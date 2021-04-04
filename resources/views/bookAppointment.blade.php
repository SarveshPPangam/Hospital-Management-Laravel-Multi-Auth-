@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>
                <div class="card-header">{{ __('Book appointment') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('bookAppointment') }}" id="appointmentForm">
                        @csrf
                        <div class="form-group row">
                            <label for="specialization" class="col-md-4 col-form-label text-md-right">{{ __('Specialization') }}</label>

                            <div class="col-md-6 my-auto">
                                <select name="specialization" id="specialization" placeholder="Select specialization" autocomplete="off">
                                    <option value="0x" selected> Select specialization </option>
                                    @foreach(App\Models\Specialization::get() as $specialization)
                                            <option value="{{ $specialization->name }}">{{ $specialization->name }} </option>
                                    @endforeach
                                </select>
                                @error('specialization')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="doctor" class="col-md-4 col-form-label text-md-right">{{ __('Doctor') }}</label>

                            <div class="col-md-6 my-auto">
                                <select name="doctor" id="doctor">
                                    <option value="0x" selected> Please Select Specialization  </option>

                                </select>
                                @error('doctor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fees" class="col-md-4 col-form-label text-md-right">{{ __('Fees') }}</label>

                            <div class="col-md-6">
                                <input id="fees" type="text" class="form-control @error('fees') is-invalid @enderror" name="fees" autocomplete="off" readonly required>

                                @error('fees')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" autocomplete="off" required >

                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="time" class="col-md-4 col-form-label text-md-right">{{ __('Time') }}</label>

                            <div class="col-md-6">
                                <input id="time" type="time" class="form-control @error('time') is-invalid @enderror" name="time" autocomplete="off" required>

                                @error('time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Book appointment') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
        </div>
            </div>





<script>
    $(document).ready(function () {
        $('#specialization').on('change', function () {
            let id = $(this).val();
            $('#doctor').empty();
            $('#doctor').append('<option value="0" disabled selected>Processing...</option>');
            $.ajax({
                type: 'GET',
                url: '/doctorsRequest/' + id,
                success: function (response) {
                    $('#doctor').empty();
                    $('#doctor').append(`<option value="0" disabled selected>Select doctor</option>`);
                    response.forEach(element => {
                        $('#doctor').append(`<option value="${element['id']}">${element['name']}</option>`);
                    });
                }
            });
        });

        $('#doctor').on('change', function () {
            let id = $(this).val();
            $('#fees').empty();
            $('#fees').append('<option value="0" disabled selected>Processing...</option>');
            $.ajax({
                type: 'GET',
                url: '/feesRequest/' + id,
                success: function (response) {
                    $('#fees').empty();
                    $('#fees').val(response);
                }
            });
        });
    });
</script>
@endsection
