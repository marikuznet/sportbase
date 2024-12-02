import axios from "axios";

export default {
    actions:{
        delSoftSportTypeObject({ commit }, item){
            axios.delete('sport_type_object/softDelete'+item.id).then((response)=>{
                commit('softDeleteSportTypeObject', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        delForceSportTypeObject({ commit }, item){
            axios.delete('sport_type_object/delete'+item.id).then((response)=>{
                commit('forceDeleteSportTypeObjects', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        restoreSportTypeObject({ commit }, item){
            axios.post('sport_type_object/restore'+item.id).then((response)=>{
                commit('restoreSportTypeObject', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setSportTypeObject({ commit }, item){
            axios.put('sport_type_object/update'+item.id,{
                'sportObject_id':item.sportObject_id,
                'sportType_id':item.sportType_id,
            }).then(response => {
                commit('updateSportTypeObject', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        storeSportTypeObject({ commit }, item){
            axios.post('sport_type_object/create',{
                'sportObject_id':item.sportObject_id,
                'sportType_id':item.sportType_id,
            }).then(response => {
                commit('createSportTypeObject', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
    },
    mutations:{
        loadSportTypeObjects(state, item) {
            state.sport_type_object = item;
        },
        loadSportTypeObjectsWithTrashed(state, item){
            state.sport_type_object = item
        },
        forceDeleteSportTypeObjects(state, item){
            let index = state.sport_type_object_with_trashed.findIndex(p => p.id === item.id)
            state.sport_type_object_with_trashed.splice(index, 1);
        },
        updateSportTypeObject(state, item){
            let index = state.sport_type_object.findIndex(p=> p.id === item.id)
            state.sport_type_object[index] = item
        },
        createSportTypeObject(state, item){
            let index = state.sport_type_object.findIndex(p => p.id === item.id)
            state.sport_type_object.unshift(index)
        },
        restoreSportTypeObject(state, item){
            let index = state.sport_type_object_with_trashed.findIndex(p => p.id === item.id)
            state.sport_type_object_with_trashed.splice(index, 1);

            let index2 = state.sport_type_object.findIndex(p => p.id === item.id)
            state.sport_type_object.unshift(index2)
        },
        softDeleteSportTypeObject(state, item){
            let index = state.sport_type_object.findIndex(p => p.id === item.id)
            state.sport_type_object.splice(index, 1);

            let index2 = state.sport_type_object_with_trashed.findIndex(p=> p.id === item.id)
            state.sport_type_object_with_trashed[index2] = item
        }
    },
    state:{
        sport_type_object:[],
        sport_type_object_with_trashed:[]
    },
    getters:{
        AllSportTypeObjects(state){
            return state.sport_type_object;
        },
        SportTypesAndObjects: (state) => (id) => {
            return state.sport_type_object.filter(p => p.sportObject_id == id);
        },
        AllSportTypeObjectsWithTrashed(state){
            return state.sport_type_object_with_trashed;
        }
    }
}
