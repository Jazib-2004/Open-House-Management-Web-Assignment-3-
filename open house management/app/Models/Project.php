<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description','tags' ,'location','picture'];

    public function isAssigned()
    {
        return !empty($this->location);
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'project_id');
    }

    public function getUserRating($projectId)
    {
        // Check if the current user has rated this project
        $currentUser = auth()->user();

        if ($currentUser) {
            $evaluation = $this->evaluations()
                ->where('evaluator_id', $currentUser->id)
                ->where('project_id', $projectId)
                ->first();

            return $evaluation ? $evaluation->rating : null;
        }

        return null;
    }
}
