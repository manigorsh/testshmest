@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">{{ __('knbgames.ROCK_SCISSORS_AND_PAPER_STATISTICS') }}</div>
                <div class="card-body">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">{{ __('knbgames.BET') }}</th>
                          <th scope="col">{{ __('knbgames.CREATOR') }} / {{ __('knbgames.HAND') }}</th>
                          <th scope="col">{{ __('knbgames.OPPONENT') }} / {{ __('knbgames.HAND') }}</th>
                          <th scope="col">{{ __('knbgames.MD5') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($games as $game)
                            <tr>
                                <td>{{ $game->bet }}</td>
                                <td>{{ $game->creator->name }} / {{ $game->creator_hand }}
                                </td>
                                <td>
                                  @if ($game->opponent_id)
                                    {{ $game->opponent->name }} / {{ $game->opponent_hand }}
                                  @endif
                                </td>
                                <td>
                                  @if ($game->opponent_id)
                                    <button type="button" class="btn btn-success fas fa-shield-alt" data-toggle="modal" data-target="#exampleModal" 
                                    data-md5-hash="{{ $game->md5_hash }}"
                                    data-md5-text="{{ $game->md5_text }}"></button>
                                  @else
                                    <button type="button" class="btn btn-success fas fa-shield-alt" data-toggle="modal" data-target="#exampleModal" 
                                    data-md5-hash="{{ $game->md5_hash }}"
                                    data-md5-text="{{ __('knbgames.AVAILABLE_AFTER_GAME_PLAYED')}}"></button>
                                  @endif
                                </td>
                            </tr>
                          @endforeach
                      </tbody>
                    </table>
                    {{ $games->links() }}
                    <a class="btn btn-primary" href="{{ route('knbgames.create') }}" role="button">{{ __('knbgames.CREATE_NEW_GAME') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
