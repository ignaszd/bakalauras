@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Users</h1>
            <div class="row">
                @include('admin.users.includes.search')
                <form action="users/create">
                <button class="btn btn-primary mt-2 mb-2">Create user</button> <br><br>
                </form>
                <div id="user_data" class="col-xl-8">
                    @include('admin.users.includes.users_data')
                </div>

                <div id="info" class="col-xl-4">
                    @if($a == 1)
                        @include('admin.users.edit')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                getMoreUsers(page);
            });
            $('#search').on('keyup', function() {
                $value = $(this).val();
                getMoreUsers(1);
            })
            $('.id').click(function(){
                {{$a = $a + 1}};
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
                document.getElementById('info').style.display = "block";
            });
        });
        function getMoreUsers(page) {
            var search = $('#search').val();
            $.ajax({
                type: "GET",
                data: {
                    'search_query':search
                },
                url: "{{route('admin.getMoreUsers')}}" + "?page=" + page,
                success:function(data) {
                    $('#user_data').html(data);
                }
            });
        }
    </script>
@endpush
