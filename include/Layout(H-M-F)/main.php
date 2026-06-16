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
<?php include 'include/Dashboard-include/energieverbruik.php';?>
<<<<<<< HEAD
<?php include 'include/Dashboard-include/Darkmode.php';?>
=======
<?php include 'include/Dashboard-include/lampen.php';?>
>>>>>>> 5c4c09e5b4de63ac9be724b5c54e0ec1f106c4dc

    </section>
</main>