import axios from "axios";

export default {
    actions: {
        async getTenderApplicationById({commit}, item) {
            return await new Promise((resolve, reject) => {
                axios.get(`/admin/applications/tender/${item.id}`).then(response => {
                    commit('loadTender', response.data)
                    resolve(response.data);
                }, error => {
                    reject(error);
                })
            })
        },
        async adminUpdateTender({commit}, item) {
            axios.put(`/admin/applications/tender/update/${item.id}`, item).then(response => {
            }).catch((error) => {
                console.log(error.response);
            });
        }
    },
    mutations: {
        loadTender(state, item) {
            state.admin_tender = item;
        },
    },
    state: {
        admin_tender: {},
        admin_tenders: {}
    },
    getters: {
        getAdminTender: state => state.admin_tender,
    }
}
