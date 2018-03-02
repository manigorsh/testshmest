<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function recipient()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }
}
