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
        <link rel="stylesheet" href="{{asset('css/style.min.css?v=')}}{{env("APP_CSS_VERSION")}}">

    </head>
    <body>
        <div class="container-fluid" id="homepage">
            {{-- Loading Overlay --}}
            <div class="overlay"></div>
            <div class="spanner">
                <div class="loader"></div>
                <p>Carregando dados. Por favor, aguarde.</p>
            </div>

            <nav class="navbar navbar-expand-lg fixed-top bg-primary" id="menuHome">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('index') }}">
                        <img src="{{asset('img/ufpr.png')}}" alt="Logo UFPR" width="60" class="d-inline-block">
                        <span class="brand-text ms-3">Hackathon UFPR</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto ms-5 mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Relatórios
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{route('relCurso')}}">Relatório de Cursos</a></li>
                                    <li><a class="dropdown-item" href="{{route('relDisciplina')}}">Relatório de Disciplinas</a></li>
                                    <li><a class="dropdown-item" href="{{route('relInstituicao')}}">Relatório Institucional</a></li>
                                </ul>
                            </li>
                        </ul>
                        <form class="d-flex" role="search">
                            <button class="btn btn-outline-success btn-mLogin" type="button">Entrar</button>
                        </form>
                    </div>
                </div>
            </nav>

            <div class="row full-height justify-content-center pt-4">
                @yield('content')
            </div>

            <div class="modal fade" id="mLogin" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mLogin" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-11 mTitle">
                                    <span>Acesso Administrativo</span>
                                </div>
                                <div class="col-1 mClose">
                                    <i class="fa-duotone fa-xmark-large" data-bs-dismiss="modal" aria-label="Close"></i>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="text-center">
                                    <img class="img-fluid form-logo p-1 mb-3" src="{{asset('img/ufpr.png')}}" alt="Logo">
                                    <form id="form-login" action="{{route('login')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="email_usuario" class="form-style" placeholder="E-mail" id="email_usuario" autocomplete="off">
                                            <i class="input-icon fa-duotone fa-at"></i>
                                        </div>	
                                        <div class="form-group mt-2">
                                            <i class="input-icon fa-duotone fa-lock"></i>
                                            <input type="password" name="senha_usuario" class="form-style" placeholder="Senha" id="senha_usuario" autocomplete="off">
                                            <i class="input-icon fa-duotone fa-eye togglePassword"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn btn-np mx-1 btn-login matchSize" data-target="#form-avaliacao">Entrar</div>
                            <div class="btn btn-np matchSize" data-bs-dismiss="modal">Cancelar</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SCRIPTS --}}
        <script src="{{asset('plugin/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('plugin/bootstrap-5.2.0-dist/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('plugin/sweetalert-2/dist/sweetalert2.all.min.js')}}"></script>
        <script src="{{asset('plugin/mask.jquery.js')}}"></script>
        <script src="{{asset('plugin/select2/js/select2.min.js')}}"></script>
        <script src="{{asset('plugin/select2/js/i18n/pt-BR.js')}}"></script>
        <script src="{{asset('js/custom.min.js')}}"></script>

        @yield('scripts')

        <script>
            /* Tratamento Campo Senha */
            $(document).on("click", ".togglePassword", function(){
                var icon = $(this);
                var input = $("#senha_usuario");
                tooglePassword(input, icon);
            });

            /* Função para mostrar/esconder senha */
            function tooglePassword(input, icon){
                var tipoInput = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr("type", tipoInput);
                icon.toggleClass("fa-eye fa-eye-slash");
            }

            /* Botão Adicionar Avaliação */
            $(document).on("click", ".btn-mLogin", function() {
                $("#mLogin").modal('show');
            });
            $(document).on("shown.bs.modal", "#mLogin", function(){
                $("#mLogin .matchSize").matchDimensions("width");
                $(".tooltip").remove();
            });
            $(document).on("hide.bs.modal", "#mLogin", function(){
                $("#mLogin form")[0].reset();
                $("#mLogin").find('.invalid-feedback').remove();
                $(".tooltip").remove();
            });

            /* Login */
            $(document).on('click', ".btn-login", function () {
                var btn = $(this);
                var form = $('#form-login').serialize();
                var url = $('#form-login').attr('action');
                btn.html('<div class="spinner-border text-light" role="status"></div>');
                btn.prop('disabled', true);
                $('#form-login').find('input').prop('disabled', true);
                $('#form-login').find('.invalid-feedback').remove();

                if($("#email_usuario").val() == "" && $("#senha_usuario").val() == ""){
                    btn.html('Entrar');
                    btn.prop('disabled', false);
                    $('#form-login').find('input').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Informe seu e-mail e senha para prosseguir.'
                    });
                }
                else{
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: form,
                        success: (data) => {
                            btn.html('Entrar');
                            btn.prop('disabled', false);
                            $('#form-login').find('input').prop('disabled', false);
                            window.location.href = data;
                        },
                        error: (err) => {
                            var errors = err.responseJSON.data;
                            btn.html('Entrar');
                            btn.prop('disabled', false);
                            $('#form-login').find('input').prop('disabled', false);

                            if ($.isArray(errors)) {
                                $.each(errors, (key, value) => {
                                    $('#form-login').find('[name="' + value['campo'] + '"]').parent().append('<span class="invalid-feedback">' + value['mensagem'] + '</span>');
                                });
                                $('#form-login').find('[name="' + errors[0]["campo"] + '"]').focus();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: err.responseJSON.data
                                });
                            }
                        }
                    });
                }
            });

        </script>
    </body>
</html>
