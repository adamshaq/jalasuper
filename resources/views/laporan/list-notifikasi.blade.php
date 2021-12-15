@extends('layouts.app')

@section('content')
	<!-- Basic datatable -->
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">List Notifikasi</h5>
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
					<div id="div-buttons" class="d-flex justify-content-end align-items-center">
						<button type="reset" class="btn btn-light legitRipple" id="reset">Kembali <i class="icon-reload-alt ml-2"></i></button>
						<button type="submit" class="btn btn-primary ml-3 legitRipple"> Generate File <i class="icon-floppy-disks ml-2"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>


@endsection
@push('scripts')
<script>

    $(document).ready(function(){
		$('#reset').click(function(){
			window.location = '/';
		});
	});
</script>
@endpush
