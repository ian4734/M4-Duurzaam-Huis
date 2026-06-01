<?php
function getSunTimes(float $lat, float $lon, string $date): array {
    $timestamp = strtotime($date);
    $dayOfYear = (int)date('z', $timestamp) + 1;
    $year      = (int)date('Y', $timestamp);
 
    $JD = julianDate($year, (int)date('n', $timestamp), (int)date('j', $timestamp));
 
    $T = ($JD - 2451545.0) / 36525.0;
 
    $L0 = fmod(280.46646 + $T * (36000.76983 + $T * 0.0003032), 360);
 
    $M = 357.52911 + $T * (35999.05029 - 0.0001537 * $T);
 
    $Mrad = deg2rad($M);
    $C = sin($Mrad) * (1.914602 - $T * (0.004817 + 0.000014 * $T))
       + sin(2 * $Mrad) * (0.019993 - 0.000101 * $T)
       + sin(3 * $Mrad) * 0.000289;
 
    $sunLon = $L0 + $C;
 
    $omega = 125.04 - 1934.136 * $T;
    $lambda = $sunLon - 0.00569 - 0.00478 * sin(deg2rad($omega));
 
    $e0 = 23.0 + (26.0 + (21.448 - $T * (46.8150 + $T * (0.00059 - $T * 0.001813))) / 60.0) / 60.0;
    $e  = $e0 + 0.00256 * cos(deg2rad($omega));
 
    $sinDec = sin(deg2rad($e)) * sin(deg2rad($lambda));
    $dec    = rad2deg(asin($sinDec));
 
    $y = tan(deg2rad($e / 2)) ** 2;
    $L0rad = deg2rad($L0);
    $Mrad2 = deg2rad($M);
    $EqT = 4 * rad2deg(
        $y * sin(2 * $L0rad)
        - 2 * 0.016708634 * sin($Mrad2)
        + 4 * 0.016708634 * $y * sin($Mrad2) * cos(2 * $L0rad)
        - 0.5 * $y * $y * sin(4 * $L0rad)
        - 1.25 * 0.016708634 ** 2 * sin(2 * $Mrad2)
    );
 
    $latRad  = deg2rad($lat);
    $decRad  = deg2rad($dec);
    $cosHA   = (cos(deg2rad(90.833)) / (cos($latRad) * cos($decRad))) - tan($latRad) * tan($decRad);
 
    if ($cosHA < -1 || $cosHA > 1) {
        return ['sunrise' => null, 'sunset' => null, 'solar_noon' => null];
    }
 
    $HA = rad2deg(acos($cosHA));
 
    $solarNoonUTC = (720 - 4 * $lon - $EqT);
    $sunriseUTC   = $solarNoonUTC - $HA * 4;
    $sunsetUTC    = $solarNoonUTC + $HA * 4;
 
    $tzOffset = getTimezoneOffsetMinutes($lat, $lon, $date);
 
    return [
        'sunrise'    => minutesToTime($sunriseUTC + $tzOffset),
        'sunset'     => minutesToTime($sunsetUTC  + $tzOffset),
        'solar_noon' => minutesToTime($solarNoonUTC + $tzOffset),
        'day_length' => minutesToDuration($HA * 8),
    ];
}
 
function julianDate(int $year, int $month, int $day): float {
    if ($month <= 2) { $year--; $month += 12; }
    $A = floor($year / 100);
    $B = 2 - $A + floor($A / 4);
    return floor(365.25 * ($year + 4716)) + floor(30.6001 * ($month + 1)) + $day + $B - 1524.5;
}
 
function minutesToTime(float $minutes): string {
    $minutes = fmod($minutes + 1440, 1440);
    $h = floor($minutes / 60);
    $m = floor(fmod($minutes, 60));
    $s = round(($minutes - floor($minutes)) * 60);
    $ampm = $h >= 12 ? 'PM' : 'AM';
    $h12  = $h % 12 ?: 12;
    return sprintf('%d:%02d:%02d %s', $h12, $m, $s, $ampm);
}
 
function minutesToDuration(float $minutes): string {
    $h = floor($minutes / 60);
    $m = floor(fmod($minutes, 60));
    return sprintf('%dh %02dm', $h, $m);
}
 
function getTimezoneOffsetMinutes(float $lat, float $lon, string $date): int {
    return (int)round($lon / 15) * 60;
}
 
