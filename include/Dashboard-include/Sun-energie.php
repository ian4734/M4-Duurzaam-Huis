<section class="dashboard-content">
    <div class="chart-container" style="position: relative; width: 400px; height: 300px;">
        <canvas id="zonnePanelenGrafiek"></canvas>
    </div>
</section>

<script>
const ctx1 = document.getElementById('zonnePanelenGrafiek').getContext('2d');
const zonnePanelenGrafiek = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'],
        datasets: [{
            label: 'Opbrengst (kWh)',
            data: [12, 19, 3, 5, 2, 3, 7],
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