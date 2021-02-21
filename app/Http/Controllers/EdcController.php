<?php

namespace App\Http\Controllers;

use App\Models\{Edc,Counter};
use DataTables;
use App\DataTables\EdcsDataTable;
use Illuminate\Http\Request;
use Validator;
Use Alert;

class EdcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function yajra(EdcsDataTable $dataTable)
    {
        return $dataTable->render('edc.index');
    }



    public function datatable(Request $request)
    {
        $dataedc = Edc::with('counter')->latest()->get();
        return DataTables::of($dataedc)
        ->addColumn('action','<div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i> </button>
            <div class="dropdown-menu dropdown-menu-right" role="menu">
            <a href="edc/{{$id}}" class="edcshow dropdown-item" id="{{$id}}"><i class="fas fa-desktop"></i> Show</a>
            <a href="#" class="editedc dropdown-item" id="{{$id}}"><i class="fas fa-edit"></i> Edit</a>
            <a href="#" class="deleteedc dropdown-item" id="{{$id}}"><i class="fas fa-trash"></i> Delete</a>
            </div></div>')
        ->addColumn('checkbox', '<input type="checkbox" name="edccheckbox[]" class="edccheckbox" value="{{$id}}" />')
        ->rawColumns(['action','checkbox'])
        ->editColumn('status', function ($dataedc) {
            if ($dataedc->status == 'Active') return '<span class="badge badge-success">' .$dataedc->status.'</span>';
            if ($dataedc->status == 'Inactive') return '<span class="badge badge-warning">' .$dataedc->status.'</span>';
            if ($dataedc->status == 'Lock') return '<span class="badge badge-danger">' .$dataedc->status.'</span>';
            if ($dataedc->status == 'Broken') return '<span class="badge badge-secondary">' .$dataedc->status.'</span>';
            return 'Null';
        })
        ->escapeColumns('status')
        ->make(true);

    }
    public function index(Request $request)
    {
        $datacounter = Counter::orderBy('nocounter','asc')->get();

        //$dataedc = Edc::with('counter')->latest()->get();
        //return $dataedc->NoCounter;
        return view('edc.edcdatatable',compact('datacounter'));
        // return view('edc.datatable');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $idedc = $request->id;
        if (!$idedc) {
            $dataedc=$request->validate([
                'tidedc' => 'required|min:5',
                'midedc' => 'required|string',
                'ipaddress' => 'required|unique:edcs',
                'serialnumber' => 'required|unique:edcs',
                'counter_id' => 'required',
                'connection' => 'required',
                'simcard' => 'required',
                'type' => 'required',
                'status' => 'required'
            ]);
        }
        else {
            $dataedc=$request->validate([
                'tidedc' => 'required|min:5',
                'midedc' => 'required|string',
                'ipaddress' => 'required',
                'serialnumber' => 'required',
                'counter_id' => 'required',
                'connection' => 'required',
                'simcard' => 'required',
                'type' => 'required',
                'status' => 'required'
            ]);
        }

        dd($dataedc);
        Edc::updateOrCreate(['id'=>$request->id],$dataedc);
        return response()->json(['success' => 'Data Added successfully.']);

        // if ($attr->fails()) {
        //     return Redirect::back()->with('error_code', 5);
        // } else {
        //     return back()->with('success', 'Success Message');
        // }

        // return back()->with('success', 'Success Message');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Edc  $Edc
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $data = Edc::findOrFail($id);
        return view('edc.edcprofile',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
      *
     * @param  \App\Edc  $Edc
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Edc::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Edc  $Edc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Edc $Edc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Edc  $Edc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Edc::findOrFail($id);
        $data->delete();
    }
    public function moredelete(Request $request)
    {
        $idarray = $request->input('id');
        $edc = Edc::whereIn('id',$idarray)->delete();
    }
}
