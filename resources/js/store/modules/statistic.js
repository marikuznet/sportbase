import axios from "axios";

export default {
    actions: {
        async getSportObjectsStatistic({commit}, payload) {
            await axios.get('/api/stats/sport-objects', payload)
                .then(resp => {
                    commit('setSportObjectsStatistic', resp.data)
                });
        },
        async getStatisticOrders({commit}) {
            await axios.get(`/api/stats/orders`)
                .then((response) => {
                    commit('setOrdersStatistic', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setOrdersStatistic', {data: []});
                })
        },
        async getStatisticsByDirect({commit}) {
            await axios.get(`/api/stats/directs`)
                .then((response) => {
                    commit('setDirectsStatistic', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setDirectsStatistic', {data: []});
                })
        },
    },
    mutations: {
        setSportObjectsStatistic(state, item) {
            return state.sport_objects_statistic = item;
        },
        setOrdersStatistic(state, item) {
            state.statistic_orders = item;
        },
        setDirectsStatistic(state, item) {
            state.statistic_directs = item;
        },
    },
    state: {
        sport_objects_statistic: {
            "activeSportObjectsCount": 0,
            "nonactiveSportObjectsCount": 0,
            "allSportObjectsCount": 0,
            "mySportObjectsCount": 0
        },
        statistic_orders: {
            'activeOrdersCount': 0,
            'estimatesCount': 0,
            'paymentsCount': 0,
        },
        statistic_directs: {
            'activeCount': 0,
            'archiveCount': 0
        },
    },
    getters: {
        sport_objects_statistic: state => state.sport_objects_statistic,
        getDirectStatistic: state => state.statistic_directs,
        activeOrdersCount: state => state.statistic_orders.activeOrdersCount,
        paymentsCount: state => state.statistic_orders.paymentsCount,
        estimatesCount: state => state.statistic_orders.estimatesCount,
    }
}
