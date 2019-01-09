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
                <div class="card justify-content-center">
                    <div class="card-header text-center">
                        Generare API Token pentru Same Day
                    </div>
                    <div class="card-body">
                        @if($smdApiTokenExDate <= $detailedFormattedTime)
                            <h4 class="text-danger text-center"><i class="far fa-times-circle"></i> Tokenul Nu mai
                                este valid
                            </h4>
                            <p class="text-center text-dark" style="text-decoration: line-through;"><i
                                        class="far fa-clock"></i> {{$smdApiTokenExDate}}</p>
                        @else
                            <h4 class="text-center text-success"><i class="fas fa-check"></i> Tokenul este inca valid
                            </h4>
                            <p class="text-center text-dark"><i class="far fa-clock"></i> {{$smdApiTokenExDate}}</p>
                            <p class="text-center text-dark">Data ultima
                                actualizare: {{$smdDayApiTokenOption->updated_at}}</p>
                        @endif
                        <br>
                        <form action="{{route('api.token.update')}}"
                              method="get">
                            <button title="Regenereaza un nou Token pentru API-ul Same day"
                                    type="submit"
                                    onclick="return confirm('Doresti sa generezi un nou TOKEN?')"
                                    class="btn btn-primary btn-block pr-4 pl-4"><i class="fas fa-cloud-upload-alt">
                                    REGENEREAZA TOKEN</i></button>
                        </form>
                    </div>
                    <div class="card-footer">
                        <span class="text-danger">*</span>
                        <small> Durata de viata a unui token este de 30 de zile.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection