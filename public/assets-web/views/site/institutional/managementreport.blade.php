@extends('layouts.web_base')

@section('content')
    <section class="management-report">
        <div class="container">
            <div class="section-title">
                <h2>Relatório de Gestão</h2>
            </div>
            <!-- <article class="blog-post">
                <h2 class="blog-post-title mb-1">Sample blog post</h2>
                    <p class="blog-post-meta">January 1, 2021 by <a href="#">Mark</a></p>

                    <p>This blog post shows a few different types of content that's supported and styled with Bootstrap. Basic typography, lists, tables, images, code, and more are all supported as expected.</p>
                    <hr>
                    <p>This is some additional paragraph placeholder content. It has been written to fill the available space and show how a longer snippet of text affects the surrounding content. We'll repeat it often to keep the demonstration flowing, so be on the lookout for this exact same string of text.</p>
            </article> -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="..." class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Relatório Semestral</p>
                            <p class="card-text">Janeiro à Junho de 2022</p>
                            <button type="button" class="btn btn-outline-success">Download</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="..." class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Relatório Semestral</p>
                            <p class="card-text">Julho à Dezembro de 2021</p>
                            <button type="button" class="btn btn-outline-success">Download</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="..." class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Relatório Semestral</p>
                            <p class="card-text">Janeiro à Junho de 2021</p>
                            <button type="button" class="btn btn-outline-success">Download</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
