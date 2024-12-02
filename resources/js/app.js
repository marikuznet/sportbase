/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import AdminStepperProfile from "./adminPanel/profile/AdminStepperProfile";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename"
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
require('./bootstrap');
require("./main.js");
window.Vue = require("vue").default;

import Vue from 'vue';
import store from './store';
import VueApexCharts from 'vue-apexcharts'

import VSelect from "@alfsnd/vue-bootstrap-select";
import moment from "moment";

Vue.use(moment);
Vue.component('v-select', VSelect);
import 'moment/locale/ru'

moment.locale('ru');
//moment.suppressDeprecationWarnings = true;

Vue.use(VueApexCharts);

Vue.directive('lazy', {
    inserted: function (el, binding) {
        const lazyImage = new Image();
        lazyImage.src = binding.value;
        lazyImage.onload = function () {
            el.style.backgroundImage = `url(${binding.value})`;
        }
    }
});

Vue.filter('formatRating', function(value) {
    if (Number.isInteger(value)) {
        return value.toFixed(0);
    } else {
        return value.toFixed(2);
    }
});


import {ValidationObserver, ValidationProvider, extend, localize} from 'vee-validate';
//import { required } from "vee-validate/dist/rules";
//extend("required", required);

extend('editorLength', {
    validate: value => {
        return value ? value.replace(/<\/?[^>]+(>|$)/g, "").length >= 5 : false;
    },
    message: 'Поле должно содержать более 5 символов'
});
extend('editorMaxLength', {
    params: ['maxLength'],
    validate(value, {maxLength}) {
        return value ? value.replace(/<\/?[^>]+(>|$)/g, "").length <= maxLength : false
    },
    message: 'слишком много символов'
});
extend('positive', {
    message: 'значение должно быть больше нуля',
    validate(value) {
        return value > 0;
    }
});
extend('minPrice', {
    params: ['maxPrice'],
    validate(value, {maxPrice}) {
        const tempPrice = maxPrice === '' ? 0 : maxPrice;
        if (tempPrice === 0) return true;
        return Number(tempPrice) > Number(value);
    },
    message: 'неккоректное значение'
});
extend('maxPrice', {
    params: ['minPrice'],
    validate(value, {minPrice}) {
        const tempPrice = minPrice === '' ? 0 : minPrice;
        if (tempPrice === 0) return true;
        return Number(value) > Number(tempPrice);
    },
    message: 'неккоректное значение'
});
extend('greaterThanStart', {
    params: ['start_1_at'],
    validate(value, {start_1_at}) {
        const end_1_at = moment(value, "HH:mm");
        const start_1_at_moment = moment(start_1_at, "HH:mm");
        if (!end_1_at.isValid() || !start_1_at_moment.isValid()) {
            return false;
        }
        return end_1_at.isAfter(start_1_at_moment);
    },
    message: 'неккоректное значение'
});
extend('vSelectLength', {
    validate: value => {
       return value > 0;
    },
    message: 'выберите несколько вариантов'
});

import ru from 'vee-validate/dist/locale/ru.json';
import * as rules from 'vee-validate/dist/rules';

localize('ru', ru)
localize('ru', {
    messages: {
        required: 'поле обязательно к заполнению',
        numeric: 'поле должно быть числовым',
        alpha: 'неккоректное значение',
        min: 'слишком мало символов',
        max: 'слишком много символов',
        regex: 'неккоректное значение'
    }
});

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

window.axios = require('axios');
Vue.prototype.$http = window.axios

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    //  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

Vue.filter('stripHTMLTags', function (value) {
    return value.replace(/<\/?[^>]+(>|$)/g, '');
});

Vue.filter('stringLength', function (value) {
    return value.length;
});

const apiSettings = Vue.observable({
    yandexMap: {
        apiKey: 'ff8bedd5-02de-4958-bdf3-89d64d967c39',
        lang: 'ru_RU',
        coordorder: 'latlong',
        version: '2.1.79',
    },
});

Vue.prototype.$apiSettings = apiSettings;


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);

Vue.component("v-header", require("./adminPanel/Header.vue").default);

Vue.component("log-in", require("./components/Login.vue").default);
Vue.component("v-reg", require("./components/Register.vue").default);
Vue.component("v-main", require("./components/MainPage.vue").default);
Vue.component("v-objects-catalog", require("./components/ObjectsCatalog.vue").default);
Vue.component("v-object-catalog", require("./components/ViewObjectCatalog.vue").default);
Vue.component("v-tenders-catalog", require("./components/TenderPage").default);
Vue.component("v-favorites-objects", require("./components/FavoritesObjects").default);
Vue.component("v-compare-objects", require("./components/CompareObjects").default);
Vue.component("v-reset-password", require("./components/ResetPassword").default);

