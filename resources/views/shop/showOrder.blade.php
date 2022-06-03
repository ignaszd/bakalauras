@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="items">
                    @foreach($orders as $order)
                        <div class="panel panel-default">
                            <div class="card mt-3">
                                <div class="card-body">
                                    <a href="{{ URL::previous() }}" class="btn btn-outline-primary float-md-end">Go Back</a>
                                    <ul class="list-group">
                                        @foreach($order->cart->items as $product)
                                            <div class="product">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <a href="{{route('shop.show',$product['item']['id'])}}">
                                                            <img height="150px" width="150" class="img-fluid mx-auto d-block image" src="{{asset('product_images/'.$product['item']['imagePath'])}}">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="info">
                                                            <div class="row">
                                                                <div class="col-md-5 product-name">
                                                                    <div class="product-name">
                                                                        <a href="{{route('shop.show',$product['item']['id'])}}">
                                                                            {{strlen($product['item']['title']) > 15 ? substr($product['item']['title'],0,15)."..." : $product['item']['title']}}

                                                                        </a>
                                                                        <div class="product-info">
                                                                            <div>Product: <span class="value">{{$product['item']['product']}}</span></div>
                                                                            <div>Brand: <span class="value">{{$product['item']['brand']}}</span></div>
                                                                            <div>Size: <span class="value">{{$product['item']['size']}}</span></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 text-center quantity">
                                                                    <label for="quantity">Quantity:</label>
                                                                    <input disabled id="quantity" type="number" value ="{{$product['qty']}}" class="form-control quantity-input text-center">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="price">Price:</label><br>
                                                                    <span class="price">{{$product['price']}}€</span>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
