@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>
                <div class="card-header">{{ __('Update password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updatePassword') }}">
                        @csrf
                        @if(session('current_password'))
                    <strong> Incorrect current password </strong>
                @endif
                        @if(session('mismatch'))
                            <strong>  New password and confirmed password do not match!    </strong>
                        @endif
                    <input type="hidden" name="id" id="id" value="{{ Auth::id() }}">

                    <div class="form-group row">
                        <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('Current password') }}</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="current_password" required >

                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required >

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required ">
                        </div>
                    </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
        </div>
            </div>
       
@endsection
