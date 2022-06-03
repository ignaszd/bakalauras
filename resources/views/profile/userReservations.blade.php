@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-4 p-0">
            <div class="row">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5 class="card-title mb-0">Reservations</h5>
                    </div>
                    <div class="card-body">
                        @if(count($reservations) == 0)
                            Make your first wakeboarding reservation to see
                        @else
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{$reservation->first_name.' '.$reservation->last_name}}</td>
                                    <td>{{$reservation->date}}</td>
                                    <td>{{$reservation->time}}</td>
                                    @if($reservation->payment_status == 1)
                                        <td><span class="badge bg-success">Paid</span></td>
                                    @else
                                        <td><span class="badge bg-warning">Unpaid</span></td>
                                    @endif
                                    <td>
                                        <form method="POST" action="{{route('profile.cancelReservation',[$reservation->id])}}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-outline-primary btn-sm mt-2" type="submit">Cancel reservation</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
