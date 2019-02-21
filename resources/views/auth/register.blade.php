@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col s12 m10 offset-m1 l8 offset-l2">
            <div class="card">
            <form  method="POST" action="{{ route('register') }}">
                <div class="card-content">
                    @csrf
                    <span class="card-title">{{ __('Register') }}</span>

                    <hr>

                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">person</i>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" class="{{ $errors->has('name') ? 'invalid' : '' }}" required autofocus>
                            <label for="email">{{ __('Name') }}</label>
                            <span class="red-text">{{ $errors->has('name') ? $errors->first('name'): '' }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">mail</i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="{{ $errors->has('email') ? 'invalid' : '' }}" required>
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <span class="red-text">{{ $errors->has('email') ? $errors->first('email'): '' }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input id="password" type="password" name="password" class="{{ $errors->has('password') ? 'invalid' : '' }}" required>
                            <label for="password">{{ __('Password') }}</label>
                            <span class="red-text">{{ $errors->has('password') ? $errors->first('password'): '' }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input id="password-confirm" type="password" name="password_confirmation" required>
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        </div>
                    </div>

                    <p>
                        <label>
                            <input type="checkbox" name="ok" id="ok" required>
                            <span>{{ __('I accept the terms and conditions of the privacy policy') }}</span>
                        </label>
                    </p>

                    <br>

                    <p>
                        <button class="btn waves-effect waves-light" type="submit" name="action">{{ __('Register') }}
                            <i class="material-icons right">create</i>
                        </button>
                    </p>

                </div>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
