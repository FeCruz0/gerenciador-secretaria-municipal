@extends('layouts.web_base')

@section('content')

<section id= "thesecretariat" class="container">
        <div class="section-title">
            <h2>A Secretaria</h2>
        </div>
        <div class="row">
            <p>A Secretaria Municipal do Ambiente e Saneamento faz parte da Administração Pública Direta Municipal 
            vinculada à Prefeitura Municipal.
            </p>
            <p>Possui a competência de propor e executar as políticas municipais de meio ambiente e saneamento 
            adotadas pelos poderes Executivo e Legislativo do Município de Arraial do Cabo. 
            </p>
            <p>A Secretaria integra o Sistema Nacional do Meio Ambiente (SISNAMA), o Sistema Nacional de 
            Gerenciamento de Recursos Hídricos (SNGRH), o Sistema Estadual de Gerenciamento de Recursos 
            Hídricos (SEGRH) e o Sistema Nacional de Unidades de Conservação (SNUC) e o Sistema Nacional de 
            Saneamento Básico.
            </p>
            <p>Sendo orientada por um conjunto de normas de conduta que, manifestadas na missão, visão e 
            valores determinam o seu comportamento funcional.
            </p>

        </div>
        <hr>

        <!-- PRINCÍPIOS -->
        <section>
            <div class="row">
                <h5 class="card-title">Princípios</h5>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">1. Missão</h5>
                            <p class="card-text">Promover a preservação, a conservação e a 
                                recuperação dos ecossistemas, desenvolvendo e implementando 
                                as políticas públicas relativas à qualidade ambiental, à 
                                biodiversidade, aos recursos hídricos e ao saneamento, 
                                visando à manutenção do equilíbrio ecológico, ao uso racional 
                                dos recursos naturais, à qualidade de vida e ao desenvolvimento 
                                sustentável, para as gerações presentes e futuras.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">2. Visão</h5>
                            <p class="card-text">Ser referência na gestão das políticas 
                                públicas de meio ambiente, saneamento e recursos hídricos 
                                da Região dos Lagos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">3. Valores</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Governança</li>
                                <li class="list-group-item">Integridade</li>
                                <li class="list-group-item">Eficiência</li>
                                <li class="list-group-item">Transparência</li>
                                <li class="list-group-item">Inovação</li>
                                <li class="list-group-item">Participação Social</li>
                                <li class="list-group-item">Responsabilidade Compartilhada</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <hr>
        
    <!-- NOSSA EQUIPE     -->
        <section>
            <div class="row">
                <h5 class="card-title">Nossa Equipe</h5>
                <div class="our-team-container">
                    <div class="col-md-3">
                        <div class="our-team">
                            <div class="pic">
                                <img src="../../../img/profile/jorge-oliveira.png">
                            </div>
                            <h5 class="title">Jorge Oliveira</h5>
                            <span class="post">Secretário do Ambiente e Saneamento</span>
                        </div>
                    </div>
            
                    <div class="col-md-3">
                        <div class="our-team">
                            <div class="pic">
                                <img src="../../../img/profile/keila-ferreira.png">
                            </div>
                            <h5 class="title">Keyla Ferreira</h5>
                            <span class="post">Subsecretária do Ambiente e Saneamento</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection

