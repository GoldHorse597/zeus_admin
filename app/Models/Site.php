<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Site extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'name',     // ← 이걸 추가해야 mass assignment 실행됨
        'domain',
    ];
}
