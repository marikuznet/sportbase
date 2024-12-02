import axios from "axios";

export default {
    actions:{
        fetchMessagesArbitr({ commit }) {
            return axios.get('/messages_arbitr/list').then(response => {
                commit('loadMessagesArbitr', response.data.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        storeMessagesArbitr({ commit }, item){
            return axios.put('/messages_arbitr/create',{
                'deal_id':item.deal_id,
                'user_id':item.user_id,
                'message':item.message,
            }).then(response => {
                //commit('createInfrastructure', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
    },
    mutations:{
        loadMessagesArbitr(state, item) {
            state.messages_arbitr = item;
        },
        updateInfrastructure(state, item){
            let index = state.messages_arbitr.findIndex(p=> p.id === item.id)
            state.messages_arbitr[index] = item
        },
    },
    state:{
        messages_arbitr:[],
    },
    getters:{
        AllMessagesArbitr(state){
            return state.messages_arbitr;
        },
        AllMessagesArbitrUser: (state) => (deal_id) => {
            return state.messages_arbitr.filter(f => f.deal_id == deal_id);
        },
    }
}
