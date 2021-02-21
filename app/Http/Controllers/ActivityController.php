<?php

namespace App\Http\Controllers;

use App\Models\{Activity,Schedule,Counter,Cashier,Shift};
use Validator;
use DataTables;
use Carbon\Carbon;
Use Alert;
use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $datacounter = Counter::orderBy('nocounter','asc')->get();
        $date = Carbon::now();
        $dataschedule= Schedule::with(['cashier','shift'])->where('date',$date->toDateString())->whereHas('shift', function($query){$query->where('codeshift','!=','OFF');})->get();
            return DataTables::of($dataschedule)
            ->addColumn('EmployeeName', '{{$cashier["employee"]}} - {{$cashier["fullname"]}}')
            ->addColumn('time', '{{$shift["startshift"]}} - {{$shift["endshift"]}}')
            ->addColumn('activity', function($row) use ($datacounter)  {
                $options = '';
                foreach ($datacounter as $counter) {
                    $options .= '<option value="'.$counter->id.'">'.$counter->type.'('.$counter->nocounter.')</option>';
                }
                $return =
                    '<div class="form-group"><div class="form-line">
                    <select name="counter_id" id="chronologyselect'.$row->id.'" class="custom-select" autofocus><option value="">Select Counter</option>'.$options.'
                    <option value="">lain-lain</option></select></div></div>';
                return $return;
            })
            ->addColumn('information', '<input type="text" class="form-control" name="info{{$id}}" id="info{{$id}}">')
            ->addColumn('action',function($row){
                $dataactivity = Activity::where('schedule_id',$row->id)->orderBy('workingtime','desc')->first();
                if (!$dataactivity) {
                    return '<input type="hidden" name="chronologyid'.$row->id.'" id="chronologyid'.$row->id.'" value="">
                    <button type="button" id="'.$row->id.'" status="in" class="statusbutton btn btn-block bg-gradient-secondary"><i class="fas fa-sign-in-alt"></i> Waiting</button>';
                } else {
                    if($dataactivity["status"]=="in"){
                        $status = "break";
                        $value = "Working";
                        $class = "";
                        $icon = '<i class="fas fa-building"></i>';
                    }
                    else if($dataactivity["status"]=="break"){
                        $status = "back";
                        $value = "Break";
                        $class = "";
                        $icon = '<i class="fas fa-coffee"></i>';
                    }
                    else if($dataactivity["status"]=="back"){
                        $status = "out";
                        $value = "Working";
                        $class = "";
                        $icon = '<i class="fas fa-building"></i>';
                    }
                    else if($dataactivity["status"]=="out"){
                        $status = "tes";
                        $value = "Finish";
                        $class = "disabled";
                        $icon = '<i class="fas fa-sign-out-alt"></i>';
                    }
                    return '<input type="hidden" name="chronologyid'.$row->id.'" id="chronologyid'.$row->id.'" value="'.$dataactivity["id"].'">
                    <button type="button" id="'.$row->id.'" status="'.$status.'" class="statusbutton btn btn-block bg-gradient-secondary" '.$class.'="'.$class.'">'.$icon.' '.$value.'</button>';
                }
            })
            ->rawColumns(['EmployeeName','time','activity','information','action'])
            ->make(true);
    }
    public function index()
    {
        //$dataactivity = Activity::where('schedule_id',$row->id)->orderBy('workingtime','desc')->first();
        $today = Carbon::now();
        return view('activity.chronology',compact('today'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $datactivity=$request->all();
        // $datactivity=array(
        //     'schedule_id' => $request->schedule_id,
        //     'counter_id' => $request->counter_id,
        //     'status' => $request->status,
        //     'in' => $request->in,
        //     'break' => $request->break,
        //     'back' => $request->back,
        //     'out' => $request->out
        // );


            Activity::updateOrCreate(['id'=>$request->id],$datactivity);

        return response()->json(['success' => 'This employee has filled in attendance.','status' => $request->status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
