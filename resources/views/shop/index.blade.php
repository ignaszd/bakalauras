@extends('layouts.app')

@section('content')

    <div class="container">
        <div style="margin-bottom: 20px;margin-top: 20px">
            @include('announcements.includes.filter',['shop'=>true])
        </div>
        <div class="row" style="width: 94%;margin-left: 0">
            @include('layouts.success')
        </div>
        <div id="product_data">
            @include('shop.includes.products_data')
        </div>
    </div>
@endsection

@push('scripts')
    <script>

        $(document).ready(function (){
            $(document).on('click', '.pagination a', function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                getMoreProducts(page);
            });

            $('#product').on('change',function (){
                getMoreProducts();
            });
            $('#brand').on('change',function (){
                getMoreProducts();
            });
            $('#size').on('change',function (){
                getMoreProducts();
            });
        });

        function getMoreProducts(page){
            var selectedProduct = $('#product option:selected').val();
            var selectedBrand = $('#brand option:selected').val();
            var selectedSize = $('#size option:selected').val();
            $.ajax({
                type: "GET",
                data: {
                    'product': selectedProduct,
                    'brand': selectedBrand,
                    'size': selectedSize
                },
                url: "{{ route('shop.get-more-products') }}" + "?page=" + page,
                success:function (data){
                    $('#product_data').html(data);
                }
            })
        }
    </script>
@endpush
