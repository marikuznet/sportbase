import axios from "axios";

export default {
    actions: {
        async fetchAdditionTender({commit}) {
            return new Promise((resolve, reject) => {
                axios.get('/api/filter/additions/list').then(response => {
                    resolve(response.data);
                    commit('loadAdditionTender', response.data);
                }, error => {
                    reject(error);
                    commit('loadAdditionTender', {data: []});
                })
            })
        },
    },
    mutations: {
        loadAdditionTender(state, item) {
            state.addition_tender = item;
        },
    },
    state: {
        addition_tender: [],
    },
    getters: {
        AllAdditionTender(state) {
            return state.addition_tender;
        },
    }
}
