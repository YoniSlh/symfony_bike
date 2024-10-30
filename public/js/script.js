// changer l'image principale en fonction de l'image survolée
document.addEventListener("DOMContentLoaded", function() {
    const imageSecondaires = document.querySelectorAll('.imageSecondaireImage');
    const mainImage = document.querySelector('.principalImage');
    const originalSrc = mainImage.src; // sauvegarde l'image d'origine

    imageSecondaires.forEach(imageSecondaire => {
        imageSecondaire.addEventListener('mouseover', function() {
            mainImage.src = this.src; 
        });

        imageSecondaire.addEventListener('mouseout', function() {
            mainImage.src = originalSrc;
        });
    });

    mainImage.addEventListener('mouseout', function() {
        mainImage.src = originalSrc; // réinitialise à l'image d'origine
    });
});
