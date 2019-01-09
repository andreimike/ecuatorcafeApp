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
                            {{csrf_field()}}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="file">Importa comenzi</label>
                                    <input type="file" class="form-control-file" id="file" name="file">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-row mt-1">
                                <div class="form-group col-md-4">
                                    <label for="date1">Setati data prajirii - Cafea Brazilia</label>
                                    <input type="date" class="form-control" id="date1" name="date1">
                                    <small>Data in formatul AAAA-LL-ZZ</small>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date2">Setati data prajirii - Cafea Columbia</label>
                                    <input type="date" class="form-control" id="date2" name="date2">
                                    <small>Data in formatul AAAA-LL-ZZ</small>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date3">Setati data prajirii - Cafea Etiopia</label>
                                    <input type="date" class="form-control" id="date3" name="date3">
                                    <small>Data in formatul AAAA-LL-ZZ</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Importa Comenzile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection