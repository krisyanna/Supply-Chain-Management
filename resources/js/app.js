import './bootstrap';
import Chart from 'chart.js/auto';

const inventoryChart = document.getElementById('inventoryChart');

if (inventoryChart) {
    new Chart(inventoryChart, {
        type: 'doughnut',
        data: {
            labels: ['In stock', 'Restocked', 'Low Stock', 'Out of Stock', 'Reserved'],
            datasets: [{
                data: [72, 10, 12, 3, 3],
                backgroundColor: [
                    '#045c3c',
                    '#35a52b',
                    '#d4c400',
                    '#ef2d2d',
                    '#2248b5'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '52%',
            plugins: {
                legend: {
                    position: 'left',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 18
                    }
                }
            }
        }
    });
}
