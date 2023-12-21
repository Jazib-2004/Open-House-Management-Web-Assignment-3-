<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Open House Management Platform</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: linear-gradient(135deg, #3494e6, #ec6ead);
            color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .card-header {
            font-size: 1.5em;
            padding-bottom: 10px;
            border-bottom: 3px solid #ccc;
            margin-bottom: 10px;
            color:black;
        }

        .card-body label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color : black;
        }

        .card-body input,
        .card-body select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .card-body input[type="checkbox"] {
            margin-top: 5px;
        }

        .card-body button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .card-body button:hover {
            background-color: #0056b3;
        }

        .additional-links {
            margin-top: 15px;
            font-size: 0.9em;
        }

        .additional-links a {
            color: #007bff;
            text-decoration: none;
        }

        .additional-links a:hover {
            text-decoration: underline;
        }
        .alert{
            color:black;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Register</div>

            <div class="card-body">
                <!-- Laravel Registration Form -->
                <form method="POST" action="\registeration">
                    @csrf

                    <!-- Name Field -->
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

                    <!-- Email Field -->
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>

                    <!-- Password Field -->
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>

                    <!-- Confirm Password Field -->
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>

                    <!-- Role Field (Dropdown) -->
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="admin">Admin</option>
                        <option value="evaluator">Evaluator</option>
                        <option value="fyp_group">FYP Group</option>
                    </select>

                    <!-- Register Button -->
                    <button type="submit">Register</button>
                    @if ($errors->any())
    <div class="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                </form>
            </div>
        </div>
    </div>
</body>

</html>
