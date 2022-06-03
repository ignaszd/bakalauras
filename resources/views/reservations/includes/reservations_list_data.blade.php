 <div class="card">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0">Clients</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped" style="width:100%">
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
                        <td><button type="button" name="btn" value="{{$reservation->id}}" class="id btn btn-primary">Info</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
<script>
    $(document).ready(function(){
        $('.id').click(function() {
            var id = $(this).attr("value");
            $.ajax({
                type: "GET",
                data: {
                    'id': id,
                },
                cache: true,
                url: "{{ route('reservations.getReservationInfo') }}",
                success:function (data){
                    $('#info').html(data);
                }
            })
        });
    });
</script>
