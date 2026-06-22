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
            <div class="section-title">
                <h2>Licenciamento Ambiental</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="environment-licensing-menu">
                        <a class="btn btn-success" href="{{ route('web_services.environmentlicensing.postlicense') }}" style="display: flex;">
                            Pós Licença</a>
                        <a class="btn btn-success" href="{{ route('web_services.environmentlicensing.checklist') }}" style="display: flex;">
                            Checklist</a>
                        <a class="btn btn-success" href="{{ route('web_services.environmentlicensing.forms') }}" style="display: flex;">
                            Formulários</a>
                        @if (isset($enviromental_licensing->file))
                            <a class="btn btn-success" href="{{ route('file_web', $enviromental_licensing->file->id) }}" style="display: flex;">
                                Relatórios</a>
                        @endif
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="container">
                        <p class="card-text">O licenciamento ambiental é o procedimento administrativo por meio do qual a
                            Secretaria faz o necessário controle sobre empreendimentos ou atividades que
                            utilizam recursos naturais ou que possam causar, sob qualquer forma, algum
                            tipo de poluição ou degradação ao meio ambiente.
                        </p>
                        <p class="card-text">No Município de Arraial, os procedimentos de licenciamento são regidos pelo
                            Sistema Municipal de Licenciamento Ambiental e demais Procedimentos de
                            Controle Ambiental, tendo a Lei Municipal 1.544/07 juntamente com a Resolução
                            conjunta GESEM/SECOU Nº 001/22.
                        </p>
						<p class="card-text">Após a concessão das licenças ou demais tipos de instrumentos de controle
                        ambiental, a Secretaria faz o acompanhamento dessas atividades e
                        empreendimentos, visando garantir o efetivo cumprimento das exigências e
                        condicionantes durante a vigência das autorizações concedidas. Nesta etapa,
                        chamada pós-licença, a secretaria integra informações do monitoramento com
                        as ferramentas de gestão e programas de autocontrole.
                    	</p><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="text-block">
				
                    <p class="card-text">A fiscalização das atividades licenciadas ou autorizadas poderá
                        ocorrer no decorrer de todo o processo de licenciamento e na etapa
                        de pós-licença, bem como após seu encerramento, visando atendimento
                        às normas ambientais e promoção da recuperação de eventual passivo.</p>
                    <p class="card-text">Além disso, serão objeto de fiscalização pelo órgão ambiental as
                        atividades irregulares, ou seja, aquelas que deveriam ser objeto de
                        instrumento de controle ambiental (licenças, autorizações etc.) mas
                        não se encontram respaldadas pelos devidos instrumentos, ou que violem
                        demais normas ambientais.</p>
                    <p class="card-text">A lei que estabelece as infrações ambientais administrativas no âmbito
                        do Estado do Rio de Janeiro é a Lei Estadual nº 3.467/2000, e em nível
                        municipal o Decreto de nº 1.826/2010 fundamenta a aplicação de sanções
                        administrativas pela Secretaria.
                    </p>
                </div>
            </div>
            <div class="row">
                <p class="card-text">As denúncias de atividades irregulares devem ser feitas pelo
                    <a href="mailto: fiscalizacaogesem@arraial.rj.gov.br">e-mail</a></p>
            </div>
            <hr>
            <div class="row">
                <div class="container">
                    <div class="section-title">
                        <h2 class="title">Normas utilizadas no licenciamento:</h2>
                    </div>
                </div>
                <p class="card-text">1. A legislação para o enquadramento é a
                    <a href="http://www.inea.rj.gov.br/wp-content/uploads/2022/03/NOP-INEA-46-Enquadramento-de-atividades.pdf" target="_blank">
                        NOP-INEA-46 - Enquadramento de atividades</a> e
                    <a href="http://www.inea.rj.gov.br/wp-content/uploads/2022/03/Anexos-NOP-INEA-46-Boletim-de-Servi%C3%A7o-2021-n110.pdf" target="_blank">
                        NOP-INEA-46 – Boletim de Serviço 2021 n110</a>.</p>
                <p class="card-text">2. Os custos de análise constam na
                    <a href="http://www.inea.rj.gov.br/wp-content/uploads/2022/03/NOP-INEA-02.R-3-Indeniza%C3%A7%C3%A3o-dos-Custos-de-An%C3%A1lise1.pdf" target="_blank">
                        NOP-INEA-02.R-3 – Indenização dos Custos de Análise</a>.</p>
            </div>
        </div>
    </section>
@endsection
@section('page-script')

<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"
></script>

@endsection
