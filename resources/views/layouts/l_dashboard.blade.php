<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('imgs/favicon.png')}}" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title>{{$seo->title ?? 'Metacornio'}} - Metacornio</title>
    <meta name="title" content="Metacornio - {{$seo->title ?? 'Metacornio'}}">
    <meta name="image" content="{{$seo->image_perfil ?? asset('img/logo.png')}}">
    <link rel="canonical" href="{{$seo->link ?? 'https://hackaton_cpa.metacornio.com.br/'}}">
    <meta name="description" content="{{$seo->description ?? 'Metacornio'}}">
    <meta name="keywords" content="{{isset($seo->keywords) ? implode(',', $seo->keywords) : ''}}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    {{-- Fonts --}}
    
    {{-- CSS --}}
    <link rel="stylesheet" href="{{asset('plugin/bootstrap-5.2.0-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/sweetalert-2/dist/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/brands.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/duotone.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/duotone-light.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/duotone-regular.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/duotone-thin.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/light.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/regular.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/sharp-duotone-light.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/sharp-duotone-regular.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/sharp-duotone-solid.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/sharp-duotone-thin.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/sharp-light.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/sharp-regular.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/sharp-solid.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/sharp-thin.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/solid.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/thin.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/DataTables/datatables.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/style.min.css?v=')}}{{env("APP_CSS_VERSION")}}">

</head>
<body class="dashboard">
    <div class="wrapper">
        {{-- Loading Overlay --}}
        <div class="overlay"></div>
        <div class="spanner">
            <div class="loader"></div>
            <p>Carregando dados. Por favor, aguarde.</p>
        </div>

        {{-- Navbar --}}
        <x-sidebar :seo="$seo"/>

        {{-- Conteúdo --}}
        <div id="SideBarContent" class="col-12 col-lg">
            <div class=" p-3 col-12">
                <div class="col-12 pb-2">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    </div>


    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="{{asset('plugin/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('plugin/bootstrap-5.2.0-dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('plugin/ckeditor5/ckeditor.js')}}"></script>
    <script src="{{asset('plugin/sweetalert-2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('plugin/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('plugin/moment.js')}}"></script>
    <script src="{{asset('plugin/moment-with-locales.js')}}"></script>
    <script src="{{asset('plugin/datetime-moment.js')}}"></script>
    <script src="{{asset('plugin/mask.jquery.js')}}"></script>
    <script src="{{asset('plugin/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('plugin/select2/js/i18n/pt-BR.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>

    <script>
        /* Função para validação de sessão */
        function checkSession(error){
            if(error.status == 4129 || error.status == 403 || error.status == 401){
                var index = window.location.origin;
                Swal.fire({
                    title: 'Sessão Expirada!',
                    text: "Clique em CONTINUAR para efetuar o login novamente!",
                    icon: 'warning',
                    allowOutsideClick: false,
                    showCancelButton: false,
                    confirmButtonColor: '#444f51',
                    confirmButtonText: 'CONTINUAR'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace(index);
                    }
                })
                return true;
            }
            else{
                return false;
            }
        }
        /* Loading Overlay */
        function load_ov(mode){
            if(mode == "show"){
                $(".spanner").addClass("show");
                $(".overlay").addClass("show");
            }
            else if(mode == "hide"){
                $(".spanner").removeClass("show");
                $(".overlay").removeClass("show");
            }
        }
        /* Loading Tooltips */
        function load_tt(){
            let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    container: 'body',
                    trigger: 'hover'
                });
            })
        };
        load_tt();
    </script>

    @yield('scripts')
</body>
</html>