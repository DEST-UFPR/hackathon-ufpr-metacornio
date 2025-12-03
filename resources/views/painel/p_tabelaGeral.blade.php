@extends('layouts.l_dashboard')
@section('content')

    <div class="row">
        <div class="col-6 col-lg-auto me-auto">
            <div class="btn btn-np btn-addDadosGerais">Adicionar</div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="table-responsive">
            <table class="table table-hover" id="dadosGeraisTable">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">Tipo</th>
                        <th class="text-center" scope="col">Valor</th>
                        <th class="text-center" scope="col">Descrição</th>
                        <th class="text-center" scope="col">Sequência</th>
                        <th class="text-center" scope="col">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="mDadosGerais" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mDadosGerais" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-1 mType">
                            <i class="fa-duotone fa-circle-n"></i>
                        </div>
                        <div class="col-10 mTitle">
                            <span></span>
                        </div>
                        <div class="col-1 mClose">
                            <i class="fa-duotone fa-xmark-large" data-bs-dismiss="modal" aria-label="Close"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="form-dadosGerais" class="row row-cols g-3 align-items-center" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="id_dadosGerais" value="">

                            <div class="col-12">
                                <label for="tipo_dado" class="form-label">Tipo de Dado</label>
                                <input type="text" class="form-control form-control-lg" name="tipo_dado" id="tipo_dado" placeholder="Tipo de Dado" required>
                            </div>

                            <h3 class="titleSection subTitle mt-3">Nova Opção de Dado</h3>
                            <div class="col-12 col-sm-3">
                                <label for="valor_dado" class="form-label">Valor da Opção</label>
                                <input type="text" class="form-control form-control-lg" name="valor_dado" id="valor_dado" placeholder="Valor da Opção" required>
                            </div>
                            <div class="col-12 col-sm-7">
                                <label for="descricao_dado" class="form-label">Descrição da Opção</label>
                                <input type="text" class="form-control form-control-lg" name="descricao_dado" id="descricao_dado" placeholder="Descrição da Opção" required>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="sequencia" class="form-label">Sequência</label>
                                <input type="text" class="form-control form-control-lg mask_number" name="sequencia" id="sequencia" placeholder="Sequência" required maxlength="3">
                            </div>
                            <div class="col-12 justify-content-end d-flex">
                                <div class="btn btn-np mx-1 btn-saveDadosGerais matchSize" data-target="#form-dadosGerais">Salvar</div>
                                <div class="btn btn-np mx-1 btn_limpar matchSize">Limpar</div>
                            </div>
                        </form>

                        <div class="row mt-3">
                            <div class="table-responsive">
                                <h3 class="titleSection">Opções Cadastradas</h3>
                                <table class="table table-hover" id="opcoesDadosGeraisTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">Valor</th>
                                            <th class="text-center" scope="col">Descrição</th>
                                            <th class="text-center" scope="col">Sequência</th>
                                            <th class="text-center" scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-np" data-bs-dismiss="modal">Fechar</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    function dadosGeraisTable(){
        var route = "{{route('getTabelaGerais')}}";

        load_ov("show");
        $.ajax({
            url: route,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: (resultData) => {
                load_ov('hide');
                $('#dadosGeraisTable').DataTable({
                    data: resultData.data,
                    "destroy": true,
                    order: [[0, 'asc'], [3, 'asc']],
                    columns: [
                        { data: "tipo_dado", className: "text-center" },
                        { data: "valor_dado", className: "text-center" },
                        { data: "descricao_dado", className: "text-center" },
                        { data: "sequencia", className: "text-center" },
                        { 
                            data: null, 
                            defaultContent: 
                                `<div class="btn-group" role="group" aria-label="">
                                    <div class="btn btn-icon btn-verDadosGerais" data-bs-toggle="tooltip" data-bs-title="Ver Detalhes" data-target="#mDadosGerais"><i class="fa-duotone fa-magnifying-glass-plus"></i></div>
                                </div>`,
                            className: "text-center",
                            orderable: false,
                        },
                    ],
                    "createdRow": function(row, data, dataIndex){
                        var dataCol = {
                            "id": data.id,
                            "tipo_dado": data.tipo_dado,
                        };
                        $(row).attr("data-dados", JSON.stringify(dataCol));
                    },
                    drawCallback: function () {
                        load_tt();
                    }
                });

                $("#dadosGeraisTable").css("width", "100%");
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
    dadosGeraisTable();

    /* Botão Adicionar Dado */
    $(document).on("click", ".btn-addDadosGerais", function() {
        $("#mDadosGerais").modal('show');
        $("#mDadosGerais .mType").html(`<i class="fa-duotone fa-circle-n"></i>`);
        $("#mDadosGerais .mTitle span").text("Novo Tipo de Dado");
        mask_inputs('put');
    });
    /* Botão Ver Dado */
    $(document).on("click", ".btn-verDadosGerais", function(){
        var route = "{{route('getTabelaGeralCompleto')}}";
        var target = $(this).data('target');
        var dados = $(this).parent().parent().parent().data("dados");
        var form = new FormData();
        form.append("tipo_dado", dados.tipo_dado);

        load_ov('show');

        $.ajax({
            url: route,
            type: 'POST',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                $.each(data.data, (key, value) => {
                    var id = value["id"];
                    var valor_dado = value["valor_dado"];
                    var descricao_dado = value["descricao_dado"];
                    var sequencia = value["sequencia"];
                    var dados = {
                        "id": id,
                        "valor_dado": valor_dado,
                        "descricao_dado": descricao_dado,
                        "sequencia": sequencia,
                    };
                    dados = JSON.stringify(dados);
                    $("#mDadosGerais #opcoesDadosGeraisTable tbody").append(`
                        <tr id="${id}" data-dados='${dados}'>
                            <td class="text-center">${valor_dado}</td>
                            <td class="text-center">${descricao_dado}</td>
                            <td class="text-center">${sequencia}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="">
                                    <div class="btn btn-icon btn-editarOpcao" data-bs-toggle="tooltip" data-bs-title="Editar"><i class="fa-duotone fa-pen-to-square"></i></div>
                                    <div class="btn btn-icon btn-excluirOpcao" data-route="{{route("deleteTabelaGeral")}}" data-bs-toggle="tooltip" data-bs-title="Excluir"><i class="fa-duotone fa-trash-xmark"></i></div>
                                </div>
                            </td>
                        </tr>
                    `);
                });
                load_ov('hide');
                load_tt();
                mask_inputs('put');
                $(target + " #tipo_dado").val(data.data[0].tipo_dado).attr("readonly", true);
                $(target).modal('show');
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
    /* Botão para Editar Dado */
    $(document).on("click", ".btn-editarOpcao", function(){
        var dadosGerais = $(this).parent().parent().parent().data("dados");
        $(".tooltip").remove();
        $("#mDadosGerais .subTitle").text('Editar Opção de Dado');
        $("#mDadosGerais #valor_dado").trigger("focus");
        $("#mDadosGerais #id_dadosGerais").val(dadosGerais.id);
        $("#mDadosGerais #valor_dado").val(dadosGerais.valor_dado);
        $("#mDadosGerais #descricao_dado").val(dadosGerais.descricao_dado);
        $("#mDadosGerais #sequencia").val(dadosGerais.sequencia);
    });
    /* Botão Salvar Dado */
    $(document).on('click', '.btn-saveDadosGerais', function(e) {
        var btn = $(this);
        var btnText = $(this).html();
        var route = $(this).data('route');
        var target = $(this).data('target');
        var id_dadosGerais = $("#mDadosGerais #id_dadosGerais").val();
        var form_dados = new FormData($(target)[0]);

        if(id_dadosGerais != ""){
            form_dados.append("id", id_dadosGerais);
        }

        if(form_dados.get("id") == ""){
            var route = "{{route('newTabelaGeral')}}";
        }
        else{
            var route = "{{route('updateTabelaGeral')}}";
        }

        btn.html('<div class="spinner-border text-light" role="status"></div>');
        btn.prop('disabled', true);
        $(target).find('input').removeClass('is-invalid').prop('disabled', true);
        $(target).find('.invalid-feedback').remove();

        $.ajax({
            url: route,
            type: 'POST',
            data: form_dados,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                if(data.success){
                    Swal.fire({
                        title: 'Registro salvo com sucesso!',
                        icon: 'success',
                        allowOutsideClick: false,
                        showCancelButton: false,
                        confirmButtonColor: '#2a2b38',
                        confirmButtonText: 'CONTINUAR'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            btn.html(btnText);
                            btn.prop('disabled', false);
                            $(target).find('input').prop('disabled', false);
                            $("#mDadosGerais #tipo_dado").attr('readonly', true);
                            $("#mDadosGerais #valor_dado").val('');
                            $("#mDadosGerais #descricao_dado").val('');
                            $("#mDadosGerais #sequencia").val('');

                            var id_dadosGerais = $("#mDadosGerais #id_dadosGerais").val();

                            if(id_dadosGerais != ""){
                                $("#mDadosGerais .subTitle").text('Nova Opção de Dado');
                                $("#opcoesDadosGeraisTable #" + id_dadosGerais).remove();
                                $("#mDadosGerais #id_dadosGerais").val('');
                            }

                            var dadosRaw = data.data;
                            var dadosResult = {
                                "id": dadosRaw.id,
                                "valor_dado": dadosRaw.valor_dado,
                                "descricao_dado": dadosRaw.descricao_dado,
                                "sequencia": dadosRaw.sequencia,
                            };
                            dadosResult = JSON.stringify(dadosResult);

                            $("#mDadosGerais #opcoesDadosGeraisTable tbody").prepend(`
                                <tr id="${data.data.id}" data-dados='${dadosResult}'>
                                    <td class="text-center">${data.data.valor_dado}</td>
                                    <td class="text-center">${data.data.descricao_dado}</td>
                                    <td class="text-center">${data.data.sequencia}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="">
                                            <div class="btn btn-icon btn-editarOpcao" data-bs-toggle="tooltip" data-bs-title="Editar"><i class="fa-duotone fa-pen-to-square"></i></div>
                                            <div class="btn btn-icon btn-excluirOpcao" data-route="{{route("deleteTabelaGeral")}}" data-bs-toggle="tooltip" data-bs-title="Excluir"><i class="fa-duotone fa-trash-xmark"></i></div>
                                        </div>
                                    </td>
                                </tr>
                            `);

                            dadosGeraisTable();
                        }
                    });
                }
            },
            error: (err) => {
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
                        $(target).find('[name="' + errors[0]["campo"] + '"]').focus();
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
    /* Botão Excluir Dado */
    $(document).on('click', '.btn-excluirOpcao', function(e) {
        var btn = $(this);
        var route = $(this).data('route');
        var dados = $(this).parent().parent().parent().attr("id");
        var dadosGerais = $(this).parent().parent().parent().data("dados");
        var linha = $("#"+dados);
        $(".tooltip").remove();

        var form = new FormData();
        form.append("id", dados);

        Swal.fire({
            title: 'Tem certeza que deseja excluir?',
            text: "Uma vez excluído o registro, não será possível recuperá-lo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2a2b38',
            cancelButtonColor: '#2a2b38',
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
                            confirmButtonColor: '#2a2b38',
                            confirmButtonText: 'CONTINUAR'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#opcoesDadosGeraisTable #"+dados).remove();
                                var tableLength = $("#opcoesDadosGeraisTable tbody tr").length;
                                if(tableLength < 1){
                                    $("#mDadosGerais").modal("hide");
                                }
                                dadosGeraisTable();
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
    /* Botão Limpar */
    $(document).on("click", ".btn_limpar", function(){
        $("#mDadosGerais #id_dadosGerais").val('');
        $("#mDadosGerais #valor_dado").val('');
        $("#mDadosGerais #descricao_dado").val('');
        $("#mDadosGerais #sequencia").val('');
        $("#mDadosGerais .subTitle").text('Novo Tipo de Dado');
        $("#mDadosGerais").find('.invalid-feedback').remove();
    })
    /* Tratamento Modal */
    $(document).on("shown.bs.modal", "#mDadosGerais", function(){
        $("#mDadosGerais .matchSize").matchDimensions("width");
        $(".tooltip").remove();
        mask_inputs("put");
    });
    $(document).on("hide.bs.modal", "#mDadosGerais", function(){
        $("#mDadosGerais #id_dadosGerais").val('');
        if($("#mDadosGerais #form-dadosGerais").length > 0){
            $("#mDadosGerais #form-dadosGerais")[0].reset();
        }
        $("#mDadosGerais #tipo_dado").attr("readonly", false);
        $("#mDadosGerais #opcoesDadosGeraisTable tbody").html("");
        $("#mDadosGerais").find('.invalid-feedback').remove();
        mask_inputs("clear");
        $(".tooltip").remove();
    });

    /* Mascara campos */
    function mask_inputs(mode){
        if(mode == "put"){
            $('.mask_number').mask('0#');
        }
        else if(mode == "clear"){
            $('.mask_number').unmask();
        }

        $("#form-dadosGerais input").trigger("input");
    }
});
</script>
@endsection