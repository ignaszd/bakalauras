<form method="POST" id="adminEdit" action="{{ route('admin.users.update', $user->id) }}">
    @method('PATCH')
    @csrf
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{$user->username}}</h5>
        </div>
        <div class="card-body">
            <div class="row g-0">
                <div class="col-sm-3 col-xl-12 col-xxl-3 text-center">
                    <img src="https://www.w3schools.com/howto/img_avatar.png" width="64" height="64" class="rounded-circle mt-2" alt="Angelica Ramos">
                </div>
                <div class="col-sm-9 col-xl-12 col-xxl-9">
                    <strong>About me</strong>
                    <p>
                        Registration date: {{$user->created_at}} <br>

                        @if($user->email_verified_at == null)
                            My email isn't verified
                        @else
                            My email is verified
                        @endif
                    </p>
                </div>
            </div>

            <table class="table table-sm mt-2 mb-4">
                <tbody>
                <tr>
                    <th>Username</th>
                    <td>
                        <input disabled id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                               value="{{old('username')}}@isset($user){{$user->username}}@endisset" required autocomplete="username" autofocus>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th>Last name</th>
                    <td>
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                               value="{{old('first_name')}}@isset($user){{$user->first_name}}@endisset" required autocomplete="first_name" autofocus>

                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th>Last name</th>
                    <td>
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                               value="{{old('last_name')}}@isset($user){{$user->last_name}}@endisset" required autocomplete="last_name" autofocus>

                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>
                        <input disabled id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                               value="{{ old('email') }} @isset($user) {{$user->email}} @endisset" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th>Phone number</th>
                    <td>
                        <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                               value="{{old('phone_number')}}@isset($user){{$user->phone_number}}@endisset" required autocomplete="phone_number">

                        @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th>Roles</th>
                    <td>
                        @foreach($roles as $role)
                            <div class="form-check">
                                <label class="form-check-label" for="{{$role->name}}">
                                    {{$role->name}}
                                </label>
                                <input class="form-check-input" name="roles[]" type="checkbox"
                                       value="{{$role->id}}" id="{{$role->name}}"
                                       @isset($user) @if(in_array($role->id, $user->roles->pluck('id')->toArray())) checked @endif @endisset
                                       @if($role->name == 'user') disabled checked @endif
                                >
                            </div>
                        @endforeach
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="text-center">
            <button type="submit" class="btn btn-primary">
                Update
            </button></div>

        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            },
        );

        $("#adminEdit").validate({
            rules: {
                first_name: {
                    required: false,
                    maxlength: 30,
                    regex: /^[^\s]+(\s+[^\s]+)*$/
                },
                last_name: {
                    required: false,
                    maxlength: 30,
                    regex: /^[^\s]+(\s+[^\s]+)*$/
                },
                phone_number: {
                    required: false,
                    maxlength: 15,
                    regex: /^[+0-9]*$/
                }
            },
            messages: {
                first_name: {
                    maxlength: "First name cannot be more than 30 characters",
                    regex: "No whitespaces allowed at the end or start of first name"
                },
                last_name: {
                    maxlength: "Last name cannot be more than 30 characters",
                    regex: "No whitespaces allowed at the end or start of last name"
                },
                phone_number: {
                    required: "Please enter your phone number",
                    maxlength: "Phone number cannot be more than 15 characters",
                    regex: "Number cannot have any special chars or whitespaces"
                }
            }
        });
    });
</script>
