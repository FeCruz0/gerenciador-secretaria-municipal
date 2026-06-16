@extends('layouts.web_base')

@section('content')

    <!-- Ouvidoria Identificada -->
    <section id="contact" class=" container">
        <div class="text-center">
            <h2 class="mb-2">Ouvidoria</h2>
            <span>Envie sua manifestação através do formulário online.</span>
        </div>
        <form action="" class="p-4 form-group">
            <div class="container">
                <div class="row">
                    <div class="col-12 my-3">
                        <div class="mb-2">
                            <label for="exampleInputEmail1" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-2">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-2">
                            <label for="exampleInputEmail1" class="form-label">Telefone</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="col-lg-6 justify-content-start">
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
                    <div class="col-lg-6">
                        <div class="mb-2">
                            <label for="textArea" class="form-label">Mensagem...</label>
                            <textarea name="mensagem" id="textArea" class="form-control" rows="6"></textarea>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>
        </form>
    </section>
@endsection
