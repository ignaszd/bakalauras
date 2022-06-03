@extends('layouts.app')
@section('content')

    <div class="container mt-5 mb-3">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                @include('layouts.success')
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="images p-3">
                                <div class="text-center p-4">
                                    <img id="main-image" src="{{asset('product_images/'.$product->imagePath)}}" width="250px" height="250px" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product p-3">
                                <div class="mt-2 mb-1"> <span class="text-uppercase text-muted brand">{{$product->brand}}</span>
                                    <h5 class="text-uppercase">{{$product->title.' '.$product->product}}</h5>
                                    <div class="price d-flex flex-row align-items-center"> <span class="act-price"></span>
                                        <div class="ml-2"> <small class="dis-price">{{$product->price}} €</small> </div>
                                    </div>
                                </div>
                                <p class="about">{{$product->description}}</p>
                                <div class="sizes mt-4">
                                    <header>
                                        <h6 class="text-uppercase" style="display:inline;">Size:</h6> {{$product->size}}
                                    </header>
                                </div>
                                <div class="cart mt-4 align-items-center">
                                    <a href = "{{route('addToCart',$product->id)}}" class = "btn btn-success " role = "button">
                                        <i class="fa fa-shopping-cart "></i> Add to cart
                                    </a>
                                    <a href="{{ URL::previous() }}" class="btn float-md-end">Go Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
