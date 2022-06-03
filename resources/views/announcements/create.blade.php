@extends('layouts.app')

@section('content')
    <form action="/announcements" class="announcement" method="POST" enctype="multipart/form-data">
        @csrf
        @include('announcements.includes.form',['create'=>true])
        <input hidden name="announcement_id" value="{{$announcement_id}}">
        <button id="submit-all" style="position:fixed; left: 80%;top: 90%" class="justify-content-md-end btn-bg btn btn-primary"> Create</button>
    </form>
    <div class="container col-md-4" id="upload" style="position: fixed;top: 65px; right: 65%">
        <div class="row justify-content-center">
            <div class="">
                <div class="card-header">
                    {{ __('Upload up to two pictures of your selling item') }}
                </div>
                @include('dropzone',['create'=>true])
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

            $("#createAnnouncement").validate({
                rules: {
                    city: {
                        required: true,
                        minlength: 4,
                        maxlength: 30,
                        regex: /^[^\s]+(\s+[^\s]+)*$/
                    }
                },
                messages: {
                    city: {
                        required: "A",
                        minlength: "Username must contain at least 4 characters",
                        maxlength: "Username cannot be more than 30 characters",
                        regex: "This username is not allowed ",

                    },
                }
            });
        });
    </script>

@endsection
