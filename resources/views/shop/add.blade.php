@extends('layouts.app')

@section('content')


    <form class="shop" action="{{route('storeProduct')}}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('shop.includes.form',['create'=>true])

    </form>

@endsection
