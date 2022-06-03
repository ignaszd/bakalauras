@extends('layouts.app')

@section('content')


    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}" >


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

    <div class="container-fluid-reservation px-sm-4 mx-10">
        <div class="row justify-content-center mx-0">
            <div class="col-lg-10">
                @include('layouts.success')
                <div class="card border-0">
                    <form class="reservationInfo" autocomplete="off" method="get" action="{{route('reservations.Prepayment')}}">
                        <div class="row">
                            <div class="mx-auto mt-3" style="width: 90%">
                                <div class="card-body p-3 p-sm-4" >
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">First name<span class="text-danger"> *</span></label>
                                            <input type="text" id="first_name" name="first_name"
                                                   @if(Auth::user()) value="{{Auth::user()->first_name}}" @endif
                                            >

                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Last name<span class="text-danger"> *</span></label>
                                            <input type="text" id="last_name" name="last_name"
                                                   @if(Auth::user()) value="{{Auth::user()->last_name}}@endif"
                                            >
                                        </div>
                                    </div>
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-4 flex-column d-flex">
                                            <label class="form-control-label px-3">Phone number<span class="text-danger"> *</span></label>
                                            <input type="text" id="phone_number" name="phone_number"
                                                   @if(Auth::user()) value="{{Auth::user()->phone_number}}" @endif
                                            >
                                        </div>
                                        <div class="form-group col-sm-4 flex-column d-flex">
                                            <label class="form-control-label px-3">Wetsuits</label>
                                            <select name="wetsuitCount">
                                                <option value="0 0" selected>{{App\Constants\GlobalConstants::EMPTY}}</option>
                                                {{$i=1}}
                                                @foreach(App\Constants\GlobalConstants::LIST_WETSUIT_UNITS as $unit)
                                                    <option value="{{$unit}} {{$i}}">{{$i}} unit price: {{$unit}}€</option>
                                                    {{$i++}}
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4 flex-column d-flex">
                                            <label class="form-control-label px-3">Wakeboards</label>
                                            <select name="wakeboardCount">
                                                <option value="0 0" selected>{{App\Constants\GlobalConstants::EMPTY}}</option>
                                                {{$i=1}}
                                                @foreach(App\Constants\GlobalConstants::LIST_WETSUIT_UNITS as $unit)
                                                    <option value="{{$unit}} {{$i}}">{{$i}} unit price: {{$unit}}€</option>
                                                    {{$i++}}
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="datepicker" class="mx-auto" style="width: 40%">
                                @include('reservations.includes.datepicker')
                            </div>

                            @include('reservations.includes.reservation_data')
                        </div>

                        <div class="text-center mb-3">
                            <button type="submit" class="confirm">Prepay for reservation</button>
                            @csrf
                            <button type="submit" class="confirm" formmethod="post" formaction="{{route('reservations.store')}}">Reserve now pay later</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                startDate: '0d'
            });

            $('.cell').click(function(){
                $('.cell').removeClass('select');
                $(this).addClass('select');
            });

            $('#dp1').on('change',function (){
                getMoreAnnouncements();

            });

            $('.confirm').click(function() {
                checked = $("input[type=checkbox]:checked").length;
                if(!checked) {
                    $('.testt').removeAttr('hidden');
                    return false;
                }
            });

            $.validator.addMethod(
                "regex",
                function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                },
            );

            $(".reservationInfo").validate({
                rules: {
                    first_name: {
                        required: true,
                        maxlength: 30,
                        regex: /^[^\s]+(\s+[^\s]+)*$/
                    },
                    last_name: {
                        required: true,
                        maxlength: 30,
                        regex: /^[^\s]+(\s+[^\s]+)*$/
                    },
                    phone_number: {
                        required: true,
                        maxlength: 15,
                        regex: /^[+0-9]*$/
                    },
                    date:{
                        required: true,
                    },
                },
                messages: {
                    first_name: {
                        required: "Please enter your first name",
                        maxlength: "First name cannot be more than 30 characters",
                        regex: "No whitespaces allowed at the end or start of first name"
                    },
                    last_name: {
                        required: "Please enter your last name",
                        maxlength: "Last name cannot be more than 30 characters",
                        regex: "No whitespaces allowed at the end or start of last name"

                    },
                    phone_number: {
                        required: "Please enter your phone number",
                        maxlength: "Phone number cannot be more than 15 characters",
                        regex: "Phone cannot have any special chars or whitespaces"
                    }
                },
            });



            function getMoreAnnouncements(){
                var selectedDate = $('#dp1').val();
                var checked = $("input[type=checkbox]:checked").length;
                $.ajax({
                    type: "GET",
                    data: {
                        'date': selectedDate,
                        'checked': checked,
                    },
                    cache: true,
                    url: "{{ route('reservations.get-more-reservations') }}",
                    success:function (data){
                        $('#announcement_data').html(data);
                    }
                })
            }
        });
    </script>
@endsection
@push('scripts')


@endpush
