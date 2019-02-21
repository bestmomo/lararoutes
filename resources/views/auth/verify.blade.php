@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    @if (session('resent'))
        <div class="card green darken-1">
            <div class="card-content white-text">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-content">
            <div class="card-title">{{ __('Verify Your Email Address') }}</div>
            <hr>
            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
        </div>
      </div>
    </div>
</div>
@endsection
