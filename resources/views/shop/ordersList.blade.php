@extends('layouts.app')

@section('content')

    <div class="container mt-5">
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
                        <div class="dropdown">
                            @if($order->status == 0)
                                <a
                                    class="btn-sm dropdown-toggle btn btn-danger d-flex align-items-center text-reset nav-link"
                                    href="#"
                                    data-bs-toggle="dropdown"
                                    role="button"
                                    data-mdb-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    Waiting for approval
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form method="POST" action="{{route('shop.approve',[$order->id])}}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="dropdown-item btn-sm">Approved</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{route('shop.sent',[$order->id])}}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="dropdown-item btn-sm">Sent</button>
                                        </form>
                                    </li>
                                </ul>
                            @elseif($order->status == 1)
                                <a
                                    class="dropdown-toggle btn btn-sm btn-warning d-flex align-items-center text-reset nav-link"
                                    href="#"
                                    data-bs-toggle="dropdown"
                                    role="button"
                                    data-mdb-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    Approved
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <form method="POST" action="{{route('shop.sent',[$order->id])}}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="dropdown-item btn-sm">Sent</button>
                                    </form>
                                </ul>
                            @else
                                <button class="btn btn-sm btn-success d-flex align-items-center text-reset nav-link disabled">
                                    Sent
                                </button>
                            @endif
                        </div>
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
@endsection
