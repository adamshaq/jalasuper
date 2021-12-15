@extends('layouts.app')

@section('content')
<style>
.editable-cell{
    background-color : #ebae34
}
</style>
	<!-- Basic datatable -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">Data Jenis Register</h5>
			<div class="header-elements">
				<div class="list-icons">
					<a class="list-icons-item" data-action="reload" id="reload-table"></a>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div id="bagian-tabel">
                <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i> Tambah </button>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-float">
                            <input name="search_param" id="search_param" placeholder="Pencarian Berdasarkan Nama" class="form-control"  data-fouc />
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
					<table class="table datatable-pagination" id="tabel-data">
						<thead>
							<tr>
								<th width="15%" id="tbl_jenis_register_id_table">Kode Jenis Register</th>
                                <th width="25%" id="jenis_register_nm_table">Nama Jenis Register</th>
                                <th width="" id="jenis_register_tp_table">jenis_register_tp_table</th>
                                <th width="" id="jenis_register_tp_nm_table">jenis_register_tp_nm_table</th>
                                <th width="10%" id="duration_table">Durasi</th>
                                <th width="10%" id="warning_table">Warning</th>
                                <th width="" id="notification_tp_table">notification_tp_table</th>
                                <th width="15%" id="notification_tp_nm_table">Jenis Notifikasi</th>
                                <th width="15%" id="actions_table"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
            </div>
            
			<div id="bagian-form">
				<form class="form-validate-jquerys" id="form-isian" action="#">
                    @csrf
                    <input type="hidden" name="tbl_jenis_register_id" />
					<div class="row">
						<div class="col-md-12">
							<div class="form-group form-group-float">
								<label class="form-group-float-label is-visible">Nama Jenis Register</label>
								<input type="text" name="jenis_register_nm" class="form-control"  required="" placeholder="" aria-invalid="false" />
							</div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Durasi Penyelesaian Register</label>
                                <input type="number" name="duration" class="form-control"  required="" placeholder="" aria-invalid="false" value="365" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Notifikasi Penyelesaian Register</label>
                                <select name="notification_tp" data-placeholder="pilih salah satu" class="form-control form-control-select2 select-search" data-fouc>
                                    {!! comCodeOptions('NOTIFICATION_TP') !!}
                                </select>
                            </div>
                        </div>
                    </div>
					<div id="div-buttons" class="d-flex justify-content-end align-items-center">
						<button type="reset" class="btn btn-light legitRipple" id="reset">Kembali <i class="icon-reload-alt ml-2"></i></button>
						<button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan Data <i class="icon-floppy-disks ml-2"></i></button>
					</div>
				</form>
            </div>
		</div>
	</div>


@endsection
@push('scripts')
<script>
    var tabelData;
    var tabelDataCompany;
    var saveMethod = 'tambah';
    var groupColumn = 3;

    $(document).ready(function(){
        $('#bagian-form').hide();
        $('#bagian-tabel').show();

		tabelData = $('#tabel-data').DataTable({
            processing	: true, 
            serverSide	: true, 
            ajax		: {
                url: "{{ url('/data-master/jenis-register/data') }}",
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
            columns: [
                { data: 'tbl_jenis_register_id', name:'tbl_jenis_register_id', visible:false},
                { data: 'jenis_register_nm', name:'jenis_register_nm', visible:true},
                { data: 'jenis_register_tp', name:'jenis_register_tp', visible:false},
                { data: 'jenis_register_tp_nm', name:'jenis_register_tp_nm', visible:false},
                { data: 'duration', name : 'duration', visible:true},
                { data: 'warning', name : 'warning', visible:true},
                { data: 'notification_tp', name : 'notification_tp', visible:false},
                { data: 'notification_tp_nm', name : 'notification_tp_nm', visible:true},
                { data: 'actions', name: 'actions', visible:true}
            ],
            order       : [[ groupColumn, 'asc'], [1, 'asc']], 
        });

        
        $(document).on('change', 'select[name=jenis_register_tp_param]',function(){ 
            tabelData.column('#jenis_register_tp_table').search($(this).val()).draw();
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#jenis_register_nm_table').search($(this).val()).draw();
        });

		$('#reload-table').click(function()   {
			tabelData.ajax.reload();
		});

        $('#tambah').click(function()   {
            saveMethod = 'tambah';
            $('input').prop("readonly",false);
			$('#bagian-form').show();
            $('#bagian-tabel').hide();
		});

        $('#reset').click(function()   {
            saveMethod = 'tambah';
            $('input').prop("readonly",false);
            tabelData.ajax.reload();
			$('#bagian-form').hide();
            $('#bagian-tabel').show();
		});

		/* submit form */
        $('#form-isian').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();
                var record=$('#form-isian').serialize();

                if(saveMethod == 'tambah'){
                    var url     = '{{ url("/data-master/jenis-register/") }}';
                    var method  = 'POST';
                }else{
                    var url     = '{{ url("/data-master/jenis-register/") }}'+'/'+dataCd;
                    var method  = 'PUT';
                }

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

        /* ubah */
        $(document).on('click', '#ubah',function(){ 
            saveMethod  = 'ubah';
            var rowData = tabelData.row($(this).parents('tr')).data();
            dataCd      = rowData['tbl_jenis_register_id'];

            $('input[name=tbl_jenis_register_id]').val(rowData['tbl_jenis_register_id']).prop("readonly",true);
            $('input[name=jenis_register_nm]').val(rowData['jenis_register_nm']);
            $('input[name=duration]').val(rowData['duration']);
            $('select[name=notification_tp]').val(rowData['notification_tp']).trigger('change');

            $('#bagian-form').show();
            $('#bagian-tabel').hide();
        });

        /* hapus data */
        $(document).on('click', '#hapus',function(){    
            var rowData=tabelData.row($(this).parents('tr')).data();
            dataCd = rowData['tbl_jenis_register_id'];
            
            swal({
                title             : "Hapus Data?",
                type              : "question",
                showCancelButton  : true,
                confirmButtonColor: "#00a65a",
                confirmButtonText : "Ya",
                cancelButtonText  : "Batal",
                allowOutsideClick : false,
            }).then(function(result){
                if(result.value){
                    swal({allowOutsideClick : false, title: "Menghapus Data",onOpen: () => {swal.showLoading();}});
                    
                    $.ajax({
                        url : '{{ url("/data-master/jenis-register/") }}'+'/'+dataCd,
                        type: "DELETE",
                        dataType: "JSON",
                        data: {
                            '_token': $('input[name=_token]').val(),
                        },
                        success: function(response)
                        {
                            if (response.status == 'ok') {
                                swal({
                                    title: "Berhasil",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    tabelData.ajax.reload();
                                    swal.close();
                                });
                            }else{
                                swal({title: "Data Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            swal({title: "Terjadi Kesalahan Sistem!", text:"Silakan Hubungi Administrator", type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                        }
                    })
                }else {
                    swal.close();
                }
            });
        });
	});
</script>
@endpush
