@php
    $route = \Request::route()->getName();
    $user = auth()->user();
@endphp

<div class="container-fluid sticky-top py-1 sideTop">
    <input type="hidden" id="route" value="{{$route}}">
    <div class="d-flex align-items-center">
        <div class="order-lg-2">
            <button type="button" id="sidebarCollapse" class="btn btn-info sideTop-btn order-lg-1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Esconder/Mostrar Menu">
                <i class="fa-duotone fa-sidebar fa-2xl"></i>
            </button>
        </div>
        <div class="order-lg-1 col col-lg-1 text-center text-light d-none d-sm-block">
            <img class="img-fluid bp-logo" src="{{asset('img/cpa_t.png')}}" alt="Logo">
        </div>
        <div class="order-lg-3 col-3 col-lg-6 m-auto text-center">
            <h3 class="sideTop-title">{{$seo->title}}</h3>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div id="SideBarNav" class="col">

            <ul class="divMenu">
                <li class="MenuItem" data-route="painel">
                    <a data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Início" href="{{route('painel')}}" data-route="painel">
                        <i class="fa-duotone fa-house"></i> <span> Início </span>
                    </a>
                </li>

                @foreach (modulos() as $modulo)
                    <li class="MenuItem">
                        <a data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$modulo->title}}">
                            <i class="fa-duotone {{$modulo->icon}}"></i> <span> {{$modulo->title}} </span>
                            <div class="fa IconSub float-end mt-1 fa-caret-down"></div>
                        </a>
                        <ul class="divMenuSub" style="display: none;">
                            @foreach (opcoes_menu() as $menu)
                                @if($modulo->name == $menu->modulo)
                                    <li class="SMenuItem" data-route="{{$menu->route}}">
                                        @if($menu->temView)
                                            <a href="{{route($menu->route)}}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$menu->title}}">
                                        @else
                                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$menu->title}}">
                                        @endif
                                                <i class="fa-duotone {{$menu->icon}}"></i><span> {{$menu->title}} </span>
                                            </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Sair">
                        <i class="fa-duotone fa-person-to-door"></i><span> Sair </span>
                    </a>
                </li>
            </ul>
        </div>