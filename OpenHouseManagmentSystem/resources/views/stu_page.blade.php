<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Page - Open House Management Platform</title>
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

        h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
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
            margin-bottom: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #000;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            color: black;
            margin-top: 10px;
        }

        .update-container {
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 80vh;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to Your Student Page</h1>

        @if(isset($fypGroup))
            <h2>Your FYP Group: {{ $fypGroup->group_name }}</h2>
        @else
            <p class="alert">Error fetching FYP Group details.</p>
        @endif

        <h3>Your Project Details</h3>

        @if(count($projects) > 0)
        <ul>
            @foreach($projects as $project)
                <li>
                    <strong>Title:</strong> {{ $project->title }} <br>
                    <strong>Description:</strong> {{ $project->description }} <br>

                    @if($project->keywords)
                        <strong>Keywords:</strong>
                        <ul>
                            @foreach(explode(',', $project->keywords) as $keyword)
                                <li>{{ $keyword }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if($project->rubrics->count() > 0)
        <ul>
            @foreach($project->rubrics as $rubric)
                <li>
                    <strong>Description:</strong> {{ $rubric->rubric->description }} <br>
                    <strong>Name:</strong> {{ $rubric->rubric->name }} <br>
                    <strong>Rating:</strong> {{ $rubric->rating }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No rubrics found for this project.</p>
    @endif
                    <strong>Location:</strong> {{ $project->location ? $project->location->name : 'Location not set by admin yet' }} <br>

            @endforeach
<!-- Display project images and captions -->
@if(isset($project->images) && is_array($project->images) && isset($project->captions) && is_array($project->captions))
    <strong>Images:</strong>
    <ul>
        @foreach($project->images as $index => $image)
            <li>
                <img src="{{ asset('storage/' . $image) }}" alt="Image {{ $index + 1 }}" style="max-width: 100px;">
                <br>
                <strong>Caption:</strong> {{ $project->captions[$index] ?? 'No caption' }}
            </li>
        @endforeach
    </ul>
@endif



           

        <h3>Ratings from Evaluators</h3>
        <br><br><br>
<br><br><br><br><br>
        <div class="update-container">
            <h3>Update Your Project</h3>
            <form action="/update_stu/{{ $fypGroup->id }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="title">Project Title:</label>
                <input type="text" name="title" required>

                <label for="description">Project Description:</label>
                <textarea name="description" required></textarea>

                <!-- Keywords Input -->
                <label for="keywords">Keywords (comma-separated):</label>
                <input type="text" name="keywords" required>

                <!-- Image Upload -->
                <label for="images">Add Image of your project</label>
                <input type="file" name="images[]" multiple accept="image/*">

                <!-- Image Captions -->
                <label for="captions">Image Caption:</label>
                <input type="text" name="captions[]">

                <!-- Add more image and caption fields dynamically -->
                <div id="additional-images"></div>
                <button type="button" onclick="addImageField()">Add More Images</button>

                <button type="submit">Update Project</button>
            </form>
        </div>

    @else
        <p>No projects found for your group. Please add your project.</p>

        <h3>Add Your Project</h3>
        <form action="/add_stu/{{ $fypGroup->id }}" method="post" enctype="multipart/form-data">
            @csrf
            <label for="title">Project Title:</label>
            <input type="text" name="title" required>

            <label for="description">Project Description:</label>
            <textarea name="description" required></textarea>

            <!-- Keywords Input -->
            <label for="keywords">Keywords (comma-separated):</label>
            <input type="text" name="keywords" required>

            <!-- Image Upload -->
            <label for="images">Images (select multiple):</label>
            <input type="file" name="images[]" multiple accept="image/*">

            <!-- Image Captions -->
            <label for="captions">Image Captions (comma-separated):</label>
            <input type="text" name="captions[]">

            <!-- Add more image and caption fields dynamically -->
            <div id="additional-images"></div>
            <button type="button" onclick="addImageField()">Add More Images</button>

            <button type="submit">Add Project</button>
        </form>
    @endif
</div>
<script>
    function addImageField() {
        // Create new input elements
        var imageInput = document.createElement("input");
        var captionInput = document.createElement("input");

        // Set attributes for the new inputs
        imageInput.type = "file";
        imageInput.name = "images[]";
        imageInput.accept = "image/*";

        captionInput.type = "text";
        captionInput.name = "captions[]";

        // Append new inputs to the container
        document.getElementById("additional-images").appendChild(imageInput);
        document.getElementById("additional-images").appendChild(captionInput);
    }
</script>
</body>

</html>
