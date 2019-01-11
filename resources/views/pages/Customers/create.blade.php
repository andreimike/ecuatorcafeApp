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

    <div id="searchLocationdataContainer" class="container displayNone">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div id="locationData" class="alert alert-success p-2 text-center" role="alert">

                </div>
            </div>
        </div>
    </div>

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
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="adresa">Adresa Companie <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="adresa" id="adresa"
                                           placeholder="Adresa Companie">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="localitate">Localitate <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="localitate" id="localitate"
                                           placeholder="Localitate">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="judet">Judet <i class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="judet" id="judet"
                                           placeholder="Judet Companie">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="codPostal">Cod Postal <i
                                                class="fas fa-exclamation text-danger"></i></label>
                                    <input type="text" class="form-control" name="codPostal" id="codPostal"
                                           placeholder="Codul Postal Exact">
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
                                    <input type="text" class="form-control" name="telefon" id="telefon"
                                           placeholder="Telefon">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           placeholder="Email">
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label for="email">Observatii pentru livrarea coletului</label>
                                    <textarea class="form-control" name="observatii" id="observatii"
                                              placeholder="Ex.: Zona in care trebuie lasat coletul pentru diferitele locatii.">

                                </textarea>
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

    <div class="modal fade" id="WaitForSalveModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="WaitForSalveCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Se cauta coduri postale</h5>
                </div>
                <div class="modal-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 100%"
                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <p>Va rugam sa asteptati!</p>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    window.onload = function () {

        $(document).ready(function () {

            $('#judet').hover(function () {

                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })

            });
        });

        $(document).ready(function () {
            $("#codPostal").one('click', function (event) {
                event.preventDefault();
                $('#WaitForSalveModalCenter').modal('show');
                var customerCity = $('#localitate').val();
                var customerCounty = $('#judet').val();
                var customerLocationData = {};
                customerLocationData['city'] = customerCity;
                customerLocationData['county'] = customerCounty;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: "{{route('search.customer.location.data')}}",
                    data: customerLocationData,
                    success: function (data) {
                        $('#WaitForSalveModalCenter').modal('hide');
                        var locationData = data['locationData']['data'];

                        var dispalyLocationData =
                            '<h6> Cod(uri) postal(e) sugerate:</h6>' +
                            '<p>';

                        for (var key in locationData) {

                            if (!locationData.hasOwnProperty(key)) continue;
                        }

                        var obj = locationData[key]['postalCode'];
                        for (var prop in obj) {

                            if (!obj.hasOwnProperty(prop)) break;

                            // console.log(obj[prop]);
                            // dispalyLocationData += obj[prop];
                        }

                        Object.keys(locationData).forEach(function (key) {

                            dispalyLocationData += "Oras/Localitate: " + "<b>" + locationData[key]['name'] + "</b>" + " - " + "Cod Posta: " + "<b>" + locationData[key]['postalCode'] + "</b>" + "<br>";

                            // console.log(locationData[key]);

                        });

                        dispalyLocationData += '</p>';

                        $('#locationData').html(dispalyLocationData);
                        $('#searchLocationdataContainer').show();

                    }
                });
                // $(this).prop('disabled', true);
            });
        });

    };

</script>