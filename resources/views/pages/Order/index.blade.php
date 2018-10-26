@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('inc.messages')
                <div class="card mt-1">
                    <div class="card-header">
                        <h5 class="text-center">Comenzi</h5>
                    </div>
                    <div class="card-body pr-0 pl-0">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-3">
                                <a href="{{route('order.declarations')}}" class="btn btn-info btn-block"
                                   title="Generaza Declaratie de Conformitate pentru toate comenzile" target="_blank">Genereaza
                                    declaratii de confomitate</a>
                            </div>
                            <div class="col-md-3">
                                <a href="" class="btn btn-success btn-block"
                                   title="Generaza Avize de Insotire">Genereaza
                                    declaratii de confomitate</a>
                            </div>
                        </div>
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
                                            @if($order->notice_number != null)
                                                {{$order->notice_number}}
                                            @else
                                                <div class="aler alert-warning">
                                                    Inca nu exista!
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->notice == null)
                                                <a href="{{route('order.single.notice', [$order->id])}}" class="btn btn-success text-center" target="_blank"><i
                                                            class="fas fa-file-alt"></i></a>
                                            @else
                                                <button type="button" class="btn btn-secondary"
                                                        style="cursor:not-allowed;" disabled><i
                                                            class="fas fa-file-alt"></i></button>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->conformity_declaration == null)
                                                <a href="{{route('order.conformity', [$order->id])}}"
                                                   class="btn btn-info text-center"><i
                                                            class="far fa-file-alt"></i></a>
                                            @else
                                                <form action="{{route('order.conformity', ['id' => $order->id])}}" method="get">
                                                <i class="fas fa-check text-success"></i> &nbsp; <button title="Regenereaza Declaratie de Conformitate" type="submit" onclick="return confirm('Acesata Declaratie de conformitate a fost deja generata. Doresti sa o generezi din nou?')" class="btn btn-info text-center"><i class="far fa-file-alt"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->dpd_shipping == null)
                                                <a href="" class="btn btn-danger text-center" target="_blank"><i
                                                            class="fas fa-shipping-fast"></i></a>
                                            @else
                                                <button type="button" class="btn btn-secondary"
                                                        style="cursor:not-allowed;" disabled><i
                                                            class="fas fa-shipping-fast"></i></button>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->smart_bill_invoice == null)
                                                <a href="" class="btn btn-primary text-center" target="_blank"><i
                                                            class="fas fa-file-invoice-dollar"></i></a>
                                            @else
                                                <button type="button" class="btn btn-secondary"
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

@endsection