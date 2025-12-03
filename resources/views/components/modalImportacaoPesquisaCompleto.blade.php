@php
    $modalID        = $modalInfo[0];
    $modalHeader    = $modalInfo[1];
    $importacao     = $modalInfo[2];
    $avaliacao      = $modalInfo[3];
    $usuario        = $modalInfo[4];
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

            {{-- IMPORTAÇÃO --}}
            <div class="card my-2">
                <div class="card-header">
                    <span>IMPORTAÇÃO</span>
                </div>
                <div class="card-body">
                    <div class="row justify-content-around">
                        <div class="col-12 col-sm-11 my-2 infoCol">
                            <span class="infoLabel">
                                Arquivo:
                            </span>
                            <span class="infoData">
                                {{$importacao->nome_arquivo}}
                            </span>
                        </div>
                        <div class="col-12 col-sm-5 my-2 infoCol">
                            <span class="infoLabel">
                                Data Importação:
                            </span>
                            <span class="infoData">
                                {{ date('d/m/Y H:i:s', strtotime($importacao->updated_at)) }}
                            </span>
                        </div>
                        <div class="col-12 col-sm-5 my-2 infoCol">
                            <span class="infoLabel">
                                Usuário:
                            </span>
                            <span class="infoData">
                                {{$usuario->nome_completo}}
                            </span>
                        </div>
                        <div class="col-12 col-sm-5 my-2 infoCol">
                            <span class="infoLabel">
                                Total de Perguntas:
                            </span>
                            <span class="infoData">
                                {{number_format($importacao->dados_importacao['total_perguntas'], 0, ",", ".")}}
                            </span>
                        </div>
                        <div class="col-12 col-sm-5 my-2 infoCol">
                            <span class="infoLabel">
                                Total de Linhas:
                            </span>
                            <span class="infoData">
                                {{number_format($importacao->dados_importacao['total_linhas'], 0, ",", ".")}}
                            </span>
                        </div>
                        <div class="col-12 col-sm-11 my-2 infoCol">
                            <span class="infoLabel">
                                Status:
                            </span>
                            <span class="infoData">
                                {{($importacao->status_importacao == "F") ? "Finalizada" : "Pendente"}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- AVALIAÇÃO --}}
            <div class="card my-2">
                <div class="card-header">
                    <span>AVALIAÇÃO</span>
                </div>
                <div class="card-body">
                    <div class="row justify-content-around">
                        <div class="col-12 col-sm-5 my-2 infoCol">
                            <span class="infoLabel">
                                Nome:
                            </span>
                            <span class="infoData">
                                {{$avaliacao->nome_avaliacao}}
                            </span>
                        </div>
                        <div class="col-12 col-sm-5 my-2 infoCol">
                            <span class="infoLabel">
                                Categoria:
                            </span>
                            <span class="infoData">
                                @php
                                    $categoria_avaliacao = listaCategoriasPesquisa()->firstWhere('codigo', $avaliacao->categoria_avaliacao);
                                @endphp
                                {{$categoria_avaliacao->nome}}
                            </span>
                        </div>
                        <div class="col-12 col-sm-5 my-2 infoCol">
                            <span class="infoLabel">
                                Período:
                            </span>
                            <span class="infoData">
                                {{$avaliacao->periodo_label}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
