// Detect dark mode preference
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.documentElement.classList.add('dark');
}
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
    if (event.matches) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});

// Mobile menu toggle
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

mobileMenuButton.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});

// Sticky navbar effect on scroll
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('nav');
    if (window.scrollY > 50) {
        navbar.classList.add('shadow-lg');
    } else {
        navbar.classList.remove('shadow-lg');
    }
});

// Image gallery
function changeImage(thumbnail, imgSrc) {
    // Update main image
    document.getElementById('mainImage').src = imgSrc;
    
    // Update active thumbnail
    const thumbnails = document.querySelectorAll('.thumbnail');
    thumbnails.forEach(thumb => {
        thumb.classList.remove('active');
    });
    thumbnail.classList.add('active');
}

// Tabs switching
const tabDetails = document.getElementById('tab-details');
const tabReviews = document.getElementById('tab-reviews');

const detailsSection = document.getElementById('details-section');
const reviewsSection = document.getElementById('reviews-section');

if(tabDetails) tabDetails.addEventListener('click', () => {
    // Update tab styles
    tabDetails.classList.add('tab-active');
    tabDetails.classList.remove('text-gray-500', 'dark:text-gray-400');
    tabReviews.classList.remove('tab-active');
    tabReviews.classList.add('text-gray-500', 'dark:text-gray-400');
    
    // Show/hide sections
    detailsSection.classList.remove('hidden');
    reviewsSection.classList.add('hidden');
});

if(tabReviews) tabReviews.addEventListener('click', () => {
    // Update tab styles
    tabReviews.classList.add('tab-active');
    tabReviews.classList.remove('text-gray-500', 'dark:text-gray-400');
    tabDetails.classList.remove('tab-active');
    tabDetails.classList.add('text-gray-500', 'dark:text-gray-400');
    
    // Show/hide sections
    reviewsSection.classList.remove('hidden');
    detailsSection.classList.add('hidden');
});

// Review form toggle
const writeReviewButton = document.getElementById('write-review-button');
const reviewForm = document.getElementById('review-form');
const cancelReviewButton = document.getElementById('cancel-review');

if (writeReviewButton && reviewForm && cancelReviewButton) {
    writeReviewButton.addEventListener('click', () => {
        reviewForm.classList.remove('hidden');
        writeReviewButton.classList.add('hidden');
    });
    
    cancelReviewButton.addEventListener('click', () => {
        reviewForm.classList.add('hidden');
        writeReviewButton.classList.remove('hidden');
    });
}

// Reservation date calculation
const pickupDate = document.getElementById('pickup-date');
const returnDate = document.getElementById('return-date');
const priceCalculation = document.getElementById('price-calculation');
const daysCount = document.getElementById('days-count');
const subtotal = document.getElementById('subtotal');
const serviceFee = document.getElementById('service-fee');
const totalPrice = document.getElementById('total-price');

if (pickupDate && returnDate) {
    // Set today as minimum date
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const formattedToday = `${yyyy}-${mm}-${dd}`;
    
    pickupDate.min = formattedToday;
    
    // Calculate dates and price when dates are selected
    function calculatePrice() {
        if (pickupDate.value && returnDate.value) {
            const start = new Date(pickupDate.value);
            const end = new Date(returnDate.value);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays > 0) {
                const dailyRate = 450; // MAD
                const daysTotal = diffDays;
                const subTotal = dailyRate * daysTotal;
                const feeAmount = subTotal * 0.05; // 5% service fee
                const total = subTotal + feeAmount;
                
                daysCount.textContent = daysTotal;
                subtotal.textContent = `${subTotal.toFixed(2)} MAD`;
                serviceFee.textContent = `${feeAmount.toFixed(2)} MAD`;
                totalPrice.textContent = `${total.toFixed(2)} MAD`;
                
                priceCalculation.classList.remove('hidden');
            }
        }
    }
    
    pickupDate.addEventListener('change', () => {
        // Set return date minimum to day after pickup
        if (pickupDate.value) {
            const nextDay = new Date(pickupDate.value);
            nextDay.setDate(nextDay.getDate() + 1);
            const yyyy = nextDay.getFullYear();
            const mm = String(nextDay.getMonth() + 1).padStart(2, '0');
            const dd = String(nextDay.getDate()).padStart(2, '0');
            returnDate.min = `${yyyy}-${mm}-${dd}`;
            
            // Clear return date if it's before new minimum
            if (returnDate.value && new Date(returnDate.value) < new Date(returnDate.min)) {
                returnDate.value = '';
            }
        }
        
        calculatePrice();
    });
    
    returnDate.addEventListener('change', calculatePrice);
}

// Reservation button
const reservationButton = document.getElementById('reservation-button');

if (reservationButton) {
    reservationButton.addEventListener('click', () => {
        if (!pickupDate.value || !returnDate.value) {
            alert('Veuillez sélectionner les dates de retrait et de retour avant de réserver.');
            return;
        }
        
        alert('Votre demande de réservation a été envoyée au partenaire. Vous serez notifié dès que la réservation sera confirmée.');
    });
}

// load comments 

let visible = 2;
const reviews = document.querySelectorAll('.review-item');
const loadMoreBtn = document.getElementById('loadMoreBtn');
const loadLessBtn = document.getElementById('loadLessBtn');

// Show initial 2 reviews
reviews.forEach((review, index) => {
    if (index >= visible) review.classList.add('hidden');
});

if(loadMoreBtn) loadMoreBtn.addEventListener('click', () => {
    let shown = 0;
    for (let i = visible; i < reviews.length && shown < 2; i++) {
        reviews[i].classList.remove('hidden');
        shown++;
    }
    visible += shown;

    // Toggle buttons
    if (visible >= reviews.length) {
        loadMoreBtn.style.display = 'none';
    }
    loadLessBtn.style.display = 'inline-block';
});

if(loadLessBtn) loadLessBtn.addEventListener('click', () => {
    visible = 2;
    reviews.forEach((review, index) => {
        if (index >= visible) review.classList.add('hidden');
    });

    // Toggle buttons
    loadMoreBtn.style.display = 'inline-block';
    loadLessBtn.style.display = 'none';
});

// Initial toggle state
if (reviews.length <= 2) {
    if(loadMoreBtn) loadMoreBtn.style.display = 'none';
    if(loadLessBtn)loadLessBtn.style.display = 'none';
} else {
    if(loadMoreBtn)loadMoreBtn.style.display = 'inline-block';
    if(loadLessBtn)loadLessBtn.style.display = 'none';
}


// 

// Toggle advanced filters
const filtersButton = document.querySelector('button:has(.fa-sliders-h)');
        
// Sort dropdown toggle
const sortButton = document.getElementById('sort-button');
const sortDropdown = document.getElementById('sort-dropdown');

sortButton?.addEventListener('click', () => {
    sortDropdown.classList.toggle('hidden');
});

// Hide sort dropdown when clicking outside
document.addEventListener('click', (e) => {
    if (sortButton && !sortButton.contains(e.target) && !sortDropdown.contains(e.target)) {
        sortDropdown.classList.add('hidden');
    }
});