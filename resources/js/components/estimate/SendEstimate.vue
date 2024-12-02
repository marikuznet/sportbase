<template>
    <section
        v-if="estimate.show_customer == 0 || estimate.show_customer == null || (estimate.show_customer == 1 && estimate.status < 3)">
        <div class="time_to_end-estimate d-flex align-items-center pt-3 pb-3">
            <div class="d-flex align-items-center" v-if="estimate.show_customer == 0 || estimate.show_customer == null">
                <div class="details d-flex pr-4 pl-4 position-relative w-100">
                    <div class="estimate shadow d-flex p-3 align-items-center w-50 mr-3">
                        <p>После нажатия на кнопку смета и счет будут отправлена заказчику</p>
                        <button type="button" @click="sendEstimate(estimate)" class="ml-5">
                            Отправить
                        </button>
                    </div>
                    <div class="cancel shadow d-flex p-3 align-items-center w-50">
                        <p>Если вас <span style="color: #E45868">не устраивают условия</span>, отклоните
                            предложение</p>
                        <button type="button" @click="$emit('getShowReject')" class="button-icon ml-5">
                            Отклонить
                        </button>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center" v-if="estimate.show_customer == 1 && estimate.status < 3">
                <div class="text w-50 mr-3 ml-4">
                    <p>
                        {{ user.role == 3 ? 'Смета и счет отправлены заказчику. Ожидайте уведомления об оплате.' : '' }}
                        {{
                            user.role == 2 ? 'Смета и счет на оплату получены от Исполнителя. Оплатите ее в течении 3х дней.' : ''
                        }}
                    </p>
                </div>
                <div class="end-time shadow d-flex w-50 p-4 mr-4">
                    <p>Осталось времени до конца срока оплаты счета</p>
                    <div class="countdown p-2 d-flex align-items-center justify-content-center">
                        <vue-countdown-timer
                            :start-time="estimate.date_send"
                            :end-time="momentDay(estimate.date_send)"
                            :interval="1000"
                            label-position="begin"
                            :end-text="'0 дня 00 часа'"
                            :day-txt="'дня'"
                            :hour-txt="'часа'">
                            <template slot="countdown" slot-scope="scope">
                                <div class="active time p-2 align-items-center justify-content-center"
                                     style="background-color: #6FB77F">
                                    <span>{{ scope.props.days }}</span>
                                    {{ getNoun(scope.props.days, ' день', ' дня', ' дней') }}
                                    <span>{{ scope.props.hours }}</span>
                                    {{ getNoun(scope.props.hours, ' час', ' часа', ' часов') }}
                                </div>
                            </template>
                            <template slot="end-text" slot-scope="scope">
                                {{estimate.status}}
                                <div class="active time p-2 align-items-center justify-content-center"
                                     :class="{'text-red': estimate.status === 1 || estimate.status === 0}">
                                    <span>{{ scope.props.endText }}</span>
                                </div>
                            </template>
                        </vue-countdown-timer>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import moment from 'moment';
import {mapActions} from "vuex";
import RejectDeal from "../deal/RejectDeal";
import VueCountdownTimer from 'vuejs-countdown-timer';
import Vue from "vue";

Vue.use(VueCountdownTimer);

export default {
    props: ['prop_estimate', 'idDeal'],
    name: "SendEstimate",
    data() {
        return {
            rejections: [], isShowPaymentExpired: false, payment_overdue_date: null,
        }
    },
    components: {
        RejectDeal, moment
    },
    computed: {
        estimate() {
            return this.$props.prop_estimate;
        },
        user: function () {
            return window.user;
        },
    },
    methods: {
        ...mapActions(["showEstimateCustomer", "acceptConditions"]),
        momentDay(date) {
            var __startTime = moment(moment(new Date())).format();
            var __endTime = moment(moment(date).add(3, 'days')).format();
            var __duration = moment.duration(moment(__endTime).diff(__startTime));
            var __hours = __duration.asHours();
            var __days = __duration.asDays();

            this.isShowPaymentExpired = __days < 0 && __hours < 0;
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
        sendEstimate(estimate) {
            this.payment_overdue_date = moment(this.estimate.date_send).add(3, 'days');
            this.showEstimateCustomer({id: estimate.id, payment_overdue_date: this.payment_overdue_date});
            this.acceptConditions({id: this.$props.idDeal, user_role: this.user.role});
            this.$store.dispatch("getDeal", {id: this.$props.idDeal});
        }
    },
    mounted() {
        this.$emit('stopTimer', this.isShowPaymentExpired);
    }
}
</script>

<style>
.text-red {
    background-color: rgb(243, 122, 138)
}
</style>
