@extends('layouts.web_base')


@section('content')
    <section>
        <div class="container">
            <div class="section-title">
                <h2>Sobre o Programa</h2>
            </div>
            <div class="row">
                <h4>O que é o programa?</h4>
                <p>O Programa foi criado com objetivo de estabelecer uma agenda ambiental para o Município alinhada aos objetivos de desenvolvimento sustentáveis da ONU, em busca de um Arraial mais sustentável e possui objetivos específicos:</p>
                <ul>
                    <li>Definir o planejamento estratégico da secretaria visando alinhar as ações e projetos que serão realizados na gestão 2021/ 2024;</li>
                    <li>Estabelecer Missão, Visão e Valores visando alinhar expectativas da equipe e população e para direcionar onde queremos chegar;</li>
                    <li>Realizar alinhamento com outras secretarias dos projetos e ações que serão realizados conjuntamente.</li>
                </ul>
            </div>

            <!-- IMAGEM -->
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                            <img src="../../../images/meuambiente01.png" class="img-fluid">
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div>
                            <p>ODS- Objetivos do Desenvolvimento Sustentável; 17 Pilares e 179 objetivos</p>
                            <p>PCS- Programa Cidades Sustentáveis; 12 eixos e 260 indicadores</p>
                            <p>Plano Diretor Municipal;</p>
                            <p>ICMS Ecológico;</p>
                            <p>Políticas Públicas de meio ambiente, saneamento e recursos hídricos- Estadual e Federal;</p>
                        </div>    
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-5">
                    <div>
                        <h5>Objetivo Geral</h5>
                    </div>
                    <div>
                        <p>Estabelecer uma agenda ambiental para o Município 
                            de Arraial do Cabo alinhada aos objetivos de desenvolvimento 
                            sustentáveis da ONU, em busca de um Arraial mais sustentável.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <h5>Objetivo Específico</h5>
                    </div>
                    <div>
                        <p>Definir o planejamento estratégico da secretaria visando 
                            alinhar as ações e projetos que serão realizados na gestão 
                            2021/ 2024;</p>
                        <p>Implementar os objetivos de desenvolvimento sustentáveis 
                            da Agenda 2030 da ONU;</p>
                        <p>Estabelecer Missão, Visão e Valores visando alinhar expectativas 
                            da equipe e população e para direcionar onde queremos chegar;</p>
                        <p>Realizar alinhamento com outras secretarias dos projetos e ações 
                            que serão realizados conjuntamente.</p>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 20px">
                <div class="d-grid gap-2 col-4 mx-auto">
                    <a href="{{ route ('projects_web_index') }}" style="color: #fafffa;">
                        <button type="button" class="btn w-100" style="height: 49px; background-color: #3cb347; border-color: #279f32">
                            NOSSOS PROJETOS
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection