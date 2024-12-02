import axios from "axios";

export default {
    actions: {
        async fetchDirectApplications({commit}, limit = 10) {
            commit('setDirectApplicationsLoading', true);
            await axios.get('/admin/applications/direct/list').then(response => {
                return commit('loadDirectApplications', response.data)
            }).catch((error) => {
                console.log(error.response);
            }).finally(() => commit('setDirectApplicationsLoading', false));
        },
        async getDirectApplicationById({commit}, item) {
            commit('setDirectApplicationsLoading', true);
            return await new Promise((resolve, reject) => {
                axios.get(`/admin/applications/direct/${item.id}`).then(response => {
                    commit('loadDirect', response.data)
                    resolve(response.data);
                }, error => {
                    reject(error);
                }).finally(() => {
                    commit("setDirectApplicationsLoading", false);
                })
            })
        }
    },
    mutations: {
        loadDirectApplications(state, item) {
            state.admin_direct_applications = item;
        },
        setDirectApplicationsLoading(state, item) {
            state.admin_direct_applications_loading = item;
        },

        loadDirect(state, item) {
            state.admin_direct = item;
        }
    },
    state: {
        admin_direct_applications: [],
        admin_direct_applications_loading: false,
        admin_direct_applications_pagination: {},

        admin_direct: {}
    },
    getters: {
        getAdminDirectApplications: state => state.admin_direct_applications,
        admin_direct_applications_loading: state => state.admin_direct_applications_loading,
        admin_direct_applications_pagination: state => state.admin_direct_applications_pagination,

        adminDirectApplicationsCount: state => state.admin_direct_applications.length,
        adminDirectApplicationsActive: state => state.admin_direct_applications.filter(p => (p.archive == 0 || p.archive == 1)),
        adminDirectApplicationsActiveCount: state => state.admin_direct_applications.filter(p => (p.archive == 0 || p.archive == 1)).length,
        DirectApplicationsArchive: state => state.admin_direct_applications.filter(p => p.archive != 0 && p.archive != 1),
        DirectApplicationsArchiveCount: state => state.admin_direct_applications.filter(p => p.archive != 0 && p.archive != 1).length,

        getAdminDirect: state => state.admin_direct,
    }
}
