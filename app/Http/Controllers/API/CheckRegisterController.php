<?php

namespace App\Http\Controllers\API;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TblRegister;
use App\Models\TblRegisterScan;

class CheckRegisterController extends Controller
{
    function index(Request $request){
        $result = DB::transaction(function () use($request) {
            $id = substr($request->id, -32);
            $register = TblRegister::select(
                            "tbl_register_id",
                            "no_surat",
                            "datetime_input",
                            "wajib_pajak",
                            "jenis_register",
                            "bpn_check_count",
                            "bpn_approve_st"
                        )
                        ->where('no_surat', $id)
                        ->first();
            
            if ($register) {
                $updateRegister                     = TblRegister::find($register->tbl_register_id);
                $updateRegister->bpn_check_by       = Auth::user()->user_id;
                $updateRegister->bpn_check_datetime = date('Y-m-d H:i:s');
                $updateRegister->bpn_check_count    = $register->bpn_check_count + 1;
                $updateRegister->updated_by         = Auth::user()->user_id;
                $updateRegister->save();
    
                $scanLog                    = new TblRegisterScan;
                $scanLog->tbl_register_id   = $register->tbl_register_id;
                $scanLog->scan_by           = Auth::user()->user_id;
                $scanLog->scan_attempt      = $updateRegister->bpn_check_count;
                $scanLog->scan_datetime     = date('Y-m-d H:i:s');
                $scanLog->scan_tp           = '0';
                $scanLog->created_by        = Auth::user()->user_id;
                $scanLog->save();
    
                $register['datetime_input']     = tgl_indo($register->datetime_input);
                $register['bpn_check_count']    = $updateRegister->bpn_check_count;

                return ['status' => 'ok' , 'result' => $register];
            }else{
                return ['status' => 'not_found'];
            }
        });

        return response()->json($result, 200);
    }

    function update(Request $request){
        DB::transaction(function () use($request) {
            $id                                     = $request->id;

            $updateRegister                         = TblRegister::find($id);
            $updateRegister->bpn_approve_by         = Auth::user()->user_id;
            $updateRegister->bpn_approve_datetime   = date('Y-m-d H:i:s');
            $updateRegister->bpn_approve_st         = '1';
            $updateRegister->bpn_check_count        = $updateRegister->bpn_check_count + 1;
            $updateRegister->updated_by;
            $updateRegister->save();
    
            $scanLog                    = new TblRegisterScan;
            $scanLog->tbl_register_id   = $updateRegister->tbl_register_id;
            $scanLog->scan_attempt      = $updateRegister->bpn_check_count;
            $scanLog->scan_by           = Auth::user()->user_id;
            $scanLog->scan_datetime     = date('Y-m-d H:i:s');
            $scanLog->scan_tp           = '1';
            $scanLog->created_by        = Auth::user()->user_id;
            $scanLog->save();
        });


        return response()->json(['status' => 'ok'], 200);
    }
}

