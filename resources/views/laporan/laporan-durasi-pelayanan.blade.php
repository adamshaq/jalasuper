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
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Tanggal Surat</label>
                                <input type="text" name="tanggal_param" class="form-control daterange-single" data-value="{{ date('Y/m/d') }}" required="" placeholder="" aria-invalid="false" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Jenis Register</label>
                                <select name="jenis_register_param" id="jenis_register_param" class="form-control form-control-select2 select-search"  data-fouc>
                                    <option value="">=== Semua Jenis Register ===</option>
                                    @foreach ($jenisRegister as $item)
                                        <option value="{{ $item->jenis_register_nm }}">{{ $item->jenis_register_nm }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
				</form>
			</div>
			<div class="table-responsive">
				<table class="table datatable-pagination" id="tabel-data">
					<thead>
						<tr>
                            <th id="tbl_register_id_table">tbl_register_id_table</th>
                            <th id="jenis_register_table">Jenis Register</th>
                            <th id="no_surat_table">No Surat</th>
                            <th id="wajib_pajak_table">Wajib Pajak</th>
                            <th id="datetime_input_table">Tanggal Surat</th>
                            <th id="datetime_done_table">Tanggal Selesai</th>
                            <th id="durasi_penyelesaian_table">Waktu Penyelesaian</th>
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
                url: "{{ url('/laporan/laporan-durasi-pelayanan') }}",
                type: "POST",
                data    : function(data){
                    data._token         = $('meta[name="csrf-token"]').attr('content');
                    data.tanggal 	    = $('input[name="tanggal_param"]').val();
                    data.jenis_register = $('select[name="jenis_register_param"]').val();
                },
            },
            columns: [
                { data: "tbl_register_id", name : "tbl_register_id", visible:false, orderable:true},
                { data: "jenis_register", name : "jenis_register", visible:true, orderable:true},
                { data: "no_surat", name : "no_surat", visible:true, orderable:true},
                { data: "wajib_pajak", name : "wajib_pajak", visible:true, orderable:true},
                { 
                    data: "datetime_input", 
                    name : "datetime_input", 
                    visible:true, 
                    orderable:true, 
                    render: function (data) {
                        return moment(data, 'YYYY-MM-DD HH:mm:ss').format('LL')
                    }
                },
                { 
                    data: "datetime_done", 
                    name : "datetime_done", 
                    visible:true, 
                    orderable:true, 
                    render: function (data) {
                        return moment(data, 'YYYY-MM-DD HH:mm:ss').format('LL')
                    }
                },
                // { data: "datetime_done", name : "datetime_done", visible:true, orderable:true, render: $.fn.dataTable.render.moment( 'YYYY-MM-DD hh:mm:ss', 'DD/MM/YYYY' )},
                { data: "durasi_penyelesaian", name : "durasi_penyelesaian", visible:true, orderable:true},
            ],
        });

		$('input[name="tanggal_param"]').change(function() {
            tabelData.ajax.reload();
		});

        $('select[name="jenis_register_param"]').change(function() {
            tabelData.ajax.reload();
		});

		$('#reset').click(function(){
			window.location = '/';
		});
	});
</script>
@endpush
