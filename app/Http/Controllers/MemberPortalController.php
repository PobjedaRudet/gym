<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Obavijest;
use App\Models\PrijavaTreninga;
use App\Models\TerminTreninga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Throwable;

class MemberPortalController extends Controller
{
    public function updatePhoto(Request $request)
    {
        /** @var Member $member */
        $member = Auth::guard('member')->user();

        if (!function_exists('finfo_open') || !function_exists('finfo_buffer')) {
            Log::error('MemberPortalController::updatePhoto - fileinfo ekstenzija nije dostupna na serveru.');
            return redirect()
                ->route('member.profile')
                ->with('photo_error', 'Server nema omogućenu PHP fileinfo ekstenziju. Kontaktirajte administratora.');
        }

        $request->validate([
            'profile_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $file = $request->file('profile_image');
        $filename = 'member_' . $member->id . '_' . time() . '.jpg';
        $path = public_path('images');
        $maxFileSize = 1048576;

        // Kreiraj direktorij ako ne postoji, s eksplicitnim logom ako ne uspije
        if (!is_dir($path)) {
            if (!mkdir($path, 0755, true)) {
                Log::error('MemberPortalController::updatePhoto - ne mogu kreirati direktorij: ' . $path);
                return redirect()
                    ->route('member.profile')
                    ->with('photo_error', 'Greška: direktorij za slike nije dostupan. Kontaktirajte administratora.');
            }
        }

        // $fullPath definišemo IZVAN try bloka da bude uvijek dostupan
        $fullPath = $path . DIRECTORY_SEPARATOR . $filename;

        Log::info('MemberPortalController::updatePhoto - čuvanje slike na: ' . $fullPath);

        try {
            $img = Image::make($file->getRealPath())->orientate();
            $img->fit(600, 600, function ($constraint) {
                $constraint->upsize();
            });

            $quality = 90;
            $img->save($fullPath, $quality, 'jpg');

            // Postavi permisije 0644 da web server (Apache/Nginx) može čitati fajl
            @chmod($fullPath, 0644);

            while (file_exists($fullPath) && filesize($fullPath) > $maxFileSize && $quality > 45) {
                $quality -= 10;
                $img->save($fullPath, $quality, 'jpg');
            }

            while (file_exists($fullPath) && filesize($fullPath) > $maxFileSize && $img->width() > 220) {
                $img->resize((int) round($img->width() * 0.85), (int) round($img->height() * 0.85));
                $img->save($fullPath, $quality, 'jpg');
            }
        } catch (Throwable $e) {
            Log::error('MemberPortalController::updatePhoto - greška pri obradi slike: ' . $e->getMessage(), [
                'exception_file' => $e->getFile(),
                'line'           => $e->getLine(),
                'save_path'      => $fullPath,
            ]);
            // Obriši eventualno djelimično kreiran fajl
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
            return redirect()
                ->route('member.profile')
                ->with('photo_error', 'Greška pri obradi slike: ' . $e->getMessage());
        }

        // Provjeri da fajl stvarno postoji i ima sadržaj PRIJE ažuriranja baze
        if (!file_exists($fullPath) || filesize($fullPath) === 0) {
            Log::error('MemberPortalController::updatePhoto - fajl nije sačuvan na: ' . $fullPath);
            return redirect()
                ->route('member.profile')
                ->with('photo_error', 'Slika nije mogla biti sačuvana na serveru. Kontaktirajte administratora.');
        }

        if (filesize($fullPath) > $maxFileSize) {
            @unlink($fullPath);
            return redirect()
                ->route('member.profile')
                ->withErrors(['profile_image' => 'Slika nije mogla biti umanjena ispod 1 MB. Odaberite manju ili kompresovanu sliku.']);
        }

        $member->image_path = $filename;
        $member->save();

        Log::info('MemberPortalController::updatePhoto - uspješno sačuvano, image_path: ' . $filename);

        return redirect()->route('member.profile')->with('success', 'Profilna slika je uspješno ažurirana.');
    }

    public function profile()
    {
        /** @var Member $member */
        $member = Auth::guard('member')->user();
        $id = $member->id;
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $ukupnoDolazaka = DB::table('attendances')->where('member_id', $id)->count();

        $trenutniMjesec = DB::table('attendances')
            ->where('member_id', $id)
            ->whereYear('in', $now->year)
            ->whereMonth('in', $now->month)
            ->count();

        $prethodniMjesec = DB::table('attendances')
            ->where('member_id', $id)
            ->whereYear('in', $lastMonth->year)
            ->whereMonth('in', $lastMonth->month)
            ->count();

        $vrijemeUkupno = DB::table('attendances')
            ->where('member_id', $id)
            ->whereNotNull('out')
            ->selectRaw('COALESCE(ROUND(AVG(TIMESTAMPDIFF(MINUTE, `in`, `out`))), 0) as prosjek, COALESCE(SUM(TIMESTAMPDIFF(MINUTE, `in`, `out`)), 0) as ukupno')
            ->first();

        $vrijemeTrenutni = DB::table('attendances')
            ->where('member_id', $id)
            ->whereNotNull('out')
            ->whereYear('in', $now->year)
            ->whereMonth('in', $now->month)
            ->selectRaw('COALESCE(ROUND(AVG(TIMESTAMPDIFF(MINUTE, `in`, `out`))), 0) as prosjek, COALESCE(SUM(TIMESTAMPDIFF(MINUTE, `in`, `out`)), 0) as ukupno')
            ->first();

        $clanarina = DB::table('fees')
            ->where('member_id', $id)
            ->orderBy('end', 'desc')
            ->first();

        $istekClanarine = $clanarina ? $clanarina->end : null;
        $aktivanClan = $istekClanarine && Carbon::parse($istekClanarine)->gte($now->copy()->startOfDay());

        // Goals
        $ciljDolazaka = 20;
        $ciljMinuta = 1800; // 30h

        // Weekly attendance (Mon-Sun current week)
        $weekStart = $now->copy()->startOfWeek(Carbon::MONDAY);
        $sedmicniDani = [];
        $daniNazivi = ['P','U','S','Č','P','S','N'];
        for ($d = 0; $d < 7; $d++) {
            $dan = $weekStart->copy()->addDays($d);
            $count = DB::table('attendances')
                ->where('member_id', $id)
                ->whereDate('in', $dan->toDateString())
                ->count();
            $sedmicniDani[] = [
                'label' => $daniNazivi[$d],
                'date' => $dan->format('d'),
                'count' => $count,
                'today' => $dan->isToday(),
                'past' => $dan->lt($now->copy()->startOfDay()),
            ];
        }

        // Last 6 months mini chart data
        $mjesecniMini = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $dol = DB::table('attendances')
                ->where('member_id', $id)
                ->whereYear('in', $date->year)
                ->whereMonth('in', $date->month)
                ->count();
            $mjesecniMini[] = [
                'label' => $date->translatedFormat('M'),
                'dolasci' => $dol,
                'tekuci' => ($i === 0),
            ];
        }

        return view('member.profile', compact(
            'member', 'ukupnoDolazaka', 'trenutniMjesec', 'prethodniMjesec',
            'vrijemeUkupno', 'vrijemeTrenutni', 'istekClanarine', 'aktivanClan',
            'ciljDolazaka', 'ciljMinuta', 'sedmicniDani', 'mjesecniMini'
        ));
    }

    public function statistics()
    {
        $member = Auth::guard('member')->user();
        $id = $member->id;
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $ukupnoDolazaka = DB::table('attendances')->where('member_id', $id)->count();

        $trenutniMjesec = DB::table('attendances')
            ->where('member_id', $id)
            ->whereYear('in', $now->year)
            ->whereMonth('in', $now->month)
            ->count();

        $prethodniMjesec = DB::table('attendances')
            ->where('member_id', $id)
            ->whereYear('in', $lastMonth->year)
            ->whereMonth('in', $lastMonth->month)
            ->count();

        $vrijemeUkupno = DB::table('attendances')
            ->where('member_id', $id)
            ->whereNotNull('out')
            ->selectRaw('COALESCE(ROUND(AVG(TIMESTAMPDIFF(MINUTE, `in`, `out`))), 0) as prosjek, COALESCE(SUM(TIMESTAMPDIFF(MINUTE, `in`, `out`)), 0) as ukupno')
            ->first();

        $vrijemeTrenutni = DB::table('attendances')
            ->where('member_id', $id)
            ->whereNotNull('out')
            ->whereYear('in', $now->year)
            ->whereMonth('in', $now->month)
            ->selectRaw('COALESCE(ROUND(AVG(TIMESTAMPDIFF(MINUTE, `in`, `out`))), 0) as prosjek, COALESCE(SUM(TIMESTAMPDIFF(MINUTE, `in`, `out`)), 0) as ukupno')
            ->first();

        $vrijemeProthodni = DB::table('attendances')
            ->where('member_id', $id)
            ->whereNotNull('out')
            ->whereYear('in', $lastMonth->year)
            ->whereMonth('in', $lastMonth->month)
            ->selectRaw('COALESCE(ROUND(AVG(TIMESTAMPDIFF(MINUTE, `in`, `out`))), 0) as prosjek, COALESCE(SUM(TIMESTAMPDIFF(MINUTE, `in`, `out`)), 0) as ukupno')
            ->first();

        // Mjesecni pregled (6 mjeseci)
        $mjesecniPregled = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $dolasci = DB::table('attendances')
                ->where('member_id', $id)
                ->whereYear('in', $date->year)
                ->whereMonth('in', $date->month)
                ->count();
            $vrijeme = DB::table('attendances')
                ->where('member_id', $id)
                ->whereNotNull('out')
                ->whereYear('in', $date->year)
                ->whereMonth('in', $date->month)
                ->selectRaw('COALESCE(SUM(TIMESTAMPDIFF(MINUTE, `in`, `out`)), 0) as ukupno, COALESCE(ROUND(AVG(TIMESTAMPDIFF(MINUTE, `in`, `out`))), 0) as prosjek')
                ->first();
            $mjesecniPregled->push([
                'mjesec' => $date->translatedFormat('M Y'),
                'mjesec_kratki' => $date->translatedFormat('M'),
                'dolasci' => $dolasci,
                'ukupno_minuta' => $vrijeme->ukupno ?? 0,
                'prosjek_minuta' => $vrijeme->prosjek ?? 0,
                'tekuci' => ($i === 0),
            ]);
        }

        $ciljDolazaka = 20;
        $ciljMinuta = 1800;

        // Godisnji pregled
        $trenutnaGodina = Carbon::now()->year;
        $prethodnaGodina = $trenutnaGodina - 1;

        $godisnjiRaw = DB::table('attendances')
            ->where('member_id', $id)
            ->whereIn(DB::raw('YEAR(`in`)'), [$trenutnaGodina, $prethodnaGodina])
            ->selectRaw('YEAR(`in`) as godina, MONTH(`in`) as mjesec, COUNT(*) as dolasci, COALESCE(SUM(CASE WHEN `out` IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, `in`, `out`) ELSE 0 END), 0) as ukupno_minuta')
            ->groupBy('godina', 'mjesec')
            ->get()
            ->groupBy('godina');

        $mjesecNazivi = ['Jan','Feb','Mar','Apr','Maj','Jun','Jul','Aug','Sep','Okt','Nov','Dec'];
        $godisnjiPregled = [
            'labels' => $mjesecNazivi,
            'trenutna' => ['godina' => $trenutnaGodina, 'dolasci' => [], 'sati' => []],
            'prethodna' => ['godina' => $prethodnaGodina, 'dolasci' => [], 'sati' => []],
        ];

        for ($m = 1; $m <= 12; $m++) {
            $tData = isset($godisnjiRaw[$trenutnaGodina]) ? $godisnjiRaw[$trenutnaGodina]->firstWhere('mjesec', $m) : null;
            $pData = isset($godisnjiRaw[$prethodnaGodina]) ? $godisnjiRaw[$prethodnaGodina]->firstWhere('mjesec', $m) : null;
            $godisnjiPregled['trenutna']['dolasci'][] = $tData ? $tData->dolasci : 0;
            $godisnjiPregled['trenutna']['sati'][] = $tData ? round($tData->ukupno_minuta / 60, 1) : 0;
            $godisnjiPregled['prethodna']['dolasci'][] = $pData ? $pData->dolasci : 0;
            $godisnjiPregled['prethodna']['sati'][] = $pData ? round($pData->ukupno_minuta / 60, 1) : 0;
        }

        // Sedmicni pregled (poslednja 4 sedmice)
        $sedmicniPregled = collect();
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek(Carbon::MONDAY);
            $weekEnd = (clone $weekStart)->endOfWeek(Carbon::SUNDAY);
            $dolasci = DB::table('attendances')
                ->where('member_id', $id)
                ->whereBetween('in', [$weekStart, $weekEnd])
                ->count();
            $vrijeme = DB::table('attendances')
                ->where('member_id', $id)
                ->whereNotNull('out')
                ->whereBetween('in', [$weekStart, $weekEnd])
                ->selectRaw('COALESCE(SUM(TIMESTAMPDIFF(MINUTE, `in`, `out`)), 0) as ukupno')
                ->first();
            $sedmicniPregled->push([
                'label' => $weekStart->format('d.m') . ' - ' . $weekEnd->format('d.m'),
                'dolasci' => $dolasci,
                'minuta' => $vrijeme->ukupno ?? 0,
                'tekuca' => ($i === 0),
            ]);
        }

