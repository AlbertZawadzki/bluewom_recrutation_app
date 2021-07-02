import {Controller} from 'stimulus';
import axios from "axios";

export default class extends Controller {
    static targets = ['currencies', 'userCurrencies'];

    currencies;
    userCurrencies;

    connect() {
        this.currencies = this.currenciesTarget;
        this.userCurrencies = this.userCurrenciesTarget;
    }

    actionAddCurrency = async (event) => {
        const parent = event.target.parentElement;
        const currencyId = parent.getAttribute('data-id');

        const form = new FormData();
        form.append('currencyId', currencyId);

        const outcome = await axios.post('/api/currency/add', form);

        if (outcome.status === 200) {
            if (this.userCurrencies.childNodes.length < 2) {
                this.userCurrencies.innerHTML = outcome.data.html.content;
                this.userCurrencies.parentElement.classList.remove('missing');
                this.userCurrencies.parentElement.childNodes[1].innerHTML = 'Twoje waluty:';
            } else {
                this.userCurrencies.innerHTML += outcome.data.html.content;
            }
            event.target.classList.remove('fa-plus-circle');
            event.target.classList.remove('fas');
            event.target.classList.add('fa-times-circle');
            event.target.classList.add('far');
            parent.setAttribute('data-action', 'click->currencies#actionRemoveCurrency');
            parent.classList.remove('add');
            parent.classList.add('remove');
        }
    }

    actionRemoveCurrency = async (event) => {
        const parent = event.target.parentElement;
        const currencyId = parseInt(parent.getAttribute('data-id'));

        const form = new FormData();
        form.append('currencyId', currencyId);

        const outcome = await axios.post('/api/currency/remove', form);

        if (outcome.status === 200) {
            for (const i in this.userCurrencies.childNodes) {
                let wantedCurrencyId = 0;
                const node = this.userCurrencies.childNodes[i];

                if (node.nodeType !== Node.ELEMENT_NODE) {
                    continue;
                }

                for (const j in node.childNodes) {
                    const subNode = node.childNodes[j];

                    if (subNode.nodeType !== Node.ELEMENT_NODE) {
                        continue;
                    }

                    const dataId = parseInt(subNode.getAttribute('data-id'));

                    if (Number.isInteger(dataId)) {
                        wantedCurrencyId = dataId;
                    }
                }

                if (currencyId === wantedCurrencyId) {
                    node.remove();
                    if (this.userCurrencies.childNodes.length === 1) {
                        this.userCurrencies.innerHTML = 'Nie śledzisz jeszcze żadnych walut, poniżej masz waluty które możesz śledzić';
                        this.userCurrencies.parentElement.classList.add('missing');
                        this.userCurrencies.parentElement.childNodes[1].innerHTML = 'Brak śledzonych walut';
                    }
                    break;
                }
            }

            for (const i in this.currencies.childNodes) {
                let wantedCurrencyId = 0;
                const node = this.currencies.childNodes[i];

                if (node.nodeType !== Node.ELEMENT_NODE) {
                    continue;
                }

                for (const j in node.childNodes) {
                    const subNode = node.childNodes[j];

                    if (subNode.nodeType !== Node.ELEMENT_NODE) {
                        continue;
                    }

                    const dataId = parseInt(subNode.getAttribute('data-id'));

                    if (Number.isInteger(dataId)) {
                        wantedCurrencyId = dataId;
                    }
                }

                if (currencyId === wantedCurrencyId) {
                    node.childNodes[1].childNodes[1].classList.add('fa-plus-circle');
                    node.childNodes[1].childNodes[1].classList.add('fas');
                    node.childNodes[1].childNodes[1].classList.remove('fa-times-circle');
                    node.childNodes[1].childNodes[1].classList.remove('far');
                    node.childNodes[1].setAttribute('data-action', 'click->currencies#actionAddCurrency');
                    node.childNodes[1].classList.add('add');
                    node.childNodes[1].classList.remove('remove');
                    break;
                }
            }
        }
    }
}