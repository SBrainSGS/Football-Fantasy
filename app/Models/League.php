<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['id', 'name', 'start_datetime', 'end_datetime'];
}
