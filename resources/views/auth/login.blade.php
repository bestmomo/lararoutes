@extends('layouts.app')

@section('content')
<div class="container">

    <main class="row">

        <div class="col s12 m10 offset-m1 l8 offset-l2">
            <div class="card">
            <form  method="POST" action="{{ route('login') }}">
                <div class="card-content">
                    @csrf
                    <span class="card-title">{{ __('Login') }}</span>

                    <hr>

                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">mail</i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="{{ $errors->has('email') ? 'invalid' : '' }}" required autofocus>
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

                    <p>
                        <label>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>{{ __('Remember Me') }}</span>
                        </label>
                    </p>

                    <p>
                        <button class="btn waves-effect waves-light right" type="submit" name="action">{{ __('Login') }}
                            <i class="material-icons right">lock_open</i>
                        </button>
                    </p>

                    <br>

                </div>
                <div class="card-action">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    @endif
                </div>
            </form>
        </div>
    </main>

</div>
@endsection
