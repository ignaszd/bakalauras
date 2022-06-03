@extends('layouts.app')

@section('content')



    <form action="/announcements/{{$announcement->id}}" class="announcement" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('announcements.includes.form',['edit'=>true])
    </form>
    <div class="container col-md-5" id="upload" style="position: fixed;top: 530px;">
        <div class="row justify-content-start">
            <div style="width: 88%">
                <div class="card-header">
                    {{ __('Upload announcemnet photos') }}
                </div>
                @include('dropzone',['edit'=>true])
            </div>
        </div>
    </div>


    <script>


        $('button').click(function (e){
            $('option').removeAttr('disabled');
        })
    </script>

@endsection