Vue.component("v-reset-input-password", require("./components/ResetInputPassword").default);

Vue.component("v-verify-email", require("./components/VerifyEmail").default);

Vue.component("v-messages", require("./components/profile/Messages").default);
Vue.component("v-profile-settings", require("./components/profile/profileExecutor/ProfileAndSettings").default);
Vue.component("v-profile-notification", require("./components/profile/Notification").default);
Vue.component("v-profile-security", require("./components/profile/Security").default);
Vue.component("v-profile-payment", require("./components/profile/PaymentDetails").default);
Vue.component("v-sport-objects", require("./components/profile/profileExecutor/SportObjects").default);

Vue.component("v-create-object", require("./components/addObject/CreateObject").default);
Vue.component("v-create-object-first", require("./components/addObject/FirstStage").default);
Vue.component("v-create-object-second", require("./components/addObject/SecondStage").default);
Vue.component("v-create-object-third", require("./components/addObject/ThirdStage").default);

Vue.component("modal", require("./components/addObject/ModalLiving"));
Vue.component("modalInfrastructure", require("./components/addObject/ModalInfrastructure"));

Vue.component("v-tender-request", require("./components/requests/TenderRequest").default);
Vue.component("v-direct-request", require("./components/profile/profileCustomer/DirectRequest").default);
Vue.component("v-my-tenders", require("./components/profile/profileCustomer/MyTenders").default);
Vue.component("v-application-objects-executor", require("./components/profile/profileExecutor/ApplicationForObjects").default);
Vue.component("v-responses-tenders-executor", require("./components/profile/profileExecutor/ResponsesToTenders").default);
Vue.component("v-orders-payments", require("./components/profile/profileCustomer/OrdersAndPayments").default);
Vue.component("v-order-component", require("./components/ordersAndPayments/OrderComponent").default);
Vue.component("v-reviews-customer", require("./components/profile/profileCustomer/Reviews").default);
Vue.component("v-conclusion-transaction", require("./components/ConclusionOfTransactionTender").default);
Vue.component("v-conclusion-transaction-direct", require("./components/ConclusionOfTransactionDirect").default);

Vue.component("v-rules-politic", require("./components/RulesPolitic").default);
Vue.component("v-news", require("./components/News").default);
Vue.component("v-view-news", require("./components/ViewNews").default);
Vue.component("v-contacts", require("./components/Contacts").default);
Vue.component("v-error-not-found", require("./components/ErrorNotFound").default);


/*#region admin-panel*/
Vue.component("v-admin-profile", require("./adminPanel/Profile").default);
Vue.component("admin-stepper-profile", require("./adminPanel/profile/AdminStepperProfile").default);

Vue.component("admin-object-show", require("./adminPanel/ShowObject").default);
Vue.component("admin-object-edit", require("./adminPanel/EditObject").default);

Vue.component('admin-create-object', require("./adminPanel/addObject/EditObject").default);
Vue.component('admin-create-object-first', require("./adminPanel/addObject/AdminFirstStage").default);

Vue.component("show-tender", require("./adminPanel/applications/showTender").default);
Vue.component("show-direct", require("./adminPanel/applications/showDirect").default);
Vue.component("v-admin-show-deal", require("./adminPanel/ShowDeal").default);


Vue.component("users-component", require("./adminPanel/UsersComponent").default);

Vue.component("admin-sport-objects-component", require("./adminPanel/SportObjectsComponent").default);

Vue.component("finantial-operations-component", require("./adminPanel/FinantialOperationsComponent").default);
Vue.component("advertisment-seo-component", require("./adminPanel/AdvertismentAndSeoComponent").default);
Vue.component("direct-tender-component", require("./adminPanel/DirectAndTenderComponent").default);
Vue.component("deals-component", require("./adminPanel/DealsComponent").default);
Vue.component("cooperation-feedbacks-component", require('./adminPanel/CooperationFeedbacksComponent').default);
Vue.component("bills-component", require('./adminPanel/BillsComponent').default);
Vue.component("news-component", require('./adminPanel/NewsComponent').default);
Vue.component("add-news-component", require('./adminPanel/news/AddNews').default);
Vue.component("show-news-component", require('./adminPanel/news/ShowNews').default);
Vue.component("payment-details", require('./adminPanel/PaymentDetails').default);

Vue.component("table-component", require("./adminPanel/TableComponent").default);

Vue.component('apexchart', VueApexCharts)
Vue.component('modal-notification', require('./components/elements/Modal').default)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store,
    el: "#app",

});
