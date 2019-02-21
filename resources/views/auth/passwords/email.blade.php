@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="card">
            <div class="card green darken-1">
                <div class="card-content white-text">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col s12 m10 offset-m1 l8 offset-l2">
            <div class="card">

            <form  method="POST" action="{{ route('password.email') }}">
                <div class="card-content">
                    @csrf
                    <span class="card-title">{{ __('Reset Password') }}</span>

                    <hr>

                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">mail</i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="{{ $errors->has('email') ? 'invalid' : '' }}" required autofocus>
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <span class="red-text">{{ $errors->has('email') ? $errors->first('email'): '' }}</span>
                        </div>
                    </div>

                    <p>
                        <button class="btn waves-effect waves-light right" type="submit" name="action">{{ __('Send Password Reset Link') }}
                            <i class="material-icons right">lock_open</i>
                        </button>
                    </p>

                    <br><br>

                </div>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
