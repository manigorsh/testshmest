<?php

namespace App\Http\Controllers;

use App\KnbGame;
use App\Transaction;
use App\User;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KnbGameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Cookie::get('ref')) {
            Cookie::queue(Cookie::make('ref', $request->ref, 60 * 24 * 365 * 100));
        }

        $games = KnbGame::whereNull('opponent_id')->paginate(10);
        return view('knbgames.index', ['games' => $games]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {        
        return view('knbgames.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::user()->balance < $request->get('bet')) {
            return redirect('knbgames')->with('fail', 'Not enough money to create this game..');
        }

        

        $knbGame = new KnbGame();
        $knbGame->bet = $request->get('bet');
        $knbGame->creator_id = Auth::user()->id;
        $knbGame->creator_hand = $request->get('creator_hand');
        $knbGame->save();

        Auth::user()->addToBalance(-$request->get('bet'), 'knb_bet', $knbGame->id);

        

        return redirect('knbgames')->with('success', 'New game has been added');
    }

    public function play(Request $request)
    {

        $knbGame = KnbGame::find($request->get('game_id'));

        if($knbGame->opponent_id) {
            return redirect('knbgames')->with('fail', 'The game is ended..');
        }

        if($knbGame->creator_id == Auth::user()->id) {
            return redirect('knbgames')->with('fail', 'You can\'t play with yourself..');
        }

        if(Auth::user()->balance < $knbGame->bet) {
            return redirect('knbgames')->with('fail', 'Not enough money to play this game..');
        }

        $result = '';
        $knbGame->opponent_id = Auth::user()->id;
        $knbGame->opponent_hand = $request->get('opponent_hand');

        if($knbGame->creator_hand == 'rock') {
            if($knbGame->opponent_hand == 'rock') {
                $result = 'draw';
            }
            elseif ($knbGame->opponent_hand == 'scissors') {
                $result = 'loose';
            }
            elseif ($knbGame->opponent_hand == 'paper') {
                $result = 'win';
            }
        }
        elseif ($knbGame->creator_hand == 'scissors') {
            if($knbGame->opponent_hand == 'rock') {
                $result = 'win';
            }
            elseif ($knbGame->opponent_hand == 'scissors') {
                $result = 'draw';
            }
            elseif ($knbGame->opponent_hand == 'paper') {
                $result = 'loose';
            }
        }
        elseif ($knbGame->creator_hand == 'paper') {
            if($knbGame->opponent_hand == 'rock') {
                $result = 'loose';
            }
            elseif ($knbGame->opponent_hand == 'scissors') {
                $result = 'win';
            }
            elseif ($knbGame->opponent_hand == 'paper') {
                $result = 'draw';
            }
        }


        $creator = User::find($knbGame->creator_id);
        $admin = User::find(1);

        $referrer_of_creator = User::find($creator->referrer_id);
        $referrer_of_opponent = User::find(Auth::user()->referrer_id);


        if($result == 'win') {
            Auth::user()->addToBalance($knbGame->bet * 2 * 0.97 - $knbGame->bet, 'knb_win', $knbGame->id);
            $referrer_of_creator->addToBalance($knbGame->bet * 2 * 0.01, 'knb_referrer_commission', $knbGame->id);
            $referrer_of_opponent->addToBalance($knbGame->bet * 2 * 0.01, 'knb_referrer_commission', $knbGame->id);
            $admin->addToBalance($knbGame->bet * 2 * 0.01, 'knb_system_commission', $knbGame->id);
        }
        elseif ($result == 'loose') {
            Auth::user()->addToBalance(-$knbGame->bet, 'knb_loose', $knbGame->id);
            $creator->addToBalance($knbGame->bet * 2 * 0.97, 'knb_win', $knbGame->id);
            $referrer_of_creator->addToBalance($knbGame->bet * 2 * 0.01, 'knb_referrer_commission', $knbGame->id);
            $referrer_of_opponent->addToBalance($knbGame->bet * 2 * 0.01, 'knb_referrer_commission', $knbGame->id);
            $admin->addToBalance($knbGame->bet * 2 * 0.01, 'knb_system_commission', $knbGame->id);
        }
        elseif ($result == 'draw') {
            $creator->addToBalance($knbGame->bet, 'knb_draw', $knbGame->id);
        }

        $knbGame->save();
        return redirect('knbgames')->with('success', 'Game ended with result: '.$result);
    }

    public function statistics()
    {
        //$games = Auth::user()->knbGameCreated;
        $games = KnbGame::where('creator_id', Auth::user()->id)
                        ->orWhere('opponent_id', Auth::user()->id)->paginate(10);
        return view('knbgames.statistics', ['games' => $games]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\KnbGame  $knbGame
     * @return \Illuminate\Http\Response
     */
    public function show(KnbGame $knbGame)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KnbGame  $knbGame
     * @return \Illuminate\Http\Response
     */
    public function edit(KnbGame $knbGame)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KnbGame  $knbGame
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KnbGame $knbGame)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KnbGame  $knbGame
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnbGame $knbGame)
    {
        //
    }


}
