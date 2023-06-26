<?php
$weather = '';
$error = '';

if (array_key_exists('submit', $_GET)) {
    //check if the user has entered a city
    if (!$_GET['city']) {
        $error = "City is required";
    }
    if ($_GET['city']) {
        $apiData = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=" . $_GET['city'] . "&appid=APIKEY");
        $weatherArray = json_decode($apiData, true);
        if ($weatherArray['cod'] == 200) {
            //print_r($weatherArray);
            //c = k-273.15
            $tempCelsius = $weatherArray['main']['temp'] - 273.15;
            $weather = "<b>" . $weatherArray['name'] . "," . $weatherArray['sys']['country'] . ":" . intval($tempCelsius) . "&deg;c" . "</b><br>";
            $weather .= "<b> Weather Condition : </b>" . $weatherArray['weather']['0']['description'] . "<br>";
            $weather .= "<b> Atmospertic Pressure : </b>" . $weatherArray['main']['pressure'] . "<br>";
            $weather .= "<b>Wind Speed : </b>" . $weatherArray['wind']['speed'] . "meter/sec<br>";
            $weather .= "<b> Cloudness : </b>" . $weatherArray['clouds']['all'] . "<br>";
            date_default_timezone_set('Asia/Colombo');
            $sunrise = $weatherArray['sys']['sunrise'];
            $weather .= "<b> Sunrise : </b>" . date('g:i:a', $sunrise) . "<br>";
            $weather .= "<b>Current Time : </b>" . date('F j, Y, g:i:a');
        } else {
            $error = "City not found";
        }
    }
}

?>




<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        body {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            background-image: url(weather.jpg);
            color: black;
            background-size: cover;
            background-attachment: fixed;
            font-family: poppin, 'Times New Roman', Times, serif;
            font-size: large;
        }

        .container {
            text-align: center;
            justify-content: center;
            align-items: center;
            width: 440px;
        }

        h1 {
            font-weight: 700;
            margin-top: 150px;
        }

        input {
            width: 350px;
            padding: 5px;
        }

        .cityLabel {
            color: grey;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Search Weather</h1>
        <form action="" method="GET">
            <label class="cityLabel" for="city">Enter your city name</label>
            <p><input type="text" name="city" id="city" placeholder="City Name"></p>
            <button type="submit" name="submit" class="btn btn-success">Submit Now</button>
            <div class="output mt-3">
                <?php

                if ($weather) {
                    echo '<div class="alert alert-success" role="alert">' . $weather . '</div>';
                }
                if ($error) {
                    echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                }
                ?>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>