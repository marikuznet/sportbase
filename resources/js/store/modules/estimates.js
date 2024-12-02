import axios from "axios";

export default {
    actions: {
        async fetchDeal_estimates({commit}, item) {
            commit('setEstimatesLoading', true);
            let deal_id = item && item.deal_id ? `?deal_id=${item.deal_id}` : ''
            let query = '/transaction/estimates' + deal_id;
            await axios.get(query).then((response) => {
                commit('loadDeal_estimates', response.data.data);
            }).catch((error) => {
                console.log(error);
                commit('loadDeal_estimates', {data: []});
            }).finally(() => {
                commit('setEstimatesLoading', false);
            })
        },
        async adminFetchEstimates({commit}) {
            commit('setEstimatesLoading', true);
            await axios.put('/admin/api/bills').then((response) => {
                commit('loadDeal_estimates', response.data.data);
            }).catch((error) => {
                console.log(error);
                commit('loadDeal_estimates', {data: []});
            }).finally(() => {
                commit('setEstimatesLoading', false);
            })
        },
        async getPayments({commit}) {
            commit('setEstimatesLoading', true);
            await axios.get('/admin/api/transaction/payments').then((response) => {
                commit('loadDeal_estimates', response.data.data);
            }).finally(() => commit('setEstimatesLoading', false));
        },

        async getEstimate({commit}, item) {
            commit('loadingEstimate', true)
            return await new Promise((resolve, reject) => {
                axios.get('/transaction/estimate/' + item.id).then(
                    result => {
                        resolve(result.data.data);
                        commit('loadEstimate', result.data.data);
                    }).catch(err => {
                    reject(err.response);
                }).finally(() => {
                    commit('loadingEstimate', false);
                });
            });
        },

        async getBalanceExecutor() {
            return await new Promise((resolve, reject) => {
                axios.get('/api/v1/company/balance').then(
                    result => {
                        resolve(result.data);
                    }).catch(err => {
                    reject(err.response);
                });
            });
        },
        storeEstimate({commit}, item) {
            return axios.put('/transaction/estimate/create', {
                'sportObject_id': item.sportObject_id,
                'deal_id': item.deal_id,

                'object_checkSport': item.object.checkSport,
                'object_price': item.object.price,
                'object_sum': item.object.sum,
                'object_start_date': item.object.startDate,
                'object_end_date': item.object.endDate,
                'object_time': item.object.time,
                'object_training': item.object.training,
                'object_trainingTime': item.object.trainingTime,
                'object_trainingTime_diff': item.object.trainingTime_diff,

                'accommodation_checkAccm': item.accommodation.checkAccm,
                'accommodation_accommodations': item.accommodation.accommodations,
                'accommodation_daysAccm': item.accommodation.daysAccm,
                'accommodation_start_date': item.accommodation.startDate,
                'accommodation_end_date': item.accommodation.endDate,
                'accommodation_priceFood': item.accommodation.priceFood,
                'accommodation_sumPriceFood': item.accommodation.sumPriceFood,
                'accommodation_sumAccm': item.accommodation.sumAccm,
                'accommodation_titlePriceFood': item.accommodation.titlePriceFood,
                'accommodation_typePriceFood': item.accommodation.typePriceFood,
                'accommodation_typeFood_id': item.accommodation.typeFood_id,

                'additional_checkLaundry': item.additional.checkLaundry,
                'additional_priceWashing': item.additional.priceWashing,
                'additional_washingVolume': item.additional.washingVolume,
                'additional_sumLaundry': item.additional.sumLaundry,
                'additional_checkTransfer': item.additional.checkTransfer,
                'additional_durationTransfer': item.additional.durationTransfer,
                'additional_priceTransfer': item.additional.priceTransfer,
                'additional_sumTransfer': item.additional.sumTransfer,
                'additional_infrastructures': item.additional.infrastructures,
                'additional_totalPrice': item.additional.totalPrice,

                'sum': item.sum
            }).then(response => {
                commit('loadDeal_estimates', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setEstimate({commit}, item) {
            axios.put('/transaction/deal_estimate/update', {
                'deal_id': item.deal_id,

                'object_id': item.object.id,
                'object_checkSport': item.object.checkSport,
                'object_price': item.object.price,
                'object_sum': item.object.sum,
                'object_start_date': item.object.startDate,
                'object_end_date': item.object.endDate,
                'object_time': item.object.time,
                'object_training': item.object.training,
                'object_trainingTime': item.object.trainingTime,
                'object_trainingTime_diff': item.object.trainingTime_diff,

                'accommodation_id': item.accommodation.id,
                'accommodation_checkAccm': item.accommodation.checkAccm,
                'accommodation_accommodations': item.accommodation.accommodations,
                'accommodation_daysAccm': item.accommodation.daysAccm,
                'accommodation_start_date': item.accommodation.startDate,
                'accommodation_end_date': item.accommodation.endDate,
                'accommodation_priceFood': item.accommodation.priceFood,
                'accommodation_sumPriceFood': item.accommodation.sumPriceFood,
                'accommodation_sumAccm': item.accommodation.sumAccm,
                'accommodation_titlePriceFood': item.accommodation.titlePriceFood,
                'accommodation_typeFood_id': item.accommodation.typeFood_id,

                'additional_id': item.additional.id,
                'additional_checkLaundry': item.additional.checkLaundry,
                'additional_priceWashing': item.additional.priceWashing,
                'additional_washingVolume': item.additional.washingVolume,
                'additional_sumLaundry': item.additional.sumLaundry,
                'additional_checkTransfer': item.additional.checkTransfer,
                'additional_durationTransfer': item.additional.durationTransfer,
                'additional_priceTransfer': item.additional.priceTransfer,
                'additional_sumTransfer': item.additional.sumTransfer,
                'additional_infrastructures': item.additional.infrastructures,
                'additional_totalPrice': item.additional.totalPrice,
            }).then(response => {
                commit('updateEstimates', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        showEstimateCustomer({commit}, item) {
            return axios.put('/transaction/estimate/show_customer/' + item.id, {
                payment_overdue_date: item.payment_overdue_date
            }).then(response => {
                commit('updateEstimate', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        estimateConfirmation({commit}, item) {
            return axios.put('/transaction/estimate/confirm_payment/' + item.id).then(response => {
                commit('updateEstimate', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        estimatePaymentConfirmationAdmin({commit}, item) {
            return axios.put('/transaction/estimate/confirm_payment_admin/' + item.id + '/' + item.deal_id).then(response => {
                commit('updateEstimate', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        updateStatusEstimate({commit}, item) {
        },
    },
    mutations: {
        loadDeal_estimates(state, item) {
            state.deal_estimates = item;
        },
        loadEstimate(state, item) {
            state.estimate = item;
        },
        loadingEstimate(state, item) {
            state.estimate_loading = item;
        },
        updateEstimate(state, item) {
            let index = state.deal_estimates.findIndex(p => p.id == item.id)
            state.deal_estimates[index] = item;
            // state.deal_estimates[index].show_customer = item.show_customer;
        },
        updateEstimates(state, item) {
            let index = state.deal_estimates.findIndex(p => p.id == item.id)
            //state.deal_estimates[index] = item;
        },

        setEstimatesLoading(state, item) {
            state.estimates_loading = item;
        }
    },
    state: {
        deal_estimates: [],
        estimates_loading: [],
        estimate: {},
    },
    getters: {
        estimateGetters: state => state.estimate,
        estimateLoading: state => state.estimate_loading,

        AllDeal_estimates: state => state.deal_estimates,
        GetEstimates: (state) => (deal_id) => {
            return state.deal_estimates.filter(p => p.deal_id == deal_id);
        },
        GetEstimatesCustomer: (state) => (user_id) => {
            return state.deal_estimates.filter(p => p.customer_info.id == user_id && p.status > 0);
        },
        GetEstimatesCustomerCount: (state) => (user_id) => {
            return state.deal_estimates.filter(p => p.customer_info.id == user_id && p.status > 0).length;
        },
        GetEstimatesExecutor: (state) => (user_id) => {
            return state.deal_estimates.filter(p => p.sportObject.created.user_id == user_id && p.status > 0);
        },
        GetEstimatesExecutorCount: (state) => (user_id) => {
            return state.deal_estimates.filter(p => p.sportObject.created.user_id == user_id && p.status > 0).length;
        },

        /**Admin*/ //.filter(p => p.status <= 3 && p.status > 0),
        GetEstimatesAdmin: state => state.deal_estimates.filter(p => p.status > 0),
        GetEstimatesPaymentAdmin: state => state.deal_estimates,
        GetPaymentPerformers: state => state.deal_estimates.filter(p => (p.status === 3 || p.status === 5)),
        GetPaymentPerformersCount: state => state.deal_estimates.filter(p => (p.status === 3 || p.status === 5)).length,
        // && (p.dealComplete === 1 || p.dealComplete === 2)),
    }
}
