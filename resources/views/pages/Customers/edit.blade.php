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
                        Editare Client
                    </div>
                    <div class="card-body">
                        <form action="{{route('customer.update', ['id'=>$customer->contractor_ean])}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nume">Nume Companie</label>
                                    <input type="text" class="form-control" name="nume" id="nume"
                                           placeholder="Nume Companie" value="{{$customer->nume}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="contractor_ean">EAN Companie</label>
                                    <input type="text" class="form-control" name="contractor_ean" id="contractor_ean" placeholder="EAN Companie" value="{{$customer->contractor_ean}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="adresa">Adresa Companie</label>
                                <input type="text" class="form-control" name="adresa" id="adresa"
                                       placeholder="Adresa Companie" value="{{$customer->adresa}}">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="iln">ILN</label>
                                    <input type="text" class="form-control" name="iln" id="iln" value="{{$customer->iln}}" placeholder="ILN">
                                </div>
                                <div class="form-group col-md-6" s>
                                    <label for="cui">CUI Companie</label>
                                    <input type="text" class="form-control" name="cui" id="cui" value="{{$customer->cui}}"
                                           placeholder="CUI Companie">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizeaza Client</button>
                        </form>
                    </div>
                </div>
            </div>
            s
        </div>
    </div>

@endsection