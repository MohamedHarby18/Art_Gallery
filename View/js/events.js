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