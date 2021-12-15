<?php

namespace App\Http\Controllers\Laporan;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TblLogPencarian;

class LaporanPencarianController extends Controller
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
        $title      = "Laporan Pencarian";
        return view('laporan.laporan-pencarian', compact('title'));
    }

    function getData(Request $request){
        $tblCompanyId = Auth::user()->tbl_company_id;
       
        $data         = TblLogPencarian::whereRaw("coalesce(tbl_company_id, '') = '$tblCompanyId'")
                        ->select("jenis_register",DB::Raw("count(jenis_register) as jumlah"))
                        ->groupBy("jenis_register");

        $splitTanggal = explode("-",$request->tanggal);

        if ($request->tanggal) {
            $tanggalStart  = formatDate($splitTanggal[0]);
            $tanggalEnd    = formatDate($splitTanggal[1]);

            $data->whereRaw("date_format(created_at, '%Y-%m-%d') between '$tanggalStart' and '$tanggalEnd'");
        }else{
            $tanggalStart    = date('Y-m-d');
            $data->whereRaw("date_format(created_at, '%Y-%m-%d') between '$tanggalStart' and '$tanggalStart'");
        }

        return DataTables::of($data)
        ->make(true);
    }
}
