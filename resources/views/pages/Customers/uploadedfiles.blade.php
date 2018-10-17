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
                        Fisiere Importate
                    </div>
                    <div class="card-body">
                        @if(count($files) > 0)
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
                                @foreach($files as $file)
                                    <tr>
                                        <th scope="row">{{$file->id}}</th>
                                        <td>
                                            <a href="{{route('download.customerfile', ['id' => $file->id])}}">{{$file->cale_fisier}}</a>
                                        </td>
                                        <td>{{$file->created_at}}</td>
                                        <td>
                                            <!--Delete-->
                                            <form class="form-delete"
                                                  action="{{route('delete.customerfile', ['id' => $file->id])}}"
                                                  method="POST">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                                <button type="submit" class="btn btn-danger btn-sm mt-1"
                                                        onclick="return confirm('Fisierul {{$file->cale_fisier}} va fi sters. Esti sigur?')"
                                                        title="Stergere Fisier - {{$file->cale_fisier}}"><i
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
                                <p class="text-center p-2 mt-3"><i class="fas fa-exclamation-triangle"></i> <span class="text-dark">Nu exista fisiere incarcate pe server</span></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection