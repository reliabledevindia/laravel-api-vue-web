<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Polls extends Model
{
    use Sluggable;
    
	protected $table = "polls";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug','question','status','created_at'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source'  => 'question',
                'onUpdate'=> true,
            ]
        ];
    }

    /**
     * The function that should be find the slug for this model.
     * 
     * @param array $slug 
     */
    static public function findBySlug($slug)
    {
        return static::where('slug',$slug)->first();
    }

    public function options()
    {
        return $this->hasMany(PollOptions::class,'poll_id');
    }
}
