<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard-Duurzaam</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="parent">
        <div class="div1">
            <?php include "sidebar.php"; ?>
        </div>
        <div class="div2">
            <?php include "header.php"; ?>
        </div>
        <div class="div3">
            <?php include "temprature.php";?>
        </div>
        <div class="div4">
            <?php include "sunset-sunrise.php"; ?>
        </div> 
        <div class="div5">
            <?php include "house-light.php"; ?>
        </div>
        <div class="div6">
            <?php include "weather.php"; ?>
        </div>
        <div class="div12">
            <?php include "enegy-opbrengst-zonnenpanelen.php"; ?>
        </div>
        <div class="div13">
            <?php include 'energy-gebruik.php'; ?>
        </div>
    </div>
</body>
</html>