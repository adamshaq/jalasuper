@extends('layouts.app')

@section('content')
	<!-- data register -->
	<div class="card" id="card-register">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">Catatan Pemohon</h5>
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
						<select name="jenis_register_param" id="jenis_register_param" class="form-control form-control-select2 select-search"  data-fouc>
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
					<thead style="display:none">
						<tr>
							<th id="tbl_register_id_table">tbl_register_id_table</th>
							<th id="jenis_register_table">jenis_register_table</th>
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

@endsection
@push('scripts')
<script>
    var tabelData;
	var baseUrl = "{{ url('/messages') }}";
	var saveMethod;

    $(document).ready(function(){
		// data register

		tabelData = $('#tabel-data').DataTable({
            serverSide	: true, 
			processing	: true, 
            order		:[[7,'ASC'],[5,'ASC'],[1,'ASC']], 
            ajax		: {
                url: baseUrl+'/data',
                type: "POST",
				data    : function(data){
                    data._token	= $('meta[name="csrf-token"]').attr('content'),
                    data.date_in= $('input[name=date_in_param]').val();
                },
            },
            columns: [
				{ data: 'tbl_register_id', name:'tbl_register_id', visible:false},
				{ data: 'jenis_register', name:'jenis_register', visible:false},
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

		$(document).on('change', '#jenis_register_param',function(){ 
            tabelData.column('#jenis_register_table').search($(this).val()).draw();
        });

		$('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');
			$('select[name=upload_tp_param]').val('').trigger('change');

			tabelData.ajax.reload();
		});

        $('#kembali').click(function(){
			window.location = '/';
        });
        
        $(document).on('click', '#balas',function(){ 
			var dataCd 		= $(this).data('tbl_register_id');
			window.location = baseUrl+'/'+dataCd
		});
	});

	function reset() {
		tabelData.ajax.reload();
	}
</script>
@endpush
