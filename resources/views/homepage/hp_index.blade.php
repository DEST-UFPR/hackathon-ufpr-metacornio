@extends('layouts.l_index')

@section('content')
    <div class="col-12 text-center align-self-center py-5">
        <img class="img-fluid meta-logo" src="{{asset('img/metacornio.png')}}" alt="Logo">
        <div class="row m-5">
            <p class="hpMsg">Página criada pela equipe Metacórnio para o <strong>Hackathon de Dados UFPR</strong>.</p>
            <p class="hpMsg">Os dashboards são visíveis na área de <strong>Relatórios</strong>, divididos em Relatório de Cursos, Relatório de Disciplinas e Relatório Institucional.</p>
            <p class="hpMsg">A área administrativa pode ser acessada pelo botão <strong>Entrar</strong> com o usuário e senha informados no GitHub.</p>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    
});
</script>
@endsection