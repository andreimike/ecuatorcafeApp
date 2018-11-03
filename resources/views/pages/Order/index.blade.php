@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('inc.messages')
                <div class="card mt-1 mb-3">
                    <div class="card-header">
                        <h4 class="text-center"><i class="fas fa-list-ol"></i> &nbsp; Actiuni pentru toate comenzile:
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-3 mt-2 mb-2 text-center">
                                @if($orders[1]->serial_number != 0 && $orders[2]->serial_number != 0)
                                    <button type="button" class="btn btn-outline-success text-center" disabled><i
                                                class="fas fa-check text-success"></i>&nbsp; Numerele de Serie au fost
                                        Generate
                                    </button>
                                @else<a href="{{route('order.serial.numbers')}}"
                                        class="btn btn-primary btn-block text-center"
                                        title="Generaza Declaratie de Conformitate pentru toate comenzile">Genereaza
                                    Nr. de Serie Pentru Comenzi</a>
                                @endif
                            </div>
                            <div class="col-md-3 mt-2 mb-2 text-center">
                                @if($orders[1]->serial_number == 0 && $orders[2]->serial_number == 0)
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
                                       target="_blank">Genereaza
                                        Avize De Insotire</a>
                                @endif
                            </div>
                            <div class="col-md-3 mt-2 mb-2 text-center">
                                @if($orders[1]->notice == 0 && $orders[2]->notice == 0)
                                    <button type="button" class="btn btn-outline-secondary text-center"
                                            onclick="conformityGeneratorAlert()">
                                        <i class="fas fa-ban text-danger"></i>
                                        Genereaza
                                        declaratii de confomitate
                                    </button>
                                @else
                                    <a href="{{route('order.declarations')}}" class="btn btn-info btn-block text-center"
                                       title="Generaza Declaratie de Conformitate pentru toate comenzile">Genereaza
                                        declaratii de confomitate</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="text-center">Comenzi</h4>
                    </div>
                    <div class="card-body pr-0 pl-0">
                        <div class="table-responsive">
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
                                    <tr>
                                        <th scope="row">
                                            {{$order->id}}
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
                                                    <button title="Regenereaza Declaratie de Conformitate" type="submit"
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
                                                <a href="" class="btn btn-danger btn-lg" target="_blank"><i
                                                            class="fas fa-shipping-fast"></i></a>
                                            @else
                                                <button type="button" class="btn btn-secondary btn-lg"
                                                        style="cursor:not-allowed;" disabled><i
                                                            class="fas fa-shipping-fast"></i></button>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->smart_bill_invoice == 0)
                                                <a href="" class="btn btn-primary btn-lg" target="_blank"><i
                                                            class="fas fa-file-invoice-dollar"></i></a>
                                            @else
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
        </div>
    </div>

    <script>
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

@endsection

