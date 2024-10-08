import { Controller } from '@hotwired/stimulus';
import { useClickOutside, useDebounce } from 'stimulus-use';

export default class extends Controller {
    static values = {
        url: String,
    }

    static targets = ['result', 'input']; // Add the target
    static debounces = ['search'];

    connect()
    {
        useClickOutside(this);
        useDebounce(this);
    }

    onSearchInput(event)
    {
        this.search();
    }

    async search()
    {
        const params = new URLSearchParams({
            q: this.inputTarget.value,
            preview: 1,
        });
        const response = await fetch(`${this.urlValue}?${params.toString()}`);
        this.resultTarget.innerHTML = await response.text();
    }

    clickOutside(event)
    {
        this.resultTarget.innerHTML = '';
    }
}

