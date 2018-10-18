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
                                    <th>Produs</th>
                                    <th>Ean Produs</th>
                                    <th>Cantitate Produs</th>
                                    <th>Pret Produs</th>
                                    <th>Total Cantitate</th>
                                    <th>Total Pret</th>
                                    <th>Numar Aviz</th>
                                    <th class="text-center">Generare Aviz</th>
                                    <th class="text-center">Generare Declaratie de conformitate</th>
                                    <th class="text-center">DPD</th>
                                    <th class="text-center">Emite in SmartBill</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)

                                    <?php
                                    foreach($productsAsocArray as $productAsocArray){
                                       dd($productAsocArray);
                                    };


                                        ?>

                                        

                                    <tr>
                                        <th scope="row">
                                            {{$order->id}}
                                        </th>
                                        <td>
                                            {{$order->order_number}}
                                        </td>
                                        <td>
                                            <ul class="text-left list-group list-group-flush">
                                                @foreach($productsAsocArray as $productAsocArray)
                                                    <li class="text-left list-group-item">
                                                        {{$productAsocArray['product_name']}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="text-left list-group list-group-flush">
                                                @foreach($productsAsocArray as $productAsocArray)
                                                    <li class="text-left list-group-item">
                                                        {{$productAsocArray['product_ean']}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="text-left list-group list-group-flush">
                                                @foreach($productsAsocArray as $productAsocArray)
                                                    <li class="text-left list-group-item">


                                                    </li>
                                                @endforeach
                                            </ul>

                                        </td>
                                        <td>
                                            <ul class="text-left list-group list-group-flush">
                                                @foreach($productsAsocArray as $productAsocArray)
                                                    <li class="text-left list-group-item">
                                                        {{--{{$productAsocArray['product_price']}}--}}
                                                        {{$price =$productAsocArray['product_price']}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>


                                            <?php
                                            foreach ($productsAsocArray as $productAsocArray) {
                                                $qty = $productAsocArray['product_qty'];
                                                $int = (int)$qty;
                                                $sum = $int + $int + $int;
                                            }
                                            ?>
                                            <p><b>{{$sum}}</b></p>

                                        </td>
                                        <td>

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
                                        <td>
                                            <a href="" class="btn btn-secondary btn-sm"><i class="fas fa-file-alt"></i></a>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-dark btn-sm"><i class="far fa-file-alt"></i></a>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-danger btn-sm"><i
                                                        class="fas fa-shipping-fast"></i></a>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-primary btn-sm"><i
                                                        class="fas fa-file-invoice-dollar"></i></a>
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