@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/announcements.css') }}">
    <div class="container">
        <div id="announcement_data">
            <div class="row" style="width: 94%;margin-left: 0">
                @include('layouts.success')
            </div>
            <a href="{{route('announcements.create')}}" class="btn btn-success mb-2"> Create announcement</a>

            @foreach($announcements as $announcement)
                <div class="row p-2 bg-white border rounded" style="width: 94%;margin-left: 0">
                    <div class="col-md-3 mt-1">
                        <a href="announcements/{{$announcement->id}}">
                            <img class="img-fluid img-responsive rounded product-image"
                                 @if($announcement->cover == 'null')
                                 src="{{asset('covers/default.jpg')}}">
                            @else
                                src="{{asset('covers/'.$announcement->cover)}}">
                            @endif
                        </a>
                    </div>
                    <div class="col-md-6 mt-1">
                        <h5><a href="announcements/{{$announcement->id}}">{{$announcement->title}}</a></h5>
                        <div class="d-flex flex-row">
                            <span>{{$announcement->city}}</span>
                        </div>
                        <div class="mt-1 mb-1 spec-1">
                            <span>{{$announcement->brand}}</span>
                            <span class="dot"></span><span>{{$announcement->product}}</span>
                            <span class="dot"></span><span>{{$announcement->size}}<br></span>
                        </div>

                        <p class="text-justify para mb-0"> {{strlen($announcement->description) > 175 ? substr($announcement->description,0,175).'...': $announcement->description}}</p>

                    </div>
                    <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                        <div class="d-flex flex-row align-items-center">
                            <h4 class="mr-1">{{$announcement->price}}€</h4>
                        </div>
                        <div class="d-flex flex-column mt-4">
                            <a class="btn btn-primary btn-sm" type="button" href="{{route('announcements.show',[$announcement->id])}}">Show announcement</a>
                            <a class="btn btn-outline-primary btn-sm mt-2" type="button" href="{{route('announcements.edit',[$announcement->id])}}">Edit</a>
                            <div class="btn-group" role="group">
                                <form method="POST" action="{{route('announcements.destroy',[$announcement->id])}}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-primary btn-sm mt-2" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
