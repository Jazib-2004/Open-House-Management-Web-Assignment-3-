<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fyp_group extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['group_name', 'email', 'password'];

}
