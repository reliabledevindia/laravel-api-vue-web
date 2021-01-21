<?php

namespace App;

use Modules\Roles\Entities\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Spatie\Permission\Traits\HasRoles;
use Kyslik\ColumnSortable\Sortable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Sluggable,Sortable,Notifiable;
    use SoftDeletes;
    use HasRoles;
    use Sortable;
    use HasApiTokens;

    //public static $guard_name = "web";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug','username','name', 'email','password','status','email_verified_at','last_login_at','last_login_ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['last_login_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $sortable = ['id','name','email','created_at'];


     /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate'=>false
            ],
            'username' => [
                'source' => 'name',
                'onUpdate'=>false
            ],
        ];
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->name);
    }

    static public function createUser($data,$role='user')
    {
         $user = static::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt(trim($data['password'])),
                ]);
        $role = Role::findByName($role);
        if(!empty($role))
        {
            $user->roles()->sync([$role->id]);
        }
        return $user;
    }

    public function pollVotes()
    {
        return $this->hasMany(UserPollVotes::class,'user_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}