<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('landing/js/app.js') }}"></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('landing/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
</head>
<style>
    .chat {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .chat li {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px dotted #B3A9A9;
    }

    .chat li .chat-message p {
        margin: 0;
        color: #777777;
    }

    .card-message {
        overflow-y: scroll;
        height: 350px;
        overflow: auto;
    }

    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #F5F5F5;
    }

    ::-webkit-scrollbar {
        width: 12px;
        background-color: #F5F5F5;
    }

    ::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
    }
</style>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- <img src="{{ asset('images/logo.png') }}" alt=""> --}}
                    <img src="{{ asset('images/atlas.png') }}" alt="" height="80px">
                    
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        {{-- {{ env('APP_NAME') }} <br> --}}
                        {{-- {{ env('APP_DESC') }} <br> --}}
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div class="card">
                        <div class="card-header">Silakan Masukan Nomor Bukti Penerimaan Surat {{session('data') }} </div>
                            <div class="card-body">
                                <form method="POST" action="/cari">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input id="id"  name="id" type="text" class="form-control" required autofocus placeholder="Nomor Bukti Penerimaan Surat atau No Resi Pos">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input id="name"  name="name" type="text" class="form-control" required autofocus placeholder="Nama Pemohon">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 offset-md-0">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Cek Status Surat') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                @if (session('success'))
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <table width="100%">
                                            @php $item = session('success') @endphp
                                            <tr>
                                                <td>
                                                    <div class="alert alert-info" role="alert">
                                                        Permohonan penjelasan hubungi no telepon {{ $item->company_phone }}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="100%">Hasil Pencarian:</th>
                                            </tr>
                                            <tr>
                                                <td width="100%">
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="25%">No Surat</td>
                                                            <td width="5%">:</td>
                                                            <td width="70%">{{ $item->no_surat }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="25%">Wajib Pajak</td>
                                                            <td width="5%">:</td>
                                                            <td width="70%">{{ $item->wajib_pajak }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="25%">Jenis Surat</td>
                                                            <td width="5%">:</td>
                                                            <td valign= width="70%">{{ $item->jenis_register }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="25%">Status Surat</td>
                                                            <td width="5%">:</td>
                                                            @if ($item->proses_st == 'PROSES_ST_3')
                                                            <td valign= width="70%">{{ $item->proses_st_nm.' '.$item->info_02 }}</td>
                                                            @else
                                                            <td valign= width="70%">{{ $item->proses_st_nm }}</td>
                                                            @endif
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <form method="POST" action="/pesan/{{ $item->tbl_register_id }}">
                                    @csrf
                                    @if (session('successSave'))
                                    <div class="alert alert-info" role="alert">
                                        Berhasil Kirim Pesan ke KPP
                                    </div>
                                    @endif
                                    <div class="card-message">
                                        <ul class="chat">
                                            <!-- DATA TERSEBUT BERUPA ARRAY YANG BERISI PESAN -->
                                            <!-- KITA LOOPING DATA TERSEBUT UNTUK MENAMPILKAN SEMUA ISI PESAN DAN PENGIRIM -->
                                            @if (session('pesan') )     
                                            @foreach (session('pesan') as $pesan)
                                            <li class="left clearfix">
                                                <div class="chat-body clearfix">
                                                    <div class="header">
                                                        <strong class="primary-font">
                                                            {{$pesan->sender}}
                                                        </strong>
                                                        {{ tgl_dan_jam($item->created_at) }}
                                                    </div>
                                                    <p>
                                                        {{$pesan->message}} 
                                                    </p>
                                                </div>
                                            </li>
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                        <textarea name="pemohon_note" id="pemohon_note" class="form-control" rows="3" placeholder="Silakan jika Anda ingin mengirimkan pesan ke KPP"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 offset-md-0">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Kirim Pesan Ke KPP') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @endif 

                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        Surat Tidak Ditemukan
                                    </div>
                                @endif
                                
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">KPP Pengguna</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <input id="param"  name="param" type="text" class="form-control">
                                </div>
                                <div>
                                    <table id="tabel-kpp" width="100%">
                                        <thead style="display:none">
                                            <tr>
                                                <th id="search" width="100%">data</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $i = 1;
                                        @endphp
                                        <tbody>
                                            @foreach ($company as $item)
                                                <tr>
                                                    <td>{{ $i.'. '.$item->company_nm }}</td>
                                                </tr>
                                                @php
                                                    $i ++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
var table;
$(document).ready( function () {
    table = $('#tabel-kpp').DataTable({
        language : {url : "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"},
        dom : 'tp',
        paging : false,
        order:false,
        scrollY : true
    });
} );

$('#param').on( 'keyup', function () {
    table.column('#search').search( this.value ).draw();
} );
</script>
</html>
