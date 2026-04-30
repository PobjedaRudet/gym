<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      /*   $test = Member::select("*")
        ->join("fees", "fees.member_id", "=", "members.id")
        ->where([
            ['members.id', '=', $id],

        ])
        ->get(); */
        $test = Member::find($id);
        Log::info($test);


        return view('createFee',['test'=> $test]);
    }

    public function fees($id){

        /* $member = Member::select('*')
            ->join("fees", "fees.member_id", "=", "members.id")
            ->where([
                ['members.id', '=', $id],

            ])->orderBy('fees.id', 'DESC')
            ->get(); */
            $member = Member::join('fees', 'fees.member_id', '=', 'members.id')
            ->select('members.*', 'fees.id as fees_id', 'fees.date as date', 'fees.start as start','fees.end as end')
            ->where('members.id', $id)
            ->orderBy('fees.id', 'desc')
            ->get();


        return view('fees',['stanje' => $member, 'id'=>$id]);
    }

    public function insertFee(Request $request){

        Log::info($request);
        //Fee::create($request->all());
        Fee::create([
            'amount' => $request->amount,
            'date' => $request->date,
            'start'=> Carbon::createFromFormat('d-m-Y', $request->start)->format('Y-m-d'),
            'end'=> Carbon::createFromFormat('d-m-Y', $request->end)->format('Y-m-d'),
            'comment' => $request->comment,
            'member_id' => $request->member_id,
        ]);

        return redirect()->route('members');

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
     * @param  \App\Http\Requests\StoreFeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function show(Fee $fee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function editFee($id)
    {
        $member = Member::join('fees', 'fees.member_id', '=', 'members.id')
        ->select('members.*', 'fees.*', 'fees.id as fees_id')
        ->where('fees.id', $id)
        ->get();



        return view('editFee', ['test' => $member]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFeeRequest  $request
     * @param  \App\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeeRequest $request, Fee $fee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Fee::where('id',$id)->delete();
        return redirect()->route('members');
    }
    public function updateFee(Request $request){

        Fee::where('id', $request->fees_id)
        ->update([
            'amount' => $request->amount,

        ]);
        return redirect('members');

    }
}
