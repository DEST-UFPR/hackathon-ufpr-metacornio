@extends('layouts.l_dashboard')
@section('content')

    <div class="row">
        <div class="col-6 col-lg-auto me-auto">
            <div class="btn btn-np btn-addImport">Importar</div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="table-responsive">
            <table class="table table-hover" id="importPesquisaTable">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">Arquivo</th>
                        <th class="text-center" scope="col">Avaliação</th>
                        <th class="text-center" scope="col">Data</th>
                        <th class="text-center" scope="col">Status</th>
                        <th class="text-center" scope="col">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade modalInfo mInfo" id="mVerImportacao" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mVerImportacao" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="mImportPesquisa" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mImportPesquisa" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-1 mType">
                            <i class="fa-duotone fa-circle-n"></i>
                        </div>
                        <div class="col-10 mTitle">
                            <span>Nova Importação</span>
                        </div>
                        <div class="col-1 mClose">
                            <i class="fa-duotone fa-xmark-large" data-bs-dismiss="modal" aria-label="Close"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        @if($avaliacoes->count() == 0)
                            <div class="alert alert-warning" role="alert">
                                Nenhuma avaliação disponível para importação. Por favor, crie uma avaliação antes de prosseguir com a importação.
                            </div>
                        @else
                            <form id="form-importPesquisa" class="row row-cols g-3 align-items-center" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="col-12">
                                    <label for="id_avaliacao" class="form-label">Avaliação</label>
                                    <select class="form-select form-select-lg" name="id_avaliacao" id="id_avaliacao" aria-label="Seletor de Avaliação" required>
                                        <option value="">.: Selecione uma Avaliação :.</option>
                                        @foreach ($avaliacoes as $avaliacao)
                                            <option value="{{$avaliacao->id}}">{{$avaliacao->nome_avaliacao}} - {{$avaliacao->categoria_avaliacao}} - {{$avaliacao->periodo_label}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="arquivo_importacao" class="form-label">Arquivo de Importação</label>
                                    <input type="file" class="form-control form-control-lg" name="arquivo_importacao" id="arquivo_importacao" placeholder="Arquivo de Importação" required>
                                    <div id="aHelp" class="form-text">
                                        Arquivos apenas nas extensões CSV ou XLS são aceitos!
                                    </div>
                                </div>

                            </form>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    @if($avaliacoes->count() > 0)
                        <div class="btn btn-np mx-1 btn-saveImportPesquisa matchSize" data-target="#form-importPesquisa">Salvar</div>
                    @endif
                    <div class="btn btn-np matchSize" data-bs-dismiss="modal">Cancelar</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    function importPesquisaTable(){
        var route = "{{route('getImportPesquisas')}}";

        load_ov("show");
        $.ajax({
            url: route,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: (resultData) => {
                load_ov('hide');
                $('#importPesquisaTable').DataTable({
                    data: resultData.data,
                    "destroy": true,
                    order: [[2, 'desc']],
                    columns: [
                        { data: "nome_arquivo", className: "text-center" },
                        { 
                            data: "id_avaliacao",
                            render: function(data, type, row){
                                return `${row.id_avaliacao.nome_avaliacao} - ${row.id_avaliacao.categoria_avaliacao} <br> <small class="cell-small"> ${row.id_avaliacao.periodo_label}</small>`;
                            },
                            className: "text-center",
                        },
                        { 
                            data: "updated_at",
                            render: DataTable.render.datetime('DD/MM/YYYY HH:mm:ss'),
                            className: "text-center",
                        },
                        { 
                            data: "status_importacao",
                            render: function (data, type, row){
                                if(data == "F"){
                                    return '<i class="fa-duotone fa-square-check icon-np" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Finalizada"></i>';
                                }
                                else if(data == "P"){
                                    return '<i class="fa-duotone fa-square-xmark icon-np" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Pendente"></i>';
                                }
                            },
                            className: "text-center",
                            orderable: false,
                        },
                        { 
                            data: null, 
                            defaultContent: 
                                `<div class="btn-group" role="group" aria-label="">
                                    <div class="btn btn-icon btn-ver" data-route="{{route("getImportPesquisaCompleto")}}" data-bs-toggle="tooltip" data-bs-title="Ver Detalhes" data-target="#mVerImportacao"><i class="fa-duotone fa-magnifying-glass-plus"></i></div>
                                    <div class="btn btn-icon btn-excluir" data-route="{{route("deleteImportPesquisa")}}" data-bs-toggle="tooltip" data-bs-title="Excluir"><i class="fa-duotone fa-trash-xmark"></i></div>
                                </div>`,
                            className: "text-center",
                            orderable: false,
                        },
                    ],
                    drawCallback: function () {
                        load_tt();
                    }
                });

                $("#importPesquisaTable").css("width", "100%");
            },
            error: (err) => {
                load_ov('hide');
                var check = checkSession(err);

                if(!check){
                    Swal.fire({
                        icon: 'error',
                        title: err.responseJSON.data
                    });
                }
            }
        });
    }
    importPesquisaTable();

    /* Botão Importação */
    $(document).on("click", ".btn-addImport", function() {
        $("#mImportPesquisa").modal('show');
    });
    /* Botão para Salvar Importação */
    $(document).on('click', '.btn-saveImportPesquisa', function(e) {
        var btn = $(this);
        var btnText = $(this).html();
        var route = "{{route('newImportPesquisa')}}";
        var target = $(this).data('target');
        var form_dados = new FormData($(target)[0]);
        var arquivo = $('#arquivo_importacao')[0].files[0];
        var arquivo_extensao = $('#arquivo_importacao').val().split('.').pop().toLowerCase();

        if(!arquivo){
            Swal.fire({
                icon: 'warning',
                title: 'Anexe um arquivo para continuar.'
            });
        }
        else{
            form_dados.append("arquivo_importacao", arquivo);

            btn.html('<div class="spinner-border text-light" role="status"></div>');
            btn.prop('disabled', true);
            $(target).find('input').removeClass('is-invalid').prop('disabled', true);
            $(target).find('.invalid-feedback').remove();

            $(".spanner p").text('Por favor aguarde. O processo de importação pode demorar dependendo da quantidade de linhas no arquivo. Não feche esta aba!');
            load_ov('show');

            $.ajax({
                url: route,
                type: 'POST',
                data: form_dados,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if(data.success){
                        load_ov('hide');
                        $(".spanner p").text('Carregando dados. Por favor, aguarde');
                        Swal.fire({
                            title: 'Importação carregada!',
                            text: 'O processo de importação foi iniciado. Você pode continuar utilizando o sistema enquanto a importação é realizada em segundo plano.',
                            icon: 'success',
                            allowOutsideClick: false,
                            showCancelButton: false,
                            confirmButtonColor: '#444f51',
                            confirmButtonText: 'CONTINUAR'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                btn.html(btnText);
                                btn.prop('disabled', false);
                                $(target).find('input').prop('disabled', false);
                                $(target)[0].reset();
                                $("#mImportPesquisa").modal("hide");
                                importPesquisaTable("");
                            }
                        });
                    }
                },
                error: (err) => {
                    load_ov('hide');
                    $(".spanner p").text('Carregando dados. Por favor, aguarde');
                    var check = checkSession(err);
                    if(!check){
                        var errors = err.responseJSON.data;
                        btn.html(btnText);
                        btn.prop('disabled', false);
                        $(target).find('input').prop('disabled', false);

                        if (errors) {
                            // console.log(errors);
                            $.each(errors, (key, value) => {
                                $(target).find('[name="' + value["campo"] + '"]').parent().append('<span class="invalid-feedback">' + value["mensagem"] + '</span>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: err.responseJSON.invalid
                            });
                        }
                    }
                }
            });
        }

    });
    /* Botão para Excluir */
    $(document).on('click', '.btn-excluir', function(e) {
        var btn = $(this);
        var route = $(this).data('route');
        var dados = $(this).parent().parent().parent().attr("id");
        var linha = $("#"+dados);
        $(".tooltip").remove();

        var form = new FormData();
        form.append("id", dados);

        Swal.fire({
            title: 'Tem certeza que deseja excluir?',
            text: "Uma vez excluído o registro, não será possível recuperá-lo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1A396A',
            cancelButtonColor: '#1A396A',
            confirmButtonText: 'SIM',
            cancelButtonText: 'CANCELAR',
            customClass: {
                confirmButton: 'matchSizeAlert',
                cancelButton: 'matchSizeAlert',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        Swal.fire({
                            title: 'Registro excluído com sucesso!',
                            icon: 'success',
                            allowOutsideClick: false,
                            showCancelButton: false,
                            confirmButtonColor: '#1A396A',
                            confirmButtonText: 'CONTINUAR'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                importPesquisaTable();
                            }
                        });
                    },
                    error: (err) => {
                        var check = checkSession(err);
                        if(!check){
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro na operação. Entre em contato com o suporte.'
                            });
                        }
                    }
                });
            }
        });
        if (Swal.isVisible()){
            $(".matchSizeAlert").matchDimensions("width");
        }
    });
    /* Tratamento Modal Importação */
    $(document).on("shown.bs.modal", "#mImportPesquisa", function(){
        $("#mImportPesquisa .matchSize").matchDimensions("width");
        $(".tooltip").remove();
    });
    $(document).on("hide.bs.modal", "#mImportPesquisa", function(){
        if($("#mImportPesquisa form").length > 0){
            $("#mImportPesquisa form")[0].reset();
        }
        $("#mImportPesquisa").find('.invalid-feedback').remove();
        $(".tooltip").remove();
    });
});
</script>
@endsection