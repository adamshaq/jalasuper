<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\VwRegister;
use App\Models\TblRegister;
use App\Models\VwNotifikasi;

class NotificationController extends Controller
{
    function index(Request $request)
    {
        $registers = VwRegister::where(function($query) {
                            $query->whereRaw(DB::Raw("date_format(datetime_done,'%Y-%m-%d') = '".date('Y-m-d')."'"))
                                ->orWhere('notification_st', '=', '0');
                        })
                        ->get();

        foreach ($registers as $item) {
            if ($item->notification_st == '0') {
                switch ($item->notification_tp) {
                    case 'NOTIFICATION_TP_1':
                        $teks   = "Yth $item->wajib_pajak , Permohonan Anda No $item->no_surat tanggal $item->datetime_input_format $item->proses_st_nm";
                        $sms    = urlencode($teks);
                        $oth    = "&outhkey=$item->notif_token_1"; 
                        $sec    = "&secret=$item->notif_token_2"; 
                        $pesan  = "&pesan=$sms"; 
                        $tujuan = "&to=$item->phone"; 
    
                        $url = $item->notif_url.$oth.$sec.$pesan.$tujuan;
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
                        curl_setopt($curl, CURLOPT_URL, $url);
                        $results = curl_exec($curl);
                        curl_close($curl);
                        $hasil=explode("|",$results);
                        
                        if(strtolower($hasil[0])=='success'){
                            $update                     = TblRegister::find($item->tbl_register_id);
                            $update->notification_st    = '1';
                            $update->updated_by         = 'SCHEDULER';
                            $update->save();
                        }

                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
        }

        return "DONE";
    }
}
