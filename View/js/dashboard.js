    // Toggle sidebar
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });

    // Sales Chart
    var ctx = document.getElementById("salesChart");
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Sales ($)",
                lineTension: 0.3,
                backgroundColor: "rgba(233, 30, 99, 0.05)",
                borderColor: "rgba(233, 30, 99, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(233, 30, 99, 1)",
                pointBorderColor: "rgba(233, 30, 99, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(233, 30, 99, 1)",
                pointHoverBorderColor: "rgba(233, 30, 99, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [1250, 1900, 2100, 2800, 2200, 2500, 2900, 3200, 3500, 3000, 3800, 4200],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return '$' + value;
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': $' + tooltipItem.yLabel;
                    }
                }
            }
        }
    });

    // Revenue Chart
    var ctx2 = document.getElementById("revenueChart");
    var revenueChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ["Prints", "Originals", "Commissions"],
            datasets: [{
                data: [55, 30, 15],
                backgroundColor: ['#4e73df', '#e83e8c', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#d81b60', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });