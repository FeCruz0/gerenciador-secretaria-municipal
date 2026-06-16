@extends('layouts.web_base')


@section('content')

    <section id="conservation_units">
        <div class="container">
            <div class="row mt-5">
                <!-- Projeto -->
                <div class="col-md-8">
                    <div class="">
                        <div class="col-md-12">
                            <div class="row mb-4">
                                <!-- Imagem -->
                                <div style="position: relative;">
                                    <div style="width:100%; height: 100%">
                                        <img class="card-img-top shadow rounded" src="{{asset('storage/images/conservation_units/' . $conservation_unit->thumb)}}" alt="Card image cap" 
                                        style="
                                        max-width: 100%;
                                        height: 260px;
                                        object-fit: cover;
                                        border:solid 1px;
                                        border-color: #b9d9ba !important;
                                        ">
                                    </div>
                                </div>
                                <!-- Imagem FIM -->

                                <!-- Título -->
                                <div class="d-flex flex-column justify-content-center">
                                    <div class="mt-5 section-title text-start">
                                        <h1 class="mb-0 pb-0 text-center">
                                            {{$conservation_unit->title}}
                                        </h1>
                                    </div>
                                </div>
                                <!-- Título FIM -->
                                <!-- Conteúdo -->
                                <div class="px-4">
                                    <div>
                                        <div class="">
                                            {{$conservation_unit->objective}}
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <div class="">
                                            <a href="{{$conservation_unit->creation_link}}">{{$conservation_unit->creation}}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ps-4 mt-0">
                                        <hr style="width: 40px; height: 2px; color:#198754; opacity: 0.50;" class="mt-3">
                                    </div>
                                    <div class="ps-4">
                                        <div class="mt-4">
                                            <h4 style="font-size: 20px">Area</h4>
                                                <ul>
                                                    <li>
                                                        {{$conservation_unit->area}}
                                                    </li>
                                                </ul>
                                        </div>
                                        <div class="mt-4">
                                            <h4 style="font-size: 20px">Localização</h4>
                                                <ul>
                                                    <li>
                                                        {{$conservation_unit->localization}}
                                                    </li>
                                                </ul>
                                        </div>
                                        <div class="mt-4">
                                            <h4 style="font-size: 20px">Abrangência</h4>
                                            <ul>
                                            @foreach($conservation_unit->coverages as $coverage)
                                                <li>
                                                    {{$coverage->city}}
                                                </li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h3>
                                            Informações da Sede
                                        </h3>
                                        <div class="ps-4 mt-4">
                                            <p>
                                                <strong>Endereço: </strong>{{$conservation_unit->address}}
                                            </p>
                                            <p>
                                                <strong>Telefone: </strong>{{$conservation_unit->phone}}
                                            </p>
                                            <p>
                                                <strong>Email: </strong>{{$conservation_unit->email}}
                                            </p>
                                            <p>
                                                <strong>Horario de Funcionamento: </strong>{{$conservation_unit->opening_hours}}
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <!-- Conteúdo fim -->
                            </div>
                        </div>
                    </div>
                </div> 
                <!-- Unidade de Conservação FIm -->

                <!-- Barra Lateral -->
                <div class="col-md-4">
                        <!-- Campo de Busca -->
                            <div class="rounded shadow-sm p-4 caixa-verde d-flex flex-column w-100" >
                                <div class="">
                                    <h3 class="fonte-verde-escuro title-font" style="font-size: 18px;">
                                        <strong>Buscar Unidade de Conservação</strong>
                                    </h3>
                                    <hr class="mt-2 mb-0 "style="width: 20px; height: 1px; color:#198754; opacity: 0.50;">
                                </div>
                                <form class="col-md-12 m-0 d-flex flex-row mt-4">
                                    <div class="col-md-10 pe-2">
                                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"       style="height: 50px;" >
                                    </div>
                                    
                                    <div class="col-md-2">
                                    <button type="button" class="btn w-100" style="height: 49px; background-color: #3cb347; border-color: #279f32">
                                            <i class="fas fa-search" style="color: #fafffa;"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        <!-- Campo de Busca FIM -->
                        
                        <!-- Ultimos Unidade de Conservação -->
                        <div class="rounded shadow-sm p-4 caixa-verde mt-5 d-flex flex-column" >
                            <div>
                                <h3 class="fonte-verde-escuro title-font" style="font-size: 18px;">
                                    <strong>Ultimas Unidades de Conservação</strong>
                                </h3>
                                <hr class="mt-2 mb-0 "style="width: 20px; height: 1px; color:#198754; opacity: 0.50;">
                            </div>
                            
                                @foreach($conservation_units as $conservation_unit)
                                <a href="{{ route('unid_conservacao_web_show', $conservation_unit->id) }}" style="text-decoration: none">
                                <div class="col-md-12 d-flex flex-column mt-4">
                                    <div class="d-flex flex-row">
                                        
                                            <div class="col-md-4 pe-2">
                                                <div>
                                                    <div style="position: relative;">
                                                        <div style="width:100%; height: 100%">
                                                            <img class="card-img-top shadow rounded" src="{{asset('storage/images/conservation_units/' . $conservation_unit->thumb)}}" alt="Card image cap" 
                                                            style="
                                                            max-width: 100%;
                                                            height: 70px;
                                                            object-fit: cover;
                                                            border:solid 1px;
                                                            border-color: #b9d9ba !important;
                                                            ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7 ps-2 ">
                                                <div class="fonte-verde-escuro">
                                                    <h3 style="font-size: 14px; font-weight: 600">
                                                        {{$conservation_unit->title}}
                                                    </h3>
                                                </div>
                                                <div style="font-size: 12px;">
                                                    <p>
                                                        {{$conservation_unit->title}}
                                                    </p>
                                                </div>
                                            </div>
                                       
                                    </div>
                                <div>
                                </a>
                                    <div class="d-flex flex-row align-items-center">
                                        <hr class="mb-0 "style="width: 100%; height: 1px; color:#198754; opacity: 0.20;">
                                    </div>
                                @endforeach
                            
                        </div>
                        <!-- Ultimos Unidade de Conservação -->
                </div>
                <!-- Barra Lateral FIM -->

            </div>
        </div>
    </section>
@endsection