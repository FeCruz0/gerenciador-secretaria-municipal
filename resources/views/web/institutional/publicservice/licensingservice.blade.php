@extends('layouts.web_base')


@section('content')
    <section id="costumer-service">
        <div class="container">
            <div class="section-title">
                <h2>Atendimento ao Público</h2>
            </div>
            <div class="row">

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
                            <a href="{{ route('web_services.fiscalization') }}">acesse o link</a>.</p>
                        <p>ATENÇÃO</p>
                        <p>1. A abertura de processo referente ao licenciamento não é 
                            feita de maneira eletrônica, apenas presencial no Protocolo 
                            Geral da prefeitura;</p>
                        <p>2. Procure anexar todos os documentos solicitados nos checklists 
                            de cada atividade na abertura do processo;</p>
                        <p>3. Confira os checklists
                        <a href="{{ route('web_services.environmentlicensing.checklist') }}">aqui</a>.</p>
                    </div>
                </div>
                
                <!-- FORMULARIO -->
                <div class="col-md-6">
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