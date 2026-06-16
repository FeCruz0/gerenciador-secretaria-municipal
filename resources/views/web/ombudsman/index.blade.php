@extends('layouts.web_base')
<style>
</style>
@section('content')
      <!--
      ============================
      PageTitle #14 Section
      ============================
      -->
      <section class="page-title page-title-14" id="page-title">
        <div class="page-title-wrap bg-overlay bg-overlay-dark-3">
          <div class="bg-section"><img src="{{ isset($banner->image) ? (asset('storage/images/banners/' . $banner->image)) : ''}}" alt="{{ isset($banner->title) ? $banner->title : '' }}"/></div>
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-6">
                <div class="title">
                  <h1 class="title-heading mt-4" style="color: rgb(41, 27, 27); font-family: 'Helvetica Neue', sans-serif; font-size: 55px; font-weight: bold; letter-spacing: -1px; line-height: 1; text-align: left;">Ouvidoria</h1>
                  <!-- End .breadcrumb-->
                </div>
                <!-- End .title-->
              </div>
              <!-- End .col-12-->
            </div>
            <!-- End .row-->
          </div>
          <!-- End .container-->
        </div>
      </section>
      <!-- End #page-title-->
      <!--
      ============================
      Contact #4 Section
      ============================
      -->
      <section class="contact contact-4" id="contact-4">
        <div class="container">
          <div class="contact-panel contact-panel-3">
            <div class="heading heading-6">
              <h2 class="heading-title" style="color: #0c974a; font-size: 48px; font-family: 'Signika', sans-serif; padding-bottom: 10px">Formulário de Manifestação da População</h2>
              <p class="heading-desc" style="font-family: 'Inder', sans-serif; line-height: 28px; margin-bottom: 15px; color: #666;">Escolha entre identificado ou anônimo, o modo de fazer sua manifestação.</p>
              <div class="contact-action">
                <img src="{{ asset('assets-web/images/icons/noteicon-2.png')}}" alt="icon"/>
                <a class="btn btn--primary button-ombudsman" onclick="identificado()">Identificado <i class="energia-arrow-right"></i></a>
                <a class="btn btn--bordered btn--white button-ombudsman"  onclick="anonimo()">Anônimo <i class="energia-arrow-right"></i></a>
              </div>
              <div class="contact-quote contact-quote-3 mt-4">
                <p style="font-family: 'Inder', sans-serif; line-height: 28px; margin-bottom: 15px; color: #666;">Uma manifestação feita não tem resposta ao manifestante. Para mais dúvidas, nos telefone: <a href="tel:{{isset($unit) ? $unit->phone : ''}}">{{isset($unit) ? $unit->phone : ''}}</a></p>
              </div>
            </div>
            <div class="contact-card">
              <div class="contact-body">
                <h5 class="card-heading" style="font-family: 'Fenix', serif; font-style: italic; color: #666; font-size: 26px;">Manifestação</h5>
                <p class="card-desc">Ficamos agradecidos pelo seu comentário.</p>

                @if(session()->exists('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>SUCESSO! </strong> {{ session('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session()->exists('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>ERRO! </strong> {{ session('error')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form name="ouvidoria_form" method="POST" action="{{ route('ombudsman_store') }}">
                  @csrf
                  <input type="text" name="access_id" id="access_id" hidden>
                  <div class="mb-20">
                    <div class="row">
                      <div class="col-12 col-md-12 identificado" style="display: none;">
                        <label class="form-label" for="name">Nome</label>
                        <input class="form-control" type="text" id="name" name="name"  />
                      </div>
                      <div class="col-12 col-md-12 identificado" style="display: none;">
                        <label class="form-label" for="email">E-mail</label>
                        <input class="form-control" type="text" id="email" name="email"  />
                      </div>
                      <div class="col-12 col-md-12 hidden-form" style="display: none;">
                        <label class="form-label" for="type_request_id">Tipo</label>
                        <select class="form-control" id="type_request_id" name="type_request_id">
                          @foreach($type_requests as $request)
                            <option value="{{$request->id}}">{{$request->title}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-12 col-md-12 hidden-form" style="display: none;">
                        <label class="form-label" for="title">Assunto</label>
                        <input class="form-control" type="text" id="title" name="title"  />
                      </div>
                      <div class="col-12 hidden-form" style="display: none;">
                        <label class="form-label" for="content">Mensagem </label>
                        <textarea class="form-control" id="content" placeholder="Add other data" name="content" cols="30" rows="10"> </textarea>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-12 hidden-form" style="display: none;">
                        <button type="submit" class="btn btn--secondary w-100">Enviar manifestação <i class="energia-arrow-right"></i></button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- End .contact-body -->
            </div>
          </div>
          <!-- End .contact-panel-->
        </div>
        <!-- End .container-->
      </section>
      @endsection
      <script>
        function anonimo() {
          $(".identificado").hide();
          $(".hidden-form").show();
          var access = document.getElementById("access_id");
          access.value = 2;
        }
        function identificado() {
          $(".identificado").show();
          $(".hidden-form").show();
          var access = document.getElementById("access_id");
          access.value = 1;
        }
      </script>
