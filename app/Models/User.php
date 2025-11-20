<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Game;
use App\Models\GameApi;
use App\Services\Game\HonorLinkService;
use App\Services\Game\GolliaService;
use App\Services\Game\SubtlePlayService;
use App\Services\Game\StarService;
use App\Services\Game\GoldenBullService;
use App\Services\Game\SGamingService;
use App\Services\Game\CrystalService;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identity',
        'nickname',
        'email',
        'password',
        'password_original',
        'status',
        'level',
        'parent_id',
        'parent_level',
        'ancestry',        
        'option',
        'site_id',
        'site_identity',
        'last_access_session',
        'last_access_ip',
        'last_access_at',
        'auto_level',
        'auto_expire_at',
        'memo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_access_at' => 'datetime',
        'auto_expire_at' => 'datetime'
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
            Message::where(['receiver_id' => $model->id, 'receiver_type' => 1])->delete();
            Inquiry::where(['sender_id' => $model->id, 'sender_type' => 1])->delete();
        });
    }

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
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
