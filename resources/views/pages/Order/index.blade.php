@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('inc.messages')
                @if(count($orders) > 0)
                    <div class="card mt-1 mb-3">
                        <div class="card-header">
                            <h4 class="text-center"><i class="fas fa-list-ol"></i> &nbsp; Actiuni pentru toate
                                comenzile:
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-3 mt-2 mb-2 text-center">
                                    @if($orders[0]->serial_number != 0)
                                        <button type="button" class="btn btn-outline-success btn-block text-center"
                                                disabled><i
                                                    class="fas fa-check text-success"></i>&nbsp; Numerele de Serie au
                                            fost
                                            Generate
                                        </button>
                                    @else<a href="{{route('order.serial.numbers')}}"
                                            class="btn btn-primary btn-block text-center"
                                            title="Generaza Declaratie de Conformitate pentru toate comenzile">Genereaza
                                        Nr. de Serie Pentru Comenzi</a>
                                    @endif
                                </div>
                                <div class="col-md-3 mt-2 mb-2 text-center">
                                    @if($orders[0]->serial_number == 0)
                                        <button type="button" class="btn btn-outline-secondary btn-block text-center"
                                                onclick="noticeGeneratorAlert()"><i
                                                    class="fas fa-ban text-danger"></i>
                                            Genereaza
                                            Avize De Insotire
                                        </button>
                                    @else
                                        <a href="{{route('order.all.notices')}}"
                                           class="btn btn-success btn-block text-center"
                                           title="Generaza Avize de Insotire"
                                        >Genereaza
                                            Avize De Insotire</a>
                                    @endif
                                </div>
                                <div class="col-md-3 mt-2 mb-2 text-center">
                                    @if($orders[0]->notice == 0)
                                        <button type="button"
                                                class="btn btn-outline-secondary btn-block text-center"
                                                onclick="conformityGeneratorAlert()">
                                            <i class="fas fa-ban text-danger"></i>
                                            Genereaza
                                            declaratii de confomitate
                                        </button>
                                    @else
                                        <a href="{{route('order.declarations')}}"
                                           class="btn btn-info btn-block text-white text-center"
                                           title="Generaza Declaratie de Conformitate pentru toate comenzile">Genereaza
                                            declaratii de confomitate</a>
                                    @endif
                                </div>
                                <div class="col-md-3 mt-2 mb-2 text-center">
                                    <a id="generateStickers" href="{{route('order.create.stickers.pdf')}}"
                                       class="btn btn-primary btn-block text-center">Genereaza PDF cu Etichete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="text-center">Comenzi</h4>
                        </div>
                        <div class="card-body pr-0 pl-0">
                            <button class="bnt btn-outline-warning btn-lg text-center text-dark mb-3 mr-1 ml-1"
                                    onclick="showFullInfos()">Detaliat
                            </button>

                            <button class="bnt btn-outline-success btn-lg text-center text-dark mb-3 mr-1 ml-1"
                                    onclick="showSmallInfos()">Compact
                            </button>
                            <div class="table-responsive">
                                <div id="ordersSmallInfos" class="displayBlock">
                                    <table class="table">
                                        <thead class="bg-light text-dark">
                                        <tr>
                                            <th>#Id</th>
                                            <th>Ordin Comanda</th>
                                            <th>Client</th>
                                            <th>Produs</th>
                                            <th>Cantitate Produs</th>
                                            <th>Data Prajire</th>
                                            <th class="text-center">Aviz</th>
                                            <th class="text-center">Declaratie</th>
                                            <th class="text-center">Curier</th>
                                            <th class="text-center">SmartBill</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <?php $productInfosArray = json_decode($order['product'], true);?>
                                            <tr class="addHover">
                                                <th scope="row">
                                                    {{$order->id}} <span class="badge badge-warning">Noua</span>
                                                </th>
                                                <td>
                                                    {{$order->order_number}}
                                                </td>
                                                <td>
                                                    <p>{{$order->customer->nume}}</p>
                                                </td>
                                                <td>
                                                    <ul class="text-left list-group list-group-flush">
                                                        @foreach($productInfosArray as $k => $productInfo)

                                                            <li class="text-left list-group-item">
                                                                {{$productInfo['product_name']}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="text-left list-group list-group-flush">
                                                        @foreach($productInfosArray as $k => $productInfo)
                                                            <li class="text-left list-group-item">
                                                                {{$productInfo['product_qty']}}
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                </td>
                                                <td>
                                                    <ul class="text-left list-group list-group-flush">
                                                        @foreach($productInfosArray as $k => $productInfo)
                                                            <li class="text-left list-group-item">
                                                                {{$productInfo['frying_date']}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td class="text-center">
                                                    @if($order->notice == 0 && $order->serial_number == 0)
                                                        <i class="fas fa-ban text-danger"></i>
                                                        <button type="button" class="btn btn-outline-secondary btn-lg"
                                                                onclick="noticeAlertMessage()"><i
                                                                    class="fas fa-file-alt"></i></button>
                                                    @elseif($order->notice == 0 && $order->serial_number != 0)
                                                        <a href="{{route('order.single.notice', [$order->id])}}"
                                                           class="btn btn-success btn-lg text-center"><i
                                                                    class="fas fa-file-download"></i></a>
                                                    @elseif($order->notice == 1 && $order->serial_number != 0)
                                                        <form action="{{route('order.single.notice', ['id' => $order->id])}}"
                                                              method="get">
                                                            <i class="fas fa-check text-success"></i>&nbsp;
                                                            <button title="Regenereaza Aviz"
                                                                    type="submit"
                                                                    onclick="return confirm('Acest Aviz a fost deja generat. Doresti sa il generezi din nou?')"
                                                                    class="btn btn-success btn-lg"><i
                                                                        class="fas fa-file-download"></i></button>
                                                        </form>
                                                    @else
                                                        <div class="aler alert-warning text-center">
                                                            <i class="fas fa-robot"></i> A aparut o eroare!
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->notice == 0 && $order->serial_number == 0)
                                                        <i class="fas fa-ban text-danger"></i>
                                                        <button type="button"
                                                                class="btn btn-outline-dark btn-lg"
                                                                onclick="conformityAlertMessage()"><i
                                                                    class="far fa-file-alt"></i></button>
                                                    @elseif($order->notice == 0 && $order->conformity_declaration == 0 && $order->serial_number != 0)
                                                        <i class="fas fa-ban text-danger"></i>
                                                        <button type="button"
                                                                class="btn btn-outline-dark text-white btn-lg"
                                                                onclick="conformityAlertMessage()"><i
                                                                    class="far fa-file-alt"></i></button>
                                                    @elseif($order->notice == 1 && $order->conformity_declaration == 0 && $order->serial_number != 0)
                                                        <a href="{{route('order.conformity', [$order->id])}}"
                                                           class="btn btn-info text-white btn-lg"><i
                                                                    class="far fa-file-alt"></i></a>
                                                    @elseif($order->conformity_declaration == 1 && $order->serial_number != 0)
                                                        <form action="{{route('order.conformity', ['id' => $order->id])}}"
                                                              method="get">
                                                            <i class="fas fa-check text-success"></i>&nbsp;
                                                            <button title="Regenereaza Declaratie de Conformitate"
                                                                    type="submit"
                                                                    onclick="return confirm('Acesata Declaratie de conformitate a fost deja generata. Doresti sa o generezi din nou?')"
                                                                    class="btn btn-info btn-lg"><i
                                                                        class="far fa-file-alt"></i></button>
                                                        </form>
                                                    @else
                                                        <div class="aler alert-warning">
                                                            <i class="fas fa-robot"></i> A aparut o eroare!
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->dpd_shipping == 0)
                                                        <a href="{{route('generate.smd.awb', ['id' => $order->id])}}"
                                                           class="btn btn-danger btn-lg"><i
                                                                    class="fas fa-shipping-fast"></i></a>
                                                    @else
                                                        <button type="button" class="btn btn-secondary btn-lg"
                                                                style="cursor:not-allowed;" disabled><i
                                                                    class="fas fa-shipping-fast"></i></button>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->smart_bill_invoice == 0)
                                                        <a href="{{route('generate.smart.bill.invoice', ['id' => $order->id])}}"
                                                           class="btn btn-primary btn-lg"><i
                                                                    class="fas fa-file-invoice-dollar"></i></a>
                                                    @else
                                                        <i class="fas fa-check text-success"></i>&nbsp;
                                                        <button type="button" class="btn btn-secondary btn-lg"
                                                                style="cursor:not-allowed;" disabled><i
                                                                    class="fas fa-file-invoice-dollar"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div id="ordersFullInfos" class="displayNone">
                                    <table class="table">
                                        <thead class="bg-light text-dark">
                                        <tr>
                                            <th>#Id</th>
                                            <th>Ordin Comanda</th>
                                            <th>Client</th>
                                            <th>Produs</th>
                                            <th>Ean Produs</th>
                                            <th>Cantitate Produs</th>
                                            <th>Pret Produs</th>
                                            <th>Data Prajire</th>
                                            <th>Nr Aviz</th>
                                            <th class="text-center">Aviz</th>
                                            <th class="text-center">Declaratie</th>
                                            <th class="text-center">Curier</th>
                                            <th class="text-center">SmartBill</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <?php $productInfosArray = json_decode($order['product'], true);?>
                                            <tr class="addHover">
                                                <th scope="row">
                                                    {{$order->id}} <span class="badge badge-warning">Noua</span>
                                                </th>
                                                <td>
                                                    {{$order->order_number}}
                                                </td>
                                                <td>
                                                    <p>{{$order->customer->nume}}</p>
                                                </td>
                                                <td>
                                                    <ul class="text-left list-group list-group-flush">
                                                        @foreach($productInfosArray as $k => $productInfo)

                                                            <li class="text-left list-group-item">
                                                                {{$productInfo['product_name']}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="text-left list-group list-group-flush">
                                                        @foreach($productInfosArray as $k => $productInfo)
                                                            <li class="text-left list-group-item">
                                                                {{$productInfo['product_ean']}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="text-left list-group list-group-flush">
                                                        @foreach($productInfosArray as $k => $productInfo)
                                                            <li class="text-left list-group-item">
                                                                {{$productInfo['product_qty']}}
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                </td>
                                                <td>
                                                    <ul class="text-left list-group list-group-flush">
                                                        @foreach($productInfosArray as $k => $productInfo)
                                                            <li class="text-left list-group-item">
                                                                {{$productInfo['product_price']}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="text-left list-group list-group-flush">
                                                        @foreach($productInfosArray as $k => $productInfo)
                                                            <li class="text-left list-group-item">
                                                                {{$productInfo['frying_date']}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    @if($order->serial_number == 0)
                                                        <div class="aler alert-warning">
                                                            Negenerat
                                                        </div>
                                                    @else
                                                        ATSNP/{{$order->serial_number}}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->notice == 0 && $order->serial_number == 0)
                                                        <i class="fas fa-ban text-danger"></i>
                                                        <button type="button" class="btn btn-outline-secondary btn-lg"
                                                                onclick="noticeAlertMessage()"><i
                                                                    class="fas fa-file-alt"></i></button>
                                                    @elseif($order->notice == 1 && $order->serial_number != 0 && $order->notice_pdf_path == null)
                                                        <a href="{{route('order.single.notice', [$order->id])}}"
                                                           class="btn btn-success btn-lg text-center"><i
                                                                    class="fas fa-folder-plus"></i></a>
                                                    @elseif($order->notice == 0 && $order->serial_number != 0 && $order->notice_pdf_path == null)
                                                        <a href="{{route('order.single.notice', [$order->id])}}"
                                                           class="btn btn-success btn-lg text-center"><i
                                                                    class="fas fa-folder-plus"></i></a>
                                                    @elseif($order->notice == 1 && $order->serial_number != 0 && $order->notice_pdf_path != null)
                                                        <i class="fas fa-check text-success"></i>&nbsp;<a
                                                                href="{{route('order.single.notice.download', [$order->id])}}"
                                                                class="btn btn-success btn-lg text-center"><i
                                                                    class="fas fa-file-download"></i></a>
                                                    @else
                                                        <div class="aler alert-warning text-center">
                                                            <i class="fas fa-robot"></i> A aparut o eroare!
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->notice == 0 && $order->serial_number == 0)
                                                        <i class="fas fa-ban text-danger"></i>
                                                        <button type="button" class="btn btn-outline-dark btn-lg"
                                                                onclick="conformityAlertMessage()"><i
                                                                    class="far fa-file-alt"></i></button>
                                                    @elseif($order->notice == 0 && $order->conformity_declaration == 0 && $order->serial_number != 0)
                                                        <i class="fas fa-ban text-danger"></i>
                                                        <button type="button" class="btn btn-outline-dark btn-lg"
                                                                onclick="conformityAlertMessage()"><i
                                                                    class="far fa-file-alt"></i></button>
                                                    @elseif($order->notice == 1 && $order->conformity_declaration == 0 && $order->serial_number != 0)
                                                        <a href="{{route('order.conformity', [$order->id])}}"
                                                           class="btn btn-info btn-lg"><i
                                                                    class="far fa-file-alt"></i></a>
                                                    @elseif($order->conformity_declaration == 1 && $order->serial_number != 0)
                                                        <form action="{{route('order.conformity', ['id' => $order->id])}}"
                                                              method="get">
                                                            <i class="fas fa-check text-success"></i>&nbsp;
                                                            <button title="Regenereaza Declaratie de Conformitate"
                                                                    type="submit"
                                                                    onclick="return confirm('Acesata Declaratie de conformitate a fost deja generata. Doresti sa o generezi din nou?')"
                                                                    class="btn btn-info btn-lg"><i
                                                                        class="far fa-file-alt"></i></button>
                                                        </form>
                                                    @else
                                                        <div class="aler alert-warning">
                                                            <i class="fas fa-robot"></i> A aparut o eroare!
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->dpd_shipping == 0)
                                                        <a href="" class="btn btn-danger btn-lg"><i
                                                                    class="fas fa-shipping-fast"></i></a>
                                                    @else
                                                        <button type="button" class="btn btn-secondary btn-lg"
                                                                style="cursor:not-allowed;" disabled><i
                                                                    class="fas fa-shipping-fast"></i></button>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->smart_bill_invoice == 0)
                                                        <a href="{{route('generate.smart.bill.invoice', ['id' => $order->id])}}"
                                                           class="btn btn-primary btn-lg"><i
                                                                    class="fas fa-file-invoice-dollar"></i></a>
                                                    @else
                                                        <i class="fas fa-check text-success"></i>&nbsp;
                                                        <button type="button" class="btn btn-secondary btn-lg"
                                                                style="cursor:not-allowed;" disabled><i
                                                                    class="fas fa-file-invoice-dollar"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        <p class="text-center p-2 mt-3"><i class="fas fa-exclamation-triangle"></i> <span
                                    class="text-dark">Nu exista comenzi incarcate in Baza de Date!</span>
                            <br>
                            <a
                                    href="{{route('order.create')}}">Adauga comenzi.</a> <i
                                    class="fas fa-exclamation-triangle"></i></p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="generatePdfForStickers" tabindex="-1" role="dialog"
         aria-labelledby="generatePdfForStickers" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Va rugam sa asteptati!</h5>
                </div>
                <div class="modal-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%"
                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <p>Se genereaza Fisierul PDF.</p>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $('#generateStickers').click(function () {
                $('#generatePdfForStickers').modal('show');
                setTimeout(function () {
                    $("#generatePdfForStickers").modal('hide');
                }, 7000);
            });
        });


        function noticeGeneratorAlert() {
            alert("Generati mai intai Un Numar de Serie pentru toate comenzile");
        }

        function conformityGeneratorAlert() {
            alert("Trebuie sa generati mai intai Avizele de Insotire");
        }

        function noticeAlertMessage() {
            alert("Generare Aviz de Insotire a Marfii.  Inca nu a fost generat un Numar de Serie pentru aceasta Conmanda. Va rugam sa generati un numar de serie mai intai!");
        }

        function conformityAlertMessage() {
            alert("Generare Declaratie de Conformitate.  Generati inainte Avizul de Insotire al Marfii!");
        }
    </script>

    <script>
        function showFullInfos() {
            document.getElementById("ordersFullInfos").classList.remove('displayNone');
            document.getElementById("ordersFullInfos").classList.add('displayBlock');
            document.getElementById("ordersSmallInfos").classList.add('displayNone');
            document.getElementById("ordersSmallInfos").classList.remove('displayBlock');
        }

        function showSmallInfos() {
            document.getElementById("ordersFullInfos").classList.remove('displayBlock');
            document.getElementById("ordersFullInfos").classList.add('displayNone');
            document.getElementById("ordersSmallInfos").classList.remove('displayNone');
            document.getElementById("ordersSmallInfos").classList.add('displayBlock');
        }
    </script>
@endsection
