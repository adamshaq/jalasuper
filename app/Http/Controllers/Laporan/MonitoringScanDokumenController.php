<?php

namespace App\Http\Controllers\Laporan;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\VwRegister;
use App\Models\TblRegister;
use App\Models\TblRegisterScan;

class MonitoringScanDokumenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        $title      = "Data Pantauan Pemindaian Surat Keterangan Penelitian Formal Bukti Pemenuhan Kewajiban Penyetoran PPh Penjualan Tanah";
        return view('laporan.monitoring-scan-dokumen', compact('title'));
    }

    function getData(Request $request){
        $tblCompanyId = Auth::user()->tbl_company_id;
       
        $data         = TblRegisterScan::select(
                            "tbl_register_scan_id",
                            "no_surat",
                            DB::Raw("date_format(register.datetime_input, '%d/%m/%Y') AS datetime_input_format"),
                            "register.datetime_input",
                            "scan_attempt",
                            "wajib_pajak",
                            "scan_datetime",
                            "scan_tp",
                            "scanner.user_nm as scan_by_nm"
                        )
                        ->where(function($query) use($tblCompanyId){
                            $query->whereRaw("coalesce(register.tbl_company_id, '') = '$tblCompanyId'");
                            // $query->where(function($query2){
                            //     $query2->where('bpn_check_count','>',0);
                            //     $query2->orWhere('bpn_approve_st','1');
                            // });
                        })
                        ->join('tbl_register as register','register.tbl_register_id','tbl_register_scan.tbl_register_id')
                        ->leftJoin('users as scanner','scanner.user_id','tbl_register_scan.scan_by');

        return DataTables::of($data)
        ->addColumn('date_scan',function($data){
            return date('d/m/Y',strtotime($data->scan_datetime));
        })
        ->addColumn('time_scan',function($data){
            return date('H:i:s',strtotime($data->scan_datetime));
        })
        ->addColumn('scan_status',function($data){
            if ($data->scan_tp == '1') {
                return "PENDAFTARAN";
            }else{
                return "NON PENDAFTARAN";
            }
        })
        ->addColumn('actions', function($data){
            $actions = '';
            $actions .= "<button type='button' id='hapus' class='btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button>";

            return $actions;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    function getData2(Request $request){
        $tblCompanyId = Auth::user()->tbl_company_id;
       
        $data         = VwRegister::where(function($query) use($tblCompanyId){
                            $query->whereRaw("coalesce(tbl_company_id, '') = '$tblCompanyId'");
                            $query->where(function($query2){
                                $query2->where('bpn_check_count','>',0);
                                $query2->orWhere('bpn_approve_st','1');
                            });
                        });

        return DataTables::of($data)
        ->addColumn('date_scan',function($data){
            if ($data->bpn_approve_st == '1') {
                return date('d/m/Y',strtotime($data->bpn_approve_datetime));
            }else{
                return date('d/m/Y',strtotime($data->bpn_check_datetime));
            }
        })
        ->addColumn('time_scan',function($data){
            if ($data->bpn_approve_st == '1') {
                return date('H:i:s',strtotime($data->bpn_approve_datetime));
            }else{
                return date('H:i:s',strtotime($data->bpn_check_datetime));
            }
        })
        ->addColumn('scan_status',function($data){
            if ($data->bpn_approve_st == '1') {
                return "PENDAFTARAN";
            }else{
                return "NON PENDAFTARAN";
            }
        })
        ->addColumn('scan_by',function($data){
            if ($data->bpn_approve_st == '1') {
                return $data->bpn_approve_by_nm;
            }else{
                return $data->bpn_check_by_nm;
            }
        })
        ->make(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        DB::beginTransaction();
        try {
            $data = TblRegisterScan::find($id);

            switch ($data->scan_tp) {
                case '0':
                    $register                  = TblRegister::find($data->tbl_register_id);
                    if ($register->bpn_check_count-1 == 0) {
                        $register->bpn_approve_st       = '0';
                        $register->bpn_approve_datetime = NULL;
                        $register->bpn_approve_by       = NULL;
                        $register->bpn_check_count = $register->bpn_check_count - 1;
                    }else{
                        $register->bpn_check_count = 0;
                    }
                    
                    $register->updated_by      = Auth::user()->user_id;
                    $register->save();

                    break;
                case '1':
                    $register                       = TblRegister::find($data->tbl_register_id);
                    $register->bpn_approve_st       = '0';
                    $register->bpn_approve_datetime = NULL;
                    $register->bpn_approve_by       = NULL;
                    $register->updated_by           = Auth::user()->user_id;
                    $register->save();

                    break;
                default:
                    # code...
                    break;
            }

            TblRegisterScan::destroy($id);

            DB::commit();

            return response()->json(['status' => 'ok'],200);
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
