import axios from "axios";

export default {
    actions: {
        async fetchResponsesTender({commit}, item) {
            commit("setResponsesLoading", true);
            try {
                const status = item.status;
                const limit = item.limit;
                const page = item.page;
                const filter = item.filter;
                return await new Promise((resolve, reject) => {
                    axios.put(`/api/tenders/responses`, {
                        status, limit, page, filter,
                    }).then(response => {
                        commit("setResponsesLoading", false);
                        commit('loadResponsesTender', response.data)
                        resolve(response);
                    }, error => {
                        reject(error);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },

        async storeResponseTender({commit}, item) {
            return await
                axios.put('/api/responses-tender/store', item).then((result) => {
                    commit('createResponsesTender', result.data)
                }).catch(err => {
                    console.log(err);
                });

        },
        async updateResponseTender({commit}, item) {
            return await axios.put(`/api/responses-tender/update`, item).then(result => {
                commit('updateResponsesTender', result.data)
            });
        },
        async deleteResponseTender({commit}, item) {
            const data = { id: item.id, user_role: item.user_role };
            try {
                const response = await axios.put(`/api/responses-tender/delete`, data);
                return response.data;
            } catch (error) {
                console.log(error.response);
                throw error.response;
            }
        },

        getResponsesStatistic({commit}, payload) {
            return axios.get('/api/stats/tender/responses', payload)
                .then(resp => {
                    commit('setResponsesStatistic', resp.data)
                });
        },
    },
    mutations: {
        setResponsesStatistic(state, payload) {
            return state.responses_tender_statistic = payload;
        },
        loadResponsesTender(state, item) {
            state.responses_tender = item.data;
            state.responses_tender_pagination = item.pagination;
        },
        setResponsesLoading(state, item) {
            return (state.responses_tender_loading = item);
        },
        createResponsesTender(state, item) {
            //let index = state.responses_tender.findIndex(p => p.id === item.id)
            state.responses_tender.push(item)
        },
        updateResponsesTender(state, item) {
            let index = state.responses_tender.findIndex(current => current.id == item.id)
            state.responses_tender[index] = item
        },
        archiveResponsesTender(state, item) {

        },
        softDeleteResponsesTender(state, item) {
            let index = state.responses_tender.findIndex(p => p.id === item.id)
            state.responses_tender.splice(index, 1);
        }
    },
    state: {
        responses_tender: [],
        responses_tender_pagination: {},
        responses_tender_loading: false,
        responses_tender_statistic: {
            'activeCount': 0,
            'archiveCount': 0,
        },
    },
    getters: {
        responses_tender_statistic(state) {
            return state.responses_tender_statistic;
        },
        responses_tender_pagination(state) {
            return state.responses_tender_pagination;
        },
        responses_tender_loading(state) {
            return state.responses_tender_loading;
        },
        AllResponses: state => state.responses_tender,
    }
}
