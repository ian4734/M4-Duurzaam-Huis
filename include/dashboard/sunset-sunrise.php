<?php
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
?>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  .wrap { width: 100%; max-width: 520px; }
 
  .cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 1.25rem;
  }
 
  .card {
    background: #fff;
    border: 1px solid #e5e5e3;
    border-radius: 12px;
    padding: 1.25rem 1rem;
    text-align: center;
  }
 
  .card-label {
    font-size: 11px;
    color: #888;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: 8px;
  }
 
  .card-time {
    font-size: 26px;
    font-weight: 500;
    color: #1a1a1a;
  }
 
  .card-sub {
    font-size: 11px;
    color: #aaa;
    margin-top: 4px;
    min-height: 16px;
  }
 
  .field { display: flex; flex-direction: column; gap: 5px; }
 
  .field label { font-size: 12px; color: #666; }
 
  .field input {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    background: #fff;
    color: #1a1a1a;
    outline: none;
    transition: border-color .15s;
  }
 
  .field input:focus { border-color: #888; }
 
  .status {
    font-size: 12px;
    color: #aaa;
    margin-top: .75rem;
    text-align: center;
  }




</style>

<div class="wrap">
  <div class="cards">
    <div class="card">
      <div class="card-label">Sunrise</div>
      <div class="card-time" id="s-rise">--:--</div>
      <div class="card-sub" id="s-rise-sub">&nbsp;</div>
    </div>
    <div class="card">
      <div class="card-label">Day length</div>
      <div class="card-time" id="s-len">--</div>
      <div class="card-sub">hours of daylight</div>
    </div>
    <div class="card">
      <div class="card-label">Sunset</div>
      <div class="card-time" id="s-set">--:--</div>
      <div class="card-sub">&nbsp;</div>
    </div>
  </div>
 
  <div class="field">
    <label>Datum</label>
    <input type="date" id="date" value="<?= htmlspecialchars($date) ?>">
  </div>
  <div class="status" id="status">Locatie ophalen...</div>
</div>
 
<script>
  const $ = id => document.getElementById(id);
  let LAT = null, LON = null, TZ = null;
 
  function fmod(a, b) { return a - Math.floor(a / b) * b; }
 
  function jd(y, m, d) {
    if (m <= 2) { y--; m += 12; }
    const A = Math.floor(y / 100);
    return Math.floor(365.25*(y+4716)) + Math.floor(30.6001*(m+1)) + d + (2-A+Math.floor(A/4)) - 1524.5;
  }
 
  function toTime(min) {
    min = fmod(min + 1440, 1440);
    const h = Math.floor(min / 60), m = Math.floor(fmod(min, 60));
    return `${h%12||12}:${String(m).padStart(2,'0')} ${h>=12?'pm':'am'}`;
  }
 
  function calcSun(lat, lon, dateStr, tzMin) {
    const ts = new Date(dateStr);
    const y = ts.getUTCFullYear(), m = ts.getUTCMonth()+1, d = ts.getUTCDate();
    const J = (jd(y,m,d) - 2451545) / 36525;
    const L0 = fmod(280.46646 + J*(36000.76983 + J*0.0003032), 360);
    const M  = 357.52911 + J*(35999.05029 - 0.0001537*J);
    const Mr = M * Math.PI/180;
    const C  = Math.sin(Mr)*(1.914602-J*(0.004817+0.000014*J))
             + Math.sin(2*Mr)*(0.019993-0.000101*J)
             + Math.sin(3*Mr)*0.000289;
    const om = 125.04 - 1934.136*J;
    const lm = L0+C - 0.00569 - 0.00478*Math.sin(om*Math.PI/180);
    const e  = (23+(26+(21.448-J*(46.815+J*(0.00059-J*0.001813)))/60)/60) + 0.00256*Math.cos(om*Math.PI/180);
    const dec = Math.asin(Math.sin(e*Math.PI/180)*Math.sin(lm*Math.PI/180)) * 180/Math.PI;
    const y2  = Math.tan(e*Math.PI/360)**2;
    const L0r = L0*Math.PI/180, Mr2 = M*Math.PI/180;
    const EqT = 4*(180/Math.PI)*(
        y2*Math.sin(2*L0r)
      - 2*0.016708634*Math.sin(Mr2)
      + 4*0.016708634*y2*Math.sin(Mr2)*Math.cos(2*L0r)
      - 0.5*y2**2*Math.sin(4*L0r)
      - 1.25*0.016708634**2*Math.sin(2*Mr2)
    );
    const lr = lat*Math.PI/180, dr = dec*Math.PI/180;
    const cosHA = Math.cos(90.833*Math.PI/180)/(Math.cos(lr)*Math.cos(dr)) - Math.tan(lr)*Math.tan(dr);
    if (cosHA < -1 || cosHA > 1) return null;
    const HA   = Math.acos(cosHA)*180/Math.PI;
    const noon = 720 - 4*lon - EqT;
    return { rise: noon-HA*4+tzMin, set: noon+HA*4+tzMin, noon: noon+tzMin };
  }
 
  function update() {
    if (LAT === null || !$('date').value) return;
    const sun = calcSun(LAT, LON, $('date').value, TZ);
    if (sun) {
      $('s-rise').textContent = toTime(sun.rise);
      $('s-set').textContent  = toTime(sun.set);
      const len = sun.set - sun.rise;
      $('s-len').textContent  = `${Math.floor(len/60)}h ${Math.round(len%60)}m`;
      $('s-rise-sub').textContent = 'noon ' + toTime(sun.noon);
    } else {
      $('s-rise').textContent = $('s-set').textContent = $('s-len').textContent = 'N/A';
      $('s-rise-sub').textContent = '';
    }
  }

  $('date').addEventListener('input', update);

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(pos => {
      LAT = pos.coords.latitude;
      LON = pos.coords.longitude;
      TZ  = -new Date().getTimezoneOffset();
      $('status').textContent = `${LAT.toFixed(2)}° N, ${LON.toFixed(2)}° E`;
      update();
    }, () => {
      LAT = 52.3676; LON = 4.9041; TZ = 120;
      $('status').textContent = 'Locatie niet beschikbaar — Amsterdam gebruikt';
      update();
    });
  } else {
    LAT = 52.3676; LON = 4.9041; TZ = 120;
    $('status').textContent = 'locatie niet beschikbaar — Amsterdam gebruikt';
    update();
  }
</script>
<footer>
  <p> deon </p>
</footer>
</html>

