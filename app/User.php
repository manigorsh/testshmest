<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


use App\Transaction;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'referrer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function knbGameCreated()
    {
        return $this->hasMany('App\KnbGame', 'creator_id', 'id');
    }

    public function knbGameParticipated()
    {
        return $this->hasMany('App\KnbGame', 'opponent_id', 'id');
    }

    public function transactionReceived()
    {
        return $this->hasMany('App\Transaction', 'user_id', 'id');
    }   

    public function getBalanceAttribute()
    {        
        $last_transaction = Transaction::where('user_id', $this->id)->orderBy('id', 'desc')->first();
        if (!$last_transaction) {
            $last_transaction = new Transaction();
            $last_transaction->user_id = $this->id;
            $last_transaction->type = 'initial';
            $last_transaction->save();
        }
        return $last_transaction->balance;
    }

    public function addToBalance($value, $reason, $description)
    {        
        $transaction = new Transaction();
        $transaction->user_id = $this->id;
        $transaction->amount = $value;
        $transaction->balance = $this->balance + $transaction->amount;
        $transaction->type = $reason;
        $transaction->description = $description;
        $transaction->save();
    }


}
