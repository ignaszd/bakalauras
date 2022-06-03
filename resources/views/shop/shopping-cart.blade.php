@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/shoppingCart.css') }}">
    <section class="shopping-cart">
        <div class="container">
            <div class="block-heading">
                <h2>Shopping Cart</h2>
                <p>Free shipping comes with a bigger price than 250€</p>
            </div>
            @include('layouts.success')
            <div class="content" style="background: #f2f2f2">
            @if(Session::has('cart'))
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <div class="items">
                            @foreach($products as $product)
                                <div class="product">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a href="{{route('shop.show',$product['item']['id'])}}">
                                                <img class="img-fluid mx-auto d-block image" src="{{asset('product_images/'.$product['item']['imagePath'])}}">
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
                                                    <div class="col-md-3 quantity">
                                                        <label for="quantity">Quantity:</label>
                                                        <input disabled id="quantity" type="number" value ="{{$product['qty']}}" class="form-control quantity-input">
                                                    </div>
                                                    <div class="col-md-2 price">
                                                        <span>{{$product['price']}}€</span>
                                                    </div>
                                                    <div class="col-md-2 price">
                                                        <div class="btn-group">
                                                            <button class="btn btn-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown">
                                                                Action
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="text-danger text-decoration-none" href="{{route('reduceByOne',['id'=>$product['item']['id']])}}">Reduce by 1</a>
                                                                </li>
                                                                <li>
                                                                    <a class="text-danger text-decoration-none" href="{{route('removeItem',['id'=>$product['item']['id']])}}">Remove all</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="summary">
                            <h3>Summary</h3>
                            <div class="summary-item"><span class="text">Subtotal</span><span class="price">{{$totalPrice}}€</span></div>
                            @if($totalPrice<250)
                                <div class="summary-item"><span class="text">Shipping</span><span class="price">3€</span></div>
                                <div class="summary-item"><span class="text">Total</span><span class="price">{{$totalPrice+3}}€</span></div>
                            @else
                                <div class="summary-item"><span class="text">Shipping</span><span class="price">0€</span></div>
                                <div class="summary-item"><span class="text">Total</span><span class="price">{{$totalPrice}}€</span></div>
                            @endif
                            <a type="button" href="{{route('checkout')}}" class="btn btn-primary btn-lg btn-block">Checkout</a>
                        </div>
                    </div>
                </div>
            @else
                 <div class="row">
                    <div class="">
                        <h2 class="text-center"> No items in cart </h2>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </section>

@endsection
