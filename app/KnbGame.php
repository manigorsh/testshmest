<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KnbGame extends Model
{
    public function creator()
    {
        return $this->belongsTo('App\User', 'id', 'creator_id');
    }

    public function opponent()
    {
        return $this->belongsTo('App\User', 'id', 'opponent_id');
    }
}
