import axios from "axios";

export default {
    actions: {
        async adminMainStatistic({commit}) {
            return await axios.get(`/admin/api/statistic/main`)
                .then((response) => {
                    commit('setMainAdminStatistic', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setMainAdminStatistic', {data: []});
                })
        },
        async adminFinanceStatistic({commit}) {
            return await axios.get(`/admin/api/statistic/finance`)
                .then((response) => {
                    commit('setFinanceAdminStatistic', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setFinanceAdminStatistic', {data: []});
                })
        },
        async adminUsersStatistic({commit}) {
            return await axios.get(`/admin/api/statistic/users`)
                .then((response) => {
                    commit('setUsersAdminStatistic', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setUsersAdminStatistic', {data: []});
                })
        },
        async adminFinancesIncomeStatistic({commit}) {
            return await axios.get(`/admin/api/statistic/finance-income`)
                .then((response) => {
                    commit('setFinanceIncomeAdminStatistic', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setFinanceIncomeAdminStatistic', {data: []});
                })
        }
    },
    mutations: {
        setMainAdminStatistic(state, item) {
            return state.statistic_admin_main = item;
        },
        setFinanceAdminStatistic(state, item) {
            return state.statistic_admin_finance = item;
        },
        setUsersAdminStatistic(state, item) {
            return state.statistic_admin_users = item;
        },
        setFinanceIncomeAdminStatistic(state, item) {
            return state.statistic_admin_finance_income = item;
        },
    },
    state: {
        statistic_admin_main: {
            'customersCount': 0,
            'executorsCount': 0,
            'objectsCount': 0,
            'dealsCount': 0
        },
        statistic_admin_finance: {
            'estimatesCount': 0,
            'paymentAdvertisementCount': 0,
            'paymentPerformers': 0
        },
        statistic_admin_users: {
            'customersCount': 0,
            'executorsCount': 0,
            'verifyCustomersCount': 0,
            'verifyExecutorsCount': 0,
            'blockCustomersCount': 0,
            'blockExecutorsCount': 0
        },
        statistic_admin_finance_income: {
            'all_money': 0,
            'money_advertisements': 0,
            'money_deals': 0,
            'paid_executor': 0
        }
    },
    getters: {
        admin_main_statistic(state) {
            return state.statistic_admin_main;
        },
        admin_users_statistic(state) {
            return state.statistic_admin_users;
        },
        admin_finance_statistic(state) {
            return state.statistic_admin_finance;
        },
        admin_finance_finance_income(state) {
            return state.statistic_admin_finance_income;
        }
    }
}
