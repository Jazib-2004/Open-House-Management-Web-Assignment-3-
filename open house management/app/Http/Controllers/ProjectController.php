<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        if (!(Auth::user()->role == 'admin' || Auth::user()->role == 'guest')) {
            abort(403, 'Unauthorized action.');
        }
        $projects = Project::latest()
    ->orderByRaw('location IS NULL DESC, location ASC, id DESC')
    ->get();
        return view('/admin/dashboard', compact('projects'));
    }

    public function show(Project $project)
    {
        if (!(Auth::user()->role == 'admin' || Auth::user()->role == 'guest')) {
            abort(403, 'Unauthorized action.');
        }
        $availableLocations=$this->availableLocations();
        return view('projects/project',["availableLocations"=>$availableLocations, "project"=>$project]);
    }

    public function availableLocations()
    {
        // Get the total number of projects
        $totalProjects = Project::count();

        // Get the locations that are already assigned to projects
        $assignedLocations = Project::whereNotNull('location')->pluck('location')->toArray();

        // Calculate the available locations
        $availableLocations = array_diff(range(1, $totalProjects), $assignedLocations);

        return $availableLocations;
    }

    public function assignLocation($projectId, $locationId)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::find($projectId);

        if ($project) {
            $project->location = $locationId;
            $project->save();

            return redirect("/admin/dashboard")->with(['message' => "Location assigned successfully for Project $projectId"]);
        }
        return redirect("/projects/$projectId")->with(['message' => 'Location assignment Failed']);
    }

    public function showEvaluations($projectId)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $project = Project::findOrFail($projectId);
        $evaluations = Evaluation::where('project_id', $project->id)->whereNotNull('rating')
        ->with('evaluator')
        ->get();
        return view('admin.show_evaluations', compact('project', 'evaluations'));
    }

    public function showStudentProject()
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();
        $project=null;

        if($user->projects){
            $project = $user->projects->first();
        }

        return view('student.project.show', compact('project'));
    }

    /**
     * Store a new project for the student.
     */
    public function storeStudentProject(Request $request)
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }
        // Validate and store the project details
        $formFields=$request->validate([
            'title' => 'required|string',
            'tags' => 'required',
            'description' => 'required|string',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
     
        if($request->hasFile('picture')) {
            $formFields['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Create a new project
        $project = Project::create($formFields);

        // Attach the project to the user
        $user->projects()->attach($project->id);

        return redirect()->route('student.project.show')->with('message', 'Project added successfully!');
    }

    public function editProject()
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();
        $project = $user->projects;
        if($project){
            $project=$project->first();
        }
        return view('student.project.edit-project', compact('project'));
    }

    public function updateProject(Request $request)
    {
        if (Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();
        $project = $user->projects;
        if($project){
            $project=$project->first();
        }

        $formFields=$request->validate([
            'title' => 'required|string',
            'tags' => 'required',
            'description' => 'required|string',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        if($request->hasFile('picture')) {
            $formFields['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        $project->update($formFields);

        return redirect()->route('student.project.show')->with('message', 'Project updated successfully!');
    }


}
