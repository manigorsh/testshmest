@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">{{ __('knbgames.ROCK_SCISSORS_AND_PAPER') }}</div>
                <div class="card-body">
                  @if (Session::has('success'))
                     <div class="alert alert-success">{{ Session::get('success') }}</div>
                  @endif
                  @if (Session::has('fail'))
                     <div class="alert alert-warning">{{ Session::get('fail') }}</div>
                  @endif
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">{{ __('knbgames.BET') }}</th>
                          <th scope="col">{{ __('knbgames.YOUR_HAND') }}</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($games as $game)
                          <tr>
                              <th scope="row">{{ $game->id }}</th>
                              <td>{{ $game->bet }}</td>
                              <td>
                              <form method="POST" action="{{ route('knbgames.play') }}" id="game_form_{{ $game->id }}">
                                @csrf
                                <input type="hidden" name="game_id" value="{{ $game->id }}"/>
                                <select name="opponent_hand">
                                    <option value="rock">{{ __('knbgames.ROCK') }}</option>
                                    <option value="scissors">{{ __('knbgames.SCISSORS') }}</option>
                                    <option value="paper">{{ __('knbgames.PAPER') }}</option>
                                </select>
                              </form>
                              <td>
                                <a class="btn btn-primary" href="#" onclick="document.getElementById('game_form_{{ $game->id }}').submit(); return false;" role="button">{{ __('knbgames.PLAY') }}</a>
                              </td>

                            </tr>
                          @endforeach
                      </tbody>
                    </table>
                    {{ $games->links() }}
                    <a class="btn btn-primary" href="{{ route('knbgames.create') }}" role="button">{{ __('knbgames.CREATE_NEW_GAME') }}</a>
                </div>
                <div class="card-body">
                  <a href="{{ route('knbgames.statistics') }}" class="card-link">{{ __('knbgames.STATISTICS_OF_THE_GAMES') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
