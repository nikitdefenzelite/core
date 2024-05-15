<!-- resources/views/503.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 Service Unavailable</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            /* Full height of the viewport */
            margin: 0;
            /* Remove default margin */
        }

        .content {
            text-align: center;
        }

        img {
            width: 100%;
            max-width: 600px;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="content">
        <img src="{{ asset('path/to/503-image.jpg') }}" alt="503 Service Unavailable">
        <p>Sorry, the service is temporarily unavailable. Please try again later.</p>
        <a href="{{ url('/') }}">Back to Home</a>
    </div>
</body>

</html>
