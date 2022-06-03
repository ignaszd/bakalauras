<div class="card-header">
    <h5 class="card-title mb-0">Single reservation data</h5>
</div>
<div class="card-body">
    <div class="row g-0">
        <div class="col-sm-3 col-xl-12 col-xxl-3 text-center">
            <img src="https://www.w3schools.com/howto/img_avatar.png" width="64" height="64" class="rounded-circle mt-2" alt="Angelica Ramos">
        </div>
        <div class="col-sm-9 col-xl-12 col-xxl-9">
            <strong>Items for rent</strong>
            <p>
                Rental wakeboards count: {{$reservation->rental_wakeboards_count}}
                <br>
                Wetsuits count: {{$reservation->wetsuits_count}}
            </p>
        </div>
    </div>

    <table class="table table-sm mt-2 mb-4">
        <tbody>
        <tr>
            <th>Name</th>
            <td>{{$reservation->first_name.' '.$reservation->last_name}}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{$reservation->date}}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{$reservation->time}}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{$reservation->phone_number}}</td>
        </tr>
        <tr>
            <th>Status</th>
            @if($reservation->payment_status == 1)
                <td><span class="badge bg-success">Paid</span></td>
            @else
                <td><span class="badge bg-warning">Unpaid</span></td>
            @endif
        </tr>
        </tbody>
    </table>
</div>
