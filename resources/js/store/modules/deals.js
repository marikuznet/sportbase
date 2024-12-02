import axios from "axios";

export default {
    actions: {
        fetchDeals({commit}, item) {
            commit('setDealsLoading', true);
            return axios.put(`/transaction/deals?page=${item.page}&total=${item.total}`).then(response => {
                commit('loadDeals', response.data)
            }).catch((error) => {
                console.log(error.response);
                commit('loadDeals', {data: [], pagination: {}});
            }).finally(() => commit('setDealsLoading', false));
        },
        adminFetchDeals({commit}) {
            commit('setDealsLoading', true);
            return axios.put(`/admin/api/deals`).then(response => {
                commit('loadDeals', response.data)
            }).catch((error) => {
                console.log(error.response);
                commit('loadDeals', {data: [], pagination: {}});
            }).finally(() => commit('setDealsLoading', false));
        },
        async getDeal({commit}, item) {
            return await new Promise((resolve, reject) => {
                axios.get('/transaction/conclusion/deal/' + item.id).then(
                    result => {
                        commit('loadDeals', result.data)
                        resolve(result.data.data);
                    }).catch(err => {
                    reject(err.response.data);
                });
            });
        },
        async getDealDirect({commit}, item) {
            return await new Promise((resolve, reject) => {
                axios.get('/transaction/deal/getDealDirect/' + item.id).then(
                    result => {
                        commit('loadDeals', result.data.data)
                        resolve(result.data.data);
                    }).catch(err => {
                    reject(err.response.data);
                });
            });
        },
        async getDealTender({commit}, item) {
            // commit('setDealsLoading', true);
            return await new Promise((resolve, reject) => {
                axios.get('/transaction/deal/tender/' + item.id).then(
                    result => {
                        commit('loadDeals', result.data.data)
                        resolve(result.data.data);
                    }).catch(err => {
                    reject(err.response.data);
                });//.finally(() => commit('setDealsLoading', false));
            });
        },
        async storeDealTender({commit}, item) {
            return await new Promise((resolve, reject) => {
                axios.put('/transaction/deal/tender/create', {
                    'tender_id': item.tender_id,
                    'responsesTender_id': item.responsesTender_id,
                }).then(
                    result => {
                        resolve(result.data);
                    }).catch(err => {
                    reject(err.response);
                });
            });
        },
        async storeDealDirect({commit}, item) {
            return await new Promise((resolve, reject) => {
                axios.put('/transaction/deal/direct/create', {
                    'directApplication_id': item.directApplication_id,
                }).then(
                    result => {
                        resolve(result.data);
                        commit('createDeal', item)
                    }).catch(err => {
                    reject(err.response);
                });
            });
        },
        delDeal({commit}, item) {
            axios.delete('/admin/deal/delete/' + item.id).then((response) => {
                commit('deleteDeal', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        rejectDeal({commit}, item) {
            return axios.put('/transaction/deal/reject/' + item.id, {
                'rejectionsDeal': item.rejectionsDeal,
                'status': item.user_role,
                'idResponse': item.idResponse,
                'idDirect': item.idDirect,
                'reason_cancelled': item.reason_cancelled
            }).then(response => {
                commit('updateDeal', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        acceptConditions({commit}, item) {
            axios.put('/transaction/deal/condition/accept/' + item.id, {
                'role': item.user_role,
            }).then(response => {
                commit('updateDeal', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        getPayment({commit}, item) {
            axios.put('/transaction/deal/get-payment/' + item.id).then(response => {
                commit('updateDeal', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        connectArbitration({commit}, item) {
           return axios.put('/transaction/deal/connect-arbitr/' + item.id, {
                'role': item.role
            }).then(response => {
                commit('updateDeal', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        dealDone({commit}, item) {
            return axios.put('/transaction/deal/done/' + item.id, {tender_id: item.tender_id}).then(response => {
                commit('updateDeal', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        dealComplete({commit}, item) {
            axios.put('/transaction/deal/complete/' + item.id, {
                complete: item.idComplete
            }).then(response => {
                commit('updateDeal', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadDeals(state, item) {
            state.deals = item.data;
            state.deals_pagination = item.pagination;
        },
        setDealsLoading(state, item) {
            state.deals_loading = item;
        },

        updateDeal(state, item) {
            let index = state.deals.findIndex(p => p.id === item.id)
            state.deals[index] = item
        },
        createDeal(state, item) {
            let index = state.deals.findIndex(p => p.id === item.id)
            state.deals.unshift(index)
        },
        deleteDeal(state, item) {
            let index = state.deals.findIndex(p => p.id === item.id)
            state.deals.splice(index, 1);
        }
    },
    state: {
        deals: [],
        deals_loading: [],
        deals_pagination: {}
    },
    getters: {
        AllDeals: state => state.deals,
        deals_loading: state => state.deals_loading,
        deals_pagination: state => state.deals_pagination,

        GetDeal: (state) => (tender_id) => {
            return state.deals.filter(p => p.tender ? p.tender.id == tender_id : '');
        },
        GetDealResponse: (state) => (response_id) => {
            return state.deals.filter(p => p.responsesTender ? p.responsesTender.id == response_id : '');
        },

        /*ADMIN*/
        DealsIsProcessing: state => state.deals.filter(p => p.step < 2 && (p.status !== 2 && p.status !== 3)),
        DealsIsProcessingCount: state => state.deals.filter(p => p.step < 2 && (p.status !== 2 && p.status !== 3)).length,

        DealsInProgress: state => state.deals.filter(p => p.step > 1 && p.complete !== 1 && (p.status !== 2 || p.status !== 3)),
        DealsInProgressCount: state => state.deals.filter(p => p.step > 1 && p.complete !== 1 && (p.status !== 2 || p.status !== 3)).length,

        DealsFinished: state => state.deals.filter(p => (p.status === 2 || p.status === 3) || (p.complete === 1 || p.complete === 2)),
        DealsFinishCount: state => state.deals.filter(p => (p.status === 2 || p.status === 3) || (p.complete === 1 || p.complete === 2)).length,
    }
}
