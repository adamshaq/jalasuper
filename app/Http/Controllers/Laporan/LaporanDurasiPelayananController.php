<?php

namespace App\Http\Controllers\Laporan;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\VwRegister;
use App\Models\TblJenisRegister;

class LaporanDurasiPelayananController extends Controller
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
        $title          = "Laporan Durasi Pelayanan";
        $jenisRegister  = TblJenisRegister::all();
        return view('laporan.laporan-durasi-pelayanan', compact('title','jenisRegister'));
    }

    function getData(Request $request){
        $tblCompanyId = Auth::user()->tbl_company_id;
       
        $data         = VwRegister::whereRaw("coalesce(tbl_company_id, '') = '$tblCompanyId'")
                        ->select(
                            "tbl_register_id",
                            "jenis_register",
                            "no_surat",
                            "wajib_pajak",
                            "datetime_input",
                            "datetime_done",
                            "durasi_penyelesaian"
                        )
                        ->whereIn('proses_st',['PROSES_ST_2','PROSES_ST_3'])
                        ;

        $splitTanggal = explode("-",$request->tanggal);

        if ($request->tanggal) {
            $tanggalStart  = formatDate($splitTanggal[0]);
            $tanggalEnd    = formatDate($splitTanggal[1]);

            $data->whereRaw("date_format(datetime_input, '%Y-%m-%d') between '$tanggalStart' and '$tanggalEnd'");
        }else{
            $tanggalStart    = date('Y-m-d');
            $data->whereRaw("date_format(datetime_input, '%Y-%m-%d') between '$tanggalStart' and '$tanggalStart'");
        }

        if ($request->jenis_register) {
            $data->where('jenis_register',$request->jenis_register);
        }

        return DataTables::of($data)
        ->make(true);
    }
}
