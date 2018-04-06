
@extends('app')

@section('content')
    <h1>Регистрация</h1>

    @include('errors')

    <form method="POST" action='{{ url("register/") }}'>
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-default">Зарегистрироваться</button>
        </div>
    </form>
@stop