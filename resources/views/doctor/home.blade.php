@extends('layouts.doctor')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('Doctor Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <strong> Password updated! </strong>
                    </div>
                    @endif
                    Hello! Doctor {{ Auth::user()->name }}
                </div>
            </div>
        
@endsection
