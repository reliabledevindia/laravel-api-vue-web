<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserPollVotes;

class PollOptions extends Model
{
	protected $table = "polls_options";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'poll_id','name','created_at'
    ];

    public function checkOptionisChecked($optionid)
    {
       return UserPollVotes::where('user_id',auth()->user()->id)->where('polls_option_id',$optionid)->exists();
       //return ($res ? $optionid : '');
    }
}