        // Dani u sedmici (distribucija)
        $daniDistribucija = DB::table('attendances')
            ->where('member_id', $id)
            ->selectRaw('DAYOFWEEK(`in`) as dan, COUNT(*) as broj')
            ->groupBy('dan')
            ->pluck('broj', 'dan')
            ->toArray();

        $daniNazivi = ['Ned','Pon','Uto','Sri','Čet','Pet','Sub'];
        $daniData = [];
        for ($d = 1; $d <= 7; $d++) {
            $daniData[] = $daniDistribucija[$d] ?? 0;
        }

        return view('member.statistics', compact(
            'member', 'ukupnoDolazaka', 'trenutniMjesec', 'prethodniMjesec',
            'vrijemeUkupno', 'vrijemeTrenutni', 'vrijemeProthodni',
            'mjesecniPregled', 'ciljDolazaka', 'ciljMinuta',
            'godisnjiPregled', 'sedmicniPregled', 'daniNazivi', 'daniData'
        ));
    }

    public function live()
    {
        $gymMembers = DB::table('attendances')
            ->join('members', 'attendances.member_id', '=', 'members.id')
            ->whereNull('attendances.out')
            ->where('attendances.gym', 1)
            ->select('members.name', 'members.surname', 'members.image_path', 'attendances.in')
            ->orderBy('attendances.in', 'desc')
            ->get();

        $ladiesMembers = DB::table('attendances')
            ->join('members', 'attendances.member_id', '=', 'members.id')
            ->whereNull('attendances.out')
            ->where('attendances.gym', '!=', 1)
            ->select('members.name', 'members.surname', 'members.image_path', 'attendances.in')
            ->orderBy('attendances.in', 'desc')
            ->get();

        return view('member.live', compact('gymMembers', 'ladiesMembers'));
    }

    public function obavijesti()
    {
        /** @var Member $member */
        $member = Auth::guard('member')->user();
        $member->last_seen_obavijesti = now();
        $member->save();

        $obavijesti = Obavijest::orderBy('created_at', 'desc')->paginate(10);
        return view('member.obavijesti', compact('obavijesti'));
    }

    public function termini()
    {
        /** @var Member $member */
        $member = Auth::guard('member')->user();
        $termini = TerminTreninga::withCount('prijave')
            ->orderBy('datum_od', 'desc')
            ->orderBy('vrijeme_od', 'asc')
            ->get();

        $mojePrijave = PrijavaTreninga::where('member_id', $member->id)->pluck('termin_id')->toArray();

        $member->update(['last_seen_termini' => now()]);

        return view('member.termini', compact('termini', 'mojePrijave'));
    }

    public function prijaviSe(TerminTreninga $termin)
    {
        $member = Auth::guard('member')->user();

        if ($termin->datum_od > Carbon::today()) {
            return back()->with('error', 'Ovaj termin još nije aktivan.');
        }

        $postojecaPrijava = PrijavaTreninga::where('termin_id', $termin->id)
            ->where('member_id', $member->id)
            ->first();

        if ($postojecaPrijava) {
            return back()->with('error', 'Već ste prijavljeni na ovaj termin.');
        }

        $brojPrijava = PrijavaTreninga::where('termin_id', $termin->id)->count();
        if ($brojPrijava >= $termin->max_mjesta) {
            return back()->with('error', 'Nema slobodnih mjesta za ovaj termin.');
        }

        PrijavaTreninga::create([
            'termin_id' => $termin->id,
            'member_id' => $member->id,
        ]);

        return back()->with('success', 'Uspješno ste se prijavili na trening.');
    }

    public function odjaviSe(TerminTreninga $termin)
    {
        $member = Auth::guard('member')->user();

        PrijavaTreninga::where('termin_id', $termin->id)
            ->where('member_id', $member->id)
            ->delete();

        return back()->with('success', 'Uspješno ste se odjavili sa treninga.');
    }

    // ===== ADMIN METHODS FOR NOTIFICATIONS =====
    public function createObavijest()
    {
        return view('member.obavijesti.create');
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
            'moderator_id' => Auth::guard('member')->id(),
            'naslov' => $request->naslov,
            'sadrzaj' => $request->sadrzaj,
            'slika' => $slikaPath,
            'tip' => $request->tip,
        ]);

        return redirect()->route('member.obavijesti')->with('success', 'Obavijest uspješno kreirana.');
    }

    public function editObavijest(Obavijest $obavijest)
    {
        if ($obavijest->moderator_id !== Auth::guard('member')->id()) {
            abort(403);
        }

        return view('member.obavijesti.edit', compact('obavijest'));
    }

    public function updateObavijest(Request $request, Obavijest $obavijest)
    {
        if ($obavijest->moderator_id !== Auth::guard('member')->id()) {
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

        return redirect()->route('member.obavijesti')->with('success', 'Obavijest uspješno ažurirana.');
    }

    public function deleteObavijest(Obavijest $obavijest)
    {
        if ($obavijest->moderator_id !== Auth::guard('member')->id()) {
            abort(403);
        }

        if ($obavijest->slika && file_exists(public_path('images/obavijesti/' . $obavijest->slika))) {
            unlink(public_path('images/obavijesti/' . $obavijest->slika));
        }

        $obavijest->delete();

        return redirect()->route('member.obavijesti')->with('success', 'Obavijest uspješno obrisana.');
    }

    // ===== ADMIN METHODS FOR TERMINI =====
    public function createTermin()
    {
        return view('member.termini.create');
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
            'moderator_id' => Auth::guard('member')->id(),
            'naziv' => $request->naziv,
            'opis' => $request->opis,
            'datum_od' => $request->datum_od,
            'dani' => $request->dani,
            'vrijeme_od' => $request->vrijeme_od,
            'vrijeme_do' => $request->vrijeme_do,
            'max_mjesta' => $request->max_mjesta,
        ]);

        return redirect()->route('member.termini')->with('success', 'Termin uspješno kreiran.');
    }

    public function editTermin(TerminTreninga $termin)
    {
        if ($termin->moderator_id !== Auth::guard('member')->id()) {
            abort(403);
        }

        return view('member.termini.edit', compact('termin'));
    }

    public function updateTermin(Request $request, TerminTreninga $termin)
    {
        if ($termin->moderator_id !== Auth::guard('member')->id()) {
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

        return redirect()->route('member.termini')->with('success', 'Termin uspješno ažuriran.');
    }

    public function deleteTermin(TerminTreninga $termin)
    {
        if ($termin->moderator_id !== Auth::guard('member')->id()) {
            abort(403);
        }

        $termin->delete();

        return redirect()->route('member.termini')->with('success', 'Termin uspješno obrisan.');
    }
}
