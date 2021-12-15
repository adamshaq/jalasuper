<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Models\TblRegister;
use App\Models\VwRegister;
use App\Models\VwNotifikasi;
use App\Models\TblJenisRegister;
use App\Models\TblCompany;
use App\Models\TblLogPencarian;
use App\Models\TblMessage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function index(Request $request){
        if (Auth::check()) {
            $id     = $request->get('tipe');
            $status = $request->get('status');

            if ($id) {
                $title              = "Data Register $id";
                $jenisRegister      = TblJenisRegister::all();
                return view('register', compact('title', 'jenisRegister', 'id', 'status'));
            }else{
                $title              = "Data Register";
                $jenisRegister      = TblJenisRegister::all();
                return view('home', compact('title', 'jenisRegister'));
            }
        } else {
            $title      = config('app.name');
            $company    = TblCompany::orderBy('company_nm')->get();
            return view('home-not-login', compact('title', 'company'));
        }
    }

    function cari(Request $request){   
        $surat = VwRegister::where('no_surat',$request->id)
                ->where('wajib_pajak','LIKE',"%$request->name%")
                ->first();

        if ($surat) {
            $pencarian                   = new TblLogPencarian;
            $pencarian->search_param     = $request->id;
            $pencarian->jenis_register   = $surat->jenis_register;
            $pencarian->tbl_company_id   = $surat->tbl_company_id;
            $pencarian->created_by       = 'GUEST';
            $pencarian->save();

            $status = TRUE;
            $pesan = TblMessage::where('tbl_register_id', $surat->tbl_register_id)->orderBy('created_at')->get();
            return redirect()->back()->with(['success' => $surat, 'pesan' => $pesan]);
        }else{
            $pencarian                   = new TblLogPencarian;
            $pencarian->search_param     = $request->id;
            $pencarian->jenis_register   = 'TIDAK DITEMUKAN';
            $pencarian->tbl_company_id   = 'TIDAK DITEMUKAN';
            $pencarian->created_by       = 'GUEST';
            $pencarian->save();

            $status = FALSE;
            return redirect()->back()->with(['error' => 'tidak ditemukan']);
        }
    }

    function kirimPesan($id, Request $request){
        DB::transaction(function () use($request, $id) {
            $register                   = TblRegister::find($id);
            $register->updated_by       = $register->wajib_pajak;
            $register->pemohon_note     = $request->pemohon_note;
            $register->pemohon_note_st  = '0';
            $register->save();

            $message                  = new TblMessage;
            $message->tbl_register_id = $register->tbl_register_id;
            $message->sender          = $register->wajib_pajak;
            $message->sender_tp       = 'WP';
            $message->message         = $request->pemohon_note;
            $message->created_by      = $register->wajib_pajak;
            $message->save();
        });
        $surat = VwRegister::find($id);
        $pesan = TblMessage::where('tbl_register_id', $surat->tbl_register_id)->orderBy('created_at')->get();
        return redirect()->back()->with(['success' => $surat, 'pesan'=>$pesan, 'successSave'=>'ok']);
    }

    function getData(Request $request){
        $tblCompanyId = Auth::user()->tbl_company_id;
        $status       = strtoupper($request->status);
        $data         = VwRegister::whereRaw("coalesce(tbl_company_id, '') = '$tblCompanyId'")
                        ;
        if ($status != 'TOTAL') {
            $data->where('status',$status);
        }

        if ($request->has('tipe')) {
            $data->where('jenis_register',$request->tipe);
        }
        
        return DataTables::of($data)
        ->addColumn('list_data',function($data){
            $status = 'home';
            return view('template.register', compact('data', 'status'))->render();
        })
        ->rawColumns(['list_data'])
        ->make(true);
    }

    function initialData(Request $request){
        $tblCompanyId       = Auth::user()->tbl_company_id;
        $tipe               = $request->get('tipe');
        
        if($tipe){
            $data = VwNotifikasi::whereRaw("coalesce(tbl_company_id, '') = '$tblCompanyId'")
                    ->whereRaw("coalesce(jenis_register_nm, '') = '$tipe'")   
                    ->first();

        }else{
            $data = VwNotifikasi::whereRaw("coalesce(tbl_company_id, '') = '$tblCompanyId'")
                    ->select(
                        DB::Raw("sum(total) as total"),
                        DB::Raw("sum(total_belum_proses) as total_belum_proses"),
                        DB::Raw("sum(total_mendesak) as total_mendesak"),
                        DB::Raw("sum(total_selesai) as total_selesai")
                    )
                    ->first();
        }

        return response()->json([
                    'status'                => 'ok', 
                    'registerAll'           => $data ? number_format($data->total, 0, ".", ".") : 0,
                    'registerBelumSelesai'  => $data ? number_format($data->total_belum_proses , 0, ".", ".") : 0,
                    'registerMendesak'      => $data ? number_format($data->total_mendesak , 0, ".", ".") : 0,
                    'registerDone'          => $data ? number_format($data->total_selesai , 0, ".", ".") : 0,
                ],200);
    }

    function getDataNotifikasi(Request $request){
        $tblCompanyId = Auth::user()->tbl_company_id;
        $data         = VwNotifikasi::whereRaw("coalesce(tbl_company_id, '') = '$tblCompanyId'");

        return DataTables::of($data)
        ->addColumn('list_data',function($data){
            return view('template.notifikasi', compact('data'))->render();
        })
        ->rawColumns(['list_data'])
        ->make(true);
    }
}
