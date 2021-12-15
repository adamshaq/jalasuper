<?php

namespace App\Http\Controllers\Laporan;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TblCompany;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NotifikasiExport;

class ListNotifikasiController extends Controller
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
        $title      = "List Notifikasi";
        $company    = TblCompany::all();
        return view('laporan.list-notifikasi', compact('title', 'company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $tanggal          = $request->tanggal;
        $tanggalFormatter = str_replace('/','',$request->tanggal);
        return Excel::download(new NotifikasiExport($tanggal), "notifikasi-$tanggalFormatter.xlsx");
    }
}
