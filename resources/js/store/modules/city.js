import axios from "axios";
import localStorageHelper from "../../helpers/localStorageHelper";

export default {
    actions: {
        async fetchCities({commit}) {
            try {
                const cachedCities = localStorageHelper.getItem('cachedCities');
                if (cachedCities && cachedCities.length > 0) {
                    commit('loadCities', cachedCities);
                    return cachedCities;
                } else {
                    const response = await axios.get('/api/filter/cities/list');
                    const cities = response.data.data;
                    commit('loadCities', cities);
                    localStorageHelper.setItem('cachedCities', cities);
                    return cities;
                }
            } catch (error) {
                console.error('Ошибка при получении списка городов:', error);
                throw error;
            }
        },
        async fetchCitiesWithTrashed({commit}) {
            axios.get('city/list_with_trashed').then(response => {
                commit('loadCitiesWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftCity({commit}, item) {
            axios.delete('city/softDelete' + item.id).then((response) => {
                commit('softDeleteCity', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delForceCity({commit}, item) {
            axios.delete('city/delete' + item.id).then((response) => {
                commit('forceDeleteCities', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        restoreCity({commit}, item) {
            axios.post('city/restore' + item.id).then((response) => {
                commit('restoreCity', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setCity({commit}, item) {
            axios.put('city/update' + item.id, {
                'title': item.title,
                'region_id': item.region_id,
            }).then(response => {
                commit('updateCity', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeCity({commit}, item) {
            axios.post('city/create', {
                'title': item.title,
                'region_id': item.region_id,
            }).then(response => {
                commit('createCity', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadCities(state, item) {
            state.city = item;
        },
        loadCitiesWithTrashed(state, item) {
            state.city = item
        },
        forceDeleteCities(state, item) {
            let index = state.city_with_trashed.findIndex(p => p.id === item.id)
            state.city_with_trashed.splice(index, 1);
        },
        updateCity(state, item) {
            let index = state.city.findIndex(p => p.id === item.id)
            state.city[index] = item
        },
        createCity(state, item) {
            let index = state.city.findIndex(p => p.id === item.id)
            state.city.unshift(index)
        },
        restoreCity(state, item) {
            let index = state.city_with_trashed.findIndex(p => p.id === item.id)
            state.city_with_trashed.splice(index, 1);

            let index2 = state.city.findIndex(p => p.id === item.id)
            state.city.unshift(index2)
        },
        softDeleteCity(state, item) {
            let index = state.city.findIndex(p => p.id === item.id)
            state.city.splice(index, 1);

            let index2 = state.city_with_trashed.findIndex(p => p.id === item.id)
            state.city_with_trashed[index2] = item
        }
    },
    state: {
        city: [],
        city_with_trashed: []
    },
    getters: {
        AllCities: state => state.city,
        AllCitiesWithTrashed: state => state.city_with_trashed,
        CityWithRegionId: (state) => (region_id) => {
            return state.city.filter(p => p.region_id.id === region_id);
        },
    }
}
