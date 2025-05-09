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


// User dropdown toggle
const userMenuButton = document.getElementById('user-menu-button');
const userDropdown = document.getElementById('user-dropdown');

userMenuButton?.addEventListener('click', () => {
    userDropdown.classList.toggle('hidden');
});

// Notifications dropdown toggle
const notificationsButton = document.getElementById('notifications-button');
const notificationsDropdown = document.getElementById('notifications-dropdown');

notificationsButton?.addEventListener('click', () => {
    notificationsDropdown.classList.toggle('hidden');
});

// Messages dropdown toggle
const messagesButton = document.getElementById('messages-button');
const messagesDropdown = document.getElementById('messages-dropdown');

messagesButton?.addEventListener('click', () => {
    messagesDropdown.classList.toggle('hidden');
});

// Hide dropdowns when clicking outside
document.addEventListener('click', (e) => {
    // User dropdown
    if (userMenuButton && !userMenuButton.contains(e.target) && userDropdown && !userDropdown.contains(e.target)) {
        userDropdown.classList.add('hidden');
    }
    
    // Notifications dropdown
    if (notificationsButton && !notificationsButton.contains(e.target) && notificationsDropdown && !notificationsDropdown.contains(e.target)) {
        notificationsDropdown.classList.add('hidden');
    }
    
    // Messages dropdown
    if (messagesButton && !messagesButton.contains(e.target) && messagesDropdown && !messagesDropdown.contains(e.target)) {
        messagesDropdown.classList.add('hidden');
    }
});

// Mobile sidebar toggle
const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
const mobileSidebar = document.getElementById('mobile-sidebar');
const closeMobileSidebar = document.getElementById('close-mobile-sidebar');
const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');

mobileSidebarToggle?.addEventListener('click', () => {
    mobileSidebar.classList.toggle('-translate-x-full');
    mobileSidebarOverlay.classList.toggle('hidden');
    document.body.classList.toggle('overflow-hidden');
});

closeMobileSidebar?.addEventListener('click', () => {
    mobileSidebar.classList.add('-translate-x-full');
    mobileSidebarOverlay.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
});

mobileSidebarOverlay?.addEventListener('click', () => {
    mobileSidebar.classList.add('-translate-x-full');
    mobileSidebarOverlay.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
});

// Sidebar link active state
const sidebarLinks = document.querySelectorAll('.sidebar-link');

sidebarLinks.forEach(link => {
    link.addEventListener('click', () => {
        // Remove active class from all links
        sidebarLinks.forEach(el => el.classList.remove('active'));
        
        // Add active class to clicked link
        link.classList.add('active');
    });
});

// Message modal
const messageButtons = document.querySelectorAll('button .fas.fa-comment-alt, .fas.fa-envelope');
const messageModal = document.getElementById('message-modal');
const closeMessageModal = document.getElementById('close-message-modal');
const messageForm = document.getElementById('message-form');
const messageInput = document.getElementById('message-input');

messageButtons.forEach(button => {
    button.parentElement.addEventListener('click', (e) => {
        e.preventDefault();
        messageModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        // Scroll to bottom of chat
        const chatContainer = document.querySelector('.chat-container');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        // Focus input
        messageInput?.focus();
    });
});

closeMessageModal?.addEventListener('click', () => {
    messageModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
});

// Close modal when clicking outside
messageModal?.addEventListener('click', (e) => {
    if (e.target === messageModal) {
        messageModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
});

// Handle message form submission
messageForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const message = messageInput.value.trim();
    if (message) {
        // Create and append new message
        const chatContainer = document.querySelector('.chat-container');
        const newMessage = document.createElement('div');
        newMessage.className = 'chat-message outgoing';
        
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const timeString = `${hours}:${minutes < 10 ? '0' + minutes : minutes}`;
        
        newMessage.innerHTML = `
            <div class="chat-bubble">
                <p class="text-white">${message}</p>
                <p class="text-xs text-gray-300 mt-1">${timeString}</p>
            </div>
        `;
        
        chatContainer.appendChild(newMessage);
        messageInput.value = '';
        
        // Scroll to bottom of chat
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
});

// Add to favorites functionality
const heartButtons = document.querySelectorAll('.far.fa-heart');

heartButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.stopPropagation();
        if (button.classList.contains('far')) {
            button.classList.remove('far');
            button.classList.add('fas');
        } else {
            button.classList.remove('fas');
            button.classList.add('far');
        }
    });
});

