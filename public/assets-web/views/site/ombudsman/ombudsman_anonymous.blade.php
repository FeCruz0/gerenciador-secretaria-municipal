@extends('layouts.web_base')

@section('content')  

    <!-- Ouvidoria Anônima -->
    <section id="contact" class=" container">
        <div class="text-center">
            <h2 class="mb-2">Ouvidoria</h2>
            <span>Envie sua manifestação através do formulário online.</span>
        </div>
        <form action="" class="p-4 form-group">
            <div class="container">
                <div class="row">
                    <div class="col-6 justify-content-start">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>Denúncia Ambiental
                            <label class="form-check-label" for="radio1"></label>
                          </div>
                          <div class="form-check">
                            <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">Outra denúncia
                            <label class="form-check-label" for="radio2"></label>
                          </div>
                          <div class="form-check">
                            <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">Elogios
                            <label class="form-check-label" for="radio2"></label>
                          </div>
                          <div class="form-check">
                            <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">
                            <input id="name2" name="name2"  />
                            <label class="form-check-label" for="radio2"></label>
                          </div>
                    </div>
                    <div class="col-6">
                        
                        <textarea name="mensagem" placeholder="Mensagem..." class="form-control" rows="6"></textarea>
                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>
        </form>
        <!-- End Title -->
    </section>
    <!-- End Ouvidoria -->
@endsection