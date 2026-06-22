@extends('layouts.web_base')
@section('content')
    @foreach ($home_modules as $module)
        @include('web.home.partials.' . $module->name)
    @endforeach

    @if(isset($organs) && count($organs) > 0)
        <!-- ======= Organs Section ======= -->
        <section id="organs" class="services section-bg" style="background-color: #0f172a; padding: 60px 0;">
            <div class="container">
                <div class="section-title text-center mb-5">
                    <h2 style="color: #f1f5f9; font-weight: 700; font-size: 32px; position: relative; margin-bottom: 20px; font-family: 'Montserrat', sans-serif;">Secretarias e Órgãos Vinculados</h2>
                    <p style="color: #94a3b8; font-size: 15px; max-width: 600px; margin: 0 auto;">Selecione o órgão correspondente para acessar as páginas, notícias, licitações e informações específicas.</p>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach($organs as $organ)
                        <div class="col-lg-4 col-md-6">
                            <div class="card border-0 shadow-lg text-center h-100 transition" style="background-color: #1e293b; border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); transition: transform 0.3s ease;">
                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="icon-box mb-4 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; border-radius: 50%; background-color: {{ $organ->theme_color_hex }}1a; border: 1px solid {{ $organ->theme_color_hex }}33; color: {{ $organ->theme_color_hex }}; font-weight: 700; font-size: 20px; font-family: 'Montserrat', sans-serif;">
                                            {{ $organ->sigla }}
                                        </div>
                                        <h5 class="card-title font-semibold mb-3" style="color: #f1f5f9; font-size: 18px; font-family: 'Montserrat', sans-serif;">{{ $organ->name }}</h5>
                                        <p class="card-text text-sm" style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Acesse o portal da secretaria para consultar banners, atalhos, notícias específicas, perguntas frequentes e serviços do setor.</p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="/{{ $organ->slug }}" class="btn btn-outline-light rounded-pill px-4" style="border-color: {{ $organ->theme_color_hex }}40; color: #f1f5f9; font-weight: 500; font-size: 13px; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='{{ $organ->theme_color_hex }}'; this.style.borderColor='{{ $organ->theme_color_hex }}'" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='{{ $organ->theme_color_hex }}40'">Acessar Portal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection