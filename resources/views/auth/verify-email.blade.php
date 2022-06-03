@extends('layouts.app')

@section('content')
    <h1> Verify your e-mail address</h1>
    <p> you have to verifye email to acces this page</p>

    <form method="POST" action="{{route('verification.send')}}">
        @csrf
        <button type="submit">Resend verification email</button>
    </form>

@endsection

