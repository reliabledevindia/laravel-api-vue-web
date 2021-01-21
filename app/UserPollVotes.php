<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPollVotes extends Model
{ 
	protected $table = "user_poll_votes";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','poll_id','polls_option_id','created_at'
    ];
}
