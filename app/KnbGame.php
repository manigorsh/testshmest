<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KnbGame extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];
	
    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id', 'id');
    }

    public function opponent()
    {
        return $this->belongsTo('App\User', 'opponent_id', 'id');
    }
}
