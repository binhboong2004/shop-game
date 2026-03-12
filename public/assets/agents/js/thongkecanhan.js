document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;

    Chart.defaults.color = '#9ca3af';
    Chart.defaults.font.family = "'Be Vietnam Pro', sans-serif";

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: [1200000, 2500000, 1500000, 3800000, 1100000, 2100000, 4800000],
                borderColor: '#E70814',
                backgroundColor: 'rgba(231, 8, 20, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#20222a',
                pointBorderColor: '#E70814',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1a1c23',
                    titleColor: '#ffffff',
                    bodyColor: '#e5e7eb',
                    borderColor: '#404452',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.05)',
                        drawBorder: false,
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        callback: function(value, index, values) {
                            if (value >= 1000000) {
                                return (value / 1000000) + 'M';
                            }
                            return value;
                        },
                        padding: 10,
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        padding: 10,
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    });
});
