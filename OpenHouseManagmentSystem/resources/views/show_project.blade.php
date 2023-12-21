<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details - Open House Management Platform</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden; /* Hide the vertical scrollbar */
        }

        .container {
            background: linear-gradient(135deg, #3494e6, #ec6ead);
            color: black;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-height: 80vh;
            max-width: 80vh; /* Set maximum height for the container */
            overflow-y: auto; /* Enable vertical scrolling if content overflows */
        }

        h1, h2, h3, p {
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 1.5em;
            margin-bottom: 15px;
        }

        p {
            font-size: 1em;
            margin-bottom: 15px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 15px;
            border: 6px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            list-style: none;
        }

        strong {
            color:black;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }

        .alert {
            color: black;
            margin-top: 10px;
        }

        .location-link {
            display: block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        .location-link:hover {
            text-decoration: underline;
        }
        a{
            background-color:white;
            text-decoration :none;
            border: 2px solid #ccc;
            padding: 15px;
            border-radius: 8px;
        }
        form {
        margin-top: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    label {
        font-size: 1.2em;
        margin-bottom: 8px;
        color: white;
    }

    select {
        padding: 10px;
        border: 2px solid #ccc;
        border-radius: 5px;
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 15px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 15px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin:10px;
    }

    button:hover {
        background-color: #45a049;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Project Details</h1>

        @if(count($projects) > 0)
            @foreach($projects as $project)
                <li>
                    <h2>{{ $project->title }}</h2>
                    <p><strong>Description:</strong> {{ $project->description }}</p>

                    @if($project->keywords)
                        <p><strong>Keywords:</strong>
                            <ul>
                                @foreach(explode(',', $project->keywords) as $keyword)
                                    <li>{{ $keyword }}</li>
                                @endforeach
                            </ul>
                        </p>
                    @endif

                    <!-- Display project images and captions -->
                    @if($project->images && $project->images->count() > 0)
                        <p><strong>Images:</strong></p>
                        <ul>
                            @foreach($project->images as $image)
                                <li>
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $project->title }}" style="max-width: 100%;">
                                    <p><strong>Caption:</strong> {{ $image->caption ?? 'No caption' }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif

        

                  
                    <form method="post" action="/set_location">
    @csrf
    <label for="location">Select Location:</label>
    <select name="location_id" {{ $project->location_id || in_array($project->id, $takenLocationProjectIds) ? 'disabled' : '' }}>
        @foreach($locations as $location)
            <option value="{{ $location->id }}" {{ ($location->id == $project->location_id) ? 'selected' : '' }} {{ $project->location_id || in_array($project->id, $takenLocationProjectIds) ? 'disabled' : '' }}>
                {{ $location->name }}
            </option>
        @endforeach
    </select>
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <button type="submit" {{ $project->location_id || in_array($project->id, $takenLocationProjectIds) ? 'disabled' : '' }}>Set Location</button>
</form>




<!-- Form for adding rubrics -->
<form method="post" action="/add_rubrics">
    @csrf
    <label for="rubric">Add Rubric (comma separated):</label>
    <textarea name="rubric" rows="4" cols="50">{{ old('rubric') }}</textarea>
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <button type="submit">Add Rubric</button>
</form>

<!-- Display existing rubrics for the project -->
@if($project->rubrics && $project->rubrics->count() > 0)
    <p><strong>Existing Rubrics:</strong></p>
    <ul>
        @foreach($project->rubrics as $rubric)
            <li>{{ $rubric->description }}</li>
        @endforeach
    </ul>
@endif


                </li>
            @endforeach
        @else
            <p>No projects found for your group. Please add your project.</p>
        @endif
    </div>
</body>

</html>
