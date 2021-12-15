<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use App\Models\TblRegister;
use App\Models\TblCompany;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RegisterTptLokalImport;
use App\Imports\RegisterEregImport;
use App\Imports\RegisterDJP9Import;
use App\Imports\RegisterSPTLBImport;

class RegisterController extends Controller
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
    function upload(Request $request){
        if ($request->tbl_company_id == Auth::user()->tbl_company_id) {
            if($request->hasFile('berkas-register')) {
                $file = $request->file('berkas-register');
                
                switch ($request->file_tp) {
                    case 'FILE_TP_1':
                        $import = new RegisterEregImport();
                        Excel::import($import,$file);
                    break;
                    case 'FILE_TP_2':
                        $import = new RegisterDJP9Import();
                        Excel::import($import,$file);
                        break;
                    case 'FILE_TP_3':
                        $import = new RegisterSPTLBImport();
                        Excel::import($import,$file);
                        break;
                    default:
                        $import = new RegisterDJP9Import();
                        Excel::import($import,$file);
                    break;
                }
                TblRegister::where('jenis_register','like','%Jenis Surat%')->delete();
                return redirect()->back()->with(['success' => 'Berhasil Unggah Berkas Register!']); 
            }
        }else{
            return redirect()->back()->with(['error' => 'Kode Kantor Salah!']); 
        }
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function proses(Request $request, $tipe, $id){
        if($id){
            DB::transaction(function () use($request, $tipe, $id) {
                $register                = TblRegister::find($id);
                $register->phone         = $request->phone;
                $register->info_02       = $request->kanwil;
                $register->proses_st     = $tipe == 'forward' ? 'PROSES_ST_3' : 'PROSES_ST_2';
                $register->datetime_done = $request->datetime_done ? formatDateTime($request->datetime_done) : date('Y-m-d H:i:s');
                $register->done_by       = Auth::user()->user_nm;
                $register->updated_by    = Auth::user()->user_id;
                $register->save();

                $kanwil = TblCompany::find(Auth::user()->tbl_company_id);

                if($tipe == 'forward'){
                    $newRegister                        = new TblRegister;
                    $newRegister->no_surat              = $register->no_surat;
                    $newRegister->file_tp               = 'FORWARD';
                    $newRegister->jenis_register        = $register->jenis_register;
                    $newRegister->wajib_pajak           = $register->wajib_pajak;
                    $newRegister->note                  = $register->note;
                    $newRegister->petugas_penerima      = $register->petugas_penerima;
                    $newRegister->datetime_input        = $request->datetime_done ? formatDateTime($request->datetime_done) : date('Y-m-d H:i:s');;
                    $newRegister->tbl_company_id        = $kanwil->company_root;
                    $newRegister->tbl_company_id_from   = $register->tbl_company_id;
                    $newRegister->created_at            = date('Y-m-d H:i:s');
                    $newRegister->created_by            = Auth::user()->user_id;
                    $newRegister->save();
                }
            });
            return response()->json(['status' => 'ok'],200); 
        }else{
            return response()->json(['status' => 'error', 'msg' => 'id cannot be null'],200); 
        }
        
    }

    function update(Request $request, $id){
        $register                = TblRegister::find($id);
        $register->datetime_done = $request->change_datetime_done ? formatDateTime($request->change_datetime_done) : date('Y-m-d H:i:s');
        $register->updated_by    = Auth::user()->user_id;
        $register->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        TblRegister::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

    function viaPos(Request $request){
        $register                    = new TblRegister;
        $register->no_surat          = $request->no_surat;
        $register->file_tp           = 'FILE_TP_4';
        $register->jenis_register    = $request->jenis_register;
        $register->wajib_pajak       = $request->wajib_pajak;
        $register->note              = $request->note;
        $register->petugas_penerima  = $request->petugas_penerima;
        $register->datetime_input    = date('Y-m-d H:i:s');
        $register->tbl_company_id    = Auth::user()->tbl_company_id;
        $register->created_at        = date('Y-m-d H:i:s');
        $register->created_by        = Auth::user()->user_id;
        $register->save();

        return response()->json(['status' => 'ok'],200);
    }
}
