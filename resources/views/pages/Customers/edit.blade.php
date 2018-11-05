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
                        Editare Client
                    </div>
                    <div class="card-body">
                        <form action="{{route('customer.update', ['id'=>$customer->contractor_ean])}}" method="post"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nume">Nume Companie <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="nume" id="nume"
                                           placeholder="Nume Companie" value="{{$customer->nume}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="contractor_ean">EAN Companie <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="contractor_ean" id="contractor_ean"
                                           placeholder="EAN Companie" value="{{$customer->contractor_ean}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="adresa">Adresa Companie <i
                                            class="fas fa-exclamation text-danger"></i></label>
                                <input type="text" class="form-control" name="adresa" id="adresa"
                                       placeholder="Adresa Companie" value="{{$customer->adresa}}">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="localitate">Localitate <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="localitate" id="localitate"
                                           placeholder="Localitate" value="{{$customer->localitate}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="judet">Judet <i class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="judet" id="judet"
                                           placeholder="Judet Companie" value="{{$customer->judet}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tara">Tara</label>
                                    <input type="text" class="form-control" name="tara" id="tara"
                                           placeholder="Tara Companie" value="{{$customer->tara}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="iln">ILN</label>
                                    <input type="text" class="form-control" name="iln" id="iln" placeholder="ILN" value="{{$customer->iln}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cui">CUI Companie <i class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="cui" id="cui"
                                           placeholder="CUI Companie" value="{{$customer->cui}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="reg_com">Reg. Comertului</label>
                                    <input type="text" class="form-control" name="reg_com" id="reg_com"
                                           placeholder="Reg. Comertului" value="{{$customer->reg_com}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="banca">Banca</label>
                                    <input type="text" class="form-control" name="banca" id="banca" placeholder="Banca" value="{{$customer->banca}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="iban">IBAN</label>
                                    <input type="text" class="form-control" name="iban" id="iban" placeholder="IBAN" value="{{$customer->iban}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="pers_contact">Persoana de Contact</label>
                                    <input type="text" class="form-control" name="pers_contact" id="pers_contact"
                                           placeholder="Persoana de Contact" value="{{$customer->pers_contact}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="telefon">Telefon</label>
                                    <input type="text" class="form-control" name="telefon" id="telefon"
                                           placeholder="Telefon" value="{{$customer->telefon}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           placeholder="Email" value="{{$customer->email}}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizeaza Client</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection