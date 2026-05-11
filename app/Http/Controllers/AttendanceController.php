<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $att = Member::select("*")
            ->join("attendances", "attendances.member_id", "=", "members.id")
            ->orderBy('attendances.id', 'DESC')
            ->paginate(15);

        Log::info($att);
        return view('attendance-list', ['att' => $att]);
    }

    public function odjaviNeaktivne()
    {
	$attendances = Attendance::whereNull('out')
            ->where('status', 1)
            ->get();

        foreach ($attendances as $attendance) {
            $timeLoggedIn = Carbon::parse($attendance->in)->diffInHours(Carbon::now());

            if ($timeLoggedIn >= 3) {
                $attendance->out = Carbon::now();
                $attendance->status = 0;
                $attendance->save();
                // You can perform additional actions here, like sending notifications, etc.
            }
        }

	return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttendanceRequest  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
    public function live(){

      $prisutni = Member::join('attendances', 'attendances.member_id', '=', 'members.id')
        ->select('members.name','members.surname','members.image_path' , 'attendances.in','attendances.id' )
        ->where('attendances.out', NULL)
        ->orderBy('attendances.id','DESC')
        ->get();
Log::info($prisutni);
        return view('attendance-live', ['prisutni' => $prisutni]);

    }

    public function live2(){

        $prisutni = Member::join('attendances', 'attendances.member_id', '=', 'members.id')
        ->select('members.id as ids','members.name','members.surname','members.image_path' , 'attendances.in','attendances.id','attendances.gym')
        ->where('attendances.out', NULL)
        ->orderBy('attendances.id','DESC')

        ->get();
        $json = json_encode(['response' => $prisutni],true);
        echo $json;

    }
    public function odjava($id){

        $odjava = Member::join('attendances', 'attendances.member_id', '=', 'members.id')

        ->where('attendances.id', $id)
        ->update([
            'out' => Carbon::now(),
            'attendances.status' => '0',

        ]);

        return redirect('attendance-list');


    }
    public function odjavalive($id){

        $odjava = Member::join('attendances', 'attendances.member_id', '=', 'members.id')

        ->where('attendances.id', $id)
        ->update([
            'out' => Carbon::now(),
            'attendances.status' => '0',

        ]);

        return redirect('attendance-live');


    }
    public function logoutAll(Request $request){

        Log::info($request);
        $neodjavljeni = Attendance::where('status', 1)
        ->update([
            'out' => Carbon::now(),
            'status' => '0'

        ]);

        $json = json_encode(['response' => 'Povratak otpisanih'], true);   // Ulaz
        echo $json;

    }

    public function report(){

        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // Ukupno članova (svi članovi) i ukupni iznos svih članarina
        $ukupno = Member::select(
            DB::raw('count(distinct members.id) as ukupniBroj'),
            DB::raw('COALESCE(sum(fees.amount), 0) as Iznos')
        )
        ->leftJoin("fees", "fees.member_id", "=", "members.id")
        ->get();

        // Aktivni članovi = unique članovi koji su uplatili članarinu u tekućem mjesecu
        $aktivni = DB::table('fees')
            ->selectRaw('COUNT(DISTINCT fees.member_id) as Aktivni, COALESCE(SUM(fees.amount), 0) as Iznos')
            ->whereYear('fees.start', $now->year)
            ->whereMonth('fees.start', $now->month)
            ->get();

        // Neaktivni članovi = ukupno članova - članovi sa uplatom u tekućem mjesecu
        $ukupnoBroj = (int) ($ukupno->first()->ukupniBroj ?? 0);
        $aktivniBroj = (int) ($aktivni->first()->Aktivni ?? 0);
        $ne = collect([(object) [
            'N' => max($ukupnoBroj - $aktivniBroj, 0),
        ]]);

        // Prošli mjesec - unique članovi sa uplatom u prošlom mjesecu
        $prosli_mjesec = DB::table('fees')
            ->selectRaw('COUNT(DISTINCT fees.member_id) as NP')
            ->whereYear('fees.start', $lastMonth->year)
            ->whereMonth('fees.start', $lastMonth->month)
            ->get();

        $prosli_mjesec_iznos = DB::table('fees')
            ->selectRaw('COALESCE(SUM(fees.amount), 0) as IznosP')
            ->whereYear('fees.start', $lastMonth->year)
            ->whereMonth('fees.start', $lastMonth->month)
            ->get();

        // Odabrana godina za grafikon (default: trenutna)
        $selectedYear = request('year', Carbon::now()->year);

        // Dostupne godine iz uplata članarina
        $dostupneGodine = DB::table('fees')
            ->selectRaw('DISTINCT YEAR(fees.start) as godina')
            ->orderBy('godina', 'desc')
            ->pluck('godina')
            ->unique()
            ->sort()
            ->values();

        // Mjesečni pregled aktivnih članova za odabranu godinu (uplata u tom mjesecu)
        $feesAll = DB::table('fees')
            ->selectRaw('MONTH(fees.start) as mj, COUNT(DISTINCT fees.member_id) as broj')
            ->whereYear('fees.start', $selectedYear)
            ->groupByRaw('MONTH(fees.start)')
            ->get()
            ->keyBy('mj');

        $mjesecni = collect();
        for ($m = 1; $m <= 12; $m++) {
            $date = Carbon::createFromDate($selectedYear, $m, 1);
            $cnt = (int) ($feesAll->get($m)->broj ?? 0);
            $mjesecni->push([
                'mjesec' => $date->translatedFormat('M'),
                'broj' => $cnt,
            ]);
        }

        return view('report', ['aktivni' => $aktivni, 'ukupno' => $ukupno, 'ne' => $ne, 'prosli_mjesec'=>$prosli_mjesec, 'prosli_mjesec_iznos'=> $prosli_mjesec_iznos, 'mjesecni' => $mjesecni, 'selectedYear' => $selectedYear, 'dostupneGodine' => $dostupneGodine]);
    }

    public function comparison()
    {
        // Dostupne godine iz dolazaka i uplata članarina
        $godineDolasci = DB::table('attendances')
            ->selectRaw('DISTINCT YEAR(`in`) as godina')
            ->pluck('godina');

        $godineUplate = DB::table('fees')
            ->selectRaw('DISTINCT YEAR(fees.start) as godina')
            ->pluck('godina');

        $dostupneGodine = $godineDolasci
            ->merge($godineUplate)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $mjesecnaImena = ['Jan','Feb','Mar','Apr','Maj','Jun','Jul','Aug','Sep','Okt','Nov','Dec'];

        // 1 upit: svi dolasci i vrijeme grupirani po godini i mjesecu
        $raw = DB::table('attendances')
            ->selectRaw('YEAR(`in`) as god, MONTH(`in`) as mj, COUNT(*) as dolasci,
                COALESCE(SUM(CASE WHEN `out` IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, `in`, `out`) ELSE 0 END), 0) as ukupno_min,
                COALESCE(ROUND(AVG(CASE WHEN `out` IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, `in`, `out`) ELSE NULL END)), 0) as prosjek_min')
            ->groupByRaw('YEAR(`in`), MONTH(`in`)')
            ->get()
            ->groupBy('god');

        $dolasciPoGodinama = [];
        $vrijemePoGodinama = [];
        $prosjekPoGodinama = [];

        foreach ($dostupneGodine as $godina) {
            $godData = isset($raw[$godina]) ? $raw[$godina]->keyBy('mj') : collect();
            $dolasciMjeseci = [];
            $vrijemeMjeseci = [];
            $prosjekMjeseci = [];
            for ($m = 1; $m <= 12; $m++) {
                $row = $godData->get($m);
                $dolasciMjeseci[] = $row ? $row->dolasci : 0;
                $vrijemeMjeseci[] = $row ? round($row->ukupno_min / 60, 1) : 0;
                $prosjekMjeseci[] = $row ? $row->prosjek_min : 0;
            }
            $dolasciPoGodinama[$godina] = $dolasciMjeseci;
            $vrijemePoGodinama[$godina] = $vrijemeMjeseci;
            $prosjekPoGodinama[$godina] = $prosjekMjeseci;
        }

        // 1 upit: godišnji totali
        $totaliRaw = DB::table('attendances')
            ->selectRaw('YEAR(`in`) as god, COUNT(*) as dolasci,
                COALESCE(SUM(CASE WHEN `out` IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, `in`, `out`) ELSE 0 END), 0) as ukupno_min,
                COALESCE(ROUND(AVG(CASE WHEN `out` IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, `in`, `out`) ELSE NULL END)), 0) as prosjek_min,
                COUNT(DISTINCT member_id) as clanova')
            ->groupByRaw('YEAR(`in`)')
            ->get()
            ->keyBy('god');

        $godisnjeTotali = [];
        foreach ($dostupneGodine as $godina) {
            $t = $totaliRaw->get($godina);
            $godisnjeTotali[$godina] = [
                'dolasci' => $t ? $t->dolasci : 0,
                'sati' => $t ? round($t->ukupno_min / 60, 1) : 0,
                'prosjek_min' => $t ? $t->prosjek_min : 0,
                'clanova' => $t ? $t->clanova : 0,
            ];
        }

        // 1 upit: aktivni članovi po mjesecu = unique uplate u tom mjesecu
        $feesRaw = DB::table('fees')
            ->selectRaw('YEAR(fees.start) as god, MONTH(fees.start) as mj, COUNT(DISTINCT fees.member_id) as aktivni')
            ->groupByRaw('YEAR(fees.start), MONTH(fees.start)')
            ->orderBy('god')
            ->orderBy('mj')
            ->get();
        $feesByYear = $feesRaw->groupBy('god');

        $aktivniPoGodinama = [];
        foreach ($dostupneGodine as $godina) {
            $godFees = isset($feesByYear[$godina]) ? $feesByYear[$godina]->keyBy('mj') : collect();
            $aktivniMjeseci = [];
            for ($m = 1; $m <= 12; $m++) {
                $cnt = (int) ($godFees->get($m)->aktivni ?? 0);
                $aktivniMjeseci[] = $cnt;
            }
            $aktivniPoGodinama[$godina] = $aktivniMjeseci;
        }

        return view('comparison', [
            'dostupneGodine' => $dostupneGodine,
            'mjesecnaImena' => $mjesecnaImena,
            'dolasciPoGodinama' => $dolasciPoGodinama,
            'vrijemePoGodinama' => $vrijemePoGodinama,
            'prosjekPoGodinama' => $prosjekPoGodinama,
            'godisnjeTotali' => $godisnjeTotali,
            'aktivniPoGodinama' => $aktivniPoGodinama,
        ]);
    }

    public function store2(Request $request)
    {
        $data = $request->input('postObj');
        $sifra = $data['id'];

        // Ovdje ubaci logiku za pronalaženje korisnika
        // Recimo da tražiš korisnika po šifri

        // Lažni primjer - zamijeni sa stvarnom logikom
        if ($sifra === "0003800199") {
            return response()->json([
                "id" => 0, // 0 = prijava, 1 = odjava
                "response" => [[
                    "name" => "Ahmet",
                    "surname" => "Hadziahmetovic",
                    "image_path" => "ahmet.jpg",
                    "end" => "2025-12-31"
                ]],
                "rok" => "2025-12-31"
            ]);
        } elseif ($sifra === "54321") {
            return response()->json([
                "id" => 1,
                "response" => [[
                    "name" => "Elma",
                    "surname" => "Test",
                    "image_path" => "elma.jpg",
                    "end" => "2025-12-31"
                ]],
                "rok" => "2025-12-31"
            ]);
        } else {
            return response()->json([
                "id" => 2,
                "response" => [],
            ]);
        }
    }
}
