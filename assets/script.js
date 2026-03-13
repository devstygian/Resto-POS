const toggleBtn = document.getElementById('sidebar-toggle');
const sidebar = document.querySelector('.sidebar');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('show');
});

fetch('db/fetch_data.php')
    .then(res => res.json())
    .then(data => {

        const labels = data.map(item => item.month);
        const totals = data.map(item => item.total);

        new Chart(document.getElementById('chart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Sales',
                    data: totals,
                    tension: 0.4
                }]
            }
        });
    });

   