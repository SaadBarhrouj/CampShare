<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
        ul {
            list-style-type: disc;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>En utilisant CampShare, vous acceptez les conditions suivantes :</p>
    <ul>
        @foreach ($content as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>
    <p><i>Pour toute question, contactez notre support client.</i></p>
</body>
</html>
