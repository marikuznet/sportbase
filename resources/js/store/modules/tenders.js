import axios from "axios";

export default {
    actions: {
        async getFilteredTenders({commit}, payload) {
            commit('setTendersLoading', true);
            try {
                const response = await axios.put('/api/tenders', {
                    page: payload.page,
                    type: payload.filters.type,
                    filter: payload.filters
                });
                commit('loadTenders', response.data);
            } catch (error) {
                console.error(error);
                commit('loadTenders', {data: [], pagination: {}});
            } finally {
                commit('setTendersLoading', false);
            }
        },
        async fetchAdminTenders({commit}) {
            try {
                return await new Promise((resolve, reject) => {
                    axios.get(`/admin/applications/tender/list`).then(response => {
                        commit('loadTenders', response.data)
                        resolve(response);
                    }, error => {
                        reject(error);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },

        async fetchMyTenders({commit}, item) {
            commit("setTendersLoading", true);
            try {
                const status = item.status ?? 'active';
                const limit = item.limit ?? 10;
                const page = item.page ?? 1;
                const filter = item.filter;
                return await new Promise((resolve, reject) => {
                    axios.put(`/tenders/my-tenders`, {
                        status, limit, page, filter
                    }).then(response => {
                        commit('loadTenders', response.data)
                        resolve(response);
                    }, error => {
                        reject(error);
                    }).finally(() => {
                        commit("setTendersLoading", false);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },
        async storeTender({commit}, item) {
            await axios.put('/tenders/create', item).then(response => {
                commit('createTender', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async updateTender({commit}, item) {
            await axios.put(`/tenders/update/${item.id}`, item).then(response => {
                commit('updateTender', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        addToTenderArchive({commit}, item) {
            axios.put('/tender/to/archive', {
                id: item.id,
                user_role: item.user_role
            }).then((response) => {
                commit('archiveTenders', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async cancelAllResponses({commit}, item) {
            try {
                const response = await axios.put(`/tenders/${item.id}/responses/reject-all`);
                return response.data;
            } catch (error) {
                console.log(error.response);
                throw error.response;
            }
        },

        getMyTendersStatistic({commit}, payload) {
            return axios.get('/api/stats/my-tenders', payload)
                .then(resp => {
                    commit('setTendersStatistic', resp.data)
                });
        },

        getTendersStatistic({commit}, payload) {
            return axios.get('/api/stats/tenders', payload)
                .then(resp => {
                    commit('setTendersStatistic', resp.data)
                });
        },

        setTendersLoading({commit}, payload){
            commit('setTendersLoading', payload);
        },

        setStorageTender({commit}, item) {
            commit("saveInStorage", item);
        },
    },
    mutations: {
        setTendersStatistic(state, payload) {
            state.tenders_statistic = payload;
        },

        loadTendersWithoutPagination(state, item) {
            state.tenders = item;
        },

        loadTenders(state, item) {
            state.tenders = item.data;
            state.tenders_pagination = item.pagination
        },
        createTender(state, item) {
            state.tenders.push(item)
        },
        updateTender(state, item) {
            const index = state.tenders.findIndex(tender => tender.id === item.id);
            if (index !== -1) {
                state.tenders.splice(index, 1, item);
            }
        },

        archiveTenders(state, item) {
            const index = state.tenders.findIndex(tender => tender.id === item.id);
            if (index !== -1) {
                state.tenders.splice(index, 1, item);
            }
        },

        softDeleteTender(state, item) {
            const index = state.tenders.findIndex(tender => tender.id === item.id);
            if (index !== -1) {
                state.tenders.splice(index, 1);
            }
        },

        deleteTender(state, item) {
            const index = state.tenders.findIndex(tender => tender.id === item.id);
            if (index !== -1) {
                state.tenders.splice(index, 1);
            }
        },

        setTendersLoading(state, payload) {
            state.tenders_loading = payload;
        },

        saveInStorage(state, payload) {
            localStorage.setItem('temp-tender', JSON.stringify(payload));
        }
    },
    state: {
        tenders: [],
        tenders_statistic: {
            activeTendersCount: 0,
            archiveTendersCount: 0,
            allTendersCount: 0,
            myResponsesTenderCount: 0,
            myTendersCount: 0
        },
        tenders_pagination: {},
        tenders_loading: false
    },
    getters: {
        tenders_pagination: state => state.tenders_pagination,
        tenders_statistic: state => state.tenders_statistic,
        tenders_loading: state => state.tenders_loading,
        AllTenders: state => state.tenders,
        GetTenderId: state => tender_id => state.tenders.find(tender => tender.id === tender_id),
        AllTendersCount: state => state.tenders.length,
        tendersActive: state => state.tenders.filter(tender => !tender.deal && (tender.archive === 0 || tender.archive === 1) && new Date(tender.start_date) > new Date()),
        tendersActiveCount: state => state.tenders.filter(tender => !tender.deal && (tender.archive === 0 || tender.archive === 1) && new Date(tender.start_date) > new Date()).length,
        tendersArchive: state => state.tenders.filter(tender => tender.deal || [2, 3, 4].includes(tender.archive) || new Date(tender.start_date) < new Date()),
        tendersArchiveCount: state => state.tenders.filter(tender => tender.deal || [2, 3, 4].includes(tender.archive) || new Date(tender.start_date) < new Date()).length
    }
}
