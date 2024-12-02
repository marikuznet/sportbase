<template>
    <div class="main" v-if="infoModel">
        <div class="sb-settings-performers">
            <user-profile-buttons :items="usersButtons"/>
            <div class="p-0 position-relative settings-performers__content">
                <div id="aboutObject"
                     class="informationBlocks__content__block informationBlocks__content__block__aboutObject shadow bg-white">
                    <div class="borderBlockBottom py-4 aboutObject__about px-4">
                        <div class="d-flex justify-content-between">
                            <h4 class="title fw-bold pb-2 addInform">Профиль и настройки аккаунта пользователя</h4>
                            <div class="align-items-center checkUser d-flex">
                                <span style="color: red;" v-if="infoModel.active">Заблокированный</span>
                                <input type="checkbox" class="toggle mr-2 ml-2" v-model="!infoModel.active">
                                <span style="color: green" v-if="!infoModel.active">Активный</span>
                            </div>
                        </div>

                        <div class="container p-0">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="title fw-bold pb-2 addInform" style="color: green">
                                        Основная информация
                                    </h4>
                                    <div class="row">
                                        <div class="col-9">
                                            <table class="table table-bordered p-2">
                                                <tr>
                                                    <td width="50%" rowspan="5">
                                                        <img :src="infoModel.image" alt="no image" class="img-fluid">
                                                    </td>
                                                    <td>Тип аккаунта
                                                        ({{
                                                            infoModel.typePerson === 0 ? "Юридическое лицо" : "Физическое лицо"
                                                        }})
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-user"></i> {{ infoModel.name_user }}
                                                    </td>
                                                </tr>
                                                <tr v-if="infoModel.phonesCompany">
                                                    <td>
                                                        <i class="fa fa-phone"></i> {{ infoModel.phonesCompany }}
                                                    </td>
                                                </tr>
                                                <tr v-if="infoModel.emailCompany">
                                                    <td>
                                                        <i class="fa fa-envelope-square"></i> {{
                                                            infoModel.emailCompany
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr v-if="infoModel.site">
                                                    <td>
                                                        <i class="fa fa-internet-explorer"></i> {{ infoModel.site }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 block__about-company" v-if="infoModel.description">
                                            <h4 class="title fw-bold pb-2 addInform" style="color: green">
                                                Описание компании
                                            </h4>
                                            <p class="mainText__company">
                                                {{ infoModel.description_no_tags }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 block__address-company">
                                            <h4 class="fw-bold title__company" style="color: green">Адрес компании
                                                <span style="color:black;">(для отображения на сайте)</span>
                                            </h4>
                                            {{ infoModel.city }}
                                            <p v-if="infoModel.city && infoModel.address" class="subtitle">
                                                <i class="fa fa-map-marker"></i>
                                                {{ infoModel.city + ', ' + infoModel.address }}
                                            </p>
                                        </div>
                                        <div v-if="infoModel.city" class="col-lg-12 map mb-3">
                                            <img class="img-fluid" src="/images/objectCard/map.png" alt="">
                                        </div>

                                        <div class="col-lg-12 pt-5 block__social-company">
                                            <h4 class="fw-bold title__company" style="color: green">
                                                Социальные сети и мессенджеры</h4>
                                            <table class="table table-bordered p-2">
                                                <tr v-for="(value, key) in social" :key="key" v-if="value">
                                                    <td width="50%">{{ key }}</td>
                                                    <td>{{ value }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-lg-12 block__social-company">
                                            <h4 class="fw-bold title__company" style="color: green">Личные
                                                данные пользователя
                                            </h4>
                                            <table class="table table-bordered">
                                                <tr v-if="infoModel.personal_data">
                                                    <td width="50%">Данные</td>
                                                    <td>
                                                        <i class="fa fa-user"></i>
                                                        {{ infoModel.personal_data }}
                                                    </td>
                                                </tr>
                                                <tr v-if="infoModel.phone">
                                                    <td width="50%">Телефон</td>
                                                    <td>
                                                        <i class="fa fa-phone"></i>
                                                        {{ infoModel.phone }}
                                                    </td>
                                                </tr>
                                                <tr v-if="infoModel.email">
                                                    <td width="50%">E-mail</td>
                                                    <td>
                                                        <i class="fa fa-envelope-square"></i>
                                                        {{ infoModel.email }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row" v-if="infoPaymentModel">
                                        <div class="col-12">
                                            <h4 class="title fw-bold pb-2 addInform" style="color: green">Платежные
                                                реквизиты</h4>
                                            <table class="p-2 table table-bordered">
                                                <tr v-if="infoPaymentModel.title">
                                                    <td>Юридическое наименование</td>
                                                    <td>{{ infoPaymentModel.legal_name }} "{{infoPaymentModel.title }}"
                                                    </td>
                                                </tr>
                                                <tr v-for="(value, key) in infoPaymentModel" :key="key"
                                                    v-if="paymentFields.hasOwnProperty(key)">
                                                    <td width="30%"><b>{{ paymentFields[key] }}</b></td>
                                                    <td>{{ value }}</td>
                                                </tr>
                                                <tr v-if="infoModel.city">
                                                    <td><b>Адрес компании</b></td>
                                                    <td><i class="fa fa-map-marker"></i> {{ infoModel.city }},
                                                        {{ infoModel.address }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row" v-if="notifications.length > 0">
                                        <div class="col-12">
                                            <h4 class="title fw-bold pb-2" style="color: green">
                                                Уведомления
                                            </h4>
                                            <table class="table table-bordered">
                                                <tr class="pb-4">
                                                    <td width="30%"><b>E-mail адрес</b></td>
                                                    <td>{{ notifications[0].email }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>События</b></td>
                                                    <td v-if="notifications.length > 0">
                                                        <p v-for="check in notifications">
                                                            <i class="fa fa-check-circle"></i>
                                                            {{ check.event_title }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="title fw-bold pb-2" style="color: green">
                                                Безопасность
                                            </h4>
                                        </div>
                                        <div class="col-12">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td width="200"><b>Пароль доступа</b></td>
                                                    <td width="50%">
                                                        <span>********</span>
                                                        <i class="fa fa-eye"></i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div v-if="false" class="row">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-center">
                                                <button @click="nextStep" class="btn btn-primary">Редактировать</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import Breadcrumbs from "./elements/Breadcrumbs";
import UserProfileButtons from "./elements/UserProfileButtons";

export default {
    components: {UserProfileButtons, Breadcrumbs},
    props: {
        userData: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            infoModel: {
                active: false,
                image: '',
                social: {},
                payment_details: {},
                personal_data: '',
                phone: '',
                email: ''
            },
            infoPaymentModel: {},
            social: {},
            notifications: [],
            usersButtons: [
                {name: 'profile', title: 'Профиль и настройки', active: true, href: '#'},
                {name: 'applications', title: 'Заявки и отклики', href: '#'},
                {name: 'deals', title: 'Сделки', href: '#'},
                {name: 'price', title: 'Сметы и счета', href: '#'},
                {name: 'reviews', title: 'Отзывы', href: '#'},
                {name: 'chat', title: 'Переписка', href: '#'},
            ],
            paymentFields: {
                tin: "ИНН",
                numKpp: "КПП",
                bic: "БИК",
                requisites: "Банковские реквизиты",
                kc: "К/С",
                okpo: "ОКПО",
                okato: "ОКАТО",
                orgn: "ОГРН",
            }
        }
    },
    methods: {
        ...mapActions(["fetchNotifications"]),
        initializeInfoModel() {
            if (this.userData.info) {
                const info = this.userData.info;
                this.infoModel = {
                    ...info,
                    active: this.userData.block,
                    image: info.image ? `/storage/listings/logos/${this.userData.id}/${info.image}` : '',
                    role_id: this.userData.role
                };
                this.social = info.social || {};
                this.infoPaymentModel = info.payment_details || {};
                this.notifications = this.userData.notifications || [];
            }
        }
    },
    watch: {
        userData: {
            handler(newVal) {
                this.initializeInfoModel();
                console.log(this.infoModel.active)
            },
            immediate: true,
            deep: true
        }
    },
    mounted() {
        this.fetchNotifications();
    }
}
</script>

<style scoped>
input[type=checkbox] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-tap-highlight-color: transparent;
    cursor: pointer;
}

input[type=checkbox]:focus {
    outline: 0;
}

.toggle {
    height: 22px !important;
    width: 44px;
    border-radius: 16px;
    display: inline-block;
    position: relative;
    margin: 0;
    border: 2px solid red;
    transition: all 0.2s ease;
}

.toggle:after {
    content: "";
    position: absolute;
    top: 2px;
    left: 2px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: white;
    box-shadow: 0 1px 2px rgba(44, 44, 44, 0.2);
    transition: all 0.2s cubic-bezier(0.5, 0.1, 0.75, 1.35);
}

.toggle:checked {
    border-color: green;
    background-color: green;
}

.toggle:checked:after {
    transform: translatex(20px);
}
</style>
