import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['cartTotal', 'itemCount'];

    add(event) {
        event.preventDefault();
        const productId = event.currentTarget.dataset.productId;
        const quantity = 1;

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ productId, quantity }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                this.cartTotalTarget.textContent = data.total;
                this.itemCountTarget.textContent = data.itemCount;
            }
        });
    }
}
