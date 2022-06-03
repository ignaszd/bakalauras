@forelse($products->chunk(4) as $productsChunk)
    <div class="row">
        @foreach($productsChunk as $product)
            <div class="col-sm-6 col-md-3" style="width: 310px; height: 600px">
                <div class = "thumbnail text-center">
                    <a href="{{route('shop.show',$product->id)}}">
                        <img src ="product_images/{{$product->imagePath}}" class = "img-thumbnail" style="width: 300px;height: 300px">
                    </a>
                    <div class="card-body text-dark">
                        <div style="height: 180px">
                            <h5 class="card-title">{{strlen($product->title) > 22 ? substr($product->title,0,22)."..." : $product->title}}</h5>
                            <p class="card-text text-start"> {{strlen($product->description) > 160 ? substr($product->description,0,160).'...': $product->description}}</p><br>
                        </div>
                        <div class="">
                            <a href = "{{route('shop.show',$product->id)}}" class = "btn btn-success float-md-end" role = "button">
                                Show product
                            </a>
                            <div>
                                <div class="float-md-start">Price: <b>{{$product->price}}€</b> </div><br>
                                <div class="float-md-start">Size: <b>{{$product->size}} </b></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@empty

    <b><p class="text-center">There is no items for sale.</p></b>

@endforelse

<div>
    {!! $products->links() !!}
</div>
