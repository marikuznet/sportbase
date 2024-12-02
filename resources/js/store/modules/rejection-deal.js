import axios from "axios";

export default {
    actions: {
        async fetchRejectionDeals({ commit }) {
            axios.get('/deal/rejection_deals/list').then(response => {
                commit('loadRejectionDeals', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
    },
    mutations:{
        loadRejectionDeals(state, item) {
            state.rejection_deals = item;
        },
    },
    state:{
        rejection_deals:[],
    },
    getters:{
        AllRejectionsDeal(state){
            return state.rejection_deals;
        },
    }
}
