<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Open House Management Platform</title>
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

        .card-header {
            font-size: 1.5em;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 3px solid #ccc;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(54, 244, 154, 0.3);
        }

        .card-body p {
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .columns {
            display: flex;
            
            justify-content: center;
            margin-top: 10px;
        }

        .column {
            flex: 0 1 calc(30% - 20px);
            text-align: center;
            margin: 10px 10px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(156, 234, 176, 0.1);
            background: rgba(205, 205, 205, 0.19);
            border : 3px solid ;
        }

        .btn {
            padding: 10px 20px;
            font-size: 1em;
            text-decoration: none;
            margin: 0 10px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn:hover {
            opacity: 0.8;
        }
        .p{
            color:black;
        }
        .cen{
            display:flex;
            text-align: center;
        }
        .text-center{
            display:flex;
            justify-content:center;
        }
      
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
           
            <div class="pr card-header">Welcome to the Open House Management Platform</div>
          
            <div class="card-body">
                <p>
                    <span style="font-size: 1.2em;">"Welcome to a world of innovation and brilliance."</span>
                </p>
                <p>
                    "Thank you for being a part of the Open House event. This platform is designed to streamline the
                    evaluation process for Final Year Projects."
                </p>

                <div class="columns">
                    <div class="column p">
                        <h3>Admins</h3>
                        <p>Your guidance shapes the future.</p>
                    </div>
                    <div class="column p">
                        <h3>Evaluators</h3>
                        <p>Your expertise defines excellence.</p>
                    </div>
                    <div class="column p">
                        <h3>Students (FYP)</h3>
                        <p>Your innovation paves the way forward.</p>
                    </div>
                </div>

                <div class="text-center">
    <a class="btn btn-primary" href="/login">Login</a>
    <a class="btn btn-secondary" href="/registeration">Register</a>
</div>

            </div>
        </div>
    </div>
</body>

</html>
