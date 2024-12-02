import axios from "axios";

export default {
    actions: {
        async fetchContacts({commit}) {
            await axios.get('/api/account/contacts').then(response => {
                commit('loadContactsChat', response.data.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async fetchMessagesChat({commit}, item) {
            await axios.get(`/api/account/messages/from/${item.id}`).then(response => {
                commit('loadMessagesChat', response.data.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        sendMessage({commit}, item) {
            return axios.post('/api/account/message/add', item);
        },

        async deleteMessagesInChat({commit}, payload) {
            return await axios.get('/api/account/messages/delete/' + payload.id).then((response) => {
            }).catch((error) => {
                console.log(error.response);
            });
        },

        async getStatisticMessages({commit}) {
            await axios.get(`/api/stats/messages/unread`)
                .then((response) => {
                    commit('setMessagesStatistic', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setMessagesStatistic', {data: []});
                })
        },
    },
    mutations: {
        loadContactsChat(state, item) {
            state.contactsChat = item;
        },
        loadMessagesChat(state, item) {
            state.messagesChat = item;
        },
        setMessagesStatistic(state, item) {
            state.statistic_messages = item;
        },
    },
    state: {
        contactsChat: [],
        messagesChat: [],
        statistic_messages: {
            'count_messages': 0
        },
    },
    getters: {
        AllContactsChat: state => state.contactsChat,
        AllMessagesChat: state => state.messagesChat,
        messages_unread: state => state.statistic_messages
    }
}
