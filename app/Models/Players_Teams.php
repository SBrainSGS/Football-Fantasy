<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players_Teams extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['team_id', 'player_id'];
}
