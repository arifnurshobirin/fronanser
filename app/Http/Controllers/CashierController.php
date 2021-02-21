<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use DataTables;
use Illuminate\Http\Request;
use Validator;
Use Alert;
use Yajra\Datatables\Html\Builder;

class CashierController extends Controller
{
    public function datatable()
    {
        $datacashier = Cashier::latest()->get();
            return DataTables::of($datacashier)
            ->addColumn('action',
                '<div class="btn-group">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i> </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                <a href="#" class="cashiershow dropdown-item" id="{{$id}}"><i class="fas fa-desktop"></i> Show</a>
                <a href="#" class="cashieredit dropdown-item" id="{{$id}}"><i class="fas fa-edit"></i> Edit</a>
                <a href="#" class="cashierdelete dropdown-item" id="{{$id}}"><i class="fas fa-trash"></i> Delete</a>
                </div></div>')
            ->addColumn('checkbox', '<input type="checkbox" name="cashiercheckbox[]" class="cashiercheckbox" value="{{$id}}" />')
            ->rawColumns(['checkbox','action'])
            ->editColumn('status', function ($datacashier) {
                if ($datacashier->status == 'Active') return '<span class="badge badge-success">' .$datacashier->status.'</span>';
                if ($datacashier->status == 'Inactive') return '<span class="badge badge-warning">' .$datacashier->status.'</span>';
                return 'Null';
            })
            ->escapeColumns('status')
            ->make(true);
    }

    public function index(Request $request)
    {
        return view('cashier.cashierdatatable');
    }


    public function create(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        $idcashier = $request->id;
        if (!$idcashier) {
        $attr = $request->validate([
            'idcard' =>  'required|numeric|unique:cashiers',
            'employee' => 'required|numeric',
            'fullname' =>  'required|string',
            'dateofbirth' => 'required|date',
            'address' =>  'required',
            'phonenumber' =>  'required|min:10|unique:cashiers',
            'position' =>  'required',
            'joindate' => 'required|date',
            'status' =>  'required',
            'avatar' => 'image|max:10000'
            ]);
        }
        else {
            $attr = $request->validate([
                'idcard' =>  'required|numeric',
                'employee' => 'required|numeric',
                'fullname' =>  'required|string',
                'dateofbirth' => 'required|date',
                'address' =>  'required',
                'phonenumber' =>  'required|min:10',
                'position' =>  'required',
                'joindate' => 'required|date',
                'status' =>  'required',
                'avatar' => 'image|max:10000'
                ]);
        }

        if($request->hasFile("avatar"))
        {
            $file= $request->file("avatar");
            $imagename =$file->getClientOriginalName();
            $file->move(public_path().'/dashboard/img/', $imagename);
        }
        else{
            $imagename ="avatar.png";
        }

        $attr["dateofbirth"] = date("Y-m-d",strtotime($attr["dateofbirth"]));
        $attr["joindate"] = date("Y-m-d",strtotime($attr["joindate"]));
        $attr["avatar"] = $imagename;

        Cashier::updateOrCreate(['id'=>$request->id],$attr);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function show($id)
    {
        $data = Cashier::findOrFail($id);
        return view('cashier.cashierprofile',compact('data'));
    }

    public function edit($id)
    {
        $data = Cashier::find($id);
        return response()->json($data);
    }

    public function update($id)
    {
        $data = Cashier::find($id)->update(['status' => 'Inactive',]);
        // $data = Cashier::find($id);
        // $$data->status = "Inactive";
        // $data->save();
        // $data = Cashier::update(['id'=>$id],['status'=>'Inactive']);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = Cashier::findOrFail($id);
        $data->delete();
    }
    public function moredelete(Request $request)
    {
        $idarray = $request->input('id');
        Cashier::whereIn('id',$idarray)->delete();
    }
}
