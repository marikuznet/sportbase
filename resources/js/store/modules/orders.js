import axios from "axios";

export default {
    actions: {
        async fetchActiveOrders({commit}, item) {
            commit("setOrdersLoading", true);
            try {
                const status = item.status ?? 'orders';
                const filter = item.filter;
                return await new Promise((resolve, reject) => {
                    axios.put(`/active-orders`, {
                        status, filter,
                    }).then(response => {
                        commit('loadOrders', response.data)
                        resolve(response.data.data);
                    }, error => {
                        reject(error);
                    }).finally(() => {
                        commit("setOrdersLoading", false);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },
        async fetchFinishedOrders({commit}, item) {
            commit("setOrdersLoading", true);
            try {
                const status = item.status ?? 'orders';
                const filter = item.filter;
                return await new Promise((resolve, reject) => {
                    axios.put(`/finished-orders`, {
                        status, filter,
                    }).then(response => {
                        resolve(response.data.data);
                    }, error => {
                        reject(error);
                    }).finally(() => {
                        commit("setOrdersLoading", false);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },
        async fetchOrders({commit}, item) {
            commit("setOrdersLoading", true);
            try {
                const status = item.status ?? 'orders';
                const limit = item.limit ?? 10;
                const page = item.page ?? 1;
                const filter = item.filter;
                return await new Promise((resolve, reject) => {
                    axios.put(`/orders`, {
                        status, limit, page, filter,
                    }).then(response => {
                        commit('loadOrders', response.data)
                        resolve(response);
                    }, error => {
                        reject(error);
                    }).finally(() => {
                        commit("setOrdersLoading", false);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },
        async fetchEstimatesProfile({commit}, item) {
            commit("setPaymentsLoading", true);
            try {
                const limit = item.limit ?? 10;
                const page = item.page ?? 1;
                const filter = item.filter;
                return await new Promise((resolve, reject) => {
                    axios.put(`/api/payments`, {
                        limit, page, filter
                    }).then(response => {
                        commit('setPayments', response.data)
                        resolve(response);
                    }, error => {
                        reject(error);
                    }).finally(() => {
                        commit("setPaymentsLoading", false);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },


        async getEstimates({commit}, item) {
            commit('setEstimatesLoading', true);
            try {
                const status = item.status ?? 'estimates';
                const limit = item.limit ?? 10;
                const page = item.page ?? 1;
                const filter = item.filter;
                return await new Promise((resolve, reject) => {
                    axios.put(`/api/payments`, {
                        status, limit, page, filter,
                    }).then(response => {
                        commit('setEstimates', response.data)
                        resolve(response);
                    }, error => {
                        reject(error);
                    }).finally(() => {
                        commit('setEstimatesLoading', false);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },
    },
    mutations: {
        loadOrders(state, item) {
            state.orders = item.data;
            state.orders_pagination = item.pagination;
        },
        setOrdersLoading(state, item) {
            state.orders_loading = item;
        },

        setEstimates(state, item) {
            state.estimates = item.data;
            state.estimates_pagination = item.pagination;
        },
        setEstimatesLoading(state, item) {
            state.estimates_loading = item;
        },

        setPayments(state, item) {
            state.payments = item.data;
            state.payments_pagination = item.pagination;
        },
        setPaymentsLoading(state, item) {
            state.payments_loading = item;
        },
    },
    state: {
        orders: [],
        orders_loading: false,
        orders_pagination: {},

        estimates: [],
        estimates_loading: false,
        estimates_pagination: {},

        payments: [],
        payments_loading: false,
        payments_pagination: {},
    },
    getters: {
        orders: state => state.orders,
        orders_loading: state => state.orders_loading,
        orders_pagination: state => state.orders_pagination,

        estimates: state => state.estimates,
        estimates_payment: state => state.estimates.filter(e => e.status == 3 || e.status == 5),
        estimates_payment_count: state => state.estimates.filter(e => e.status == 3 || e.status == 5).length,
        estimates_loading: state => state.estimates_loading,
        estimates_pagination: state => state.estimates_pagination,

        payments: state => state.payments,
        payments_loading: state => state.payments_loading,
        payments_pagination: state => state.payments_pagination,
    }
}
