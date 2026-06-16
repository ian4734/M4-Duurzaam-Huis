<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section class="dashboard-content">
    <div class="chart-container" style="position: relative; width: 400px; height: 300px;">
        <canvas id="energieverbuik"></canvas>
    </div>
</section>

<script>
const ctx = document.getElementById('energieverbuik').getContext('2d');
const energieverbuik = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'],
        datasets: [{
            label: 'verbruik (kWh)',
            data: [14, 12, 5, 15, 20, 30, 3],
            backgroundColor: '#9EDE8C'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>