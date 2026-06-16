@extends('layouts.web_base')

@section('content')
    <section class="management-report">
        <div class="container px-5">
            <div class="section-title mt-4">
                <h2>Noticias</h2>
            </div>
            <!-- <article class="blog-post">
                <h2 class="blog-post-title mb-1">Sample blog post</h2>
                    <p class="blog-post-meta">January 1, 2021 by <a href="#">Mark</a></p>

                    <p>This blog post shows a few different types of content that's supported and styled with Bootstrap. Basic typography, lists, tables, images, code, and more are all supported as expected.</p>
                    <hr>
                    <p>This is some additional paragraph placeholder content. It has been written to fill the available space and show how a longer snippet of text affects the surrounding content. We'll repeat it often to keep the demonstration flowing, so be on the lookout for this exact same string of text.</p>
            </article> -->

                <!-- SHORTCUT ICONS -->

                <!--Section: News of the day-->
            @foreach ($news as $new)


            <hr>
            <div class="row gx-5 p-5 col-md-10">
                <div class="col-md-6 mb-4">
                    <div class="bg-image hover-overlay ripple shadow-2-strong rounded-5" data-mdb-ripple-color="light">
                        <img src="{{asset('storage/images/news/' . $new->thumb)}}" class="img-fluid" style="height: 200px" />
                        <a href="{{ route('news_web_show', $new->id) }}">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <span class="badge bg-danger px-2 py-1 shadow-1-strong mb-3">{{ $new->created_at }}</span>
                    <h4>
                        <strong>{{ $new->title }}</strong>
                    </h4>
                    <p class="text-muted">
                        {{ $new->description }}
                    </p>
                    <button type="button" class="btn btn-primary">Ler Mais</button>
                </div>
            </div>
            <hr>
            <div class="row gx-5 p-5 col-md-10">
                <div class="col-md-6 mb-4">
                    <div class="bg-image hover-overlay ripple shadow-2-strong rounded-5" data-mdb-ripple-color="light">
                        <img src="https://mdbcdn.b-cdn.net/img/new/slides/080.webp" class="img-fluid" style="height: 200px" />
                        <a href="https://www.uol.com">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <span class="badge bg-danger px-2 py-1 shadow-1-strong mb-3">{{ $new->created_at }}</span>
                    <h4>
                        <strong>{{ $new->title }}</strong>
                    </h4>
                    <p class="text-muted">
                        {{ $new->description }}
                    </p>
                    <a href="{{ route('news_web_show', $new->id) }}">
                        <button type="button" class="btn btn-primary" href="{{ route('news_web_show', $new->id) }}">Ler Mais</button>
                    </a>
                </div>
            </div>

            @endforeach

        </div>
    </section>
@endsection