$lat    = isset($_GET['lat'])  ? (float)$_GET['lat']  : 52.3676;
$lon    = isset($_GET['lon'])  ? (float)$_GET['lon']  : 4.9041;
$date   = isset($_GET['date']) ? $_GET['date']         : date('Y-m-d');
$city   = isset($_GET['city']) ? htmlspecialchars($_GET['city']) : 'Amsterdam';
$tzOff  = isset($_GET['tz'])   ? (int)$_GET['tz']     : 120; // minutes offset
 
$times  = getSunTimes($lat, $lon, $date);
 
function getSunTimesWithTZ(float $lat, float $lon, string $date, int $tzMinutes): array {
    $timestamp = strtotime($date);
    $year  = (int)date('Y', $timestamp);
    $month = (int)date('n', $timestamp);
    $day   = (int)date('j', $timestamp);
 
    $JD  = julianDate($year, $month, $day);
    $T   = ($JD - 2451545.0) / 36525.0;
    $L0  = fmod(280.46646 + $T * (36000.76983 + $T * 0.0003032), 360);
    $M   = 357.52911 + $T * (35999.05029 - 0.0001537 * $T);
    $Mrad = deg2rad($M);
    $C   = sin($Mrad)*(1.914602-$T*(0.004817+0.000014*$T))
          +sin(2*$Mrad)*(0.019993-0.000101*$T)
          +sin(3*$Mrad)*0.000289;
    $sunLon = $L0 + $C;
    $omega  = 125.04 - 1934.136 * $T;
    $lambda = $sunLon - 0.00569 - 0.00478 * sin(deg2rad($omega));
    $e0 = 23.0+(26.0+(21.448-$T*(46.8150+$T*(0.00059-$T*0.001813)))/60.0)/60.0;
    $e  = $e0 + 0.00256 * cos(deg2rad($omega));
    $sinDec = sin(deg2rad($e)) * sin(deg2rad($lambda));
    $dec    = rad2deg(asin($sinDec));
    $y      = tan(deg2rad($e/2))**2;
    $L0r    = deg2rad($L0);
    $Mr2    = deg2rad($M);
    $EqT    = 4*rad2deg($y*sin(2*$L0r)-2*0.016708634*sin($Mr2)
              +4*0.016708634*$y*sin($Mr2)*cos(2*$L0r)
              -0.5*$y*$y*sin(4*$L0r)
              -1.25*0.016708634**2*sin(2*$Mr2));
    $latRad = deg2rad($lat);
    $decRad = deg2rad($dec);
    $cosHA  = (cos(deg2rad(90.833))/(cos($latRad)*cos($decRad)))-tan($latRad)*tan($decRad);
 
    if ($cosHA < -1 || $cosHA > 1) {
        return ['sunrise'=>'--:--','sunset'=>'--:--','solar_noon'=>'--:--','day_length'=>'N/A'];
    }
 
    $HA           = rad2deg(acos($cosHA));
    $solarNoonUTC = 720 - 4*$lon - $EqT;
    $sunriseUTC   = $solarNoonUTC - $HA*4;
    $sunsetUTC    = $solarNoonUTC + $HA*4;
 
    return [
        'sunrise'    => minutesToTime($sunriseUTC  + $tzMinutes),
        'sunset'     => minutesToTime($sunsetUTC   + $tzMinutes),
        'solar_noon' => minutesToTime($solarNoonUTC + $tzMinutes),
        'day_length' => minutesToDuration($HA*8),
        'declination'=> round($dec, 2),
    ];
}
 
