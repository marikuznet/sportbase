import axios from "axios";
import localStorageHelper from "../../helpers/localStorageHelper";

export default {
    actions: {
        async fetchServices({commit}) {
            try {
                const cachedServices = localStorageHelper.getItem('cachedServices');
                if (cachedServices && cachedServices.length > 0) {
                    commit('loadServices', cachedServices);
                    return cachedServices;
                } else {
                    const response = await axios.get('/service/list');
                    const services = response.data;
                    commit('loadServices', services);
                    localStorageHelper.setItem('cachedServices', services);
                    return services;
                }
            } catch (error) {
                console.error('Ошибка при получении списка видов спорта:', error);
                throw error;
            }

            await axios.get('/service/list').then(response => {
                commit('loadServices', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async getServicesInObjects({commit}) {
            await axios.get('/api/filter/sport-object/services/list').then(response => {
                commit('loadServices', response.data.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async fetchServicesWithTrashed({commit}) {
            axios.get('service/list_with_trashed').then(response => {
                commit('loadServicesWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftService({commit}, item) {
            axios.delete('service/softDelete' + item.id).then((response) => {
                commit('softDeleteService', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delForceService({commit}, item) {
            axios.delete('service/delete' + item.id).then((response) => {
                commit('forceDeleteServices', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        restoreService({commit}, item) {
            axios.post('service/restore' + item.id).then((response) => {
                commit('restoreService', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setService({commit}, item) {
            axios.put('service/update' + item.id, {
                'title': item.title,
            }).then(response => {
                commit('updateService', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeService({commit}, item) {
            axios.post('service/create', {
                'title': item.title,
            }).then(response => {
                commit('createService', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadServices(state, item) {
            state.service = item;
        },
        loadServicesWithTrashed(state, item) {
            state.service = item
        },
        forceDeleteServices(state, item) {
            let index = state.service_with_trashed.findIndex(p => p.id === item.id)
            state.service_with_trashed.splice(index, 1);
        },
        updateService(state, item) {
            let index = state.service.findIndex(p => p.id === item.id)
            state.service[index] = item
        },
        createService(state, item) {
            let index = state.service.findIndex(p => p.id === item.id)
            state.service.unshift(index)
        },
        restoreService(state, item) {
            let index = state.service_with_trashed.findIndex(p => p.id === item.id)
            state.service_with_trashed.splice(index, 1);

            let index2 = state.service.findIndex(p => p.id === item.id)
            state.service.unshift(index2)
        },
        softDeleteService(state, item) {
            let index = state.service.findIndex(p => p.id === item.id)
            state.service.splice(index, 1);

            let index2 = state.service_with_trashed.findIndex(p => p.id === item.id)
            state.service_with_trashed[index2] = item
        }
    },
    state: {
        service: [],
        service_with_trashed: []
    },
    getters: {
        AllServices(state) {
            return state.service;
        },
        AllServicesWithTrashed(state) {
            return state.service_with_trashed;
        }
    }
}
