<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Throwable;

class MemberController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('createMember');
    }

    public function members()
    {
       // $stanje = Member::paginate(10);
        $stanje = Member::paginate(25);
        Log::info($stanje);
        return view('members',  ['stanje' => $stanje]);
    }

    public function test2()
    {
       // $stanje = Member::paginate(10);
        $stanje = Member::paginate(20);

        return $stanje->toJson();
    }

    public function updateMember(Request $request)
    {

        // dd($request->all());
        Log::info($request->id);

        if ($request->hasFile('image')) {
            Log::info('Ima slika');
            Log::info($request);
            if (!function_exists('finfo_open') || !function_exists('finfo_buffer')) {
                Log::error('MemberController::updateMember - fileinfo ekstenzija nije dostupna na serveru.');
                return redirect()->back()->withInput()->with('error', 'Server nema omogućenu PHP fileinfo ekstenziju. Kontaktirajte administratora.');
            }

            if($request->status == NULL){
                $status = 'off';
                 }else{
                    $status = 'on';
                 }
            $file = $request->image;
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $path = public_path() . '/images/';

            try {
                $img = Image::make($file->getRealPath());
                $quality = 90;
                $img->save($path . $filename, $quality);

                while (filesize($path . $filename) > 1048576 && $quality > 10) {
                    $quality -= 10;
                    $img->save($path . $filename, $quality);
                }

                if (filesize($path . $filename) > 1048576) {
                    $img->resize($img->width() / 2, $img->height() / 2);
                    $img->save($path . $filename, $quality);
                }
            } catch (Throwable $e) {
                Log::error('MemberController::updateMember - greška pri obradi slike: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
                return redirect()->back()->withInput()->with('error', 'Greška pri obradi slike: ' . $e->getMessage());
            }

            Member::where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'code' => $request->code,
                    'email' => $request->email,
                    'jmbg' => $request->jmbg,
                    'register_date' => $request->register_date,
                    'image_path' => $filename,
                    'mobile' => $request->mobile,
                    'status' => $status,
                    'street' => $request->street,
                    'post_no' => $request->post_no,
                    'city' => $request->city,
                ]);

            return redirect('members');
        } else {
            Log::info('Nema slika');
            if($request->status == NULL){
                $status = 'off';
            }else{
                $status = 'on';
             }
            Member::where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'code' => $request->code,
                    'email' => $request->email,
                    'jmbg' => $request->jmbg,
                    'register_date' => $request->register_date,
                    'street' => $request->street,
                    'post_no' => $request->post_no,
                    'city' => $request->city,
                    'status' => $status,
                ]);

            return redirect('members');
        }
    }

    public function memberProfile($id)
    {
        $member = Member::find($id);
        Log::info($member);

        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // Ukupno dolazaka
        $ukupnoDolazaka = DB::table('attendances')->where('member_id', $id)->count();

        // Dolasci u trenutnom mjesecu
        $trenutniMjesec = DB::table('attendances')
            ->where('member_id', $id)
            ->whereYear('in', $now->year)
            ->whereMonth('in', $now->month)
            ->count();

        // Dolasci u prethodnom mjesecu
        $prethodniMjesec = DB::table('attendances')
            ->where('member_id', $id)
            ->whereYear('in', $lastMonth->year)
            ->whereMonth('in', $lastMonth->month)
            ->count();

        // Statistika vremena boravka (u minutama)
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

        // Datum isteka članarine
        $clanarina = DB::table('fees')
            ->where('member_id', $id)
            ->orderBy('end', 'desc')
            ->first();

        $istekClanarine = $clanarina ? $clanarina->end : null;
        $aktivanClan = $istekClanarine && Carbon::parse($istekClanarine)->gte($now->startOfDay());

        // Mjesečni pregled dolazaka (posljednjih 6 mjeseci)
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

        // Cilj: 20 dolazaka mjesečno (otprilike 5x sedmično)
        $ciljDolazaka = 20;
        // Cilj: 30 sati mjesečno (otprilike 1.5h x 20 treninga)
        $ciljMinuta = 1800;

        // Godišnji pregled: trenutna i prethodna godina (svih 12 mjeseci)
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

        return view('memberProfile', [
            'member' => $member,
            'ukupnoDolazaka' => $ukupnoDolazaka,
            'trenutniMjesec' => $trenutniMjesec,
            'prethodniMjesec' => $prethodniMjesec,
            'vrijemeUkupno' => $vrijemeUkupno,
            'vrijemeTrenutni' => $vrijemeTrenutni,
            'vrijemeProthodni' => $vrijemeProthodni,
            'istekClanarine' => $istekClanarine,
            'aktivanClan' => $aktivanClan,
            'mjesecniPregled' => $mjesecniPregled,
            'ciljDolazaka' => $ciljDolazaka,
            'ciljMinuta' => $ciljMinuta,
            'godisnjiPregled' => $godisnjiPregled,
        ]);
    }

    public function editMember($id)
    {
        $member = Member::find($id);
        Log::info($member);

        return view('editMember', ['member' => $member]);
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = Member::where('name', 'LIKE', "%$searchTerm%")
            ->orWhere('surname', 'LIKE', "%$searchTerm%")
            ->paginate(1000);

        return view('search', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $member = new Member();
        Log::info($request);

        $filename = null;
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $path = public_path() . '/images/';

            $img = Image::make($file->getRealPath());
            $quality = 90;
            $img->save($path . $filename, $quality);

            // Smanjuj kvalitet dok slika ne bude manja od 1MB
            while (filesize($path . $filename) > 1048576 && $quality > 10) {
                $quality -= 10;
                $img->save($path . $filename, $quality);
            }

            // Ako je još uvijek veća od 1MB, smanji dimenzije
            if (filesize($path . $filename) > 1048576) {
                $img->resize($img->width() / 2, $img->height() / 2);
                $img->save($path . $filename, $quality);
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Morate uploadovati sliku člana.');
        }
        $member->name = $request->name;
        $member->surname = $request->surname;
        $member->code = $request->code;
        $member->email = $request->email;
        $member->jmbg = $request->jmbg;
        $member->register_date = Carbon::now();
        $member->street = $request->street;
        $member->post_no = $request->post_no;
        $member->mobile = $request->mobile;
        $member->status = $request->status;
        $member->city = $request->city;
        $member->image_path = $filename;
        $member->save();
        return redirect()->route('createMember');



        // Upload slike i prikaz putanje
        /* if( $request->hasFile('uploadfile')) {
            $image = $request->file('uploadfile');
            $path = public_path(). '/images/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);





        } */

        /*   $member = new Member();
        $member->name= $request->name;
        $member->surname= $request->surname;
        $member->code= $request->code;
        $member->jmbg= $request->jmbg;
        $member->register_date = Carbon::now();
        $member->image_path = $request->path;
        $member->street = $request->street;
        $member->post_no = $request->post_no;
        $member->city = $request->city;
        $member->save(); */
    }


    public function store(StoreMemberRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMemberRequest  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->back()->with('success', 'Član uspješno obrisan.');
    }

    public function test(Request $request)
    {
        /*   $firstname = htmlspecialchars($_GET["firstname"]);
        $lastname = htmlspecialchars($_GET["lastname"]);
        $password = htmlspecialchars($_GET["password"]); */
        //Log::info();
        /*  $test = new Test();
        $test->name = $request->firstname;
        $test->save(); */
        //echo "firstname: $firstname lastname: $lastname password: $password";

    }
    public function profile()
    {
        return view('memberProfile');
    }

    public function attendance()
    {
        return view('attendance');
    }

    public function attendance2()
    {
        return view('attendance2');
    }

    public function slanje(Request $request){

        $id = $request->postObj['id'];
        $gym = $request->postObj['gym'];
        Log::info($gym);
        $date = Carbon::today()->toDateString();
      $end = Member::select("fees.end as rok")
            ->join("fees", "fees.member_id", "=", "members.id")
            ->where([
                ['members.code', '=', $id],
                ['fees.end', '>=', $date],
            ])->orderBy('fees.id','DESC')
            ->get();







       Log::info($end);
        if(count($end)>0){
            if ($end[0]->rok >= $date) {
                $istek = date("d.m.Y", strtotime($end[0]->rok));
                Log::info('Aktivan član');
                Log::info('Carbon: ' . Carbon::now());
               /*  $user = Member::join('fees', 'fees.member_id', '=', 'members.id')
                    ->where('members.code', $id)
                    ->get(['members.*', 'fees.end as end']); */
                    $user = Member::join('fees', 'fees.member_id', '=', 'members.id')
                    ->select('members.*', 'fees.end as end')
                    ->where('members.code', $id)
                    ->orderBy('fees.id', 'desc')
                    ->limit(1)
                    ->get();
                    Log::Info('Provjera');
                    Log::Info($user);


                $user_id = $user[0]->id;

                Log::info(Carbon::today()->toDateString());
                //Dodaj u evidencije



                $provjera_evidencije = Attendance::where('member_id', $user_id)->OrderBy('id', 'DESC')->first();
                // Log::info($provjera_evidencije);
                if ($provjera_evidencije) {

                    if ($provjera_evidencije->status == 1) {
                        Log::info('Uraditi Logout');
                        //$provjera_evidencije->update(['out'=>Carbon::now()]);
                        $provjera_evidencije->out = Carbon::now();
                        $provjera_evidencije->status = 0;
                        $provjera_evidencije->save();

                        $json = json_encode(['response' => $user, 'id' => 1], true); // Izlaz

                        echo $json;
                    } elseif ($provjera_evidencije->status == 0) {
                        $evidencije = new Attendance();
                        $evidencije->in = Carbon::now();
                        //$evidencije->out= Carbon::now();
                        $evidencije->date = Carbon::today()->toDateString();
                        $evidencije->status = 1;
                        $evidencije->gym = $gym;
                        $evidencije->member_id = $user_id;
                        $evidencije->save();
                        $json = json_encode(['response' => $user, 'id' => 0,'rok'=>$istek], true);   // Ulaz
                        echo $json;
                    }
                } else {
                    Log::info('Uraditi PRVI LOGIN');
                    $evidencije = new Attendance();
                    $evidencije->in = Carbon::now();
                    //$evidencije->out= Carbon::now();
                    $evidencije->date = Carbon::today()->toDateString();
                    $evidencije->status = 1;
                    $evidencije->gym = $gym;
                    $evidencije->member_id = $user_id;
                    $evidencije->save();

                    $json = json_encode(['response' => $user, 'id' => 0,'rok'=>$istek], true);  // Ulaz
                    echo $json;
                }
            }

        }
        else {
            Log::info('Neaktivan član');
            $user = Member::where('code',$id)->first();
            $json = json_encode(['response' => $user,'id' => 2], true);  // Članarina je istekla
            echo $json;
        }

        //Log::info($provjera_evidencije->status);
        /*  $prov = $provjera_evidencije[0]->status; */

        /*    Attendance::where('member_id',$id)->update(['out'=>Carbon::now(), 'status'=> 0])->first(); */
        /*  if(isset($provjera_evidencije)){





            $json = json_encode(['response' => $user], true);
            echo $json;
        } else {

            $json = json_encode(['response' => $id], true);
            echo $json;
        }
 */
    }
}
