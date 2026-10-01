<?php

namespace App\Http\Controllers;

use App\Models\Erabiltzailea;
use App\Models\Ikastaroa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AdministrazioaController extends Controller
{
    public function login()
    {
        if (Auth::user()?->rola?->rola_izena === 'admin') {
            return redirect()->route(Auth::user()->rola?->rola_izena === 'admin' ? 'administrazioa' : 'home');
        }

        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $request->merge(['emaila' => mb_strtolower(trim((string) $request->input('emaila')))]);
        $data = $request->validate([
            'emaila' => ['required', 'email', 'max:255'],
            'pasahitza' => ['required', 'string', 'max:255'],
        ], [
            'emaila.required' => 'Idatzi zure helbide elektronikoa.',
            'emaila.email' => 'Idatzi baliozko helbide elektroniko bat.',
            'emaila.max' => 'Helbide elektronikoa luzeegia da.',
            'pasahitza.required' => 'Idatzi zure pasahitza.',
            'pasahitza.string' => 'Pasahitzak testua izan behar du.',
            'pasahitza.max' => 'Pasahitza luzeegia da.',
        ]);

        $key = 'admin-login:'.hash('sha256', mb_strtolower($data['emaila']).'|'.$request->ip());
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'emaila' => 'Saiakera gehiegi. Saiatu berriro '.RateLimiter::availableIn($key).' segundo barru.',
            ])->withInput($request->only('emaila'));
        }

        $credentials = [
            'emaila' => $data['emaila'],
            'password' => $data['pasahitza'],
            'aktibo' => true,
            fn ($query) => $query->whereHas('rola', fn ($role) => $role->whereIn('rola_izena', ['admin', 'ikasleak'])),
        ];

        if (! Auth::attempt($credentials)) {
            RateLimiter::hit($key, 60);

            return back()->withErrors([
                'emaila' => 'Ezin izan da saioa hasi. Egiaztatu zure emaila eta pasahitza.',
            ])->withInput($request->only('emaila'));
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        return redirect()->route(Auth::user()->rola?->rola_izena === 'admin' ? 'administrazioa' : 'home');
    }

    public function index()
    {
        $ikastaroak = Ikastaroa::with('matrikulak.erabiltzailea')->orderBy('hasiera_data')->get();
        $erabiltzaileak = Erabiltzailea::with('rola')->orderBy('id_erabiltzailea')->get();
        $students = $erabiltzaileak->filter(fn ($user) => $user->rola?->rola_izena === 'ikasleak');
        $courseStats = $ikastaroak->map(function ($course) {
            $enrolled = $course->matrikulak->where('egoera', 'aktibo')->count();
            $capacity = max(0, (int) $course->edukiera);

            return [
                'title' => $course->izenburua,
                'enrolled' => $enrolled,
                'capacity' => $capacity,
                'available' => max(0, $capacity - $enrolled),
                'percent' => $capacity > 0 ? (int) round($enrolled / $capacity * 100) : 0,
            ];
        });
        $stats = [
            'students' => $students->count(),
            'active_students' => $students->where('aktibo', true)->count(),
            'inactive_students' => $students->where('aktibo', false)->count(),
            'enrollments' => $courseStats->sum('enrolled'),
            'available' => $courseStats->sum('available'),
            'capacity' => $courseStats->sum('capacity'),
        ];

        return response()->view('administrazioa', compact('ikastaroak', 'erabiltzaileak', 'stats', 'courseStats'))
            ->header('Cache-Control', 'no-store, private');
    }

    public function destroy(Erabiltzailea $erabiltzailea)
{
    if (Auth::id() === $erabiltzailea->id_erabiltzailea) {
        return redirect()->route('administrazioa')->withErrors([
            'erabiltzailea' => 'Ezin duzu zure administratzaile kontua ezabatu.',
        ]);
    }

    $izena = $erabiltzailea->izena . ' ' . $erabiltzailea->abizenak;

    $erabiltzailea->delete();

    return redirect()
        ->route('administrazioa')
        ->with('status', $izena . ' erabiltzailea ezabatu da.');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
