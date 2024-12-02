import axios from "axios";
import localStorageHelper from "../../helpers/localStorageHelper";

export default {
    actions: {
        async fetchSportTypes({commit}) {
            try {
                const cachedSportTypes = localStorageHelper.getItem('cachedSportTypes');
                if (cachedSportTypes && cachedSportTypes.length > 0) {
                    commit('loadSportTypes', cachedSportTypes);
                    return cachedSportTypes;
                } else {
                    const response = await axios.get('/api/filter/sport-types/list');
                    const sportTypes = response.data;
                    commit('loadSportTypes', sportTypes);
                    localStorageHelper.setItem('cachedSportTypes', sportTypes);
                    return sportTypes;
                }
            } catch (error) {
                console.error('Ошибка при получении списка видов спорта:', error);
                throw error;
            }
        },
        async getSportTypesInObjects({commit}) {
            await axios.get('/api/filter/sport-object/type-sports/list').then(resp => {
                commit('loadSportTypes', resp.data.data)
            })
        },
        async fetchSportTypesWithTrashed({commit}) {
            axios.get('sport_type/list_with_trashed').then(response => {
                commit('loadSportTypesWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftSportType({commit}, item) {
            axios.delete('sport_type/softDelete' + item.id).then((response) => {
                commit('softDeleteSportType', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delForceSportType({commit}, item) {
            axios.delete('sport_type/delete' + item.id).then((response) => {
                commit('forceDeleteSportTypes', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        restoreSportType({commit}, item) {
            axios.post('sport_type/restore' + item.id).then((response) => {
                commit('restoreSportType', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setSportType({commit}, item) {
            axios.put('sport_type/update' + item.id, {
                'title': item.title,
            }).then(response => {
                commit('updateSportType', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeSportType({commit}, item) {
            axios.post('sport_type/create', {
                'title': item.title,
            }).then(response => {
                commit('createSportType', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadSportTypes(state, item) {
            state.sport_type = item;
        },
        loadSportTypesWithTrashed(state, item) {
            state.sport_type = item
        },
        forceDeleteSportTypes(state, item) {
            let index = state.sport_type_with_trashed.findIndex(p => p.id === item.id)
            state.sport_type_with_trashed.splice(index, 1);
        },
        updateSportType(state, item) {
            let index = state.sport_type.findIndex(p => p.id === item.id)
            state.sport_type[index] = item
        },
        createSportType(state, item) {
            let index = state.sport_type.findIndex(p => p.id === item.id)
            state.sport_type.unshift(index)
        },
        restoreSportType(state, item) {
            let index = state.sport_type_with_trashed.findIndex(p => p.id === item.id)
            state.sport_type_with_trashed.splice(index, 1);

            let index2 = state.sport_type.findIndex(p => p.id === item.id)
            state.sport_type.unshift(index2)
        },
        softDeleteSportType(state, item) {
            let index = state.sport_type.findIndex(p => p.id === item.id)
            state.sport_type.splice(index, 1);

            let index2 = state.sport_type_with_trashed.findIndex(p => p.id === item.id)
            state.sport_type_with_trashed[index2] = item
        }
    },
    state: {
        sport_type: [],
        sport_type_with_trashed: []
    },
    getters: {
        AllSportTypes(state) {
            return state.sport_type;
        },
        AllSportTypesWithTrashed(state) {
            return state.sport_type_with_trashed;
        }
    }
}
