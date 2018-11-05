@extends('layouts.app')

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('inc.messages')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Fisiere Importate</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-4 text-center">
                                <button class="btn btn-primary btn-lg text-center" type="button" data-toggle="collapse"
                                        data-target="#customersFiles" aria-expanded="false"
                                        aria-controls="customersFiles">
                                    Fisiere Clienti <i class="fas fa-users"></i>
                                </button>
                            </div>
                            <div class="col-md-4 text-center">
                                <button class="btn btn-primary btn-lg text-center" type="button" data-toggle="collapse"
                                        data-target="#ordersFiles" aria-expanded="false"
                                        aria-controls="ordersFiles">
                                    Fisiere Comenzi <i class="fas fa-list-ol"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3 mb-2">
            <div class="col-md-10">
                <div class="collapse" id="customersFiles">
                    <div class="card mt-3">
                        <div class="card-header text-center">
                            <h5>Fisiere Pentru Clienti Incarcate</h5>
                        </div>
                        <div class="card-body">
                            @if(count($customersFiles) > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light text-dark">
                                        <tr>
                                            <th>#ID</th>
                                            <th>Fisier</th>
                                            <th>Data Importare</th>
                                            <th>Sterge</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($customersFiles as $customerFile)
                                            <tr>
                                                <th scope="row">{{$customerFile->id}}</th>
                                                <td>
                                                    <a href="{{route('download.customerfile', ['id' => $customerFile->id])}}">{{$customerFile->customers_uploads_path}}</a>
                                                </td>
                                                <td>{{$customerFile->created_at}}</td>
                                                <td>
                                                    <!--Delete-->
                                                    <form class="form-delete"
                                                          action="{{route('delete.customerfile', ['id' => $customerFile->id])}}"
                                                          method="POST">
                                                        {{csrf_field()}}
                                                        {{method_field('DELETE')}}
                                                        <button type="submit" class="btn btn-danger btn-sm mt-1"
                                                                onclick="return confirm('Fisierul {{$customerFile->customers_uploads_path}} va fi sters. Esti sigur?')"
                                                                title="Stergere Fisier - {{$customerFile->customers_uploads_path}}">
                                                            <i
                                                                    class="far fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    <p class="text-center p-2 mt-3"><i class="fas fa-exclamation-triangle"></i> <span
                                                class="text-dark">Nu exista fisiere incarcate pe server</span></p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="collapse" id="ordersFiles">
                    <div class="card mt-3">
                        <div class="card-header text-center">
                            <h5>Fisiere Pentru Comenzi Incarcate</h5>
                        </div>
                        <div class="card-body">
                            @if(count($ordersFiles) > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light text-dark">
                                        <tr>
                                            <th>#ID</th>
                                            <th>Fisier</th>
                                            <th>Data Importare</th>
                                            <th>Sterge</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($ordersFiles as $oderFile)
                                            <tr>
                                                <th scope="row">{{$oderFile->id}}</th>
                                                <td>
                                                    <a href="{{route('download.order.file', ['id' => $oderFile->id])}}">{{$oderFile->orders_uploads_path}}</a>
                                                </td>
                                                <td>{{$oderFile->created_at}}</td>
                                                <td>
                                                    <!--Delete-->
                                                    <form class="form-delete"
                                                          action="{{route('delete.order.file', ['id' => $oderFile->id])}}"
                                                          method="POST">
                                                        {{csrf_field()}}
                                                        {{method_field('DELETE')}}
                                                        <button type="submit" class="btn btn-danger btn-sm mt-1"
                                                                onclick="return confirm('Fisierul {{$oderFile->orders_uploads_path}} va fi sters. Esti sigur?')"
                                                                title="Stergere Fisier - {{$oderFile->orders_uploads_path}}">
                                                            <i
                                                                    class="far fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    <p class="text-center p-2 mt-3"><i class="fas fa-exclamation-triangle"></i> <span
                                                class="text-dark">Nu exista fisiere incarcate pe server</span></p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection