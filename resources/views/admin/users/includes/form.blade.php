@csrf

<div class="row mb-3">
    <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

    <div class="col-md-6">
        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username"
               value="{{old('username')}}@isset($user){{$user->username}}@endisset" autocomplete="name" autofocus>

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
               value="{{ old('email') }} @isset($user) {{$user->email}} @endisset" autocomplete="email">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
@isset($create)
    <div class="row mb-3">
        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
@endisset

<div class="row mb-3">
    <label for="roles" class="col-md-4 col-form-label text-md-end">{{ __('Roles') }}</label>

    <div class="col-md-6">
        @foreach($roles as $role)
            <div class="form-check">
                <input @if($role->name == 'user') disabled checked @endif class="form-check-input" name="roles[]" type="checkbox"
                       value="{{$role->id}}" id="{{$role->name}}"
                       @isset($user) @if(in_array($role->id, $user->roles->pluck('id')->toArray())) checked @endif @endisset>
                <label class="form-check-label" for="{{$role->name}}">
                    {{$role->name}}
                </label>
            </div>
        @endforeach
    </div>
</div>

<div class="row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-danger">
            Submit
        </button>
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

        $("#createForm").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 4,
                    maxlength: 30,
                    regex: /^(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/, // no _. at begining or end or __ .. ._ inside
                    remote: '{{route('validateUsername')}}'
                },
                email: {
                    email: true,
                    required: true,
                    remote: '{{route('validateEmail')}}'
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength: 255
                },
            },
            messages: {
                username: {
                    required: "Please enter username",
                    minlength: "Username must contain at least 4 characters",
                    maxlength: "Username cannot be more than 30 characters",
                    regex: "This username are not allowed ",
                    remote: "Username already exists"
                },
                email: {
                    required: "Please enter email address",
                    email: "Please enter valid email address.",
                    remote: "Email already exists"
                },
                password: {
                    required: "Please enter password",
                    minlength: "Password must contain at least 5 characters",
                    maxlength: "Password cannot be more than 255 characters"
                },
            }
        });
    });

</script>
