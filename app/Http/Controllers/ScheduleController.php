<?php

namespace App\Http\Controllers;

use App\Models\{Schedule,Cashier,Shift};
use DataTables;
use Alert;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use LengthException;
use Response;

class ScheduleController extends Controller
{

    public function datatable(Request $request)
    {

            // var_dump($request->position);

        // $data = DB::table('scheduletable')
        //     ->select('scheduletable.id','scheduletable.Employee','scheduletable.FullName','scheduletable.Date','scheduletable.CodeShift',
        //             'workinghourtable.id as idWH','workinghourtable.StartShift', 'workinghourtable.EndShift','workinghourtable.Shift')
        //     ->leftJoin('workinghourtable', 'scheduletable.CodeShift', '=', 'workinghourtable.CodeShift')->orderBy('scheduletable.Employee','asc')
        //     ->get();
                // ->addColumn('attendance',
                // '<button type="button" class="btn btn-primary"><i class="fas fa-wrench"></i> Masuk</button>')
                // ->addColumn('activity', '<input type="text" name="activity{{$id}}" id="activity{{$id}}" class="form-control" />')
                // ->addColumn('shift', '<label for="shift">{{$StartShift}} - {{$EndShift}}</label>')
        //$dataconsolidate = Consolidate::with('cashier','counter')->latest()->get();
        // $dataschedule = Cashier::where('Status','Active')->get();


        // return Datatables::of($users)
        // ->filter(function ($query) use ($request) {
        //     if ($request->has('selectposition')) {
        //         $query->where('position', 'like', "%{$request->get('selectposition')}%");
        //     }

        //     if ($request->has('selectstatus')) {
        //         $query->where('status', 'like', "%{$request->get('selectstatus')}%");
        //     }
        // })
        // ->make(true);
        // ->where('position', $positiontable)->where('status', $statustable)
    //     $duplicates = DB::table('schedules')
    // ->select('subject', 'book_id')
    // ->where('group_id', 3)
    // ->groupBy('subject', 'book_id')
    // ->havingRaw('COUNT(*) > 1')
    //->having('account_id', '>', 100)
    // ->get();
        $positiontable = $request->position;
        $statustable = $request->status;
        $weektable = $request->week;
        $dataschedule = Schedule::with(['cashier' ,'shift'])
                        ->where('week',$weektable)
                        ->whereHas('cashier', function($query) use($statustable,$positiontable) {$query
                        ->whereIn('status', $statustable)
                        ->whereIn('position',$positiontable)
                        ->groupBy('fullname')
                        ;})
                        ->get();
        return DataTables::of($dataschedule)
            ->addColumn('EmployeeName', '{{$cashier["employee"]}} - {{$cashier["fullname"]}}')
            ->addColumn('action',
            '<div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i> </button>
            <div class="dropdown-menu dropdown-menu-right" role="menu">
            <a class="schedulecreate dropdown-item" id="{{$id}}"><i class="fas fa-desktop"></i> Create</a>
            <a class="scheduleedit dropdown-item" id="{{$id}}" onclick="editschedule({{$id}})"><i class="fas fa-edit"></i> Edit</a>
            <a class="scheduledelete dropdown-item" id="{{$id}}"><i class="fas fa-trash"></i> Delete</a>
            </div></div>')
            ->rawColumns(['StatusCashier','EmployeeName','action'])
            ->editColumn('cashier.status', function ($Schedule) {
                if ($Schedule->cashier['status'] == 'Active') return '<span class="badge badge-success">' .$Schedule->cashier['status'].'</span>';
                if ($Schedule->cashier['status'] == 'Inactive') return '<span class="badge badge-warning">' .$Schedule->cashier['status'].'</span>';
                return 'Null';
            })
            ->escapeColumns('cashier.status')
            ->make(true);
    }

    public function index(Request $request)
    {
        // $datacashier = Cashier::all();
        $datashift = Shift::all();
        return view('schedule.scheduledatatable2',compact('datashift'));
    }

    public function create(Request $request)
    {
        $positiontable = $request->position;
        $weektable = $request->week;
        $datacashier = Cashier::whereIn('position',$positiontable)->where('status','Active')->orderBy('employee','ASC')->get();
        $dataschedule = Schedule::with(['cashier' ,'shift'])->where('week',$weektable)->orderBy('id','ASC')->get();

        //return response()->json($datacashier);
        return Response::json(array('datacashier' => $datacashier,'dataschedule' => $dataschedule));
    }

    public function form($id)
    {
         // $dataschedule = Schedule::latest()->get();;where('position',$positiontable)->
        $startdate = date('2020-12-14');
        $enddate = date('2020-12-20');

        $datacashier = Cashier::find($id);
        $dataschedule= Schedule::with(['cashier','shift'])->where('cashier_id',$id)->whereBetween('date',[$startdate,$enddate])->get();
        //dd($datacashier,$dataschedule);
        return Response::json(array('datacashier' => $datacashier,'dataschedule' => $dataschedule));
        //return Response::json($dataschedule);
    }

    public function indexnew()
    {
         // $dataschedule = Schedule::latest()->get();
         // $datacashier = Cashier::latest()->get();
        $dataworkinghour = Shift::all();
        return view('schedule.schedulecreatenew',compact('dataworkinghour'));
    }

    public function datatablecreate()
    {
            // $dataworkinghour = Shift::all();
            $data = Cashier::where('Status','Active')->get();
            return DataTables::of($data)
            ->addColumn('cashier', '{{$Employee}} {{$FullName}}')
            ->addColumn('monday', '<input type="text" name="monshift{{$id}}" id="monshift{{$id}}" class="form-control input-uppercase" oninput="shifthour({{$id}})"/>')
            ->addColumn('tuesday', '<input type="text" name="tueshift{{$id}}" id="tueshift{{$id}}" class="form-control input-uppercase" oninput="shifthour({{$id}})" />')
            ->addColumn('wednesday', '<input type="text" name="wedshift{{$id}}" id="wedshift{{$id}}" class="form-control input-uppercase" oninput="shifthour({{$id}})" />')
            ->addColumn('thursday', '<input type="text" name="thurshift{{$id}}" id="thurshift{{$id}}" class="form-control input-uppercase" oninput="shifthour({{$id}})" />')
            ->addColumn('friday', '<input type="text" name="frishift{{$id}}" id="frishift{{$id}}" class="form-control input-uppercase" oninput="shifthour({{$id}})" />')
            ->addColumn('saturday', '<input type="text" name="saturshift{{$id}}" id="saturshift{{$id}}" class="form-control input-uppercase" oninput="shifthour({{$id}})" />')
            ->addColumn('sunday', '<input type="text" name="sunshift{{$id}}" id="sunshift{{$id}}" class="form-control input-uppercase" oninput="shifthour({{$id}})" />')
            ->addColumn('action',
                '<div class="btn-group">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i> </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                <a class="schedulesave dropdown-item" id="{{$id}}" onclick="freezeschedule({{$id}})"><i class="fas fa-desktop"></i> Create</a>
                <a class="scheduleedit dropdown-item" id="{{$id}}" onclick="editschedule({{$id}})"><i class="fas fa-edit"></i> Edit</a>
                <a class="scheduledelete dropdown-item" id="{{$id}}"><i class="fas fa-trash"></i> Delete</a>
                </div></div>')
            ->rawColumns(['monday','tuesday','wednesday','thursday','friday','saturday','sunday','action'])
            ->make(true);

    }

    public function store(Request $request)
    {
        $arraycode = ['codemonday','codetuesday','codewednesday','codethursday','codefriday','codesaturday','codesunday'];
        $arrayid = ['idmonday','idtuesday','idwednesday','idthursday','idfriday','idsaturday','idsunday'];
        $dataweek = $request->weekinput;
        $startdate = Carbon::parse($request->dateinput);
        $positiontable = explode(',', $request->positionhidden);
        $datacashier = Cashier::whereIn('position',$positiontable)->where('status','Active')->orderBy('employee','ASC')->pluck('id')->toArray();

        for($b=0;$b<count($datacashier);$b++){
            for($c=0;$c<7;$c++)
            {
                if($c==0){
                    $dateformat =  $startdate->isoFormat('YYYY-MM-DD');
                    $dateschedule = Carbon::parse($dateformat);
                }
                else{
                    $dateadd =  $startdate->addDays(1);
                    $dateformat = $dateadd->isoFormat('YYYY-MM-DD');
                    $dateschedule = Carbon::parse($dateformat);
                }

                $code = $arraycode[$c] .$b;
                $shift = $request->$code;
                $codeshift = strtoupper($shift);
                $datashift = Shift::where('codeshift',$codeshift)->pluck('id')->toArray();

                $id = $arrayid[$c] .$b;
                $dataid = $request->$id;

                if(count($datashift) > 0){
                    $attr=array(
                        'cashier_id' => $datacashier[$b],
                        'shift_id' => $datashift[0],
                        'week' =>  $dataweek,
                        'date' => $dateschedule,
                    );
                    Schedule::updateOrCreate(['id'=>$dataid],$attr);
                }
                else{
                    return response()->json(['error' => 'Please check Your Schedule, status have not save.']);
                }
            }
        }
        return response()->json(['success' => 'Data Added successfully.']);

    }

    public function show($id)
    {
        $data = Schedule::findOrFail($id);
        return view('schedule.scheduleprofile',compact('data'));
    }

    public function edit($id)
    {
        $data = Schedule::with(['cashier' ,'shift'])->find($id);
        return response()->json($data);
    }

    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    public function destroy($id)
    {
        $data = Schedule::findOrFail($id);
        $data->delete();
    }
    public function destroydatatable($id)
    {
        $data = Schedule::findOrFail($id);
        $data->delete();
    }
    public function day($monday)
    {
        $data = Schedule::findOrFail($id);
        $data->delete();
    }
}
