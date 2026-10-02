<?php

namespace App\Http\Controllers;

use App\Models\Erabiltzailea;
use App\Models\Ikastaroa;
use App\Models\Matrikula;
use App\Models\Rola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class IkastaroController extends Controller
{
    /**
     * Lista los cursos por fecha y cuenta sus matrículas activas.
     * Incluye el estado de las matrículas del usuario y, para administradores, los alumnos de cada curso.
     */
    public function index()
    {
        return response()->view('index', [
            'ikastaroak' => Ikastaroa::withCount(['matrikulak' => fn ($query) => $query->where('egoera', 'aktibo')])
                ->when(Auth::user()?->rola?->rola_izena === 'admin', fn ($query) => $query->with('matrikulak.erabiltzailea'))
                ->orderBy('hasiera_data')->get(),
            'matrikulatuta' => Auth::check()
                ? Matrikula::where('id_erabiltzailea', Auth::id())->pluck('egoera', 'id_ikastaroa')->all()
                : [],
        ])->header('Cache-Control', 'no-store, private');
    }

    /**
     * Muestra el formulario con un curso vacío para introducir los datos de un nuevo curso.
     */
    public function create()
    {
        return view('ikastaro-form', ['ikastaroa' => new Ikastaroa]);
    }

    /**
     * Muestra el formulario con los datos del curso que se va a modificar.
     */
    public function edit(Ikastaroa $ikastaroa)
    {
        return view('ikastaro-form', compact('ikastaroa'));
    }

    /**
     * Valida los datos del formulario, crea el curso y vuelve al listado con un mensaje.
     */
    public function store(Request $request)
    {
        Ikastaroa::create($this->validateCourse($request));

        return redirect()->route('home')->with('status', 'Ikastaroa sortu da.');
    }

    /**
     * Valida y actualiza el curso dentro de una transacción.
     * Bloquea la escritura antes de comprobar que la capacidad cubre las matrículas activas.
     */
    public function update(Request $request, Ikastaroa $ikastaroa)
    {
        $data = $this->validateCourse($request);
        DB::transaction(function () use ($data, $ikastaroa) {
            DB::table('ikastaroak')->where('id_ikastaroa', $ikastaroa->id_ikastaroa)
                ->update(['edukiera' => DB::raw('edukiera')]);
            $course = Ikastaroa::whereKey($ikastaroa->id_ikastaroa)->lockForUpdate()->firstOrFail();
            if ($data['edukiera'] < $course->matrikulak()->where('egoera', 'aktibo')->count()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'edukiera' => 'Edukiera ezin da matrikula aktiboen kopurua baino txikiagoa izan.',
                ]);
            }
            $course->update($data);
        });

        return redirect()->route('home')->with('status', 'Ikastaroa eguneratu da.');
    }

    /**
     * Elimina las matrículas y el curso en una transacción, de modo que ambas operaciones se completen juntas.
     */
    public function destroy(Ikastaroa $ikastaroa)
    {
        DB::transaction(function () use ($ikastaroa) {
            $ikastaroa->matrikulak()->delete();
            $ikastaroa->delete();
        });

        return redirect()->route('home')->with('status', 'Ikastaroa eta bere matrikulak ezabatu dira.');
    }

    /**
     * Devuelve los datos validados del curso o genera errores de validación.
     * Comprueba los textos, la capacidad entre 1 y 30 y que la fecha final no preceda a la inicial.
     */
    private function validateCourse(Request $request): array
    {
        return $request->validate([
            'izenburua' => ['required', 'string', 'max:255'],
            'deskribapena' => ['nullable', 'string', 'max:10000'],
            'edukiera' => ['required', 'integer', 'min:1', 'max:'.Ikastaroa::MAX_CAPACITY],
            'hasiera_data' => ['required', 'date_format:Y-m-d'],
            'amaiera_data' => ['required', 'date_format:Y-m-d', 'after_or_equal:hasiera_data'],
        ], [
            'required' => ':attribute eremua bete behar da.',
            'string' => ':attribute eremuak testua izan behar du.',
            'izenburua.max' => 'Izenburuak gehienez 255 karaktere izan ditzake.',
            'deskribapena.max' => 'Deskribapena luzeegia da.',
            'edukiera.integer' => 'Plaza kopuruak zenbaki osoa izan behar du.',
            'edukiera.min' => 'Gutxienez plaza bat egon behar da.',
            'edukiera.max' => 'Gehienez '.Ikastaroa::MAX_CAPACITY.' plaza egon daitezke.',
            'date_format' => ':attribute eremuak baliozko data izan behar du.',
            'amaiera_data.after_or_equal' => 'Amaiera-data ezin da hasiera-data baino lehenagokoa izan.',
        ], [
            'izenburua' => 'Izenburua', 'deskribapena' => 'Deskribapena',
            'edukiera' => 'Plaza kopurua', 'hasiera_data' => 'Hasiera-data', 'amaiera_data' => 'Amaiera-data',
        ]);
    }

    /**
     * Muestra el formulario de registro; si ya hay sesión, redirige según el rol del usuario.
     */
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->rola?->rola_izena === 'admin' ? 'administrazioa' : 'home');
        }

        return view('erregistratu');
    }

    /**
     * Permite establecer una contraseña a un alumno previamente creado por el administrador.
     * Valida la confirmación, limita los intentos por IP y activa solo cuentas que aún no tienen contraseña.
     */
    public function storeRegistration(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        $request->merge(['emaila' => mb_strtolower(trim((string) $request->input('emaila')))]);
        $data = $request->validate([
            'emaila' => ['required', 'email', 'max:255'],
            'pasahitza' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ], [
            'emaila.required' => 'Idatzi zure helbide elektronikoa.',
            'emaila.email' => 'Idatzi baliozko helbide elektroniko bat.',
            'emaila.max' => 'Helbide elektronikoa luzeegia da.',
            'pasahitza.required' => 'Idatzi zure pasahitza.',
            'pasahitza.string' => 'Pasahitzak testua izan behar du.',
            'pasahitza.min' => 'Pasahitzak gutxienez 8 karaktere izan behar ditu.',
            'pasahitza.max' => 'Pasahitza luzeegia da.',
            'pasahitza.confirmed' => 'Pasahitzak ez datoz bat.',
        ]);

        $key = 'registration:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            return back()->withErrors(['emaila' => 'Saiakera gehiegi. Saiatu berriro minutu bat barru.'])
                ->withInput($request->only('emaila'));
        }
        RateLimiter::hit($key, 60);

        // Activa únicamente un alumno existente sin contraseña, sin sobrescribir una cuenta registrada.
        $updated = Erabiltzailea::where('emaila', $data['emaila'])
            ->whereHas('rola', fn ($query) => $query->where('rola_izena', 'ikasleak'))
            ->whereNull('pasahitza')
            ->update(['pasahitza' => Hash::make($data['pasahitza']), 'aktibo' => true]);

        if (! $updated) {
            $alreadyRegistered = Erabiltzailea::where('emaila', $data['emaila'])
                ->whereHas('rola', fn ($query) => $query->where('rola_izena', 'ikasleak'))
                ->whereNotNull('pasahitza')->exists();

            return back()->withErrors([
                'emaila' => $alreadyRegistered
                    ? 'Kontu hau dagoeneko erregistratuta dago. Joan Saioa hasi atalera eta erabili erregistratzean aukeratu zenuen pasahitza.'
                    : 'Ezin da erregistroa osatu. Administratzaileak aurrez ikasle gisa gehitu behar zaitu. Egiaztatu emandako emaila.',
            ])->withInput($request->only('emaila'));
        }

        return redirect()->route('login')->with('status', 'Erregistroa ondo osatu da. Orain saioa has dezakezu.');
    }

    /**
     * Valida los datos y crea un alumno inactivo, sin contraseña y con el rol de alumno.
     * Devuelve su identificador al panel para que después pueda completar el registro.
     */
    public function storeStudent(Request $request)
    {
        $request->merge(['emaila' => mb_strtolower(trim((string) $request->input('emaila')))]);
        $data = $request->validate([
            'izena' => ['required', 'string', 'max:255'],
            'abizenak' => ['required', 'string', 'max:255'],
            'emaila' => ['required', 'email', 'max:255', 'unique:erabiltzaileak,emaila'],
        ], [
            'required' => ':attribute eremua bete behar da.',
            'string' => ':attribute eremuak testua izan behar du.',
            'max' => ':attribute eremua luzeegia da.',
            'emaila.email' => 'Idatzi baliozko helbide elektroniko bat.',
            'emaila.unique' => 'Helbide elektroniko hori dagoeneko erregistratuta dago.',
        ], ['izena' => 'Izena', 'abizenak' => 'Abizenak', 'emaila' => 'Helbide elektronikoa']);

        $role = Rola::firstOrCreate(['rola_izena' => 'ikasleak'], ['deskribapena' => 'Ikasleak']);
        $student = Erabiltzailea::create([
            ...$data, 'id_rola' => $role->id_rola, 'pasahitza' => null, 'aktibo' => false,
        ]);

        return redirect()->route('administrazioa')
            ->with('created_student_id', $student->id_erabiltzailea)
            ->with('status', 'Ikaslea gehitu da. Orain bere emailarekin erregistra daiteke.');
    }

    /**
     * Matricula al alumno activo si no tiene una matrícula previa y quedan plazas.
     * Comprueba los requisitos dentro de una transacción con bloqueo de escritura para evitar superar el aforo.
     */
    public function enroll(Request $request, Ikastaroa $ikastaroa)
    {
        $student = $request->user();
        if ($student->rola?->rola_izena !== 'ikasleak' || ! $student->aktibo) {
            return redirect()->route('home')->withErrors(['matrikula' => 'Ikasle aktiboek bakarrik egin dezakete matrikula.']);
        }

        $message = DB::transaction(function () use ($student, $ikastaroa) {
            // Esta escritura sin cambio de valor obtiene el bloqueo de SQLite antes de comprobar las plazas.
            DB::table('ikastaroak')->where('id_ikastaroa', $ikastaroa->id_ikastaroa)
                ->update(['edukiera' => DB::raw('edukiera')]);

            $existing = Matrikula::where('id_erabiltzailea', $student->id_erabiltzailea)
                ->where('id_ikastaroa', $ikastaroa->id_ikastaroa)->first();
            if ($existing) {
                return $existing->egoera === 'aktibo'
                    ? 'Dagoeneko matrikulatuta zaude ikastaro honetan.'
                    : 'Zure matrikula ez dago aktibo. Jarri harremanetan administratzailearekin.';
            }
            $ikastaroa->refresh();
            if ($ikastaroa->matrikulak()->where('egoera', 'aktibo')->count() >= $ikastaroa->edukiera) {
                return 'Ez dago plaza librerik ikastaro honetan.';
            }
            Matrikula::create([
                'id_erabiltzailea' => $student->id_erabiltzailea,
                'id_ikastaroa' => $ikastaroa->id_ikastaroa,
                'matrikula_data' => now()->toDateString(),
                'egoera' => 'aktibo',
            ]);

            return null;
        });

        return $message
            ? redirect()->route('home')->withErrors(['matrikula' => $message])
            : redirect()->route('home')->with('status', 'Matrikula ondo egin da.');
    }
}
