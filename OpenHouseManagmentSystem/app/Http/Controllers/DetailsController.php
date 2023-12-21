<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Fyp_group;
use App\Models\Evaluator;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\TakenLocation;
use App\Models\Location;
use App\Models\Prefer;
use App\Models\Rubric;
use App\Models\RubricMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DetailsController extends Controller
{
    public function stu_page(Request $request, $id)
{
    try {
        // Get Fyp_group details
        $fypGroup = Fyp_group::find($id);

        // Get projects associated with the Fyp_group with the 'location' relationship loaded
        $projects = Project::with(['location', 'rubrics'])->where('fyp_id', $id)->get();
    } catch (\Exception $e) {
        Log::error('Error getting student details: ' . $e->getMessage());
    }

    return view('stu_page', ['fypGroup' => $fypGroup, 'projects' => $projects  ]);
}



    public function add_project(Request $request, $id)
{
    try {
        
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'keywords' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust file types and size as needed
        ]);
        
        // Example: Save project details to the database using DB facade
        $projectId = DB::table('projects')->insertGetId([
            'fyp_id' => $id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'keywords' => $request->input('keywords'),
        ]);
        // Example: Save project images to the database using DB facade
        $images = $request->file('images');
        $captions = $request->input('captions');

        if ($images && is_array($images)) {
            foreach ($images as $key => $image) {
                // Example: Store the image in the storage and get its path
                $imagePath = $image->store('project_images', 'public');

                // Example: Save image details to the project_images table
                DB::table('project_images')->insert([
                    'project_id' => $projectId,
                    'image_path' => $imagePath,
                    'caption' => isset($captions[$key]) ? $captions[$key] : null,
                ]);
            }
        }
     
        // Redirect or return a response as needed
        return redirect('/studetails/'.$id);
    } catch (\Exception $e) {
        Log::error('Error inserting project details: ' . $e->getMessage());
        // Handle the error, redirect, or return a response
        return redirect()->back()->with('error', 'Failed to add project');
    }
}

    
public function update_project(Request $request, $id)
{
    try {
        // Example: Update project details in the database using DB facade
        DB::table('projects')
            ->where('fyp_id', $id)
            ->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'keywords' => $request->input('keywords'),
            ]);

        // Example: Delete existing project images
        DB::table('project_images')->where('project_id', $id)->delete();

        // Example: Save updated project images to the database using DB facade
        $images = $request->file('images');
        $captions = $request->input('captions');

        if ($images && is_array($images)) {
            foreach ($images as $key => $image) {
                // Example: Store the image in the storage and get its path
                $imagePath = $image ->store('project_images', 'public');

                // Example: Save image details to the project_images table
                DB::table('project_images')->insert([
                    'project_id' => $id,
                    'image_path' => $imagePath,
                    'caption' => isset($captions[$key]) ? $captions[$key] : null,
                ]);
            }
        }

        // Redirect or return a response as needed
        return redirect('/studetails/'.$id);
    } catch (\Exception $e) {
        Log::error('Error updating project details: ' . $e->getMessage());
        // Handle the error, redirect, or return a response
        return redirect()->back()->with('error', 'Failed to update project');
    }
}


    public function rate(Request $request,$projectId)
    {
        // Assuming the form sends the 'rating' value
        $rating = request('rating');

        // Loop through each rubric and insert the rating
        foreach (request('rubrics') as $rubricId) {
            DB::table('rubric_metric')->insert([
                'rubric_id' => $rubricId,
                'project_id' => $projectId,
                'rating' => $rating,
            ]);
        }

        return redirect('/projects')->with('success', 'Project rated successfully!');
    }
public function show_project()
{
    try {
       
        // Get all projects with their associated images and rubrics
        $projects = Project::with(['images', 'rubrics'])->get();
        
        // Get all available locations
        $locations = Location::all();
        
        // Get project IDs with assigned locations
        $takenLocationProjectIds = TakenLocation::pluck('project_id')->toArray();
    
        return view('show_project', ['projects' => $projects, 'locations' => $locations, 'takenLocationProjectIds' => $takenLocationProjectIds]);
    } catch (\Exception $e) {
        \Log::error('Error fetching projects: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to fetch projects');
    }
}

