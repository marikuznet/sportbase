import Vue from 'vue'
import Vuex from 'vuex'
import axios from "axios";

//#region modules import
import sport_object from './modules/sport-objects'
import accomodation_cond_pricing from './modules/accomodation-cond-pricing'
import accomodation_type_pricing from './modules/accomodation-type-pricing'
import accomodation_type from './modules/accomodation-type'
import city from './modules/city'
import country from './modules/country'
import feedback from './modules/feedback'
import in_accomodation_pricing from './modules/in-accomodation-pricing'
import infrastructure from './modules/infrastructure'
import object_type from './modules/object-type'
import option from './modules/option'
import region from './modules/region'
import service_and_object from './modules/service-and-object'
import service from './modules/service'
import sport_type_object from './modules/sport-type-object'
import sport_type from './modules/sport-type'
import position from './modules/position'
import payment_details from './modules/payment-details'
import type_food from './modules/type-food'
import addition_tender from './modules/addition-tender'
import tenders from './modules/tenders'
import info_companies from './modules/info-companies'
import requirement_infrastructures from './modules/requirement-infrastructures'
import responses_tender from './modules/responses-tender'
import responses_and_tenders from './modules/responses-and-tenders'
import direct_applications from './modules/direct-applications'
import users from './modules/users'
import notifications from './modules/notification'
import event_notifications from './modules/event-notifications'
import rate_advertisments from './modules/rate-advertisments'
import deals from './modules/deals'
import acc_pricing_and_object from './modules/accomodation-cond-pricing-object'
import rejection_deals from './modules/rejection-deal'
import estimate from './modules/estimate'
import estimates from "./modules/estimates";
import review_deal from "./modules/reviews-deals";
import messages_arbitr from "./modules/messages-arbitr";
import statistic_admin from "./modules/statistic-admin";
import news from "./modules/news";
import messages from "./modules/messages";
import orders from "./modules/orders";
import filters from "./modules/filters";
import statistic from "./modules/statistic";
//#endregion

//#region modules admin import
import admin_direct_applications from './modules/admin/admin-direct-applications'
import admin_tender_applications from './modules/admin/admin-tender-applications'
import admin_sport_objects from './modules/admin/admin-sport-objects'
//#endregion
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        sport_object, accomodation_cond_pricing, accomodation_type_pricing, accomodation_type,
        city, country, region, feedback, in_accomodation_pricing, infrastructure, object_type, option,
        service_and_object, service, sport_type_object, sport_type,
        position, payment_details, info_companies, type_food, addition_tender, tenders,
        requirement_infrastructures, responses_tender, responses_and_tenders, direct_applications,
        users, notifications, event_notifications, rate_advertisments,
        deals, acc_pricing_and_object, rejection_deals, estimate, estimates, review_deal, messages_arbitr, news,
        messages, orders, filters,
        statistic_admin, statistic,

        admin_direct_applications, admin_tender_applications, admin_sport_objects
    }
})
