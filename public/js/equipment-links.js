// Mettre à jour les liens vers la page des équipements
document.addEventListener('DOMContentLoaded', function() {
    // Mettre à jour les liens vers la page des équipements
    const equipmentLinks = document.querySelectorAll('a[href="#equipment"]');
    const equipmentUrl = '/mes-equipements'; // URL de la page des équipements
    
    equipmentLinks.forEach(link => {
        link.href = equipmentUrl;
    });
});
