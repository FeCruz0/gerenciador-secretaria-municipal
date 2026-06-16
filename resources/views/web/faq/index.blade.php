@extends('layouts.web_base')


@section('content')
<!-- ======= FAQ ======= -->
    <section id="faq" class="faq">
        <div class="container">
            <div class="section-title my-5">
                <h2>Perguntas Frequentes</h2>
            </div>
            <div class="row mb-5 col-md-8 offset-md-2">
                <div class="">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @foreach($departaments as $departament)
                            @php
                                $related_faqs = $faqs->where('departament_id', $departament->id);
                            @endphp
                            @if ($related_faqs->count() > 0)
                                <h5 class="mb-0 pb-0 text-center" id="{{ $departament->id }}" >{{ $departament->sigla }} - {{ $departament->departament }}</h5>
                                    @foreach ($related_faqs as $faq)
                                    <div class="accordion-item col-md-10 offset-md-1">
                                        <h2 class="accordion-header" id="flush-heading{{ $faq->id }}">
                                            <button id="collapse01-{{ $faq->id }}" class="accordion-button collapsed my-1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $faq->id }}" aria-expanded="false" aria-controls="flush-collapse{{ $faq->id }}" aria-controls="collapse01-{{ $faq->id }}">
                                                <li style="color: #0e9c09;"><strong style="color: #111f2c;">{{ $faq->question }}</strong></li>
                                            </button>
                                        </h2>
                                        <div id="flush-collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $faq->id }}" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body ps-5" style="background-color: #a9fcb4de; color: #041a07;">{{ $faq->answer }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                <br>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Frequently Asked Questions Section -->
@endsection