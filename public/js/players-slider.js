// Players Slider Functionality
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('playersSlider');
    const prevBtn = document.querySelector('.prev-player');
    const nextBtn = document.querySelector('.next-player');
    
    if (!slider) return;
    
    const scrollAmount = 270; // card width + gap
    let autoScrollInterval;
    
    // Scroll function
    function scrollPlayers(direction) {
        if (direction === 'left') {
            slider.scrollLeft -= scrollAmount;
        } else {
            slider.scrollLeft += scrollAmount;
        }
    }
    
    // Button click events
    if (prevBtn) {
        prevBtn.addEventListener('click', () => scrollPlayers('left'));
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => scrollPlayers('right'));
    }
    
    // Auto scroll functionality (optional - currently disabled)
    function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
            if (slider.scrollLeft >= (slider.scrollWidth - slider.clientWidth)) {
                slider.scrollLeft = 0;
            } else {
                slider.scrollLeft += scrollAmount;
            }
        }, 3000);
    }
    
    function stopAutoScroll() {
        clearInterval(autoScrollInterval);
    }
    
    // Pause auto scroll on hover
    const playersSection = document.querySelector('.players-slider-section');
    if (playersSection) {
        playersSection.addEventListener('mouseenter', stopAutoScroll);
        playersSection.addEventListener('mouseleave', () => {
            // Uncomment to enable auto scroll
            // startAutoScroll();
        });
        
        // Uncomment to start auto scroll on page load
        // startAutoScroll();
    }
    
    // Touch/swipe support for mobile
    let isDown = false;
    let startX;
    let scrollLeft;
    
    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.style.cursor = 'grabbing';
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    
    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.style.cursor = 'grab';
    });
    
    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.style.cursor = 'grab';
    });
    
    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2;
        slider.scrollLeft = scrollLeft - walk;
    });
});
