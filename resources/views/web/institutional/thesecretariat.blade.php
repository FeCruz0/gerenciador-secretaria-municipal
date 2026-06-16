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

<section id= "thesecretariat" class="container">
    <div class="row">
        <!-- Título -->
        <div class="d-flex flex-column justify-content-center">
            <div class="mt-5 section-title text-start">
                <h1 class="mb-0 pb-0 text-center">
                    A Secretaria do  Meio Ambiente
                </h1>
            </div>
        </div>
        <!-- Título FIM -->
        <!-- Conteúdo -->
        <div class="px-4">
            <div>
                <div class="">
                    <p style="font-size: 16px">
                        A Secretaria Municipal do Ambiente e Saneamento faz parte da Administração Pública Direta Municipal  vinculada à Prefeitura Municipal.
                    <br><br>
                        Possui a competência de propor e executar as políticas municipais de meio ambiente e saneamento adotadas pelos poderes Executivo e Legislativo do Município de Arraial do Cabo.
                    <br><br>
                        O papel fundamental da Secretaria do Ambiente e Saneamento, é proteger a fauna e flora do município. Além disso, uma das suas responsabilidades é garantir que futuros empreendimento ou atividades causem menos impactos ambientais.
                    <br><br>
                        Portanto, a Secretaria foi criada com a finalidade de manter um município sustentável. Sendo assim, devendo ensinar a população a educação ambiental e conscientizando a importância de viver num ambiente sem poluição e preservado, sendo um importante aliado na conservação ambiental dos Municípios, pois sem sua implantação o ecossistema irá se degradar e futuras gerações irão sofrer as crises ambientais. Como por exemplo, falta de alimentos, água potável, e doenças respiratórias por falta de um ar limpo e sem poluição.
                    <br><br>
                        A Secretaria integra o Sistema Nacional do Meio Ambiente (SISNAMA), o Sistema Nacional de Gerenciamento de Recursos Hídricos (SNGRH), o Sistema Estadual de Gerenciamento de Recursos Hídricos (SEGRH) e o Sistema Nacional de Unidades de Conservação (SNUC) e o Sistema Nacional de Saneamento Básico.
                    <br><br>
                        Sendo orientada por um conjunto de normas de conduta que, manifestadas na missão, visão e valores determinam o seu comportamento funcional.
                    <br><br>
                        Cabe à Secretaria do Ambiente e Saneamento desenvolver e aplicar as seguintes políticas públicas: Plano Municipal de Educação Ambiental, Plano Municipal de Gerenciamento de Resíduos Sólidos, Plano Municipal de Zoneamento Costeiro , Plano Municipal de Mudanças Climáticas, Plano Municipal de Arborização Urbana, Plano Municipal de Saneamento Básico, Plano Municipal de Desenvolvimento Ambiental e Conservação da Biodiversidade, Plano Municipal da Mata Atlântica e Plano Municipal de Combate ao Lixo no Mar.
                    </p>
                </div>
            </div>
            <div class="ps-4 mt-0">
                <hr style="width: 40px; height: 2px; color:#198754; opacity: 0.50;" class="mt-3">
            </div>
            <div class="d-flex flex-column justify-content-center mt-5">
                <div class=" section-title text-start">
                    <h2 class="mb-0 pb-0 text-center" style="font-size: 25px">
                        <strong>Princípios</strong>
                    </h2>
                </div>
            </div>
            <!-- Pills navs -->
            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <img src=../../../images/secretaria-missao-logo.png>
                    <a
                        class="nav-link active border border-primary"
                        id="ex3-tab-1"
                        data-mdb-toggle="pill"
                        href="#ex3-pills-1"
                        role="tab"
                        aria-controls="ex3-pills-1"
                        aria-selected="true"
                        >
                        <strong>Missão</strong></a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <img src=../../../images/secretaria-visao-logo.png>
                    <a
                        class="nav-link border border-primary"
                        id="ex3-tab-2"
                        data-mdb-toggle="pill"
                        href="#ex3-pills-2"
                        role="tab"
                        aria-controls="ex3-pills-2"
                        aria-selected="false"
                        ><strong>Visão</strong></a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <img src=../../../images/secretaria-valores-logo.png>
                    <a
                        class="nav-link border border-primary"
                        id="ex3-tab-3"
                        data-mdb-toggle="pill"
                        href="#ex3-pills-3"
                        role="tab"
                        aria-controls="ex3-pills-3"
                        aria-selected="false"
                        ><strong>Valores</strong></a
                    >
                </li>
            </ul>
            <div style="text-align:center">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="ex3-pills-1" role="tabpanel" aria-labelledby="ex3-pills-1-tab">
                        Promover a preservação, a conservação e a recuperação dos ecossistemas, desenvolvendo e implementando as políticas públicas relativas à qualidade ambiental, à biodiversidade, aos recursos hídricos e ao saneamento, visando à manutenção do equilíbrio ecológico, ao uso racional dos recursos naturais, à qualidade de vida e ao desenvolvimento sustentável, para as gerações presentes e futuras.
                    </div>
                    <div class="tab-pane fade" id="ex3-pills-2" role="tabpanel" aria-labelledby="ex3-pills-2-tab">
                        Ser referência na gestão das políticas públicas de meio ambiente, saneamento e recursos hídricos da Região dos Lagos.
                    </div>
                    <div class="tab-pane fade" id="ex3-pills-3" role="tabpanel" aria-labelledby="ex3-pills-3-tab">
                        Governança. Integridade. Eficiência. Transparência. Inovação. Participação Social. Responsabilidade Compartilhada.
                    </div>
                </div>
            </div>
            <!-- Pills navs FIM -->
        </div>
        <!-- Conteúdo FIM -->
    </div>
</section>

        <hr>

    <!-- NOSSA EQUIPE     -->
    <section>
        <div class="row">
            <div class="d-flex flex-column justify-content-center mt-5">
                <div class=" section-title text-start">
                    <h2 class="mb-0 pb-0 text-center" style="font-size: 25px">
                        <strong>Nossa Equipe</strong>
                    </h2>
                </div>
            </div>
            <div class="our-team-container">
                <div class="col-md-3">
                    <div class="our-team">
                        <h5 class="title">Jorge Oliveira</h5>
                        <span class="post">Secretário do Ambiente e Saneamento</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="our-team">
                        <h5 class="title">Keila Ferreira</h5>
                        <span class="post">Sub-secretária do Ambiente e Saneamento</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- NOSSA EQUIPE  FIM   -->
@endsection
@section('page-script')

<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"
></script>

@endsection

<!-- página duplicada -->