@extends('layouts.admin')

@section('content')

    
   @isset($patients)
   
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

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
                                <td> <a href="{{ route('admin.viewPatient', $patient->id) }}" class="btn btn-info"> View  </a> </td>
                            </tr>
                        @endforeach


                    @else
                        <Strong class="text-center">There are no such patients!</Strong>
                    @endif
                    </tbody>
                </table>
                </div>
            </div>






   @endisset





@endsection
