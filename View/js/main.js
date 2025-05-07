// View in Room functionality
document.addEventListener('DOMContentLoaded', function() {
    const artworkOverlay = document.getElementById('artworkOverlay');
    const artworkImage = document.getElementById('artworkImage');
    const roomBackground = document.getElementById('roomBackground');
    const changeRoomBtn = document.getElementById('changeRoomBtn');
    const uploadRoomBtn = document.getElementById('uploadRoomBtn');
    const resetBtn = document.getElementById('resetBtn');
    const sizeBtns = document.querySelectorAll('.size-btn');
    const frameOptions = document.querySelectorAll('.frame-option');
    const artworkThumbnails = document.querySelectorAll('.artwork-thumbnail');
    const roomStyles = document.querySelectorAll('.room-style');
    
    let isDragging = false;
    let offsetX, offsetY;
    
    // Make artwork draggable
    artworkOverlay.addEventListener('mousedown', startDrag);
    artworkOverlay.addEventListener('touchstart', startDrag);
    
    document.addEventListener('mousemove', drag);
    document.addEventListener('touchmove', drag);
    
    document.addEventListener('mouseup', endDrag);
    document.addEventListener('touchend', endDrag);
    
    function startDrag(e) {
        isDragging = true;
        
        if (e.type === 'mousedown') {
            offsetX = e.clientX - artworkOverlay.getBoundingClientRect().left;
            offsetY = e.clientY - artworkOverlay.getBoundingClientRect().top;
        } else {
            offsetX = e.touches[0].clientX - artworkOverlay.getBoundingClientRect().left;
            offsetY = e.touches[0].clientY - artworkOverlay.getBoundingClientRect().top;
        }
        
        e.preventDefault();
    }
    
    function drag(e) {
        if (!isDragging) return;
        
        const roomRect = roomBackground.getBoundingClientRect();
        let x, y;
        
        if (e.type === 'mousemove') {
            x = e.clientX - roomRect.left - offsetX;
            y = e.clientY - roomRect.top - offsetY;
        } else {
            x = e.touches[0].clientX - roomRect.left - offsetX;
            y = e.touches[0].clientY - roomRect.top - offsetY;
        }
        
        // Constrain to room boundaries
        x = Math.max(0, Math.min(x, roomRect.width - artworkOverlay.offsetWidth));
        y = Math.max(0, Math.min(y, roomRect.height - artworkOverlay.offsetHeight));
        
        artworkOverlay.style.left = x + 'px';
        artworkOverlay.style.top = y + 'px';
    }
    
    function endDrag() {
        isDragging = false;
    }
    
    // Size controls
    sizeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            sizeBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const size = this.dataset.size;
            artworkOverlay.className = 'artwork-overlay';
            artworkOverlay.classList.add(size);
        });
    });
    
    // Frame controls
    frameOptions.forEach(option => {
        option.addEventListener('click', function() {
            frameOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            const frame = this.dataset.frame;
            artworkImage.className = 'artwork-image';
            if (frame !== 'none') {
                artworkImage.classList.add(frame + '-frame');
            }
        });
    });
    
    // Artwork thumbnail controls
    artworkThumbnails.forEach(thumb => {
        thumb.addEventListener('click', function() {
            artworkThumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const artworkSrc = this.dataset.artwork;
            artworkImage.src = artworkSrc;
        });
    });
    
    // Room style controls
    roomStyles.forEach(style => {
        style.addEventListener('click', function() {
            const roomSrc = this.dataset.room;
            roomBackground.src = roomSrc;
            
            // Hide room options after selection
            document.querySelector('.room-options').style.display = 'none';
        });
    });
    
    // Change room button
    changeRoomBtn.addEventListener('click', function() {
        document.querySelector('.room-options').style.display = 'block';
    });
    
    // Upload room button
    uploadRoomBtn.addEventListener('click', function() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        
        input.onchange = e => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    roomBackground.src = event.target.result;
                    document.querySelector('.room-options').style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        };
        
        input.click();
    });
    
    // Reset button
    resetBtn.addEventListener('click', function() {
        // Reset position
        artworkOverlay.style.left = '50%';
        artworkOverlay.style.top = '50%';
        artworkOverlay.style.transform = 'translate(-50%, -50%)';
        
        // Reset size
        sizeBtns.forEach(b => b.classList.remove('active'));
        document.querySelector('.size-btn[data-size="medium"]').classList.add('active');
        artworkOverlay.className = 'artwork-overlay';
        artworkOverlay.classList.add('medium');
        
        // Reset frame
        frameOptions.forEach(opt => opt.classList.remove('active'));
        document.querySelector('.frame-option[data-frame="black"]').classList.add('active');
        artworkImage.className = 'artwork-image';
        artworkImage.classList.add('black-frame');
        
        // Reset artwork
        artworkThumbnails.forEach(t => t.classList.remove('active'));
        document.querySelector('.artwork-thumbnail[data-artwork="img/5.jpg"]').classList.add('active');
        artworkImage.src = 'img/5.jpg';
        
        // Reset room
        roomBackground.src = 'img/living-room.jpg';
    });
});

window.onscroll = function() {myFunction()};

var navbar_sticky = document.getElementById("navbar_sticky");
var sticky = navbar_sticky.offsetTop;
var navbar_height = document.querySelector('.navbar').offsetHeight;

function myFunction() {
  if (window.pageYOffset >= sticky + navbar_height) {
    navbar_sticky.classList.add("sticky")
    document.body.style.paddingTop = navbar_height + 'px';
  } else {
    navbar_sticky.classList.remove("sticky");
    document.body.style.paddingTop = '0'
  }
}

// Initialize event slider
document.addEventListener('DOMContentLoaded', function() {
    // This would be replaced with actual slider initialization code
    // For example, using Slick slider or another library
    // $('.past-events-slider').slick({...});
    
    // For demonstration purposes, we'll just add a click handler
    document.querySelectorAll('.past-event').forEach(event => {
        event.addEventListener('click', function() {
            alert('View details for this past event');
        });
    });
});

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