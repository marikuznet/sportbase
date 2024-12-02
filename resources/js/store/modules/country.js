import axios from "axios";
import localStorageHelper from '../../helpers/localStorageHelper';

export default {
    actions: {
        async fetchCountries({ commit }) {
            try {
                const cachedCountries = localStorageHelper.getItem('cachedCountries');
                if (cachedCountries && cachedCountries.length > 0) {
                    commit('loadCountries', cachedCountries);
                    return cachedCountries;
                } else {
                    const response = await axios.get('/api/v1/country/list');
                    const countries = response.data.data;
                    commit('loadCountries', countries);
                    localStorageHelper.setItem('cachedCountries', countries);
                    return countries;
                }
            } catch (error) {
                console.error('Ошибка при получении списка стран:', error);
                throw error;
            }
        },
        async fetchCountriesWithTrashed({commit}) {
            axios.get('country/list_with_trashed').then(response => {
                commit('loadCountriesWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftCountry({commit}, item) {
            axios.delete('country/softDelete' + item.id).then((response) => {
                commit('softDeleteCountry', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delForceCountry({commit}, item) {
            axios.delete('country/delete' + item.id).then((response) => {
                commit('forceDeleteCountries', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        restoreCountry({commit}, item) {
            axios.post('country/restore' + item.id).then((response) => {
                commit('restoreCountry', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setCountry({commit}, item) {
            axios.put('country/update' + item.id, {
                'title': item.title,
            }).then(response => {
                commit('updateCountry', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeCountry({commit}, item) {
            axios.post('country/create', {
                'title': item.title,
            }).then(response => {
                commit('createCountry', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadCountries(state, item) {
            state.country = item;
        },
        loadCountriesWithTrashed(state, item) {
            state.country = item
        },
        forceDeleteCountries(state, item) {
            let index = state.country_with_trashed.findIndex(p => p.id === item.id)
            state.country_with_trashed.splice(index, 1);
        },
        updateCountry(state, item) {
            let index = state.country.findIndex(p => p.id === item.id)
            state.country[index] = item
        },
        createCountry(state, item) {
            let index = state.country.findIndex(p => p.id === item.id)
            state.country.unshift(index)
        },
        restoreCountry(state, item) {
            let index = state.country_with_trashed.findIndex(p => p.id === item.id)
            state.country_with_trashed.splice(index, 1);

            let index2 = state.country.findIndex(p => p.id === item.id)
            state.country.unshift(index2)
        },
        softDeleteCountry(state, item) {
            let index = state.country.findIndex(p => p.id === item.id)
            state.country.splice(index, 1);

            let index2 = state.country_with_trashed.findIndex(p => p.id === item.id)
            state.country_with_trashed[index2] = item
        }
    },
    state: {
        country: localStorageHelper.getItem('cachedCountries') || [],
        country_with_trashed: []
    },
    getters: {
        AllCountries: state => state.country,
        AllCountriesWithTrashed: state => state.country_with_trashed,
    }
}
