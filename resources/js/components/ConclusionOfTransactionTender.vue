<template>
    <div v-if="myDeal">
        <div class="align-items-center d-flex justify-content-center loading position-fixed" v-if="loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <div class="deal-caption d-flex align-items-center justify-content-center"
             style="height: 105px; background-color:#231F6D">
            <p class="text-uppercase"><b>заключение сделки №{{ myDeal.id }}</b></p>
        </div>
        <div v-if="myDeal" style="background-color: #F9F9F9; min-height: 100vh;">
            <main class="container p-0 notifications proposal-card">
                <nav class="" aria-label="breadcrumb ">
                    <ol class="breadcrumb px-4 px-lg-0 py-4 my-lg-2"
                        style="border-bottom: none; background-color: transparent">
                        <li class="breadcrumb-item fs-lg-5"><a href="/">Главная</a></li>
                        <li class="breadcrumb-item fs-lg-5"><a href="/orders-and-payments">Заказы и оплаты</a></li>
                        <li class="breadcrumb-item active fs-lg-5" aria-current="page">Заключение сделки №{{
                                myDeal.id
                            }}
                        </li>
                    </ol>
                </nav>

                <div class="deal-block mb-3">
                    <div v-if="myDeal.customer_info" class="title__deal-block d-flex align-items-center p-3">
                        <div class="align-items-center d-lg-flex d-none">
                            <img class="mr-4" src="/icons/stages/check-mark.svg" alt="">

                            <template v-if="user.role === 2">
                                <p class="caption mr-4">Поздравляем, Вы выбрали Исполнителя</p>
                                <div style="width: 40px; height: 40px" class="mr-4">
                                    <img class="mr-4 w-100 h-100" style="border-radius: 100%"
                                         :src="'/storage/listings/logos/'
                                         + myDeal.responsesTender.company_info.user_id + '/'
                                         + myDeal.responsesTender.company_info.image" alt="">
                                </div>
                                <p class="caption mr-4">
                                    {{
                                        myDeal.responsesTender.company_info.typePerson === 1 ?
                                            myDeal.responsesTender.company_info.surname + ' ' +
                                            myDeal.responsesTender.company_info.name : myDeal.responsesTender.company_info.title
                                    }}
                                </p>
                                <p class="caption normal">для тендера №{{ myDeal.tender.id }}</p>
                            </template>

                            <template v-else-if="user.role === 3">
                                <p class="caption mr-4">Поздравляем, Заказчик</p>
                                <div style="width: 40px; height: 40px" class="mr-4">
                                    <img class="mr-4 w-100 h-100" style="border-radius: 100%" alt=""
                                         :src="'/storage/listings/logos/'
                                         + myDeal.customer_info.user_id
                                         + '/' + myDeal.customer_info.logo">
                                </div>
                                <p class="caption mr-4">{{ myDeal.customer_info.title }}</p>
                                <p class="caption normal">выбрал вас победителем в тендере №{{ myDeal.tender.id }}</p>
                            </template>
                        </div>
                        <div class="d-flex d-lg-none">
                            <div class="flex-grow-0">
                                <img width="25px" class="mr-4" src="/icons/stages/check-mark.svg" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p class="caption mr-4">Поздравляем</p>
                                <div class="d-flex flex-wrap align-items-center mb-2">
                                    <template v-if="user.role === 3">
                                        <p class="caption mr-4">Заказчик</p>
                                        <img width="30px" class="mr-4" alt=""
                                             :src="'/storage/listings/logos/'
                                             + myDeal.responsesTender.company_info.user_id
                                              + '/' + myDeal.responsesTender.company_info.image">
                                        <p class="caption mr-4">{{ myDeal.customer_info.title }}</p>
                                    </template>
                                    <template v-else-if="user.role === 2">
                                        <p class="caption mr-4">Вы выбрали Исполнителя</p>
                                        <img width="30px" class="mr-4" alt=""
                                             :src="'/storage/listings/logos/'
                                             + myDeal.customer_info.user_id + '/'
                                             + myDeal.customer_info.logo">
                                        <p class="caption mr-4"> {{
                                                myDeal.responsesTender.company_info.typePerson === 1 ?
                                                    myDeal.responsesTender.company_info.surname + ' ' +
                                                    myDeal.responsesTender.company_info.name :
                                                    myDeal.responsesTender.company_info.title
                                            }}
                                        </p>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="request-customer">
                        <div class="info-full-request-object" style="border: none">
                            <div class="response">
                                <div class="container pb-2">
                                    <div v-if="myDeal.tender"
                                         class="title-request overflow-auto shadow modal-info-object-request tender mb-3">
                                        <div class="title-request__item d-flex flex-wrap pt-3 pb-3 pl-4 pr-4
                                            justify-content-between">
                                            <div class="logo d-flex align-items-center">
                                                <p class="ispr">Заявка от заказчика</p>
                                            </div>
                                            <div class="d-flex">
                                                <div data-toggle="collapse" data-target="#tender"
                                                     class="arrow-button d-none d-lg-flex justify-content-center shadow"
                                                     style="cursor:pointer" aria-expanded="true">
                                                    <img width="20px" src="/icons/downArrowRed.svg" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <request id="tender" class="collapse show" :prop_request="myDeal.tender"/>
                                    </div>
                                    <div v-if="myDeal.responsesTender"
                                         class="title-request overflow-auto shadow modal-info-object-request tender mb-3">
                                        <div class="title-request__item d-flex flex-wrap pl-4 pr-4 pt-3 pb-3
                                            justify-content-between">
                                            <div class="logo d-flex align-items-center">
                                                <p class="ispr">
                                                    {{ user.role === 3 ? 'Ваш отклик' : '' }}
                                                    {{ user.role === 2 ? 'Предложение исполнителя' : '' }}
                                                </p>
                                            </div>
                                            <div class="d-flex">
                                                <div data-toggle="collapse" data-target="#response"
                                                     class="arrow-button d-none d-lg-flex justify-content-center shadow"
                                                     style="cursor:pointer" aria-expanded="true">
                                                    <img width="20px" src="/icons/downArrowRed.svg" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <request id="response" class="collapse show"
                                                 :prop_request="myDeal.responsesTender"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="deal-customer" v-if="myDeal.customer_info">
                    <p style="font-size: calc(1.125rem);" class="text-muted" :class="{'text-end': user.role == 2}">
                        Заказчик
                    </p>
                    <div class="logo d-flex flex-wrap align-items-center mb-0"
                         :class="{'flex-row-reverse': user.role == 2}">
                        <div class="block__circle mr-2">
                            <img class="block__circle mr-2 ms-2"
                                 :src="myDeal.tender ?'/storage/listings/logos/' + myDeal.customer_info.user_id + '/'
                                     +  myDeal.customer_info.logo
                                 : '/storage/listings/logos/' + myDeal.direct.customer_info.user_id
                                         + '/' + myDeal.direct.company_info.image" alt="">
                        </div>
                        <p class="caption" style="font-size: calc(1.25rem); font-weight: bold; color: #0B3158">
                            {{ myDeal.customer_info.title }}</p>
                        <div class="d-flex flex-wrap position-relative" :class="{'mr-3': user.role == 2}">
                            <div class="message ml-5 p-4 w-100 mb-2">
                                <p>Предлагаю вам заключить сделку на выполнение задания по тендеру
                                    №{{ myDeal.tender.id }} (сообщение сформировано автоматически).</p>
                            </div>
                            <div class="pb-4 d-block ml-lg-5">
                                <p class="ago">{{ fromNow(myDeal.deal_date_ago) }}</p>
                            </div>
                            <p class="text-muted ml-4 date-time" style="font-size: calc(1rem)">
                                <!--{{ deal.deal_date }}!--></p>
                        </div>
                    </div>
                </div>

                <create-estimate v-if="isCreateEstimate || isEditEstimate" :create="isCreateEstimate"
                                 :edit="isEditEstimate" :idEstimate="idEstimate" :id-deal="$props.id" :deal="myDeal"
                                 @visibleModal="visibleEstimate($event)"/>

                <warning :warning="0" v-if="!hasInfoCompany"></warning>
                <warning :warning="1" v-if="!hasPaymentDetail"></warning>

                <template v-if="myDeal.estimates">
                    <estimate :deal_id="myDeal.id" @editEstimate="showEditEstimate"
                              @createEstimate="isCreateEstimate = true" :length="myDeal.estimates.length"
                              v-for="(est, index) in myDeal.estimates" :key="est.id" :get-estimates="est"
                              :customer-info="myDeal.responsesTender.company_info"
                              :executor-info="myDeal.sportObject.created"
                              :index-est="index" @stopTimer="functStopTimer" @getShowReject="getShowReject">
                    </estimate>

                    <awaiting v-show="myDeal.status === 0" :deal-id="myDeal.id"
                              @createEstimate="isCreateEstimate = true"
                              :estimates-length="myDeal.estimates.length" :timer="stopTimer" @showReject="getShowReject"
                              :show-customer="myDeal.estimates.length > 0 ? myDeal.estimates[myDeal.estimates.length - 1].show_customer : null"/>

                    <transaction-management v-show="(myDeal.estimates.length > 0 ? myDeal.estimates[myDeal.estimates.length - 1].status === 3 : false)
                                         && (myDeal.step === 2 || myDeal.step === 3)" :tender-id="myDeal.tender.id"
                                            :get_deal-id="myDeal.id" :completed-at="myDeal.completed_at"
                                            :confirmed-at="myDeal.confirmed_at">
                    </transaction-management>
                </template>

                <div class="deal-complete" v-show="myDeal.step === 4 || myDeal.step === 5">
                    <div class="logo d-flex justify-content-center mb-3 mb-lg-5">
                        <img src="/icons/logo.png" alt="logo">
                    </div>
                    <div class="pb-4">
                        <div class="notif p-3">
                            <div class="align-items-center d-flex notif__text">
                                <img class="mr-4" src="/icons/stages/check-mark.svg" alt="">
                                <div class="w-100">
                                    <p>
                                        <b>Поздравляем,</b> сделка №{{ myDeal.id }} успешно завершена и стороны не
                                        имеют претензий друг к другу.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <review v-show="myDeal.step == 4 && (user.role ==2 ? !myDeal.review : user.role == 3)"
                        :deal-id="myDeal.id" :can-add-review="true"></review>

                <arbitration v-show="myDeal.step == 6 || myDeal.step == 7" :props-deal-id="myDeal.id"></arbitration>

                <warning :warning="2" v-if="myDeal.status == 2"></warning>
                <warning :warning="3" v-if="myDeal.status == 3"></warning>
            </main>

            <div v-if="false" class="container">
                <template v-if="![1,2].includes(myDeal.complete)">
                    <custom-vue-editor text-label="Ваше сообщение" @update:text="myMessage = $event"
                                       :max-length="2000" :text="myMessage" :props="false"/>
                    <div class="d-flex justify-content-center">
                        <button class="button button-blue" style="border-radius: 10px">
                            <span class="mr-2">Отправить</span>
                            <img src="/icons/messages/letter.svg" alt=""></button>
                    </div>
                </template>
            </div>
            <div class="p-2"></div>

            <reject-deal v-if="showRejectDeal === true" @visibleFalse="getFalseReject" :id-deal="myDeal.id"
                         @updateDeal="getDeal({id: $props.id})"/>
        </div>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from './NavBar'
