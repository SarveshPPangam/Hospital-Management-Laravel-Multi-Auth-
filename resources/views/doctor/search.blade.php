@extends('layouts.doctor')

@section('content')

    
   @isset($patients)
   <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Doctor Dashboard') }}</div>

                    <table class="table" id="spec_table">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Name </th>
                                <th> Age </th>
                                <th> Gender </th>
                                <th> Contact no. </th>
                                <th> Created at </th>
                                <th> Updated at </th>
                            </tr>
                        </thead>
                    <tbody id="table_data">
                    @if ($patients->count())

                        @foreach ($patients as $patient)

                            <tr id="sid{{ $patient->id }}">
                                <td> {{ $patient->id }} </td>
                                <td> {{ $patient->name }} </td>
                                <td> {{ $patient->age }} </td>
                                <td> {{ $patient->gender }} </td>
                                <td> {{ $patient->contact_no }} </td>
                                <td> {{ $patient->created_at }} </td>
                                <td> {{ $patient->updated_at }} </td>
                                <td> <a href="{{ route('updatePatientForm', $patient->id) }}" class="btn btn-info"> Edit  </a> </td>
                                <td> <a href="{{ route('doctor.viewPatient', $patient->id) }}" class="btn btn-info"> View  </a> </td>
                                <td> <a href="javascript:void(0)" onclick="deletePatient({{$patient->id}})" class="btn btn-danger"> Delete  </a> </td>
                            </tr>
                        @endforeach


                    @else
                        <Strong>There are no such patients!</Strong>
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>





{{-- Delete specialization script --}}
<script>
    function deletePatient(id)
    {
        if(confirm("Are you sure you want to delete the patient?"))
        {
            $.ajax({
                url: '/doctor/deletePatient/'+id,
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

   @endisset





@endsection
