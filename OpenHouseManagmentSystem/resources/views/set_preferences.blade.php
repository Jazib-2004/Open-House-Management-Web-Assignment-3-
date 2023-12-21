<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- resources/views/set_preferences.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Your head content goes here -->
    <title>Set Preferences</title>
</head>

<body>
    <h1>Set Your Preferences</h1>

    <form method="post" action="/save_prefer/{{$id}}">
        @csrf

        <!-- Add form fields for project categories, specialty areas, etc. -->
        <label for="project_categories">Project Categories:</label>
        <input type="text" name="project_categories" required>

        <label for="specialty_areas">Specialty Areas:</label>
        <input type="text" name="specialty_areas" required>

        <!-- Add more fields as needed -->

        <button type="submit">Save Preferences</button>
    </form>
</body>

</html>

</body>
</html>