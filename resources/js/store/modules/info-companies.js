import axios from "axios";

export default {
    actions: {
        async fetchInfoCompanies({commit}) {
            return await axios.get('/api/info-company').then(response => {
                if (response.data.data != undefined) {
                    commit('loadInfoCompanies', response.data.data)
                    return response.data.data;
                } else {
                    return false;
                }
            }).catch((error) => {
                console.log(error.response);
            });
        },
        async setInfoCompanies({commit}, item) {
            await axios.put('/info-company/update', {
                //'id': item.id,
                'user_id': user.id,
                'typePerson': item.typePerson,
                'title': item.title,
                'image': item.imageUpload,
                'phoneCompany': item.phones,
                'quantityEmployees': item.quantityEmployees,
                'emailCompany': item.emailCompany,
                'site': item.site,
                'description': item.descriptionCompany,

                'address_id': item.address_id,
                'city_id': item.city_id,
                'postIndex': item.postIndex,
                'address': item.address,
                'longtitude': item.longtitude,
                'latitude': item.latitude,

                'facebook': item.facebook,
                'twitter': item.twitter,
                'linkedIn': item.linkedIn,
                'telegram': item.telegram,
                'slack': item.slack,
                'instagram': item.instagram,

                'surname': item.surname,
                'name': item.name,
                'patronymic': item.patronymic,
                'position_id': item.position_id,
                'email': item.email,
                'phone': item.phone,

            }).then(response => {
                commit('updateInfoCompanies', response.data)
            }).catch((error) => {
                console.log(error.response);
            });
        },
        update({commit}, item) {
            return commit('Update', item)
        }
    },
    mutations: {
        loadInfoCompanies(state, item) {
            state.info_companies = item;
        },
        Update(state, item) {
            state.info_companies.title = item.title;
            state.info_companies.emailCompany = item.emailCompany;
        },
        updateInfoCompanies(state, item) {
            let index = state.info_companies.findIndex(p => p.id === item.id)
            //state.info_companies.unshift(item);
            state.info_companies[index] = item
        },
    },
    state: {
        info_companies: {},
    },
    getters: {
        AllInfoCompanies(state) {
            return state.info_companies;
        },
        InfoCompany: (state) => (user_id) => {
            return state.info_companies.filter(p => p.user_id == user_id)[0];
        },
        TitleCompany(state) {
            if (state.info_companies != undefined) {
                if (user.role == 3) return state.info_companies.title;
                else if (user.role == 2) {
                    if (state.info_companies.typePerson === 0) return state.info_companies.title;
                    else if (state.info_companies.typePerson === 1) return state.info_companies.surname + ' ' + state.info_companies.name;
                }
            } else return "";
        },
        LogoCompany(state) {
            if (state.info_companies != undefined)
                return state.info_companies.image;
            else return "";

        }
    }
}
