@extends('layouts.admin')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                    @if ($doctors->count())
                        <table class="table">
                            <tr>
                                <th> ID </th>
                                <th> Name </th>
                                <th> Specialization </th>
                                <th> Email </th>
                                <th> Fees </th>
                                <th> Contact no. </th>
                                <th> Address </th>
                                <th> Created at </th>
                            </tr>

                        @foreach ($doctors as $doctor)

                            <tr>
                                <td> {{ $doctor->id }} </td>
                                <td> {{ $doctor->name }} </td>
                                <td> {{ $doctor->specialization }} </td>
                                <td> {{ $doctor->email }} </td>
                                <td> {{ $doctor->fees }} </td>
                                <td> {{ $doctor->contact_no }} </td>
                                <td> {{ $doctor->address }} </td>
                                <td> {{ $doctor->created_at }} </td>
                                <td> <a href="{{ route('editDoctor', $doctor->id) }}"><button type="button" class="btn btn-primary"> Edit </button> </a> </td>
                                <td> <a href="{{ route('deleteDoctor', $doctor->id) }}"><button type="button" class="btn btn-danger"> Delete </button> </a> </td>
                            </tr>
                        @endforeach
                        </table>
                    @else
                        There are no doctors!
                    @endif

                </div>
           
</div>
@endsection
