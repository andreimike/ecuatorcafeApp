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
                        Adauga un nou client
                    </div>
                    <div class="card-body">
                        <form action="{{route('customer.store')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nume">Nume Companie <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="nume" id="nume"
                                           placeholder="Nume Companie">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="contractor_ean">Ean Companie <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="contractor_ean" id="contractor_ean"
                                           placeholder="Contractor EAN">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="adresa">Adresa Companie <i
                                            class="fas fa-exclamation text-danger"></i></label>
                                <input type="text" class="form-control" name="adresa" id="adresa"
                                       placeholder="Adresa Companie">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="localitate">Localitate <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="localitate" id="localitate"
                                           placeholder="Localitate">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="judet">Judet <i class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="judet" id="judet"
                                           placeholder="Judet Companie">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tara">Tara</label>
                                    <input type="text" class="form-control" name="tara" id="tara"
                                           placeholder="Tara Companie">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="iln">ILN</label>
                                    <input type="text" class="form-control" name="iln" id="iln" placeholder="ILN">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cui">CUI Companie <i class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="cui" id="cui"
                                           placeholder="CUI Companie">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="reg_com">Reg. Comertului</label>
                                    <input type="text" class="form-control" name="reg_com" id="reg_com"
                                           placeholder="Reg. Comertului">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="banca">Banca</label>
                                    <input type="text" class="form-control" name="banca" id="banca" placeholder="Banca">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="iban">IBAN</label>
                                    <input type="text" class="form-control" name="iban" id="iban" placeholder="IBAN">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="pers_contact">Persoana de Contact</label>
                                    <input type="text" class="form-control" name="pers_contact" id="pers_contact"
                                           placeholder="Persoana de Contact">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="telefon">Telefon</label>
                                    <input type="text" class="form-control" name="telefon" id="telefon" placeholder="Telefon">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Adauga Client</button>
                        </form>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('upload.customers')}}"><i class="fas fa-cloud-upload-alt"></i> Importa Clineti
                            din Fisier XLXS</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection