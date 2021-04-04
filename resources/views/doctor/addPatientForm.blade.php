@extends('layouts.doctor')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('Doctor Dashboard') }}</div>
                <div class="card-header">{{ __('Add patient') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('addPatientSubmit') }}">
                        @csrf
                        <input type = "hidden" name="doctor_id" value="{{Auth::user()->id}}">
                        <input type = "hidden" name="doctor_name" value="{{Auth::user()->name}}">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Age') }}</label>

                            <div class="col-md-6">
                                <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autocomplete="age" autofocus>

                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3"><input type="radio" id="male" name="gender" value="male" >
                                <label for="male" class="col-form-label">Male</label></div>
                            <div class="col-md-3"><input type="radio" id="female" name="gender" value="female">
                                <label for="female" class="col-form-label">Female</label></div>
                            <div class="col-md-3"><input type="radio" id="other" name="gender" value="other">
                                <label for="other" class="col-form-label">Other</label></div>
                            
                            
                            
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact_no" class="col-md-4 col-form-label text-md-right">{{ __('Contact no.') }}</label>

                            <div class="col-md-6">
                                <input id="contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no') }}" required autocomplete="contact_no" autofocus>

                                @error('contact_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="textarea" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="medical_history" class="col-md-4 col-form-label text-md-right">{{ __('Medical history') }}</label>

                            <div class="col-md-6">
                                <input id="medical_history" type="textarea" class="form-control @error('medical_history') is-invalid @enderror" name="medical_history" value="{{ old('medical_history') }}" required autocomplete="medical_history" autofocus>

                                @error('medical_history')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add patient') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
        </div>
            </div>
        
@endsection
