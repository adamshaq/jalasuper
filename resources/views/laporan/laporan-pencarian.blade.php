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
				<form class="form-validate-jquerys" id="form-isian" method="POST" action="/laporan/list-notifikasi">
                    @csrf
					<div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Tanggal</label>
                                <input type="text" name="tanggal" class="form-control daterange-single" data-value="{{ date('Y/m/d') }}" required="" placeholder="" aria-invalid="false" />
                            </div>
                        </div>
                    </div>
				</form>
			</div>
			<div class="table-responsive">
				<table class="table datatable-pagination" id="tabel-data">
					<thead>
						<tr>
							<th width="55%" id="jenis_register_table">Jenis Surat</th>
							<th width="45%" id="jumlah_table">Jumlah</th>
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
			order       : [[1, 'asc']], 
            ajax		: {
                url: "{{ url('/laporan/laporan-pencarian') }}",
                type: "POST",
                data    : function(data){
                    data._token		= $('meta[name="csrf-token"]').attr('content')
                    data.tanggal 	= $('input[name="tanggal"]').val()
                },
            },
            columns: [
                { data: 'jenis_register', name:'jenis_register', visible:true, orderable : false},
                { data: 'jumlah', name:'jumlah', visible:true},
            ],
        });

		$('input[name="tanggal"]').change(function() {
			tabelData.ajax.reload();
		});

		$('#reset').click(function(){
			window.location = '/';
		});
	});
</script>
@endpush
