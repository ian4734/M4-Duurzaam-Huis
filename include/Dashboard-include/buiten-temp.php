<?php 

$url = "https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current=temperature_2m";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);

$data = json_decode($response, true);
$temperature = $data['current']['temperature_2m'];


?>


<div class="temperature">
    <h2 class="tempTest">Buiten temperatuur</h2>
    <p class="tempTest"><?php echo $temperature; ?>°C</p>
    <h2 class="tempTest">Binnen temperatuur</h2>
    <pc class="tempTest">22°C</p>
</div>

<div class="kyano">
    <p>kyano</p>
</div>
