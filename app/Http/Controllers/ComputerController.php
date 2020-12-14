<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Models\Counter;
use App\Models\Computer;
Use Alert;
use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $request)
    {
        $datacomputer = Computer::with('counter')->latest()->get();
            return DataTables::of($datacomputer)
            ->addColumn('action',
                '<div class="btn-group">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i> </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                <a href="#" class="computershow dropdown-item" id="{{$id}}"><i class="fas fa-desktop"></i> Show</a>
                <a href="#" class="computeredit dropdown-item" id="{{$id}}"><i class="fas fa-edit"></i> Edit</a>
                <a href="#" class="computerdelete dropdown-item" id="{{$id}}"><i class="fas fa-trash"></i> Delete</a>
                </div></div>')
            ->addColumn('checkbox', '<input type="checkbox" name="computercheckbox[]" class="computercheckbox" value="{{$id}}" />')
            ->rawColumns(['checkbox','action'])
            ->editColumn('status', function ($datacomputer) {
                if ($datacomputer->status == 'Active') return '<span class="badge badge-success">' .$datacomputer->status.'</span>';
                if ($datacomputer->status == 'Inactive') return '<span class="badge badge-warning">' .$datacomputer->status.'</span>';
                if ($datacomputer->status == 'Lock') return '<span class="badge badge-danger">' .$datacomputer->status.'</span>';
                if ($datacomputer->status == 'Broken') return '<span class="badge badge-secondary">' .$datacomputer->status.'</span>';
                return 'Null';
            })
            ->escapeColumns('status')
            ->make(true);
    }

    public function index()
    {
        $datacounter = Counter::orderBy('nocounter','asc')->get();
        return view('computer.computerdatatable',compact('datacounter'));
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
        $attr=$request->validate([
            'nocomputer' => 'required|unique:computers',
            'counter_id' => 'required',
            'printer' => 'required',
            'drawer' => 'required',
            'scanner' => 'required',
            'monitor' => 'required',
            'type' => 'required',
            'status' => 'required'
        ]);
        Computer::updateOrCreate(['id'=>$request->id],$attr);
        return response()->json(['success' => 'Data Added successfully.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Computer::findOrFail($id);
        return view('computer.computerprofile',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Computer::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Computer $computer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Computer $computer,$id)
    {
        $data = Computer::findOrFail($id);
        $data->delete();
    }
    public function moredelete(Request $request)
    {
        $idarray = $request->input('id');
        $computer = Computer::whereIn('id',$idarray)->delete();
    }
}
