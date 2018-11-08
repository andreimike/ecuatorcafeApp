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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        Editare Ultimul Numar de Serie Salvat
                    </div>
                    <div class="card-body">
                        <form action="{{route('serial.number.update', ['id'=>$serialNumber->id])}}" method="post"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-row justify-content-center">
                                <div class="form-group col-md-6">
                                    <label for="nume">Numar de Serie Curent</label>
                                    <input type="text" class="form-control" placeholder="Numar de serie Curent" disabled
                                           value="{{$serialNumber->serial_number}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="adresa">Introduce ultimul numar de serie <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="serialNumber" id="serialNumber"
                                       placeholder="Numar de serie" value="{{$serialNumber->serial_number}}">
                            </div>
                            <button type="submit" class="btn btn-primary">Salveaza noul Numar de Serie</button>
                        </form>
                    </div>
                    <div class="card-footer">
                        <span class="text-danger">*</span><small> Numarul introdus va fi <b>scazut automat cu -1</b>.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection