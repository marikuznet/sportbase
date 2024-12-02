import axios from "axios";

export default {
    actions:{
        async fetchInfrastructures({ commit }) {
            axios.get('/infrastructure/list').then(response => {
                commit('loadInfrastructures', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        async getInfrastructuresInObjects({ commit }) {
            axios.get('/api/filter/sport-object/infrastructures/list').then(response => {
                commit('loadInfrastructures', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        async fetchInfrastructuresWithTrashed({ commit }) {
            axios.get('infrastructure/list_with_trashed').then(response => {
                commit('loadInfrastructuresWithTrashed', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        delSoftInfrastructure({ commit }, item){
            axios.delete('infrastructure/softDelete'+item.id).then((response)=>{
                commit('softDeleteInfrastructure', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        delForceInfrastructure({ commit }, item){
            axios.delete('infrastructure/delete'+item.id).then((response)=>{
                commit('forceDeleteInfrastructures', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        restoreInfrastructure({ commit }, item){
            axios.post('infrastructure/restore'+item.id).then((response)=>{
                commit('restoreInfrastructure', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setInfrastructure({ commit }, item){
            axios.put('infrastructure/update'+item.id,{
                'title':item.title,
                'image':item.image,
                'option_id':item.option_id,
            }).then(response => {
                commit('updateInfrastructure', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        storeInfrastructure({ commit }, item){
            axios.post('infrastructure/create',{
                'title':item.title,
                'image':item.image,
                'option_id':item.option_id,
            }).then(response => {
                commit('createInfrastructure', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
    },
    mutations:{
        loadInfrastructures(state, item) {
            state.infrastructure = item;
        },
        loadInfrastructuresWithTrashed(state, item){
            state.infrastructure = item
        },
        forceDeleteInfrastructures(state, item){
            let index = state.infrastructure_with_trashed.findIndex(p => p.id === item.id)
            state.infrastructure_with_trashed.splice(index, 1);
        },
        updateInfrastructure(state, item){
            let index = state.infrastructure.findIndex(p=> p.id === item.id)
            state.infrastructure[index] = item
        },
        createInfrastructure(state, item){
            let index = state.infrastructure.findIndex(p => p.id === item.id)
            state.infrastructure.unshift(index)
        },
        restoreInfrastructure(state, item){
            let index = state.infrastructure_with_trashed.findIndex(p => p.id === item.id)
            state.infrastructure_with_trashed.splice(index, 1);

            let index2 = state.infrastructure.findIndex(p => p.id === item.id)
            state.infrastructure.unshift(index2)
        },
        softDeleteInfrastructure(state, item){
            let index = state.infrastructure.findIndex(p => p.id === item.id)
            state.infrastructure.splice(index, 1);

            let index2 = state.infrastructure_with_trashed.findIndex(p=> p.id === item.id)
            state.infrastructure_with_trashed[index2] = item
        }
    },
    state:{
        infrastructure:[],
        infrastructure_with_trashed:[]
    },
    getters:{
        AllInfrastructures(state){
            return state.infrastructure;
        },
        AllInfrastructuresWithTrashed(state){
            return state.infrastructure_with_trashed;
        }
    }
}
