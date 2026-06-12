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

        <main class="dashboard-content">
            <?php include 'include/dashboard/buiten-temp.php'; ?>
            <?php include 'include/dashboard/sunset-sunrise.php'; ?>
            <?php include 'include/dashboard/weatherforecast.php'; ?>
            <?php include 'include/dashboard/zonnepanelen.php'; ?>
            <?php include 'include/dashboard/energie.php'; ?>
            <?php include 'include/dashboard/lampen.php'; ?>
        </main>
    </div>

    <footer class="footer"><?php include 'include/footer.php'; ?></footer>
</div>
</body> 
</html>

