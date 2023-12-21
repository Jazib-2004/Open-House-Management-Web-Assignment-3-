<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubric_metric extends Model
{
    use HasFactory;
    public $timestamps = false;
    // RubricMetrics.php

public function rubric()
{
    return $this->belongsTo(Rubric::class, 'rubric_id');
}

public function project()
{
    return $this->belongsTo(Project::class, 'project_id');
}

}
