@extends('layouts.app')

@section('content')
    @include('inc.messages')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Listare Clineti</h5>
                    </div>
                    <div class="card-body pr-0 pl-0">
                        <button type="button"
                                class="bnt btn-outline-warning btn-lg text-center text-dark mb-3 mr-1 ml-1"
                                onclick="showFullInfos()">Detaliat
                        </button>

                        <button type="button"
                                class="bnt btn-outline-success btn-lg text-center text-dark mb-3 mr-1 ml-1"
                                onclick="showSmallInfos()">Compact
                        </button>
                        @if(count($customers) > 0)
                            <div class="table-responsive">
                                <div id="customerSamllInfos" class="displayBlock">
                                    <table class="table">
                                        <thead class="bg-light text-dark">
                                        <tr>
                                            <th>Contractor EAN</th>
                                            <th>Nume</th>
                                            <th>Adresa</th>
                                            <th>Localitate</th>
                                            <th>Judet</th>
                                            <th>Tara</th>
                                            <th>ILN</th>
                                            <th>CUI</th>
                                            <th>Reg. Comert</th>
                                            <th class="text-center">Actiuni</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($customers as $customer)
                                            <tr class="addHover">
                                                <th scope="row">{{$customer->contractor_ean}}</th>
                                                <td><a href="{{route('customer.edit', [$customer->contractor_ean])}}"
                                                       title="Editare Client -  {{$customer->nume}}">{{$customer->nume}}</a>
                                                </td>
                                                <td>
                                                    {{$customer->adresa}}
                                                </td>
                                                <td>
                                                    @if($customer->localitate == null)
                                                        -
                                                    @else
                                                        {{$customer->localitate}}
                                                    @endif
                                                </td>
                                                <td>@if($customer->judet == null)
                                                        -
                                                    @else
                                                        {{$customer->judet}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($customer->tara == null)
                                                        -
                                                    @else
                                                        {{$customer->tara}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($customer->iln == null)
                                                        -
                                                    @else
                                                        {{$customer->iln}}
                                                    @endif

                                                </td>
                                                <td>
                                                    @if($customer->cui == null)
                                                        -
                                                    @else
                                                        {{$customer->cui}}
                                                    @endif

                                                </td>
                                                <td>@if($customer->reg_com == null)
                                                        -
                                                    @else
                                                        {{$customer->reg_com}}
                                                    @endif

                                                </td>
                                                <td>
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tr class="addHover" style="border: 0;">
                                                            <td style="border: none;" align="left"
                                                                class="text-center mt-0 pt-0">
                                                                <!--Edit-->
                                                                <a href="{{route('customer.edit', [$customer->contractor_ean])}}"
                                                                   class="btn btn-info btn-lg mt-1 text-white"
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
                                                                    <button type="submit"
                                                                            class="btn btn-danger btn-lg mt-1"
                                                                            onclick="return confirm('Clientul {{$customer->nume}} va fi sters. Esti sigur?')"
                                                                            title="Stergere Client - {{$customer->nume}}">
                                                                        <i
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
                                <div id="customerFullInfos" class="displayNone">
                                    <table class="table">
                                        <thead class="bg-light text-dark">
                                        <tr>
                                            <th>Contractor EAN</th>
                                            <th>Nume</th>
                                            <th>Adresa</th>
                                            <th>Localitate</th>
                                            <th>Judet</th>
                                            <th>Tara</th>
                                            <th>ILN</th>
                                            <th>CUI</th>
                                            <th>Reg. Comert</th>
                                            <th>Banca</th>
                                            <th>Iban</th>
                                            <th>Pers.Contact</th>
                                            <th>Email</th>
                                            <th>Tel.</th>
                                            <th>Data adaugare companie</th>
                                            <th class="text-center">Actiuni</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($customers as $customer)
                                            <tr class="addHover">
                                                <th scope="row">{{$customer->contractor_ean}}</th>
                                                <td><a href="{{route('customer.edit', [$customer->contractor_ean])}}"
                                                       title="Editare Client -  {{$customer->nume}}">{{$customer->nume}}</a>
                                                </td>
                                                <td>
                                                    {{$customer->adresa}}
                                                </td>
                                                <td>
                                                    @if($customer->localitate == null)
                                                        -
                                                    @else
                                                        {{$customer->localitate}}
                                                    @endif
                                                </td>
                                                <td>@if($customer->judet == null)
                                                        -
                                                    @else
                                                        {{$customer->judet}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($customer->tara == null)
                                                        -
                                                    @else
                                                        {{$customer->tara}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($customer->iln == null)
                                                        -
                                                    @else
                                                        {{$customer->iln}}
                                                    @endif

                                                </td>
                                                <td>
                                                    @if($customer->cui == null)
                                                        -
                                                    @else
                                                        {{$customer->cui}}
                                                    @endif

                                                </td>
                                                <td>@if($customer->reg_com == null)
                                                        -
                                                    @else
                                                        {{$customer->reg_com}}
                                                    @endif

                                                </td>
                                                <td>
                                                    @if($customer->banca == null)
                                                        -
                                                    @else
                                                        {{$customer->banca}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($customer->iban == null)
                                                        -
                                                    @else
                                                        {{$customer->iban}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($customer->pers_contact == null)
                                                        -
                                                    @else
                                                        {{$customer->pers_contact}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($customer->telefon == null)
                                                        -
                                                    @else
                                                        {{$customer->telefon}}
                                                    @endif

                                                </td>
                                                <td>
                                                    @if($customer->email == null)
                                                        -
                                                    @else
                                                        {{$customer->email}}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$customer->created_at}}
                                                </td>
                                                <td>
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tr style="border: 0;">
                                                            <td style="border: none;" align="left"
                                                                class="text-center mt-0 pt-0">
                                                                <!--Edit-->
                                                                <a href="{{route('customer.edit', [$customer->contractor_ean])}}"
                                                                   class="btn btn-info text-white btn-lg mt-1"
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
                                                                    <button type="submit"
                                                                            class="btn btn-danger btn-lg mt-1"
                                                                            onclick="return confirm('Clientul {{$customer->nume}} va fi sters. Esti sigur?')"
                                                                            title="Stergere Client - {{$customer->nume}}">
                                                                        <i
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
                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                <p class="text-center p-2 mt-3"><i class="fas fa-exclamation-triangle"></i> <span
                                            class="text-dark">Momentan nu exista clineti in baza de date!</span> <a
                                            href="{{route('customer.create')}}">Va rugam sa adaugati clienti.</a> <i
                                            class="fas fa-exclamation-triangle"></i></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function showFullInfos() {
        document.getElementById("customerFullInfos").classList.add('displayBlock');
        document.getElementById("customerFullInfos").classList.remove('displayNone');
        document.getElementById("customerSamllInfos").classList.remove('displayBlock');
        document.getElementById("customerSamllInfos").classList.add('displayNone');
    }

    function showSmallInfos() {
        document.getElementById("customerFullInfos").classList.remove('displayBlock');
        document.getElementById("customerFullInfos").classList.add('displayNone');
        document.getElementById("customerSamllInfos").classList.remove('displayNone');
        document.getElementById("customerSamllInfos").classList.add('displayBlock');
    }
</script>