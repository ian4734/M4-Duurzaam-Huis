<div class="weather-widget">
    <h3>Weather forecast</h3>
    <div id="weather-data">
        <p>Laden...</p>
    </div>
</div>

<script>
const apiKey = '26cf474345852c86a57589e7d02d686f'; 
const lat = 52.37;
const lon = 4.89;
const url = `https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric&lang=nl`;

fetch(url)
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('weather-data');
        container.innerHTML = '<h4>5-daagse voorspelling:</h4>';

        data.list.filter(item => item.dt_txt.includes("12:00:00")).forEach(day => {
            const date = new Date(day.dt_txt).toLocaleDateString('nl-NL', { weekday: 'long' });
            container.innerHTML += `
                <div class="weather-row">
                    <span>${date}</span>
                    <span>${Math.round(day.main.temp)}°C</span>
                    <span>${day.weather[0].description}</span>
                </div>`;
        });
    });
</script>
<div class="ian">
    <p>Ian</p>
</div>