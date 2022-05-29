<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Admin- {{ config('app.name', 'Laravel') }}</title>    
       
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/icons.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/googlefont.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/sb-admin-2.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/vendor/datatables/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/vendor/select2/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/sb-admin-custom.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    
</head>
<body id="page-top">
    <div id="wrapper">
       <div class="modal fade" tabindex="-1" role="dialog" id="spinnerModal">
          <div class="modal-dialog modal-dialog-centered text-center" role="document">
              <div class="d-flex justify-content-center w-100">
                  <div style="background-color: white; padding: 12px;">
                      <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                  </div>
              </div>
          </div>
       </div>
       @include('controller.sidebar')
       <div id="content-wrapper" class="d-flex flex-column">        
         <div id="content">
           @include('controller.navbar')
           <div class="container-fluid">
              <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">@yield('page_title')</h1>
                @yield('nav_sectiton')
              </div>
              @if (Session::has('msg'))
                <div class="alert alert-{{ Session::get('class')=="error"?"danger":Session::get('class') }} alert-dismissible fade show" role="alert">
                  <strong>{{ ucwords(Session::get('class')) }}!</strong> {{ ucwords(Session::get('msg'))}}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif
              @yield('content')
           </div>               
         </div>
         @include('controller.footer')
       </div>
     </div>
     <a class="scroll-to-top rounded" href="#page-top">
       <i class="fas fa-angle-up"></i>
     </a>
     @include('controller.model')
    <script src="{{ asset('js/app.js') }}" ></script>    
    <script src="{{ asset ('assets/backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/alertify/alertify.js') }}"></script>
    <script src="{{ asset ('assets/backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset ('assets/backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset ('assets/backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset ('assets/backend/vendor/ckeditor/ckeditor.js') }}"></script>
          
    <script src="{{ asset ('assets/backend/vendor/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset ('assets/backend/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset ('assets/backend/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/backend/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        var base_url="{{url('/')}}";
        
        $(document).ready(function() {
          alertify.logPosition("top right");
          alertify.delay(100000);
          $('form').parsley();
          $('.select2').select2();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
        });
    </script>
    @stack('scripts')
</body>
</html>