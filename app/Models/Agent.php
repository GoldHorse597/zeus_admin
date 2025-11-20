<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Agent extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    //
    protected $fillable = [
        'identity',
        'nickname',
        'email',
        'password',
        'password_original',
        'status',
        'type',
        'parent_id',
        'parent_level',
        'ancestry',
        'site_id',
        'last_access_session',
        'last_access_ip',
        'last_access_at',
        'memo'
    ];
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_access_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function($model)
        {
        });
        self::saved(function($model)
        {
        });
        self::updated(function($model)
        {
        });
        self::deleting(function($model)
        {   
            Message::where(['receiver_id' => $model->id, 'receiver_type' => 0])->delete();
            Inquiry::where(['sender_id' => $model->id, 'sender_type' => 0])->delete();
        });
    }

    /**
     * Set the agent's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        if (preg_match('/^\$2y\$/', $value)) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = bcrypt($value);
        }
    }
    
    public function getParents()
    {
        $ancestry_ids = explode('/', trim($this->ancestry, '/'));
        $parents = array();
        foreach ($ancestry_ids as $ancestry_id) {
            $parent = Agent::where('id', $ancestry_id)->first();
            if ($parent && $parent->parent_level >= $authUser->parent_level - 1)
                $parents[] = $parent;
        }
        $parents[] = $agent;

        return $parents;
    }
}
