@extends('layouts.app')

@section('content')
    <!-- Inner container -->
    <div class="d-md-flex align-items-md-start">

        <!-- Left sidebar component -->
        <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-0 sidebar-expand-md">

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Navigation -->
                <div class="card">
                    <div class="card-body bg-indigo-400 text-center card-img-top" style="background-image: url(/global_assets/images/backgrounds/panel_bg.png); background-size: contain;">
                        <div class="card-img-actions d-inline-block mb-3">
                             @if ($dataUser->image == NULL)                                     
                             <img class="img-fluid rounded-circle" src="{{ asset('/global_assets/images/placeholders/placeholder.jpg') }}" width="170" height="170" alt="">
                            @else
                                <img class="img-fluid rounded-circle" src="{{ asset('/storage/user-picture/'.$dataUser->image) }}" width="170" height="170" alt="">
                            @endif
                        </div>

                        <h6 class="font-weight-semibold mb-0">{{ $dataUser->user_nm }}</h6>
                        @switch($dataUser->user_tp)
                            @case('USER_TP_1')
                                <span class="d-block opacity-75">Super Administrator</span>
                            @break
                            @case('USER_TP_2')
                                <span class="d-block opacity-75">Administrator KPP</span>
                            @break
                            @case('USER_TP_3')
                                <span class="d-block opacity-75">Pegawai</span>
                            @break
                            @default
                                
                        @endswitch
                        <span class="d-block opacity-75">{{ $dataUser->company_nm }}</span>
                        <div class="list-icons list-icons-extended mt-3">
                            <a href="/data-master/user" class="list-icons-item text-white" data-popup="tooltip" title="" data-container="body" data-original-title="Kembali Ke Daftar User"><i class="icon-home"></i></a>
                            @if ($dataUser->user_tp != 'USER_TP_1' && Auth::user()->user_tp == 'USER_TP_1' && Auth::user()->user_id != $dataUser->user_id)
                                <a id="hapus-user" class="list-icons-item text-white" data-popup="tooltip" title="" data-container="body" data-original-title="Hapus User"><i class="icon-trash"></i></a>
                            @endif
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <ul class="nav nav-sidebar mb-2">
                            <li class="nav-item">
                                <a href="#profile" class="nav-link active" data-toggle="tab">
                                    <i class="icon-user"></i>
                                     Profil User
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="#data-foto" class="nav-link" data-toggle="tab">
                                    <i class="icon-image2"></i>
                                    Ubah Foto Profil User
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="#data-password" class="nav-link" data-toggle="tab">
                                    <i class="icon-key"></i>
                                    Ubah Password
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /navigation -->

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /left sidebar component -->


        <!-- Right content -->
        <div class="tab-content w-100 overflow-auto">
            <div class="tab-pane fade active show" id="profile">
                <!-- Profil User -->
                <div class="card">
                    <div class="card-header header-elements-sm-inline">
                        <h6 class="card-title">Profil User</h6>
                    </div>

                    <div class="card-body">
                        <form class="form-validate-jquery" id="form-isian" action="#">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">User ID</label>
                                        <input type="text" name="user_id" class="form-control" id="user_id" readonly placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Nama User</label>
                                        <input type="text" name="user_nm" class="form-control" required="" placeholder="" aria-invalid="false">
                                    </div>
                                </div>
                            </div>
                            @if ($dataUser->user_tp != 'USER_TP_1')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Jenis User</label>
                                        <select name="user_tp" data-placeholder="pilih salah satu" class="form-control form-control-select2 select-search" required data-fouc>
                                            <option value="USER_TP_2">Administrator</option>
                                            <option value="USER_TP_3">Pegawai</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    
                                </div>
                            </div>
                            @endif
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan Data <i class="icon-floppy-disks ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /profil perusahaan -->
            </div>

            <div class="tab-pane fade" id="data-foto">
                <!-- change company image -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Ubah Foto Profil User</h6>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-warning"> 
                            <i class="fa fa-exclamation-triangle"></i> 
                            Maksimal ukuran file 2 MB
                        </div>
                        <div class="row" id="img-cropper">
                            <div class="col-md-12 p-20">
                                <div class="img-container" style="display:none" id="img-container">
                                    <img id="image" src="" class="img-responsive" alt="Picture">
                                </div>
                                <label class="data-url"></label>
                            </div>
                        </div>
                        <div class="btn-group btn-group-justified">
                            <button type="button" id="pilih-foto" class="btn bg-slate-700 legitRipple"><i class="fa fa-image"> Pilih Foto Dari Komputer </i></button>
                            <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*" style="display:none">
                            <button type="button" id="save-image" class="btn bg-slate-700 legitRipple"><i class="fa fa-floppy-o"> Jadikan Foto User</i></button>
                            <button type="button" id="reset-cropper" class="btn bg-slate-700 legitRipple"><i class="fa fa-refresh"> Reset Cropper</i></button>
                        </div><br>
                        <div class="btn-group btn-group-justified">
                            <button type="button" id="hapus-foto" class="btn bg-slate-700 legitRipple"><i class="fa fa-trash-o"> Hapus Foto Profil User Saat Ini</i></button>
                            <button type="button" id="batal-upload" class="btn bg-slate-700 legitRipple"><i class="fa fa-remove"> Batal</i></button>
                        </div>
                    </div>
                </div>
                <!-- /change company image -->
            </div>

            <div class="tab-pane fade" id="data-password">
                <!-- Account settings -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Pengaturan Akun</h5>
                    </div>

                    <div class="card-body">
                        <form action="#" id="form-password">
                            @csrf
                            <input type="hidden" name="user_id_password" value="{{ $dataUser->user_id }}">
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
            </div>
        </div>
        <!-- /right content -->

    </div>
    <!-- /inner container -->

