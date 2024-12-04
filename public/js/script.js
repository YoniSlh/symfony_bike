// changer l'image principale en fonction de l'image survolée
document.addEventListener("DOMContentLoaded", function () {
  const imageSecondaires = document.querySelectorAll(".imageSecondaireImage");
  const mainImage = document.querySelector(".principalImage");
  const originalSrc = mainImage.src; // sauvegarde l'image d'origine

  imageSecondaires.forEach((imageSecondaire) => {
    imageSecondaire.addEventListener("mouseover", function () {
      mainImage.src = this.src;
    });

    imageSecondaire.addEventListener("mouseout", function () {
      mainImage.src = originalSrc;
    });
  });

  mainImage.addEventListener("mouseout", function () {
    mainImage.src = originalSrc; // réinitialise à l'image d'origine
  });
});

// dropdown
document.addEventListener("DOMContentLoaded", function () {
  const dropdownToggle = document.querySelector(".dropdown-toggle");
  const dropdownMenu = document.querySelector(".dropdown-menu");

  dropdownToggle.addEventListener("click", function (event) {
    event.preventDefault();
    dropdownMenu.style.display =
      dropdownMenu.style.display === "block" ? "none" : "block";
  });

  document.addEventListener("click", function (event) {
    if (
      !dropdownToggle.contains(event.target) &&
      !dropdownMenu.contains(event.target)
    ) {
      dropdownMenu.style.display = "none";
    }
  });
});

// changer logo de la langue
document.addEventListener("DOMContentLoaded", function () {
  const langLogo = document.querySelector(".lang-logo");
  langLogo.src = assetDrapeauFr;

  document.getElementById("langEn").addEventListener("click", function (event) {
    event.preventDefault();
    langLogo.src = assetDrapeauEn;
  });

  document
    .querySelector('a[href="?lang=fr"]')
    .addEventListener("click", function (event) {
      event.preventDefault();
      langLogo.src = assetDrapeauFr;
    });
});

// changer logo de la langue en fonction du paramètre de l'URL
document.addEventListener("DOMContentLoaded", function () {
  const langLogo = document.querySelector(".lang-logo");
  const urlParams = new URLSearchParams(window.location.search);
  const lang = urlParams.get("lang");

  if (lang === "en") {
    langLogo.src = assetDrapeauEn;
  } else {
    langLogo.src = assetDrapeauFr;
  }
});

// fermer flash
document
  .querySelectorAll(".flash-success .close-btn, .flash-error .close-btn")
  .forEach(function (button) {
    button.addEventListener("click", function () {
      var flash = this.closest(".flash-success, .flash-error");
      flash.classList.add("hidden");
      setTimeout(function () {
        flash.style.display = "none";
      }, 300);
    });
  });