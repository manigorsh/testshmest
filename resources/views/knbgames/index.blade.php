@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
        <div class="col-md-7">
            <div class="card card-default">
                <div class="card-header">{{ __('knbgames.ROCK_SCISSORS_AND_PAPER') }}</div>
                <div class="card-body">
                <a class="btn btn-primary fa" href="{{ route('knbgames.create') }}" role="button">{{ __('knbgames.CREATE_NEW_GAME') }}</a>    
		                <table class="table table-hover">
                      <thead>
                        <tr>
                          <!--<th scope="col">#</th>-->
                          <th scope="col">{{ __('knbgames.GAMER') }}</th>
                          <th scope="col">{{ __('knbgames.BET') }}</th>
                          <th scope="col">{{ __('knbgames.YOUR_HAND') }}</th>
                          <th scope="col">{{ __('knbgames.MD5') }}</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($games as $game)
                          <tr>
                              <!--<th scope="row">{{ $game->id }}</th>-->
                              <td>{{ $game->creator->name }}</td>
			                        <td>{{ $game->bet }} {{ __('auth.RUB') }}</td>
                              <td>
                                <form method="POST" action="{{ route('knbgames.play') }}" id="game_form_{{ $game->id }}">
                                  @csrf
                                  <input type="hidden" name="game_id" value="{{ $game->id }}"/>
                                  <!--
                                  <select name="opponent_hand">
                                      <option value="rock">{{ __('knbgames.ROCK') }}</option>
                                      <option value="scissors">{{ __('knbgames.SCISSORS') }}</option>
                                      <option value="paper">{{ __('knbgames.PAPER') }}</option>
                                  </select>
                                  -->
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="opponent_hand" id="opponent_hand_rock_{{ $game->id }}" value="rock" checked>
                                    <label class="form-check-label far fa-hand-rock fa-2x" for="opponent_hand_rock_{{ $game->id }}"></label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="opponent_hand" id="opponent_hand_scissors_{{ $game->id }}" value="scissors">
                                    <label class="form-check-label far fa-hand-scissors fa-2x" for="opponent_hand_scissors_{{ $game->id }}"></label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="opponent_hand" id="opponent_hand_paper_{{ $game->id }}" value="paper">
                                    <label class="form-check-label far fa-hand-paper fa-2x" for="opponent_hand_paper_{{ $game->id }}"></label>
                                  </div>
                                </form>
                              </td>
                              <td>
                                <button type="button" class="btn btn-success fas fa-shield-alt" data-toggle="modal" data-target="#exampleModal" 
                                data-md5-hash="{{ $game->md5_hash }}"
                                data-md5-text="{{ __('knbgames.AVAILABLE_AFTER_GAME_PLAYED')}}"></button>
                              </td>
                              <td>
                                <a class="btn btn-primary fa" href="#" onclick="document.getElementById('game_form_{{ $game->id }}').submit(); return false;" role="button">{{ __('knbgames.PLAY') }}</a>
                                
                                @auth
                                  @if (Auth::user()->id == $game->creator->id)
                                    <form id="cancel_game_form_{{ $game->id }}" action="{{ route('knbgames.cancel') }}" method="POST" style="display: none;">
                                        <input type="hidden" name="game_id" value="{{ $game->id }}"/>
                                        @csrf
                                    </form>
                                    <a class="btn btn-danger fa" href="#" onclick="document.getElementById('cancel_game_form_{{ $game->id }}').submit(); return false;" role="button">{{ __('knbgames.CANCEL') }}</a>
                                  @endif
                                @endauth
                              </td>

                            </tr>
                          @endforeach
                      </tbody>
                    </table>
                    <?php /*{{ $games->links() }} */?>
                    <a class="btn btn-primary fa" href="{{ route('knbgames.create') }}" role="button">{{ __('knbgames.CREATE_NEW_GAME') }}</a>
                </div>
                <div class="card-body">
                  <a href="{{ route('knbgames.statistics') }}" class="card-link">{{ __('knbgames.STATISTICS_OF_THE_GAMES') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
          <div class="card card-default">
            <div class="card-header">Недавние Игры</div>
            <div class="card-body">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Игрок</th>
                    <th scope="col">Ставка</th>
                    <th scope="col">Предмет</th>
                    <th scope="col">Итог</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($last_games as $last_game)
                    <tr>
                      <td>{{ $last_game->creator->name }}</td>
                      <td>{{ $last_game->bet }} {{ __('auth.RUB') }}</td>
                      <td>
                        <div class="form-check form-check-inline">
                          <input type="radio" value="{{ $last_game->creator_hand }}" class="form-check-input">
                          <label class="form-check-label far fa-hand-{{ $last_game->creator_hand }} fa-2x"></label>
                        </div>
                      </td>
                      <td>{{ $last_game->result }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="card card-default" style="margin-top: 20px;">
            <div class="card-header">Чат Онлайн</div>
            <div class="card-body">
              <div id="chat"></div>
              <script type="text/javascript">
                window.onload=function () {
                 refreshChat();
		 setInterval(() => { refreshChat() }, 5000);
                }
                function sendChatMessage(message) {
                    return fetch('{{ route('chat.store') }}', {
                        method: 'post',
                        credentials: "same-origin",
                        headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({message: message})
                    })
                    .then((res) => {
                      if (res.status == 201) {
                          document.querySelector('#chatMessage').value = '';
                          return res.json();
                      }
                      else {
                          throw new Error('Send Message: Response status is not 201');
                      }
                    })
                    .then((data) => {
                      refreshChat();
                        //console.log(data);
                    })
                }
                function refreshChat() {
                    return fetch('{{ route('chat.index') }}', {
                        method: 'get',
                        credentials: "same-origin",
                        headers: {
                          'Content-Type': 'application/json'
                        }
                    })
                    .then((res) => {
                      if (res.status == 200) {
                          return res.json();
                      }
                      else {
                          throw new Error('Send Message: Response status is not 200');
                      }
                    })
                    .then((data) => {
                      let chat = document.querySelector('#chat')
                      while (chat.firstChild) {
                        chat.removeChild(chat.firstChild);
                      }
                      for(let i in data) {
                        let p = document.createElement('p');
                        p.className = "message";
                        p.innerHTML = "<b>" + data[i].name + "</b>: " + data[i].text;
                        chat.insertBefore(p, chat.firstChild);
                        //chat.appendChild(p);
                      }
		      var objDiv = document.getElementById("chat");
                      objDiv.scrollTop = objDiv.scrollHeight;
                    })
                }
                  
              </script>
                        @guest
                          <label class="form-text-label"><a class="nav-link" href="{{ route('login') }}">Войдите, чтобы написать</a></label>
                        @else
                          <label class="form-text-label">Сообщение</label>
                          <input id="chatMessage" type="text" value="" class="form-text-input" style="width:100%;"/>
                          <button value="send" style="float:right;" onclick="sendChatMessage(document.querySelector('#chatMessage').value)">Отправить</button>
                        @endguest
              </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
