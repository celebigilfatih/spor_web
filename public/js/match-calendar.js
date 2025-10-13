// Match Calendar JavaScript Functions

function scrollMatches(direction) {
    const container = document.getElementById('matchesScroll');
    const scrollAmount = 350; // Scroll amount in pixels
    
    if (direction === 'left') {
        container.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    } else if (direction === 'right') {
        container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }
}

// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const matchCards = document.querySelectorAll('.horizontal-match-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            // Show/hide match cards based on filter
            matchCards.forEach(card => {
                if (filter === 'all') {
                    card.style.display = 'block';
                } else {
                    const cardType = card.getAttribute('data-type');
                    if (cardType === filter) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    });
    
    // Auto-scroll functionality (optional)
    let autoScrollInterval;
    
    function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
            const container = document.getElementById('matchesScroll');
            const maxScroll = container.scrollWidth - container.clientWidth;
            
            if (container.scrollLeft >= maxScroll) {
                container.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                scrollMatches('right');
            }
        }, 5000); // Auto-scroll every 5 seconds
    }
    
    function stopAutoScroll() {
        clearInterval(autoScrollInterval);
    }
    
    // Start auto-scroll on page load
    // startAutoScroll();
    
    // Stop auto-scroll when user interacts
    const container = document.getElementById('matchesScroll');
    if (container) {
        container.addEventListener('mouseenter', stopAutoScroll);
        container.addEventListener('mouseleave', startAutoScroll);
        container.addEventListener('touchstart', stopAutoScroll);
    }
});

// Touch/swipe support for mobile
let startX = 0;
let scrollLeft = 0;

document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('matchesScroll');
    
    if (container) {
        container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
        });
        
        container.addEventListener('touchmove', (e) => {
            e.preventDefault();
            const x = e.touches[0].pageX - container.offsetLeft;
            const walk = (x - startX) * 2;
            container.scrollLeft = scrollLeft - walk;
        });
    }
});