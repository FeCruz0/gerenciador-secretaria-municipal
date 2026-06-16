@extends('layouts.web_base')

@section('page-style')

<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css"
  rel="stylesheet"
/>

@endsection

@section('content')
    <section id="conservation_units" class="container">
            <div class="section-title mt-5 pb-5">
                <h1>Unidades de Conservação</h1>
            </div>

            <section class="mb-5 px-2">
                <div class="row">
                    <div class="col-3 mt-2">
                        <!-- Tab navs -->
                        <div
                        class="nav flex-column nav-pills text-center"
                        id="v-pills-tab"
                        role="tablist"
                        aria-orientation="vertical"
                        >
                         @php
                            $i=0;
                        @endphp
                        @foreach ($types as $type)
                            <a
                                class="nav-link {{$i==0 ? 'active' : ''}}"
                                id="v-pills-{{$type->id}}-tab"
                                data-mdb-toggle="pill"
                                href="#v-pills-{{$type->id}}"
                                role="tab"
                                aria-controls="v-pills-{{$type->id}}"
                                aria-selected="true">

                                    {{$type->type}}

                            </a >
                            @php
                                $i++;
                            @endphp
                        @endforeach

                        </div> 
                        <!-- Tab navs -->
                    </div>

                    <div class="col-9">
                        <!-- Proteção Integral -->
                            @foreach($types as $type)
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-{{$type->id}}" role="tabpanel" aria-labelledby="v-pills-{{$type->id}}-tab">
                                            @foreach($type->conservations as $conservation_unit)
                                                <div class="col-md-4 py-3">
                                                    <a href="{{ route('unid_conservacao_web_show', $conservation_unit->id) }}" style="text-decoration: none">
                                                        <div class="card shadow-sm" class="rounded">
                                                            <div style="position: relative;">
                                                                <div style="width:100%; height: 100%">
                                                                    <img class="card-img-top shadow rounded" src="{{asset('storage/images/conservation_units/' . $conservation_unit->thumb)}}" alt="Card image cap"
                                                                    style="
                                                                    max-width: 100%;
                                                                    height: 7.5rem;
                                                                    object-fit: cover;
                                                                    border:solid 1px;
                                                                    border-color: #b9d9ba !important;
                                                                    ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center mt-2" style="border-radius: 5px 5px 5px 15px; ">
                                                            <h3 style="font-size: 16px; color: #4c4c4c" class="title-font">
                                                            <strong> {{$conservation_unit->title}} </strong>
                                                            </h3>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                    </div>
                                </div>
                            @endforeach
                    </div>
                </div>
            </section>
            <hr>

            <div class="row mt-5">
            <section style="" class="col-md-8 px-5">
            <div class="row">
                <div class="">
                    <h4 class="section-title text-start" style="font-size: 32px">
                        <strong>
                            Adote a Conduta Consciente <span style="color:#4a9f51;">.</span>
                        </strong>
                    </h4>
                    <ul class="list-group list-group-flush " style="font-size:14px">
                        <li class="list-group-item" style="color:#2b302b">
                            <i class="fas me-1 fa-feather-alt" style="color: #4a9f51;"></i>
                            Informe-se sobre normas e
                            regulamentos dos locais que vai visitar.
                        </li>
                        <li class="list-group-item" style="color:#2b302b">
                            <i class="fas me-1 fa-feather-alt" style="color: #4a9f51;"></i>
                            Caminhe somente pelas trilhas;
                            atalhos são perigosos e degradam o ambiente.
                        </li>
                        <li class="list-group-item" style="color:#2b302b">
                            <i class="fas me-1 fa-feather-alt" style="color: #4a9f51;"></i>
                            Deixe cada coisa em seu lugar;
                            não risque pedras ou troncos de árvores.
                        </li>
                        <li class="list-group-item" style="color:#2b302b">
                            <i class="fas me-1 fa-feather-alt" style="color: #4a9f51;"></i>
                            Respeite a fauna e a flora;
                            Observe animais à distância, não os alimente
                        </li>
                        <li class="list-group-item" style="color:#2b302b">
                            <i class="fas me-1 fa-feather-alt" style="color: #4a9f51;"></i>
                            Cuide do lixo que você produz até chegar a um ponto de coleta.
                        </li>

                        <li class="list-group-item" style="color:#2b302b">
                        <i class="fas me-1 fa-feather-alt" style="color: #4a9f51;"></i>
                            Informe às autoridades em caso de acidente.
                        </li>
                        <li class="list-group-item" style="color:#2b302b">
                            <i class="fas me-1 fa-feather-alt" style="color: #4a9f51;"></i>
                            Leve materiais de primeiros socorros.
                        </li>
                        <li class="list-group-item" style="color:#661111">
                            <i class="fas me-1 fa-feather-alt" style="color: red;"></i>
                            Não cace nem colete espécies.
                        </li>
                        <li class="list-group-item" style="color:#661111">
                            <i class="fas me-1 fa-feather-alt" style="color: red;"></i>
                            Não faça fogueiras.
                        </li>
                    </ul>
                </div>
                </div>
            </section>
            <section style="color:#2b302b; padding-bottom: 0px;" class="col-md-4 px-5">
                <div class="">
                    <div class="d-flex justify-content-between my-4" style="font-size: 17px">
                        <div class="text-center ">
                        <i class="fas fa-shoe-prints fa-2x mb-2 fa-rotate-270" style="color: #4a9f51;" ></i>
                            <p style="color:#4f4f4f"><strong>Passeios</strong></p>
                        </div>
                        <div class="text-center ">
                        <i class="fas fa-walking fa-2x mb-2" style="color: #4a9f51;"></i>
                            <p style="color:#4f4f4f"><strong>Caminhadas</strong></p>
                        </div>
                        <div class="text-center ">
                            <i class="fas fa-hiking fa-2x mb-2" style="color: #4a9f51;"></i>
                            <p style="color:#4f4f4f"><strong>Escaladas</strong></p>
                        </div>
                    </div>
                    <div class="text-start d-flex flex-column justify-content-center ms-1" style="font-size:14px">
                    <div>
                        <p>
                            É sempre bom lembrar que a prática de atividades recreativas e
                            esportivas em áreas naturais <strong>oferece riscos</strong>, inclusive dentro de
                            parques públicos.
                        </p>

                    </div>
                    <hr style="width: 10%; color: #4a9f51;" class="m-0">
                    <div class="mt-3 mt-0">
                        <p>
                            Muitas outras <strong>atividades ao ar
                            livre</strong> podem ser feitas sem perturbar o ambiente natural, por isto
                            são atividades permitidas no interior dos parques.
                        </p>

                    </div>

                    </div>
                </div>
            </section>
            </div>
            <hr>
            <section class="mt-5">
                <div class="d-flex flex-column text-center">
                    <div class="mb-3">
                        <i class="fas fa-recycle fa-5x" style="color: #4a9f51;"></i>
                    </div>
                    <div>
                    <h5 class="section-title" style="font-size: 28px">
                        <strong>
                            Preserve o Meio Ambiente
                        </strong>
                    </h5>
                    </div>
                </div>
            </section>

    </section>
@endsection

@section('page-script')

<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"
></script>

@endsection