@endsection
@push('scripts')
<script src="/global_assets/js/plugins/media/cropper.min.js"></script>
<script>
    var tabelDataMenara;
    var dataCd = "{{ $dataUser->user_id }}";
    var base64Image = '';

    $(function () {

        'use strict';

        var console = window.console || { log: function () {} };
        var $image = $('#image');
        var options = {
            aspectRatio: 200/200,
            preview: '.img-preview',
            crop: function (e) {
                base64Image = $image.cropper('getCroppedCanvas').toDataURL(0.5)
            }
        };

        // Cropper
        $image.cropper(options);

        $('#reset-cropper').click(function(){
            $image.cropper("reset");  
        });

        $('#pilih-foto').click(function(){
            $('#inputImage').click();  
        });

        // Import image
        var $inputImage = $('#inputImage');
        var URL = window.URL || window.webkitURL;
        var blobURL;

        if (URL) {
            $inputImage.change(function () {
                var files = this.files;
                var file;

                if (!$image.data('cropper')) {
                    return;
                }

                if (files && files.length) {
                    file = files[0];

                    if(file.size < 3000000){
                        if (/^image\/\w+$/.test(file.type)) {
                            blobURL = URL.createObjectURL(file);
                            
                            $image.one('built.cropper', function () {

                                // Revoke when load complete
                                URL.revokeObjectURL(blobURL);
                            }).cropper('reset').cropper('replace', blobURL);
                            
                            $inputImage.val('');
                            $('#img-container').show();
                        } else {
                            swal({
                                title: "Silakan Pilih Foto",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: false,
                                timer: 1000
                            }).then(() => {
                                swal.close()
                            });
                        }
                    }else{
                        swal({
                            title: "Ukuran Foto Terlalu Besar",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            $inputImage.val('');
                            swal.close()
                        });
                    }

                }
            });
        } else {
            $inputImage.prop('disabled', true).parent().addClass('disabled');
        }

        /*simpan upload berkas*/
        $('#save-image').click(function(){
            if(base64Image == ''){
                swal({
                    title: "Silakan Pilih Gambar!!",
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                }).then(() => {
                    swal.close()
                });
                return false;
            }

            swal({
                title               : 'Upload Foto?',
                type                : "question",
                showCancelButton    : true,
                confirmButtonColor  : "#00a65a",
                confirmButtonText   : "Ya",
                cancelButtonText    : "Batalkan",
            }).then(function(result){
                if(result.value){
                    swal({title: "Menyimpan Data",onOpen: () => {swal.showLoading();}});

                    $.ajax({
                        url          : "{{ url('sistem/user/profil/image') }}"+"/"+dataCd,
                        type         : "PUT", 
                        data         :{"image" : base64Image, '_token': $('input[name=_token]').val()},
                        dataType     : 'JSON',
                        success   : function(response){
                            if(response.status == 'ok') {     
                                swal({
                                    title: "Berhasil",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    swal.close();
                                    window.location = '{{ url("sistem/user/profil/") }}'+'/'+dataCd;
                                });
                            }else{
                                swal({title: "Data Gagal Disimpan",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                            }
                        },
                        error: function(response){ 
                            var errorText = '';
                            console.log(response)
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
        });

        $('#hapus-foto').click(function(){
            swal({
                title             : "Hapus Foto?",
                type              : "question",
                showCancelButton  : true,
                confirmButtonColor: "#00a65a",
                confirmButtonText : "Ya",
                cancelButtonText  : "Tidak",
            }).then(function(result){
                if(result.value){
                    swal({title: "Menghapus Data",onOpen: () => {swal.showLoading();}});
                    $.ajax({
                        url       : "{{ url('sistem/user/profil/image') }}"+"/"+dataCd,
                        type      : "PUT", 
                        data      :{"image" : base64Image, '_token': $('input[name=_token]').val()},
                        dataType  : "JSON",
                        success   : function(response){
                            if(response.status == 'ok') {     
                                swal({
                                    title: "Berhasil",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    swal.close();
                                    window.location = '{{ url("sistem/user/profil/") }}'+'/'+dataCd;
                                });
                            }else{
                                swal({title: "Data Gagal Disimpan",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                            }
                        },
                        error: function(response){ 
                            var errorText = '';
                            console.log(response)
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
                    })
                }else {
                    swal.close();
                }
            });
        });

        $('#batal-upload').click(function(){
            swal({
                title             : "Batal Unggah Foto??",
                type              : "question",
                showCancelButton  : true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText : "Ya",
                cancelButtonText  : "Tidak",
            }).then(function(result){
                if(result.value){   
                    $('.nav-sidebar a[href="#profile"]').tab('show');
                }
            });
        });

    });

    $(document).ready(function(){
        /* submit form perusahaan */
        $('#form-isian').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();
                var record=$('#form-isian').serialize();
                var url     = '{{ url("/data-master/user/") }}'+'/{{ $dataUser->user_id }}';
                var method  = 'PUT';

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
                                        swal.close();
                                    }
                                });  
                            }
                        });
                    }
                });
            }
        });

        /* form-password */
        $('#form-password').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();
                var record  = $('#form-password').serialize();
                var url     = '{{ url("/data-master/user/password/") }}';
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
                                        init();
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

        @if ($dataUser->user_tp != 'USER_TP_1' && Auth::user()->user_tp == 'USER_TP_1' && Auth::user()->user_id != $dataUser->user_id)
        $('#hapus-user').on('click', function () {
            swal({
                title             : "Hapus User?",
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
                        url : '{{ url("/data-master/user/$dataUser->user_id") }}',
                        type: "DELETE",
                        dataType: "JSON",
                        data: {
                            '_token': $('input[name=_token]').val(),
                        },
                        success: function(response)
                        {
                            if (response.status == 'ok') {
                                swal({
                                    title: "Berhasil Hapus Berkas",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    window.location = '/data-master/user';
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
        @endif

        init();
    });

    function init(){
        var urlUpdate='{{ url("/data-master/user/".$dataUser->user_id) }}';

        $.getJSON( urlUpdate, function(data){
            if (data['status'] == 'ok') {
                $('input[name=password]').val('');
                $('input[name=repeat_password]').val('');
                $.each(data['data'], function (index, data) {
                    $('input[name='+index+']').val(data);
                    $('select[name='+index+']').val(data).trigger('change');
                });
            }
        });
    }
</script>
@endpush