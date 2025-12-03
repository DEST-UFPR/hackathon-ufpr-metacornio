@extends('layouts.l_dashboard')
@section('content')

    <div class="row">
        <div class="col-6 col-lg-auto me-auto">
            <div class="btn btn-np btn-addUsuario">Adicionar</div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="table-responsive">
            <table class="table table-hover" id="usuarioTable">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">Nome</th>
                        <th class="text-center" scope="col">E-mail</th>
                        <th class="text-center" scope="col">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade modalInfo mInfo" id="mVerUsuario" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mVerUsuario" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="mUsuario" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mUsuario" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-1 mType">
                            <i class="fa-duotone fa-circle-n"></i>
                        </div>
                        <div class="col-10 mTitle">
                            <span>Novo Usuário</span>
                        </div>
                        <div class="col-1 mClose">
                            <i class="fa-duotone fa-xmark-large" data-bs-dismiss="modal" aria-label="Close"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="form-usuario" class="row row-cols g-3 align-items-center" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <input autocomplete="false" name="hidden" type="text" style="display:none;">
                            @csrf
                            <input type="hidden" name="id" id="id_usuario" value="">
                            <input type="hidden" name="nome_usuario" id="nome_usuario" value="">

                            <div class="col-12">
                                <label for="nome_completo" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control form-control-lg" name="nome_completo" id="nome_completo" placeholder="Nome Completo" required>
                            </div>
                            <div class="col-12">
                                <label for="email_usuario" class="form-label">E-mail</label>
                                <input type="text" class="form-control form-control-lg" name="email_usuario" id="email_usuario" placeholder="E-mail" required autocomplete="new-password">
                            </div>
                            <div class="col-12 d-none" id="inputPASS">
                                <label for="senha_usuario" class="form-label">Senha</label>
                                <div id="ndHelp" class="form-text">
                                    A senha deve conter no mínimo 6 (seis) caracteres.
                                </div>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg br-none" name="senha_usuario" id="senha_usuario" placeholder="Senha" required aria-labelledby="sHelp" autocomplete="new-password">
                                    <span class="input-group-text bl-none bg-trans">
                                        <i class="fa-duotone fa-eye togglePassword"></i>
                                    </span>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-np mx-1 btn-saveUsuario matchSize" data-target="#form-usuario">Salvar</div>
                    <div class="btn btn-np matchSize" data-bs-dismiss="modal">Cancelar</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mSenhaUsuario" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mSenhaUsuario" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-1 mType">
                            <i class="fa-duotone fa-circle-n"></i>
                        </div>
                        <div class="col-10 mTitle">
                            <span>Alteração de Senha</span>
                        </div>
                        <div class="col-1 mClose">
                            <i class="fa-duotone fa-xmark-large" data-bs-dismiss="modal" aria-label="Close"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="form-senhaUsuario" class="row row-cols g-3 align-items-center" action="{{route('updateUsuarioPassword')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="id_usuario" value="">

                            <div class="col-12">
                                <label for="senha_usuario" class="form-label">Senha</label>
                                <div id="ndHelp" class="form-text">
                                    A senha deve conter no mínimo 6 (seis) caracteres.
                                </div>
                                <div class="input-group">
                                    <input type="password" class="form-control br-none" name="senha_usuario" id="senha_usuario" placeholder="Senha" required aria-labelledby="sHelp">
                                    <span class="input-group-text bl-none bg-trans">
                                        <i class="fa-duotone fa-eye togglePassword"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="confirma_senha_usuario" class="form-label">Confirme a Senha</label>
                                <div class="input-group">
                                    <input type="password" class="form-control br-none" name="confirma_senha_usuario" id="confirma_senha_usuario" placeholder="Confirme a Senha" required aria-labelledby="sHelp">
                                    <span class="input-group-text bl-none bg-trans">
                                        <i class="fa-duotone fa-eye togglePassword"></i>
                                    </span>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-np mx-1 btn_salvarSenha matchSize" data-target="#form-senhaUsuario" data-route="{{route('updateUsuarioPassword')}}">Salvar</div>
                    <div class="btn btn-np matchSize" data-bs-dismiss="modal">Cancelar</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    function usuarioTable(){
        var route = "{{route('getUsuarios')}}";

        load_ov("show");
        $.ajax({
            url: route,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: (resultData) => {
                $('#usuarioTable').DataTable({
                    data: resultData.data,
                    "destroy": true,
                    order: [[0, 'asc']],
                    columns: [
                        { data: "nome_completo", className: "text-center" },
                        { data: "email_usuario", className: "text-center" },
                        { 
                            data: null, 
                            defaultContent: 
                                `<div class="btn-group" role="group" aria-label="">
                                    <div class="btn btn-icon btn-ver" data-route="{{route("getUsuarioCompleto")}}" data-bs-toggle="tooltip" data-bs-title="Ver Detalhes" data-target="#mVerUsuario"><i class="fa-duotone fa-magnifying-glass-plus"></i></div>
                                    <div class="btn btn-icon btn-editUsuario" data-bs-toggle="tooltip" data-bs-title="Editar" data-target="#mUsuario"><i class="fa-duotone fa-pen-to-square"></i></div>
                                    <div class="btn btn-icon btn-alterarSenha" data-bs-toggle="tooltip" data-bs-title="Alterar Senha" data-target="#mSenhaUsuario"><i class="fa-duotone fa-key"></i></div>
                                    <div class="btn btn-icon btn-delUsuario" data-route="{{route("deleteUsuario")}}" data-bs-toggle="tooltip" data-bs-title="Excluir"><i class="fa-duotone fa-trash-xmark"></i></div>
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

                $("#usuarioTable").css("width", "100%");
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
    usuarioTable();

    /* Botão Adicionar Usuário */
    $(document).on("click", ".btn-addUsuario", function() {
        $("#mUsuario #inputPASS").removeClass("d-none");
        $("#mUsuario").modal('show');
    });
    /* Botão para Salvar Usuário */
    $(document).on('click', '.btn-saveUsuario', function(e) {
        var btn = $(this);
        var btnText = $(this).html();
        var target = $(this).data('target');
        var form_dados = new FormData($(target)[0]);

        if(form_dados.get("id") == ""){
            var route = "{{route('newUsuario')}}";
        }
        else{
            var route = "{{route('updateUsuario')}}";
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
                            $("#mUsuario").modal("hide");
                            usuarioTable("");
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
    /* Botão para Editar Usuário */
    $(document).on("click", ".btn-editUsuario", function(){
        var dados = $(this).parent().parent().parent().attr("id");
        var route = "{{route('getUsuario')}}/" + dados;
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
                $(target + " .modal-header span").text("Editar Usuário");
                $("#mUsuario #id_usuario").val(retorno.id);
                $("#mUsuario #nome_usuario").val(retorno.nome_usuario);
                $("#mUsuario #nome_completo").val(retorno.nome_completo);
                $("#mUsuario #email_usuario").val(retorno.email_usuario);
                
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
    $(document).on('click', '.btn-delUsuario', function(e) {
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
                                usuarioTable();
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
    /* Tratamento Modal Usuario */
    $(document).on("shown.bs.modal", "#mUsuario", function(){
        $("#mUsuario .matchSize").matchDimensions("width");
        $(".tooltip").remove();
    });
    $(document).on("hide.bs.modal", "#mUsuario", function(){
        $("#mUsuario #id_usuario").val('');
        $("#mUsuario #nome_usuario").val('');
        $("#mUsuario form")[0].reset();
        $("#mUsuario").find('.invalid-feedback').remove();
        $("#mUsuario #inputPASS").addClass("d-none");
        $("#mUsuario #senha_usuario").attr("type", "password");
        $("#mUsuario .togglePassword").removeClass("fa-eye-slash").addClass("fa-eye");
    });

    /* Botão Alterar Senha Usuario */
    $(document).on("click", ".btn-alterarSenha", function(){
        var target = $(this).data('target');
        var id_usuario = $(this).parent().parent().parent().attr("id");
        $(target).modal("show");
        $(target + " #id_usuario").val(id_usuario);
    });
    /* Botão para Salvar Senha Usuario */
    $(document).on('click', '.btn_salvarSenha', function(e) {
        var btn = $(this);
        var btnText = $(this).html();
        var route = $(this).data('route');
        var target = $(this).data('target');

        var form_dados = new FormData($(target)[0]);

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
                        title: 'Senha alterada com sucesso!',
                        html: '<p>Em instantes o usuário receberá um e-mail confirmando a atualização da senha, com os novos dados para acesso.</p>',
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
                            $("#mSenhaUsuario").modal("hide");
                            usuariosTable();
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
                            if(value["campo"] === "senha_usuario" || value["campo"] === "confirma_senha_usuario"){
                                $(target).find('[name="' + value["campo"] + '"]').parent().parent().append('<span class="invalid-feedback">' + value["mensagem"] + '</span>');
                            }
                            else{
                                $(target).find('[name="' + value["campo"] + '"]').parent().append('<span class="invalid-feedback">' + value["mensagem"] + '</span>');
                            }
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
    /* Tratamento Modal Senha Usuario */
    $(document).on("shown.bs.modal", "#mSenhaUsuario", function(){
        $("#mSenhaUsuario .matchSize").matchDimensions("width");
    });
    $(document).on("hide.bs.modal", "#mSenhaUsuario", function(){
        $("#mSenhaUsuario #id_usuario").val('');
        $("#mSenhaUsuario form")[0].reset();
        $("#mSenhaUsuario").find('.invalid-feedback').remove();
        $("#mSenhaUsuario #senha_usuario").attr("type", "password");
        $("#mSenhaUsuario #confirma_senha_usuario").attr("type", "password");
        $("#mSenhaUsuario .togglePassword").removeClass("fa-eye-slash").addClass("fa-eye");
    });

    /* Tratamento Campo Senha */
    $(document).on("click", "#mUsuario .togglePassword", function(){
        var icon = $(this);
        var input = icon.parent().parent().find('input');
        tooglePassword(input, icon);
    });
    $(document).on("click", "#mSenhaUsuario .togglePassword", function(){
        var icon = $(this);
        var input = icon.parent().parent().find('input');
        tooglePassword(input, icon);
    });
    /* Função para mostrar/esconder senha */
    function tooglePassword(input, icon){
        var tipoInput = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr("type", tipoInput);
        icon.toggleClass("fa-eye fa-eye-slash");
    };

});
</script>
@endsection