<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div>
  <canvas id="myChart"></canvas>
</div>
<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'],
      datasets: [{
        label: 'Durchschnitt Temperatur',
        data: [12, 19, 3, 5, 2, 3, 10],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>