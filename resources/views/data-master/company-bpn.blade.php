@extends('layouts.app')

@section('content')
	<!-- Basic datatable -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">Data BPN</h5>
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
								<th width="15%" id="tbl_company_id_table">Kode BPN</th>
                                <th width="25%" id="company_nm_table">Nama BPN</th>
                                <th width="" id="company_tp_table">company_tp_table</th>
                                <th width="" id="company_tp_nm_table">company_tp_nm_table</th>
                                <th width="15%" id="phone_table">No Telp</th>
                                <th width="30%" id="company_address_table">Alamat</th>
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
                    <input type="hidden" name="tbl_company_id" />
					<div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Kode BPN</label>
                                <input type="text" name="tbl_company_id" class="form-control"  required="" placeholder="" aria-invalid="false" />
                            </div>
                        </div>
						<div class="col-md-6">
							<div class="form-group form-group-float">
								<label class="form-group-float-label is-visible">Nama BPN</label>
								<input type="text" name="company_nm" class="form-control"  required="" placeholder="" aria-invalid="false" />
							</div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">No Telp</label>
                                <input type="number" name="phone" class="form-control"  required="" placeholder="" aria-invalid="false" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Alamat BPN</label>
                                <textarea name="company_address" class="form-control" required="" placeholder="" aria-invalid="false"></textarea>
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
    var saveMethod = 'tambah';
    var groupColumn = 3;

    $(document).ready(function(){
        $('#bagian-form').hide();
        $('#bagian-tabel').show();

		tabelData = $('#tabel-data').DataTable({
            serverSide	: true, 
			processing	: true, 
            order		: [[4,'ASC']], 
            ajax		: {
                url: "{{ url('/data-master/company-bpn/data') }}",
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
            columns: [
                { data: 'tbl_company_id', name:'tbl_company_id', visible:true},
                { data: 'company_nm', name:'company_nm', visible:true},
                { data: 'company_tp', name:'company_tp', visible:false},
                { data: 'company_tp_nm', name:'company_tp_nm', visible:false},
                { data: 'phone', name:'phone', visible:true},
                { data: 'company_address', name:'company_address', visible:true},
                { data: 'actions', name: 'actions', visible:true}
            ],
            order       : [[ groupColumn, 'asc'], [1, 'asc']], 
            columnDefs: [
                { "visible": false, "targets": groupColumn }
            ],
            displayLength : 10,
            drawCallback : function ( settings ) {
                var api   = this.api();
                var rows  = api.rows( {page:'current'} ).nodes();
                var last  = null;

                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group_row" col><td colspan="6" align="center"><h5><b>'+group+'</b></h5></td></tr>'
                        );

                        last = group;
                    }
                } );
            }
        });

        
        $(document).on('change', 'select[name=company_tp_param]',function(){ 
            tabelData.column('#company_tp_table').search($(this).val()).draw();
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#company_nm_table').search($(this).val()).draw();
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
                    var url     = '{{ url("/data-master/company-bpn/") }}';
                    var method  = 'POST';
                }else{
                    var url     = '{{ url("/data-master/company-bpn/") }}'+'/'+dataCd;
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
            dataCd      = rowData['tbl_company_id'];

            $('input[name=tbl_company_id]').val(rowData['tbl_company_id']).prop("readonly",true);
            $('input[name=company_nm]').val(rowData['company_nm']);
            $('input[name=phone]').val(rowData['phone']);
            $('textarea[name=company_address]').val(rowData['company_address']);
            

            $('#bagian-form').show();
            $('#bagian-tabel').hide();
        });

		/* detail */
        $(document).on('click', '#detail',function(){ 
            saveMethod  = 'ubah';
            var rowData = tabelData.row($(this).parents('tr')).data();
            dataCd      = rowData['tbl_company_id'];

            $('input[name=tbl_company_id]').val(rowData['tbl_company_id']).prop("readonly",true);
            $('input[name=company_nm]').val(rowData['company_nm']);
            $('input[name=phone]').val(rowData['phone']);
            $('textarea[name=company_address]').val(rowData['company_address']);

            $('#div-buttons').hide();
            $('#bagian-form').show();
            $('#bagian-tabel').hide();
        });

        /* hapus data */
        $(document).on('click', '#hapus',function(){    
            var rowData=tabelData.row($(this).parents('tr')).data();
            dataCd = rowData['tbl_company_id'];
            
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
                        url : '{{ url("/data-master/company-bpn/") }}'+'/'+dataCd,
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

        /*cek kode*/
        $('input[name=tbl_company_id]').focusout(function(){
            var id= $(this).val();
            var urlCek='{{ url("/data-master/company") }}'+'/'+id;

            if ($(this).val()) {
                $.getJSON( urlCek, function(data){
                    if (data['data'] != null) {
                        swal({
                            title: "Peringatan!",
                            text: "Kode Sudah Digunakan!",
                            type: "warning",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            $('input[name=tbl_company_id]').val('');
                            $('input[name=tbl_company_id]').focus();
                            swal.close();
                        });
                    }
                });
            }
        });
	});
</script>
@endpush
