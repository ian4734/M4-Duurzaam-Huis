<main>
    <aside class="sidebar">
        <h1>Dashboard</h1>
        <nav>
            <ul>
                <li>Home</li>
                <li>Time</li>
                <li>Temperature</li>
                <li>Weather</li>
                <li>Dawn & Dusk</li>
                <li>Sunpanels</li>
            </ul>
        </nav>
    </aside>
    <section class="dashbaord-content">
<?php include 'include/Dashboard-include/Weather.php'; ?>
<?php include 'include/Dashboard-include/Sun-energie.php';?>
<?php include 'include/Dashboard-include/buiten-temp.php';?>
<?php include 'include/Dashboard-include/sunset-sunrise.php';?>

    </section>
</main>