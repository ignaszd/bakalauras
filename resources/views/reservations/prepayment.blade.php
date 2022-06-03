@extends('layouts.app')

@section('content')
    @php
        $stripe_key = 'pk_test_51KaGgxCc3mCpUx3hju74h8eL3aUat6HZMhzNv84ORR2b7MVwe9L5Nb8pMr5yV3eFvq8xgF9f6YmJAcsbIWF8Af4Z00PzAF2LNr';
    @endphp
    <div class="container pt-1">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Reservation information') }}</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="full_name" class="col-md-2 col-form-label text-md-end">{{ __('Full name') }}</label>
                            <div class="col-md-3">
                                <input disabled type="text" class="form-control" value="{{session()->get('first_name')}} {{session()->get('last_name')}}" aria-label="First name" name="first_name">
                            </div>
                            <label for="phone_number" class="col-md-2 col-form-label text-md-end">{{ __('Phone number') }}</label>
                            <div class="col-md-3">
                                <input disabled type="text" class="form-control" value="{{session()->get('phone_number')}}" aria-label="Phone number" name="phone_number">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="wakeboards" class="col-md-2 col-form-label text-md-end">{{ __('Wakeboards count') }} </label>
                            <div class="col-md-3">
                                <input disabled type="text" class="form-control" value="{{session()->get('rental_wakeboards_count')}}" aria-label="wakeboards" name="wakeboards">
                            </div>
                            <label for="wetsuits" class="col-md-2 col-form-label text-md-end">{{ __('Wetsuits count') }}</label>
                            <div class="col-md-3">
                                <input disabled type="text" class="form-control" value="{{session()->get('wetsuits_count')}}" aria-label="wetsuits" name="wetsuits">
                            </div>
                        </div>
                    </div>

                    <form action="{{route('reservations.Prepayment')}}"  method="post" id="payment-form">
                        <div class="row mb-1">
                            <label for="wakeboards" class="col-md-2 col-form-label text-md-end">{{ __('Selected times') }} </label>
                            <div class="col-md-4">
                                @foreach($times as $time)
                                    <li>{{$time}}</li>
                                @endforeach
                            </div>
                            <p class="text-center"><b>Total reservation price is: {{$price}} €</b></p>
                        </div>
                        @include('checkout.checkoutform')
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function(){
            if (window.history && window.history.pushState) {

                window.history.pushState('forward', null);

                $(window).on('popstate', function() {
                    window.location.href = "http://127.0.0.1:8000/reservations";
                });

            }
            });
    </script>


    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.getElementById('card-button').onclick = function() {
            $('card-button').attr('data-secret',{{$intent}})
        }
    </script>
    <script>
        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)

        var style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const stripe = Stripe('{{ $stripe_key }}', { locale: 'en' }); // Create a Stripe client.
        const elements = stripe.elements(); // Create an instance of Elements.
        const cardElement = elements.create('card', { style: style }); // Create an instance of the card Element.

        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardElement.mount('#card-element'); // Add an instance of the card Element into the `card-element` <div>.

        // Handle real-time validation errors from the card Element.
        cardElement.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.handleCardPayment(clientSecret, cardElement, {
                payment_method_data: {
                    // billing_details: { name: cardHolderName.value }
                }
            })
                .then(function(result) {
                    console.log(result);
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        console.log(result);
                        form.submit();
                    }
                });
        });

    </script>
@endsection
