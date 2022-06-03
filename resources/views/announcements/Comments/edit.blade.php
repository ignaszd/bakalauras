@extends('layouts.app')

@section('content')
    <form action="/announcement/comment/store/{{$comment->id}}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{$comment->announcement_id}}" name="announcement_id">
        <label for="title">Your comment:</label>
        <input type="text" value="{{$comment->comment}}" class="form-control" id="title" name="comment" placeholder="Insert comment"/>

        <button type="submit" class="btn btn-primary btn-lg">Edit</button>

    </form>
@endsection
