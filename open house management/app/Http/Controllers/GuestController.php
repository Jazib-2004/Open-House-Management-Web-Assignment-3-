<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function index()
    {
        // Check if the authenticated user has the role 'guest'
        if (Auth::user()->role != 'guest') {
            abort(403, 'Unauthorized action.');
        }

        // Retrieve the user's assigned projects based on evaluations
        $projects = Project::whereNotNull('location')
            ->whereHas('evaluations', function ($query) {
                $query->where('evaluator_id', Auth::id());
            })
            ->orderBy('location', 'asc')
            ->get();

        return view('/guest/home', compact('projects'));
    }

    public function preferences()
    {
        if (Auth::user()->role !== 'guest') {
            abort(403, 'Unauthorized action.');
        }
        // Retrieve the guest preferences for the authenticated user
        $tags = Auth::user()->guestPreference()->pluck('tags')->toArray();

        // Pass the tags to the view
        return view('guest/preferences/preferences', ['tags' => $tags]);
    }

    public function editPreferences()
    {
        if (Auth::user()->role !== 'guest') {
            abort(403, 'Unauthorized action.');
        }
        // Retrieve the guest preferences for the authenticated user
        $tags = Auth::user()->guestPreference()->pluck('tags')->toArray();

        // Pass the tags to the view
        return view('/guest/preferences/edit', ['tags' => $tags]);
    }

    public function store(Request $request)
    {
        // Validate and store the guest's preferred keywords
        $request->validate([
            'keywords' => 'required|string',
        ]);

        // Check if the authenticated user has the role 'guest'
        if (Auth::user()->role === 'guest') {
            // Create a new guest preferences record for the authenticated user
            Auth::user()->guestPreference()->create([
                'tags' => $request->input('keywords'),
            ]);

            $this->assignProjectsForEvaluation(Auth::user());

            return redirect()->route('guest.preferences')->with('message', 'Keywords submitted successfully!');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function edit(Request $request)
    {
        // Validate and store the guest's preferred keywords
        $request->validate([
            'keywords' => 'required|string',
        ]);

        // Check if the authenticated user has the role 'guest'
        if (Auth::user()->role === 'guest') {
            // Create a new guest preferences record for the authenticated user
            Auth::user()->guestPreference()->update([
                'tags' => $request->input('keywords'),
            ]);

            $this->assignProjectsForEvaluation(Auth::user());

            return redirect()->route('guest.preferences')->with('message', 'Keywords Updated successfully!');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    
    private function assignProjectsForEvaluation($user)
    {
        // Retrieve projects that match the user's current preferred keywords and have a non-null location
        $tagsArray = explode(',', $user->guestPreference->tags);

        $matchingProjects = Project::whereNotNull('location')
            ->where(function ($query) use ($tagsArray) {
                foreach ($tagsArray as $tag) {
                    $query->orWhere('tags', 'like', '%' . $tag . '%');
                }
            })
            ->get();

        // Exclude projects that the user has already rated
        $ratedProjectIds = Evaluation::where('evaluator_id', $user->id)->whereNotNull('rating')->pluck('project_id')->toArray();

        // Exclude already rated projects from the matching projects
        $unratedProjects = $matchingProjects->whereNotIn('id', $ratedProjectIds);

        // Retrieve the user's current assigned projects
        $assignedProjects = Evaluation::where('evaluator_id', $user->id)->whereNull('rating')->pluck('project_id')->toArray();

        // Calculate the number of additional projects needed to reach the desired range (3-5)
        $desiredMaxAssignments = 5;
        $additionalProjectsNeeded = max(0, $desiredMaxAssignments - count($assignedProjects));

        // Take the required number of projects, even if less than the desired maximum
        $newAssignments = $unratedProjects->pluck('id')->take(min($additionalProjectsNeeded, $desiredMaxAssignments))->toArray();

        // Remove excess assignments if the total exceeds the desired maximum
        if (count($ratedProjectIds) + count($newAssignments) > $desiredMaxAssignments) {
            $excessAssignments = count($ratedProjectIds) + count($newAssignments) - $desiredMaxAssignments;
            $newAssignments = array_slice($newAssignments, 0, -$excessAssignments);
        }

        // Merge new assignments with existing assignments
        $assignedProjects = array_merge($assignedProjects, $newAssignments);

        // Create or update evaluation records for the assigned projects
        foreach ($assignedProjects as $projectId) {
            $evaluation = Evaluation::updateOrCreate(
                ['evaluator_id' => $user->id, 'project_id' => $projectId],
                ['rating' => null] // Set rating to null for new assignments
            );
        }
    }








    public function rateProject(Request $request)
    {
        // Validate the request
        $request->validate([
            'rating' => 'required|integer|min:1|max:10',
        ]);

        // Save the evaluation
        $evaluatorId = auth()->user()->id;
        $projectId = $request->input('projectId');
        $rating = $request->input('rating');
        // Find existing evaluation
        $evaluation = Evaluation::where('evaluator_id', $evaluatorId)
            ->where('project_id', $projectId)
            ->first();
        if ($evaluation) {
            // Update existing evaluation
            $evaluation->rating = $rating;
            $evaluation->save();
        }

            return redirect()->route('guest.home')->with('message', 'Rating submitted successfully.');
        }

}
