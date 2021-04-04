@extends('layouts.admin')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                    @if ($users->count())
                        <table class="table">
                            <tr>
                                <th> ID </th>
                                <th> Name </th>
                                <th> Email </th>
                                <th> Gender </th>
                                <th> Address </th>
                                <th> City </th>
                                <th> Created at </th>
                                <th> Updated at </th>
                                <th></th>
                            </tr>

                        @foreach ($users as $user)

                            <tr id="sid{{$user->id}}">
                                <td> {{ $user->id }} </td>
                                <td> {{ $user->name }} </td>
                                <td> {{ $user->email }} </td>
                                <td> {{ $user->gender }} </td>
                                <td> {{ $user->address }} </td>
                                <td> {{ $user->city }} </td>
                                <td> {{ $user->created_at }} </td>
                                <td> {{ $user->updated_at }} </td>
                                <td> <a href="javascript:void(0)" class="btn btn-danger" onclick="deleteUser({{ $user->id }})"> Delete </a> </td>
                            </tr>
                        @endforeach
                        </table>
                    @else
                        There are no users!
                    @endif

                </div>
            </div>
    















<script>
    function deleteUser(id)
    {
        if(confirm("Are you sure you want to delete the user?"))
        {
            $.ajax({
                url: '/admin/deleteUser/'+id,
                type: 'DELETE',
                data:{
                    _token: '{!! csrf_token() !!}',
                },
                success:function(response)
                {
                    //console.log("in success");
                    $('#sid'+id).remove();
                },
                error:function(err)
                {
                    console.log(err);
                }
            })
        }
    }
</script>
@endsection
