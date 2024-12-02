export default {
    actions: {
        addObject({commit}, item) {
            commit('addObject', item)
        },
        addAccommodation({commit}, item) {
            commit('addAccommodation', item)
        },
        addAdditional({commit}, item) {
            commit('addAdditional', item)
        },
        setStoreEstimate({commit}, item) {
            commit("setStoreEstimate", item);
        }
    },
    mutations: {
        setStoreEstimate(state, item) {
            state.estimates[0].object = item.objectRent;
        },
        addObject(state, item) {
            state.estimates[0].object = item.object;
            localStorage.setItem('objectRent', JSON.stringify(item));
        },
        addAccommodation(state, item) {
            state.estimates[0].accommodation = item.accommodation;
            localStorage.setItem('accommodationRent', JSON.stringify(item));
        },
        addAdditional(state, item) {
            state.estimates[0].additional = item.additional
            localStorage.setItem('additionalRent', JSON.stringify(item));
        }
    },
    /*actions: {
        async fetchTypeFoods({ commit }) {
            axios.get('/tender/type_foods/list').then(response => {
                commit('loadTypeFoods', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
    },
    mutations:{
        loadTypeFoods(state, item) {
            state.type_foods = item;
        },
    },*/
    state: {
        estimates: [{object: [], accommodation: [], additional: []}],
    },
    getters: {
        AllEstimates(state) {
            return state.estimates;
        },
        GetEstimate(state) {
            return state.estimates[0];
        },
        EstimateObject(state) {
            return state.estimates[0].object;
        },
        EstimateAccomodation(state) {
            return state.estimates[0].accommodation;
        },
        EstimateAdditional(state) {
            return state.estimates[0].additional;
        },
    }
}
