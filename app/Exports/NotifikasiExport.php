<?php

namespace App\Exports;

use Auth;
use App\Models\VwRegister;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NotifikasiExport implements FromView
{
    public function __construct(string $date)
    {
        $this->date = $date;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $splitTanggal = explode("-",$this->date);
        $tanggalStart  = formatDate($splitTanggal[0]);
        $tanggalEnd    = formatDate($splitTanggal[1]);

        return view('exports.notifikasi', [
            'registers' => VwRegister::whereRaw("DATE_FORMAT(datetime_done, '%d/%m/%Y') between '$tanggalStart' and '$tanggalEnd'")
                            ->where('proses_st','PROSES_ST_2')
                            ->where('tbl_company_id',Auth::user()->tbl_company_id)
                            ->get()
        ]);
    }
}
