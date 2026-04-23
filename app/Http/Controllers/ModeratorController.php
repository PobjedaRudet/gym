<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Obavijest;
use App\Models\PrijavaTreninga;
use App\Models\TerminTreninga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeratorController extends Controller
{
    // ===== DASHBOARD =====
    public function dashboard()
    {
        $moderator = Auth::guard('moderator')->user();
        $obavijestiCount = Obavijest::where('moderator_id', $moderator->id)->count();
        $terminiCount = TerminTreninga::where('moderator_id', $moderator->id)->where('datum_od', '<=', Carbon::today())->count();
        $clanovaCount = Member::whereNotNull('password')->where('password', '!=', '')->count();

        return view('moderator.dashboard', compact('moderator', 'obavijestiCount', 'terminiCount', 'clanovaCount'));
    }

    // ===== OBAVIJESTI =====
    public function obavijesti()
    {
        $obavijesti = Obavijest::where('moderator_id', Auth::guard('moderator')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('moderator.obavijesti.index', compact('obavijesti'));
    }

    public function createObavijest()
    {
        return view('moderator.obavijesti.create');
    }

    public function storeObavijest(Request $request)
    {
        $request->validate([
            'naslov' => 'required|string|max:255',
            'sadrzaj' => 'required|string',
            'tip' => 'required|in:info,vazno,upozorenje',
            'slika' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $slikaPath = null;
        if ($request->hasFile('slika')) {
            $file = $request->file('slika');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/obavijesti'), $filename);
            $slikaPath = $filename;
        }

        Obavijest::create([
            'moderator_id' => Auth::guard('moderator')->id(),
            'naslov' => $request->naslov,
            'sadrzaj' => $request->sadrzaj,
            'slika' => $slikaPath,
            'tip' => $request->tip,
        ]);

        return redirect()->route('moderator.obavijesti')->with('success', 'Obavijest uspješno kreirana.');
    }

    public function editObavijest(Obavijest $obavijest)
    {
        if ($obavijest->moderator_id !== Auth::guard('moderator')->id()) {
            abort(403);
        }

        return view('moderator.obavijesti.edit', compact('obavijest'));
    }

    public function updateObavijest(Request $request, Obavijest $obavijest)
    {
        if ($obavijest->moderator_id !== Auth::guard('moderator')->id()) {
            abort(403);
        }

        $request->validate([
            'naslov' => 'required|string|max:255',
            'sadrzaj' => 'required|string',
            'tip' => 'required|in:info,vazno,upozorenje',
            'slika' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = $request->only('naslov', 'sadrzaj', 'tip');

        if ($request->hasFile('slika')) {
            if ($obavijest->slika && file_exists(public_path('images/obavijesti/' . $obavijest->slika))) {
                unlink(public_path('images/obavijesti/' . $obavijest->slika));
            }
            $file = $request->file('slika');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/obavijesti'), $filename);
            $data['slika'] = $filename;
        }

        if ($request->has('ukloni_sliku') && !$request->hasFile('slika')) {
            if ($obavijest->slika && file_exists(public_path('images/obavijesti/' . $obavijest->slika))) {
                unlink(public_path('images/obavijesti/' . $obavijest->slika));
            }
            $data['slika'] = null;
        }

        $obavijest->update($data);

        return redirect()->route('moderator.obavijesti')->with('success', 'Obavijest uspješno ažurirana.');
    }

    public function deleteObavijest(Obavijest $obavijest)
    {
        if ($obavijest->moderator_id !== Auth::guard('moderator')->id()) {
            abort(403);
        }

        if ($obavijest->slika && file_exists(public_path('images/obavijesti/' . $obavijest->slika))) {
            unlink(public_path('images/obavijesti/' . $obavijest->slika));
        }

        $obavijest->delete();

        return redirect()->route('moderator.obavijesti')->with('success', 'Obavijest uspješno obrisana.');
    }

    // ===== TERMINI TRENINGA =====
    public function termini()
    {
        $termini = TerminTreninga::where('moderator_id', Auth::guard('moderator')->id())
            ->withCount('prijave')
            ->orderBy('datum_od', 'desc')
            ->paginate(10);

        return view('moderator.termini.index', compact('termini'));
    }

    public function createTermin()
    {
        return view('moderator.termini.create');
    }

    public function storeTermin(Request $request)
    {
        $request->validate([
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'datum_od' => 'required|date|after_or_equal:today',
            'dani' => 'required|array|min:1',
            'dani.*' => 'integer|between:1,7',
            'vrijeme_od' => 'required',
            'vrijeme_do' => 'required|after:vrijeme_od',
            'max_mjesta' => 'required|integer|min:1|max:100',
        ]);

        TerminTreninga::create([
            'moderator_id' => Auth::guard('moderator')->id(),
            'naziv' => $request->naziv,
            'opis' => $request->opis,
            'datum_od' => $request->datum_od,
            'dani' => $request->dani,
            'vrijeme_od' => $request->vrijeme_od,
            'vrijeme_do' => $request->vrijeme_do,
            'max_mjesta' => $request->max_mjesta,
        ]);

        return redirect()->route('moderator.termini')->with('success', 'Termin uspješno kreiran.');
    }

    public function editTermin(TerminTreninga $termin)
    {
        if ($termin->moderator_id !== Auth::guard('moderator')->id()) {
            abort(403);
        }

        return view('moderator.termini.edit', compact('termin'));
    }

    public function updateTermin(Request $request, TerminTreninga $termin)
    {
        if ($termin->moderator_id !== Auth::guard('moderator')->id()) {
            abort(403);
        }

        $request->validate([
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'datum_od' => 'required|date',
            'dani' => 'required|array|min:1',
            'dani.*' => 'integer|between:1,7',
            'vrijeme_od' => 'required',
            'vrijeme_do' => 'required|after:vrijeme_od',
            'max_mjesta' => 'required|integer|min:1|max:100',
        ]);

        $termin->update([
            'naziv' => $request->naziv,
            'opis' => $request->opis,
            'datum_od' => $request->datum_od,
            'dani' => $request->dani,
            'vrijeme_od' => $request->vrijeme_od,
            'vrijeme_do' => $request->vrijeme_do,
            'max_mjesta' => $request->max_mjesta,
        ]);

        return redirect()->route('moderator.termini')->with('success', 'Termin uspješno ažuriran.');
    }

    public function deleteTermin(TerminTreninga $termin)
    {
        if ($termin->moderator_id !== Auth::guard('moderator')->id()) {
            abort(403);
        }

        $termin->delete();

        return redirect()->route('moderator.termini')->with('success', 'Termin uspješno obrisan.');
    }

    public function terminPrijave(TerminTreninga $termin)
    {
        if ($termin->moderator_id !== Auth::guard('moderator')->id()) {
            abort(403);
        }

        $termin->load('prijavljeniClanovi');

        return view('moderator.termini.prijave', compact('termin'));
    }
}
