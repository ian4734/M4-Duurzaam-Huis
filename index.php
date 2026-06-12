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

<div class="page-container">
    <header><?php include 'include/header.php'; ?></header>

    <div class="main-wrapper">
        <aside class="sidebar">
            <?php include 'include/dashboard/sidebar.php'; ?>
        </aside>

        <main class="parent">
            <div class="temperature"><?php include 'include/dashboard/buiten-temp.php'; ?></div>
            <div class="sunsetsunrise"><?php include 'include/dashboard/sunset-sunrise.php'; ?></div>
            <div class="weatherforecast"><?php include 'include/dashboard/weatherforecast.php'; ?></div>
            <div class="zonnepanelen"><?php include 'include/dashboard/zonnepanelen.php'; ?></div>
            <div class="energie"><?php include 'include/dashboard/energie.php'; ?></div>
            <div class="lampen"><?php include 'include/dashboard/lampen.php'; ?></div>
            <div class="parent"></div>
            </main>

    </div>
    
    <footer class="footer"><?php include 'include/footer.php'; ?></div>
</body> 
<footer class="footer"><?php include 'include/footer.php'; ?></div>
</html>

