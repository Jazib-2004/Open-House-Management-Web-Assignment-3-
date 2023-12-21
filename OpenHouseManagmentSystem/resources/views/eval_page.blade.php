<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluator Page</title>
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
            overflow: hidden;
        }

        .container {
            background: linear-gradient(135deg, #3494e6, #ec6ead);
            color: black;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-height: 80vh;
            max-width: 80vh;
            overflow-y: auto;
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
            color: black;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }

        .rubric {
            margin-top: 20px;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
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
            margin: 10px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Evaluator Page</h1>

        @if(count($projects) > 0)
            @foreach($projects as $project)
                <li>
                    <h2>{{ $project->title }}</h2>
                    <p><strong>Description:</strong> {{ $project->description }}</p>

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

                    <!-- Display rubrics for the project -->
                    @if($rubrics && $rubrics->count() > 0)
                        <p><strong>Rubrics:</strong></p>
                        <ul>
                            @foreach($rubrics as $rubric)
                                <li class="rubric">
                                    <span>{{ $rubric->description }}</span>
                                    <form action="/rate/{{$project->id}}" method = "post">
                                    <label for="rating">Rate:</label>
                                    <select name="rating" id="rating">
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        @else
            <p>No projects found for evaluation.</p>
        @endif
    </div>
</body>

</html>
