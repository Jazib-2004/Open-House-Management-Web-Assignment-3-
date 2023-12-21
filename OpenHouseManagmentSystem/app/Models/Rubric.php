<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'id', 'description'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
