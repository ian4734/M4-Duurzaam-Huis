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
        
<div class="parent">
    <div class="div1">
<?php include 'include/Dashboard-include/Weather.php'; ?></div>
    <div class="div2">
<?php include 'include/Dashboard-include/buiten-temp.php';?></div>
    <div class="div3">
<?php include 'include/Dashboard-include/sunset-sunrise.php';?></div>
    <div class="div4">
<?php include 'include/Dashboard-include/Sun-energie.php';?></div>
    <div class="div5">
<?php include 'include/Dashboard-include/energieverbruik.php';?></div>
    <div class="div6">
  
<?php include 'include/Dashboard-include/lampen.php';?></div>

</div>

    </section>
</main>