import axios from "axios";

export default {
    actions: {
        async fetchRequirementInfrastructures({commit}) {
            await axios.get('/api/filter/requirement-infrastructures/list')
                .then(result => {
                    commit('loadRequirementInfrastructures', result.data.data)
                }).catch(e => {
                    console.log(e);
                })
        },
    },
    mutations: {
        loadRequirementInfrastructures(state, item) {
            state.requirement_infrastructures = item;
        },
    },
    state: {
        requirement_infrastructures: [],
    },
    getters: {
        AllRequirementInfrastructures: state => state.requirement_infrastructures,
    }
}
