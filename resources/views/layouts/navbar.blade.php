<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark fixed-top">
    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a href="/" class="d-inline-block">
                    <img src="/images/atlas.png" class="img-fluid" width="150" height="150" alt="" style="background:#fff;padding:3px">
                </a>
            </li>
        </ul>
        <span class="navbar-text ml-md-3 mr-md-auto">
            <i class="icon-user-check mr-2"></i>
            Login sebagai {{ Auth::user()->user_nm }}
        </span>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ url('/messages') }}" class="navbar-nav-link legitRipple">
                    <i class="icon-envelop2 mr-2"></i>
                    Catatan Pemohon
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-pulse2 mr-2"></i>
                    Laporan
                </a>
                
                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                    {{-- <div class="dropdown-content-header">
                        <span class="font-size-sm line-height-sm text-uppercase font-weight-semibold"></span>
                        <a href="#" class="text-default"><i class="icon-search4 font-size-base"></i></a>
                    </div> --}}

                    <div class="dropdown-content-body dropdown-scrollable">
                        <ul class="media-list">
                            <li class="media" onclick="window.location='/laporan/monitoring-scan-dokumen'">
                                <div class="mr-3">
                                    <a href="#" class="btn bg-teal-400 rounded-round btn-icon"><i class="icon-qrcode"></i></a>
                                </div>

                                <div class="media-body">
                                    <h5 class="">Monitoring Scan Dokumen</h5>
                                </div>
                            </li>
                            <li class="media" onclick="window.location='/laporan/laporan-pencarian'">
                                <div class="mr-3">
                                    <a href="#" class="btn bg-pink-400 rounded-round btn-icon"><i class="icon-pie5"></i></a>
                                </div>

                                <div class="media-body">
                                    <h5 class="">Statistik Surat</h5>
                                </div>
                            </li>

                            <li class="media" onclick="window.location='/laporan/list-notifikasi'">
                                <div class="mr-3">
                                    <a href="#" class="btn bg-success-400 rounded-round btn-icon"><i class="icon-file-excel"></i></a>
                                </div>
                                
                                <div class="media-body">
                                    <h5 class="">List Notifikasi</h5>
                                </div>
                            </li>

                            <li class="media" onclick="window.location='/laporan/laporan-durasi-pelayanan'">
                                <div class="mr-3">
                                    <a href="#" class="btn bg-purple-400 rounded-round btn-icon"><i class="icon-hour-glass2"></i></a>
                                </div>
                                
                                <div class="media-body">
                                    <h5 class="">Laporan Durasi Pelayanan</h5>
                                </div>
                            </li>

                            {{-- <li class="media" onclick="window.location='/messages'">
                                <div class="mr-3">
                                    <a href="#" class="btn bg-blue rounded-round btn-icon"><i class="icon-envelop2"></i></a>
                                </div>
                                
                                <div class="media-body">
                                    <h5 class="">Catatan Pemohon</h5>
                                </div>
                            </li> --}}
    
                        </ul>
                    </div>
                </div>
            </li>
            
            {{-- <li class="nav-item">
                <a href="/laporan-pencarian" class="navbar-nav-link legitRipple">
                    <i class="icon-pie5 mr-2"></i>
                    Statistik Surat
                </a>
            </li>
            <li class="nav-item">
                <a href="/list-notifikasi" class="navbar-nav-link legitRipple">
                    <i class="icon-file-excel mr-2"></i>
                    List Notifikasi
                </a>
            </li>
            <li class="nav-item">
                <a href="/messages" class="navbar-nav-link legitRipple">
                    <i class="icon-envelop2 mr-2"></i>
                    Catatan Pemohon
                    <span class="badge badge-light badge-pill" id="belum-baca">{{ belumBaca() }}</span>
                </a>
            </li> --}}

            @if (Auth::user()->user_tp != 'USER_TP_3')  
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon-make-group mr-2"></i>
                    Data BPN
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                    <div class="dropdown-content-body p-2">
                        <div class="row no-gutters">
                            @if (config('app.multi_kpp') && Auth::user()->user_tp == 'USER_TP_1')    
                            <div class="col-12 col-sm-4">
                                <a href="/data-master/company-bpn/" class="d-block text-default text-center ripple-dark rounded p-3 legitRipple">
                                    <i class="icon-office text-blue-400 icon-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Kantor BPN</div>
                                </a>
                            </div>
                            @endif
                            
                            @if (in_array(Auth::user()->user_tp, ['USER_TP_1', 'USER_TP_2']))
                            <div class="col-12 col-sm-4">
                                <a href="/data-master/user-bpn" class="d-block text-default text-center ripple-dark rounded p-3 legitRipple">
                                    <i class="icon-users text-blue-400 icon-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">User BPN</div>
                                </a>                               
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon-make-group mr-2"></i>
                    Data KPP
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                    <div class="dropdown-content-body p-2">
                        <div class="row no-gutters">
                            @if (config('app.multi_kpp') && Auth::user()->user_tp == 'USER_TP_1')    
                            <div class="col-12 col-sm-4">
                                <a href="/data-master/company/" class="d-block text-default text-center ripple-dark rounded p-3 legitRipple">
                                    <i class="icon-office text-blue-400 icon-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">KPP</div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-4">
                                <a href="/data-master/company-bpn/" class="d-block text-default text-center ripple-dark rounded p-3 legitRipple">
                                    <i class="icon-office text-blue-400 icon-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Kantor BPN</div>
                                </a>
                            </div>
                            @endif
                            
                            @if (Auth::user()->user_tp == 'USER_TP_1')
                            <div class="col-12 col-sm-4">
                                <a href="/data-master/jenis-register" class="d-block text-default text-center ripple-dark rounded p-3 legitRipple">
                                    <i class="icon-envelop2 text-blue-400 icon-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Jenis Register</div>
                                </a>                               
                            </div>
                            @endif
                            
                            @if (in_array(Auth::user()->user_tp, ['USER_TP_1', 'USER_TP_2']))
                            <div class="col-12 col-sm-4">
                                <a href="/data-master/user" class="d-block text-default text-center ripple-dark rounded p-3 legitRipple">
                                    <i class="icon-users text-blue-400 icon-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">User</div>
                                </a>                               
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
            @endif
            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown">
                    <span>{{ Auth::user()->user_nm }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="/ubah/kata/sandi" class="dropdown-item"><i class="icon-key"></i> Ubah Kata Sandi</a>
                    <a href="#" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="icon-switch2" ></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->