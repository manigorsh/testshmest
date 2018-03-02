@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Create New Game</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('knbgames.store') }}">
                        @csrf


                         <div class="form-group row">
                            <label for="creator_hand" class="col-md-4 col-form-label text-md-right">Your Bet</label>

                            <div class="col-md-6">
                                <select name="bet">
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="2000">2000</option>
                                    <option value="5000">5000</option>
                                    <option value="10000">10000</option>
                                    <option value="20000">20000</option>
                                    <option value="50000">50000</option>
                                    <option value="100000">100000</option>
                                </select>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="creator_hand" class="col-md-4 col-form-label text-md-right">Your Hand</label>

                                <div class="col-md-6">
                                    <select name="creator_hand">
                                        <option value="rock">Rock</option>
                                        <option value="scissors">Scissors</option>
                                        <option value="paper">Paper</option>
                                    </select>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
