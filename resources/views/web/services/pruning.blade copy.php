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
    <section id="pruning">
        <div class="container">
            <div class="section-title">
                <h1>Setor de Poda</h1>
            </div>
            <div class="row">
                <div class="container">
                    <h4>O que é o serviço de poda de árvore?</h4>
                    <p>O Serviço de Poda visa cuidar de toda arborização urbana
                        de forma adequada e de forma que não atrapalhe o desenvolvimento
                        das espécies, mediante vistoria de equipes técnicas e com
                        expertise no assunto, são eliminados ramos mortos, danificados,
                        doentes, praguejados, ou até mesmo espécies que colocam em risco
                        a segurança dos munícipes.</p>
                </div>
            </div>
            <div class="container">
                <div class="text-block">
                    <p>As árvores são importantes para todo o processo sustentável do meio
                        ambiente, porém o crescimento exagerado delas pode causar diversos
                        problemas como:</p>
                    <ul>
                        <li>Curto circuito em fios elétricos;</li>
                        <li>Derrubada de galhos e folhas sujando e até mesmo danificando
                            objetivos que estejam abaixo da árvore;</li>
                        <li>Risco de cair durante uma tempestade.</li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="container">
                    <div class="section-title">
                        <h2>Em quais casos posso solicitar a poda de árvores?</h2>
                    </div>
                </div>
                <div class="pruning-container">
                    <div class="row">
                        <div class="col-md-3">
                            <div>
                                <div class="pic">
                                    <img src="image1.jpg">
                                </div>
                                <h5 class="title">Poda de Manutenção</h5>
                                <div class="pruning-text-block">
                                    <p>Conferir uma forma adequada à árvore durante
                                    seu desenvolvimento.</p>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item" role="presentation">
                            <img src=../../../images/semas-poda-limpeza-logo.png>
                            <p class="nav-link border border-primary"
                                id="ex3-tab-1"
                                role="tab"
                                aria-controls="ex3-pills-1">
                                <strong>Poda de Limpeza</strong>
                            </p>
                            <div class="tab-pane text-center px-5">
                                <p class="card-text">Eliminar ramos doentes, praguejados ou danificados.</p>
                            </div>
                        </li>
                        <li class="nav-item" role="presentation">
                            <img src=../../../images/semas-poda-emergencia-logo.png>
                            <p class="nav-link border border-primary"
                                id="ex3-tab-1"
                                role="tab"
                                aria-controls="ex3-pills-1">
                                <strong>Poda de Emergência</strong>
                            </p>
                            <div class="tab-pane text-center px-5">
                                <p class="card-text">Retirar galhos que colocam em risco a segurança das pessoas.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <div class="pic">
                                    <img src="image1.jpg">
                                </div>
                                <h5 class="title">Poda de Adequação</h5>
                                <div class="pruning-text-block">
                                    <p>Adequar o desenvolvimento da árvore ao espaços, edificações
                                        ou equipamentos urbanos.</p>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item" role="presentation">
                            <img src=../../../images/semas-poda-supressao-logo.png>
                            <p class="nav-link border border-primary"
                                id="ex3-tab-1"
                                role="tab"
                                aria-controls="ex3-pills-1">
                                <strong>Supressão</strong>
                            </p>
                            <div class="tab-pane text-center px-5">
                                <p class="card-text">Retirada da árvore dentro da área particular ou pública.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>



            <div class="row">
                <div class="container">
                    <h4>Como posso solicitar os serviços de poda?</h4>
                        <div class="rounded-container mt-4 mb-4">
                        <button class="rounded-button">Solicitar Poda</button>
                    </div>
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
                        <strong>Poda em Área Pública</strong></a
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
                        ><strong>Supressão em Área Pública</strong></a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link border border-primary"
                        id="ex3-tab-2"
                        data-mdb-toggle="pill"
                        href="#ex3-pills-3"
                        role="tab"
                        aria-controls="ex3-pills-3"
                        aria-selected="false"
                        ><strong>Poda e Supressão em Área Pública</strong></a
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
                    <p class="card-text">O requerente precisa abrir uma solicitação na SEMAS, com nome
                        completo do requerente, endereço completo, número do documento,
                        número do telefone, ponto de referência, além de informar o motivo
                        para o qual está pedindo a referida poda. O tempo estimado é de
                        vinte dias a contar da entrada do requerimento, para que seja feita
                        a vistoria e assim emitido o laudo deferindo ou indeferindo a solicitação.
                    </p>
                </div>
                <div
                    class="tab-pane fade text-center px-5"
                    id="ex3-pills-2"
                    role="tabpanel"
                    aria-labelledby="ex3-tab-2"
                    >
                    <p class="card-text">O requerente precisa abrir uma solicitação na SEMAS, com nome
                        completo do requerente, endereço completo, número do documento,
                        número do telefone, ponto de referência, além de informar o
                        motivo para o qual está pedindo a referida supressão. Após a
                        solicitação, um técnico irá até o local para fazer uma vistoria,
                        sendo deferida, a diretoria de licenciamento ambiental irá
                        emitir uma licença. Vale ressaltar que o requerente terá que
                        realizar a compensação ambiental, com doação de mudas de espécies
                        nativas estipuladas pela diretoria de licenciamento ambiental.
                    </p>
                </div>
                <div
                    class="tab-pane fade text-center px-5"
                    id="ex3-pills-3"
                    role="tabpanel"
                    aria-labelledby="ex3-tab-3"
                    >
                    <p class="card-text">O requerente precisa abrir uma solicitação diretamente no
                        Protocolo. Quando o processo chega na secretaria, um técnico
                        vai até o endereço fazer uma vistoria. Após isso, a solicitação
                        com laudo técnico é encaminhada à diretoria de licenciamento
                        ambiental para prosseguimento.
                    </p>

                </div>
            </div>
            <!-- Pills content -->
        </div>
    </section>
@endsection
