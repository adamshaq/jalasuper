<div class="card border-left-3 border-left-success-400 rounded-left-0">
    <div class="card-body">
        <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
            <div>
                <h6><b>{{ $data->wajib_pajak }}</b></h6>
                <p class="">{{ $data->no_surat }}</p>
                <p class="">{{ $data->jenis_register }}</p>
                <p class="">{{ $data->note }}</p>
                <p class="">Tanggal Masuk : {{ tgl_indo($data->datetime_input) }}</p>
                @if ($data->proses_st == 'PROSES_ST_3')
                <p class=""> <b>Telah diteruskan ke kanwil {{ $data->info_02 }}</b> </p>
                @endif

            </div>

            <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto">
                @if ($data->proses_st == 'PROSES_ST_1')
                <li>Prioritas: &nbsp; 
                    @if ($data->running >= $data->warning)
                        <span class="badge badge-danger">Mendesak</span>                   
                    @else
                        <span class="badge badge-success">Normal</span>
                    @endif
                </li>
                @else
                <li>Tanggal Selesai: &nbsp;{{ tgl_indo($data->datetime_done) }} </li>
                <li>Diselesaikan Oleh: &nbsp;{{ $data->done_by }} </li>
                <li>
                    @if (Auth::user()->user_tp != 'USER_TP_3')
                    <button type='button' id='ubah-tanggal-selesai' data-tbl_register_id="{{ $data->tbl_register_id }}" data-datetime_done="{{ toViewDate($data->datetime_done) }}" class='btn btn-warning btn-sm ml-1 legitRipple'><i class='icon-pencil7'></i> Ubah Tanggal Register Selesai </button>
                    @endif
                </li>
                @endif
            </ul>
        </div>
        @if ($data->pemohon_note != NULL)
            <div class="alert alert-primary alert-dismissible" width="100%">
                <span class="font-weight-semibold">{{$data->pemohon_note}}</span>
            </div>
        @endif
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <span>Tenggat Waktu: <span class="font-weight-semibold">{{ tgl_indo($data->datetime_deadline) }}</span></span>
            </div>
            <div class="col-md-6">
                @if ($status == 'catatan')
                <div class="d-flex justify-content-end align-items-center">
                    <button type='button' id='balas' data-tbl_register_id="{{ $data->tbl_register_id }}" data-notification_tp="{{ $data->notification_tp }}" class='btn btn-info btn-sm ml-1 legitRipple'><i class='icon-reply'></i>  Balas </button>
                </div>  
                @else    
                <div class="d-flex justify-content-end align-items-center">
                    @if (in_array($data->proses_st,['PROSES_ST_1','PROSES_ST_9']))
                        <button type='button' id='hapus' data-tbl_register_id="{{ $data->tbl_register_id }}" class='btn btn-danger btn-sm legitRipple'><i class='icon-trash'></i> Hapus Register </button>
                        <button type='button' id='kanwil' data-tbl_register_id="{{ $data->tbl_register_id }}" data-notification_tp="{{ $data->notification_tp }}" class='btn btn-primary btn-sm ml-1 legitRipple'><i class='icon-forward'></i> Teruskan Ke Kanwil </button>
                        <button type='button' id='selesai' data-tbl_register_id="{{ $data->tbl_register_id }}" data-notification_tp="{{ $data->notification_tp }}" class='btn btn-info btn-sm ml-1 legitRipple'><i class='icon-check'></i> Selesaikan Register </button>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>