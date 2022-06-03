@extends('layouts.app')

@section('content')

    <div class="container">
        @include('announcements.includes.filter',['announcements'=>true])

        <div id="announcement_data">
            <div class="row" style="width: 94%;margin-left: 0">
            @include('layouts.success')
            </div>

            @include('announcements.includes.announcement_data')
        </div>
    </div>


    <link rel="stylesheet" href="{{ asset('css/announcements.css') }}">

@endsection
    @push('scripts')
        <script>
            $(document).ready(function (){
                $(document).on('click', '.pagination a', function(event){
                    event.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    getMoreAnnouncements(page);
                });


                $('#product').on('change',function (){
                    getMoreAnnouncements();
                });
                $('#brand').on('change',function (){
                    getMoreAnnouncements();
                });
                $('#size').on('change',function (){
                    getMoreAnnouncements();
                });
            });

            function getMoreAnnouncements(page){
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
                    url: "{{ route('announcements.get-more-announcements') }}" + "?page=" + page,
                    success:function (data){
                        $('#announcement_data').html(data);
                    }
                })
            }
        </script>
    @endpush

