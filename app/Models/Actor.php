<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'Actor';
    use HasFactory;

    protected $fillable = ['actor_firstname', 'actor_lastname'];

    public $timestamps = false;
}
