@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h5 class="text-center">Panou de control</h5></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h6 class="text-center">Bine ai revenit <b>{{Auth::user()->name}}</b></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-success">Incarca fisier comenzi <i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
