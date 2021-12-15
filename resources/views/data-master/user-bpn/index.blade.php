@extends('layouts.app')

@section('content')

	<!-- Dashboard content -->
	<div class="row">
		<div class="col-xl-12">
            <div class="card" style="zoom: 1;">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Data User</h5>
                </div>

                <div class="card-body">
                    <div id="bagian-tabel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Nama User</label>
                                    <input name="search_param" id="search_param" placeholder="Pencarian Berdasarkan Nama" class="form-control" data-fouc />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Jenis User</label>
                                    <select name="user_tp_param" data-placeholder="pilih salah satu" class="form-control form-control-select2 select-search" required data-fouc>
                                        <option value="USER_TP_2">Administrator</option>
                                        <option value="USER_TP_3">Pegawai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">BPN</label>
                                    <select name="tbl_company_id_param" data-placeholder="pilih salah satu" class="form-control form-control-select2 select-search" required data-fouc>
                                        @foreach ($companies as $item)
                                            <option value="{{ $item->tbl_company_id }}">{{ $item->company_nm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i> Tambah</button>
                        <div class="table-responsive">
                            <table class="table datatable-pagination" id="tabel-data">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th id="user_nm_table">Nama User</th>
                                        <th id="user_tp_table">Jenis User ID</th>
                                        <th>Jenis User</th>
                                        <th id="tbl_company_id_table">BPN ID</th>
                                        <th>BPN</th>
                                        <th class="text-center" width="15%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="bagian-form">
                        <form class="form-validate-jquery" id="form-isian" action="#">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">User ID</label>
                                        <input type="text" name="user_id" class="form-control" id="user_id" required placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Nama User</label>
                                        <input type="text" name="user_nm" class="form-control" required="" placeholder="" aria-invalid="false">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Kata Sandi</label>
                                        <input type="password" name="password" id="password" class="form-control" required placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Ulangi Kata Sandi</label>
                                        <input type="password" name="repeat_password" class="form-control" required placeholder="">
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->user_tp == 'USER_TP_1')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Jenis User</label>
                                        <select name="user_tp" data-placeholder="pilih salah satu" class="form-control form-control-select2 select-search" required data-fouc>
                                            <option value="USER_TP_2">Administrator BPN</option>
                                            <option value="USER_TP_3">Pegawai</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">BPN</label>
                                        <select name="tbl_company_id" data-placeholder="pilih salah satu" class="form-control form-control-select2 select-search" required data-fouc>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->tbl_company_id }}">{{ $item->company_nm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="reset" class="btn btn-light legitRipple" id="reset">Kembali <i class="icon-reload-alt ml-2"></i></button>
                                <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan Data <i class="icon-floppy-disks ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
	</div>
@endsection
@push('scripts')
<script>
    var tabelData;

    $(document).ready(function(){
        $('#bagian-form').hide();  

        tabelData = $('#tabel-data').DataTable({
            serverSide	: true, 
			processing	: true, 
            order		: [[4,'ASC']], 
            ajax		: {
                url: "{{ url('data-master/user-bpn/data') }}",
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
            columns: [
                { data: 'user_id', name: 'user_id', visible:true },
                { data: 'user_nm', name: 'user_nm' },
                { data: 'user_tp', name: 'user_tp', visible:false  },
                { data: 'user_tp_nm', name: 'user_tp_nm'},
                { data: 'tbl_company_id', name: 'tbl_company_id', visible:false  },
                { data: 'company_nm', name: 'company_nm'},
                { data: 'actions', name: 'actions' }
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#user_nm_table').search($(this).val()).draw();
        });

        $(document).on('change', 'select[name=user_tp_param]',function(){ 
            tabelData.column('#user_tp_table').search($(this).val()).draw();
        });

        $(document).on('change', 'select[name=tbl_company_id_param]',function(){ 
            tabelData.column('#tbl_company_id_table').search($(this).val()).draw();
        });

        /* tambah data */
        $('#tambah').click(function()   {
            saveMethod  ='tambah';

            $('input[name=user_nm]').focus();
            $('#bagian-tabel').hide();      
            $('#bagian-form').show(); 
            $('.card-title').text('Tambah Data');       
        });

        /* tambah data */
        $('#reset').click(function()   {
            saveMethod  ='';

            $('select[name=user_tp]').val('').trigger('change');
            $('#bagian-tabel').show();      
            $('#bagian-form').hide(); 
            tabelData.ajax.reload();
            $('.card-title').text('Data User');       
        });

        /* profil */
        $(document).on('click', '#profil',function(){ 
            var rowData=tabelData.row($(this).parents('tr')).data();
            dataCd = rowData['user_id'];

            window.location = '/data-master/user-bpn/profil/'+dataCd;
        });

        /* submit form */
        $('#form-isian').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();
                var record  = $('#form-isian').serialize();
                var url     = '{{ url("/data-master/user-bpn/") }}';
                var method  = 'POST';

                swal({
                    title               : 'Simpan Data?',
                    type                : "question",
                    showCancelButton    : true,
                    confirmButtonColor  : "#00a65a",
                    confirmButtonText   : "Ya",
                    cancelButtonText    : "Batalkan",
                    allowOutsideClick : false,
                }).then(function(result){
                    if(result.value){
                        swal({allowOutsideClick : false,title: "Menyimpan Data",onOpen: () => {swal.showLoading();}});

                        $.ajax({
                            'type': method,
                            'url' : url,
                            'data': record,
                            'dataType': 'JSON',
                            'success': function(response){
                                if(response["status"] == 'ok') {     
                                    swal({
                                        title: "Berhasil",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then(() => {
                                        $('#reset').click();
                                        swal.close();
                                    });
                                }else{
                                    swal({title: "Data Gagal Disimpan",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                }
                            },
                            'error': function(response){ 
                                var errorText = '';
                                $.each(response.responseJSON.errors, function(key, value) {
                                    errorText += value+'<br>'
                                });

                                swal({
                                    title             : response.status+':'+response.responseJSON.message,
                                    type              : "error",
                                    html              : errorText, 
                                    showCancelButton  : false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText : "Mengerti",
                                    cancelButtonText  : "Tidak",
                                }).then(function(result){
                                    if(result.value){   	
                                        reset('ubah');
                                    }
                                });  
                            }
                        });
                    }
                });
            }
        });
    });
</script>
@endpush