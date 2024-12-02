import axios from "axios";

export default {
    actions: {
        async fetchObjectTypes({commit}) {
            let {data} = await axios.get('/api/object/object-types');
            commit('loadObjectTypes', data)
            return data;
        },
        async fetchObjectTypesWithTrashed({commit}) {
            axios.get('object_type/list_with_trashed').then(response => {
                commit('loadObjectTypesWithTrashed', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delSoftObjectType({commit}, item) {
            axios.delete('object_type/softDelete' + item.id).then((response) => {
                commit('softDeleteObjectType', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delForceObjectType({commit}, item) {
            axios.delete('object_type/delete' + item.id).then((response) => {
                commit('forceDeleteObjectTypes', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        restoreObjectType({commit}, item) {
            axios.post('object_type/restore' + item.id).then((response) => {
                commit('restoreObjectType', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
       /* setObjectType({commit}, item) {
            axios.put('object_type/update' + item.id, {
                'title': item.title,
                'objectType_id': item.objectType_id,
                'image': item.image,
                'description': item.description,
                'sportType_id': item.sportType_id,
                'accomodationConditionAndPricing_id': item.accomodationConditionAndPricing_id,
                'infrastructure_id': item.infrastructure_id,
                'city_id': item.city_id,
                'address': item.address,
                'postIndex': item.postIndex,
                'longtitude': item.longtitude,
                'latitude': item.latitude,
                'rating': item.rating,
                'feedback_id': item.feedback_id,
                'user_id': item.user_id,
                'hasPromotion': item.hasPromotion,
                'hasHighlightion': item.hasHighlightion,
                'hasVIP': item.hasVIP,
            }).then(response => {
                commit('updateObjectType', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeObjectType({commit}, item) {
            axios.post('object_type/create', {
                'title': item.title,
                'objectType_id': item.objectType_id,
                'image': item.image,
                'description': item.description,
                'sportType_id': item.sportType_id,
                'accomodationConditionAndPricing_id': item.accomodationConditionAndPricing_id,
                'infrastructure_id': item.infrastructure_id,
                'city_id': item.city_id,
                'address': item.address,
                'postIndex': item.postIndex,
                'longtitude': item.longtitude,
                'latitude': item.latitude,
                'rating': item.rating,
                'feedback_id': item.feedback_id,
                'user_id': item.user_id,
                'hasPromotion': item.hasPromotion,
                'hasHighlightion': item.hasHighlightion,
                'hasVIP': item.hasVIP,
            }).then(response => {
                commit('createObjectType', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },*/
    },
    mutations: {
        loadObjectTypes(state, item) {
            state.object_type = item;
        },
        loadObjectTypesWithTrashed(state, item) {
            state.object_type = item
        },
        forceDeleteObjectTypes(state, item) {
            let index = state.object_type_with_trashed.findIndex(p => p.id === item.id)
            state.object_type_with_trashed.splice(index, 1);
        },
        updateObjectType(state, item) {
            let index = state.object_type.findIndex(p => p.id === item.id)
            state.object_type[index] = item
        },
        createObjectType(state, item) {
            let index = state.object_type.findIndex(p => p.id === item.id)
            state.object_type.unshift(index)
        },
        restoreObjectType(state, item) {
            let index = state.object_type_with_trashed.findIndex(p => p.id === item.id)
            state.object_type_with_trashed.splice(index, 1);

            let index2 = state.object_type.findIndex(p => p.id === item.id)
            state.object_type.unshift(index2)
        },
        softDeleteObjectType(state, item) {
            let index = state.object_type.findIndex(p => p.id === item.id)
            state.object_type.splice(index, 1);

            let index2 = state.object_type_with_trashed.findIndex(p => p.id === item.id)
            state.object_type_with_trashed[index2] = item
        }
    },
    state: {
        object_type: [],
        object_type_with_trashed: []
    },
    getters: {
        AllObjectTypes: state => state.object_type,
        AllObjectTypesWithTrashed: state => state.object_type_with_trashed,
    }
}
