<p>Energie verbruik</p>


<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function loadAndDrawChart() {
        fetch('include/gas.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Netwerk fout');
                }
                return response.json();
            })
            .then(jsonData => {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Naam');
    data.addColumn('number', 'Waarde');

    jsonData.forEach(item => {
        data.addRow([item.naam, item.verbruik]);
        console.log(`toegevoegd: ${item.datum} - ${item.verbruik}`);
    });

    var options = {'title': 'gasverbruik'};
    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);
    })
    .catch(error => console.error('Fout bij het laden data:', error));
}

</script>