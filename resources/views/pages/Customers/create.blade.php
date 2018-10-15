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
                        Adauga un nou client
                    </div>
                    <div class="card-body">
                        <form action="{{route('customer.store')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="nume">Nume Companie</label>
                                <input type="text" class="form-control" name="nume" id="nume"
                                       placeholder="Nume Companie">
                            </div>
                            <div class="form-group">
                                <label for="adresa">Adresa Companie</label>
                                <input type="text" class="form-control" name="adresa" id="adresa"
                                       placeholder="Adresa Companie">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="iln">ILN</label>
                                    <input type="text" class="form-control" name="iln" id="iln" placeholder="ILN">
                                </div>
                                <div class="form-group col-md-6" s>
                                    <label for="cui">CUI Companie</label>
                                    <input type="text" class="form-control" name="cui" id="cui"
                                           placeholder="CUI Companie">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Adauga Client</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection