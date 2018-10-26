@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Editeaza data de Prajire pentru comanda <b>{{$order->order_number}}</b>.
                    </div>
                    <div class="card-body">
                        <form action="{{route('order.update', ['id'=>$order->id])}}" method="post"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <?php $productInfosArray = json_decode($order['product'], true);?>
                                <label for="date">Data curenta: <b>{{$productInfosArray[0]['frying_date']}}</b></label>
                                <input type="date" class="form-control" id="date" name="date"
                                       value="{{$productInfosArray[0]['frying_date']}}">
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizeza Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection