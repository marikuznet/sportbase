import axios from "axios";

export default {
    actions: {
        async fetchEventNotifications({commit}) {
            return await axios.get('/event-notifications/list').then(response => {
                commit('loadEventNotifications', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
    },
    mutations: {
        loadEventNotifications(state, item) {
            state.event_notifications = item;
        },
    },
    state: {
        event_notifications: [],
    },
    getters: {
        AllEventNotifications(state) {
            return state.event_notifications;
        },
    }
}
