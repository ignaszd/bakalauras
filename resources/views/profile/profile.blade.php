@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="main-body">
            @include('layouts.success')
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="https://www.w3schools.com/howto/img_avatar.png" class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4>{{$user->first_name.' '.$user->last_name}}</h4>
                                    <p class="text-secondary mb-1">Announcements count: {{$count}}</p>
                                    <p class="text-secondary mb-1">Registered at: {{$user->created_at->format('Y-m-d')}}</p>
                                    <a href="{{route('profile.myReservations')}}" class="btn btn-outline-primary">
                                        Wakeboarding reservations
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{$user->first_name.' '.$user->last_name}}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{$user->email}}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{$user->phone_number}}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Gender</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ucfirst($user->gender)}}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn btn-outline-primary" href="{{route('profile.editProfile',[$user->id])}}">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="container mt-5">
        @if(count($orders) == 0)
        <div class="card-header">
            <h6 class="text-center card-title mb-0">Make your first purchase to display orders</h6>
        </div>
        @else
            <div class="card-header">
                <h6 class="text-center card-title mb-0">Inventory orders list</h6>
            </div>
            <div class="card-body">
            <table class="table table-borderless main">
                <thead>
                <tr class="head">
                    <th scope="col">Order ID</th>
                    <th scope="col">Created</th>
                    <th scope="col">Updated</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Total</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Status</th>
                    <th scope="col">Information</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="rounded bg-white">
                        <td class="order-color">{{$order->id}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->updated_at}}</td>
                        <td class="d-flex align-items-center"><span class="ml-2">{{$order->user->first_name.' '.$order->user->last_name}}</span> </td>
                        <td>{{$order->cart->totalPrice}}€</td>
                        <td>{{$order->cart->totalItems}}</td>
                        <td>
                            @if($order->status == 0)
                                <span class="badge bg-danger">Waiting for approval</span>
                            @elseif($order->status == 1)
                                <span class="badge bg-warning">Approved</span>
                            @else
                                <span class="badge bg-success">Sent</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <a href="{{route('shop.showOrder',[$order->id])}}" class="btn btn-outline-primary btn-sm" type="button">
                                    Details
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        @endif
    </div>


@endsection
