<template>
    <section>
        <div class="container p-0 block-estimate pb-4" v-if="estimate">
            <div class="d-flex flex-estimate"
                 :class="{'flex-row-reverse justify-content-end': user.role == 2, 'justify-content-end': user.role == 3}"
                 v-if="user.role == 2 ? (user.role == 2 && estimate.show_customer == 1) : user.role == 3">
                <div style="width: 75%">
                    <div class="details__estimate w-100 mb-2">
                        <div class="title-estimate d-flex pr-4 pl-4 pt-3 pb-3 align-items-center">
                            <div class="d-lg-block d-none">
                                <p class="mr-4">Детали сметы №{{ estimate.id }}</p>
                            </div>
                            <div class="w-100 d-flex d-lg-none justify-content-between align-items-center mb-2">
                                <p style="font-size: calc(0.875rem)" class="mr-4">Детали сметы №{{ estimate.id }}</p>
                                <div data-toggle="collapse" :data-target="'#estimate-'+estimate.id"
                                     class="arrow-button d-flex d-lg-none justify-content-center shadow"
                                     style="cursor:pointer; width: 36px; height: 36px">
                                    <img width="13px" src="/icons/downArrowRed.svg" alt="up">
                                </div>
                            </div>
                            <div class="btn-services d-flex">
                                <button @click="openInvoice(estimate)"
                                        type="button" class="btn-base button-border p-2 d-flex align-items-center mr-1 mr-lg-2
                                    mb-2 mb-lg-0 flex-fill">
                                    <img class="mr-3" src="/icons/pdf-file.svg" alt="pdf">Смета на услуги
                                </button>
                                <button @click="openPayment(estimate)" type="button"
                                        class="btn-base services button-border p-2 d-flex flex-fill align-items-center mr-4">
                                    <img class="mr-3" src="/icons/pdf-file.svg" alt="pdf">Счет на оплату услуг
                                </button>
                            </div>
                            <button type="button" v-if="user.role == 3 && estimate.show_customer != 1"
                                    @click="$emit('editEstimate', estimate.id)"
                                    class="btn-base button-blue edit_estimate mr-2 p-2 d-flex align-items-center">
                                <img class="mr-3" src="/icons/editWhite.svg" alt="edit">Редактировать смету
                            </button>
                            <div data-toggle="collapse" :data-target="'#estimate-'+estimate.id"
                                 class="arrow-button d-none d-lg-flex justify-content-center shadow"
                                 style="cursor:pointer" aria-expanded="true">
                                <img width="20px" src="/icons/downArrowRed.svg" alt="">
                            </div>
                        </div>

                        <div :id="'estimate-'+estimate.id" class="collapse show">
                            <div class="detail-estimate-name d-lg-flex justify-content-between
                                        p-4 shadow m-3 d-none">
                                <div class="d-flex name align-items-center">
                                    <p class="name mr-4">{{ estimate.sportObject.title }}</p>
                                    <img class="mr-2" src="/icons/direct/world.svg" alt="world">
                                    <p class="city">{{ estimate.sportObject.city }}</p>
                                </div>
                                <div class="d-flex price-and-rating align-items-center">
                                    <div class="price p-2">
                                        <p>от {{ euroObject(estimate.sportObject.accm_minPrice) }} € / чел.</p>
                                    </div>
                                    <div class="rating-messages d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="rating align-items-center col-auto d-flex">
                                                <div class="d-flex">
                                                    <star-rating :increment="0.5" :starSize="16"
                                                                 :activeColor="'#F5AE67'"
                                                                 :showRating="false"
                                                                 :rating="myDeal.sportObject.average_rating"
                                                                 :read-only="true"></star-rating>
                                                    <div>
                                                        <p style="font-size: calc(1rem); color: #0B3158">
                                                            {{ myDeal.sportObject.average_rating | formatRating }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div :id="'estimate-'+estimate.id"
                             class="collapse show detail-estimate-name d-lg-none justify-content-between p-4 shadow m-3">
                            <div class="name align-items-center">
                                <p style="font-size: calc(0.94rem)" class="name mr-4 mb-2">{{
                                        estimate.sportObject.title
                                    }}</p>
                                <div class="city d-flex mb-2">
                                    <img class="mr-2" src="/icons/direct/world.svg" alt="">
                                    <p style="font-size: calc(0.81rem)" class="city">{{ estimate.sportObject.city }}</p>
                                </div>
                            </div>
                            <div class="d-flex price-and-rating align-items-center justify-content-between">
                                <div class="price p-2">
                                    <p>от {{ euroObject(estimate.sportObject.accm_minPrice) }} € / чел.</p>
                                </div>
                                <div class="">
                                    <div class="d-flex">
                                        <div class="rating align-items-center col-auto d-flex">
                                            <div class="d-flex">
                                                <star-rating :increment="0.5" :starSize="16"
                                                             :activeColor="'#F5AE67'"
                                                             :showRating="false"
                                                             :rating="myDeal.sportObject.average_rating"
                                                             :read-only="true"></star-rating>
                                                <div>
                                                    <p style="font-size: calc(1rem); color: #0B3158">
                                                        {{ myDeal.sportObject.average_rating.toPrecision(3) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div :id="'estimate-'+estimate.id" class="description-estimate collapse show">
                            <div class="row ml-4 mr-4">
                                <div class="col-12 col-md-6" v-if="estimate.rentSportObject.checkSport">
                                    <p class="caption">Аренда спорт объекта</p>
                                    <p class="sub_caption">Cтоимость аренды (за человека)</p>
                                    <div class="d-flex">
                                        <div class="buta price ml-0 pl-2 pr-2 p-2">
                                            <p>{{ estimate.rentSportObject.price }} руб.</p>
                                        </div>
                                        <div class="butt pl-2 pr-2 p-2">
                                            <p>за час</p>
                                        </div>
                                    </div>
                                    <p class="sub_caption">Дата пребывания</p>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2 d-lg-block d-none">с</span>
                                        <div class="buta date ml-0 pl-2 pr-2 p-2">
                                            <p>{{ getDate(estimate.rentSportObject.start_date) }}</p>
                                        </div>
                                        <span class="mr-2">по</span>
                                        <div class="buta date ml-0 pl-2 pr-2 p-2">
                                            <p>{{ getDate(estimate.rentSportObject.end_date) }}</p>
                                        </div>
                                        <div class="buta pl-2 pr-2 p-2">
                                            <p>{{ getYear(estimate.rentSportObject.end_date) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6" v-if="estimate.rentAccommodation.checkAccm">
                                    <p class="caption food d-none d-lg-block">Питание</p>
                                    <div class="d-none d-lg-flex">
                                        <div class="buta ml-0 pl-2 pr-2 p-2">
                                            <p>{{ estimate.rentAccommodation.typeFood }}</p>
                                        </div>
                                        <div class="butt pl-2 pr-2 p-2">
                                            <p>
                                                {{
                                                    estimate.rentAccommodation.titlePriceFood == 'Включено в стоимость'
                                                        ? 'включено в стоимость' : 'не включено в стоимость'
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex"
                                         v-if="estimate.rentAccommodation.titlePriceFood != 'Включено в стоимость'">
                                        <div class="buta price ml-0 pl-2 pr-2 p-2">
                                            <p>{{ estimate.rentAccommodation.priceFood }} руб.</p>
                                        </div>
                                        <div class="butt pl-2 pr-2 p-2">
                                            <p>за человека</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 placement" v-if="estimate.rentAccommodation.checkAccm">
                                    <p class="caption d-none d-lg-block">Размещение</p>
                                    <p class="sub_caption">Количество и стоимость проживания</p>
                                    <div v-for="accm in estimate.rentAccommodation.accommodations" v-if="accm.check">
                                        <p class="sub_caption">{{ accm.title }}</p>
                                        <div class="d-flex" v-if="accm.options" v-for="option in accm.options">
                                            <div class="buta ml-0 pl-2 pr-2 p-2">
                                                <p>{{ option.places['title'] }}</p>
                                            </div>
                                            <div class="buta price ml-0 pl-2 pr-2 p-2">
                                                <p>{{ option.price }} руб.</p>
                                            </div>
                                            <div class="butt pl-2 pr-2 p-2">
                                                <p>за сутки</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="sub_caption">Дата размещения</p>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2 d-none d-lg-block">с</span>
                                        <div class="buta date ml-0 pl-2 pr-2 p-2">
                                            <p>{{ getDate(estimate.rentAccommodation.start_date) }}</p>
                                        </div>
                                        <span class="mr-2">по</span>
                                        <div class="buta date ml-0 pl-2 pr-2 p-2">
                                            <p>{{ getDate(estimate.rentAccommodation.end_date) }}</p>
                                        </div>
                                        <div class="butt pl-2 pr-2 p-2">
                                            <p>{{ getYear(estimate.rentAccommodation.end_date) }}</p>
                                        </div>
                                    </div>
                                    <p class="caption food d-block d-lg-none">Питание</p>
                                    <div class="d-flex flex-estimate d-lg-none">
                                        <div class="buta ml-0 pl-2 pr-2 p-2">
                                            <p>{{ estimate.rentAccommodation.typeFood }}</p>
                                        </div>
                                        <div class="butt pl-2 pr-2 p-2">
                                            <p v-if="estimate.rentAccommodation.titlePriceFood == 'Включено в стоимость'">
                                                включено в стоимость</p>
                                            <p v-else>не включено в стоимость</p>
                                        </div>
                                        <div class="d-flex"
                                             v-if="estimate.rentAccommodation.titlePriceFood != 'Включено в стоимость'">
                                            <div class="buta price ml-0 pl-2 pr-2 p-2">
                                                <p>{{ estimate.rentAccommodation.priceFood }} руб.</p>
                                            </div>
                                            <div class="butt pl-2 pr-2 p-2">
                                                <p>за человека</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr width="100%">
                            <div class="row ml-4 mr-4 mb-3">
                                <div class="col-12 col-sm-12 col-md-6">
                                    <p class="caption">Сумма к оплате</p>
                                    <div class="price-estimate d-lg-flex d-none">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="sub_caption mt-1">Стоимость аренды</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="price_rub mt-1"><b>{{
                                                        estimate.rentSportObject.sum.toFixed(2)
                                                    }}
                                                    руб </b><span class="days">за {{
                                                        getDays(estimate.rentSportObject.start_date, estimate.rentSportObject.end_date)
                                                    }}</span></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="sub_caption">Стоимость размещения</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="price_rub"><b>{{
                                                        estimate.rentAccommodation.sumAccm.toFixed(2)
                                                    }}
                                                    руб </b><span
                                                    class="days">за {{
                                                        getDays(estimate.rentAccommodation.start_date, estimate.rentAccommodation.end_date)
                                                    }}</span>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="sub_caption">Стоимость питания</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="price_rub">
                                                    <b>{{ estimate.rentAccommodation.sumPriceFood.toFixed(2) }} руб </b>
                                                    <span class="days">
                                                    за {{
                                                            getDays(estimate.rentAccommodation.start_date, estimate.rentAccommodation.end_date)
                                                        }}
                                                </span>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="sub_caption">Стоимость дополнительных услуг</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="price_rub">
                                                    <b>
                                                        {{ estimate.rentAddition.totalPrice.toFixed(2) }} руб
                                                    </b>
                                                    <span class="days">за {{ additionalCount }}</span></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="sub_caption mt-2">Итого</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="price_rub mt-2"><b>{{
                                                        (estimate.rentSportObject.sum + estimate.rentAccommodation.sumPriceFood
                                                            + estimate.rentAccommodation.sumAccm
                                                            + estimate.rentAddition.totalPrice).toFixed(2)
                                                    }} руб</b></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-lg-none align-items-center">
                                        <div class="price mb-3">
                                            <p class="sub_caption mt-1">Стоимость аренды</p>
                                            <div class="price_rub d-flex mt-1 align-items-center">
                                                <p class="text-white pl-3 pr-3 pt-2 pb-2 mr-3">
                                                    {{ estimate.rentSportObject.sum.toFixed(2) }} руб</p>
                                                <span class="days">за {{
                                                        getDays(estimate.rentSportObject.start_date, estimate.rentSportObject.end_date)
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="price mb-3">
                                            <p class="sub_caption">Стоимость размещения</p>
                                            <div class="price_rub d-flex mt-1 align-items-center">
                                                <p class="text-white pl-3 pr-3 pt-2 pb-2 mr-3">
                                                    {{ estimate.rentAccommodation.sumAccm.toFixed(2) }} руб</p>
                                                <span class="days">за {{
                                                        getDays(estimate.rentAccommodation.start_date, estimate.rentAccommodation.end_date)
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="price mb-3">
                                            <p class="sub_caption">Стоимость питания</p>
                                            <div class="price_rub d-flex mt-1 align-items-center">
                                                <p class="text-white pl-3 pr-3 pt-2 pb-2 mr-3">
                                                    {{ estimate.rentAccommodation.sumPriceFood.toFixed(2) }} руб
                                                </p>
                                                <span class="days">за {{
                                                        getDays(estimate.rentAccommodation.start_date, estimate.rentAccommodation.end_date)
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="price mb-3">
                                            <p class="sub_caption">Стоимость доп. услуг</p>
                                            <div class="price_rub d-flex mt-1 align-items-center">
                                                <p class="text-white pl-3 pr-3 pt-2 pb-2 mr-3">
                                                    {{ estimate.rentAddition.totalPrice.toFixed(2) }} руб
                                                </p>
                                                <span class="days">за {{ additionalCount }}</span>
                                            </div>
                                        </div>
                                        <div class="sum">
                                            <p class="sub_caption mt-3">Итого</p>
                                            <p style="font-weight: bold; font-size: calc(1.25rem)"
                                               class="price_rub mt-2">{{
                                                    (estimate.rentSportObject.sum + estimate.rentAccommodation.sumAccm
                                                        + estimate.rentAccommodation.sumPriceFood
                                                        + estimate.rentAddition.totalPrice).toFixed(2)
                                                }} руб</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="notification d-flex align-items-center p-3 ml-4 mr-4 mb-4">
                                <img class="mr-3" src="/icons/information.svg" alt="">
                                <p>Счет на оплату сформирован автоматически из сметы. При изменении сметы счет будет
                                    создан повторно.</p>
                            </div>
                        </div>
                        <sendEstimate v-if="isShowSendEstimate" :id-deal="$props.deal_id"
                                      :prop_estimate="estimate" @stopTimer="functStopTimer"
                                      @getShowReject="showReject"/>
                    </div>
                    <p v-if="user.role == 3" class="ago text-end">
                        {{ fromNow(estimate.deal_date_ago) }}
                    </p>
                    <p v-if="user.role == 2 && (estimate.show_customer == 1)" class="ago">
                        {{ fromNow(estimate.date_send) }}
                    </p>
                </div>

                <div :class="{'ml-3': user.role !== 2, 'mr-3': user.role === 2}">
                    <p style="font-size: calc(1.125rem);" class="text-muted">Исполнитель</p>
                    <div class="d-flex align-items-center logo mb-2">
                        <div class="block__circle mr-2 w-100">
                            <img class="w-100" :src="'/storage/listings/logos/'
                                             + executorInfo.user_id + '/' + executorInfo.image" alt="logo-customer">
                        </div>
                        <p style="color:#0B3158; font-size: calc(1.25rem)">{{ executorInfo.title }}</p>
                    </div>
                </div>
            </div>


            <div class="estimate_notif" v-if="myDeal.status != 2 && myDeal.status != 3">
                <time-to-end-estimate :show-customer="estimate.show_customer" :length="$props.length"
                                      :step="myDeal.step" :id-estimate="estimate.id" :index-est="$props.indexEst"
                                      :stop-timer="stopTimer" @createEstimate="$emit('createEstimate')"
                                      @getShowReject="showReject"/>

                <div class="p-0 mt-lg-5 mt-3" v-if="user.role == 2 && !stopTimer && estimate.show_customer == 1">
                    <notif-estimate :get_estimate-id="estimate.id" @reject="showReject"
                                    :get-payment="estimate.payment_at_customer" :get_deal-id="myDeal.id"
                                    :get_documents="estimate.documents" :get_status="estimate.status"
                                    @updateEstimates="updateEstimates"/>
                    <p class="ago">
                        {{ fromNow(estimate.date_payment) }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

import sendEstimate from "./SendEstimate";
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import RejectDeal from "../deal/RejectDeal";
import NotifEstimate from "./NotifEstimate";
import axios from "axios";
import StarRating from "vue-star-rating"
import TimeToEndEstimate from "./TimeToEndEstimate";

export default {
    components: {TimeToEndEstimate, NotifEstimate, RejectDeal, sendEstimate, StarRating},
    props: {
        deal_id: {
            type: Number,
        },
        length: {
            type: Number,
            default: 0
        },
        indexEst: {},
        getEstimates: {
            type: Object,
            default: function () {
                return {}
            }
        },
        customerInfo: {
            type: Object,
            default: function () {
                return {}
            }
        },
        executorInfo: {
            type: Object,
            default: function () {
                return {}
            }
        }
    },
    data() {
        return {
            eur: null, stopTimer: false, dealData: {}
        }
    },
    computed: {
        ...mapGetters({
            titleCompany: 'TitleCompany', logo: 'LogoCompany', getDeal: 'AllDeals',
        }),
        user: function () {
            return window.user;
        },
        logoCompany() {
            return '/storage/listings/logos/' + this.user.id + '/' + this.logo;
        },
        estimate() {
            return this.getEstimates;
        },
        myDeal() {
            return this.getDeal;
        },
        additionalCount() {
            let additionalCount = 0;
            if (this.estimate.rentAddition.checkLaundry) additionalCount++;
            if (this.estimate.rentAddition.checkTransfer) additionalCount++;
            this.estimate.rentAddition.infrastructures.map(infrastructure => {
                if (infrastructure.check) additionalCount++;
            })
            return this.getServiceText(additionalCount);
        },
        isShowSendEstimate() {
            return (this.dealData.status !== 2 && this.dealData.status !== 3);
        }
    },
    methods: {
        ...mapActions(["estimateConfirmation",]),
        showReject() {
            this.$emit('getShowReject');
        },
        getDate(date) {
            return moment(new Date(date)).format("D MMMM");
        },
        getYear(date) {
            return moment(new Date(date)).format("YYYY");
        },
        getDays(start, end) {
            let start_date = moment(new Date(start));
            let end_date = moment(new Date(end)).add(1, 'day');
            return this.getDaysText(end_date.diff(start_date, 'days'));
        },
        getDaysText(count) {
            let text = "суток";
            if (count === 1) text = 'сутки'
            return `${count} ${text}`;
        },
        getEUR() {
            /*axios.get('https://free.currconv.com/api/v7/convert?apiKey=cd2ff852330c08894153&q=RUB_EUR&compact=ultra').then(response => {
                this.eur = response.data.RUB_EUR;
            }).catch((error) => {
                console.log(error.response);
            });*/
        },
        euroObject(price) {
            return Number(0.012 * price).toFixed(0);
        },
        fromNow(date) {
            const moment = require('moment');
            moment.locale('ru');
            const fromNow = moment(date);
            return fromNow.fromNow();
        },
        functStopTimer(value) {
            this.stopTimer = value;
        },
        updateEstimates() {
            this.$store.dispatch("getDeal", {id: this.$props.deal_id});
        },
        momentMonthDate(date) {
            return moment(moment(date)).format('LL');
        },
        showInvoice(estimate) {
            const services = [];
            const daysAccm = estimate.rentAccommodation.daysAccm;

            // Helper function to add service
            const addService = (title, price, justification) => {
                services.push({ title, price, justification });
            };

            // Аренда спортивного объекта
            if (estimate.rentSportObject.checkSport && estimate.rentSportObject.sum !== 0) {
                addService(
                    'Аренда спортивного объекта',
                    estimate.rentSportObject.sum,
                    `${estimate.rentSportObject.price} руб/час\n`
                );
            }

            // Размещение
            if (estimate.rentAccommodation.checkAccm) {
                const justifAccm = `Даты размещения: ${this.momentMonthDate(estimate.rentAccommodation.start_date)} - ${this.momentMonthDate(estimate.rentAccommodation.end_date)}\n`;
                estimate.rentAccommodation.accommodations.filter((a) => a.check).forEach((a) => {
                    let price = 0;
                    let options = '';

                    a.options.forEach((o) => {
                        const colNum = o.colNum || 1;
                        options += ` (${o.places.title}, номеров: ${colNum})`;
                        price += Number(o.price);
                    });

                    addService(a.title, price * daysAccm, justifAccm + a.title + options + '; \n');
                });
            }

            // Питание
            if (estimate.rentAccommodation.checkAccm && estimate.rentAccommodation.priceFood != null) {
                addService(
                    'Питание',
                    estimate.rentAccommodation.sumPriceFood,
                    `Тип питания: ${estimate.rentAccommodation.typeFood}\n`
                );
            }

            // Инфраструктура
            estimate.rentAddition.infrastructures.filter((i) => i.check).forEach((i) => {
                const justifInfra = `Даты размещения: ${this.momentMonthDate(i.start_date)} - ${this.momentMonthDate(i.end_date)}\n`;
                addService(i.title, i.price * daysAccm, justifInfra);
            });

            // Прачечная
            if (estimate.rentAddition.checkLaundry) {
                addService(
                    'Услуги прачечной',
                    estimate.rentAddition.sumLaundry,
                    `Объем стирки: ${estimate.rentAddition.washingVolume} кг, цена за кг: ${estimate.rentAddition.priceWashing} руб.\n`
                );
            }

            // Трансфер
            if (estimate.rentAddition.checkTransfer) {
                addService(
                    'Трансфер от/до аэропорта на автобусе',
                    estimate.rentAddition.sumTransfer,
                    `Период (продолжительность): ${estimate.rentAddition.durationTransfer} часов, стоимость за час: ${estimate.rentAddition.priceTransfer} руб.\n`
                );
            }

            // Итоговая сумма
            const total = services.reduce((sum, service) => sum + Number(service.price), 0);

            // Отправка данных на сервер
            axios.put('/invoices/download/', {
                deal_id: estimate.deal_id,
                est_id: estimate.id,
                services,
                total
            });
        },
        showPayment(estimate) {
            const services = [];
            const daysAccm = estimate.rentAccommodation.daysAccm;

            if (estimate.rentSportObject.checkSport && estimate.rentSportObject.sum !== 0) {
                services.push({
                    title: 'Аренда спортивного объекта',
                    price: estimate.rentSportObject.sum,
                    justification: `${estimate.rentSportObject.price} руб/час\n`,
                    unit: 'час',
                    pre_price: estimate.rentSportObject.price
                });
            }

            if (estimate.rentAccommodation.checkAccm) {
                const accommodations = estimate.rentAccommodation.accommodations.filter((a) => a.check);

                const justif = `Даты размещения: ${this.momentMonthDate(estimate.rentAccommodation.start_date)}
                 - ${this.momentMonthDate(estimate.rentAccommodation.end_date)}\n`;
                let options = '';
                accommodations.forEach((a) => {
                    let price = 0;

                    a.options.forEach((o) => {
                        const colNum = o.colNum || 1;
                        const places = o.places.title;
                        options += ` (${places}, номеров: ${colNum})`;
                        price += Number(o.price)
                    });

                    services.push({
                        title: a.title,
                        price: price * daysAccm,
                        justification: justif + a.title + options + '; \n',
                        unit: 'дн.',
                        pre_price: price
                    });
                    options = '';
                });
            }
            if (estimate.rentAccommodation.checkAccm && estimate.rentAccommodation.priceFood != null) {
                services.push({
                    title: 'Питание',
                    price: estimate.rentAccommodation.sumPriceFood,
                    justification: `Тип питания: ${estimate.rentAccommodation.typeFood}\n`,
                    unit: 'дн.',
                    pre_price: estimate.rentAccommodation.priceFood,
                    days: daysAccm
                });
            }

            const infrastructures = estimate.rentAddition.infrastructures.filter((i) => i.check);
            infrastructures.forEach((i) => {
                const justif = `Даты размещения: ${this.momentMonthDate(i.start_date)} - ${this.momentMonthDate(i.end_date)}\n`;
                services.push({
                    title: i.title,
                    price: i.price * daysAccm,
                    justification: justif,
                    unit: 'дн.',
                    pre_price: i.price
                });
            });

            if (estimate.rentAddition.checkLaundry) {
                services.push({
                    title: 'Услуги прачечной',
                    price: estimate.rentAddition.sumLaundry,
                    justification: `Объем стирки: ${estimate.rentAddition.washingVolume} кг, цена за кг: ${estimate.rentAddition.priceWashing} руб.\n`,
                    unit: 'кг',
                    pre_price: estimate.rentAddition.priceWashing
                });
            }

            if (estimate.rentAddition.checkTransfer) services.push({
                title: 'Трансфер от/до аэропорта на автобусе',
                price: estimate.rentAddition.sumTransfer,
                justification: `'Период(продолжительность): ${estimate.rentAddition.durationTransfer} часов, стоимость за час: ${estimate.rentAddition.priceTransfer} руб. \n`,
                unit: 'час',
                pre_price: estimate.rentAddition.priceTransfer
            });

            let total = services.reduce((sum, service) => sum + Number(service.price), 0);

            let customer_payment = {};
            axios.get(`/api/user/payment-details/${estimate.customer_id}`).then((response) => {
                customer_payment = response.data.paymentDetails;

                axios.put('/invoice-payment/download/', {
                    'estimate': estimate,
                    'deal_id': estimate.deal_id,
                    'est_id': estimate.id,
                    'customer': customer_payment,
                    'services': services,
                    'total': total,
                })
            });
        },
        openInvoice(estimate) {
            window.open("/storage/listings/estimate/" + estimate.deal_id + "/" + estimate.id, '_blank')
        },
        openPayment(estimate) {
            window.open("/storage/listings/payment-invoice/" + estimate.deal_id + "/" + estimate.id, '_blank')
        },
        getServiceText(count) {
            let text = "услуг";
            const lastDigit = count % 10;
            const lastTwoDigits = count % 100;
            if (lastDigit === 1 && lastTwoDigits !== 11) {
                text = "услугу";
            } else if (lastDigit >= 2 && lastDigit <= 4 && (lastTwoDigits < 10 || lastTwoDigits >= 20)) {
                text = "услуги";
            }
            return `${count} ${text}`;
        },
    },
    mounted() {
        this.getEUR();
        this.$emit('stopTimer', this.stopTimer);
        this.$store.dispatch("getDeal", {id: this.$props.deal_id}).then((response) => {
            this.dealData = response;
        });
        this.showInvoice(this.estimate);
        this.showPayment(this.estimate);
    }
}
</script>

<style scoped>
.block-estimate .details__estimate {
    /* width: 75%;*/
}

.block-estimate .executor {
    width: 25%;
}

@media (max-width: 992px) {
    .block-estimate .details__estimate {
        width: 100%;
    }

    .block-estimate .executor {
        width: 100%;
    }

    .block-estimate .btn-services button {
        height: 47px !important;
    }
}
</style>
