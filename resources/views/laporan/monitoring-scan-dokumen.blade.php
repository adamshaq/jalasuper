@extends('layouts.app')

@section('content')
	<!-- Basic datatable -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">{{ $title }}</h5>
			<div class="header-elements">
				<div class="list-icons">
					<a class="list-icons-item" data-action="reload" id="reload-table"></a>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div id="bagian-form">
				<form class="form-validate-jquerys" id="form-isian" method="POST" action="/list-notifikasi">
                    @csrf
					<div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Nomor BPS</label>
                                <input type="text" name="no_surat_param" class="form-control" placeholder="Pencarian Berdasarkan Nomor BPS" aria-invalid="false" />
                            </div>
                        </div>
                    </div>
				</form>
			</div>
			<div class="table-responsive">
				<table class="table datatable-pagination" id="tabel-data">
					<thead>
						<tr>
                            <th id="tbl_register_scan_id_table">tbl_register_scan_id_table</th>
                            <th id="no_surat_table">No BPS</th>
                            <th id="datetime_input_format_table">Tanggal Surat</th>
                            <th id="wajib_pajak_table">Nama</th>
                            <th id="scan_datetime_table">scan_datetime_table</th>
                            <th id="date_scan_table">Tanggal Pindai</th>
                            <th id="time_scan_table">Waktu Pindai</th>
                            <th id="scan_status_table">Tindakan</th>
                            <th id="scan_by_nm_table">Pemindai</th>
                            <th id="scan_attempt_table">Pemindaian Ke</th>
                            <th id="action_table">#</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
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
		tabelData = $('#tabel-data').DataTable({
            serverSide	: true, 
			processing	: true, 
			order       : [[4, 'desc']], 
            ajax		: {
                url: "{{ url('/laporan/monitoring-scan-dokumen') }}",
                type: "POST",
                data    : function(data){
                    data._token = $('meta[name="csrf-token"]').attr('content');
                    data.id 	= $('input[name="no_surat_param"]').val();
                },
            },
            dom : 'tpi',
            scrollX :true,
            scrollY :false,
            columns: [
                { data: 'tbl_register_scan_id', name:'tbl_register_scan_id', visible:false, orderable : true},
                { data: 'no_surat', name:'no_surat', visible:true, orderable : true},
                { 
                    data: "datetime_input", 
                    name : "datetime_input", 
                    visible:true, 
                    orderable:true, 
                    render: function (data) {
                        return moment(data, 'YYYY-MM-DD HH:mm:ss').format('LL')
                    }
                },
                // { data: 'datetime_input_format', name:'datetime_input_format', visible:true, orderable : true},
                { data: 'wajib_pajak', name:'wajib_pajak', visible:true, orderable : true},
                { data: 'scan_datetime', name:'scan_datetime', visible:false, orderable : true},
                { 
                    data: "scan_datetime", 
                    name : "date_scan", 
                    visible:true, 
                    orderable:true, 
                    render: function (data) {
                        return moment(data, 'YYYY-MM-DD HH:mm:ss').format('LL')
                    }
                },
                // { data: 'date_scan', name:'date_scan', visible:true, orderable : true},
                { 
                    data: "scan_datetime", 
                    name : "time_scan", 
                    visible:true, 
                    orderable:true, 
                    render: function (data) {
                        return moment(data, 'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss')
                    }
                },
                // { data: 'time_scan', name:'time_scan', visible:true, orderable : true},
                { data: 'scan_status', name:'scan_status', visible:true, orderable : true},
                { data: 'scan_by_nm', name:'scan_by_nm', visible:true, orderable : true},
                { data: 'scan_attempt', name:'scan_attempt', visible:true, orderable : true},
                { data: 'actions', name:'actions', visible:true, orderable : false},
            ],
        });

		$('input[name="no_surat_param"]').keyup(function() {
            tabelData.column("#no_surat_table").search($(this).val()).draw();
		});

		$('#reset').click(function(){
			window.location = '/';
		});

        /* hapus data */
        $(document).on('click', '#hapus',function(){    
            var rowData=tabelData.row($(this).parents('tr')).data();
            dataCd = rowData['tbl_register_scan_id'];
            
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
                        url : '{{ url("/laporan/monitoring-scan-dokumen/") }}'+'/'+dataCd,
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
