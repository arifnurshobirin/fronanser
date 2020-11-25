<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use DataTables;
use Illuminate\Http\Request;
use Validator;
Use Alert;

class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $request)
    {
        $datacounter = Counter::latest()->get();
            return DataTables::of($datacounter)
            ->addColumn('action',
            '<div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i> </button>
            <div class="dropdown-menu dropdown-menu-right" role="menu">
            <a href="#" class="countershow dropdown-item" id="{{$id}}"><i class="fas fa-desktop"></i> Show</a>
            <a href="#" class="counteredit dropdown-item" id="{{$id}}"><i class="fas fa-edit"></i> Edit</a>
            <a href="#" class="counterdelete dropdown-item" id="{{$id}}"><i class="fas fa-trash"></i> Delete</a>
            </div></div>')
            ->addColumn('checkbox', '<input type="checkbox" name="countercheckbox[]" class="checkbox countercheckbox" value="{{$id}}" />')
            ->rawColumns(['checkbox','action'])
            ->editColumn('status', function ($datacounter) {
                if ($datacounter->status == 'Queueing') return '<span class="badge badge-danger">' .$datacounter->status.'</span>';
                if ($datacounter->status == 'Active') return '<span class="badge badge-success">' .$datacounter->status.'</span>';
                if ($datacounter->status == 'Inactive') return '<span class="badge badge-warning">' .$datacounter->status.'</span>';
                if ($datacounter->status == 'Broken') return '<span class="badge badge-secondary">' .$datacounter->status.'</span>';
                return 'Null';
            })
            ->escapeColumns('status')
            ->make(true);

    }

    public function index(Request $request)
    {
        return view('counter.counterdatatable');
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

        var_dump($request->nocounter);
        // $form_data = array(
        //     'nocounter' => $request->nocounter,
        //     'ipaddress' => $request->ipaddress,
        //     'macaddress' => $request->macaddress,
        //     'type' => $request->typecounter,
        //     'status' => $request->statuscounter
        // );

        // Counter::updateOrCreate(['id'=>$request->counterid],$form_data);

        // return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Counter  $Counter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Counter::findOrFail($id);
        return view('counter.counterprofile',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Counter  $Counter
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Counter::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Counter  $Counter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Counter $Counter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Counter  $Counter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Counter::findOrFail($id);
        $data->delete();
    }

    public function moredelete(Request $request)
    {
        // if($request->ajax()){
        //     return response()->json(['status'=>'Ajax request']);
        // }
        // return response()->json(['status'=>'Http request']);
        $idarray = $request->input('id');
        $counter = Counter::whereIn('id',$idarray)->delete();
    }
}
