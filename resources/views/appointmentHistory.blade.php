@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                    @if ($appointments->count())
                        <table class="table">
                            <tr>
                                <th> ID </th>
                                <th> Specialization </th>
                                <th> Doctor name </th>
                                <th> Fees </th>
                                <th> Appointment date </th>
                                <th> Appointment time </th>
                                <th> Booked at </th>
                                <th> Current status </th>
                            </tr>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td> {{ $appointment->id }} </td>
                                <td> {{ $appointment->specialization }} </td>
                                <td> {{ App\Models\Doctor::find($appointment->doctor_id)->name }} </td>
                                <td> {{ $appointment->fees }} </td>
                                <td> {{ $appointment->appointment_date }} </td>
                                <td> {{ $appointment->appointment_time }} </td>
                                <td> {{ $appointment->created_at }} </td>

                                @if($appointment->doctor_status && $appointment->user_status)
                                @if(Carbon\Carbon::now() > date('Y-m-d H:i:s', strtotime("$appointment->appointment_date $appointment->appointment_time")))
                                <td><strong> Appointment over or expired </strong></td>
                                    @else
                                        <td> <strong id="uid{{$appointment->id}}"> Active </strong></td>
                                        <td id="cancelButton{{$appointment->id}}"> <a href="javascript:void(0)"><button type="button" class="btn btn-danger" onclick="cancelAppointment({{$appointment->id }})"> Cancel </button> </a> </td>
                                    @endif
                                @elseif( !$appointment->user_status)
                                     <td><strong> Cancelled by you </strong></td>
                                @elseif( !$appointment->doctor_status)
                                    <td><strong> Cancelled by doctor </strong></td>
                                @endif

                            </tr>
                        @endforeach
                        </table>
                    @else
                    <div class="m-2">There are no appointments!
                    </div>
                    @endif

                </div>
            </div>







<script>
    function cancelAppointment(id)
    {
        if(confirm("Are you sure you want to cancel the appointment?"))
        {
            $.ajax({
                url:"{{ route('cancelAppointment') }}",
                type:"PUT",
                data:{
                    id:id,
                    _token: '{!! csrf_token() !!}',
                },
                success:function(response){
                    $('#uid'+ id).text("Cancelled by you");
                    $('#cancelButton'+id).remove();
                }
            });
        }
    }
</script>
@endsection
