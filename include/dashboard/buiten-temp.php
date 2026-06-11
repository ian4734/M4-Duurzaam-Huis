<?php 

$url = "https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current=temperature_2m";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);

$data = json_decode($response, true);
$temperature = $data['current']['temperature_2m'];


?>

<body>
    <div class="temperature">
        <h2>Buiten temperatuur</h2>
        <p><?php echo $temperature; ?>°C</p>
        <h2>Binnen temperatuur</h2>
        <p>22°C</p>
    </div>
</body>