public function preferences(Request $request,$id){

    DB::table('prefers')->insert([
        'evaluator_id' => $id,
        'project_categories' => $request->input('project_categories'),
        'specialty_areas' => $request->input('specialty_areas'),
     
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $matchingProjects = Project::where('keywords', 'like', "%$projectCategories%")
        ->limit(3) // Fetch the first 3 matching projects
        ->pluck('id');
        $rubrics = Rubric::whereIn('project_id', $matchingProjects)->get();

        return view('eval_page', [
            'project_categories' => $projectCategories,
            'rubrics' => $rubrics,
        ]);
}
public function set_preferences($id)
{

    $preferences = DB::table('prefers')->where('evaluator_id', $id)->first();
    dd($preferences);
    if ($preferences) {
        // Preferences exist, fetch matching projects and associated rubrics
        $matchingProjects = Project::where('keywords', 'like', "%$preferences->project_categories%")
            ->limit(3) // Fetch the first 3 matching projects
            ->pluck('id');
        $rubrics = Rubric::whereIn('project_id', $matchingProjects)->get();

        return view('eval_page', [
            'project_categories' => $preferences->project_categories,
            'rubrics' => $rubrics,
        ]);
    } else {
        // Preferences are not set, redirect to the set_preferences view
        return view('set_preferences', ['id' => $id  ]);
    }
}




public function setLocation(Request $request)
{
    try {
        $locationId = $request->input('location_id');
        $projectId = $request->input('project_id');

        // Check if the project already has a location assigned
        $project = Project::find($projectId);
        if ($project->location_id) {
            return redirect()->back()->with('error', 'Project already has a location assigned.');
        }

        // Move the selected location to the "taken_locations" table
        $location = Location::find($locationId);

        // Example: Store the location in the taken_locations table using DB::table
        DB::table('taken_locations')->insert([
            'project_id' => $projectId, // Include project_id
            'name' => $location->name,
            // Add other relevant fields
        ]);

        // Delete the selected location from the "locations" table
        $location->delete();

        // Associate the selected location with the project
        $project->location_id = $locationId;
        $project->save();

        return redirect('/landing')->with('success', 'Location set successfully.');

    } catch (\Exception $e) {
        \Log::error('Error setting location: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to set location');
    }
}


public function addRubrics(Request $request)
{
    try {
        $projectId = $request->input('project_id');
        $rubricsInput = $request->input('rubric');

        // Get the project name
        $project = Project::find($projectId);
      
        // Split rubrics into an array
        $rubricArray = explode(',', $rubricsInput);
        
    
        foreach ($rubricArray as $rubric) {
            
            DB::table('rubrics')->insert([
            'met_id' => $request->input('project_id'),
            'name' => $project->title, 
            'description' => $rubric,]);
            
        }
        
        // Redirect back to the project details page with success message
        return redirect('/landing'.$id);
        
    } catch (\Exception $e) {
        \Log::error('Error adding rubrics: ' . $e->getMessage());
        // Redirect back to the project details page with error message
        return redirect()->back()->with('error', 'Failed to add rubrics');
    }
}





// Method for updating ratings
public function updateRubricRatings(Request $request)
{
    try {
        // Assuming you have a form with rubric_id and rating inputs for each rubric
        $rubricId = $request->input('rubric_id');
        $projectId = $request->input('project_id');
        $rating = $request->input('rating');

        // Example: Update rating in rubric_ratings table
        RubricRating::where('rubric_id', $rubricId)
            ->where('project_id', $projectId)
            ->update(['rating' => $rating]);

        return redirect()->back()->with('success', 'Rubric rating updated successfully.');
        
    } catch (\Exception $e) {
        \Log::error('Error updating rubric rating: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update rubric rating');
    }
}



}