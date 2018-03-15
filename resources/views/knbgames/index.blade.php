@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">{{ __('knbgames.ROCK_SCISSORS_AND_PAPER') }}</div>
                <div class="card-body">
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
                    {{ $games->links() }}
                    <a class="btn btn-primary fa" href="{{ route('knbgames.create') }}" role="button">{{ __('knbgames.CREATE_NEW_GAME') }}</a>
                </div>
                <div class="card-body">
                  <a href="{{ route('knbgames.statistics') }}" class="card-link">{{ __('knbgames.STATISTICS_OF_THE_GAMES') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
