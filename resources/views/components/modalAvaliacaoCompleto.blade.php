@php
    $modalID        = $modalInfo[0];
    $modalHeader    = $modalInfo[1];
    $avaliacao      = $modalInfo[2];
    if(count($modalInfo[3]) > 0)    $perguntas      = $modalInfo[3];
    if(count($modalInfo[4]) > 0)    $importPesquisa = $modalInfo[4];
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

            <div class="col-2">
                <ul class="nav flex-column nav-tabs">
                    <li class="nav-item">
                        <div class="btn-np mb-1 d-flex dAvaliacao active">Avaliação</div>
                    </li>
                    @if(isset($perguntas))
                        <li class="nav-item">
                            <div class="btn-np mb-1 d-flex dPergunta">Perguntas</div>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="col-10">
                {{-- AVALIAÇÃO --}}
                <div class="" id="dAvaliacao">
                    <div class="card">
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
                                <div class="col-12 col-sm-5 my-2 infoCol">
                                    <span class="infoLabel">
                                        Status:
                                    </span>
                                    <span class="infoData">
                                        @php
                                            $status_avaliacao = listaStatusPesquisa()->firstWhere('codigo', $avaliacao->status_avaliacao);
                                        @endphp
                                        {{$status_avaliacao->nome}}
                                    </span>
                                </div>
                                <div class="col-12 col-sm-5 my-2 infoCol">
                                    <span class="infoLabel">
                                        Data Criação:
                                    </span>
                                    <span class="infoData">
                                        {{ date('d/m/Y H:i:s', strtotime($avaliacao->created_at)) }}
                                    </span>
                                </div>
                                <div class="col-12 col-sm-5 my-2 infoCol">
                                    <span class="infoLabel">
                                        Data Última Modificação:
                                    </span>
                                    <span class="infoData">
                                        {{ date('d/m/Y H:i:s', strtotime($avaliacao->updated_at)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isset($importPesquisa))
                        {{-- IMPORTAÇÃO DE PESQUISA --}}
                        <div class="card">
                            <div class="card-header">
                                <span>PESQUISA</span>
                            </div>
                            @foreach ($importPesquisa as $iPesquisa)
                                <div class="card-body">
                                    <div class="row justify-content-around">
                                        <div class="col-12 col-sm-5 my-2 infoCol">
                                            <span class="infoLabel">
                                                Arquivo:
                                            </span>
                                            <span class="infoData">
                                                {{$iPesquisa->nome_arquivo}}
                                            </span>
                                        </div>
                                        <div class="col-12 col-sm-5 my-2 infoCol">
                                            <span class="infoLabel">
                                                Data Importação:
                                            </span>
                                            <span class="infoData">
                                                {{ date('d/m/Y H:i:s', strtotime($iPesquisa->updated_at)) }}
                                            </span>
                                        </div>
                                        <div class="col-12 col-sm-5 my-2 infoCol">
                                            <span class="infoLabel">
                                                Total de Perguntas:
                                            </span>
                                            <span class="infoData">
                                                {{number_format($iPesquisa->dados_importacao['total_perguntas'], 0, ",", ".")}}
                                            </span>
                                        </div>
                                        <div class="col-12 col-sm-5 my-2 infoCol">
                                            <span class="infoLabel">
                                                Total de Linhas:
                                            </span>
                                            <span class="infoData">
                                                {{number_format($iPesquisa->dados_importacao['total_linhas'], 0, ",", ".")}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if(isset($perguntas))
                    @php
                        $agrupado = $perguntas->groupBy('categoria_pergunta');
                    @endphp
                    {{-- PERGUNTAS --}}
                    <div class="d-none" id="dPergunta">
                        <div class="accordion" id="perguntasAccordion">
                            @foreach($agrupado as $categoria => $perguntas)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{$categoria}}" aria-expanded="true" aria-controls="{{$categoria}}">
                                            <span>{{$categoria}}</span>
                                        </button>
                                    </h2>
                                    <div id="{{$categoria}}" class="accordion-collapse collapse" data-bs-parent="#perguntasAccordion">
                                        <div class="accordion-body">
                                            <div class="row justify-content-around">
                                                @foreach($perguntas as $pergunta)
                                                    <div class="col-12 col-sm-11 my-2 infoCol">
                                                        <span class="infoData">
                                                            {{$pergunta->ordem_pergunta}}. {{$pergunta->texto_pergunta}}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>