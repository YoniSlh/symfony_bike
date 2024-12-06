import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["itemCount", "totalAmount", "cartItem", "quantityInput"];

  connect() {
    this.loadCartData();
  }

  addToCart(event) {
    event.preventDefault();
    const button = event.currentTarget;

    const productId = button.dataset.id;
    const productName = button.dataset.name;
    const productPrice = button.dataset.price;

    fetch(addToCartUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        id: productId,
        name: productName,
        price: parseFloat(productPrice),
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erreur lors de l'ajout au panier");
        }
        return response.json();
      })
      .then((data) => {
        console.log("Produit ajouté au panier :", data);
        this.loadCartData();
      })
      .catch((error) => {
        console.error("Erreur lors de l'ajout au panier :", error);
      });
  }

  loadCartData() {
    fetch(getCartUrl, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Cache-Control": "no-cache",
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erreur lors du chargement des données du panier");
        }
        return response.json();
      })
      .then((data) => {
        this.updateCartDisplay(data);
      })
      .catch((error) => {
        console.error(
          "Erreur lors du chargement des données du panier :",
          error
        );
      });
  }

  updateCartDisplay(data) {
    console.log("Mise à jour des données du panier :", data);

    const itemCountPanier = document.getElementById("itemCountPanier");
    const totalAmountPanier = document.getElementById("totalAmountPanier");

    if (itemCountPanier) {
      const itemCountText =
        data.itemCount === 0 ? "0 articles" : `${data.itemCount} articles`;
      itemCountPanier.textContent = itemCountText;
    }

    if (totalAmountPanier) {
      totalAmountPanier.textContent = `${(data.totalAmount || 0).toFixed(2)} €`;
    }

    if (this.itemCountTarget) {
      this.itemCountTarget.textContent =
        data.itemCount === 0 ? "0 articles" : `${data.itemCount} articles`;
    }

    if (this.totalAmountTarget) {
      this.totalAmountTarget.textContent = `${(data.totalAmount || 0).toFixed(
        2
      )} €`;
    }

    const removedProductId = data.removedProductId?.toString();
    if (removedProductId) {
      const row = this.cartItemTargets.find(
        (item) => item.dataset.id === removedProductId
      );
      if (row) {
        row.remove();
      }
    }
  }

  updateQuantity(event) {
    const quantityInput = event.target;
    const row = quantityInput.closest(".cart-item");
    const productId = row.dataset.id;
    const newQuantity = parseInt(quantityInput.value, 10);

    fetch(updateQuantityUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        id: productId,
        quantity: newQuantity,
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erreur lors de la mise à jour de la quantité");
        }
        return response.json();
      })
      .then((data) => {
        console.log("Quantité mise à jour :", data);
        this.loadCartData();
      })
      .catch((error) => {
        console.error("Erreur lors de la mise à jour de la quantité :", error);
      });
  }

  removeFromCart(event) {
    event.preventDefault();
    const button = event.currentTarget;
    const row = button.closest(".cart-item");
    const productId = row.dataset.id;

    fetch("/cart/remove", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        id: productId,
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erreur lors de la suppression du produit");
        }
        return response.json();
      })
      .then((data) => {
        console.log("Produit retiré du panier:", data);
        if (data.success) {
          this.loadCartData();
        }
      })
      .catch((error) => {
        console.error("Erreur lors de la suppression du produit:", error);
      });
  }
}
