<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Your Project</title>
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

        h3 {
            font-size: 1.5em;
            margin-bottom: 15px;
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
    </style>
</head>

<body>
   
    <div class="container">
        <h3>Update Your Project</h3>
        <form action="/update_stu/".{{id}} method="post" enctype="multipart/form-data">
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
