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

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->rola?->rola_izena === 'admin' ? 'administrazioa' : 'home');
        }

        return view('erregistratu');
    }

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

        // Only claim an existing, unregistered student; never replace a password.
        $updated = Erabiltzailea::where('emaila', $data['emaila'])
            ->whereHas('rola', fn ($query) => $query->where('rola_izena', 'ikasleak'))
            ->whereNull('pasahitza')
            ->update(['pasahitza' => Hash::make($data['pasahitza']), 'aktibo' => true]);

        if (! $updated) {
            return back()->withErrors([
                'emaila' => 'Ezin da erregistroa osatu. Administratzaileak aurrez ikasle gisa gehitu behar zaitu, eta ezin duzu dagoeneko erregistratuta egon.',
            ])->withInput($request->only('emaila'));
        }

        return redirect()->route('login')->with('status', 'Erregistroa ondo osatu da. Orain saioa has dezakezu.');
    }

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

    public function enroll(Request $request, Ikastaroa $ikastaroa)
    {
        $student = $request->user();
        if ($student->rola?->rola_izena !== 'ikasleak' || ! $student->aktibo) {
            return redirect()->route('home')->withErrors(['matrikula' => 'Ikasle aktiboek bakarrik egin dezakete matrikula.']);
        }

        $message = DB::transaction(function () use ($student, $ikastaroa) {
            // Acquire SQLite's write lock before checking the remaining places.
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
