@extends('layouts.app')

@section('content')
	<!-- Account settings -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">{{ $title }}</h5>
        </div>

        <div class="card-body">
            <form action="#" id="form-password">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Sandi Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" value="password" readonly="readonly" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Sandi Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" required placeholder="Kata Sandi">
                        </div>

                        <div class="col-md-6">
                            <label>Ulangi Sandi Baru</label>
                            <input type="password" name="repeat_password" class="form-control" required placeholder="">
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary ml-3 legitRipple">Submit <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /account settings -->

@endsection
@push('scripts')
<script>
    $(document).ready(function(){
		/* form-password */
        $('#form-password').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();
                var record  = $('#form-password').serialize();
                var url     = '{{ url("/ubah/kata/sandi") }}';
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
                                        window.location = '/';
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
                                        swal.close();
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
