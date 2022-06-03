@extends('layouts.app')

@section('content')

        @php
            $stripe_key = 'pk_test_51KaGgxCc3mCpUx3hju74h8eL3aUat6HZMhzNv84ORR2b7MVwe9L5Nb8pMr5yV3eFvq8xgF9f6YmJAcsbIWF8Af4Z00PzAF2LNr';
        @endphp
        <div class="container pt-1">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{route('checkout')}}"  method="post" id="payment-form">
                            <div class="card-header">{{ __('Delivery information') }}</div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label for="first_name" class="col-md-2 col-form-label text-md-end">{{ __('First name') }} <b class="text-danger">*</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" placeholder="First name" aria-label="First name" name="first_name">
                                    </div>
                                    <label for="last_name" class="col-md-2 col-form-label text-md-end">{{ __('Last name') }} <b class="text-danger">*</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" name="last_name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="city" class="col-md-2 col-form-label text-md-end">{{ __('City') }} <b class="text-danger">*</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" placeholder="City" aria-label="City" name="city">
                                    </div>
                                    <label for="address" class="col-md-2 col-form-label text-md-end">{{ __('Address') }} <b class="text-danger">*</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" placeholder="Address" aria-label="Address" name="address">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="phone_number" class="col-md-2 col-form-label text-md-end">{{ __('Phone number') }} <b class="text-danger">*</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" placeholder="Phone number" aria-label="Phone number" name="phone_number">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{$id}}" name="payment_id">
                            @include('checkout.checkoutform',['shop'=>true])
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://js.stripe.com/v3/"></script>
        <script>
            document.getElementById('card-button').onclick = function() {
                $('card-button').attr('data-secret',{{$intent}})
            }
        </script>
        <script>
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

    <script>
        $(document).ready(function() {
            $.validator.addMethod(
                "regex",
                function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                },
            );

            $("#payment-form").validate({
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
                    city: {
                        required: true,
                        maxlength: 20,
                        regex: /^[^\s]+(\s+[^\s]+)*$/
                    },
                    address: {
                        required: true,
                        maxlength: 40,
                        regex: /^[^\s]+(\s+[^\s]+)*$/
                    }
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
                    },
                    city: {
                        required: "Please enter your delivery city",
                        maxlength: "City cannot be more than 20 characters",
                        regex: "No whitespaces allowed at the end or start of last name"
                    },
                    address: {
                        required: "Please enter your delivery address",
                        maxlength: "Address cannot be more than 40 characters",
                        regex: "No whitespaces allowed at the end or start of last name"
                    }
                }
            });
        });
    </script>
@endsection
