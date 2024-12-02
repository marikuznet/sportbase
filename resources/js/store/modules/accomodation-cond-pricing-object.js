import axios from "axios";
export default {
    actions: {
        async fetchCondPricingAndObject({commit}) {
            axios.get('/condPricing_and_object/list').then(response => {
                commit('loadCondPricingAndObject', response.data.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeCondPricingAndObject({commit}, item) {
            axios.put('/condPricing_and_object/create', {
                'sportObject_id': item.sportObject_id,
                'accomodationType_id': item.accomodationType_id,
            }).then(response => {
                commit('createPricingAndObject', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadCondPricingAndObject(state, item) {
            state.condPricing_and_object = item;
        },
        createPricingAndObject(state, item) {
            let index = state.condPricing_and_object.findIndex(p => p.id === item.id)
            state.condPricing_and_object.unshift(index)
        },
    },
    state: {
        condPricing_and_object: [],
    },
    getters: {
        AllCondPricingAndObjects(state) {
            return state.condPricing_and_object;
        },
        CondPricingAndObjects: (state) => (id) => {
            return state.condPricing_and_object.filter(p => p.sportObject_id == id);
        },
    }
}
