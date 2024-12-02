import axios from "axios";

export default {
    actions: {
        delSoftServiceAndObject({commit}, item) {
            axios.delete('service_and_object/softDelete' + item.id).then((response) => {
                commit('softDeleteServiceAndObject', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        delForceServiceAndObject({commit}, item) {
            axios.delete('service_and_object/delete' + item.id).then((response) => {
                commit('forceDeleteServiceAndObjects', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        restoreServiceAndObject({commit}, item) {
            axios.post('service_and_object/restore' + item.id).then((response) => {
                commit('restoreServiceAndObject', item)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        setServiceAndObject({commit}, item) {
            axios.put('service_and_object/update' + item.id, {
                'sportObject_id': item.sportObject_id,
                'service_id': item.service_id,
            }).then(response => {
                commit('updateServiceAndObject', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        storeServiceAndObject({commit}, item) {
            axios.post('service_and_object/create', {
                'sportObject_id': item.sportObject_id,
                'service_id': item.service_id,
            }).then(response => {
                commit('createServiceAndObject', product)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadServiceAndObjects(state, item) {
            state.service_and_object = item;
        },
        loadServiceAndObjectsWithTrashed(state, item) {
            state.service_and_object = item
        },
        forceDeleteServiceAndObjects(state, item) {
            let index = state.service_and_object_with_trashed.findIndex(p => p.id === item.id)
            state.service_and_object_with_trashed.splice(index, 1);
        },
        updateServiceAndObject(state, item) {
            let index = state.service_and_object.findIndex(p => p.id === item.id)
            state.service_and_object[index] = item
        },
        createServiceAndObject(state, item) {
            let index = state.service_and_object.findIndex(p => p.id === item.id)
            state.service_and_object.unshift(index)
        },
        restoreServiceAndObject(state, item) {
            let index = state.service_and_object_with_trashed.findIndex(p => p.id === item.id)
            state.service_and_object_with_trashed.splice(index, 1);

            let index2 = state.service_and_object.findIndex(p => p.id === item.id)
            state.service_and_object.unshift(index2)
        },
        softDeleteServiceAndObject(state, item) {
            let index = state.service_and_object.findIndex(p => p.id === item.id)
            state.service_and_object.splice(index, 1);

            let index2 = state.service_and_object_with_trashed.findIndex(p => p.id === item.id)
            state.service_and_object_with_trashed[index2] = item
        }
    },
    state: {
        service_and_object: [],
        service_and_object_with_trashed: []
    },
    getters: {
        AllServiceAndObjects(state) {
            return state.service_and_object;
        },
        ServiceAndObjects: (state) => (id) => {
            return state.service_and_object.filter(p => p.obj.sportObject_id == id);
        },
        AllServiceAndObjectsWithTrashed(state) {
            return state.service_and_object_with_trashed;
        }
    }
}
