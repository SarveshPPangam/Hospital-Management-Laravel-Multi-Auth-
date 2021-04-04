@extends('layouts.app')

@section('content')

            <div class="card text-left">
                <div class="card-header">{{ __('User Dashboard') }}</div>
                @if(isset($patient))
                <div class="mx-4 mt-4"><h2> Patient </h2>
                   <p> Name&ensp;: {{ $patient->name}} </p>
                   <p>  Age&ensp;: {{ $patient->age}} </p>
                   <p>  Gender&ensp;: {{ $patient->gender}} </p>
                   <p>  Contact Number&ensp;: {{ $patient->contact_no}} </p>
                   <p>  E-mail&ensp;: {{ $patient->email}} </p>
                   <p>  Address&ensp;: {{ $patient->address}} </p>
                   <p>  Medical history&ensp;: {{ $patient->medical_history}} </p>

                <div class="text-center">
                <table class="table" id="hist_table">
                    <thead>
                        <tr>
                            <th> ID </th>
                            <th> Blood pressure </th>
                            <th> Blood sugar </th>
                            <th> Weight </th>
                            <th> Temperature </th>
                            <th> Medical prescription </th>
                            <th> Created at </th>
                        </tr>
                    </thead>
                    <tbody id="table_data">
                @isset($medical_history)
                @if($medical_history->count())

                        @foreach($medical_history as $mHistory)
                            <tr id="sid{{ $mHistory->id }}">
                                <td> {{ $mHistory->id }} </td>
                                <td> {{ $mHistory->blood_pressure }} </td>
                                <td> {{ $mHistory->blood_sugar }} </td>
                                <td> {{ $mHistory->weight }} </td>
                                <td> {{ $mHistory->temperature }} </td>
                                <td> {{ $mHistory->medical_prescription }} </td>
                                <td> {{ $mHistory->created_at }} </td>
                            </tr>
                        @endforeach
                @endisset
                @else
                    <strong> No medical history! </strong>
                @endif
                @else
                       <strong> No medical history! </strong>
                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



@endsection
