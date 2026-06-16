@extends('admin.app')
@section('content')

<div class="container-fluid">
    <div class="row mb-3">

        <div class="col-md-3 fadeInDown" data-anime="200">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="titulo text-xs font-weight-bold text-success text-uppercase mb-1">
                                Titulo <i class="far fa-eye"></i></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 blur">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-question fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 fadeInDown" data-anime="400">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="titulo text-xs font-weight-bold text-success text-uppercase mb-1">
                                Dúvidas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 fadeInDown" data-anime="600">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="titulo text-xs font-weight-bold text-success text-uppercase mb-1">
                                Opções</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 fadeInDown" data-anime="800">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="titulo text-xs font-weight-bold text-success text-uppercase mb-1">
                                Opções</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12" data-anime="1000">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="title">Home</h6>
                </div>
                <div class="card-body">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Commodi sit rem natus
                    recusandae amet quaerat sequi dicta, consequuntur harum nemo! Enim unde ea, delectus
                    deserunt sit et veritatis ratione nesciunt!Accusantium perspiciatis harum error
                    minima, exercitationem fuga voluptatibus? Placeat, natus fugiat repudiandae,
                    consequuntur provident ipsa sed esse sunt cupiditate itaque officia ad sapiente
                    architecto eius blanditiis sequi illo dignissimos dolorem.
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12" data-anime="1000">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="title">Ajuda</h6>
                </div>
                <div class="card-body">
                    
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                          <h6 class="accordion-header color-theme" id="headingOne">
                            <a class="accordion-button pergunta" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              Pergunta 1
                            <a>
                          </h6>
                          <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                          </div>
                        </div>
                        <hr class="sidebar-divider d-none d-md-block">
                        <div class="accordion-item">
                          <h6 class="accordion-header color-theme" id="headingTwo">
                            <a class="accordion-button collapsed pergunta" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Pergunta 2
                            </a>
                          </h6>
                          <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                          </div>
                        </div>
                        <hr class="sidebar-divider d-none d-md-block">
                        <div class="accordion-item">
                          <h6 class="accordion-header color-theme pergunta" id="headingThree">
                            <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Pergunta 3
                            </a>
                          </h6>
                          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                          </div>
                        </div>
                      </div>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection