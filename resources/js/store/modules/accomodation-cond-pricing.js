import axios from "axios";

export default {
    actions:{
        async fetchAccomodationCondPrices({ commit }) {
            axios.get('/accomodation_cond_pricing/list').then(response => {
                commit('loadAccomodationCondPrices', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        async fetchAccomodationCondPricesWithTrashed({ commit }) {
            axios.get('accomodation_cond_pricing/list_with_trashed').then(response => {
                commit('loadAccomodationCondPricesWithTrashed', response.data)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        delSoftAccomodationCondPrice({ commit }, item){
            axios.delete('accomodation_cond_pricing/softDelete'+item.id).then((response)=>{
                commit('softDeleteAccomodationCondPrice', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        delForceAccomodationCondPrice({ commit }, item){
            axios.delete('accomodation_cond_pricing/delete'+item.id).then((response)=>{
                commit('forceDeleteAccomodationCondPrices', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        restoreAccomodationCondPrice({ commit }, item){
            axios.post('accomodation_cond_pricing/restore'+item.id).then((response)=>{
                commit('restoreAccomodationCondPrice', item)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setAccomodationCondPrice({ commit }, item){
            axios.put('accomodation_cond_pricing/update'+item.id,{
                'description':item.description,
                'includedInAccomodationPricing_id':item.includedInAccomodationPricing_id,
                'image':item.image,
                'accomodationTypeAndPricing_id':item.accomodationTypeAndPricing_id,
            }).then(response => {
                commit('updateAccomodationCondPrice', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        async storeAccomodationCondPrice({ commit }, item){
            return await new Promise((resolve, reject) => {
                axios.put('/accommodations/condition-pricing', {
                    'description':item.description,
                    'image':item.image,
                    'included_in_accomodation_pricing': item.included_in_accomodation_pricing
                }).then(response => {
                    resolve(response);
                }, error => {
                    reject(error);
                })
            })
        },
    },
    mutations:{
        loadAccomodationCondPrices(state, item) {
            state.accomodation_cond_pricing = item;
        },
        loadAccomodationCondPricesWithTrashed(state, item){
            state.accomodation_cond_pricing = item
        },
        forceDeleteAccomodationCondPrices(state, item){
            let index = state.accomodation_cond_pricing_with_trashed.findIndex(p => p.id === item.id)
            state.accomodation_cond_pricing_with_trashed.splice(index, 1);
        },
        updateAccomodationCondPrice(state, item){
            let index = state.accomodation_cond_pricing.findIndex(p=> p.id === item.id)
            state.accomodation_cond_pricing[index] = item
        },
        createAccomodationCondPrice(state, item){
            let index = state.accomodation_cond_pricing.findIndex(p => p.id === item.id)
            state.accomodation_cond_pricing.unshift(index)
        },
        restoreAccomodationCondPrice(state, item){
            let index = state.accomodation_cond_pricing_with_trashed.findIndex(p => p.id === item.id)
            state.accomodation_cond_pricing_with_trashed.splice(index, 1);

            let index2 = state.accomodation_cond_pricing.findIndex(p => p.id === item.id)
            state.accomodation_cond_pricing.unshift(index2)
        },
        softDeleteAccomodationCondPrice(state, item){
            let index = state.accomodation_cond_pricing.findIndex(p => p.id === item.id)
            state.accomodation_cond_pricing.splice(index, 1);

            let index2 = state.accomodation_cond_pricing_with_trashed.findIndex(p=> p.id === item.id)
            state.accomodation_cond_pricing_with_trashed[index2] = item
        }
    },
    state:{
        accomodation_cond_pricing:[],
        accomodation_cond_pricing_with_trashed:[]
    },
    getters:{
        AllAccomodationCondPrices(state){
            return state.accomodation_cond_pricing;
        },
        AllAccomodationCondPricesWithTrashed(state){
            return state.accomodation_cond_pricing_with_trashed;
        }
    }
}
