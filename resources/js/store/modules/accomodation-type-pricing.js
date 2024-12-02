import axios from "axios";
export default {
    actions: {
        async fetchAccomodationTypePrices({state, commit}) {
            axios.get('/accomodation-type-pricing/list').then(response => {
                commit('loadAccomodationTypePrices', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async fetchAccomodationTypePricesWithTrashed({commit}) {
            axios.get('accomodation_type_pricing/list_with_trashed').then(response => {
                commit('loadAccomodationTypePricesWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftAccomodationTypePrice({commit}, item) {
            axios.delete('accomodation_type_pricing/softDelete' + item.id).then((response) => {
                commit('softDeleteAccomodationTypePrice', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delForceAccomodationTypePrice({commit}, item) {
            axios.delete('accomodation_type_pricing/delete' + item.id).then((response) => {
                commit('forceDeleteAccomodationTypePrices', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        restoreAccomodationTypePrice({commit}, item) {
            axios.post('accomodation_type_pricing/restore' + item.id).then((response) => {
                commit('restoreAccomodationTypePrice', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setAccomodationTypePrice({commit}, item) {
            axios.put('accomodation_type_pricing/update' + item.id, {
                'accomodationType_id': item.accomodationType_id,
                'description': item.description,
                'price': item.price,
            }).then(response => {
                commit('updateAccomodationTypePrice', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeAccomodationTypePrice({commit}, item) {
            return new Promise((resolve, reject) => {
                axios.put('/accommodations/types', {
                    'accomodationType_id': item.accomodationType_id,
                    'description': item.description,
                    'price': item.price,
                    'accCondAndPricing_id': item.accCondAndPricing_id,
                }).then(response => {
                    resolve(response);
                }, error => {
                    reject(error);
                })
            })
        },
    },
    mutations: {
        loadAccomodationTypePrices(state, item) {
            state.accomodation_type_pricing = item;
        },
        loadAccomodationTypePricesWithTrashed(state, item) {
            state.accomodation_type_pricing = item
        },
        forceDeleteAccomodationTypePrices(state, item) {
            let index = state.accomodation_type_pricing_with_trashed.findIndex(p => p.id === item.id)
            state.accomodation_type_pricing_with_trashed.splice(index, 1);
        },
        updateAccomodationTypePrice(state, item) {
            let index = state.accomodation_type_pricing.findIndex(p => p.id === item.id)
            state.accomodation_type_pricing[index] = item
        },
        createAccomodationTypePrice(state, item) {
            let index = state.accomodation_type_pricing.findIndex(p => p.id === item.id)
            state.accomodation_type_pricing.unshift(index)
        },
        restoreAccomodationTypePrice(state, item) {
            let index = state.accomodation_type_pricing_with_trashed.findIndex(p => p.id === item.id)
            state.accomodation_type_pricing_with_trashed.splice(index, 1);

            let index2 = state.accomodation_type_pricing.findIndex(p => p.id === item.id)
            state.accomodation_type_pricing.unshift(index2)
        },
        softDeleteAccomodationTypePrice(state, item) {
            let index = state.accomodation_type_pricing.findIndex(p => p.id === item.id)
            state.accomodation_type_pricing.splice(index, 1);

            let index2 = state.accomodation_type_pricing_with_trashed.findIndex(p => p.id === item.id)
            state.accomodation_type_pricing_with_trashed[index2] = item
        }
    },
    state: {
        accomodation_type_pricing: [],
        accomodation_type_pricing_with_trashed: []
    },
    getters: {
        AllAccomodationTypePrices(state) {
            return state.accomodation_type_pricing;
        },
        AllAccomodationTypePricesWithTrashed(state) {
            return state.accomodation_type_pricing_with_trashed;
        },
    }
}
