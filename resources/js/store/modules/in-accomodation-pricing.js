import axios from "axios";

export default {
    actions: {
        async fetchInAccomodationPrices({commit}) {
            axios.get('in_accomodation_prices/list').then(response => {
                commit('loadInAccomodationPrices', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async fetchInAccomodationPricesWithTrashed({commit}) {
            axios.get('in_accomodation_prices/list_with_trashed').then(response => {
                commit('loadInAccomodationPricesWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftInAccomodationPrice({commit}, item) {
            axios.delete('in_accomodation_prices/softDelete' + item.id).then((response) => {
                commit('softDeleteInAccomodationPrice', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delForceInAccomodationPrice({commit}, item) {
            axios.delete('in_accomodation_prices/delete' + item.id).then((response) => {
                commit('forceDeleteInAccomodationPrices', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        restoreInAccomodationPrice({commit}, item) {
            axios.post('in_accomodation_prices/restore' + item.id).then((response) => {
                commit('restoreInAccomodationPrice', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setInAccomodationPrice({commit}, item) {
            axios.put('in_accomodation_prices/update' + item.id, {
                'title': item.title,
            }).then(response => {
                commit('updateInAccomodationPrice', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeInAccomodationPrice({commit}, item) {
            return new Promise((resolve, reject) => {
                axios.put('/accommodations/included-prices', {
                    'title': item.title,
                }).then(response => {
                    resolve(response);
                }, error => {
                    reject(error);
                })
            })
        },
    },
    mutations: {
        loadInAccomodationPrices(state, item) {
            state.in_accomodation_prices = item;
        },
        loadInAccomodationPricesWithTrashed(state, item) {
            state.in_accomodation_prices = item
        },
        forceDeleteInAccomodationPrices(state, item) {
            let index = state.in_accomodation_prices_with_trashed.findIndex(p => p.id === item.id)
            state.in_accomodation_prices_with_trashed.splice(index, 1);
        },
        updateInAccomodationPrice(state, item) {
            let index = state.in_accomodation_prices.findIndex(p => p.id === item.id)
            state.in_accomodation_prices[index] = item
        },
        createInAccomodationPrice(state, item) {
            let index = state.in_accomodation_prices.findIndex(p => p.id === item.id)
            state.in_accomodation_prices.unshift(index)
        },
        restoreInAccomodationPrice(state, item) {
            let index = state.in_accomodation_prices_with_trashed.findIndex(p => p.id === item.id)
            state.in_accomodation_prices_with_trashed.splice(index, 1);

            let index2 = state.in_accomodation_prices.findIndex(p => p.id === item.id)
            state.in_accomodation_prices.unshift(index2)
        },
        softDeleteInAccomodationPrice(state, item) {
            let index = state.in_accomodation_prices.findIndex(p => p.id === item.id)
            state.in_accomodation_prices.splice(index, 1);

            let index2 = state.in_accomodation_prices_with_trashed.findIndex(p => p.id === item.id)
            state.in_accomodation_prices_with_trashed[index2] = item
        }
    },
    state: {
        in_accomodation_prices: [],
        in_accomodation_prices_with_trashed: []
    },
    getters: {
        AllInAccomodationPrices(state) {
            return state.in_accomodation_prices;
        },
        AllInAccomodationPricesWithTrashed(state) {
            return state.in_accomodation_prices_with_trashed;
        }
    }
}
