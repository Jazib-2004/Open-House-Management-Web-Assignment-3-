<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['fyp_id', 'title', 'keywords','description'];
    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }
    // Project.php

public function location()
{
    return $this->belongsTo(Location::class);
}
public function rubrics()
{
    return $this->hasMany(Rubric_metric::class, 'project_id');
}

   
}
