<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Models\TblJenisRegister;
use App\Models\TblRegister;
use App\Models\VwRegister;

class CatatanPemohonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function index(Request $request){
        $jenisRegister  = TblJenisRegister::all();
        $title          = "Catatan Pemohon";
        return view('catatan-pemohon', compact('title', 'jenisRegister'));
    }

    function getData(Request $request){
        $tblCompanyId = Auth::user()->tbl_company_id;
        $data         = VwRegister::whereRaw("coalesce(tbl_company_id, '') = '$tblCompanyId'")
                        ->where(function($query){
                            $query->whereNotNull('pemohon_note');
                            $query->where('pemohon_note_st','0');
                        });

        return DataTables::of($data)
        ->addColumn('list_data',function($data){
            $status = 'catatan';
            return view('template.register', compact('data','status'))->render();
        })
        ->rawColumns(['list_data'])
        ->make(true);
    }

    function update($id){
        $register = TblRegister::find($id);
        $register->pemohon_note_st = '1';
        $register->updated_by      = Auth::user()->user_id;
        $register->save();

        return response()->json(['status' => 'ok'],200);
    }
}
