@extends('layouts.web_base')

@section('content')
    <section id="forms">
        <div class="container">
            <div class="section-title">
                <h2>Formulários</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="environment-licensing-menu">
                        <a class="btn btn-success" href="{{ route('licenciamento_ambiental_web') }}">
                            Licenciamento Ambiental</a>
                        <a class="btn btn-success" href="{{ route('web_services.environmentlicensing.postlicense') }}">
                            Pós-Licença</a>
                        <a class="btn btn-success" href="{{ route('web_services.environmentlicensing.checklist') }}">
                            Checklist</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection