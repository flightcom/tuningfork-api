@extends('layouts.bare')

@section('content')
    <div class="container login-page">
        <div class="login-form-container">
            <div class="login-logo text-center"><h1>Admin</h1></div>
            <div class="login-box">
                <p class="text-center">Sign in to start your session</p>

                {!! Form::open(array(
                    'url' => route('admin.login.request'),
                    'method' => 'POST',
                )) !!}
                {{ csrf_field() }}

                <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::email('email', old('email'), array(
                        'name' => 'email',
                        'class' => 'form-control form-group',
                        'placeholder' => 'Email'
                    )) !!}

                    @if ($errors->has('email'))
                        <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                    @endif
                </div>

                <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::password('password', array(
                        'class' => 'form-control form-group',
                        'placeholder' => 'Password'
                    )) !!}

                    @if ($errors->has('password'))
                        <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                    @endif
                </div>

                <div class="remember">
                    <label>
                        {!! Form::checkbox('remember') !!} Remember Me
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-flat text-center">
                    Login
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
