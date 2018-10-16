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
                        Import Clienti din Fisier
                    </div>
                    <div class="card-body">
                        <form action="{{route('import.customers')}}" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="fisierclienti">Adauga Fisier</label>
                                <input type="file" class="form-control-file" id="fisierclienti" name="fisierclienti">
                            </div>
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-primary">Importa Clientii</button>
                        </form>
                    </div>
                    <div class="card-footer mt-2">
                        <a href="{{route('upload.viewfiles')}}" class="btn btn-outline-info">Vezi fisierele incarcate</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection