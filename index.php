<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard-Duurzaam</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="buiten-temp.css">
</head>
<body>
    <header <div class="darkmode"><?php include 'include/dashboard/Darkmode.php'; ?></div>
            class="header"> <?php include 'include/header.php'; ?>      
    </header>

    <?php include 'include/dashboard/sidebar.php'; ?>
    <?php include 'include/dashboard/buiten-temp.php'; ?>
    <?php include 'include/dashboard/sunset-sunrise.php'; ?>
    <?php include 'include/dashboard/weatherforecast.php'; ?>
    <?php include 'include/dashboard/zonnepanelen.php'; ?>
    <?php include 'include/dashboard/energie.php'; ?>
    <?php include 'include/dashboard/lampen.php'; ?>
    
</body> 
<footer class="footer"><?php include 'include/footer.php'; ?></div>
</html>


