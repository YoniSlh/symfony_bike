import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['cartCount', 'cartTotal'];

    connect() {
        this.cart = JSON.parse(localStorage.getItem('cart')) || {};
        this.updateCart();
    }

    addToCart(event) {
        const productId = event.currentTarget.dataset.cartId;
        const productName = event.currentTarget.dataset.cartName;
        const productPrice = parseFloat(event.currentTarget.dataset.cartPrice);

        if (!this.cart[productId]) {
            this.cart[productId] = { name: productName, price: productPrice, quantity: 1 };
        } else {
            this.cart[productId].quantity++;
        }

        this.saveCart();
        this.updateCart();
    }

    removeFromCart(event) {
        const productId = event.currentTarget.dataset.cartId;

        if (this.cart[productId]) {
            delete this.cart[productId];
            this.saveCart();
            this.updateCart();
        }
    }

    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.cart));
    }

    updateCart() {
        const totalItems = Object.values(this.cart).reduce((sum, item) => sum + item.quantity, 0);
        const totalPrice = Object.values(this.cart).reduce((sum, item) => sum + item.price * item.quantity, 0);

        this.cartCountTarget.textContent = totalItems;
        this.cartTotalTarget.textContent = `${totalPrice.toFixed(2)} €`;
    }
}
