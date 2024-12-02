import axios from "axios";

export default {
    actions: {
        async getAdvertisingTariffs({commit}) {
            commit("setAdvertisingTariffsLoading", true);
            await axios.get('/api/advertising_tariffs').then((response) => {
                commit('loadAdvertisingTariffs', response.data.data);
            }).finally(() => commit('setAdvertisingTariffsLoading', false));
        },
        async setAdvertisementTitle({commit}, item) {
            await axios.post('/admin/api/tariff/update/' + item.id, item).then(response => {
                console.log(response);
                commit('updateAdvertisingTariff', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async setAdvertisementPrice({commit}, item) {
            await axios.post('/admin/api/advertisements/tariff/price/update/' + item.id, item).then(response => {
                commit('updateAdvertisingTariffPrice', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },

        async getAdvertisements({commit}, item) {
            commit('setAdvertisementLoading', true);
            await axios.get('/admin/api/advertisements').then(response => {
                commit('loadAdvertisements', response.data.data)
            }).finally(() => commit('setAdvertisementLoading', false)
            )
        },

        async getPaymentAdvertisements({commit}, item) {
            commit('setPaymentAdvertisementsLoading', true);
            await axios.get('/admin/api/advertisements/payments').then(response => {
                commit('loadPaymentAdvertisements', response.data.data)
            }).finally(() => commit('setPaymentAdvertisementsLoading', false)
            )
        },
    },
    mutations: {
        loadAdvertisingTariffs(state, item) {
            state.advertising_tariffs = item;
        },
        setAdvertisingTariffsLoading(state, item) {
            state.advertising_tariffs_loading = item;
        },
        updateAdvertisingTariff(state, item) {
            let index = state.advertising_tariffs.findIndex(p => p.id === item.id)
            state.advertising_tariffs[index].title = item.title
            state.advertising_tariffs[index].description = item.description
        },
        updateAdvertisingTariffPrice(state, item) {
            let index = state.advertising_tariffs.findIndex(p => p.id === item.id)
            state.advertising_tariffs[index].price = item.price
        },

        loadAdvertisements(state, item) {
            state.advertisements = item;
        },
        setAdvertisementLoading(state, item) {
            state.advertisements_loading = item;
        },

        loadPaymentAdvertisements(state, item) {
            state.payment_advertisements = item;
        },
        setPaymentAdvertisementsLoading(state, item) {
            state.payment_advertisements_loading = item;
        }
    },
    state: {
        advertising_tariffs: [],
        advertising_tariffs_loading: false,

        advertisements: [],
        advertisements_loading: false,

        payment_advertisements: [],
        payment_advertisements_loading: [],
    },
    getters: {
        advertising_tariffs: state => state.advertising_tariffs,
        advertising_tariffs_loading: state => state.advertising_tariffs_loading,

        advertisements: state => state.advertisements,
        advertisement_loading: state => state.advertisements_loading,

        payment_advertisements: state => state.payment_advertisements,
        payment_advertisements_count: state => state.payment_advertisements.length,
        payment_advertisements_loading: state => state.payment_advertisements_loading,
    }
}
