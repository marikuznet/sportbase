import axios from "axios";
import localStorageHelper from "../../helpers/localStorageHelper";

export default {
    actions: {
        async fetchRegions({commit}) {
            try {
                const cachedRegions = localStorageHelper.getItem('cachedRegions');
                if (cachedRegions && cachedRegions.length > 0) {
                    commit('loadRegions', cachedRegions);
                    return cachedRegions;
                } else {
                    const response = await axios.get('/api/filter/regions/list');
                    const regions = response.data.data;
                    commit('loadRegions', regions);
                    localStorageHelper.setItem('cachedRegions', regions);
                    return regions;
                }
            } catch (error) {
                console.error('Ошибка при получении списка регионов:', error);
                throw error;
            }
        },
        async fetchRegionsWithTrashed({commit}) {
            axios.get('region/list_with_trashed').then(response => {
                commit('loadRegionsWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftRegion({commit}, item) {
            axios.delete('region/softDelete' + item.id).then((response) => {
                commit('softDeleteRegion', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delForceRegion({commit}, item) {
            axios.delete('region/delete' + item.id).then((response) => {
                commit('forceDeleteRegions', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        restoreRegion({commit}, item) {
            axios.post('region/restore' + item.id).then((response) => {
                commit('restoreRegion', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setRegion({commit}, item) {
            axios.put('region/update' + item.id, {
                'title': item.title,
            }).then(response => {
                commit('updateRegion', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeRegion({commit}, item) {
            axios.post('region/create', {
                'title': item.title,
            }).then(response => {
                commit('createRegion', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadRegions(state, item) {
            state.region = item;
        },
        loadRegionsWithTrashed(state, item) {
            state.region = item
        },
        forceDeleteRegions(state, item) {
            let index = state.region_with_trashed.findIndex(p => p.id === item.id)
            state.region_with_trashed.splice(index, 1);
        },
        updateRegion(state, item) {
            let index = state.region.findIndex(p => p.id === item.id)
            state.region[index] = item
        },
        createRegion(state, item) {
            let index = state.region.findIndex(p => p.id === item.id)
            state.region.unshift(index)
        },
        restoreRegion(state, item) {
            let index = state.region_with_trashed.findIndex(p => p.id === item.id)
            state.region_with_trashed.splice(index, 1);

            let index2 = state.region.findIndex(p => p.id === item.id)
            state.region.unshift(index2)
        },
        softDeleteRegion(state, item) {
            let index = state.region.findIndex(p => p.id === item.id)
            state.region.splice(index, 1);

            let index2 = state.region_with_trashed.findIndex(p => p.id === item.id)
            state.region_with_trashed[index2] = item
        }
    },
    state: {
        region: [],
        region_with_trashed: []
    },
    getters: {
        AllRegions: state => state.region,
        AllRegionsWithTrashed: state => state.region_with_trashed,
        RegionsWithCountryId: (state) => (country_id) => {
            return state.region.filter(p => p.country_id == country_id);
        },
    }
}
