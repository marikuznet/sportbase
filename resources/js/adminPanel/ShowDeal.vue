<template>
    <main class="mr-3 ml-3" v-if="myDeal">
        <nav aria-label="breadcrumb" class="pt-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/deals/in_progress">Сделки (На согласовании)</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Детали сделки (ID: {{ myDeal.id }} )
                </li>
            </ol>
        </nav>
        <div class="caption mb-3"><h4><b>Детали сделки ({{ myDeal.tender ? 'Тендерная' : 'Прямая' }})</b>
        </h4></div>
        <div class="row">
            <div class="col-lg-8">
                <div class="block-application">
                    <template v-if="myDeal.tender">
                        <admin-custom-deal :deal="myDeal.tender" deal-type="tender"></admin-custom-deal>
                        <admin-custom-deal :deal="myDeal.responsesTender" deal-type="response"></admin-custom-deal>
                    </template>
                    <template v-if="myDeal.direct">
                        <admin-custom-deal :deal="myDeal.direct" deal-type="direct"
                                           :sport-object="myDeal.sportObject"></admin-custom-deal>
                    </template>

                    <div class="block-application__deal" v-if="myDeal.tender">
                        <div class="caption d-flex">
                            <b class="mr-2">Сторона</b>
                            <p @click.prevent="visibleTenderCustomer"><a class="mr-2" href="#">ЗАКАЗЧИК</a></p>
                            <p @click.prevent="visibleTenderExecutor"><a class="mr-2" href="#">ИСПОЛНИТЕЛЬ</a></p>
                            <p @click.prevent="visibleArbitrazh"><a class="mr-2" href="#">АРБИТР</a></p>
                        </div>
                        <div class="block-application-deal__customer" v-if="showTenderCustomer">
                            <tender-customer-info :my-deal="myDeal" :is-customer="true"/>
                            <estimates-block v-if="estimates.length > 0" :estimates="estimates" :my-deal="myDeal"
                                             :is-customer="true"/>
                        </div>

                        <div class="block-application-deal__executor" v-if="showTenderExecutor">
                            <tender-customer-info :my-deal="myDeal" :is-customer="false"/>
                            <estimates-block v-if="estimates.length > 0" :estimates="estimates" :my-deal="myDeal"
                                             :is-customer="false"/>
                        </div>
                        <div class="block-application-deal__arbitr" v-if="visibleArbitr">
                            <arbitr :props-deal-id="myDeal.id"></arbitr>
                        </div>
                    </div>
                </div>

                <div class="block-application__deal" v-if="myDeal.direct">
                    <div class="caption d-flex">
                        <b class="mr-2">Сторона</b>
                        <p @click.prevent="visibleTenderCustomer"><a class="mr-2" href="#">ЗАКАЗЧИК</a></p>
                        <p @click.prevent="visibleTenderExecutor"><a class="mr-2" href="#">ИСПОЛНИТЕЛЬ</a></p>
                        <p v-if="false" @click.prevent="visibleArbitrazh"><a class="mr-2" href="#">АРБИТР</a></p>
                    </div>
                    <div class="block-application-deal__customer" v-if="showTenderCustomer">
                        <div class="row mb-3">
                            <div class="col-3">
                                <h6>Заказчик</h6>
                                <div class="d-flex">
                                    <div class="img mr-1 block__circle" style="width: 40px; height: 40px">
                                        <img class="w-100 h-100" alt=""
                                             :src="`/storage/listings/logos/${myDeal.direct.customer_info.user_id}/${myDeal.direct.customer_info.logo}`">
                                    </div>
                                    <p><b>{{ myDeal.direct.customer_info.title }}</b></p>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="block-grey pl-3 pr-3 pt-1">
                                    <p class="mb-0">Предлагаю вам заключить сделку на выполнение задания по прямой
                                        заявке №{{ myDeal.direct.id }} (сообщение сформировано автоматически).</p>
                                </div>
                                <div class="block-days-ago">
                                    <p class="text-muted">{{ fromNow(myDeal.deal_date_ago) }}</p>
                                </div>
                            </div>
                        </div>

                        <estimates-block v-if="estimates.length > 0" :estimates="estimates" :my-deal="myDeal"
                                         :is-customer="true"/>

                        <div class="w-100" v-if="!estimates">
                            <div
                                class="block-grey border-darkBlue position-relative align-items-center pt-3 pl-3 pr-3">
                                <div class="position-absolute w-100 pr-5"
                                     style="top: -20px; text-align: center; margin-left: -1.5rem !important;">
                                    <img src="/icons/logo.png" alt="">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Ожидайте когда Исполнитель сформирует (создаст) смету и пришлет счет на
                                            оплату услуг</p>
                                    </div>
                                    <div class="col-4">
                                        <p>Если вас не устраивают условия сделки, вы можете отказаться от нее</p>
                                    </div>
                                    <div class="col-2">
                                        <p><a href="#" style="color: red">Отказаться от сделки</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="block-days-ago">
                                <p class="text-muted">1 день назад</p>
                            </div>
                        </div>
                    </div>
                    <div class="block-application-deal__executor" v-if="showTenderExecutor">
                        <div class="row mb-3">
                            <div class="col-9">
                                <div class="block-grey pl-3 pr-3 pt-1">
                                    <p class="mb-0">Предлагаю вам заключить сделку на выполнение задания по прямой
                                        заявке №{{ myDeal.direct.id }} (сообщение сформировано автоматически).</p>
                                </div>
                                <div class="block-days-ago">
                                    <p class="text-muted">2 дня назад</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <h6>Заказчик</h6>
                                <div class="d-flex">
                                    <div class="img mr-1" style="width: 40px; height: 40px">
                                        <img class="w-100 h-100" src="" alt="">
                                    </div>
                                    <p><b>{{ myDeal.direct.customer_info.title }}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3" v-for="(estimate, index) in estimates">
                            <div class="row">
                                <div class="col-9">
                                    <div class="block-estimate border-black pl-3 pr-3">
                                        <div class="row">
                                            <div class="col-5">
                                                <b>Смета №{{ estimate.id }}</b>
                                            </div>
                                            <div class="col-3">
                                                <p>Смета на услуги</p>
                                            </div>
                                            <div class="col-3">
                                                <p>Счет на оплату услуг</p>
                                            </div>
                                        </div>
                                        <div class="row">

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <h6><b>Аренда спортивного объекта</b></h6>
                                                <div class="rent-object">
                                                    <h6>Стоимость аренды: {{ estimate.rentSportObject.price }}
                                                        руб/час</h6>
                                                    <h6>Даты пребывания: c
                                                        {{ getDate(estimate.rentSportObject.start_date) }} по
                                                        {{ getDate(estimate.rentSportObject.end_date) }}
                                                        {{ getYear(estimate.rentSportObject.end_date) }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-6" v-if="estimate.rentAccommodation.checkAccm">
                                                <h6><b>Размещение</b></h6>
                                                <div class="rent-accom">
                                                    <h6>Количество и стоимость проживания:</h6>

                                                    <div v-for="accm in estimate.rentAccommodation.accommodations"
                                                         v-if="accm.check">
                                                        <h6>{{ accm.title }}</h6>
                                                        <div v-if="accm.options" v-for="option in accm.options">
                                                            <h6>* {{ option.places['title'] }}: {{ option.price }}
                                                                руб/сутки</h6>
                                                        </div>
                                                    </div>
                                                    <h6>Даты размещения: c
                                                        {{ getDate(estimate.rentAccommodation.start_date) }} по
                                                        {{ getDate(estimate.rentAccommodation.end_date) }}
                                                        {{ getYear(estimate.rentAccommodation.end_date) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <h6><b>Питание</b></h6>
                                                <h6 v-if="estimate.rentAccommodation.titlePriceFood == 'Входит в стоимость'">
                                                    Включено в стоимость ({{ estimate.rentAccommodation.typeFood }})
                                                </h6>
                                                <h6 v-else>Не включено в стоимость
                                                    ({{ estimate.rentAccommodation.typeFood }})</h6>
                                            </div>
                                            <div class="col-6">
                                                <h6><b>Сумма к оплате</b></h6>
                                                <h6>Стоимость аренды:
                                                    <b>{{ estimate.rentSportObject.sum.toFixed(2) }}
                                                        руб </b><span class="days">за {{
                                                            getDays(estimate.rentSportObject.start_date, estimate.rentSportObject.end_date)
                                                        }} суток</span>
                                                </h6>
                                                <h6>Стоимость размещения:
                                                    <b>{{ estimate.rentAccommodation.sumAccm.toFixed(2) }}
                                                        руб </b><span
                                                        class="days">за {{
                                                            getDays(estimate.rentAccommodation.start_date, estimate.rentAccommodation.end_date)
                                                        }} суток</span>
                                                </h6>
                                                <h6>Стоимость питания:
                                                    <b>{{ estimate.rentAccommodation.sumPriceFood }}
                                                        руб </b> <span class="days">за {{
                                                            getDays(estimate.rentAccommodation.start_date, estimate.rentAccommodation.end_date)
                                                        }} суток</span>
                                                </h6>
                                                <h6>Стоимость дополнительных услуг:
                                                    <b>{{ estimate.rentAddition.totalPrice.toFixed(2) }}</b>
                                                </h6>
                                                <h6>Итого: <b>{{
                                                        (estimate.rentSportObject.sum + estimate.rentAccommodation.sumPriceFood + estimate.rentAccommodation.sumAccm
                                                            + estimate.rentAddition.totalPrice).toFixed(2)
                                                    }} руб</b></h6>
                                            </div>
                                        </div>
                                        <div class="row info-block">
                                            <p style="color: lightskyblue">Счет на оплату сформирован автоматически
                                                из сметы. При изменении сметы счет будет создан повторно.</p>
                                        </div>
                                        <div class="row pt-3 align-items-center"
                                             style="background-color: lightgray">
                                            <div class="col-6">
                                                <p style="color: dodgerblue">
                                                    Смета и счет на оплату получены от Исполнителя. Оплатите ее в
                                                    течении 3х дней.</p>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p style="color: dodgerblue">Осталось времени до конца срока
                                                            оплаты по счету</p>
                                                    </div>
                                                    <div class="col-6"
                                                         v-if="estimate.show_customer == 1 && index == estimates.length - 1">
                                                        <div>
                                                            <vue-countdown-timer
                                                                :start-time="estimate.date_send"
                                                                :end-time="momentDay(estimate.date_send)"
                                                                :interval="1000"
                                                                label-position="begin"
                                                                :end-text="'0 дня 00 часа'"
                                                                :day-txt="'дня'"
                                                                :hour-txt="'часа'">

                                                                <template slot="countdown" slot-scope="scope">
                                                                    <div
                                                                        class="active time p-2 align-items-center justify-content-center"
                                                                        style="background-color: #6FB77F">
                                                                        <span>{{ scope.props.days }}</span>
                                                                        {{
                                                                            getNoun(scope.props.dayTxt, ' день', ' дня', ' дней')
                                                                        }}
                                                                        <span>{{ scope.props.hours }}</span>
                                                                        {{
                                                                            getNoun(scope.props.hourTxt, ' час', ' часа', ' часов')
                                                                        }}
                                                                    </div>
                                                                </template>
                                                                <template slot="end-text" slot-scope="scope">
                                                                    <div
                                                                        class="active time p-2 align-items-center justify-content-center"
                                                                        style="background-color: rgb(243,122,138)">
                                                                        <span>{{ scope.props.endText }}</span>
                                                                    </div>
                                                                </template>
                                                            </vue-countdown-timer>
                                                        </div>
                                                    </div>
                                                    <div class="col-6" v-else>
                                                        <div
                                                            class="block-darkGrey p-1 d-flex justify-content-center">
                                                            <h6><b>0 дней 00 часов</b></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <p>Исполнитель</p>
                                    <div class="d-flex">
                                        <div class="img mr-1" style="width: 40px; height: 40px">
                                            <img class="w-100 h-100" src="" alt="">
                                        </div>
                                        <p><b>{{ myDeal.sportObject.created.title }}</b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="block-days-ago">
                                <p class="text-muted">{{ fromNow(estimate.deal_date_ago) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="[2,3].includes(myDeal.status)" class="block-payment-notif">
                    <div class="logo d-flex justify-content-center mb-3">
                        <img src="/icons/logo.png" alt="">
                    </div>
                    <div class="notif d-lg-flex d-none align-items-center p-3 justify-content-between bg-white badge">
                        <img class="mr-4" src="/icons/warning-red.svg" alt="">
                        <div class="w-100 d-flex">
                            <p class="mb-0">{{ myDeal.status == 2 ? 'Сделка отклонена Заказчиком' : '' }}
                                {{ myDeal.status == 3 ? 'Сделка отклонена Исполнителем' : '' }}</p>
                        </div>
                    </div>
                    <div class="notif d-lg-none align-items-center p-3 justify-content-between bg-white badge">
                        <div class="d-flex">
                            <div class="flex-grow-0 mr-3">
                                <img width="24px" src="/icons/warning-red.svg" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p style="color: #59728B" class="pb-4">
                                    {{ myDeal.status == 2 ? 'Сделка отклонена Заказчиком' : '' }}
                                    {{ myDeal.status == 3 ? 'Сделка отклонена Исполнителем' : '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="pb-4 d-block">
                        <p class="ago">Сегодня</p>
                    </div>
                </div>
            </div>

            <reject-deal v-show="showRejectDeal" :show-reject-deal="showRejectDeal" :id-deal="$props.id"
                         @visibleFalse="closeModalReject" :is-admin="true" :id-user="rejectDealUserId"
                         @updateDeal="getDealById({id: $props.id})"/>


            <div class="col-lg-4" v-if="false">
                <div class="border-black pl-3 pr-3 pt-3">
                    <h6><b>Состояние</b></h6>
                    <h6>Ожидает действий от (Исполнителя) (Заказчика)</h6>
                    <h6><b>Подробности</b></h6>
                    <h6 v-if="false">Тип объекта: </h6>
                    <h6>ID заявки: {{ myDeal.tender ? myDeal.tender.id : myDeal.direct.id }}</h6>
                    <h6>Тип заявки: {{ myDeal.tender ? "Тендерная заявка" : "Прямая заявка" }}</h6>
                    <h6 v-if="myDeal.tender">Даты пребывания: с {{ myDeal.tender.startDate }} по
                        {{ myDeal.tender.endDate }} {{ myDeal.tender.endDate_year }} {{ myDeal.tender.spreadDate }}</h6>
                    <h6 v-else-if="myDeal.direct">Даты пребывания: {с {{ myDeal.direct.startDate }} по
                        {{ myDeal.direct.endDate }}
                        {{ myDeal.direct.endDate_year }}
                        {{ myDeal.direct.spreadDate }}</h6>
                    <h6>Стоимость (общ.): </h6>
                    <h6><b>Заказчик</b></h6>
                    <h6>{{ myDeal.tender ? myDeal.tender.customer_info.title : myDeal.direct.customer_info.title }}</h6>

                    <h6><b>Исполнитель</b></h6>
                    <h6>{{
                            myDeal.responsesTender ? myDeal.responsesTender.company_info.title :
                                (myDeal.sportObject.created ? myDeal.sportObject.created.title : '')
                        }}</h6>

                    <h6 v-if="false"><b>Прогресс выполнения</b></h6>
                    <div v-if="false" class="progress_execution">
                        <h6>шаг 1 - создание сметы</h6>
                        <h6>шаг 1.1 - создание и отправка счета на оплату</h6>
                        <h6>шаг 1.2 - ожидание оплаты по счету</h6>
                        <h6>шаг 1.3 - время оплаты по счету истекло</h6>
                        <h6>шаг 1.4 - повторное создание и отправка счета</h6>
                        <h6>шаг 1.5 - ожидание оплаты по счету (повторно)</h6>
                        <h6>шаг 2 - получено подтверждение оплаты по счету</h6>
                        <h6>шаг 3 - время выполнения заказа истекло</h6>
                        <h6>шаг 5 - отзыв о сотрудничестве</h6>
                        <h6>шаг 6 - сделка завершена</h6>
                    </div>
                    <h6><b>Управление</b></h6>
                    <p @click="showRejectDeal = true"><a class="cap" href="#">
                        <i style="color:red;" class="fa fa-window-close mr-2">
                        </i>ОТКАЗАТЬСЯ</a>
                    </p>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
import moment from "moment";
import VueCountdownTimer from 'vuejs-countdown-timer';
import RejectDeal from "../components/deal/RejectDeal";
import Estimate from "../components/estimate/Estimate";
import CreateEstimate from "../components/payment/CreateEstimate";
import arbitr from "../adminPanel/Arbitration";
import TenderCustomerInfo from "./deals/TenderCustomerInfo";
import EstimatesBlock from "./deals/EstimatesBlock";
import AdminCustomDeal from "./deals/AdminCustomDeal";

Vue.use(VueCountdownTimer);


export default {
    components: {
        AdminCustomDeal, EstimatesBlock, TenderCustomerInfo, arbitr, CreateEstimate, Estimate, RejectDeal
    },
    props: ['id'],
    data: function () {
        return {
            showTenderCustomer: true, showTenderExecutor: false, showRejectDeal: false, rejections: [],
            createEstimate: false, editEstimate: false, editEstimate_id: null,
            visibleArbitr: false, rejectDealUserId: null, estimates: [], myDeal: {}
        }
    },
    computed: {
        user: function () {
            return window.user;
        },
    },
    methods: {
        ...mapActions(["fetchDeal_estimates"]),
        visibleEstimate(x) {
            this.createEstimate = x;
            this.editEstimate = x;
        },
        showEditEstimate(value) {
            this.editEstimate_id = value;
            this.editEstimate = true;
        },
        functStopTimer(value) {
            this.stopTimer = value;
        },
        visibleTenderExecutor() {
            this.showTenderCustomer = false;
            this.showTenderExecutor = true;
            this.visibleArbitr = false;
        },
        visibleTenderCustomer() {
            this.showTenderExecutor = false;
            this.showTenderCustomer = true;
            this.visibleArbitr = false;
        },
        visibleArbitrazh() {
            this.showTenderExecutor = false;
            this.showTenderCustomer = false;
            this.visibleArbitr = true;
        },
        fromNow(deal_date) {
            const fromNow = moment(deal_date);
            return fromNow.fromNow();
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
            return end_date.diff(start_date, 'days');
        },
        momentDay(date) {
            var __startTime = moment(moment(new Date())).format();
            var __endTime = moment(moment(date).add(3, 'days')).format();
            var __duration = moment.duration(moment(__endTime).diff(__startTime));
            var __hours = __duration.asHours();
            var __days = __duration.asDays();
            this.showPaymentExpired = __days < 0 && __hours < 0;
            return moment(date).add(3, 'days')
        },
        getNoun(number, one, two, five) {
            let n = Math.abs(number);
            n %= 100;
            if (n >= 5 && n <= 20) {
                return five;
            }
            n %= 10;
            if (n === 1) {
                return one;
            }
            if (n >= 2 && n <= 4) {
                return two;
            }
            return five;
        },
        showCreateEstimate(date) {
            return this.momentDay(date) < moment();
        },
        getShowReject(user_role) {
            this.showRejectDeal = true;
            this.rejectDealUserId = user_role;
        },
        closeModalReject() {
            this.showRejectDeal = false;
        },
        getDealById(deal_id) {
            this.$store.dispatch('getDeal', {id: deal_id}).then((res) => {
                this.myDeal = res;
                this.estimates = res.estimates;
            });
        }
    },
    async mounted() {
        await this.getDealById(this.$props.id);
    }
}
</script>

<style scoped>
p {
    font-size: 12px;
}

h6 {
    font-size: 12px;
}
</style>

<style>

.block-grey {
    border-radius: 5px;
    background-color: lightgray;
}

.block-darkGrey {
    background-color: darkgray;
}

.border-darkBlue {
    border: 1px solid blue;
}

.cap {
    font-size: 16px;
}

.border-black {
    background-color: white;
    border: 1px solid black;
}
</style>