$times = getSunTimesWithTZ($lat, $lon, $date, $tzOff);
$displayDate = date('l, F j, Y', strtotime($date));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sun Times — <?= $city ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300&family=Inconsolata:wght@300;400&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
  :root {
    --dawn:   #f4a26b;
    --dusk:   #c0627a;
    --sky:    #1a1025;
    --gold:   #e8c97e;
    --mist:   rgba(255,255,255,0.07);
    --text:   #f0e8df;
    --dim:    rgba(240,232,223,0.45);
  }
 
  body {
    min-height: 100vh;
    background: var(--sky);
    background-image:
      radial-gradient(ellipse 80% 50% at 20% 110%, rgba(244,162,107,0.18) 0%, transparent 60%),
      radial-gradient(ellipse 60% 40% at 80% 110%, rgba(192,98,122,0.15) 0%, transparent 60%),
      radial-gradient(ellipse 40% 30% at 50% 0%,   rgba(232,201,126,0.06) 0%, transparent 50%);
    color: var(--text);
    font-family: 'Inconsolata', monospace;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    overflow-x: hidden;
  }
 
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
      radial-gradient(1px 1px at 10% 15%, rgba(255,255,255,0.6) 0%, transparent 100%),
      radial-gradient(1px 1px at 25% 8%,  rgba(255,255,255,0.4) 0%, transparent 100%),
      radial-gradient(1px 1px at 45% 20%, rgba(255,255,255,0.5) 0%, transparent 100%),
      radial-gradient(1px 1px at 65% 5%,  rgba(255,255,255,0.3) 0%, transparent 100%),
      radial-gradient(1px 1px at 80% 18%, rgba(255,255,255,0.6) 0%, transparent 100%),
      radial-gradient(1px 1px at 92% 10%, rgba(255,255,255,0.4) 0%, transparent 100%),
      radial-gradient(1px 1px at 35% 3%,  rgba(255,255,255,0.5) 0%, transparent 100%),
      radial-gradient(1px 1px at 55% 12%, rgba(255,255,255,0.3) 0%, transparent 100%),
      radial-gradient(1px 1px at 72% 25%, rgba(255,255,255,0.4) 0%, transparent 100%),
      radial-gradient(1px 1px at 15% 30%, rgba(255,255,255,0.3) 0%, transparent 100%);
    pointer-events: none;
    z-index: 0;
  }
 
  .card {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 560px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 2px;
    padding: 2.5rem 2.5rem 2rem;
    backdrop-filter: blur(12px);
  }
 
  .header { text-align: center; margin-bottom: 2rem; }
 
  .sun-icon {
    display: block;
    margin: 0 auto 1rem;
    animation: slow-spin 60s linear infinite;
  }
  @keyframes slow-spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
  }
 
  h1 {
    font-family: 'Cormorant Garamond', serif;
    font-weight: 300;
    font-size: 2.4rem;
    letter-spacing: 0.08em;
    color: var(--gold);
    line-height: 1;
  }
  h1 em { font-style: italic; color: var(--dawn); }
 
  .date-label {
    margin-top: 0.4rem;
    font-size: 0.75rem;
    letter-spacing: 0.15em;
    color: var(--dim);
    text-transform: uppercase;
  }
 
  .horizon {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    margin: 2rem 0;
  }
 
  .sun-event {
    flex: 1;
    text-align: center;
    padding: 1.2rem 0.8rem;
    border: 1px solid rgba(255,255,255,0.08);
    background: var(--mist);
    border-radius: 2px;
    position: relative;
    overflow: hidden;
  }
  .sun-event::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
  }
  .sun-event.rise::before  { background: linear-gradient(90deg, transparent, var(--dawn), transparent); }
  .sun-event.set::before   { background: linear-gradient(90deg, transparent, var(--dusk), transparent); }
 
  .event-label {
    font-size: 0.65rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--dim);
    margin-bottom: 0.5rem;
  }
  .event-time {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.9rem;
    font-weight: 300;
    letter-spacing: 0.02em;
  }
  .rise .event-time { color: var(--dawn); }
  .set  .event-time { color: var(--dusk); }
 
  .divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    margin: 1.5rem 0;
  }
 
  .meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.8rem;
  }
  .meta-item {
    padding: 0.7rem 0.9rem;
    background: var(--mist);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 2px;
  }
  .meta-item .label {
    font-size: 0.6rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--dim);
    margin-bottom: 0.25rem;
  }
  .meta-item .value {
    font-size: 1rem;
    color: var(--gold);
    letter-spacing: 0.05em;
  }
 
  .divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,.1), transparent); margin: 1.5rem 0; }
 
  /* Form */
  .lookup-form { margin-top: 1.8rem; }
  .lookup-form h2 {
    font-family: 'Cormorant Garamond', serif;
    font-weight: 300;
    font-size: 1rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--dim);
    margin-bottom: 1rem;
  }
 
  .form-row { display: flex; gap: 0.6rem; flex-wrap: wrap; margin-bottom: 0.6rem; }
 
  label { display: flex; flex-direction: column; gap: 0.25rem; flex: 1; min-width: 100px; }
  label span {
    font-size: 0.6rem;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--dim);
  }
  input[type=text], input[type=number], input[type=date] {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 2px;
    color: var(--text);
    font-family: 'Inconsolata', monospace;
    font-size: 0.9rem;
    padding: 0.45rem 0.6rem;
    outline: none;
    transition: border-color 0.2s;
    width: 100%;
  }
  input:focus { border-color: var(--gold); }
 
  button {
    width: 100%;
    margin-top: 0.8rem;
    padding: 0.7rem;
    background: linear-gradient(135deg, rgba(244,162,107,0.2), rgba(192,98,122,0.2));
    border: 1px solid rgba(232,201,126,0.3);
    border-radius: 2px;
    color: var(--gold);
    font-family: 'Inconsolata', monospace;
    font-size: 0.85rem;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s;
  }
  button:hover { background: linear-gradient(135deg, rgba(244,162,107,0.35), rgba(192,98,122,0.35)); }
 
  .coords { text-align: center; margin-top: 1.2rem; font-size: 0.65rem; color: var(--dim); letter-spacing: 0.1em; }
