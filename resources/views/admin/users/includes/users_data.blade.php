
<div class="card">
    <div class="card-header pb-0">
        <h5 class="card-title mb-0">Users list</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped" style="width:100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            @foreach($users as $user)
                <tbody>
                <tr>
                    <td><img src="https://www.w3schools.com/howto/img_avatar.png" width="32" height="32" class="rounded-circle my-n1" alt="Avatar"></td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->first_name.' '.$user->last_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="id btn btn-primary btn-sm" value="{{$user->id}}"> Edit </button>
                        <form method="POST" action="users/{{$user->id}}">
                            {{--        <form method="POST" action="{{route('users.destroy', $user->id)}}">  --}}
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm"> Delete </button>
                        </form>
                        </div>
                    </td>
                </tr>
                </tbody>
            @endforeach
            </table>
        </div>
    </div>
<div>
    {!! $users->links() !!}
</div>
<script>
    $(document).ready(function(){
        $('.id').click(function() {
            var id = $(this).attr("value");
            $.ajax({
                type: "GET",
                data: {
                    'id': id,
                },
                cache: true,
                url: "/admin/users/"+id+"/edit",
                success:function (data){
                    $('#info').html(data);
                }
            })
        });
    });
</script>
