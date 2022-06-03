@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit profile') }}</div>

                    <div class="card-body">
                        <form method="POST" id="editProfileForm" action="{{ route('profile.updateProfile') }}">
                            @csrf
                            <input hidden name="user-id" value="{{$user->id}}">
                            <div class="row mb-3">
                                <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }} <b class="text-danger">*</b></label>

                                <div class="col-md-6">
                                    <input  id="username" type="text" class="form-control @error('username') is-invalid  @enderror" name="username" value="{{$user->username}}" autocomplete="username" autofocus>

                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }} <b class="text-danger">*</b></label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }} <b class="text-danger">*</b></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }} <b class="text-danger">*</b></label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First name') }} <b class="text-danger">*</b></label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{$user->first_name}}" autocomplete="first_name" autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last name') }} <b class="text-danger">*</b></label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{$user->last_name}}" autocomplete="last_name" autofocus>

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }} <b class="text-danger">*</b></label>

                                <div class="col-md-6">
                                    <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{$user->phone_number}}" autocomplete="phone_number" autofocus>

                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="">
                                <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
                                <div class="form-check form-check-inline">
                                    <input @if($user->gender == 'male')checked @endif class="form-check-input" type="radio" name="gender" id="male" value="male">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input @if($user->gender == 'female')checked @endif class="form-check-input" type="radio" name="gender" id="female" value="female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>

                            <div class="row mb-2 justify-content-center">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" style="width: 150px">
                                        {{ __('Edit profile') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $.validator.addMethod(
                "regex",
                function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                },
            );

            $("#editProfileForm").validate({
                rules: {

                    last_name: {
                        required: true,
                        maxlength: 30,
                        regex: /^[^\s]+(\s+[^\s]+)*$/
                    },
                    phone_number: {
                        required: true,
                        maxlength: 15,
                        regex: /^[+0-9]*$/
                    }
                },
                messages: {

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

                }
            });
        });
    </script>
@endsection

