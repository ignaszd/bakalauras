@extends('layouts.app')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.js"></script>
    <link rel="stylesheet" href="{{ asset('css/reservationList.css') }}">
    <div class="container">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Reservations</h1>
            <div class="row">
                <div id="list_data" class="col-md-8">
                    @include('reservations.includes.reservations_list_data')
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Reservations date</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-0">
                                <div class="card-header bg-white border-0">
                                    <div class="mx-0 mb-0 row justify-content-sm-center justify-content-start px-1">
                                        <input required type="text" id="dp1" class="datepicker text-center" placeholder="Select date" name="date" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="info" style="display: block" class="card mt-2">
                        @if($a == 1)
                            @include('reservations.includes.showReservation')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                startDate: '0d'
            });

            $('#dp1').on('change',function (){
                getMoreAnnouncements();
            });

            $('.id').click(function(){
                {{$a = $a + 1}};
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
                document.getElementById('info').style.display = "block";
            });


            function getMoreAnnouncements(){
                var selectedDate = $('#dp1').val();
                $.ajax({
                    type: "GET",
                    data: {
                        'date': selectedDate,
                    },
                    cache: true,
                    url: "{{ route('reservations.getReservationsList') }}",
                    success:function (data){
                        $('#list_data').html(data);
                    }
                })

            }

        });
    </script>
@endpush
