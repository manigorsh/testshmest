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
                          <th scope="col">#</th>
                          <th scope="col">{{ __('knbgames.BET') }}</th>
                          <th scope="col">{{ __('knbgames.YOUR_HAND') }}</th>
                          <th scope="col">{{ __('knbgames.OPPONENT_HAND') }}</th>
                          <th scope="col">{{ __('knbgames.RESULT') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($games as $game)
                            <tr>
                                <th scope="row">{{ $game->id }}</th>
                                <td>{{ $game->bet }}</td>
                                <td>{{ $game->creator_hand }}</td>
                                <td>{{ $game->opponent_hand }}</td>
                                <td></td>
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
