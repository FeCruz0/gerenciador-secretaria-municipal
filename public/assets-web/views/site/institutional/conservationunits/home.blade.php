@extends('layouts.web_base')

@section('content')
    <section id="conservation-units">
        <div class="container">
            <div class="section-title">
                <h2>Unidades de Conservação</h2>
            </div>
            <!-- <div>
                <ul>
                    <li>1. Parque Municipal da Praia do Forno</li>
                    <li>2. Reserva Ecológica da Ilha de Cabo Frio</li>
                    <li>3. Reserva Biológica das Orquídeas</li>
                    <li>4. Reserva Biológica da Lagoa Salgada</li>
                    <li>5. Reserva Biológica do Brejo Jardim</li> 
                    <li>6. Reserva Biológica do Brejo do Espinho</li>
                    <li>7. Área de Proteção Ambiental do Município de Arraial do Cabo</li>
                    <li>8. Área de Proteção Ambiental do Morro da Cabocla</li>
                    <li>9. Área de Proteção Ambiental do Pontal do Atalaia</li>
                    <li>10. Área de Relevante Interesse Ecológico Ponta de Massambaba</li>
                    <li>11. Área de Relevante Interesse Ecológico do Morro do Telégrafo</li>
                    <li>12. Área de Relevante Interessante Ecológico do Morro do Vigia</li>
                    <li>13. Área de Relevante Interesse Ecológico do Morro do Miranda</li>
                    <li>14. Área de Relevante Interesse Ecológico do Morro do Forno</li>
                    <li>15. Parque Municipal da Fábrica</li>
                    <li>16. Parque Municipal Natural do Combro Grande</li>
                    <li>17. Parque Municipal da Praia do Pontal</li>
                    <li>18. Reserva Biológica Pontal do Atalaia</li>
                </ul>
            </div> -->
            <section>
                <div class="row">
                    <h5 class="card-title">Unidades de Conservação de Proteção Integral</h5>
                    <div class="container">
                        <div class="conservation-unity-container">
                            <div class="col-md-4">
                                <div>
                                    <h6>UC1</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <h6>UC2</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <h6>UC3</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="row">
                    <h5 class="card-title">Unidades de Conservação de Uso Estável</h5>
                    <div class="container">
                        <div class="conservation-unity-container">
                            <div class="col-md-4">
                                <div class="pic">
                                    <a href="{{ route('institutional.conservationunits.pecsol')}}">
                                        <img src="../../../img/logo/pecsol-logo.png"></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <h6>UC2</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <h6>UC3</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <h4 class="card-title">Uso Público</h4>
                <div class="container">
                    <h5 class="card-title">Adote a Conduta Consciente</h5>
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Informe-se sobre normas e 
                                regulamentos dos locais que vai visitar.</li>
                            <li class="list-group-item">Caminhe somente pelas trilhas; 
                                atalhos são perigosos e degradam o ambiente.</li>
                            <li class="list-group-item">Deixe cada coisa em seu lugar; 
                                não risque pedras ou troncos de árvores.</li>
                            <li class="list-group-item">Respeite a fauna e a flora: 
                                observe animais à distância, não os alimente, 
                                não cace nem colete espécies.</li>
                            <li class="list-group-item">Não faça fogueiras.</li>
                            <li class="list-group-item">Cuide do lixo que você produz 
                                até chegar a um ponto de coleta.</li>
                            <li class="list-group-item">Leve materiais de primeiros socorros.</li>
                            <li class="list-group-item">Informe às autoridades em caso de acidente.</li>
                        </ul>
                    </div>
                </div>
            
                <div class="container">
                    <h5 class="card-title">Ao ar livre</h5>
                    <p>Passeios, caminhadas, escaladas e muitas outras atividades ao ar 
                        livre podem ser feitas sem perturbar o ambiente natural, por isto 
                        são atividades permitidas no interior dos parques.</p>
                    <p>E sempre bom lembrar que a prática de atividades recreativas e 
                        esportivas em áreas naturais oferece riscos, inclusive dentro de 
                        parques públicos.
                        <a href="http://www.inea.rj.gov.br/wp-content/uploads/2019/02/esportes-em-ucs.pdf" target="_blank">
                            Saiba mais</a>.
                        É bom lembrar também que a caça, a 
                        captura de animais e a retirada de plantas são condutas ilegais.</p>
                </div>
            </section>

        </div>
    </section>
@endsection