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
    <section id="postlicense">
        <div class="container">
            <div class="section-title">
                <h2>Pós Licença</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="environment-licensing-menu">
                        <a class="btn btn-success" href="{{ route('licenciamento_ambiental_web') }}" style="display: flex;">
                            Licenciamento Ambiental</a>
                        <a class="btn btn-success" href="{{ route('web_services.environmentlicensing.checklist') }}" style="display: flex;">
                            Checklist</a>
                        <a class="btn btn-success" href="{{ route('web_services.environmentlicensing.forms') }}" style="display: flex;">
                            Formulários</a>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="container">
                        <p>No momento subsequente à etapa de avaliação e aprovação das
                             atividades de licenciamento, tem início o acompanhamento e 
                             o controle criterioso da instalação e operação das atividades 
                             licenciadas, integrando o monitoramento e a fiscalização com 
                             as ferramentas de gestão e programas de autocontrole, o que 
                             possibilita uma avaliação crítica do licenciamento ambiental.
                        </p>
                        <p>Esta etapa, chamada pós-licença, é também um instrumento de 
                            controle ambiental, por meio do qual a Secretaria acompanha 
                            e fiscaliza as atividades utilizadoras de recursos ambientais, 
                            efetiva ou potencialmente poluidores e as licenciadas, integrando 
                            informações do do monitoramento com as ferramentas de gestão e 
                            programas de autocontrole, visando garantir a performance ambiental 
                            das mesmas durante a vigência das autorizações concedidas.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <p>A observância e a revisão dos procedimentos e das condicionantes 
                        possibilitam uma maior confiabilidade no sistema, na medida em 
                        que o monitoramento evidencia e legitima a tomada de decisão do 
                        licenciador a partir da avaliação em tese realizada no licenciamento, 
                        por meio do enfoque na melhoria da qualidade ambiental.
                    </p>
                    <p>Essa etapa se traduz na prática pela ações de controle das condicionantes 
                        e auditorias ambientais.
                    </p>
                </div>
            </div>

            <!-- Pills navs -->
            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link active border border-primary"
                        id="ex3-tab-1"
                        data-mdb-toggle="pill"
                        href="#ex3-pills-1"
                        role="tab"
                        aria-controls="ex3-pills-1"
                        aria-selected="true"
                        >
                        <strong>Controle de Condicionante</strong></a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link border border-primary"
                        id="ex3-tab-2"
                        data-mdb-toggle="pill"
                        href="#ex3-pills-2"
                        role="tab"
                        aria-controls="ex3-pills-2"
                        aria-selected="false"
                        ><strong>Auditoria Ambiental</strong></a
                    >
                </li>
            </ul>
            <!-- Pills navs -->

            <!-- Pills content -->
            <div class="tab-content" id="ex2-content">
                <div
                    class="tab-pane fade show active text-center px-5"
                    id="ex3-pills-1"
                    role="tabpanel"
                    aria-labelledby="ex3-tab-1"
                    >
                    <p>O controle de condicionantes é um instrumento de controle 
                        ambiental por meio do qual a Secretaria acompanha e fiscaliza 
                        as atividades utilizadoras de recursos ambientais, efetiva ou 
                        potencialmente poluidores, e as licenças ambientais concedidas, 
                        integrando informações do monitoramento com as ferramentas de 
                        gestão e programas de autocontrole, visando garantir a performance 
                        ambiental das atividades durante a vigência da autorização concedida.
                    </p>
                    <p>Como parte do controle ambiental das atividades e empreendimentos 
                        sujeitos ao licenciamento ambiental, destaca-se o acompanhamento 
                        do atendimento das condicionantes das licenças ambientais emitidas 
                        pela Secretaria. Esse acompanhamento é realizado por meio de 
                        vistorias em campo, das análises dos programas, estudos, projetos 
                        e auditorias ambientais apresentados a Secretaria por meio de 
                        documentos técnicos, dos monitoramentos dos compartimentos ambientais 
                        realizados e pelos dados e informações fornecidos pelos programas 
                        de autocontrole.
                    </p>
                    <p>Assim, a Secretaria avalia se os compromissos ambientais assumidos 
                        pelo empreendedor durante o licenciamento ambiental, tais como 
                        condições de funcionamento, restrições e medidas de controle 
                        ambiental, estão sendo cumpridos. A conformidade do cumprimento 
                        das condicionantes da licença ambiental é um dos quesitos que 
                        garantem a qualidade ambiental da região onde o empreendimento 
                        está localizado. Além disso, possibilita garantir a mitigação e 
                        até a compensação dos impactos ambientais não mitigáveis.
                    </p>
                </div>
                <div
                    class="tab-pane fade text-center px-5"
                    id="ex3-pills-2"
                    role="tabpanel"
                    aria-labelledby="ex3-tab-2"
                    >
                    <p>As Auditorias Ambientais são processos sistemáticos de verificação, 
                        documentado e realizado de forma independente, nas modalidades 
                        Auditoria Ambiental de Controle e Auditoria Ambiental de 
                        Acompanhamento, executado no âmbito do processo de licenciamento 
                        ambiental para obter evidências e avaliá-las objetivamente, 
                        quanto a atividade licenciada.
                    </p>
                    <p>Os resultados dessas auditorias são consolidados no Relatório de 
                        Auditoria Ambiental, documento destinado ao órgão ambiental e 
                        elaborado pela equipe auditora. De uma maneira geral, esses 
                        resultados apontam conformidades e não-conformidades no desempenho 
                        ambiental da atividade, que norteiam e orientam a elaboração de 
                        um Plano de Ação para implantação de melhorias ou adequações no 
                        processo ou nos sistemas de controle.
                    </p>
                    <p>A Auditoria Ambiental de Controle é realizada normalmente a cada 
                        requerimento ou renovação de licença ambiental, para verificação 
                        detalhada do desempenho ambiental da organização em operação, com 
                        base em conformidade legal e em suas políticas e práticas de controle.
                    </p>
                    <p>A Auditoria Ambiental de Acompanhamento é realizada a cada ano, 
                        com ênfase no acompanhamento do Plano de Ação da última auditoria 
                        ambiental, complementando-o com novas medidas advindas de eventuais 
                        novas exigências do órgão ambiental, alterações significativas nos 
                        aspectos e impactos ambientais e mudanças em processo, entre outros.
                    </p>
                    <p>O procedimento da Auditoria Ambiental foi regulamentado pela DZ-056.R-3 
                        – Diretriz para realização de Auditoria Ambiental, aprovada pela 
                        Resolução Conema nº 021/2010.
                    </p>
                </div>
            </div>
            <!-- Pills content -->

        </div>
    </section>
@endsection
@section('page-script')

<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"
></script>

@endsection
