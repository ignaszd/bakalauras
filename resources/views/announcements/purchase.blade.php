@extends('layouts.app')

@section('content')

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Purchase information') }}</div>

                        <div class="card-body">
                            <form action="{{route('storePurchase')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{$announcement->user_id}}" name="seller_id"/>
                                <input type="hidden" value="{{$announcement->id}}" name="announcement_id"/>
                                <input type="hidden" value="{{Auth::user()->id}}" name="buyer_id"/>

                                <div class="row mb-3">
                                    <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First name') }}</label>
                                    <div class="col-md-6">
                                        <input id="first_name" type="text" class="form-control" name="first_name" placeholder="Write down your first name">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last name') }}</label>
                                    <div class="col-md-6">
                                        <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Write down your last name">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }}</label>
                                    <div class="col-md-6">
                                        <input id="phone_number" type="text" class="form-control" name="phone_number" placeholder="Write down your phone number">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                                    <div class="col-md-6">
                                        <input id="address" type="text" class="form-control" name="address" placeholder="Write down your address">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Payment bank') }}</label>
                                    <div class="col-md-6">
                                        <select name="bank" class="form-control">
                                            <option selected disabled> Select payment bank</option>
                                            <option value="Swedbank">Swedbank</option>
                                            <option value="SEB">SEB</option>
                                            <option value="Luminor">Luminor</option>
                                            <option value="Revolut">Revolut</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Make purchase
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
