import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['input', 'results'];

    async update(event) {
        const query = event.target.value;

        if (query.length < 3) {
            this.resultsTarget.innerHTML = '';
            return;
        }

        const response = await fetch(`/search?query=${query}`);
        const data = await response.json();

        this.resultsTarget.innerHTML = data.map(product => `
            <div class="product-result">
                <strong>${product.name}</strong>
            </div>
        `).join('');
    }
}