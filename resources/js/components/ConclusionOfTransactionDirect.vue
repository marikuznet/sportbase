<template>
    <div v-if="myDeal">
        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <div class="deal-caption d-flex align-items-center justify-content-center"
             style="height: 105px; background-color:#231F6D">
            <p class="text-uppercase"><b>заключение сделки №{{ myDeal.id }}</b></p>
        </div>
        <div style="background-color: #F9F9F9">
            <main class="proposal-card container p-0 notifications">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-4 px-lg-0 py-4 my-lg-2" style="background-color: transparent">
                        <li class="breadcrumb-item fs-lg-5"><a href="/">Главная</a></li>
                        <li class="breadcrumb-item fs-lg-5"><a href="/orders-and-payments">Заказы и оплаты</a></li>
                        <li class="breadcrumb-item active fs-lg-5">Заключение сделки №{{ myDeal.id }}</li>
                    </ol>
                </nav>
                <div class="deal-block mb-3" v-if="myDeal.direct">
                    <div class="title__deal-block d-flex align-items-center p-3">
                        <div class="title__deal-block__executor align-items-center d-lg-flex d-none"
                             v-if="user.role === 3">
                            <img class="mr-4" src="/icons/stages/check-mark.svg" alt="">
                            <p class="caption mr-4">Поздравляем, вы приняли предложение по заявке №{{
                                    myDeal.direct.id
                                }}
                                от</p>
                            <div style="width: 40px; height: 40px" class="mr-4">
                                <img class="mr-4 w-100 h-100" style="border-radius: 100%"
                                     :src="'/storage/listings/logos/' + myDeal.direct.customer_info.user_id + '/'
                                     + myDeal.direct.customer_info.logo" alt="">
                            </div>
                            <p class="caption mr-4">{{ myDeal.direct.customer_info.title }}</p>
                        </div>
                        <div class="mobile-title__deal-block__executor d-flex d-lg-none" v-if="user.role === 3">
                            <div class="flex-grow-0">
                                <img width="25px" class="mr-4" src="/icons/stages/check-mark.svg" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p class="caption mr-4">Поздравляем,</p>
                                <div class="d-flex align-items-center mb-2">
                                    <p class="caption mr-4"> вы приняли предложение по заявке №{{
                                            myDeal.direct.id
                                        }} от</p>
                                    <img width="30px" class="mr-4"
                                         :src="'/storage/listings/logos/' + myDeal.direct.customer_info.user_id + '/'
                                         + myDeal.direct.customer_info.logo" alt="">
                                    <p class="caption mr-4"> {{
                                            myDeal.direct.customer_info.title
                                        }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="title__deal-block__executor align-items-center d-lg-flex d-none"
                             v-if="user.role === 2">
                            <img class="mr-4" src="/icons/stages/check-mark.svg" alt="">
                            <p class="caption mr-4">Поздравляем, исполнитель</p>
                            <div style="width: 40px; height: 40px" class="mr-4">
                                <img class="mr-4 w-100 h-100" style="border-radius: 100%"
                                     :src="'/storage/listings/logos/' + myDeal.direct.customer_info.user_id + '/'
                                         +  myDeal.direct.customer_info.logo"
                                     alt="">
                            </div>
                            <p class="caption mr-4">
                                {{ myDeal.direct.sportObject.created.title }}
                            </p>
                            <p class="caption">принял вашу заявку №{{ myDeal.direct.id }}</p>
                        </div>
                        <div class="mobile-title__deal-block__executor d-flex d-lg-none" v-if="user.role === 2">
                            <div class="flex-grow-0">
                                <img width="25px" class="mr-4" src="/icons/stages/check-mark.svg" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p class="caption mr-4">Поздравляем,</p>
                                <div class="d-flex align-items-center mb-2">
                                    <p class="caption mr-4"> исполнитель</p>
                                    <img width="30px" class="mr-4"
                                         :src="'/storage/listings/logos/' + myDeal.direct.customer_info.user_id + '/'
                                         + myDeal.direct.customer_info.logo" alt="">
                                    <p class="caption mr-4"> {{ myDeal.direct.customer_info.title }}</p>
                                    <p class="caption">принял вашу заявку №{{ myDeal.id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="request-customer">
                        <div class="info-full-request-object" style="border: none">
                            <div class="response">
                                <div class="container pb-2">
                                    <div class="shadow modal-info-object-request tender mb-3">
                                        <div
                                            class="title-info d-flex flex-wrap pt-3 pb-3 pl-4 pr-4 justify-content-between">
                                            <div class="logo d-flex align-items-center">
                                                <p class="ispr">Заявка от заказчика</p>
                                            </div>
                                            <div class="arrow-button d-flex justify-content-center shadow"
                                                 @click="visibleDetailsDirect" style="cursor:pointer">
                                                <img width="20px" alt=""
                                                     :src="detailsDirect ? '/icons/upArrowRed.svg' : '/icons/selectArow.svg'">
                                            </div>
                                        </div>
                                        <div class="body-info" v-if="detailsDirect">
                                            <div class="proposal-card request-object p-4"
                                                 style="border: none; border-bottom: 1px solid lightgray;">
                                                <div class="titleObject pb-2 d-flex justify-content-between">
                                                    <p class="captionObject text-uppercase">
                                                        {{ myDeal.direct.sportObject.title || '' }}
                                                        <span class="pl-3 text-muted text-lowercase objectId">ID {{
                                                                myDeal.direct.sportObject.id
                                                            }}</span>
                                                    </p>
                                                </div>
                                                <div
                                                    class="info-request-object d-flex flex-wrap justify-content-between">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="d-flex">
                                                            <div class="create padding mr-2">
                                                                <div class="title d-flex pb-2">
                                                                    <img src="/icons/direct/XMLID_14_.svg"
                                                                         alt="created-icon">
                                                                    <p class="pl-3 caption">Создана</p>
                                                                </div>
                                                                <div class="field-green">
                                                                    <p class="text-nowrap d-flex">{{ myDeal.deal_date }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="create mr-2">
                                                                <div class="title d-flex pb-2">
                                                                    <p class=" caption">Человек</p>
                                                                </div>
                                                                <div class="field">
                                                                    <p class="text-nowrap">{{ myDeal.direct.colPeople }}
                                                                        человек</p>
                                                                </div>
                                                            </div>
                                                            <div class="create mr-4">
                                                                <div class="title d-flex pb-2">
                                                                    <p class="caption">Стоимость</p>
                                                                </div>
                                                                <div class="price d-flex align-items-center">
                                                                    <div class="field-blue mr-2">
                                                                        <p class="text-nowrap">
                                                                            {{ myDeal.direct.minPrice }} руб.</p>
                                                                    </div>
                                                                    <p class="text-nowrap">за сутки</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <rating-messages :average_rating="myDeal.sportObject.average_rating"
                                                                     :reviews_count="myDeal.sportObject.reviews_count"/>
                                                </div>
                                            </div>

                                            <request :prop_request="myDeal.direct"></request>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="deal-customer mt-5">
                    <div class="customer">
                        <div class="logo d-flex flex-wrap align-items-center justify-content-end"
                             v-if="user.role === 3 && myDeal.direct">
                            <div class="d-flex flex-wrap position-relative mr-3">
                                <div class="message ml-4 p-4 w-100 mb-2">
                                    <p>Вы приняли условия по заявке №{{ myDeal.direct.id }}. Сформируйте смету и счет на
                                        оплату услуг, далее отправьте ее заказчику.</p>
                                </div>
                                <div v-if="false" class="pb-4 ml-lg-4">
                                    <p class="ago">{{ fromNow(myDeal.deal_date_ago) }}</p>
                                </div>
                            </div>
                            <div class="d-block">
                                <p style="font-size: calc(1.125rem);" class="text-muted">Исполнитель (Вы)</p>
                                <div class="info-company d-flex align-items-center">
                                    <div class="logo-round">
                                        <img class="mr-2 w-100 h-100" alt="logo"
                                             :src="'/storage/listings/logos/' + myDeal.executor_info.user_id + '/'
                                         + myDeal.executor_info.logo">
                                    </div>
                                    <p class="caption pl-2"
                                       style="font-size: calc(1.25rem); font-weight: bold; color: #0B3158">
                                        {{ myDeal.direct.sportObject.created.title }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <create-estimate v-if="isCreateEstimate || isEditEstimate" :create="isCreateEstimate"
                                 :edit="isEditEstimate" :idEstimate="idEstimate" :id-deal="$props.id" :deal="myDeal"
                                 @visibleModal="visibleEstimate($event)"/>

                <warning-data :warning="0" v-if="!hasInfoCompany"/>
                <warning-data :warning="1" v-if="!hasPaymentDetail"/>

                <template v-if="myDeal.estimates">
                    <estimate :deal_id="myDeal.id" @editEstimate="showEditEstimate"
                              :customer-info="myDeal.customer_info" :executor-info="myDeal.executor_info"
                              @createEstimate="isCreateEstimate = true" :length="myDeal.estimates.length"
                              v-for="(est, index) in myDeal.estimates" :key="est.id" :get-estimates="est"
                              :index-est="index" @stopTimer="functStopTimer" @getShowReject="getShowReject"/>

                    <awaiting-decision :deal="myDeal" @createEstimate="isCreateEstimate = true"
                                       :timer="stopTimer" @showReject="getShowReject"
                                       :estimates-length="myDeal.estimates.length"
                                       :show-customer="myDeal.estimates.length > 0 ? myDeal.estimates[myDeal.estimates.length - 1].show_customer : null"/>

                    <transaction-management
                        v-show="(myDeal.estimates.length > 0 ? myDeal.estimates[myDeal.estimates.length - 1].status == 3 : false)
                        && (myDeal.step == 2 || myDeal.step ==3)" :direct-id="myDeal.direct.id"
                        :get_deal-id="myDeal.id" :completed-at="myDeal.completed_at"
                        :confirmed-at="myDeal.confirmed_at">
                    </transaction-management>
                </template>

                <div class="container notifications p-0">
                    <review class=" mb-lg-5"
                            v-show="myDeal.step == 4 && (user.role == 2 ? !myDeal.review : user.role == 3)"
                            :deal-id="myDeal.id" :review-data="myDeal.review" :can-add-review="true"
                            @closeEditor="closeEditor"></review>

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

                    <arbitration v-show="myDeal.step == 6 || myDeal.step == 7" :props-deal-id="myDeal.id"></arbitration>

                    <warning-data :warning="2" v-if="myDeal.status == 2"></warning-data>
                    <warning-data :warning="3" v-if="myDeal.status == 3"></warning-data>
                </div>

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
            </main>

            <div class="mb-4 p-2"></div>

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
import {mapActions, mapGetters} from "vuex";
import CreateEstimate from "./payment/CreateEstimate";
import VueCountdownTimer from 'vuejs-countdown-timer';
import Request from "./Request";
import AwaitingDecision from "./deal/AwaitingDecision";
import WarningData from "./deal/WarningData";
import Estimate from "./estimate/Estimate";
import RejectDeal from "./deal/RejectDeal";
import TransactionManagement from "./deal/TransactionManagement";
import Review from "./deal/Review";
import Arbitration from "./deal/Arbitration";
import StarRating from "vue-star-rating"
import RatingMessages from "./elements/RatingMessages";
import CustomVueEditor from "./elements/CustomVueEditor";

Vue.use(VueCountdownTimer);


export default {
    props: ['id'],
    data: function () {
        return {
            showRejectDeal: false, rejections: [], isCreateEstimate: false, detailsDirect: true,
            showPaymentExpired: false, isEditEstimate: false, idEstimate: null, stopTimer: false,
            loading: true, myMessage: ''
        }
    },
    methods: {
        ...mapActions(["fetchDealsReviews", "getDeal"]),
        visibleEstimate(x) {
            this.isCreateEstimate = x;
            this.isEditEstimate = x;
        },
        showEditEstimate(value) {
            this.idEstimate = value;
            this.isEditEstimate = true;
        },
        fromNow(deal_date) {
            let moment = require('moment');
            moment.locale('ru');

            let fromNow = moment(deal_date);
            return fromNow.fromNow();
        },
        visibleDetailsDirect() {
            this.detailsDirect = !this.detailsDirect;
        },
        functStopTimer(value) {
            this.stopTimer = value;
        },
        getShowReject() {
            this.showRejectDeal = true;
        },
        getFalseReject() {
            this.showRejectDeal = false;
        },
        closeEditor() {
            window.location.reload()
        }
    },
    computed: {
        ...mapGetters({
            logo: 'LogoCompany', infoCompany: 'AllInfoCompanies',
            allReviews: 'AllDealsReviews', myDeal: 'AllDeals'
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
    mounted() {
    },
    async created() {
        if (this.$props.id === undefined) return window.location.href = "/orders-and-payments";
        this.loading = true;
        const actions = [
            this.$store.dispatch("getDeal", {id: this.$props.id}),
            this.fetchDealsReviews()
        ];
        await Promise.all(actions).then(() => {
            this.loading = false;
        });
    },
    components: {
        CustomVueEditor,
        RatingMessages,
        Arbitration, Review, TransactionManagement, RejectDeal, Estimate, WarningData, AwaitingDecision, Request,
        CreateEstimate, navbar, extendedinf, VSelect, StarRating
    },
}
</script>

<style scoped>
.deal-block {
    border: 1px solid #BAC4DF;
    border-radius: 10px;
    background-color: white;
}

.deal-block .title__deal-block {
    background-color: #F2F5FF;
    border-radius: 10px 10px 0 0;
    border-bottom: 1px solid #BAC4DF;
    margin-bottom: 30px;
}

.deal-block .title__deal-block .caption,
section .details__estimate .title-estimate p,
.detail-estimate-name .name {
    color: #0B3158;
    font-size: calc(1.25rem);
    font-weight: bold;
}

.deal-block .title__deal-block .caption.normal {
    font-weight: normal;
}

.deal-block .btn.city p, .deal-block .butn p {
    font-size: calc(1.06rem);
}

.arrow-button {
    background-color: white;
    width: 50px;
    height: 50px;
    border: 1px solid #BAC4DF;
    border-radius: 10px;
}

.deal-customer .message {
    background-color: #F2F5FF;
    border-radius: 10px;
    border: 1px solid #BAC4DF;
}

.deal-customer .baloon:before {
    position: absolute;
    content: '';
    left: 0;
    top: -19px;
    border: 20px solid transparent;
    border-left: 20px solid #BAC4DF;
}

.deal-customer .baloon:after {
    position: absolute;
    content: '';
    left: 0;
    top: -18px;
    border: 20px solid transparent;
    border-left: 20px solid #F2F5FF;
}

.deal-customer .message p {
    color: #0B3158;
    font-size: calc(1rem);
}

.deal-customer .logo {
    margin-bottom: 35px;
}

.deal-customer .details {
    background-color: #EBECF1;
    border-radius: 10px;
}

.deal-customer .details p,
.description-estimate .sub_caption {
    font-size: calc(1.125rem);
    color: #59728B;
}

.deal-customer .details .estimate,
.deal-customer .details .cancel {
    background-color: white;
    border-radius: 10px;
}

.deal-customer .details .estimate button,
.deal-customer .details .cancel button {
    width: 180px;
    height: 50px;
    background-color: #6FB77F;
    border-radius: 5px;
    color: white;
}

.deal-customer .details .cancel button,
.btn_arbitration button {
    background-color: transparent !important;
    border: 1px solid #E45868 !important;
    color: #E45868 !important;
}

section .details__estimate {
    background-color: white;
    border-radius: 10px;
    border: 1px solid #BAC4DF;
}

section .details__estimate .title-estimate {
    background-color: #F2F5FF;
    border-radius: 10px 10px 0 0;
}

section .details__estimate .title-estimate button {
    font-size: calc(1rem);
    border-radius: 10px;
    background-color: transparent;
}

.button-blue {
    background-color: #6283E5 !important;
    color: white;
    font-size: calc(1.06rem) !important;
    height: 47px;
}

.arrow-button {
    width: 50px;
    height: 50px;
    border: 1px solid #BAC4DF;
    border-radius: 10px;
}

.detail-estimate-name {
    border-radius: 10px;
}

.detail-estimate-name .city {
    color: #6283E5;
    font-size: calc(1.125rem);
}

.detail-estimate-name .price {
    border: 1px solid #1A9536;
    border-radius: 10px;
}

.detail-estimate-name .price p,
.description-estimate .buta p,
.description-estimate .days {
    color: #0B3158;
    font-size: calc(1rem);
}

.description-estimate .caption {
    font-size: calc(1.125rem);
    font-weight: bold;
    color: #0B3158;
}

.description-estimate .buta.price {
    border-color: #6283E5;
}

.description-estimate .buta.date {
    border-color: #1A9536;
}

.description-estimate .price_rub,
.notifications .congratulate p {
    font-size: calc(1.25rem);
    color: #0B3158;
}

.description-estimate .notification {
    border-radius: 10px;
    border: 1px solid #BAC4DF;
}

.description-estimate .notification p {
    color: #32325D;
    font-size: calc(1.125rem);
}

.notifications .notif {
    border-radius: 10px;
    background-color: white;
    border: 2px solid #BAC4DF;
}

.notif p {
    font-size: calc(1.25rem);
    color: #0B3158;
}

.congratulate p {
    font-size: calc(1.25rem);
    color: #0B3158;
}

.notifications .notif .order {
    font-size: calc(1.375rem);
    font-weight: bold;
    color: #0B3158;
}

.review .title p {
    font-size: calc(1.25rem);
}

.review .rating {
    border: 1px solid #BAC4DF;
    border-radius: 10px;
}

.review .rating p {
    font-size: calc(1.125rem);
    color: #0B3158;
}

.review .text {
    border: 1px solid #BAC4DF;
    border-radius: 10px;
    background-color: #F2F5FF;
}

.review .text p {
    color: #0B3158;
    font-size: calc(1.125rem);
}

.btn-review button {
    width: 280px;
}

.allReviews {
    background-color: #F9F9F9;
    border-radius: 0 0 10px 10px;
    border-top: 2px solid #BAC4DF;
}

.allReviews .reviews button {
    background-color: white;
    border: 1px solid #6283E5;
    border-radius: 5px;
    color: #6283E5;
    font-size: calc(1.25rem);
}

.allReviews .reviews p {
    color: #0B3158;
    font-size: calc(1.25rem);
}

.allReviews .reviews {
    background-color: white;
    border-radius: 10px;
}

.deal-caption p {
    font-size: calc(1.75rem) !important;
}

@media (max-width: 960px) {
    .deal-block {
        margin-left: 1.5rem !important;
        margin-right: 1.5rem !important;
    }

    .deal-block .title__deal-block .caption,
    .description-estimate .caption {
        font-size: calc(0.875rem);
    }

    .deal-block .title__deal-block .caption.normal {
        width: 180px;
    }

    .info-full-request-object .modal-info-object-request .title-info .ispr {
        font-size: calc(0.875rem) !important;
    }

    .info-region .butn.city p, .butn p {
        font-size: calc(0.81rem) !important;
    }

    .deal-customer {
        margin-left: 1.5rem !important;
        margin-right: 1.5rem !important;
        width: auto;
    }

    .deal-customer .customer p {
        font-size: calc(0.94rem) !important;
    }

    .deal-customer .date-time {
        font-size: calc(0.875rem) !important;
    }

    .deal-customer .message, .deal-customer .message p {
        margin-left: 0 !important;
    }

    .details .estimate {
        margin-right: 0 !important;
        margin-bottom: 1rem;
    }

    .details .estimate p, .details .cancel p {
        margin-bottom: 1rem;
    }

    .details .estimate, .details .cancel, .customer .details {
        flex-wrap: wrap;
    }

    .deal-customer .details .estimate button,
    .deal-customer .details .cancel button {
        height: 45px !important;
    }

    .details .estimate, .details .cancel {
        width: 100% !important;
    }

    .block-estimate .executor {
        order: -1;
    }

    .block-estimate .executor p {
        font-size: calc(0.94rem) !important;
    }

    .block-estimate .executor {
        width: 100% !important;
    }

    .block-estimate .executor .logo img {
        width: 30px;
    }

    .block-estimate .executor .logo p {
        color: #0B3158;
        font-size: calc(0.875rem);
        font-weight: bold;
    }

    .details__estimate {
        width: 100% !important;
    }

    .details__estimate .title-estimate {
        flex-wrap: wrap;
    }

    section .details__estimate .title-estimate {
        font-size: calc(0.875rem) !important;
    }

    section .details__estimate .title-estimate button {
        width: 50% !important;
    }

    section .details__estimate .title-estimate button {
        font-size: calc(0.875rem) !important;
    }

    section .details__estimate .title-estimate .edit_estimate {
        width: 190px !important;
        font-size: calc(0.81rem) !important;
    }

    .btn-services .services {
        margin-right: 0 !important;
    }

    .buta p, .description-estimate .food {
        font-size: calc(0.81rem) !important;
        font-weight: normal;
        margin-bottom: 0 !important;
    }

    .description-estimate .placement {
        width: 100% !important;
    }

    .description-estimate .notification p {
        font-size: calc(0.81rem);
    }

    .description-estimate .notification img {
        width: 17px;
    }

    .notif {
        margin-left: 1.5rem !important;
        margin-right: 1.5rem !important;
    }

    .block-estimate .ago,
    .notifications .ago {
        font-size: calc(0.875rem) !important;
    }

    .notif .enum p {
        font-size: calc(0.875rem) !important;
    }

    .notif .order {
        font-size: calc(0.875rem) !important;
    }

    .notif img {
        width: 24px;
    }

    .notif .rating img {
        width: 17px;
    }

    .details__estimate {
        margin-right: 0 !important;
    }

    .description-estimate .sub_caption {
        color: #0B3158;
        font-size: calc(0.875rem);
    }

    .deal-caption {
        height: 100px;
    }

    .deal-caption p {
        font-size: calc(1.25rem) !important;
        font-weight: normal;
        text-align: center;
        margin-right: 5rem !important;
        margin-left: 5rem !important;
    }

    .deal-customer .customer p {
        margin-left: 0 !important;
    }
}
</style>
