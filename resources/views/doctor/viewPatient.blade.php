@extends('layouts.doctor')

@section('content')
    <div class="card text-left">
        <div class="card-header">{{ __('Doctor Dashboard') }}</div>
        <div class="mx-4 mt-4">
            <h2> Patient </h2>
            <p> Name&ensp;: {{ $patient->name }} </p>
            <p> Age&ensp;: {{ $patient->age }} </p>
            <p> Gender&ensp;: {{ $patient->gender }} </p>
            <p> Contact Number&ensp;: {{ $patient->contact_no }} </p>
            <p> E-mail&ensp;: {{ $patient->email }} </p>
            <p> Address&ensp;: {{ $patient->address }} </p>
            <p> Medical history&ensp;: {{ $patient->medical_history }} </p>

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
                        @if ($medical_history->count())

                            @foreach ($medical_history as $mHistory)
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

                        @else
                            <strong> No medical history! </strong>
                        @endif
                    </tbody>
                </table>
                <button class="btn btn-info" data-toggle="modal" data-target="#addMHistoryModal"> Add medical history
                </button>

            </div>
        </div>



        <div class="modal fade" id="addMHistoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addMHistoryForm">
                            @csrf
                            <div class="form-group">
                                <label for="blood_pressure"> Blood pressure </label>
                                <input type="hidden" id="patient_id" name="patient_id" value="{{ $patient->id }}">
                                <input type="number" step="0.001" class="form-control" name="blood_pressure"
                                    id="blood_pressure" />
                                <label for="blood_sugar"> Blood sugar </label>
                                <input type="number" step="0.001" class="form-control" name="blood_sugar"
                                    id="blood_sugar" />
                                <label for="weight"> Weight </label>
                                <input type="number" step="0.001" class="form-control" name="weight" id="weight" />
                                <label for="temperature"> Temperature </label>
                                <input type="number" step="0.001" class="form-control" name="temperature"
                                    id="temperature" />
                                <label for="medical_prescription"> Medical prescription </label>
                                <input type="textarea" class="form-control" name="medical_prescription"
                                    id="medical_prescription" />
                            </div>
                            <button type="submit" class="btn btn-primary">Add medical history</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <script>
        $('#addMHistoryForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('doctor.addMedicalHistory') }}",
                type: "POST",
                data: {
                    patient_id: $("input[name=patient_id]").val(),
                    blood_pressure: $("input[name=blood_pressure]").val(),
                    blood_sugar: $("input[name=blood_sugar]").val(),
                    weight: $("input[name=weight]").val(),
                    temperature: $("input[name=temperature]").val(),
                    medical_prescription: $("input[name=medical_prescription]").val(),
                    _token: '{!!  csrf_token() !!}'
                },
                success: function(response) {
                    $('#hist_table tbody').append('<tr><td>' + response.id + '</td><td>' + response
                        .blood_pressure + '</td><td>' + response.blood_sugar + '</td><td>' +
                        response.weight + '</td><td>' + response.temperature + '</td><td>' +
                        response.medical_prescription + '</td><td>' + response.created_at.substring(
                            0, 19).replace("T", " ") + '</td></tr>');
                    $('#addMHistoryModal').modal('toggle');
                    $('#addMHistoryForm')[0].reset();
                }
            });
        })

    </script>
@endsection
