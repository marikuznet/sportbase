import axios from "axios";

export default {
    actions:{
        async fetchFeedbacks({ commit }) {
            axios.get('feedback/list').then(response => {
                commit('loadFeedbacks', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        async fetchFeedbacksWithTrashed({ commit }) {
            axios.get('feedback/list_with_trashed').then(response => {
                commit('loadFeedbacksWithTrashed', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        delSoftFeedback({ commit }, item){
            axios.delete('feedback/softDelete'+item.id).then((response)=>{
                commit('softDeleteFeedback', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        delForceFeedback({ commit }, item){
            axios.delete('feedback/delete'+item.id).then((response)=>{
                commit('forceDeleteFeedbacks', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        restoreFeedback({ commit }, item){
            axios.post('feedback/restore'+item.id).then((response)=>{
                commit('restoreFeedback', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setFeedback({ commit }, item){
            axios.put('feedback/update'+item.id,{
                'date':item.date,
                'content':item.content,
                'rating':item.rating,
            }).then(response => {
                commit('updateFeedback', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        storeFeedback({ commit }, item){
            axios.post('feedback/create',{
                'date':item.date,
                'content':item.content,
                'rating':item.rating,
            }).then(response => {
                commit('createFeedback', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
    },
    mutations:{
        loadFeedbacks(state, item) {
            state.feedback = item;
        },
        loadFeedbacksWithTrashed(state, item){
            state.feedback = item
        },
        forceDeleteFeedbacks(state, item){
            let index = state.feedback_with_trashed.findIndex(p => p.id === item.id)
            state.feedback_with_trashed.splice(index, 1);
        },
        updateFeedback(state, item){
            let index = state.feedback.findIndex(p=> p.id === item.id)
            state.feedback[index] = item
        },
        createFeedback(state, item){
            let index = state.feedback.findIndex(p => p.id === item.id)
            state.feedback.unshift(index)
        },
        restoreFeedback(state, item){
            let index = state.feedback_with_trashed.findIndex(p => p.id === item.id)
            state.feedback_with_trashed.splice(index, 1);

            let index2 = state.feedback.findIndex(p => p.id === item.id)
            state.feedback.unshift(index2)
        },
        softDeleteFeedback(state, item){
            let index = state.feedback.findIndex(p => p.id === item.id)
            state.feedback.splice(index, 1);

            let index2 = state.feedback_with_trashed.findIndex(p=> p.id === item.id)
            state.feedback_with_trashed[index2] = item
        }
    },
    state:{
        feedback:[],
        feedback_with_trashed:[]
    },
    getters:{
        AllFeedbacks(state){
            return state.feedback;
        },
        AllFeedbacksWithTrashed(state){
            return state.feedback_with_trashed;
        }
    }
}
