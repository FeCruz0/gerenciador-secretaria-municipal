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

    <section id="conservation_units">
        <div class="container">
            <div class="row mt-5">
                <!-- Projeto -->
                <div class="col-md-12 mb-5">
                    <div class="">
                        <div class="col-md-12">
                            <div class="row mb-4">

                                <!-- Título -->
                                <div class="d-flex flex-column justify-content-center">
                                    <div class="mt-5 section-title text-start">
                                        <h1 class="mb-0 pb-0 text-center">
                                            A Secretaria
                                        </h1>
                                    </div>
                                </div>
                                <!-- Título FIM -->
                                <!-- Conteúdo -->
                                <div class="px-4">
                                    <div class="p-5">
                                        <div class="">
                                            <p style="font-size: 16px">
                                                A Secretaria Municipal do Ambiente e Saneamento faz parte da Administração Pública Direta Municipal vinculada à Prefeitura Municipal.
                                            </p>
                                            <p style="font-size: 16px">
                                                Possui a competência de propor e executar as políticas municipais de meio ambiente e saneamento adotadas pelos poderes Executivo e Legislativo do Município de Arraial do Cabo.
                                            </p>
                                            <p style="font-size: 16px">
                                                O papel fundamental da Secretaria do Ambiente e Saneamento, é proteger a fauna e flora do município. Além disso, uma das suas responsabilidades é garantir que futuros empreendimento ou atividades causem menos impactos ambientais.
                                            </p>
                                            <p style="font-size: 16px">
                                                Portanto, a Secretaria foi criada com a finalidade de manter um município sustentável. Sendo assim, devendo ensinar a população a educação ambiental e conscientizando a importância de viver num ambiente sem poluição e preservado, sendo um importante aliado na conservação ambiental dos Municípios, pois sem sua implantação o ecossistema irá se degradar e futuras gerações irão sofrer as crises ambientais. Como por exemplo, falta de alimentos, água potável, e doenças respiratórias por falta de um ar limpo e sem poluição.
                                            </p>
                                            <p style="font-size: 16px">
                                                A Secretaria integra o Sistema Nacional do Meio Ambiente (SISNAMA), o Sistema Nacional de Gerenciamento de Recursos Hídricos (SNGRH), o Sistema Estadual de Gerenciamento de Recursos Hídricos (SEGRH) e o Sistema Nacional de Unidades de Conservação (SNUC) e o Sistema Nacional de Saneamento Básico.
                                            </p>
                                            <p style="font-size: 16px">
                                                Sendo orientada por um conjunto de normas de conduta que, manifestadas na missão, visão e valores determinam o seu comportamento funcional.
                                            </p>
                                            <p style="font-size: 16px">
                                                Cabe à Secretaria do Ambiente e Saneamento desenvolver e aplicar as seguintes políticas públicas: Plano Municipal de Educação Ambiental, Plano Municipal de Gerenciamento de Resíduos Sólidos, Plano Municipal de Zoneamento Costeiro , Plano Municipal de Mudanças Climáticas, Plano Municipal de Arborização Urbana, Plano Municipal de Saneamento Básico, Plano Municipal de Desenvolvimento Ambiental e Conservação da Biodiversidade, Plano Municipal da Mata Atlântica e Plano Municipal de Combate ao Lixo no Mar.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center mt-5">
                                        <div class=" section-title text-start">
                                            <h2 class="mb-0 pb-0 text-center" style="font-size: 25px">
                                                <strong>Princípios</strong>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link  active" id="v-pills-mission-tab" data-toggle="pill" href="#v-pills-mission" role="tab" aria-controls="v-pills-mission" aria-selected="true"><h3>Missão</h3></a>
                                            <a class="nav-link" id="v-pills-vision-tab" data-toggle="pill" href="#v-pills-vision" role="tab" aria-controls="v-pills-vision" aria-selected="false"><h3>Visão</h3></a>
                                            <a class="nav-link" id="v-pills-values-tab" data-toggle="pill" href="#v-pills-values" role="tab" aria-controls="v-pills-values" aria-selected="false"><h3>Valores</h3></a>
                                          </div>
                                        </div>
                                        <div class="col-9">
                                          <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-mission" role="tabpanel" aria-labelledby="v-pills-mission-tab">
                                                Promover a preservação, a conservação e a recuperação dos ecossistemas, desenvolvendo e implementando as políticas públicas relativas à qualidade ambiental, à biodiversidade, aos recursos hídricos e ao saneamento, visando à manutenção do equilíbrio ecológico, ao uso racional dos recursos naturais, à qualidade de vida e ao desenvolvimento sustentável, para as gerações presentes e futuras.
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-vision" role="tabpanel" aria-labelledby="v-pills-vision-tab">
                                                Ser referência na gestão das políticas públicas de meio ambiente, saneamento e recursos hídricos da Região dos Lagos.
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-values" role="tabpanel" aria-labelledby="v-pills-values-tab">
                                                Governança. Integridade. Eficiência. Transparência. Inovação. Participação Social. Responsabilidade Compartilhada.
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Conteúdo fim -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Unidade de Conservação FIm -->

            </div>
        </div>
    </section>
@endsection
@section('page-script')

<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"
></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

@endsection
