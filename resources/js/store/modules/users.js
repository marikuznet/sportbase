import axios from "axios";

export default {
    actions: {
        fetchUsers({commit}) {
            commit("setUsersLoading", true);
            return axios.get('/admin/api/users/list').then(response => {
                commit('loadUsers', response.data.data)
            }).catch((error) => {
                console.log(error.response);
            }).finally(() => {
                commit("setUsersLoading", false)
            });
        },

        async getCurrentUser() {
            return await new Promise((resolve, reject) => {
                axios.get('/auth/current-user').then(
                    result => {
                        resolve(result.data);
                    }).catch(err => {
                    reject(err);
                    console.log("error in store");
                });
            });
        },
        async delUser({commit}, item) {
            commit("setUsersLoading", true);
            return await axios.delete(`/user/${item.id}/delete`).then((response) => {
                commit('deleteUser', item)
            }).catch((error) => {
                console.log(error.response);
            }).finally(() => {
                commit("setUsersLoading", false);
            });
        },
       async setStatusUser({commit}, item) {
            commit("setUsersLoading", true);
            return await axios.put(`/user/update`, {
                'id': item.id,
                'status': item.status,
            }).then(response => {
                commit('updateStatusUser', item)
            }).catch((error) => {
                console.log(error.response);
            }).finally(() => {
                commit("setUsersLoading", false);
            });
        },
        async setActiveUser({commit}, item) {
            commit("setUsersLoading", true);
            return await axios.put(`/user/update`, {
                'id': item.id,
                'status': 11,
            }).then(response => {
                commit('updateStatusUser', item)
            }).catch((error) => {
                console.log(error.response);
            }).finally(() => {
                commit("setUsersLoading", false);
            });
        },
        async setNonVerifyUser({commit}, item) {
            commit("setUsersLoading", true);
            return await axios.put(`/user/update/`, {
                'id': item.id,
                'status': 13,
            }).then(response => {
                commit('updateStatusBlock', item)
            }).catch((error) => {
                console.log(error.response);
            }).finally(() => {
                commit("setUsersLoading", false);
            });
        },
        async setBlockUser({commit}, item) {
            commit("setUsersLoading", true);
            return await axios.put(`/user/block/`, {
                'id': item.id,
                'block': item.block,
            }).then(response => {
                commit('updateStatusBlock', item)
            }).catch((error) => {
                console.log(error.response);
            }).finally(() => {
                commit("setUsersLoading", false);
            });
        },
    },
    mutations: {
        loadUsers(state, item) {
            state.users = item;
        },

        deleteUser(state, item) {
            let index = state.users.findIndex(p => p.id === item.id)
            state.users.splice(index, 1);
        },
        updateStatusUser(state, item) {
            state.users.forEach(p => {
                if (p.id === item.id) p.status = item.status;
            });
        },
        updateStatusBlock(state, item) {
            state.users.forEach(p => {
                if (p.id === item.id) p.block = item.block;
            });
        },
        setUsersLoading(state, payload) {
            return (state.users_loading = payload);
        },
    },
    state: {
        users: [],
        users_loading: false,
    },
    getters: {
        AllUsers: state => state.users,
        users_loading: state => state.users_loading,
        InfoUser: (state) => (user_id) => {
            return state.users.filter(p => p.id == user_id)[0];
        },
        UsersCustomer: state => state.users.filter(p => p.role === 2),
        UsersExecutor: state => state.users.filter(p => p.role === 3),
    }
}
