@php
    $modalID        = $modalInfo[0];
    $modalHeader    = $modalInfo[1];
    $usuario        = json_decode($modalInfo[2]);
@endphp

<div class="modal-header">
    <div class="row">
        <div class="col-1 mType">
            <i class="fa-duotone fa-circle-i"></i>
        </div>
        <div class="col-10 mTitle">
            <span>{{$modalHeader}}</span>
        </div>
        <div class="col-1 mClose">
            <i class="fa-duotone fa-xmark-large" data-bs-dismiss="modal" aria-label="Close"></i>
        </div>
    </div>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row">

            {{-- USUÁRIO --}}
            <div class="card my-2">
                <div class="card-header">
                    <span>USUÁRIO</span>
                </div>
                <div class="card-body">
                    <div class="row justify-content-around">
                        <div class="col-12 col-sm-11 my-2 infoCol">
                            <span class="infoLabel">
                                Código:
                            </span>
                            <span class="infoData">
                                {{$usuario->nome_usuario}}
                            </span>
                        </div>
                        <div class="col-12 col-sm-11 my-2 infoCol">
                            <span class="infoLabel">
                                Nome Completo:
                            </span>
                            <span class="infoData">
                                {{$usuario->nome_completo}}
                            </span>
                        </div>
                        <div class="col-12 col-sm-11 my-2 infoCol">
                            <span class="infoLabel">
                                E-mail:
                            </span>
                            <span class="infoData">
                                {{$usuario->email_usuario}}
                            </span>
                        </div>
                        <div class="col-12 col-sm-5 my-2 infoCol">
                            <span class="infoLabel">
                                Data Criação:
                            </span>
                            <span class="infoData">
                                {{ date('d/m/Y H:i:s', strtotime($usuario->created_at)) }}
                            </span>
                        </div>
                        <div class="col-12 col-sm-5 my-2 infoCol">
                            <span class="infoLabel">
                                Data Última Modificação:
                            </span>
                            <span class="infoData">
                                {{ date('d/m/Y H:i:s', strtotime($usuario->updated_at)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