function cancelReservation(reservationId) {
if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
    fetch(`/client/reservations/cancel/${reservationId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            // Recharger les réservations
            document.getElementById('statusFilter').dispatchEvent(new Event('change'));
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue');
    });
}
}

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

let visible = 3;
const reviews = document.querySelectorAll('.review-item');
const loadMoreBtn = document.getElementById('loadMoreBtn');
const loadLessBtn = document.getElementById('loadLessBtn');

// Show initial 3 reviews
reviews.forEach((review, index) => {
    if (index >= visible) review.classList.add('hidden');
});

if(loadMoreBtn) loadMoreBtn.addEventListener('click', () => {
    let shown = 0;
    for (let i = visible; i < reviews.length && shown < 3; i++) {
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
    visible = 3;
    reviews.forEach((review, index) => {
        if (index >= visible) review.classList.add('hidden');
    });

    // Toggle buttons
    loadMoreBtn.style.display = 'inline-block';
    loadLessBtn.style.display = 'none';
});

// Initial toggle state
if (reviews.length <= 3) {
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

// Sort dropdown toggle
const sortButtonCity = document.getElementById('city-filter-button');
const sortDropdownCity = document.getElementById('city-dropdown');

sortButtonCity?.addEventListener('click', () => {
    sortDropdownCity.classList.toggle('hidden');
});

// Hide sort dropdown when clicking outside
document.addEventListener('click', (e) => {
    if (sortButtonCity && !sortButtonCity.contains(e.target) && !sortDropdownCity.contains(e.target)) {
        sortDropdownCity.classList.add('hidden');
    }
});

// Price Range Filter Interactions
document.addEventListener('DOMContentLoaded', function() {
    // Price range buttons
    const priceRangeButtons = document.querySelectorAll('[data-price-range]');
    const resetPriceFilter = document.querySelector('.reset-price-filter');

    // Highlight active price range
    const currentPriceRange = new URLSearchParams(window.location.search).get('price_range');
    if (currentPriceRange) {
        priceRangeButtons.forEach(button => {
            if (button.dataset.priceRange === currentPriceRange) {
                button.classList.add('bg-forest', 'text-white');
                button.classList.remove('bg-white', 'dark:bg-gray-700');
            }
        });
    }

    // Handle price range button clicks
    priceRangeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            
            // Update price_range parameter
            urlParams.set('price_range', this.dataset.priceRange);
            
            // Redirect to new URL with updated parameters
            window.location.href = `${window.location.pathname}?${urlParams.toString()}`;
        });
    });

    // Handle reset button click
    if (resetPriceFilter) {
        resetPriceFilter.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            
            // Remove price_range parameter
            urlParams.delete('price_range');
            
            // Redirect to new URL without price filter
            window.location.href = `${window.location.pathname}?${urlParams.toString()}`;

        });
    }

    const openModalBtn = document.getElementById('openPartnerModalBtn');
    const partnerModal = document.getElementById('partnerAcceptModal');
    if (openModalBtn && partnerModal) {
        const closeModalBtn = document.getElementById('closePartnerModalBtn');
        const cancelModalBtn = document.getElementById('cancelPartnerModalBtn');
        const openModal = () => {
            partnerModal.classList.remove('hidden');
            partnerModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        };
        const closeModal = () => {
            partnerModal.classList.add('hidden');
            partnerModal.classList.remove('flex');
            document.body.style.overflow = '';
        };
        openModalBtn.addEventListener('click', (event) => {
            event.preventDefault();
            openModal();
        });
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }
        if (cancelModalBtn) {
            cancelModalBtn.addEventListener('click', closeModal);
        }
        partnerModal.addEventListener('click', (event) => {
            if (event.target === partnerModal) {
                closeModal();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !partnerModal.classList.contains('hidden')) {
                closeModal();
            }
        });
    }

});


// Tab switching
const tabEquipment = document.getElementById('tab-equipment1');
const tabReviews1 = document.getElementById('tab-reviews1');
const equipmentSection = document.getElementById('equipment-section1');
const reviewsSection1 = document.getElementById('reviews-section1');

tabEquipment.addEventListener('click', () => {
    // Update tab styles
    tabEquipment.classList.add('tab-active');
    tabReviews1.classList.remove('tab-active');
    tabReviews1.classList.add('text-gray-500', 'dark:text-gray-400');
    
    // Show/hide sections
    equipmentSection.classList.remove('hidden');
    reviewsSection1.classList.add('hidden');
});

tabReviews1.addEventListener('click', () => {
    // Update tab styles
    tabReviews1.classList.add('tab-active');
    tabReviews1.classList.remove('text-gray-500', 'dark:text-gray-400');
    tabEquipment.classList.remove('tab-active');
    
    // Show/hide sections
    reviewsSection1.classList.remove('hidden');
    equipmentSection.classList.add('hidden');
});


const links = document.querySelectorAll(".sidebar-link");
const components = document.querySelectorAll(".component");

links.forEach(link => {
    link.addEventListener("click", (e) => {
    e.preventDefault();
    const targetId = link.getAttribute("data-target");

    components.forEach(comp => {
        comp.classList.add("hidden");
    });

    document.getElementById(targetId).classList.remove("hidden");
    });
});
      

    


