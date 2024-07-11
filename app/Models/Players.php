<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['id', 'name', 'avatar_path', 'real_team', 'position'];
}
