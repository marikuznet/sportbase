import axios from "axios";

export default {
    actions: {
        async fetchNews({commit}, item) {
            commit('setNewsLoading', true);
            return await axios.put(`/api/news?page=${item.page}&total=${item.total}`)
                .then((response) => {
                    commit('loadNews', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('loadNews', {data: [], pagination: {}});
                }).finally(() => {
                    commit('setNewsLoading', false);
                })
        },

        async adminFetchNews({commit}) {
            commit('setNewsLoading', true);
            return await axios.get(`/admin/api/news`)
                .then((response) => {
                    commit('loadNewsAdmin', response.data.data);
                }).catch((error) => {
                    console.log(error);
                    commit('loadNewsAdmin', {data: []});
                }).finally(() => {
                    commit('setNewsLoading', false);
                })
        },

        async storeNews({commit}, payload) {
            return await axios.post('/admin/api/news/store', payload).then(response => {
                commit('createNews', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },

        async updateNews({commit}, payload) {
            return await axios.post('/admin/api/news/update/' + payload.id, payload).then(response => {
                //commit('createNews', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },

        async removeNews({commit}, payload) {
            return await axios.delete('/admin/api/news/delete/' + payload.id).then((response) => {
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadNews(state, item) {
            state.news = item.data;
            state.news_meta = item.pagination;
        },
        loadNewsAdmin(state, item) {
            state.news = item;
        },
        setNewsLoading(state, payload) {
            return (state.news_loading = payload);
        },
        createNews(state, payload) {
            let index = state.news.findIndex(p => p.id === payload.id)
            state.news.unshift(index)
        },
    },
    state: {
        news: [],
        news_loading: [],
        news_meta: {}
    },
    getters: {
        all_news(state) {
            return state.news;
        },
        news_loading(state) {
            return state.news_loading;
        },
        news_pagination(state) {
            return state.news_meta
        }
    }
}
