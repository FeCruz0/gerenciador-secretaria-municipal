@extends('layouts.web_base')


@section('content')

<style>
.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
</style>

    <section id="projects">
        <div class="container">
            <div class="section-title mb-0 pb-0 mt-4">
              <h1>Arquivo Detalhado</h1>
            </div>
            <div class="service-entry">
                <div class="entry-content">
                  <div class="entry-introduction entry-infos my-5" style="height: 700px">
                    <div id="pdf" style="height:100%"></div>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.js"></script>
                    <script>PDFObject.embed("{{ asset('storage/files/' . $file->url) }}", "#pdf");</script>
                  </div>
                </div>
            </div>
            </div>
    </section>
@endsection