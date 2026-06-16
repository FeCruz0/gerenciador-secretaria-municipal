@extends('layouts.web_base')


@section('content')
    <section id="costumer-service">
        <div class="container">
            <div class="section-title">
                <h2>Atendimento ao Público</h2>
            </div>
            <div class="row">

            <!-- SUB MENU OUVIDORIA -->
                <div class="col-md-2">
                    <div class="environment-licensing-menu">
                        <button type="button" onclick="ouvidoria()" class="btn btn-success">
                            <a>Ouvidoria</a>
                        </button>
                        <button type="button" onclick="denuncia()" class="btn btn-success">
                            <a>Denúncia Ambiental</a>
                        </button>
                        <button type="button" onclick="licenciamento()" class="btn btn-success">
                            <a>Atendimento ao Licenciamento</a>
                        </button>
                        <button type="button" onclick="poda()" class="btn btn-success">
                            <a>Atendimento à Poda</a>
                        </button>
                    </div>
                </div>

                <!-- OUVIDORIA -->
                <div class="col-md-6 ouvidoria">
                    <div class="container">
                        <h5 class="card-title">Ouvidoria</h5>
                        <p>Núcleo de Atendimento ao Público: Recebe, expede 
                            e encaminha documentos e processos administrativos 
                            relacionados, especificamente, ao Licenciamento Ambiental.</p>
                        <p>Presencial: Rua Tókio, nº 76, Baleia- Arraial do 
                            Cabo (sede). De segunda a sexta-feira, das 9h às 17h.</p>
                        <p>WhatsApp: (22) xxxxxxxxxx. De segunda a sexta-feira, das 9h às 17h.</p>
                        <p>Para entrar em contato com o a Secretaria do Ambiente e 
                            Saneamento, preencha o formulário ou envie um e-mail 
                            para <a href="mailto:gab.ambiente@arraial.rj.gov.br">nosso contato</a>.</p>
                    </div>
                </div>

                <!-- DENUNCIA AMBIENTAL -->
                <div class="col-md-6 denuncia" style="display: none;">
                    <div class="container">
                        <h5 class="card-title">Denúncia Ambiental</h5>
                        <p>Antes de fazer sua denúncia ambiental ou solicitar uma 
                            fiscalização ambiental leia atentamente as informações 
                            abaixo:</p>
                        <p>DENÚNCIAS E FISCALIZAÇÕES DE COMPETÊNCIA DA SEMAS</p>
                        <p>São de competência da SEMAS as denúncias e fiscalizações 
                            ambientais de ações que envolvam:</p>
                            <div style="width:auto;">
                                <img src="../../../img/content/denuncias-ambientais-1.png">
                            </div>
                            <div>
                                <img src="../../../img/content/denuncias-ambientais-2.png">
                            </div>
                        <p>Presencial: Rua Tókio, nº 76, Baleia- Arraial do Cabo (sede). 
                            De segunda a sexta-feira, das 9h às 17h.</p>
                        <p>Por WhatsApp: (22) xxxxxxxxxx. Todos os dias, das 9h às 17h.</p>
                        <p>Para entrar em contato com o setor de Fiscalização da  
                            Secretaria do Ambiente e Saneamento de Arraial do Cabo, 
                            preencha o formulário ou envie um e-mail para
                            <a href="mailto:fiscalizacaosemas@arraial.rj.gov.br">nosso contato</a>.</p>
                        <p>* Para denúncias de crimes ambientais, 
                            <a href="{{ route('services.fiscalization') }}">acesse o link</a>.</p>
                    </div>
                </div>

                <!-- ATENDIMENTO LICENCIAMENTO -->
                <div class="col-md-6 licenciamento" style="display: none;">
                    <div class="container">
                        <h5 class="card-title">Atendimento ao Licenciamento</h5>
                        <p>Recebe, expede e encaminha documentos e processos 
                            administrativos relacionados, especificamente, ao Sistema 
                            Estadual de Licenciamento Ambiental.</p>
                        <p>Presencial: Rua Tókio, nº 76, Baleia- Arraial do Cabo (sede). 
                            De segunda a sexta-feira, das 9h às 17h.</p>
                        <p>Para entrar em contato com o setor de Licenciamento  da  
                            Secretaria do Ambiente e Saneamento de Arraial do Cabo, 
                            preencha o formulário ou envie um e-mail para
                            <a href="mailto:XXX@arraial.rj.gov.br">nosso contato</a>.</p>
                        <p>* Para denúncias de crimes ambientais, 
                            <a href="{{ route('services.fiscalization') }}">acesse o link</a>.</p>
                        <p>ATENÇÃO</p>
                        <p>1. A abertura de processo referente ao licenciamento não é 
                            feita de maneira eletrônica, apenas presencial no Protocolo 
                            Geral da prefeitura;</p>
                        <p>2. Procure anexar todos os documentos solicitados nos checklists 
                            de cada atividade na abertura do processo;</p>
                        <p>3. Confira os checklists
                        <a href="{{ route('services.environmentlicensing.checklist') }}">aqui</a>.</p>
                    </div>
                </div>

                <!-- ATENDIMENTO PODA -->
                <div class="col-md-6 poda" style="display: none;">
                    <div class="container">
                        <h5 class="card-title">Atendimento à Poda</h5>
                        <p>Recebe, expede e encaminha documentos e processos 
                            administrativos relacionados, especificamente, 
                            ao Sistema Estadual de Licenciamento Ambiental.</p>
                        <p>Presencial: Rua Tókio, nº 76, Baleia- Arraial do Cabo (sede). 
                            De segunda a sexta-feira, das 9h às 17h.</p>
                        <p>Para entrar em contato com o setor de Poda  da  
                            Secretaria do Ambiente e Saneamento de Arraial do Cabo, 
                            preencha o formulário ou envie um e-mail para
                            <a href="mailto:poda.semas@arraial.rj.gov.br">nosso contato</a>.</p>
                        <p>ATENÇÃO</p>
                        <p>1. A abertura de processo referente à Poda pode ser
                            feita através do
                            <a href="{{ route('services.pruning') }}">link</a>.</p>
                        <p>2. Procure anexar todos os documentos solicitados;</p>
                    </div>
                </div>
                
                <!-- FORMULARIO -->
                <div class="col-md-4">
                    <div class="container">
                        <div class="container">
                            <form>
                                <label for="inputEmail" class="form-label">Formulário de Atendimento:</label>
                                <div class="mb-3">    
                                    <input type="text" class="form-control" id="nome" placeholder="Nome Completo">
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" id="email" placeholder="E-mail" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <button type="button" onclick="anonimo()" class="btn btn-primary">Anônimo</button>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Assunto">
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" id="mensagemOuvidoria" placeholder="Mensagem" rows="3"></textarea>
                                </div>
                                <div id="emailHelp" class="form-text">Suas informações não serão compartilhadas.</div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </section>
@endsection
    <script>
        function ouvidoria(){
            $(".ouvidoria").show();
            $(".denuncia").hide();
            $(".licenciamento").hide();
            $(".poda").hide();
        }

        function denuncia(){
            $(".ouvidoria").hide();
            $(".denuncia").show();
            $(".licenciamento").hide();
            $(".poda").hide();
        }

        function licenciamento(){
            $(".ouvidoria").hide();
            $(".denuncia").hide();
            $(".licenciamento").show();
            $(".poda").hide();
        }

        function poda(){
            $(".ouvidoria").hide();
            $(".denuncia").hide();
            $(".licenciamento").hide();
            $(".poda").show();
        }

        var anom = false;
        function anonimo(){
            if(anom == false){
            	document.getElementById('nome').value = "";
                document.getElementById('nome').disabled = true;
                document.getElementById('email').value = "";
                document.getElementById('email').disabled = true;
                anom = true;
            }
            else{
                document.getElementById('nome').disabled = false;
                document.getElementById('email').disabled = false;
                anom = false;
            }
        }
    </script>