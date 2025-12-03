@extends('layouts.l_dashboard')
@section('content')
    <div class="container-fluid indexDash">
        <div class="row">
            <span class="dashTitle">Olá {{$user->nome_completo}}, bem-vindo ao Hackaton CPA.</span>
        </div>

        <div class="row m-5">
            <p class="dashMsg">Para ver importações realizadas, acesse o menu <strong>Administração > Importar Pesquisa</strong>.</p>
            <p class="dashMsg">Para gestão de Avaliações, acesse o menu <strong>Cadastros > Avaliações</strong>.</p>
            <p class="dashMsg">Para relatórios de incontingências, acesse o menu <strong>Estatísticas > Alertas</strong>.</p>
        </div>

    </div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    
});
</script>
@endsection