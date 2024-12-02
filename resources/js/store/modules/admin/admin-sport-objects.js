import axios from "axios";

export default {
    actions: {
        async getSportObjectById({commit}, item) {
            return await new Promise((resolve, reject) => {
                axios.get(`/admin/sport-objects/${item.id}`).then(response => {
                    commit('loadSportObject', response.data.data)
                    resolve(response.data.data);
                }, error => {
                    reject(error);
                })
            })
        },
        async getAddressesBySportObjects({commit}) {
            return await new Promise((resolve, reject) => {
                axios.get(`/admin/sport-objects/addresses`).then(response => {
                    commit('loadAddresses', response.data.data)
                    resolve(response.data.data);
                }, error => {
                    reject(error);
                })
            })
        }
    },
    mutations: {
        loadSportObject(state, item) {
            state.admin_sport_object = item;
        },
        loadAddresses(state, item) {
            state.admin_sport_objects_addresses = item;
        },
    },
    state: {
        admin_sport_object: {},
        admin_sport_objects_addresses: {},
    },
    getters: {
        getAdminSportObject: state => state.admin_sport_object,
        getAdminSportObjectsAddresses: state => state.admin_sport_objects_addresses,
    }
}
