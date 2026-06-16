@extends('admin.app')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" data-anime="1000">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="title">Contemplados</h6>
                    </div>
                    <div class="card-body">
                        
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">CPF</th>
                                <th scope="col">Opções</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>000.000.000-00</td>
                                <td>
                                    <a href="#" class="btn btn-secondary"><i class="far fa-edit"></i></a>
                                    <a href="#" class="btn btn-primary"><i class="far fa-trash-alt"></i></a>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>000.000.000-00</td>
                                <td>
                                    <a href="#" class="btn btn-secondary"><i class="far fa-edit"></i></a>
                                    <a href="#" class="btn btn-primary"><i class="far fa-trash-alt"></i></a>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>000.000.000-00</td>
                                <td>
                                    <a href="#" class="btn btn-secondary"><i class="far fa-edit"></i></a>
                                    <a href="#" class="btn btn-primary"><i class="far fa-trash-alt"></i></a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                </div>
    
            </div>
        </div>




    </div>




@endsection