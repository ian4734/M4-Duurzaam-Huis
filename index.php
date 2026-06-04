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
        <?php include 'include/header.php'; ?>
    </div>
    <div class="div2">
        <p>sidebar</p>
    </div>
    <div class="div3">
        <p>temprature</p>
    </div>
    <div class="div4">
        <?php include 'include/dashboard/sunset-sunrise.php'; ?>
    </div>
    <div class="div5">
        <p>weather forecast</p>
    </div>
    <div class="div6">
        <p>Opbrengst energie van zonnepanelen</p>
    </div>
    <div class="div7">
        <p>Energie verbruik</p>
    </div>
    <div class="div8">
        <p>Huis met lampen enzo</p>
    </div>
</div>
    <?php include 'include/footer.php'; ?>
</body> 
</html>


