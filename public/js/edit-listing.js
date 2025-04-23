// Script pour gérer l'édition des annonces
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si nous sommes en mode édition
    const editMode = window.editMode || false;
    const listing = window.listing || null;
    
    // Pré-remplir les champs du formulaire en mode édition
    if (editMode && listing) {
        // Mettre à jour le titre de la page
        const pageTitle = document.querySelector('h1');
        if (pageTitle) {
            pageTitle.textContent = 'Modifier votre annonce';
            document.title = 'Modifier votre annonce - CampShare';
        }
        
        // Pré-remplir les champs du formulaire
        if (document.getElementById('equipment_name')) {
            document.getElementById('equipment_name').value = listing.title || '';
        }
        
        if (document.getElementById('category')) {
            document.getElementById('category').value = listing.category_id || '';
        }
        
        if (document.getElementById('city')) {
            document.getElementById('city').value = listing.city_id || '';
        }
        
        if (document.getElementById('price')) {
            document.getElementById('price').value = listing.price_per_day || '';
        }
        
        if (document.getElementById('description')) {
            document.getElementById('description').value = listing.description || '';
        }
        
        // Autres champs si disponibles
        if (document.getElementById('brand') && listing.brand) {
            document.getElementById('brand').value = listing.brand;
        }
        
        if (document.getElementById('condition') && listing.condition) {
            document.getElementById('condition').value = listing.condition;
        }
        
        if (document.getElementById('capacity') && listing.capacity) {
            document.getElementById('capacity').value = listing.capacity;
        }
        
        if (document.getElementById('available-from') && listing.available_from) {
            document.getElementById('available-from').value = listing.available_from;
        }
        
        if (document.getElementById('available-until') && listing.available_until) {
            document.getElementById('available-until').value = listing.available_until;
        }
        
        if (document.getElementById('delivery-option') && listing.delivery_option) {
            document.getElementById('delivery-option').checked = true;
        }
        
        // Afficher les images existantes si disponibles
        if (listing.images && listing.images.length > 0) {
            const photoPreviews = document.getElementById('photo-previews');
            if (photoPreviews) {
                photoPreviews.innerHTML = ''; // Effacer les prévisualisations existantes
                
                listing.images.forEach((image, index) => {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'photo-preview';
                    previewDiv.innerHTML = `
                        <img src="${image.url.startsWith('http') ? image.url : '/storage/' + image.url}" alt="Preview" class="w-full h-full object-cover">
                        <div class="photo-preview-overlay">
                            <button type="button" class="set-main-photo" title="Définir comme photo principale">
                                <i class="fas fa-star"></i>
                            </button>
                            <button type="button" class="delete-photo" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <input type="hidden" name="existing_photos[]" value="${image.id}">
                    `;
                    
                    photoPreviews.appendChild(previewDiv);
                    
                    // Ajouter les événements pour définir la photo principale et supprimer
                    previewDiv.querySelector('.set-main-photo').addEventListener('click', function() {
                        document.querySelectorAll('.photo-preview').forEach(p => {
                            p.classList.remove('main-photo');
                            p.style.border = 'none';
                        });
                        previewDiv.classList.add('main-photo');
                        previewDiv.style.border = '2px solid #2D5F2B';
                        
                        // Créer un input caché pour marquer cette photo comme principale
                        const mainPhotoInput = document.createElement('input');
                        mainPhotoInput.type = 'hidden';
                        mainPhotoInput.name = 'main_photo';
                        mainPhotoInput.value = image.id;
                        
                        // Supprimer les inputs main_photo existants
                        document.querySelectorAll('input[name="main_photo"]').forEach(input => {
                            input.remove();
                        });
                        
                        document.getElementById('listing-form').appendChild(mainPhotoInput);
                        
                        // Mettre à jour les images de prévisualisation
                        if (typeof updatePreviewImages === 'function') {
                            updatePreviewImages();
                        }
                    });
                    
                    previewDiv.querySelector('.delete-photo').addEventListener('click', function() {
                        // Créer un input caché pour marquer cette photo comme à supprimer
                        const deletePhotoInput = document.createElement('input');
                        deletePhotoInput.type = 'hidden';
                        deletePhotoInput.name = 'delete_photos[]';
                        deletePhotoInput.value = image.id;
                        document.getElementById('listing-form').appendChild(deletePhotoInput);
                        
                        previewDiv.remove();
                        if (typeof updatePhotoCount === 'function') {
                            updatePhotoCount();
                        }
                        if (typeof updatePreviewImages === 'function') {
                            updatePreviewImages();
                        }
                    });
                });
                
                if (typeof updatePhotoCount === 'function') {
                    updatePhotoCount();
                }
                if (typeof updatePreviewImages === 'function') {
                    updatePreviewImages();
                }
            }
        }
        
        // Mettre à jour le formulaire pour qu'il utilise la méthode PUT pour la mise à jour
        const form = document.getElementById('listing-form');
        if (form) {
            // Ajouter un champ caché pour la méthode PUT
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
            
            // Modifier l'action du formulaire pour pointer vers la route de mise à jour
            form.action = `/listings/${listing.id}`;
        }
    }
});
