<link rel="stylesheet" href="{{asset('css/comment.css')}}">
<div class="container mt-1">
    <div class="d-flex justify-content-center row">
        <div class="col-md-8">
            <div class="d-flex flex-column comment-section">
                <div class="bg-light p-2">
                    <form class="comment" action="{{route('createComment')}}" method="POST">
                        @csrf
                        <div class="d-flex flex-row align-items-start">
                            <img class="rounded-circle" src="https://www.w3schools.com/howto/img_avatar.png" width="40">
                            <textarea name="comment" class="form-control ml-1 shadow-none textarea"></textarea>
                        </div>
                        <div class="mt-2 text-right">
                            <button class="float-end btn btn-primary btn-sm shadow-none" type="submit">Post comment</button>
                        </div>
                        <input type="hidden" name="announcement_id" value="{{$announcement->id}}">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (){
        $(".comment").validate({
            rules: {
                comment: {
                    required: true,
                },
            },
            messages: {
                comment: {
                    required: "Please enter title field",
                },
            }
        });
    });
</script>
