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
                  <h1 class="title-heading" style="color: rgb(41, 27, 27); font-family: 'Helvetica Neue', sans-serif; font-size: 55px; font-weight: bold; letter-spacing: -1px; line-height: 1; text-align: left;">Despesas</h1>
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
      Services Single Section
      ============================
      -->
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
                    <form  method="post" action="{{ route('expense_web_index_filter') }}">
                      @csrf
                      <div class="row">
                        <div class="col-12 col-md-12">
                          <label class="form-label" for="title">Assunto</label>
                          <input class="form-control" type="text" id="title" name="title"  />
                        </div>
                        <div class="col-12 col-md-12">
                          <label class="form-label" for="type_expense_id">Tipos</label>
                          <select class="form-control" id="type_expense_id" name="type_expense_id">
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->title }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-12 col-md-12">
                          <label class="form-label" for="register">Registro</label>
                          <input class="form-control" type="text" id="register" name="register"  />
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
                    <h5>Despesas</h5>
                    <div class="table-responsive">
                      @if (count($expenses) >= 1)
                        <table class="table">
                          <thead class="table-dark">
                            <tr>
                              <th>Registro</th>
                              <th>Assunto</th>
                              <th>Tipo</th>
                              <th>Data</th>
                              <th style="text-align: right;">Funções</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($expenses as $expense)
                                  <tr>
                                      <td>{{$expense->register}}</td>
                                      <td>{{$expense->title}}</td>
                                      <td>{{ isset($expense->type_expense) ? $expense->type_expense->title : ''}}</td>
                                      <td>{{ date('Y-m-d', strtotime($expense->created_at)) }}</td>
                                      <td style="text-align: right;">
                                      <a href="{{ route('web_expense_show', $expense->id) }}"> <span>Ver mais </span> <i class="energia-arrow-right"></i></a>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                          <tfoot>
                              <th>Registro</th>
                              <th>Assunto</th>
                              <th>Tipo</th>
                              <th>Data</th>
                              <th style="text-align: right;">Funções</th>
                          </tfoot>
                        </table>
                      @else
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-times"></i> Não existem Despesas Armazenadas.
                        </div>
                      @endif
                      <div class="d-flex justify-content-center" style="margin-top: 3%;">
                        {{ $expenses->links()}}
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
