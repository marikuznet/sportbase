import axios from "axios";

export default {
    actions: {
        async fetchPositions({commit}) {
            return await new Promise((resolve, reject) => {
                axios.get('/position/list').then(
                    result => {
                        commit('loadPositions', result.data.data)
                        resolve(result.data.data);
                    }).catch(err => {
                    reject(err.response.data);
                });
            });
        },
        async fetchPositionsWithTrashed({commit}) {
            axios.get('position/list_with_trashed').then(response => {
                commit('loadRegionsWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadPositions(state, item) {
            state.position = item;
        },
        loadPositionsWithTrashed(state, item) {
            state.position = item
        },
    },
    state: {
        position: [],
        position_with_trashed: []
    },
    getters: {
        AllPositions(state) {
            return state.position;
        },
        AllPositionsWithTrashed(state) {
            return state.position_with_trashed;
        }
    }
}
