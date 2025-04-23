function sendFilterRequest() {
    var formData = new FormData(document.getElementById('filters-form'));  // Get all the form data

    // Send the data via AJAX
    fetch('{{ route("demandes.filter") }}', {  
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF token
        },
        body: formData  // Send the form data
    })
    .then(response => response.text()) 
    .then(data => {
        // Handle the response data (e.g., update the UI)
        console.log(data);  // For debugging

        if (data.success) {
            console.log("here");
            const reservaion = document.getElementById("reservations");
            reservaion.innerHTML = ""; 

            if (data.demandes.length > 0) {
                data.demandes.forEach(reservation => {
                    let newReservation = `
                    <div class="px-6 py-4">
                        <div class="flex flex-col lg:flex-row lg:items-start">
                            <div class="flex-shrink-0 mb-4 lg:mb-0 lg:mr-6 w-full lg:w-auto">
                                <div class="flex items-center lg:w-16">
                                    <img src="${reservation.avatar_url}" 
                                        alt="Mehdi Idrissi" 
                                        class="w-12 h-12 rounded-full object-cover" />
                                    <div class="lg:hidden ml-3">
                                        <h3 class="font-medium text-gray-900 dark:text-white">${reservation.username}</h3>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-star text-amber-400 mr-1"></i>
                                            <span>4.8 <span class="text-gray-500 dark:text-gray-400">(14)</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden lg:block mt-2">
                                    <h3 class="font-medium text-gray-900 dark:text-white text-center">${reservation.username}</h3>
                                    <div class="flex items-center justify-center text-xs mt-1">
                                        <i class="fas fa-star text-amber-400 mr-1"></i>
                                        <span>4.8</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-grow grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4 lg:mb-0">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Équipement</p>
                                    <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                        <span class="truncate">${reservation.title}</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Dates</p>
                                    <p class="font-medium text-gray-900 dark:text-white">${reservation.start_date} - ${reservation.end_date}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">(${reservation.number_days})</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Montant</p>
                                    <p class="font-medium text-gray-900 dark:text-white">${reservation.montant_total} MAD</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">(${reservation.price_per_day} MAD/jour)</p>
                                </div>
                            </div>

                            <div class="flex flex-col items-start lg:items-end lg:ml-6 space-y-3">
                                ${getStatusBadge(reservation.status, reservation.created_at)}
                            </div>
                        </div>
                    </div>`;

                    reservaion.insertAdjacentHTML('beforeend', newReservation);
                });
            }
        }
    })
    .catch(error => console.error('Error:', error));  // Catch any errors
}

function getStatusBadge(status, createdAt) {
    let statusClass = '';
    let textColor = '';
    let buttons = '';

    switch (status) {
        case "pending":
            statusClass = "bg-amber-100 dark:bg-amber-900/30";
            textColor = "text-amber-800 dark:text-amber-300";
            buttons = `
                <div class="flex space-x-2 w-full lg:w-auto">
                    <button class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors flex-1 lg:flex-initial">
                        Accepter
                    </button>
                    <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex-1 lg:flex-initial">
                        Refuser
                    </button>
                    <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-comment-alt"></i>
                    </button>
                </div>`;
            break;
        case "confirmed":
        case "ongoing":
            statusClass = "bg-green-100 dark:bg-green-900/30";
            textColor = "text-green-800 dark:text-green-300";
            break;
        case "canceled":
            statusClass = "bg-green-100 dark:bg-green-900/30";
            textColor = "text-green-800 dark:text-green-300";
            break;
        default:
            statusClass = "bg-amber-100 dark:bg-amber-900/30";
            textColor = "text-amber-800 dark:text-amber-300";
    }

    return `
        <div class="flex flex-col items-start lg:items-end lg:ml-6 space-y-3">
            <div class="status-badge ${statusClass} ${textColor}">
                <i class="fas fa-clock mr-1"></i> ${status}
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400">${createdAt}</p>
            ${buttons}
        </div>
    `;
}



document.querySelectorAll('.filter-chip').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('selected-status').value = this.value;

        document.querySelectorAll('.filter-chip').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        // Trigger the AJAX request
        sendFilterRequest();
    });
});
document.getElementById('filters-form').addEventListener('change', function(event) {
    // Check if the event target is an input or select element
    if (event.target.matches('input, select, textarea')) {
        sendFilterRequest(); 
    }
});

document.getElementById('filters-form').addEventListener('input', function(event) {
    // Trigger on typing inside input or textarea
    if (event.target.matches('input, textarea')) {
        sendFilterRequest(); 
    }
});
document.getElementById('filters-form').addEventListener('click', function(event) {
    // Check if the event target is a button (e.g., reset button or apply button)
    if (event.target.matches('button')) {
        event.preventDefault(); // Prevent the default action (e.g., form submission)
        sendFilterRequest();  // Call the function to send the request
    }
});
