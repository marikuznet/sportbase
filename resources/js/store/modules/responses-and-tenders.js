import axios from "axios";

export default {
    actions: {
        async fetchResponsesAndTenders({commit}) {
            axios.get('/admin/responses-and-tenders/list').then(response => {
                commit('loadResponsesAndTenders', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async adminFetchResponsesByTenders({commit}, item) {
            axios.get(`/admin/responses-and-tenders/${item.id}/list`).then(response => {
                commit('loadResponsesAndTenders', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftResponsesAndTenders({commit}, item) {
            axios.delete('/responses_and_tenders/softDelete' + item.id).then((response) => {
                commit('softDeleteResponsesAndTenders', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeResponsesAndTenders({commit}, item) {
            axios.post('/responses_and_tenders/create', {
                'sportObject_id': item.sportObject_id,
                'service_id': item.service_id,
            }).then(response => {
                commit('createResponsesAndTenders', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        deleteResponse({commit}, item) {
            axios.delete('/responses_and_tenders/delete/' + item.id).then((response) => {
                commit('deleteResponsesAndTenders', item)
            }).catch((error) => {
                console.log(error.response);
            });
        }
    },
    mutations: {
        loadResponsesAndTenders(state, item) {
            state.responses_and_tenders = item;
        },
        updateResponsesAndTenders(state, item) {
            let index = state.responses_and_tenders.findIndex(p => p.id === item.id)
            state.responses_and_tenders[index] = item
        },
        createResponsesAndTenders(state, item) {
            let index = state.responses_and_tenders.findIndex(p => p.id === item.id)
            state.responses_and_tenders.unshift(index)
        },
        softDeleteResponsesAndTenders(state, item) {
            let index = state.responses_and_tenders.findIndex(p => p.id === item.id)
            state.responses_and_tenders.splice(index, 1);
        },
        deleteResponsesAndTenders(state, item) {
            let index = state.responses_and_tenders.findIndex(p => p.id === item.id)
            state.responses_and_tenders.splice(index, 1);
        }
    },
    state: {
        responses_and_tenders: []
    },
    getters: {
        AllResponsesAndTenders(state) {
            return state.responses_and_tenders;
        },
        GetTender: (state) => (idTender) => {
            return state.responses_and_tenders.filter(p => p.tender_id === idTender);
        },
        myResponsesOnTender: (state) => (user_id, tender_id) => {
            return state.responses_and_tenders.filter(p => p.responsesTender.user_id == user_id && p.tender_id == tender_id);
        },

        myResponsesOnTenderActive: (state) => (user_id) => {
            return state.responses_and_tenders.filter(p => p.responsesTender_userId == user_id && p.tender_archive == 0);
        },
        myResponsesOnTenderActiveCount: (state) => (user_id) => {
            return state.responses_and_tenders.filter(p => p.responsesTender_userId == user_id && p.tender_archive == 0).length;
        },

        myResponses: (state) => (user_id) => {
            return state.responses_and_tenders.filter(p => p.responsesTender_userId == user_id && (p.tender_archive != 0 && p.responsesTender_archive != 0));
        },
        myResponsesCount: (state) => (user_id) => {
            return state.responses_and_tenders.filter(p => p.responsesTender_userId == user_id).length;
        },
        myResponsesArchive: (state) => (user_id) => {
            return state.responses_and_tenders.filter(p => p.responsesTender_userId == user_id && p.responsesTender_archive == 2 && p.responsesTender_archive == 3);
        },
        myResponsesArchiveCount: (state) => (user_id) => {
            return state.responses_and_tenders.filter(p => p.responsesTender_userId == user_id && p.responsesTender_archive == 2 && p.responsesTender_archive == 3).length;
        },


        AllResponsesOnTender: (state) => (tender_id) => {
            return state.responses_and_tenders.filter(p => p.tender_id === tender_id);
        },
        AllResponsesOnTenderCount: (state) => (tender_id) => {
            return state.responses_and_tenders.filter(p => p.tender_id === tender_id).length;
        },
        AllResponsesCount: (state) => (tender_id) => {
            return state.responses_and_tenders.filter(p => p.tender_id === tender_id && p.responsesTender_archive === 0).length;
        },
        responsesTenderCount: (state) => (tender_id) => {
            return state.responses_and_tenders.filter(p => p.tender_id === tender_id).length;
        },
        responsesTenderWithDealCount: (state) => (tender_id) => {
            return state.responses_and_tenders.filter(p => p.tender_id === tender_id && p.responsesTender_archive === 1).length;
        },
        responsesCancelTender: (state) => (tender_id) => {
            return state.responses_and_tenders.filter(p => p.tender_id === tender_id && p.responsesTender_archive !== 0
                && p.responsesTender_archive !== 1);
        },

        tenderArchiveForExecutor: (state) => (user_id) => {
            return state.responses_and_tenders.filter(p => p.tender.archive != 0 && p.responsesTender_userId == user_id);
        }
    }
}
