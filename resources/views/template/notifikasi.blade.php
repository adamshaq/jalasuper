<!-- notifikasi -->
<div class="card border-left-3 border-left-success-400 rounded-left-0">
    <div class="card-body">
        <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
            <div>
                <h6>{{ $data->jenis_register_nm }}</h6>
            </div>
        </div>
         <!-- Quick stats boxes -->
         <div class="row">
            <div class="col-xl-3">
                <div class="card bg-teal card-notifikasi" data-status="total" data-jenis_register="{{ $data->jenis_register_nm }}">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="font-weight-semibold mb-0" id="register-mendesak">
                                <i class="icon-files-empty2"></i> {{ number_format($data->total , 0, ".", ".")}}
                            </h2>
                        </div>
                        <div>
                            Total Register
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-warning card-notifikasi" data-status="belum" data-jenis_register="{{ $data->jenis_register_nm }}">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="font-weight-semibold mb-0" id="register-total">
                                <i class="icon-file-minus2"></i> {{ number_format($data->total_belum_proses , 0, ".", ".")}}
                            </h2>
                        </div>
                        <div>
                            Total Belum Proses
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-danger card-notifikasi" data-status="mendesak" data-jenis_register="{{ $data->jenis_register_nm }}">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="font-weight-semibold mb-0" id="register-total">
                                <i class="icon-file-minus2"></i> {{ number_format($data->total_mendesak , 0, ".", ".")}}
                            </h2>
                        </div>
                        <div>
                            Total Register Mendesak
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-blue card-notifikasi" data-status="selesai" data-jenis_register="{{ $data->jenis_register_nm }}">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="font-weight-semibold mb-0" id="register-selesai">
                                <i class="icon-file-check"></i> {{ number_format($data->total_selesai , 0, ".", ".")}}
                            </h2>
                        </div>
                        <div>
                            Total Register Selesai
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /quick stats boxes -->
    </div>
</div>