<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $title.' | '.env('APP_NAME') }}</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ url('/') }}/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="{{ url('/') }}/global_assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="{{ url('/') }}/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="{{ url('/') }}/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="{{ url('/') }}/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="{{ url('/') }}/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ url('/') }}/global_assets/js/main/jquery.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/loaders/blockui.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/ui/slinky.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/ui/ripple.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ url('/') }}/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/forms/validation/validate.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/forms/inputs/touchspin.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/ui/moment/moment_locales.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/pickers/daterangepicker.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
	<script src="{{ url('/') }}/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js"></script>
	<script src="{{ url('/') }}/js/app.js"></script>
	<!-- /theme JS files -->

</head>
<body class="navbar-top">

	@include('layouts.navbar')
	<!-- Page content -->
	<div class="page-content">
			<!-- Main content -->
	<div class="content-wrapper">	
			<!-- Content area -->
			<div class="content mt-10">

				@yield('content')
			
			</div>
			<!-- /content area -->

			@include('layouts.footer')	
	
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->	
	<script>
		$(document).ready(function(){
			moment.locale('id');

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$(document).on('click', '.card-notifikasi',function(){ 
				window.location = "{{ url('') }}"+"?tipe="+$(this).data('jenis_register')+"&status="+$(this).data('status');
			});
			
			$('.daterange-single').daterangepicker({ 
				applyClass: 'bg-slate-600',
            	cancelClass: 'btn-light',
				locale: {
					format: 'DD/MM/YYYY'
				}
			});

			$('.date-picker').daterangepicker({
				singleDatePicker: true,
				locale: {
					format: 'DD/MM/YYYY'
				}
			});

			$('form').each(function() { 
				var validator = $(this).validate({
					ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
					errorClass: 'validation-invalid-label',
					successClass: 'validation-valid-label',
					validClass: 'validation-valid-label',
					highlight: function(element, errorClass) {
						$(element).removeClass(errorClass);
					},
					unhighlight: function(element, errorClass) {
						$(element).removeClass(errorClass);
					},
					// Different components require proper error label placement
					errorPlacement: function(error, element) {

						// Unstyled checkboxes, radios
						if (element.parents().hasClass('form-check')) {
							error.appendTo( element.parents('.form-check').parent() );
						}

						// Input with icons and Select2
						else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
							error.appendTo( element.parent() );
						}

						// Input group, styled file input
						else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
							error.appendTo( element.parent().parent() );
						}

						// Other elements
						else {
							error.insertAfter(element);
						}
					},
					rules: {
						password: {
							minlength: 5
						},
						repeat_password: {
							equalTo: '#password'
						},
						email: {
							email: true
						},
						repeat_email: {
							equalTo: '#email'
						},
						minimum_characters: {
							minlength: 10
						},
						maximum_characters: {
							maxlength: 10
						},
						minimum_number: {
							min: 10
						},
						maximum_number: {
							max: 10
						},
						number_range: {
							range: [10, 20]
						},
						url: {
							url: true
						},
						date: {
							date: true
						},
						date_iso: {
							dateISO: true
						},
						numbers: {
							number: true
						},
						digits: {
							digits: true
						},
						creditcard: {
							creditcard: true
						},
						basic_checkbox: {
							minlength: 2
						},
						styled_checkbox: {
							minlength: 2
						},
						switchery_group: {
							minlength: 2
						},
						switch_group: {
							minlength: 2
						}
					},
					messages: {
						custom: {
							required: 'This is a custom error message'
						},
						basic_checkbox: {
							minlength: 'Please select at least {0} checkboxes'
						},
						styled_checkbox: {
							minlength: 'Please select at least {0} checkboxes'
						},
						switchery_group: {
							minlength: 'Please select at least {0} switches'
						},
						switch_group: {
							minlength: 'Please select at least {0} switches'
						},
						agree: 'Please accept our policy'
					}
				});
				
				// Reset form
				$('#reset').on('click', function() {
					validator.resetForm();
				});
			});

			@if(session('success')) 
				swal({
					title: "{{ session('success') }}",
					type: "success",
					showCancelButton: false,
					showConfirmButton: false,
					timer: 1000
				}).then(() => {
					swal.close();
				});
			@endif

			@if(session('error'))
				swal({
					title: "{{ session('error') }}",
					type: "error",
					showCancelButton: false,
					showConfirmButton: false,
					timer: 1000
				}).then(() => {
					swal.close();
				});
			@endif

			swal.setDefaults({
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-light'
            });
		});
		
		$('.form-control-select2').select2();

		$.extend( $.fn.dataTable.defaults, {
            pagingType	: "full_numbers",
			language	: {"url": "{{ asset('/plugins/DataTables/indonesian.json')}}"},
			dom 		: 'tpir',
        });
	</script>
	@stack('scripts')
</body>
</html>
