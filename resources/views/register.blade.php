@extends('layouts.app')

@section('content')
    <!-- Quick stats boxes -->
	<div class="row">
		<div class="col-xl-3">
			<!-- Members online -->
			<div class="card bg-teal card-notifikasi" data-status="total" data-jenis_register="{{ $id }}">
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
			<div class="card bg-warning card-notifikasi" data-status="belum" data-jenis_register="{{ $id }}">
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
			<div class="card bg-danger card-notifikasi" data-status="mendesak" data-jenis_register="{{ $id }}">
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
			<div class="card bg-blue card-notifikasi" data-status="selesai" data-jenis_register="{{ $id }}">
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

	<!-- data register -->
	<div class="card" id="card-register">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">Daftar Register</h5>
			<div class="header-elements">
				<div class="list-icons">
					<a class="list-icons-item" data-action="reload" id="reload-table"></a>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group form-group-float">
						<label class="form-group-float-label is-visible">Nama Wajib Pajak</label>
						<input name="search_param" id="search_param" placeholder="Pencarian Berdasarkan Nama" class="form-control" data-fouc />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group form-group-float">
						<label class="form-group-float-label is-visible">Jenis Register</label>
						<select name="jenis_register_nm_param" id="jenis_register_nm_param" class="form-control form-control-select2 select-search"  data-fouc>
							@foreach ($jenisRegister as $item)
								<option value="{{ $item->jenis_register_nm }}">{{ $item->jenis_register_nm }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
            <button type='button' id="kembali" class='btn btn-light btn-sm legitRipple'><i class='icon-reload-alt'></i> Kembali </button>
			<br>
			<br>
			<div class="table-responsive">
				<table class="table datatable-pagination" id="tabel-data" width="100%">
					<thead style="display: none">
						<tr>
							<th id="tbl_register_id_table">tbl_register_id_table</th>
							<th id="jenis_register_nm_table">jenis_register_nm_table</th>
							<th id="wajib_pajak_table">wajib_pajak_table</th>
							<th id="phone_table">phone_table</th>
							<th id="notification_tp_table">notification_tp_table</th>
							<th id="datetime_input_table">datetime_input_table</th>
							<th id="proses_st_table">proses_st_table</th>
							<th id="selisih_table">selisih_table</th>
							<th width="100%" id="list_data_table">Daftar Register</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- modal selesai -->
	<div id="modal-selesai" class="modal fade" tabindex="">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Selesaikan Register?</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<form class="form-validate-jquerys" id="form-selesai" action="#">
						@csrf
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Waktu Penyelesaian</label>
									<input type="text" name="datetime_done" class="form-control date-picker" placeholder="" aria-invalid="false" />
								</div>
							</div>
							<div class="col-md-6" id="div-phone" style="display:none">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">No Telepon Wajib Pajak</label>
									<input type="text" name="phone" class="form-control" required="" placeholder="" aria-invalid="false" />
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="modal-footer">
					<button type="reset" class="btn btn-light legitRipple" id="close-modal" data-dismiss="modal">Kembali <i class="icon-reload-alt ml-2"></i></button>
					<button type="button" id="selesaikan-register" class="btn btn-primary ml-3 legitRipple">Selesaikan Register <i class="icon-floppy-disks ml-2"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- /modal selesai-->

	<!-- modal teruskan -->
	<div id="modal-teruskan" class="modal fade" tabindex="">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Teruskan Register ke Kanwil?</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<form class="form-validate-jquerys" id="form-teruskan" action="#">
						@csrf
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Diteruskan Pada</label>
									<input type="text" name="datetime_done" class="form-control date-picker" placeholder="" aria-invalid="false" />
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="modal-footer">
					<button type="reset" class="btn btn-light legitRipple" id="close-modal" data-dismiss="modal">Kembali <i class="icon-reload-alt ml-2"></i></button>
					<button type="button" id="teruskan-register" class="btn btn-primary ml-3 legitRipple">Teruskan Register <i class="icon-floppy-disks ml-2"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- /modal selesai-->

	<!-- modal ubah tanggal selesai -->
	<div id="modal-ubah-tanggal-selesai" class="modal fade" tabindex="">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Ubah Tanggal Register Selesai?</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<form class="form-validate-jquerys" id="form-ubah-tanggal-selesai" action="#">
						@csrf
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Waktu Penyelesaian</label>
									<input type="text" name="change_datetime_done" class="form-control date-picker" placeholder="" aria-invalid="false" />
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="modal-footer">
					<button type="reset" class="btn btn-light legitRipple" id="close-modal" data-dismiss="modal">Kembali <i class="icon-reload-alt ml-2"></i></button>
					<button type="button" id="simpan-tanggal-register-selesai" class="btn btn-primary ml-3 legitRipple">Simpan Tanggal <i class="icon-floppy-disks ml-2"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- /modal ubah tanggal selesai-->


@endsection
@push('scripts')
<script>
	var tabelData;
	var dataCd;
	var fileTp;
	var baseUrl = "{{ url('/') }}"+"/";
	var saveMethod;
	var phone;
	var kodeKantor;
	var dateTimeDone;

    $(document).ready(function(){
		$('#jenis_register_nm_param').val("{{ $id }}").trigger('change');

		tabelData = $('#tabel-data').DataTable({
			serverSide	: true, 
			processing	: true, 
            order		:[[7,'ASC'],[5,'ASC'],[1,'ASC']], 
            ajax		: {
                url: baseUrl,
                type: "POST",
				data    : function(data){
                    data._token		= $('meta[name="csrf-token"]').attr('content'),
                    data.date_in	= $('input[name=date_in_param]').val();
                    data.tipe		= "{{ $id }}";
                    data.status		= "{{ $status }}";
                },
            },
            columns: [
				{ data: 'tbl_register_id', name:'tbl_register_id', visible:false},
				{ data: 'jenis_register_nm', name:'jenis_register_nm', visible:false},
				{ data: 'wajib_pajak', name:'wajib_pajak', visible:false},
				{ data: 'phone', name:'phone', visible:false},
				{ data: 'notification_tp', name:'notification_tp', visible:false},
				{ data: 'datetime_input', name:'datetime_input', visible:false},
				{ data: 'proses_st', name:'proses_st', visible:false},
				{ data: 'selisih', name:'selisih', visible:false},
                { data: 'list_data', name: 'list_data' }
            ],
		});

		$(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#wajib_pajak_table').search($(this).val()).draw();
        });

		$(document).on('change', '#jenis_register_nm_param',function(){ 
            tabelData.column('#jenis_register_nm_table').search($(this).val()).draw();
            init($(this).val());
        });

		$('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');
			$('select[name=upload_tp_param]').val('').trigger('change');

			tabelData.ajax.reload();
		});

		/* selesaikan register */

		$(document).on('click', '#selesai',function(){ 
			dataCd 			= $(this).data('tbl_register_id');
			var notificationTp 	= $(this).data('notification_tp');

			if (notificationTp == 'NOTIFICATION_TP_1') {
				$('#div-phone').show();
				$('input[name=phone]').attr("required",true);
			} else {
				$('#div-phone').hide();
				$('input[name=phone]').attr("required",false);
			}

			$('#modal-selesai').modal('show');
		});

		$('#modal-selesai').on('hide.bs.modal', function() {
			$(this).find('select').val('').trigger('change').prop("disabled",false);
			$(this).find('input').val('').prop("readonly",false);
			$(this).find('textarea').val('').prop("readonly",false);
			$(this).find('.date-picker').val('{{ date("d/m/Y") }}');

			$('input[name=phone]').attr("required",false);

			$('#div-phone').hide();
		});

		$('#selesaikan-register').click(function(){
			$('#form-selesai').submit();
		});

        $('#form-selesai').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();
                var record=$(this).serialize();
				var url     = baseUrl+'proses/done/'+dataCd;
				var method  = 'PUT';

                swal({
                    title               : 'Selesaikan Register?',
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
										$('#modal-selesai').modal('hide');
										tabelData.ajax.reload();
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

		/* ./selesaikan register */
		
		/* teruskan ke kanwil */

		$(document).on('click', '#kanwil',function(){ 
			dataCd 			= $(this).data('tbl_register_id');
			var notificationTp 	= $(this).data('notification_tp');

			$('#modal-teruskan').modal('show');
		});

		$('#modal-teruskan').on('hide.bs.modal', function() {
			$(this).find('select').val('').trigger('change').prop("disabled",false);
			$(this).find('input').val('').prop("readonly",false);
			$(this).find('textarea').val('').prop("readonly",false);
			$(this).find('.date-picker').val('{{ date("d/m/Y") }}');
		});

		$('#teruskan-register').click(function(){
			$('#form-teruskan').submit();
		});

        $('#form-teruskan').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();
                var record=$(this).serialize();
				var url     = baseUrl+'proses/forward/'+dataCd;
				var method  = 'PUT';

                swal({
                    title               : 'Teruskan Register Ke Kanwil?',
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
										$('#modal-teruskan').modal('hide');
										tabelData.ajax.reload();
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

		/* ./teruskan ke kanwil */

		/* ubah tanggal register selesai */

		$(document).on('click', '#ubah-tanggal-selesai',function(){
			dataCd 			= $(this).data('tbl_register_id');
			dateTimeDone 	= $(this).data('datetime_done');

			$('input[name=change_datetime_done]').val(dateTimeDone);
			$('#modal-ubah-tanggal-selesai').modal('show');
		});

		$('#modal-selesai').on('hide.bs.modal', function() {
			$(this).find('.date-picker').val('{{ date("d/m/Y") }}');
		});

		$('#simpan-tanggal-register-selesai').click(function(){
			$('#form-ubah-tanggal-selesai').submit();
		});

        $('#form-ubah-tanggal-selesai').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();
                var record=$(this).serialize();
				var url     = baseUrl+'update/'+dataCd;
				var method  = 'PUT';

                swal({
                    title               : 'Simpan Tanggal Selesai?',
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
										$('#modal-ubah-tanggal-selesai').modal('hide');
										tabelData.ajax.reload();
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

		/* ./ubah tanggal register selesai */

		$(document).on('click', '#hapus',function(){ 
			var dataCd 			= $(this).data('tbl_register_id');

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
                        url : '{{ url("/delete") }}'+'/'+dataCd,
                        type: "GET",
                        dataType: "JSON",
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
									reset();
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

        $('#kembali').click(function(){
			window.location = '/';
		});

		init("{{ $id }}");
	});

	function reset() {
		tabelData.ajax.reload();
		init($('#jenis_register_nm_param').val());
	}

	function init(params) {
        $.getJSON(baseUrl+'initial/data?tipe='+params, function(data){
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
