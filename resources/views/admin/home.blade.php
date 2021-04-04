@extends('layouts.admin')

@section('content')



            <div class="card">
                <div class="card-header text-center mb-2">{{ __('Admin Dashboard') }}</div>

                {{-- <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }} --}}

                @if(session('success'))
                            <strong> Your password has been updated </strong>
                        @endif
                    <p class="m-3"> Total doctors: {{ App\Http\Controllers\AdminController::getStats()['total_doctors'] }} </p>
                    <p class="m-3"> Total users: {{ App\Http\Controllers\AdminController::getStats()['total_users'] }} </p>
                    <p class="m-3"> Total patients: {{ App\Http\Controllers\AdminController::getStats()['total_patients'] }} </p>

                </div>
            </div>



@endsection
