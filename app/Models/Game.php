<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $fillable = [
        'name',     // ← 이걸 추가해야 mass assignment 실행됨
    ];
}
