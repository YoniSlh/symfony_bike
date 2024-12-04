import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["itemCount", "totalAmount"];

  connect() {
    console.log("CartController connecté !");
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
        this.itemCountTarget.textContent = data.itemCount;
        this.totalAmountTarget.textContent = `${data.totalAmount.toFixed(2)} €`;
      })
      .catch((error) => {
        console.error(error);
      });
  }
}
