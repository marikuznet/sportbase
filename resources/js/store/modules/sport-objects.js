import axios from "axios";

export default {
    actions: {
        async fetchSportObjects({commit, state}, item) {
            commit('setSportObjectsLoading', true);
            await axios.put(`/api/sport-objects?page=${item.page}&total=${item.total}`, {filter: item.filters})
                .then((response) => {
                    commit('loadSportObjects', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('loadSportObjects', {data: [], pagination: {}});
                }).finally(() => commit('setSportObjectsLoading', false))
        },
        async fetchSportObjectsWithoutPage({commit}) {
            commit('setSportObjectsLoading', true);
            return await new Promise((resolve, reject) => {
                axios.get(`/api/sport-objects/without-page`).then(
                    result => {
                        commit('loadSportObjects', result.data.data);
                        resolve(result.data.data);
                    }).catch(err => {
                    console.log(error);
                    reject(err.response.data);
                    commit('loadSportObjects', {data: [], pagination: {}});
                }).finally(() => commit('setSportObjectsLoading', false));
            });
        },
        async fetchFavourites({commit, state}, item) {
            commit('setSportObjectsLoading', true);
            await axios.get(`/api/favourites`)
                .then((response) => {
                    commit('loadSportObjects', response.data);
                    return response.data;
                }).catch((error) => {
                    console.log(error);
                    commit('loadSportObjects', {data: [], pagination: {}});
                }).finally(() => commit('setSportObjectsLoading', false))
        },

        async fetchSportObjectsByUser({commit}, item) {
            commit("setSportObjectsLoading", true);
            try {
                const limit = item.limit ?? 10;
                const page = item.page ?? 1;
                const filter = item.filter;
                return await new Promise((resolve, reject) => {
                    axios.put(`/api/sport-objects/user`, {
                        limit, page, filter
                    }).then(response => {
                        commit('loadSportObjects', response.data)
                        resolve(response);
                    }, error => {
                        reject(error);
                    }).finally(() => {
                        commit("setSportObjectsLoading", false);
                    })
                })
            } catch (error) {
                console.log(error);
            }
        },

        async getUserSportObjects({commit}, item) {
            await axios.get(`/api/sport-objects/user/${item.id}`).then((response) => {
                commit('loadSportObjects', response.data);
            })
        },

        async getPopularSportObjects({commit}, item) {
            return await axios.post(`/api/sport-objects/popular`, item)
                .then((response) => {
                    commit('loadSportObjects', response.data);
                    return response.data.data;
                }).catch((error) => {
                    console.log(error);
                    commit('loadSportObjects', {data: []});
                })
        },

        async pauseAdvertisement({commit}, item) {
            await axios.post(`/sport-objects/advertisement/${item.id}/stop`, item.data);
        },

        async continueAdvertisement({commit}, item) {
            await axios.get(`/sport-objects/advertisement/${item.id}/resume`);
        },

        async visibleSportObject({commit}, item) {
            await axios.put('/api/sportObject/visible/' + item.id, {
                visible: item.visible,
            });
        },
        async verifySportObject({commit}, item) {
            await axios.put('/api/sportObject/verify/' + item.id).then(response => {
                commit('updateSportObject', response.data)
            });
        },
        async delForceSportObject({commit}, item) {
            await axios.delete('/api/sportObject/delete/' + item.id).then((response) => {
                commit('forceDeleteSportObject', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async delSoftSportObject({commit}, item) {
            commit('setSportObjectsLoading', true);
            await axios.delete('sport_objects/softDelete' + item.id).then((response) => {
                commit('forceDeleteSportObject', item)
            }).catch((error) => {
                console.log(error.response);
            }).finally(() => commit('setSportObjectsLoading', true));
        },
        setSportObject({commit}, item) {
            axios.put('/sport-objects/update/' + item.id, {
                'edit': true,
                'title': item.title,
                'objectType': item.objectType_id,
                'objectType_id': item.objectType.id,
                'images': JSON.stringify(item.images),
                'storageImages': JSON.stringify(item.storageImages),
                'files': item.files,
                'description': item.description,
                'sportType_id': 1,
                'accomodationConditionAndPricing_id': item.accomodationConditionAndPricing_id,
                'included': item.pricing.included,
                'included_id': item.pricing.included_id,
                'accCondPricing_id': item.pricing.accCondPricing_id,
                'pricing_description': item.pricing.description,
                'city_id': item.address.city_id,
                'address': item.address.street,
                'postIndex': item.address.postIndex,
                'longtitude': item.address.longtitude,
                'latitude': item.address.latitude,
                'rating': 0,
                'user_id': item.user_id,
                'visible': 0,
                'verify': 0,
                'typeLiving': item.pricing.typeLiving,
                'infrastructures': item.pricing.infrastructures,
                'services': item.services,
                'sports': item.sports,
            }).then(response => {
                commit('updateSportObject', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setAdminSportObject({commit}, item) {
            axios.put('/admin/sport-objects/update/' + item.id, {
                'edit': true,
                'title': item.title,
                'objectType': item.objectType_id,
                'objectType_id': item.objectType.id,
                'images': JSON.stringify(item.images),
                'storageImages': JSON.stringify(item.storageImages),
                'files': item.files,
                'description': item.description,
                'sportType_id': 1,
                'accomodationConditionAndPricing_id': item.accomodationConditionAndPricing_id,
                'included': item.pricing.included,
                'included_id': item.pricing.included_id,
                'accCondPricing_id': item.pricing.accCondPricing_id,
                'pricing_description': item.pricing.description,
                'city_id': item.address.city_id,
                'address': item.address.street,
                'postIndex': item.address.postIndex,
                'longtitude': item.address.longtitude,
                'latitude': item.address.latitude,
                'rating': 0,
                'user_id': item.user_id,
                'visible': 0,
                'verify': 0,
                'typeLiving': item.pricing.typeLiving,
                'infrastructures': item.pricing.infrastructures,
                'services': item.services,
                'sports': item.sports,
            }).then(response => {
                commit('updateSportObject', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async storeSportObject({commit}, item) {
            return await new Promise((resolve, reject) => {
                axios.put('/sportObject/create', {
                    'title': item.title,
                    'objectType_id': item.objectType.id,
                    'image': item.storageImages,
                    'files': item.files,
                    'description': item.description,
                    'sportType_id': 1,
                    'accomodationConditionAndPricing_id': item.accCondPricing_id,
                    'city_id': item.address.city_id,
                    'address': item.address.street,
                    'postIndex': item.address.postIndex,
                    'longtitude': item.address.longtitude,
                    'latitude': item.address.latitude,
                    'rating': 0,
                    'user_id': item.user_id,
                    'visible': 0,
                    'verify': 0,
                    'typeLiving': item.pricing.typeLiving,
                    'infrastructures': item.pricing.infrastructures,
                    'services': item.services,
                    'sports': item.sports,
                }).then(response => {
                    resolve(response);
                }, error => {
                    reject(error);
                })
            })
        },
        setStoreSportObject({commit}, item) {
            if (item.edit) commit("setEditStore", item);
            else commit("setStore", item);
        },

        async adminFetchSportObjects({commit}) {
            commit('setSportObjectsLoading', true);
            return await new Promise((resolve, reject) => {
                axios.get(`/admin/api/sport-objects`)
                    .then((response) => {
                        commit('loadSportObjects', response.data);
                        resolve(response.data);
                    })
            }, error => {
                reject(error);
            }).finally(() => {
                commit('setSportObjectsLoading', false);
            })
        },

        async adminSportObjectsStatistic({commit}) {
            await axios.get(`/admin/api/sport-objects/statistic`)
                .then((response) => {
                    commit('setSportObjectsAdminStatistic', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setSportObjectsAdminStatistic', {data: []});
                })
        },

    },
    mutations: {
        setSportObjectsAdminStatistic(state, item) {
            return state.sport_objects_admin = item;
        },

        setSportObjectId(state, item) {
            return state.sport_object_id = item;
        },

        setStore(state, item) {
            state.sport_objects[0] = item;
            if (item.title) {
                localStorage.setItem(item.title, JSON.stringify(item.object));
            } else localStorage.setItem('object', JSON.stringify(item.object));
        },
        setEditStore(state, item) {
            state.sport_objects[0] = item;
            if (item.title) {
                localStorage.setItem(item.title, JSON.stringify(item.object));
            } else localStorage.setItem('object', JSON.stringify(item.object));
        },
        loadSportObjects(state, item) {
            state.sport_objects = item.data;
            state.sport_objects_meta = item.pagination;
        },
        forceDeleteSportObject(state, item) {
            state.sport_objects.filter(res => res.id !== item.id);
            state.sport_objects.splice(res => res.id, 1);
        },
        updateSportObject(state, item) {
            let index = state.sport_objects.findIndex(p => p.id === item.id)
            state.sport_objects[index] = item
        },
        setSportObjectsLoading(state, payload) {
            return state.sport_objects_loading = payload;
        },
    },
    state: {
        sport_objects: [],
        sport_object_id: null,
        sport_objects_meta: {},
        sport_objects_with_trashed: [],

        sport_objects_admin: {
            "checkinSportObjectsCount": 0,
            "checkedSportObjectsCount": 0,
        },
        sport_objects_loading: false,
    },
    getters: {
        sport_objects_admin_statistic: state => state.sport_objects_admin,

        AllSportObjects: state => {
            if (!Array.isArray(state.sport_objects)) {
                return []; // Return an empty array if sport_objects is not defined or not an array
            }

            return state.sport_objects.sort((a, b) => {
                const score = (obj) => {
                    return (obj.hasPromotion ? 2 : 0) + (obj.hasHighlightion ? 1 : 0);
                };

                return score(b) - score(a);
            });
        },

        sport_objects_verify: state => state.sport_objects.filter(p => p.verify === 1 && p.visible === 1),
        sport_objects_loading: state => state.sport_objects_loading,
        sport_objects_pagination: state => state.sport_objects_meta,
        sport_object_id: state => state.sport_object_id,

        CreateSportObject: state => state.sport_objects[0],

        AllSportObjectsChecking: state => state.sport_objects.filter(p => p.verify === 0),
        AllSportObjectsChecked: state => state.sport_objects.filter(p => p.verify === 1),


        SportObject: (state) => (id) => {
            return state.sport_objects.filter(p => p.id == id)[0];
        },

        AllSportObjectsWithTrashed: state => state.sport_objects_with_trashed,
    }
}
