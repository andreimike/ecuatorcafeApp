@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="card mt-1">
                    <div class="card-header">
                        Incarca fisierul de comenzi
                    </div>
                    <div class="card-body">
                        <form action="{{route('order.store')}}" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="file">Importa comenzi</label>
                                <input type="file" class="form-control-file" id="file" name="file">
                            </div>
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-primary">Importa Comenzile</button>
                        </form>
                    </div>
                </div>
                <div class="card mt-1">
                    <div class="card-header">
                        Selectati data de prajire pentru cafea
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection