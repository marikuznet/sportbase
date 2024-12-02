import axios from "axios";

export default {
    actions: {
        async fetchDirectRequests({commit}, item) {
            commit("setDirectRequestLoading", true);
            try {
                const status = item.status || 'active';
                const limit = item.limit || 10;
                const page = item.page || 1;
                const filter = item.filter;
                return await new Promise((resolve, reject) => {
                    axios.put(`/direct-applications`, {
                        status, limit, page, filter
                    }).then(response => {
                        commit('loadDirectRequest', response.data)
                        resolve(response);
                    }, error => {
                        reject(error);
                    }).finally(() => {
                        commit("setDirectRequestLoading", false);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },
        async getDirectApplication({commit}, id) {
            axios.get('/direct_applications/direct/' + id).then(response => {
                return commit('loadDirectApplications', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeDirectApplication({commit}, item) {
            axios.put('/direct-application/create', {
                infoCompany_id: item.infoCompany_id,
                sportObject_id: item.sportObject_id,
                type_sports: item.type_sports,
                infrastructures: item.infrastructures,
                city_id: item.city_id,
                startDate: item.startDate,
                endDate: item.endDate,
                spreadDate: item.spreadDate,
                typeFoods: item.typeFoods,
                additionsTender: item.additionsTender,
                colPeople: item.colPeople,
                priceForPerson: item.priceForPerson,
                minPrice: item.minPrice,
                createDate: item.createDate,
                user_id: item.user_id,
                comment: item.comment,
            }).then(response => {
                commit('createDirectApplication', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setDirectApplication({commit}, item) {
            axios.put('/direct_application/update/' + item.id, {
                //'id': item.id,
                type_sports: item.type_sports,
                infrastructures: item.infrastructures,
                city_id: item.city_id,
                startDate: item.startDate,
                endDate: item.endDate,
                spreadDate: item.spreadDate,
                typeFoods: item.typeFoods,
                additionsTender: item.additionsTender,
                colPeople: item.colPeople,
                priceForPerson: item.priceForPerson,
                minPrice: item.minPrice,
                createDate: item.createDate,
                comment: item.comment,
            }).then(response => {
                commit('updateDirectApplication', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setAdminDirectApplication({commit}, item) {
            axios.put('/admin/direct_applications/update/' + item.id, {
                //'id': item.id,
                type_sports: item.type_sports,
                infrastructures: item.infrastructures,
                city_id: item.city_id,
                startDate: item.startDate,
                endDate: item.endDate,
                spreadDate: item.spreadDate,
                typeFoods: item.typeFoods,
                additionsTender: item.additionsTender,
                colPeople: item.colPeople,
                priceForPerson: item.priceForPerson,
                minPrice: item.minPrice,
                createDate: item.createDate,
                comment: item.comment,
            }).then(response => {
                commit('updateDirectApplication', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        addToDirectArchive({commit}, item) {
            axios.put('/direct_application/to/archive/', {
                'id': item.id,
                'user_role': item.user_role
            }).then((response) => {
                commit('archiveDirectApplication', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftDirect({commit}, item) {
            axios.delete('/direct_application/softDelete/' + item.id).then((response) => {
                commit('softDeleteDirectApplication', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delDirect({commit}, item) {
            axios.delete('/admin/direct_application/delete/' + item.id).then((response) => {
                commit('deleteDirectApplication', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadDirectRequest(state, item) {
            state.direct_applications = item.data;
            state.direct_applications_pagination = item.pagination;
        },
        setDirectRequestLoading(state, item) {
            state.direct_applications_loading = item;
        },


        loadDirectApplications(state, item) {
            state.direct_applications = item;
        },
        setDirectApplicationsLoading(state, item) {
            state.direct_applications_loading = item;
        },

        createDirectApplication(state, item) {
            //let index = state.direct_applications.findIndex(p => p.id === item.id)
            state.direct_applications.unshift(item)
        },
        updateDirectApplication(state, item) {
            let index = state.direct_applications.findIndex(p => p.id === item.id)
            state.direct_applications[index] = item
        },
        archiveDirectApplication(state, item) {
            let index = state.direct_applications.findIndex(p => p.id === item.id)
            state.direct_applications[index] = item
        },
        deleteDirectApplication(state, item) {
            let index = state.direct_applications.findIndex(p => p.id === item.id)
            state.direct_applications.splice(index, 1);
        }
    },
    state: {
        direct_applications: [],
        direct_applications_loading: false,
        direct_applications_pagination: {},
    },
    getters: {
        getDirectApplications: state => state.direct_applications,
        direct_applications_loading: state => state.direct_applications_loading,
        direct_applications_pagination: state => state.direct_applications_pagination,
    }
}
