import axios from "axios";

export default {
    actions: {
        async fetchDealsReviews({commit}, item) {
            return await new Promise((resolve, reject) => {
                let query = '/deals_reviews/list';
                axios.get(item?.total ? query + `?page=${item?.page || 1}&total=${item?.total || 10}&sort=${item.sort}` : query).then(
                    result => {
                        commit('loadDealsReviews', result.data.data)
                        resolve(result.data);
                    }).catch(err => {
                    reject(err.response);
                });
            });
        },
        async getReviews({commit}, item) {
            commit('setReviewsLoading', true)
            try {
                const status = item.status ?? 'executor';
                const limit = item.limit ?? 10;
                const page = item.page ?? 1;
                const filter = item.filter;
                return await new Promise((resolve, reject) => {
                    axios.put(`/reviews/data`, {
                        status, limit, page, filter
                    }).then(response => {
                        commit('setReviews', response.data);
                        resolve(response);
                    }, error => {
                        reject(error);
                    }).finally(() => {
                        commit('setReviewsLoading', false)
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },
        async fetchReviews({commit}, item) {
            commit('setReviewsLoading', true);
            try {
                const sort = item.sort;
                const limit = item.limit;
                const page = item.page;
                return await new Promise((resolve, reject) => {
                    axios.get(`/api/reviews/sport-object/${item.sportObjectId}`, {
                        params: {sort, limit, page},
                    }).then(response => {
                        commit('setReviews', response.data);
                        resolve(response);
                    }, error => {
                        reject(error);
                    }).finally(() => {
                        commit('setReviewsLoading', false);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },
        async fetchDealsCooperationFeedbackAdmin({commit}) {
            axios.put('/admin/api/feedbacks').then(response => {
                commit('loadDealsReviews', response.data.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeDealReview({commit}, item) {
            axios.put('/review/create', {
                'deal_id': item.deal_id,
                'user_id': item.user_id,
                'infrastructure': item.infrastructure,
                'sport_object': item.sport_object,
                'food': item.food,
                'territory': item.territory,
                'place': item.place,
                'price': item.price,
                'text': item.text,
                'status': item.status,
            }).then(response => {
                commit('createDealReview', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delDealReview({commit}, item) {
            axios.delete('/review/delete/' + item.id).then((response) => {
                commit('deleteDealReview', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        verifyReview({commit}, item) {
            axios.put('/review/verify/' + item.id).then(response => {
                commit('updateDealReview', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        refusedReview({commit}, item) {
            axios.put('/review/refused/' + item.id).then(response => {
                commit('updateDealReview', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        }
    },
    mutations: {
        setReviews(state, item) {
            state.reviews = item.data;
            state.reviews_pagination = item.pagination;
        },
        setReviewsLoading(state, item) {
            state.reviews_loading = item;
        },

        loadDealsReviews(state, item) {
            state.deals_reviews = item;
        },
        deleteDealReview(state, item) {
            let index = state.deals_reviews_with_trashed.findIndex(p => p.id === item.id)
            state.deals_reviews_with_trashed.splice(index, 1);
        },
        updateDealReview(state, item) {
            let index = state.deals_reviews.findIndex(p => p.id === item.id)
            state.deals_reviews[index] = item
        },
        createDealReview(state, item) {
            let index = state.deals_reviews.findIndex(p => p.id === item.id)
            state.deals_reviews.unshift(index)
        },
    },
    state: {
        deals_reviews: [],

        reviews: [],
        reviews_pagination: {},
        reviews_loading: false,
    },
    getters: {
        getReviews: state => state.reviews,
        getReviewsLoading: state => state.reviews_loading,
        getReviewsPagination: state => state.reviews_pagination,

        AllDealsReviews(state) {
            return state.deals_reviews;
        },
        AllDealsReviewsVerified(state) {
            return state.deals_reviews.filter(p => p.status == 1);
        },
        GetDealReview: state => (deal_id) => {
            //return state.deals_reviews.filter(p => p.deal_id == deal_id)[0];
        },


        /**Admin*/
        AllFeedbacksModeratingCount(state) {
            return state.deals_reviews.filter(p => p.status == 0).length;
        },
        AllFeedbacksAcceptedCount(state) {
            return state.deals_reviews.filter(p => p.status == 1).length;
        },
        AllFeedbacksRefusedCount(state) {
            return state.deals_reviews.filter(p => p.status == 2).length;
        },
        AllFeedbacksModerating(state) {
            return state.deals_reviews.filter(p => p.status == 0);
        },
        AllFeedbacksAccepted(state) {
            return state.deals_reviews.filter(p => p.status == 1);
        },
        AllFeedbacksRefused(state) {
            return state.deals_reviews.filter(p => p.status == 2);
        },
    }
}
