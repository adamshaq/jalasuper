<?php

namespace App\Http\Controllers\DataMaster;

use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TblJenisRegister;
use App\Models\TblJenisRegisterCompany;

class JenisRegisterCompanyController extends Controller{
    function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData($id = NULL){
        $data = TblJenisRegisterCompany::select(
                    'tbl_jenis_register_company.tbl_jenis_register_company_id',
                    'company.company_nm',
                    'tbl_jenis_register_company.duration',
                    'tbl_jenis_register_company.notification_tp',
                    'notiftp.code_nm as notification_tp_nm'
                )
                ->leftJoin('tbl_company as company','company.tbl_company_id','tbl_jenis_register_company.tbl_company_id')
                ->leftJoin('com_code as notiftp','notiftp.com_cd','tbl_jenis_register_company.notification_tp');
        
        if($id){
            $data->where('tbl_jenis_register_company.tbl_jenis_register_id', $id);
        }

        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = "<button type='button' id='ubah-company' class='btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp";
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
            'jenis_register_nm'      => 'required',
            'jenis_register_tp'      => 'nullable',
        ]);
            
        $registerType                        = new TblJenisRegister;
        $registerType->jenis_register_nm     = $request->jenis_register_nm;
        $registerType->jenis_register_tp     = $request->jenis_register_tp;
        $registerType->duration              = $request->duration;
        $registerType->warning               = round(env('WARNING_COEFFITIENT') * $request->duration);
        $registerType->created_by            = Auth::user()->user_id;
        $registerType->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $registerType = TblJenisRegister::find($id);

        return response()->json(['status' => 'ok', 'data' => $registerType],200); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
        $this->validate($request,[
            'duration'          => 'required',
            'notification_tp'   => 'required',
        ]);
            
        $registerType                    = TblJenisRegisterCompany::find($id);
        $registerType->duration          = $request->duration;
        $registerType->warning           = round(env('WARNING_COEFFITIENT') * $request->duration);
        $registerType->notification_tp   = $request->notification_tp;
        $registerType->updated_by        = Auth::user()->user_id;
        $registerType->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        TblJenisRegister::destroy($id);
        
        return response()->json(['status' => 'ok'],200); 
    }
}
