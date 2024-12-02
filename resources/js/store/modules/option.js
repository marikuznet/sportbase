import axios from "axios";

export default {
    actions:{
        async fetchOptions({ commit }) {
            axios.get('/options/list').then(response => {
                commit('loadOptions', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        async fetchOptionsWithTrashed({ commit }) {
            axios.get('option/list_with_trashed').then(response => {
                commit('loadOptionsWithTrashed', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        delSoftOption({ commit }, item){
            axios.delete('option/softDelete'+item.id).then((response)=>{
                commit('softDeleteOption', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        delForceOption({ commit }, item){
            axios.delete('option/delete'+item.id).then((response)=>{
                commit('forceDeleteOptions', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        restoreOption({ commit }, item){
            axios.post('option/restore'+item.id).then((response)=>{
                commit('restoreOption', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setOption({ commit }, item){
            axios.put('option/update'+item.id,{
                'title':item.title,
            }).then(response => {
                commit('updateOption', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        storeOption({ commit }, item){
            axios.post('option/create',{
                'title':item.title,
            }).then(response => {
                commit('createOption', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
    },
    mutations:{
        loadOptions(state, item) {
            state.option = item;
        },
        loadOptionsWithTrashed(state, item){
            state.option = item
        },
        forceDeleteOptions(state, item){
            let index = state.option_with_trashed.findIndex(p => p.id === item.id)
            state.option_with_trashed.splice(index, 1);
        },
        updateOption(state, item){
            let index = state.option.findIndex(p=> p.id === item.id)
            state.option[index] = item
        },
        createOption(state, item){
            let index = state.option.findIndex(p => p.id === item.id)
            state.option.unshift(index)
        },
        restoreOption(state, item){
            let index = state.option_with_trashed.findIndex(p => p.id === item.id)
            state.option_with_trashed.splice(index, 1);

            let index2 = state.option.findIndex(p => p.id === item.id)
            state.option.unshift(index2)
        },
        softDeleteOption(state, item){
            let index = state.option.findIndex(p => p.id === item.id)
            state.option.splice(index, 1);

            let index2 = state.option_with_trashed.findIndex(p=> p.id === item.id)
            state.option_with_trashed[index2] = item
        }
    },
    state:{
        option:[],
        option_with_trashed:[]
    },
    getters:{
        AllOptions(state){
            return state.option;
        },
        Options: (state) => (infrastructure_id) => {
            return state.option.filter(p => p.infrastructure_id == infrastructure_id);
        },

        AllOptionsWithTrashed(state){
            return state.option_with_trashed;
        }
    }
}
