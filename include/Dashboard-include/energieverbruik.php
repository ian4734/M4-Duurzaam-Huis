<section class="dashboard-content">
    <div class="chart-container" style="position: relative; width: 400px; height: 300px;">
        <canvas id="energieverbuik"></canvas>
    </div>
</section>

<script>
const ctx2 = document.getElementById('energieverbuik').getContext('2d');
const energieverbuik = new Chart(ctx2, {
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
<p> deon </p>