@extends('layouts.web_base')

@section('content')
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
                <!-- Download-->
                <div class="widget widget-download">
                  <div class="widget-title">
                    <h5>Arquivos</h5>
                  </div>
                  <div class="widget-content">
                    <ul class="list-unstyled">
                      @php
                        $cont = 1;
                      @endphp
                      @foreach($expense->files as $file)
                        <li class="{{ ($cont % 2) === 0 ? 'inversed' : '' }}"><a href="{{ route('file_web', $file->id) }}"> <span>{{isset($file->title) ? $file->title : '' }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" width="18" height="18">
                              <g>
                                <g>
                                  <g>
                                    <path class="shp0" d="M2.12 2L2.93 1L14.93 1L15.87 2L2.12 2ZM9 14.5L3.5 9L7 9L7 7L11 7L11 9L14.5 9L9 14.5ZM17.54 2.23L16.15 0.55C15.88 0.21 15.47 0 15 0L3 0C2.53 0 2.12 0.21 1.84 0.55L0.46 2.23C0.17 2.57 0 3.02 0 3.5L0 16C0 17.1 0.9 18 2 18L16 18C17.1 18 18 17.1 18 16L18 3.5C18 3.02 17.83 2.57 17.54 2.23Z"></path>
                                  </g>
                                </g>
                              </g>
                            </svg>
                          </a>
                        </li>
                        @php
                          $cont++;
                        @endphp
                      @endforeach
                    </ul>
                  </div>
                </div>
                <!-- End .widget-download-->
              </div>
              <!-- End .sidebar-->
            </div>
            <div class="col-12 col-lg-8 order-0 order-lg-2">
              <!-- Start .service-entry-->
              <div class="service-entry">
                <div class="entry-content">
                  <div class="entry-introduction entry-infos">
                    <h5>Dados da Despesa</h5>
                    <div class="row">
                      <div class="col-8 col-md-8">
                        <label class="form-label" for="name">Assunto</label>
                        <input class="form-control" type="text" value="{{ isset($expense->title) ? $expense->title : ' ' }}" disabled />
                      </div>
                      <div class="col-4 col-md-4">
                        <label class="form-label" for="name">Registro</label>
                        <input class="form-control" type="text" value="{{ isset($expense->register) ? $expense->register : ' ' }}" disabled />
                      </div>
                      <div class="col-4 col-md-4">
                        <label class="form-label" for="name">Tipo</label>
                        <input class="form-control" type="text" value="{{ isset($expense->typeExpense) ? $expense->typeExpense->title : ' ' }}"  disabled/>
                      </div>
                      <div class="col-4 col-md-4">
                        <label class="form-label" for="name">Data Criação</label>
                        <input class="form-control" type="text" value="{{ isset($expense->created_at) ? $expense->created_at->format('d/M/y H:m:s') : ' ' }}" disabled />
                      </div>
                      <div class="col-4 col-md-4">
                        <label class="form-label" for="name">Fonte</label>
                        <input class="form-control" type="text" value="{{ isset($expense->source) ? $expense->source : ' ' }}" disabled />
                      </div>
                      <div class="col-3 col-md-3">
                        <label class="form-label" for="name">Saldo Atual</label>
                        <input class="form-control current-balance" type="text" value="{{ isset($expense->current_balance) ? str_replace('.',',', $expense->current_balance) : ' ' }}" disabled />
                      </div>
                      <div class="col-3 col-md-3">
                        <label class="form-label" for="name">Saldo Bloqueado</label>
                        <input class="form-control blocked-balance" type="text" value="{{ isset($expense->blocked_balance) ? str_replace('.',',', $expense->blocked_balance) : ' ' }}" disabled />
                      </div>
                      <div class="col-3 col-md-3">
                        <label class="form-label" for="name">Saldo Utilizado</label>
                        <input class="form-control used-balance" type="text" value="{{ isset($expense->used_balance) ? str_replace('.',',', $expense->used_balance) : ' ' }}" disabled />
                      </div>
                      <div class="col-3 col-md-3">
                        <label class="form-label" for="name">Saldo Disponível</label>
                        <input class="form-control available-balance" type="text" value="{{ isset($expense->available_balance) ? str_replace('.',',', $expense->available_balance) : ' ' }}"  disabled/>
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


<!-- testar aqui-->
@section('web-script')
  {{-- Vendor js files --}}
  <script src="{{asset(mix('vendors/js/forms/cleave/cleave.min.js'))}}"></script>
  <script src="{{asset(mix('vendors/js/forms/cleave/addons/cleave-phone.br.js'))}}"></script>
@endsection

@section('web-page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/forms/expense-input-mask.js')) }}"></script>
@endsection
