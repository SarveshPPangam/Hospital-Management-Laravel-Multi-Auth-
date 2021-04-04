@extends('layouts.admin')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                    @if ($patients->count())
                        <table class="table">
                            <tr>
                                <th> ID </th>
                                <th> Name </th>
                                <th> Age </th>
                                <th> Gender </th>
                                <th> Contact no. </th>
                                <th> Email </th>
                                <th> Address </th>
                                <th> Doctor name </th>
                                <th> Medical history </th>
                                <th> Created at </th>
                                <th> Updated at </th>
                                <th></th>
                            </tr>

                        @foreach ($patients as $patient)

                            <tr id="sid{{$patient->id}}">
                                <td> {{ $patient->id }} </td>
                                <td> {{ $patient->name }} </td>
                                <td> {{ $patient->age }} </td>
                                <td> {{ $patient->gender }} </td>
                                <td> {{ $patient->contact_no }} </td>
                                <td> {{ $patient->email }} </td>
                                <td> {{ $patient->address }} </td>
                                <td> {{ $patient->doctor_name  }} </td>
                                <td> {{ $patient->medical_history  }} </td>
                                <td> {{ $patient->created_at }} </td>
                                <td> {{ $patient->updated_at }} </td>
                                <td> <a href="{{ route('admin.viewPatient', $patient->id) }}" class="btn btn-info"> View  </a> </td>
                                {{-- <td> <a href="javascript:void(0)" class="btn btn-danger" onclick="deletepatient({{ $user->id }})"> Delete </a> </td> --}}
                            </tr>
                        @endforeach
                        </table>
                    @else
                        There are no patients!
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
