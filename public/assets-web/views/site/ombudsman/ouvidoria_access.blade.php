@extends('layouts.web_base')

@section('content')

    <section id="contact" class="text-center">
        <div class="container">
            <h2 class="semibold-title">Ouvidoria</h2>
            <span class="d-block mb-4">Indique o tipo de acesso</span>
            <a href="{{ route('ombudsman.anonymous') }}" class="btn btn-success">Anônimo</a>
            <a href="{{ route('ombudsman.normal') }}" class="btn btn-success">Identificada</a>
        </div>
    </section>
@endsection
