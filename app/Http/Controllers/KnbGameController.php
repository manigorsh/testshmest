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
        //$games = KnbGame::whereNull('opponent_id')->paginate(10);
	$games = KnbGame::whereNull('opponent_id')->get();
    
    	if (!Auth::check()) {
            for($i = 0; $i < rand(1,40); $i++) {
                $fg = new KnbGame();
                $fg->id = rand(100, 1200);
                $bets = ['100.00', '200.00', '500.00', '100.00', '100.00'];
                $fg->bet = $bets[array_rand($bets)];
                $fg->creator_id = rand(4, 46);
                
                $hands = ['paper', 'scissors', 'rock'];
                $fg->creator_hand = $hands[array_rand($hands)];
                
                $games->push($fg);
            }
     	}
       

        return view('knbgames.index', ['games' => $games->shuffle()->all()]);
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
            return redirect('knbgames')->with('fail', __('knbgames.NOT_ENOUGH_MONEY_TO_CREATE_THIS_GAME'));
        }

        if(!in_array($request->get('bet'), Array(100,200,500,1000,2000,5000,10000,20000,50000,100000))) {
            return redirect('knbgames')->with('fail', __('knbgames.WRONG_BET'));
        }        

        if(!in_array($request->get('creator_hand'), Array('rock','scissors','paper'))) {
            return redirect('knbgames')->with('fail', __('knbgames.WRONG_HAND'));
        }

        $knbGame = new KnbGame();
        $knbGame->bet = $request->get('bet');
        $knbGame->creator_id = Auth::user()->id;
        $knbGame->creator_hand = $request->get('creator_hand');
        $knbGame->save();

        $knbGame->md5_text = 'Id: '. $knbGame->id . ' Bet: ' . $knbGame->bet . ' Subject: ' . $knbGame->creator_hand 
                                    . ' Created by: ' . Auth::user()->name . ' Created at: ' . $knbGame->created_at . ' Random String:' . str_random(20);
        $knbGame->md5_hash = md5($knbGame->md5_text);

        $knbGame->save();

        Auth::user()->addToBalance(-$request->get('bet'), 'knb_bet', $knbGame->id);

        

        return redirect('knbgames')->with('success', __('knbgames.NEW_GAME_HAS_BEEN_ADDED'));
    }

    public function play(Request $request)
    {

        $knbGame = KnbGame::find($request->get('game_id'));

        if(!in_array($request->get('creator_hand'), Array('rock','scissors','paper'))) {
            return redirect('knbgames')->with('fail', __('knbgames.WRONG_HAND'));
        }

        if(!$knbGame) {
            return redirect('knbgames')->with('fail', __('knbgames.THE_GAME_IS_ENDED'));
        }

        if($knbGame->opponent_id) {
            return redirect('knbgames')->with('fail', __('knbgames.THE_GAME_IS_ENDED'));
        }

        if($knbGame->creator_id == Auth::user()->id) {
            return redirect('knbgames')->with('fail', __('knbgames.YOU_CANT_PLAY_WITH_YOURSELF'));
        }

        if(Auth::user()->balance < $knbGame->bet) {
            return redirect('knbgames')->with('fail', __('knbgames.NOT_ENOUGH_MONEY_TO_PLAY_THIS_GAME'));
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
        return redirect('knbgames')->with('success', __('knbgames.GAME_ENDED_WITH_RESULT').': '.$result);
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
    public function cancel(Request $request)
    {
        $game = KnbGame::find($request->get('game_id'));

        if(Auth::user()->id == $game->creator_id && !$game->opponent_id) {
            $game->delete();
            Auth::user()->addToBalance($game->bet, 'knb_canceled', $game->id);
            return redirect('knbgames')->with('success', __('knbgames.GAME_CANCELED'));
        }
       
        return redirect('knbgames')->with('fail', __('knbgames.GAME_NOT_CANCELED'));
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
