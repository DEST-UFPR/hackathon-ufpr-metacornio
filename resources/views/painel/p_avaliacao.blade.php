@extends('layouts.l_dashboard')
@section('content')

    <div class="row">
        <div class="col-6 col-lg-auto me-auto">
            <div class="btn btn-np btn-addAvaliacao">Adicionar</div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="table-responsive">
            <table class="table table-hover" id="avaliacaoTable">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">Nome</th>
                        <th class="text-center" scope="col">Categoria</th>
                        <th class="text-center" scope="col">Período</th>
                        <th class="text-center" scope="col">Status</th>
                        <th class="text-center" scope="col">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade modalInfo mInfo" id="mVerAvaliacao" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mVerAvaliacao" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="mAvaliacao" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mAvaliacao" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-1 mType">
                            <i class="fa-duotone fa-circle-n"></i>
                        </div>
                        <div class="col-10 mTitle">
                            <span>Nova Avaliação</span>
                        </div>
                        <div class="col-1 mClose">
                            <i class="fa-duotone fa-xmark-large" data-bs-dismiss="modal" aria-label="Close"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="form-avaliacao" class="row row-cols g-3 align-items-center" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id_avaliacao" value="">

                            <div class="col-12">
                                <label for="nome_avaliacao" class="form-label">Nome da Avaliação</label>
                                <input type="text" class="form-control form-control-lg" name="nome_avaliacao" id="nome_avaliacao" placeholder="Nome da Avaliação" required>
                            </div>
                            <div class="col-12">
                                <label for="categoria_avaliacao" class="form-label">Categoria da Avaliação</label>
                                <select class="form-select form-select-lg" name="categoria_avaliacao" id="categoria_avaliacao" aria-label="Seletor de Categoria" required>
                                    <option value="">.: Selecione um Categoria :.</option>
                                    @foreach (listaCategoriasPesquisa() as $categoria)
                                        <option value="{{$categoria->codigo}}">{{$categoria->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="semestre_avaliacao" class="form-label">Semestre da Avaliação</label>
                                <input type="text" class="form-control form-control-lg mask_number" name="semestre_avaliacao" id="semestre_avaliacao" placeholder="Semestre da Avaliação" length="1">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="ano_avaliacao" class="form-label">Ano da Avaliação</label>
                                <input type="text" class="form-control form-control-lg mask_number" name="ano_avaliacao" id="ano_avaliacao" placeholder="Ano da Avaliação" length="4" required>
                            </div>
                            <div class="col-12">
                                <label for="status_avaliacao" class="form-label">Status da Avaliação</label>
                                <select class="form-select form-select-lg" name="status_avaliacao" id="status_avaliacao" aria-label="Seletor de Status" required>
                                    <option value="">.: Selecione um Status :.</option>
                                    @foreach (listaStatusPesquisa() as $status)
                                        <option value="{{$status->codigo}}">{{$status->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-np mx-1 btn-saveAvaliacao matchSize" data-target="#form-avaliacao">Salvar</div>
                    <div class="btn btn-np matchSize" data-bs-dismiss="modal">Cancelar</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    function avaliacaoTable(){
        var route = "{{route('getAvaliacoes')}}";

        load_ov("show");
        $.ajax({
            url: route,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: (resultData) => {
                $('#avaliacaoTable').DataTable({
                    data: resultData.data,
                    "destroy": true,
                    order: [[2, 'desc']],
                    columns: [
                        { data: "nome_avaliacao", className: "text-center" },
                        { data: "categoria_avaliacao", className: "text-center" },
                        { data: "periodo_label", className: "text-center" },
                        { 
                            data: "status_avaliacao",
                            render: function (data, type, row){
                                if(data == "A"){
                                    return '<i class="fa-duotone fa-solid fa-hourglass-half icon-np" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Em Processo"></i>';
                                }
                                else if(data == "F"){
                                    return '<i class="fa-duotone fa-square-check icon-np" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Finalizada"></i>';
                                }
                                else if(data == "C"){
                                    return '<i class="fa-duotone fa-square-xmark icon-np" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Cancelada"></i>';
                                }
                            },
                            className: "text-center",
                            orderable: false,
                        },
                        { 
                            data: null, 
                            defaultContent: 
                                `<div class="btn-group" role="group" aria-label="">
                                    <div class="btn btn-icon btn-ver" data-route="{{route("getAvaliacaoCompleto")}}" data-bs-toggle="tooltip" data-bs-title="Ver Detalhes" data-target="#mVerAvaliacao"><i class="fa-duotone fa-magnifying-glass-plus"></i></div>
                                    <div class="btn btn-icon btn-editAvaliacao" data-bs-toggle="tooltip" data-bs-title="Editar" data-target="#mAvaliacao"><i class="fa-duotone fa-pen-to-square"></i></div>
                                    <div class="btn btn-icon btn-delAvaliacao" data-route="{{route("deleteAvaliacao")}}" data-bs-toggle="tooltip" data-bs-title="Excluir"><i class="fa-duotone fa-trash-xmark"></i></div>
                                </div>`,
                            className: "text-center",
                            orderable: false,
                        },
                    ],
                    drawCallback: function () {
                        $(".tooltip").remove();
                        load_ov('hide');
                        load_tt();
                    }
                });

                $("#avaliacaoTable").css("width", "100%");
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
    avaliacaoTable();

    /* Botão Adicionar Avaliação */
    $(document).on("click", ".btn-addAvaliacao", function() {
        $("#mAvaliacao").modal('show');
    });
    /* Botão para Salvar Avaliação */
    $(document).on('click', '.btn-saveAvaliacao', function(e) {
        var btn = $(this);
        var btnText = $(this).html();
        var target = $(this).data('target');
        var form_dados = new FormData($(target)[0]);

        if(form_dados.get("id") == ""){
            var route = "{{route('newAvaliacao')}}";
        }
        else{
            var route = "{{route('updateAvaliacao')}}";
        }

        btn.html('<div class="spinner-border text-light" role="status"></div>');
        btn.prop('disabled', true);
        $(target).find('input').removeClass('is-invalid').prop('disabled', true);
        $(target).find('.invalid-feedback').remove();

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
                    Swal.fire({
                        title: 'Registro salvo com sucesso!',
                        icon: 'success',
                        allowOutsideClick: false,
                        showCancelButton: false,
                        confirmButtonColor: '#1A396A',
                        confirmButtonText: 'CONTINUAR'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            btn.html(btnText);
                            btn.prop('disabled', false);
                            $(target).find('input').prop('disabled', false);
                            $(target)[0].reset();
                            $("#mAvaliacao").modal("hide");
                            avaliacaoTable("");
                        }
                    });
                }
            },
            error: (err) => {
                load_ov('hide');
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

    });
    /* Botão para Editar Avaliação */
    $(document).on("click", ".btn-editAvaliacao", function(){
        var dados = $(this).parent().parent().parent().attr("id");
        var route = "{{route('getAvaliacao')}}/" + dados;
        var target = $(this).data('target');

        load_ov('show');

        $.ajax({
            url: route,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                var retorno = data.data;
                load_ov('hide');
                load_tt();
                $(target).modal('show');
                $(target + " .mType").html(`<i class="fa-duotone fa-circle-e"></i>`);
                $(target + " .modal-header span").text("Editar Avaliação");
                $("#mAvaliacao #id_avaliacao").val(retorno.id);
                $("#mAvaliacao #nome_avaliacao").val(retorno.nome_avaliacao);
                $("#mAvaliacao #categoria_avaliacao").val(retorno.categoria_avaliacao);
                $("#mAvaliacao #semestre_avaliacao").val(retorno.semestre_avaliacao);
                $("#mAvaliacao #ano_avaliacao").val(retorno.ano_avaliacao);
                $("#mAvaliacao #status_avaliacao").val(retorno.status_avaliacao);
                mask_inputs("put");
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
    });
    /* Botão para Excluir */
    $(document).on('click', '.btn-delAvaliacao', function(e) {
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
                                avaliacaoTable();
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
    $(document).on("shown.bs.modal", "#mAvaliacao", function(){
        $("#mAvaliacao .matchSize").matchDimensions("width");
        $(".tooltip").remove();
        mask_inputs("put");
    });
    $(document).on("hide.bs.modal", "#mAvaliacao", function(){
        $("#mAvaliacao #id_avaliacao").val('');
        $("#mAvaliacao form")[0].reset();
        mask_inputs("clear");
        $("#mAvaliacao").find('.invalid-feedback').remove();
        $(".tooltip").remove();
    });

    /* Tratamento Menu Ver Avaliacao */
    $(document).on("click", "#mVerAvaliacao .dAvaliacao", function(){
        $("#mVerAvaliacao #dAvaliacao").removeClass("d-none");
        $("#mVerAvaliacao .dAvaliacao").addClass("active");
        $("#mVerAvaliacao #dPergunta").addClass("d-none");
        $("#mVerAvaliacao .dPergunta").removeClass("active");
    });
    $(document).on("click", "#mVerAvaliacao .dPergunta", function(){
        $("#mVerAvaliacao #dPergunta").removeClass("d-none");
        $("#mVerAvaliacao .dPergunta").addClass("active");
        $("#mVerAvaliacao #dAvaliacao").addClass("d-none");
        $("#mVerAvaliacao .dAvaliacao").removeClass("active");
    });

    /* Mascara campos */
    function mask_inputs(mode){
        if(mode == "put"){
            $('.mask_number').mask('0#');
        }
        else if(mode == "clear"){
            $('.mask_number').unmask();
        }

        $("#form-avaliacao input").trigger("input");
    }
});
</script>
@endsection