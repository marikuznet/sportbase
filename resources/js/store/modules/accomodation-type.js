import axios from "axios";

export default {
    actions: {
        async fetchAccomodationTypes({commit}) {
            await axios.get('/accomodation-type/list').then(response => {
                commit('loadAccomodationTypes', response.data.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async fetchAccomodationTypesWithTrashed({commit}) {
            axios.get('accomodation_type/list_with_trashed').then(response => {
                commit('loadAccomodationTypesWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftAccomodationType({commit}, item) {
            axios.delete('accomodation_type/softDelete' + item.id).then((response) => {
                commit('softDeleteAccomodationType', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delForceAccomodationType({commit}, item) {
            axios.delete('accomodation_type/delete' + item.id).then((response) => {
                commit('forceDeleteAccomodationTypes', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        restoreAccomodationType({commit}, item) {
            axios.post('accomodation_type/restore' + item.id).then((response) => {
                commit('restoreAccomodationType', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setAccomodationType({commit}, item) {
            axios.put('accomodation_type/update' + item.id, {
                'title': item.title,
            }).then(response => {
                commit('updateAccomodationType', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeAccomodationType({commit}, item) {
            axios.post('accomodation_type/create', {
                'title': item.title,
            }).then(response => {
                commit('createAccomodationType', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadAccomodationTypes(state, item) {
            state.accomodation_type = item;
        },
        loadAccomodationTypesWithTrashed(state, item) {
            state.accomodation_type = item
        },
        forceDeleteAccomodationTypes(state, item) {
            let index = state.accomodation_type_with_trashed.findIndex(p => p.id === item.id)
            state.accomodation_type_with_trashed.splice(index, 1);
        },
        updateAccomodationType(state, item) {
            let index = state.accomodation_type.findIndex(p => p.id === item.id)
            state.accomodation_type[index] = item
        },
        createAccomodationType(state, item) {
            let index = state.accomodation_type.findIndex(p => p.id === item.id)
            state.accomodation_type.unshift(index)
        },
        restoreAccomodationType(state, item) {
            let index = state.accomodation_type_with_trashed.findIndex(p => p.id === item.id)
            state.accomodation_type_with_trashed.splice(index, 1);

            let index2 = state.accomodation_type.findIndex(p => p.id === item.id)
            state.accomodation_type.unshift(index2)
        },
        softDeleteAccomodationType(state, item) {
            let index = state.accomodation_type.findIndex(p => p.id === item.id)
            state.accomodation_type.splice(index, 1);

            let index2 = state.accomodation_type_with_trashed.findIndex(p => p.id === item.id)
            state.accomodation_type_with_trashed[index2] = item
        }
    },
    state: {
        accomodation_type: [],
        accomodation_type_with_trashed: []
    },
    getters: {
        AllAccomodationTypes(state) {
            return state.accomodation_type;
        },
        AllAccomodationTypesWithTrashed(state) {
            return state.accomodation_type_with_trashed;
        }
    }
}