import extendedinf from "./ExtendedFooterInformation";
import VSelect from "@alfsnd/vue-bootstrap-select";
import {mapGetters, mapActions} from "vuex";
import CreateEstimate from "./payment/CreateEstimate";
import VueCountdownTimer from 'vuejs-countdown-timer';
import awaiting from './deal/AwaitingDecision';
import request from './Request';
import warning from './deal/WarningData';
import Estimate from "./estimate/Estimate";
import RejectDeal from "./deal/RejectDeal";
import TransactionManagement from "./deal/TransactionManagement";
import Arbitration from "./deal/Arbitration";
import Review from "./deal/Review";
import StarRating from "vue-star-rating"
import CustomVueEditor from "./elements/CustomVueEditor";

Vue.use(VueCountdownTimer);

export default {
    props: ['id'],
    data: function () {
        return {
            showRejectDeal: false, isCreateEstimate: false, isEditEstimate: false, idEstimate: null,
            stopTimer: false, loading: false, myMessage: ''
        }
    },
    methods: {
        ...mapActions(["fetchDealsReviews", "getDeal"]),
        getShowReject() {
            this.showRejectDeal = true;
        },
        getFalseReject() {
            this.showRejectDeal = false;
        },
        visibleEstimate(x) {
            this.isCreateEstimate = x;
            this.isEditEstimate = x;
        },
        fromNow(deal_date) {
            const moment = require('moment');
            moment.locale('ru');
            const fromNow = moment(deal_date);
            return fromNow.fromNow();
        },
        showEditEstimate(idEstimate) {
            this.idEstimate = idEstimate;
            this.isEditEstimate = true;
        },
        functStopTimer(value) {
            this.stopTimer = value;
        },
    },
    computed: {
        ...mapGetters({
            myDeal: 'AllDeals'
        }),
        user: function () {
            return window.user;
        },
        hasInfoCompany() {
            return true ?? !!this.$store.getters.AllInfoCompanies;
        },
        hasPaymentDetail() {
            return true ?? !!this.$store.getters.AllInfoCompanies?.payment_details;
        }
    },
    async created() {
        if (this.$props.id === undefined) return window.location.href = "/orders-and-payments";
        this.loading = true;
        const actions = [
            this.$store.dispatch("getDeal", {id: this.$props.id}),
            this.fetchDealsReviews(),
        ];
        await Promise.all(actions);
        this.loading = false;
    },
    components: {
        CustomVueEditor,
        Review, Arbitration, TransactionManagement, RejectDeal,
        Estimate, CreateEstimate, navbar, extendedinf, VSelect, awaiting, request, warning, StarRating
    },
}
</script>

<style lang="scss">
.block__circle {
    width: 40px !important;
    height: 40px;
}

.block__circle img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
}

.title-request {
    &__item {
        border: none;
        background-color: #F2F5FF;
    }
}
</style>
