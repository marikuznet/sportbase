import axios from "axios";

export default {
    actions: {
        async fetchPaymentDetails({commit}, item) {
            return await new Promise((resolve, reject) => {
                let query = '/payment-details/list';
                if (item && item.user_id != null) query + `?user_id=${item.user.id}`;
                axios.get('/payment-details/list').then(
                    result => {
                        commit('loadPaymentDetails', result.data.data)
                        resolve(result.data.data);
                    }).catch(err => {
                    reject(err.response.data);
                });
            });

          /*  return axios.get('/payment-details/list').then(response => {
                return commit('loadPaymentDetails', response.data)
            }).catch((error) => {
                console.log(error.response);
            });*/
        },
        async getPaymentDetailsByUser({commit}) {
            return await new Promise((resolve, reject) => {
                axios.get(`/payment-details/user`).then(
                    result => {
                        commit('loadPaymentDetails', result.data.data)
                        resolve(result.data.data);
                    }).catch(err => {
                    reject(err.response.data);
                });
            });
        },
        async fetchPaymentDetailsWithTrashed({commit}) {
            axios.get('payment_details/list_with_trashed').then(response => {
                commit('loadRegionsWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setPaymentDetails({commit}, item) {
            axios.put('/payment-details/update', {
                'id': item.id,
                'legal_name': item.legal_name,
                'title': item.title,
                'tin': item.tin,
                'numKpp': item.numKpp,
                'bic': item.bic,
                'requisites': item.requisites,
                'kc': item.kc,
                'okpo': item.okpo,
                'okato': item.okato,
                'orgn': item.orgn,
                'user_id': user.id,
                'address_id': item.address_id,
                'city_id': item.city_id,
                'postIndex': item.postIndex,
                'address': item.address,
                //'longtitude': item.longtitude,
                //'latitude': item.latitude
            }).then(response => {
                console.log(response);
                commit('updatePaymentDetails', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadPaymentDetails(state, item) {
            state.payment_details = item;
        },
        loadPaymentDetailsWithTrashed(state, item) {
            state.payment_details = item
        },
        updatePaymentDetails(state, item) {
            let index = state.payment_details.findIndex(p => p.id === item.id)
            state.payment_details[index] = item
        },
    },
    state: {
        payment_details: [],
        payment_details_with_trashed: []
    },
    getters: {
        AllPaymentDetails(state) {
            return state.payment_details;
        },
        InfoPayment: (state) => (user_id) => {
            return state.payment_details.filter(p => p.user_id == user_id)[0];
        },
        AllPaymentDetailsWithTrashed(state) {
            return state.payment_details_with_trashed;
        }
    }
}
