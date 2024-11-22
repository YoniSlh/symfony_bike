import { Controller } from 'stimulus';

export default class extends Controller {
  static targets = ['input', 'results'];

  connect() {
    console.log('Autocomplete controller connected');
  }

  update(event) {
    this.query = event.target.value;
    console.log('Input value:', this.query);
    
    if (this.query.length >= 3) {
      this.search();
    } else {
      this.clearResults();
    }
  }

  search() {
    fetch('/search?query=' + this.query)
      .then(response => response.json())
      .then(data => {
        this.showResults(data);
      })
      .catch(error => console.error('Error during fetch:', error));
  }

  showResults(data) {
    this.clearResults();
    const results = this.resultsTarget;
    if (data.length > 0) {
      data.forEach(item => {
        const div = document.createElement('div');
        div.classList.add('autocomplete-item');
        div.textContent = item.name;
        results.appendChild(div);
      });
    } else {
      results.innerHTML = '<div class="no-results">Aucun résultat</div>';
    }
  }

  clearResults() {
    this.resultsTarget.innerHTML = '';
  }
}
