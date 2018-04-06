<html>
<head>
    <meta charset="UTF-8">
    <title>E-mail активация</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
</head>
<body>
<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navabar-header">
                <a href="#" class="navbar-brend">Antirabstvo</a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{ url('/register') }}">Регистрация</a>
                    </li>
                    @if(Auth::check())
                        <li><a href="{{ url('/user/edit', Auth::user()->id) }}">Редактировать профиль</a></li>
                        <li><a href="{{ url('/logout') }}">Выход</a></li>
                        @else
                    <li>
                        <a href="{{ url('/login') }}">Войти</a>
                    </li>
                        @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container">
    @include('flash')

    @yield('content')
</div>
<script src="/js/app.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
<script>
    jQuery(function ($) {
        $('#phone').mask('+9(999)9999999');
    })
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@yield('script')
</body>
</html>