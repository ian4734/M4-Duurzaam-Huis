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
    <div class="header">
        <?php include 'include/header.php'; ?>
    </div>
    <div class="sidebar">
        <p>sidebar</p>
    </div>
    <div class="temprature">
        <p>temprature</p>
    </div>
    <div class="susetsunrise">
        <?php include 'include/dashboard/sunset-sunrise.php'; ?>
    </div>
    <div class="weatherforecast">
        <p>weather forecast</p>
    </div>
    <div class="zonnepanelen">
        <p>Opbrengst energie van zonnepanelen</p>
    </div>
    <div class="energie">
        <p>Energie verbruik</p>
    </div>
    <div class="lampen">
        <p>Huis met lampen enzo</p>
    </div>
    <div class="footer">
     <?php include 'include/footer.php'; ?>
    </div>
</div>
</body> 
</html>


