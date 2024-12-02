import axios from "axios";

export default {
    actions: {
        async fetchTypeFoods({commit}) {
            return await new Promise((resolve, reject) => {
                axios.get('/api/filter/type-foods/list').then(
                    result => {
                        commit('loadTypeFoods', result.data)
                        resolve(result.data);
                    }).catch(err => {
                    reject(err.response.data);
                });
            });
        },
    },
    mutations: {
        loadTypeFoods(state, item) {
            state.type_foods = item;
        },
    },
    state: {
        type_foods: [],
    },
    getters: {
        AllTypeFoods(state) {
            return state.type_foods;
        },
    }
}
