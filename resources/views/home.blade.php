@extends('layouts.app')

@section('content')
	<!-- Quick stats boxes -->
	<div class="row">
		<div class="col-xl-3">
			<!-- Members online -->
			<div class="card bg-teal-400">
				<div class="card-body">
					<div class="d-flex">
						<h2 class="font-weight-semibold mb-0" id="register-all">
							<i class='icon-spinner2 spinner'></i> 
						</h2>
					</div>
					<div>
						Total Register
					</div>
				</div>
				<div class="container-fluid">
				</div>
			</div>
		</div>

		<div class="col-xl-3">
			<div class="card bg-warning-400">
				<div class="card-body">
					<div class="d-flex">
						<h2 class="font-weight-semibold mb-0" id="register-belum-selesai">
							<i class='icon-spinner2 spinner'></i> 
						</h2>
					</div>
					<div>
						Total Register Belum Selesai
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3">
			<div class="card bg-danger-400">
				<div class="card-body">
					<div class="d-flex">
						<h2 class="font-weight-semibold mb-0" id="register-mendesak">
							<i class='icon-spinner2 spinner'></i> 
						</h2>
					</div>
					<div>
						Total Register Mendesak
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3">
			<div class="card bg-blue-400">
				<div class="card-body">
					<div class="d-flex">
						<h2 class="font-weight-semibold mb-0" id="register-done">
							<i class='icon-spinner2 spinner'></i> 
						</h2>
					</div>
					<div>
						Total Register Sudah Selesai
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /quick stats boxes -->

	<!-- daftar jumlah register-->
	<div class="card" id="card-notifikasi">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">Daftar Jumlah Register</h5>
			<div class="header-elements">
				<div class="list-icons">
					<a class="list-icons-item" data-action="reload" id="reload-table"></a>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="mb-10">
				@foreach (comCodeData('FILE_TP') as $item)	
				<form style="display: none;" class="form-upload" id="form-upload-{{ $item->com_cd }}" action="{{ url('upload') }}" method="POST" enctype="multipart/form-data" data-flag="0">
					@csrf
					<input type="hidden" name="tbl_company_id">
					<input type="hidden" name="file_tp" value="{{ $item->com_cd }}">
					<input type="file" name="berkas-register" id="berkas-register-{{ $item->com_cd }}">
				</form>
				<button type='button' data-file_tp="{{ $item->com_cd }}" class='upload btn btn-info btn-sm legitRipple'><i class='icon-upload'></i> Upload {{ $item->code_nm }}  </button>
				@endforeach
				<button type='button' id="permohonan-via-pos" class='btn btn-info btn-sm legitRipple'><i class='icon icon-add'></i> Input Permohonan via Pos </button>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group form-group-float">
						<label class="form-group-float-label is-visible">Nama Jenis Register</label>
						<input name="search_register_param" id="search_register_param" placeholder="Pencarian Berdasarkan Nama" class="form-control" data-fouc />
					</div>
				</div>
			</div>
			
			<div class="table-responsive">
				<table class="table datatable-pagination" id="tabel-data-notifikasi" width="100%">
					<thead style="display:none">
						<tr>
							<th width="35%" id="jenis_register_nm_table">Jenis Register</th>
							<th width="15%" id="total_table">Total Register</th>
							<th width="55%" id="total_mendesak_table">Total Register Mendesak</th>
							<th width="100%" id="list_data_table">Daftar Register</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Basic modal -->
	<div id="modal-permohonan" class="modal fade" tabindex="">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Tambah Permohonan via Pos</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<form class="form-validate-jquerys" id="form-permohonan" action="#">
						@csrf
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">No Surat/No Resi Pos</label>
									<input type="text" name="no_surat" class="form-control" required="" placeholder="" aria-invalid="false" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Jenis Register</label>
									<select name="jenis_register" id="jenis_register" class="form-control form-control-select2 select-search"  data-fouc>
										@foreach ($jenisRegister as $item)
											<option value="{{ $item->jenis_register_nm }}">{{ $item->jenis_register_nm }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Nama Pemohon</label>
									<input type="text" name="wajib_pajak" class="form-control" required="" placeholder="" aria-invalid="false" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Petugas Penerima</label>
									<input type="text" name="petugas_penerima" class="form-control" required="" placeholder="" aria-invalid="false" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Catatan</label>
									<textarea name="note" id="note" class="form-control"></textarea>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
					<button type="button" id="submit-item" class="btn bg-primary">Simpan <i class="icon-floppy-disk"></i> </button>
				</div>
			</div>
		</div>
	</div>
	<!-- /basic modal -->

@endsection
@push('scripts')
<script>
    var tabelDataNotifikasi;
	var fileTp;
	var baseUrl = "{{ url('/') }}"+"/";
	var saveMethod;

    $(document).ready(function(){
		// data notifikasi
		tabelDataNotifikasi = $('#tabel-data-notifikasi').DataTable({
			serverSide	: true, 
			processing	: true, 
            order		:[[2,'DESC']], 
            ajax		: {
                url: baseUrl+'notifikasi',
                type: "POST",
				data    : function(data){
                    data._token	= $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
				{ data: 'jenis_register_nm', name:'jenis_register_nm', visible:false},
				{ data: 'total', name:'total', visible:false},
				{ data: 'total_mendesak', name:'total_mendesak', visible:false},
                { data: 'list_data', name: 'list_data' }
            ],
		});

		$(document).on('keyup', '#search_register_param',function(){ 
            tabelDataNotifikasi.column('#jenis_register_nm_table').search($(this).val()).draw();
        });

		// upload
		$(document).on('click', '.upload',function(){ 
			fileTp = $(this).data('file_tp');
			$('#berkas-register-'+fileTp).click().change(function (e) {
				$('#form-upload-'+fileTp).submit();
			});
		});

		/* submit form */
		$('.form-upload').submit(function(e){
            $form = $(this).attr('id');
			$flag = $(this).attr('data-flag');
			
			if($flag == 0){
				e.preventDefault();
				swal({
					title: 'Kode Kantor?',
					input: 'text',
					inputPlaceholder: 'Kode Kantor',
					showCancelButton: true,
					inputClass: 'form-control',
					inputValidator: function (value) {
						return !value && 'Kode Kantor Tidak Boleh Kosong!'
					}
				}).then(function (result) {
					kodeKantor = result.value;
					if (result.value) {
						swal({
							title               : 'Unggah Berkas?',
							type                : 'question',
							showCancelButton    : true,
							confirmButtonColor  : "#00a65a",
							confirmButtonText   : "Ya",
							cancelButtonText    : "Batal",
							allowOutsideClick   : false,
						}).then(function(result) {
							if(result.value){
								swal({allowOutsideClick : false, title: "Mengunggah Berkas",onOpen: () => {swal.showLoading();}});

								$('#'+$form).find('input[name=tbl_company_id]').val(kodeKantor);
								$('#'+$form).attr('data-flag','1');
								$('#'+$form).submit();
							}
						});
					}
				});
			}
			return true;
        });

		// permohonan via pos
		$(document).on('click', '#permohonan-via-pos',function(){ 
			$('#modal-permohonan').modal('show');
		});

		$('#submit-item').click(function()   {
            $('#form-permohonan').submit();
		});

		/* submit form */
        $('#form-permohonan').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();
                var record=$('#form-permohonan').serialize();

				var url     = baseUrl+'/permohonan-via-pos';
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
                                        $('#modal-permohonan').modal('hide');
										$('input[name=no_surat]').val('');
										$('input[name=wajib_pajak]').val('');
										$('select[name=jenis_register]').val('').trigger('change');
										$('textarea[name=note]').val('');
										tabelDataNotifikasi.ajax.reload();
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

		init();
	});

	function reset(params) {
		init();
		tabelData.ajax.reload();
	}

	function init() {
        $.getJSON(baseUrl+'initial/data', function(data){
            if (data['status'] == 'ok') {
                $('#register-all').empty().append('<i class="icon-files-empty2"></i> '+data['registerAll']);
                $('#register-belum-selesai').empty().append('<i class="icon-file-minus2"></i> '+data['registerBelumSelesai']);
                $('#register-mendesak').empty().append('<i class="icon-file-minus2"></i> '+data['registerMendesak']);
                $('#register-done').empty().append('<i class="icon-file-check"></i> '+data['registerDone']);
            }
        });
	}
</script>
@endpush
