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
            <!-- Basic layout -->
            <div class="card mt-0">
                <div class="card-body">
                    <div class="card border-left-3 border-left-success-400 rounded-left-0">
                        <div class="card-body">
                            <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                <div>
                                    <h6><b>{{ $register->wajib_pajak }}</b></h6>
                                    <p class="">{{ $register->no_surat }}</p>
                                    <p class="">{{ $register->jenis_register }}</p>
                                    <p class="">{{ $register->note }}</p>
                                    <p class="">Tanggal Masuk : {{ tgl_dan_jam($register->datetime_input) }}</p>
                                    @if ($register->proses_st == 'PROSES_ST_3')
                                    <p class=""> <b>Telah diteruskan ke kanwil {{ $register->info_02 }}</b> </p>
                                    @endif
                    
                                </div>
                    
                                <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto">
                                    @if ($register->proses_st == 'PROSES_ST_1')
                                    <li>Prioritas: &nbsp; 
                                        @if ($register->selisih >= $register->warning)
                                            <span class="badge badge-danger">Mendesak</span>                   
                                        @else
                                            <span class="badge badge-success">Normal</span>
                                        @endif
                                    </li>
                                    @else
                                    <li>Tanggal Selesai: &nbsp;{{ tgl_dan_jam($register->datetime_done) }} </li>
                                    <li>Diselesaikan Oleh: &nbsp;{{ $register->done_by }} </li>
                                    @endif
                                </ul>
                                
                            </div>
        
                            
                        </div>
                    
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <span>Tenggat Waktu: <span class="font-weight-semibold">{{ tgl_dan_jam($register->datetime_deadline) }}</span></span>
                                </div>
                                <div class="col-md-6">
                                  
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul id="messages" class="media-list media-chat media-chat-scrollable mb-3">

                    </ul>

                    @if ($register->proses_st == 'PROSES_ST_1')
                    <textarea name="message-body" class="form-control mb-3" rows="3" cols="1" placeholder="Tulis Pesan Anda"></textarea>
                    <div class="d-flex align-items-center">
                        <button id="send-message" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto"><b><i class="icon-paperplane"></i></b> Kirim</button>
                    </div>
                    @endif
                </div>
            </div>
            <!-- /basic layout -->
		</div>
	</div>

@endsection
@push('scripts')
<script>
	var baseUrl = "{{ url('/messages/') }}";
	var saveMethod;

    $(document).ready(function(){
        getMessages();

        $('.list-icons-item').click(function() {
            getMessages();
        });

        $('#send-message').click(function() {
            var record = {
                '_token'    : $('meta[name="csrf-token"]').attr('content'),
                'message'   : $('textarea[name=message-body]').val(),
            };

            $.ajax({
                'type': 'POST',
                'url' : baseUrl+'/{{ $register->tbl_register_id }}',
                'data': record,
                'dataType': 'JSON',
                'success': function(response){
                    if(response["status"] == 'ok') {
                        $('textarea[name=message-body]').val('');
                        getMessages();
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
        });
        /* submit form */
        $('#form-cppt').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();
                var record=$('#form-cppt').serialize();

                if(saveMethod == 'tambah'){
                    var url     = '{{ url("/cppt/") }}';
                    var method  = 'POST';
                }else{
                    var url     = '{{ url("/cppt/") }}'+'/'+dataCd;
                    var method  = 'PUT';
                }

                swal({
                    title               : 'Simpan Data?',
                    type                : "warning",
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
                                        reset('cppt');
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
	});

	function getMessages() {
        $.getJSON( "{{ url('/messages/get/'.$register->tbl_register_id) }}", function(data){
            if (data['status'] == 'ok') {
                $('#messages').empty();
                $('#messages').append(data['template']);
            }
        });
	}
</script>
@endpush
