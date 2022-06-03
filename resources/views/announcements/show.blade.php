@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/announcement.css')}}">
    <script src="{{asset('js/announcementPhoto.js')}}"></script>
    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="images p-3">
                                <div class="text-center p-4">
                                    @if($announcement->cover == 'null')
                                        <img id="main-image" src="{{asset('covers/default.jpg')}}" height="250" width="250" />
                                    @else
                                        <img id="main-image" src="{{asset('covers/'.$announcement->cover)}}" height="250" width="250" />
                                    @endif
                                </div>
                                <div class="thumbnail text-center">
                                    @if($announcement->cover == 'null')
                                        <img onclick="change_image(this)" src="{{asset('covers/default.jpg')}}" height="70" width="70" />
                                    @else
                                        <img onclick="change_image(this)" src="{{asset('covers/'.$announcement->cover)}}" height="70" width="70" />
                                    @endif
                                    @foreach($images as $image)
                                        <img onclick="change_image(this)" src="{{asset('announcement_images/'.$image->image)}}" height="70" width="70">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product p-3">
                                <div class="mt-1 mb-1">
                                    <span class="text-uppercase text-muted brand">{{$announcement->brand}} {{$announcement->product}}</span>
                                    <h5 class="text-uppercase">{{$announcement->title}}</h5>
                                </div>

                                <p class="about">{{$announcement->description}}</p>
                                <div class="sizes mt-4">
                                    <header>
                                        <h6 class="text-uppercase" style="display:inline;">Size:</h6> {{$announcement->size}}
                                    </header>
                                    <header>
                                        <h6 class="text-uppercase" style="display:inline;">Price:</h6> {{$announcement->price}} €
                                    </header>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3 mt-4">
                            <div class="card" style="border: none;display: inline;">
                                <img id="avatar" style="border-radius: 50%" src="https://www.w3schools.com/howto/img_avatar.png" alt="Avatar">
                                <div id="texts" style="float:right;">
                                    <p style="margin: 0;padding: 0" class="about">&nbsp;User registered at {{ $announcement->user->created_at->format('Y').' '.$monthName}}</p>
                                    <p class="about" style="margin:0;padding:0">&nbsp;Announcements count: {{$count}}</p>
                                    <p class="about" style="margin:0;padding:0"><b>&nbsp;{{$announcement->city}}</b></p>
                                </div>
                            </div>
                            <div class="mt-2 text-start" style="width: 100%">
                                <button class="btn btn-outline-primary btn-md" disabled> <i style="font-size:12px" class="fa">&#xf095;</i> {{$announcement->user->phone_number}} </button>
                                <a href="{{ URL::previous() }}" class="btn btn-outline-primary float-md-end">Go Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        Announcement comments
    </div>
    @foreach($comments as $comment)
        @include('announcements.includes.comment')
    @endforeach

    @include('announcements.includes.createComment')

@endsection

