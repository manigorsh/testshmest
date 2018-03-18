<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <meta name="og:title" content="Lucky Partners: Игры с реальным соперником на крупные ставки!"/>
    <meta name="og:url" content="http://partners.fnvst.com/"/>
    <meta name="og:image" content="http://partners.fnvst.com/knb.jpg"/>
    <meta name="og:description" content="Честные игры, прибыльная партнерка, быстрый вывод средств!"/>
</head>
<body>
  <style>
    .blink {
      animation: blink-animation 2s steps(5, start) infinite;
      -webkit-animation: blink-animation 2s steps(5, start) infinite;
    }
    @keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }
    @-webkit-keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }
  </style>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/lplogo.png" alt="{{ config('app.name', 'Laravel') }}">
                </a>
                <a href="{{ url('/bonus') }}" class="nav-link"><img class="blink" src="/bonus.png" style="height: 50px;position: absolute;left: 53%;top: 3%;"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('auth.RULES') }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('/public-offer') }}">{{ __('common.PUBLIC_OFFER') }}</a>
                                    <a class="dropdown-item" href="{{ url('/project-rules') }}">{{ __('common.PROJECT_RULES') }}</a>
                                    <a class="dropdown-item" href="{{ url('/game-rules') }}">{{ __('common.GAME_RULES') }}</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('auth.GAMES') }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('knbgames.index') }}">{{ __('knbgames.ROCK_SCISSORS_AND_PAPER') }}</a>
                                </div>
                            </li>
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('auth.LOGIN') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('auth.REGISTER') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('auth.BALANCE') }}: {{ Auth::user()->balance }} {{ __('auth.RUB') }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('paygate.freekassa.create') }}">{{ __('paygate.PAY') }}</a>
                                    <a class="dropdown-item" href="{{ route('paygate.payout.create') }}">{{ __('paygate.PAYOUT') }}</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('partners.index') }}">
                                        {{ __('auth.PARTNERS') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('auth.LOGOUT') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
      @if (Session::has('success'))
         <div class="alert alert-success">{{ Session::get('success') }}</div>
      @endif
      @if (Session::has('fail'))
         <div class="alert alert-warning">{{ Session::get('fail') }}</div>
      @endif
        <main class="py-4">
            @yield('content')
            <div class="container text-center">
                <a href="//www.free-kassa.ru/"><img src="//www.free-kassa.ru/img/fk_btn/13.png"></a>
                <a href="mailto:support@fnvst.com">Техподдержка support@fnvst.com</a>
            </div>
        </main>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ __('knbgames.MD5_CONTROL') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="md5-hash" class="col-form-label">MD5-Hash</label>
                <input type="text" class="form-control" id="md5-hash" readonly>
              </div>
              <div class="form-group">
                <label for="md5-text" class="col-form-label">MD5-Text</label>
                <textarea class="form-control" id="md5-text" readonly></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
      $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var md5_text = button.data('md5-text');
      var md5_hash = button.data('md5-hash');
      var modal = $(this)
      modal.find('#md5-hash').val(md5_hash);
      modal.find('#md5-text').text(md5_text);
    })
    </script>
</body>
</html>
