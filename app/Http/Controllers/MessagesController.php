<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Models\TblJenisRegister;
use App\Models\TblRegister;
use App\Models\VwRegister;
use App\Models\TblMessage;

class MessagesController extends Controller
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
    function index(Request $request, $id = NULL){
        if ($id) {
            $register  = VwRegister::find($id);
            $title     = "Catatan Pemohon $register->wajib_pajak";
            return view('messages.detail', compact('title', 'register'));
        }else{
            $jenisRegister  = TblJenisRegister::all();
            $title          = "Catatan Pemohon";
            return view('messages.index', compact('title', 'jenisRegister'));
        }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request, $id){
        $this->validate($request,[
            'message'        => 'required',
        ]);
        
        DB::transaction(function () use($request, $id) {
            $register                   = TblRegister::find($id);
            $register->updated_by       = $register->wajib_pajak;
            $register->pemohon_note     = $request->message;
            $register->pemohon_note_st  = '0';
            $register->save();

            $message                  = new TblMessage;
            $message->tbl_register_id = $id;
            $message->sender          = Auth::user()->user_nm;
            $message->sender_tp       = 'PETUGAS';
            $message->message         = $request->message;
            $message->created_by      = Auth::user()->user_id;
            $message->save();
        });

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $user = TblMessage::find($id);

        if($user){
            return response()->json(['status' => 'ok', 'data' => $user],200);
        }else{
            return response()->json(['status' => 'failed', 'data' => 'not found'],200);
        }
    }

    function getMessages($id){
        $messages = TblMessage::where('tbl_register_id',$id)->orderBy('created_at')->get();
        $template = view("messages.template", compact('messages'))->render();
        return response()->json(['status' => 'ok', 'template' => $template],200);
    }
}
