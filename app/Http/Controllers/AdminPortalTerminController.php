<?php

namespace App\Http\Controllers;

use App\Models\Moderator;
use App\Models\TerminTreninga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminPortalTerminController extends Controller
{
    public function index()
    {
        $this->authorizeAdminEmail();

        $termini = TerminTreninga::withCount('prijave')
            ->orderBy('datum_od', 'desc')
            ->orderBy('vrijeme_od', 'asc')
            ->paginate(12);

        return view('admin.portal-termini', compact('termini'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdminEmail();

        $validated = $request->validate([
            'naziv' => ['required', 'string', 'max:255'],
            'opis' => ['nullable', 'string'],
            'datum_od' => ['required', 'date', 'after_or_equal:today'],
            'dani' => ['required', 'array', 'min:1'],
            'dani.*' => ['integer', 'between:1,7'],
            'vrijeme_od' => ['required'],
            'vrijeme_do' => ['required', 'after:vrijeme_od'],
            'max_mjesta' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $moderator = $this->resolveModeratorForCurrentAdmin();

        TerminTreninga::create([
            'moderator_id' => $moderator->id,
            'naziv' => $validated['naziv'],
            'opis' => $validated['opis'] ?? null,
            'datum_od' => $validated['datum_od'],
            'dani' => $validated['dani'],
            'vrijeme_od' => $validated['vrijeme_od'],
            'vrijeme_do' => $validated['vrijeme_do'],
            'max_mjesta' => $validated['max_mjesta'],
        ]);

        return redirect()
            ->route('admin.portal.termini')
            ->with('success', 'Termin treninga je uspjesno objavljen na portalu.');
    }

    public function edit(TerminTreninga $termin)
    {
        $this->authorizeAdminEmail();

        return view('admin.portal-termini-edit', compact('termin'));
    }

    public function update(Request $request, TerminTreninga $termin)
    {
        $this->authorizeAdminEmail();

        $validated = $request->validate([
            'naziv' => ['required', 'string', 'max:255'],
            'opis' => ['nullable', 'string'],
            'datum_od' => ['required', 'date'],
            'dani' => ['required', 'array', 'min:1'],
            'dani.*' => ['integer', 'between:1,7'],
            'vrijeme_od' => ['required'],
            'vrijeme_do' => ['required', 'after:vrijeme_od'],
            'max_mjesta' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $termin->update([
            'naziv' => $validated['naziv'],
            'opis' => $validated['opis'] ?? null,
            'datum_od' => $validated['datum_od'],
            'dani' => $validated['dani'],
            'vrijeme_od' => $validated['vrijeme_od'],
            'vrijeme_do' => $validated['vrijeme_do'],
            'max_mjesta' => $validated['max_mjesta'],
        ]);

        return redirect()
            ->route('admin.portal.termini')
            ->with('success', 'Termin treninga je uspjesno azuriran.');
    }

    public function destroy(TerminTreninga $termin)
    {
        $this->authorizeAdminEmail();

        $termin->delete();

        return redirect()
            ->route('admin.portal.termini')
            ->with('success', 'Termin treninga je uspjesno obrisan.');
    }

    private function authorizeAdminEmail(): void
    {
        if (!Auth::check() || Auth::user()->email !== 'admin@begsfit.ba') {
            abort(403);
        }
    }

    private function resolveModeratorForCurrentAdmin(): Moderator
    {
        $user = Auth::user();

        return Moderator::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'password' => Hash::make(Str::random(24)),
            ]
        );
    }
}
