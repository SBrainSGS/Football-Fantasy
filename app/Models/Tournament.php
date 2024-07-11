<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'league_id', 'budget', 'start_datetime', 'end_datetime', 'max_players', 'privacy', 'host_id', 'link'];
}