</style>
</head>
<body>
 
<div class="card">
  <div class="header">
    <!-- Animated sun SVG -->
    <svg class="sun-icon" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="24" cy="24" r="9" stroke="#e8c97e" stroke-width="1.2" fill="none"/>
      <?php
        for ($i = 0; $i < 12; $i++) {
            $angle = $i * 30;
            $rad   = deg2rad($angle);
            $x1    = 24 + cos($rad) * 13;
            $y1    = 24 + sin($rad) * 13;
            $x2    = 24 + cos($rad) * 17;
            $y2    = 24 + sin($rad) * 17;
            echo "<line x1=\"$x1\" y1=\"$y1\" x2=\"$x2\" y2=\"$y2\" stroke=\"#e8c97e\" stroke-width=\"1.2\" stroke-linecap=\"round\"/>\n";
        }
      ?>
    </svg>
 
    <h1><?= $city ?><br><em>Sun Times</em></h1>
    <div class="date-label"><?= $displayDate ?></div>
  </div>
 
  <div class="horizon">
    <div class="sun-event rise">
      <div class="event-label">☀ Sunrise</div>
      <div class="event-time"><?= $times['sunrise'] ?? '--:--' ?></div>
    </div>
    <div class="sun-event set">
      <div class="event-label">Sunset ☽</div>
      <div class="event-time"><?= $times['sunset'] ?? '--:--' ?></div>
    </div>
  </div>
 
  <div class="meta-grid">
    <div class="meta-item">
      <div class="label">Solar Noon</div>
      <div class="value"><?= $times['solar_noon'] ?? '--' ?></div>
    </div>
    <div class="meta-item">
      <div class="label">Day Length</div>
      <div class="value"><?= $times['day_length'] ?? '--' ?></div>
    </div>
    <div class="meta-item">
      <div class="label">Latitude</div>
      <div class="value"><?= round($lat, 4) ?>°</div>
    </div>
    <div class="meta-item">
      <div class="label">Longitude</div>
      <div class="value"><?= round($lon, 4) ?>°</div>
    </div>
  </div>
 
  <div class="divider"></div>
 
  <!-- Lookup form -->
  <div class="lookup-form">
    <h2>Look up another location</h2>
    <form method="GET">
      <div class="form-row">
        <label>
          <span>City name</span>
          <input type="text" name="city" value="<?= htmlspecialchars($city) ?>" placeholder="Amsterdam">
        </label>
        <label>
          <span>Date</span>
          <input type="date" name="date" value="<?= $date ?>">
        </label>
      </div>
      <div class="form-row">
        <label>
          <span>Latitude</span>
          <input type="number" name="lat" value="<?= $lat ?>" step="0.0001" placeholder="52.3676">
        </label>
        <label>
          <span>Longitude</span>
          <input type="number" name="lon" value="<?= $lon ?>" step="0.0001" placeholder="4.9041">
        </label>
        <label>
          <span>TZ offset (min)</span>
          <input type="number" name="tz" value="<?= $tzOff ?>" step="30" placeholder="60">
        </label>
      </div>
      <button type="submit">Calculate Sun Times</button>
    </form>
  </div>
 
  <div class="coords">
    Calculated using NOAA Solar Algorithm &nbsp;·&nbsp; Times in local time
  </div>
</div>
 

<footer>deon</footer>
</body>
</html>