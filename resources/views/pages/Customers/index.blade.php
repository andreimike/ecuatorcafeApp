@extends('layouts.app')

@section('content')
    @include('inc.messages')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Listare Clineti</h5>
                    </div>
                    <div class="card-body">
                        @if(count($customers) > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light text-dark">
                                    <tr>
                                        <th>Nume Companie</th>
                                        <th>Adresa Companie</th>
                                        <th>Contractor EAN</th>
                                        <th>ILN Companie</th>
                                        <th>CUI Companie</th>
                                        <th>Data adaugare companie</th>
                                        <th class="text-center">Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customers as $customer)
                                        <tr>
                                            <td><a href="{{route('customer.edit', [$customer->contractor_ean])}}"
                                                   title="Editare Client -  {{$customer->nume}}">{{$customer->nume}}</a>
                                            </td>
                                            <td>{{$customer->adresa}}</td>
                                            <td>>{{$customer->contractor_ean}}</td>
                                            <td>{{$customer->iln}}</td>
                                            <td>{{$customer->cui}}</td>
                                            <td>{{$customer->created_at}}</td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr style="border: 0;">
                                                        <td style="border: none;" align="left"
                                                            class="text-center mt-0 pt-0">
                                                            <!--Edit-->
                                                            <a href="{{route('customer.edit', [$customer->contractor_ean])}}"
                                                               class="btn btn-info btn-sm mt-1"
                                                               title="Editare Client -  {{$customer->nume}}"><i
                                                                        class="far fa-edit"></i></a>
                                                        </td>
                                                        <td style="border: none;" align="right"
                                                            class="text-center mt-0 pt-0">
                                                            <!--Delete-->
                                                            <form class="form-delete"
                                                                  action="{{route('customer.delete', ['contractor_ean' => $customer->contractor_ean])}}"
                                                                  method="POST">
                                                                {{csrf_field()}}
                                                                {{method_field('DELETE')}}
                                                                <button type="submit" class="btn btn-danger btn-sm mt-1"
                                                                        onclick="return confirm('Clientul {{$customer->nume}} va fi sters. Esti sigur?')"
                                                                        title="Stergere Client - {{$customer->nume}}"><i
                                                                            class="far fa-trash-alt"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                <p class="text-center p-2 mt-3"><i class="fas fa-exclamation-triangle"></i> <span class="text-dark">Momentan nu exista clineti in baza de date!</span> <a
                                            href="{{route('customer.create')}}">Va rugam sa adaugati clienti.</a> <i class="fas fa-exclamation-triangle"></i></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection