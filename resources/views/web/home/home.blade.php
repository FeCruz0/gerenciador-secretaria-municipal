@extends('layouts.web_base')
@section('content')
<!-- Carousel wrapper -->
    <div id="carouselHomeBanner" class="carousel slide carousel-fade" data-mdb-ride="carousel" style="height:260px;">
        <!-- Indicators -->
        <div class="carousel-indicators">
            @php
                $i=0;
            @endphp
            @foreach($posts as $post)
                <button
                type="button"
                data-mdb-target="#carouselHomeBanner"
                data-mdb-slide-to={{ $i }}
                @if ($i == 0)
                    class="active"
                    aria-current="true"
                @endif
                aria-label={{ $post->title }}
                ></button>
                @php
                    $i++;
                @endphp
            @endforeach
        </div>

        <!-- Inner -->
        <div class="carousel-inner" style="height:260px;">
            @php
                $img_bg = "";
                $verification = false;
            @endphp
            @foreach($posts as $post)
                @foreach($post->media as $img)
                    @if($img->type_media_id == 1)
                        @php
                            $img_bg = $img->url;
                        @endphp
                    @else
                        @php
                            $img_sm = $img->url;
                        @endphp
                    @endif
                @endforeach
                    @if ($verification)
                        <!-- Single item -->
                        <div class="carousel-item">
                            <img src="{{asset('storage/images/posts/' . $img_bg)}}" class="d-block w-100" alt="Sunset Over the City"/>
                            @if (!isset($post->title))
                                <div class="carousel-caption d-none d-md-block" >
                                    <h5>{{ $post->title }}</h5>
                                    <p>{{ $post->sub_title }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        @php
                            $verification = true;
                        @endphp
                        <!-- Single item -->
                        <div class="carousel-item active">
                            <img src="{{asset('storage/images/posts/' . $img_bg)}}" class="d-block w-100" alt="Sunset Over the City"/>
                            @if (!isset($post->title))
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>{{ $post->title }}</h5>
                                    <p>{{ $post->sub_title }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
            @endforeach
        </div>
        <!-- Inner -->

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselHomeBanner" data-mdb-slide="prev">
            <span class="" aria-hidden="true"><</span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carouselHomeBanner" data-mdb-slide="next">
            <span class="" aria-hidden="true">></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>
        <!-- Carousel wrapper -->

    <!-- SHORTCUT ICONS -->
    <div class="team-boxed" >
        <div class="container" >
            <div class="row people" >
                @foreach ($web_shortcuts as $web_shortcut)
                    <div class="col-md-2 col-lg-2 item">
                        <a href="{{ $web_shortcut->link_url }}">
                            <div class="box">
                                <img class="rounded-circle" src="{{asset('storage/images/shortcutweb/' . $web_shortcut->img_url)}}">
                                <h3 class="name">{{ $web_shortcut->title }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

  <!-- ======= About Us Section ======= -->
  <section id="about" class="about">
    <h1 class="mt-4 mb-4" style="color: rgb(17, 114, 82); font-family: 'Helvetica Neue', sans-serif; font-size: 75px; font-weight: bold; letter-spacing: -1px; line-height: 1; text-align: center;">Notícias</h1>
    <div class="container">
      <div class="row no-gutters">

        <div class="row">
            @php
                $i = 0;
            @endphp
            @if(isset($news))
                @foreach($news as $new)
                    @if ($i == 0)
                        @php
                            $i++;
                        @endphp
                        <div class="col-lg-6 d-flex flex-column justify-content-top about-content" style="background: url({{asset('storage/images/news/' . $new->image)}});background-repeat: no-repeat;background-size: cover;">
                            <div class="p-4 p-md-5 mb-4 text-white rounded " style="background: rgba(77, 63, 63, .8);">
                                <div class="col-md-12 px-0">
                                    <h5 class="display-4 " style="color: #ffffff; font-family: 'Trocchi', serif; font-size: 50px; font-weight: 600; line-height: 56px; margin: 0;">{{ $new->title }}</h5>
                                    <p class="lead my-3" style="color: #ffffff; font-family: 'Source Sans Pro', sans-serif; font-size: 24px; font-weight: 400; line-height: 26px; margin: 0 0 24px;">{{$new->description}}</p>
                                    <p class="lead mb-0" style="color: #7c795d; font-family: 'Source Sans Pro', sans-serif; font-size: 28px; font-weight: 400; line-height: 32px; margin: 0 0 24px;"><a class="text-white fw-bold" href="{{ route('news_web_show', $new->id) }}">Continue lendo...</a></p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="col-lg-6 d-flex flex-column justify-content-top about-content" >
                    @foreach($news as $new)
                        @if ($i > 1 && $i <= 3)
                                <div class="row g-0 rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative" style="background: url({{asset('storage/images/news/' . $new->image)}});background-repeat: no-repeat;background-size: contain;">
                                    <div class="col p-4 d-flex flex-column position-static" style="background-color: rgba(77, 63, 63, .8);">
                                        <h4 class="mb-0 " style="color: #ffffff; forgb(255, 255, 255)ly: 'Trocchi', serif; font-size: 25px; font-weight: 600; line-height: 28px; margin: 0;">{{$new->title}}</h4>
                                        <div class="mb-1 mt-1" style="color: #ffffff; font-family: 'Source Sans Pro', sans-serif; font-size: 14px; font-weight: 400; line-height: 18px; margin: 0 0 24px;">{{ date('d/m/Y', strtoTime($new->created_at))}}</div>
                                        <p class="card-text mb-auto" style="ont-family: 'Source Sans Pro', sans-serif; font-size: 14px; line-height: 20px; margin: 0 0 24px;">{{$new->description}}</p>
                                        <a href="{{ route('news_web_show', $new->id) }}" class="stretched-link" style="color: #ffffff; font-family: 'Source Sans Pro', sans-serif; font-size: 20px; font-weight: 600; line-height: 22px; margin: 0 0 24px;">Continue lendo...</a>
                                    </div>
                                </div>
                        @endif
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </div>
            @endif
        </div>

      </div>
    </div>
  </section><!-- End About Us Section -->

  <!-- ======= Contact Us Section ======= -->
  <section id="contact" class="contact">
    <div class="container">

      <div class="section-title">
        <h2>Canais de Comunicação e Denúncias:</h2>
      </div>

      <div class="row">

        <div class="col-lg-6 d-flex align-items-stretch" data-aos="fade-up">
          <div class="info-box">
            <i class="bx bx-map"></i>
              <h3>Site</h3>
            <p><a href="{{ route('web_ombudsman') }}">semas.arraial.rj.gov.br/ouvidoria</a></p>
          </div>
        </div>

        <div class="col-lg-3 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
          <div class="info-box">
            <i class="bx bx-envelope"></i>
              <h3>Email</h3>
            <p>gab.ambiente@arraial.rj.gov.br</p>
          </div>
        </div>
        <div class="col-lg-3 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
          <div class="info-box ">
            <i class="bx bx-phone-call"></i>
              <h3>Whatsapp</h3>
            <p> (22) 99758 7280</p>
          </div>
        </div>
      </div>

    </div>
  </section><!-- End Contact Us Section -->

@endsection