@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-1">
                    <div class="card-header">
                        <h5 class="text-center">Comenzi</h5>
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
                                    <th>Numar Aviz</th>
                                    <th class="text-center">Aviz</th>
                                    <th class="text-center">Declaratie</th>
                                    <th class="text-center">DPD</th>
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
                                            @if($order->notice_number != null)
                                                {{$order->notice_number}}
                                            @else
                                                <div class="aler alert-warning">
                                                    Inca nu exista un numar de aviz!
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->notice == null)
                                                <a href="" class="btn btn-success text-center"><i
                                                            class="fas fa-file-alt"></i></a>
                                            @else
                                                <button type="button" class="btn btn-secondary"
                                                        style="cursor:not-allowed;" disabled><i
                                                            class="fas fa-file-alt"></i></button>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->conformity_declaration == null)
                                                <a href="" class="btn btn-info text-center"><i
                                                            class="far fa-file-alt"></i></a>
                                            @else
                                                <button type="button" class="btn btn-secondary"
                                                        style="cursor:not-allowed;" disabled><i
                                                            class="far fa-file-alt"></i></button>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->dpd_shipping == null)
                                                <a href="" class="btn btn-danger text-center"><i
                                                            class="fas fa-shipping-fast"></i></a>
                                            @else
                                                <button type="button" class="btn btn-secondary"
                                                        style="cursor:not-allowed;" disabled><i
                                                            class="fas fa-shipping-fast"></i></button>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->smart_bill_invoice == null)
                                                <a href="" class="btn btn-primary text-center"><i
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