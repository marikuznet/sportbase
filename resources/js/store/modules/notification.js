import axios from "axios";

export default {
    actions: {
        async fetchNotifications({commit}) {
            return await axios.get('/notifications/list').then(response => {
                commit('loadNotifications', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadNotifications(state, item) {
            state.notifications = item;
        },
    },
    state: {
        notifications: [],
    },
    getters: {
        AllNotifications(state) {
            return state.notifications;
        },
    }
}
