
@extends('app')

@section('content')
    <h1>Авторизация</h1>

    @include('errors')

    <form method="POST" action='{{ url("login/") }}'>
        {{csrf_field()}}

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? ' checked' : '' }}> Запомнить меня
            </label>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-default">Войти</button>
        </div>
    </form>
@stop