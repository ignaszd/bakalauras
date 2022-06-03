<link rel="stylesheet" href="{{asset('css/comment.css')}}">
<div class="container mt-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-8">
            <div class="d-flex flex-column comment-section">
                <div class="bg-white p-2">
                    <div class="d-flex flex-row user-info">
                        <img class="rounded-circle" src="https://www.w3schools.com/howto/img_avatar.png" width="40">
                        <div class="d-flex flex-column w-100 justify-content-start padding">
                            <span class="d-block font-weight-bold name">{{$comment->user->username}}</span>
                            <span class="date text-black-50">Shared publicly {{$comment->created_at->format('Y-m-d')}}</span>
                        </div>

                        @if(Auth::user()->id == $comment->user_id)
                            <a class=" btn btn-sm" href="/announcement/comment/edit/{{$comment->id}}">Edit</a>
                            <form method="POST" action="/announcement/comment/delete/{{$comment->id}}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm " type="submit">Delete</button>
                            </form>
                        @endif
                    </div>
                    <div class="mt-2">
                        <p class="comment-text">{{$comment->comment}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
