@extends('layouts.web_base')


@section('content')
    <section id="projects">
        <div class="container">
            <div class="section-title mt-5">
                <h1>Projetos</h1>
            </div>

            <div class="row">
                @foreach($projects as $project)
                <div class="col-md-3 py-3">
                    <a href="{{ route('project_web_show', $project->id) }}" style="text-decoration: none">
                        <div class="card shadow-sm" style="border-radius: 5px 5px 5px 15px; ">
                            <div style="width:100%; height: 100%">
                                <img class="card-img-top shadow rounded" src="{{asset('storage/images/projects/' . $project->thumb)}}" alt="Card image cap"
                                style="j
                                max-width: 100%;
                                height: 260px;
                                object-fit: cover;
                                border:solid 1px;
                                border-color: #b9d9ba !important;
                                ">
                            </div>
                            <div class="card-body text-center">
                                <h2 style="font-size: 22px;">{{$project->title}}</h2>
                                <p class="card-text text-secondary text-center" style="font-size: 14px;">
                                    {{$project->description}}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
