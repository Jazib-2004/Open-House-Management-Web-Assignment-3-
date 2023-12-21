<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['project_id', 'image_path', 'caption'];
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
