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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{route('order.create')}}" class="btn btn-success text-white">Adauga o comanda <i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="">
                            Clienti:
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($customers as $customer)
                                <li class="list-group-item">{{$customer->nume}} <a href="{{route('customer.edit', [$customer->id])}}" title="Editeaza clientul - {{$customer->nume}}"><i class="far fa-edit"></i></a> </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
