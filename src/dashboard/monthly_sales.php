<div class="card chart-card">
    <div class="card-header">
        <h3>Monthly Sales Overview</h3>
    </div>
    <div class="chart-container">
        <canvas id="chart"></canvas>
    </div>
</div>

<script>
    // Fetch monthly sales for Chart.js
    fetch('db/fetch_data.php')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(item => item.month);
            const totals = data.map(item => parseFloat(item.total));

            new Chart(document.getElementById('chart'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Monthly Sales',
                        data: totals,
                        backgroundColor: 'rgba(37, 99, 235, 0.2)',
                        borderColor: 'rgba(37, 99, 235, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return '₱' + context.raw.toLocaleString('en-PH', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString('en-PH');
                                }
                            }
                        },
                        x: {
                            ticks: {
                                autoSkip: false
                            }
                        }
                    }
                }
            });
        })
        .catch(err => console.error('Error fetching monthly sales:', err));
</script>