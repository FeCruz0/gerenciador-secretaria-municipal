@extends('layouts.web_base')

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
                  <h1 class="title-heading" style="color: rgb(41, 27, 27); font-family: 'Helvetica Neue', sans-serif; font-size: 55px; font-weight: bold; letter-spacing: -1px; line-height: 1; text-align: left;">Legislação</h1>
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
      <section class="service-single" id="service-single">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-4 order-1">
              <!--
              ============================
              Services Sidebar
              ============================
              -->
              <div class="sidebar sidebar-service">
                <!-- Services-->
                <div class="widget widget-services">
                  <div class="widget-title">
                    <h5>Busca Avançada</h5>
                  </div>
                  <div class="widget-content">
                    <form  method="post" action="{{ route('legislation_web_index_filter') }}">
                      @csrf
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <label class="form-label" for="ementa">Ementa</label>
                          <input class="form-control" type="text" id="ementa" name="ementa"  />
                        </div>
                        <div class="col-12 col-md-12">
                          <label class="form-label" for="number">Número</label>
                          <input class="form-control" type="text" id="number" name="number"  />
                        </div>
                        <div class="col-12 col-md-12">
                          <label class="form-label" for="number_complement">Complemento</label>
                          <input class="form-control" type="text" id="number_complement" name="number_complement"  />
                        </div>
                        <div class="col-12 col-md-12">
                          <label class="form-label" for="category_id">Categorias</label>
                          <select class="form-control" id="category_id" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-12 col-md-12">
                          <label class="form-label" for="situation_id">Situações</label>
                          <select class="form-control" id="situation_id" name="situation_id">
                            @foreach($situations as $situation)
                                <option value="{{ $situation->id }}">{{ $situation->situation }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-12 col-md-12">
                          <label class="form-label" for="date">Registro</label>
                          <input class="form-control" type="date" id="date" name="date"  />
                        </div>
                        <div class="col-12">
                          <button type="submit" class="btn btn--secondary w-100">Filtrar pesquisa <i class="energia-arrow-right"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- End .widget-services -->
              </div>
              <!-- End .sidebar-->
            </div>
            <div class="col-12 col-lg-8 order-0 order-lg-2">
              <!-- Start .service-entry-->
              <div class="service-entry">
                <div class="entry-content">
                  <div class="entry-introduction entry-infos">
                    <h5>Legislações</h5>
                    <div class="table-responsive">
                      @if (count($legislations) >= 1)
                        <table class="table">
                          <thead class="table-dark">
                            <tr>
                                <th>Ementa</th>
                                <th>Categoria</th>
                                <th>Situação</th>
                                <th>Data</th>
                                <th style="text-align: right;">Funções</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($legislations as $legislation)
                                  <tr>
                                    <td>{{$legislation->ementa}}</td>
                                    <td>{{isset($legislation->category) ? $legislation->category->category : ''}}</td>
                                    <td>{{isset($legislation->situation) ? $legislation->situation->situation : ''}}</td>
                                    <td>{{ isset($legislation->date) ? date('d-m-Y H:i', strtotime($legislation->date)) : '' }}</td>
                                    <td style="text-align: right;">
                                      <a href="{{ route('web_legislation_show', $legislation->id) }}"> <span>ver mais </span> <i class="energia-arrow-right"></i></a>
                                    </td>
                                  </tr>
                              @endforeach
                          </tbody>
                          <tfoot>
                                <th>Ementa</th>
                                <th>Categoria</th>
                                <th>Situação</th>
                                <th>Data</th>
                                <th style="text-align: right;">Funções</th>
                          </tfoot>
                        </table>
                      @else
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-times"></i> Não existem Legislações Armazenadas.
                        </div>
                      @endif
                      <div class="d-flex justify-content-center" style="margin-top: 3%;">
                        {{ $legislations->links()}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End .service-entry-->
            </div>
            <!-- End .col-lg-8-->
          </div>
          <!-- End .row-->
        </div>
        <!-- End .container-->
      </section>
@endsection
