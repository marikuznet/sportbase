import axios from "axios";

export default {
    state: {
        filters: {
            object: [],
            food: [],
            services: [],
            infrastructures: []
        },
        filtersSportObject: {
            sports: [],
            regions: [],
            services: [],
            infrastructures: []
        },
        responseData: {
            typeSports: [],
            cities: [],
            infrastructures: [],
            typeFoods: [],
            additions: [],
        }
    },
    actions: {
        async getFilters({commit}, payload) {
            return axios.get('/api/v1/filters')
                .then(resp => {
                    commit('setFilters', resp.data)
                });
        },
        async getFiltersForSportObject({commit}) {
            return axios.get('/api/filter')
                .then(resp => {
                    commit('setFiltersSportObject', resp.data)
                });
        },
        async getDataResponse({commit}, payload) {
            return await axios.get('/api/v1/data/response')
                .then(resp => {
                    commit('setDataResponse', resp.data)
                });
        },
    },
    getters: {
        filters: state => state.filters,
        filtersSportObject: state => state.filtersSportObject,
        responseData: state => state.responseData
    },
    mutations: {
        setFilters(state, payload) {
            return state.filters = payload;
        },
        setFiltersSportObject(state, payload) {
            return state.filtersSportObject = payload;
        },
        setDataResponse(state, payload) {
            return state.responseData = payload;
        },
    }
}
