<?php

namespace App\Http\Controllers\DataMaster;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TblCompany;
use App\Models\User;

class CompanyBpnController extends Controller{
    function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $pageFileName = 'company';
        $title        = 'Kantor BPN';
        return view('data-master.company-bpn', compact('title'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $data = TblCompany::select(
                    'tbl_company.tbl_company_id',
                    'tbl_company.company_nm',
                    'tbl_company.company_tp',
                    'companytp.code_nm as company_tp_nm',
                    'tbl_company.company_address',
                    'tbl_company.phone'
                )
                ->leftJoin('com_code as companytp','companytp.com_cd','tbl_company.tbl_company_id')
                ->where('company_tp','COMPANY_TP_3');

        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = '';
                    $actions .= "<button type='button' id='ubah'  class='btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp";
                    $actions .= "<button type='button' id='hapus' class='btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button>";

                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $this->validate($request,[
            'tbl_company_id'  => 'required',
            'company_nm'      => 'required',
            'company_tp'      => 'nullable',
            'company_address' => 'nullable',
            'phone'           => 'nullable',
        ]);

        $company                    = new TblCompany;
        $company->tbl_company_id    = $request->tbl_company_id;
        $company->company_nm        = $request->company_nm;
        $company->company_tp        = 'COMPANY_TP_3';
        $company->company_address   = $request->company_address;
        $company->phone             = $request->phone;
        $company->created_by        = Auth::user()->user_id;
        $company->save();

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $company = TblCompany::find($id);

        return response()->json(['status' => 'ok', 'data' => $company],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
        // return $request->all();
        $this->validate($request,[
            'tbl_company_id'  => 'required',
            'company_nm'      => 'required',
            'company_tp'      => 'nullable',
            'company_address' => 'nullable',
            'phone'           => 'nullable',
        ]);

        DB::transaction(function () use($request, $id) {
            $company                    = TblCompany::find($id);
            $company->company_nm        = $request->company_nm;
            $company->company_nm        = $request->company_nm;
            // $company->company_tp        = $request->company_tp;
            $company->company_address   = $request->company_address;
            $company->phone             = $request->phone;
            $company->updated_by        = Auth::user()->user_id;
            $company->save();

            // $users = User::where('tbl_company_id',$id)->update(['tbl_company_id'])
        });

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        TblCompany::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }
}
