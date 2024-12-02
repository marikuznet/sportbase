<template>
    <div class="transaction_management container p-0">
        <div class="logo d-flex justify-content-center mb-3">
            <img src="/icons/logo.png" alt="logo">
        </div>
        <div v-if="!dateExpired" class="ticking_time">
            <div class="notif d-flex align-items-center p-3 justify-content-between w-100">
                <div class="d-flex w-100">
                    <img class="mr-4" src="/icons/settingsGreen.svg" alt="">
                    <div class="notif__order w-100">
                        <div class="mr-3 order">Управление заказом</div>
                        <div class="order__management w-100 d-flex align-items-center">
                            <p class="mr-5">Заказ выполняется. До завершения осталось:</p>
                            <div class="countdown p-2 d-flex align-items-center justify-content-center">
                                <vue-countdown-timer
                                    :start-time="date_payment"
                                    :end-time="fullDateStop"
                                    :interval="1000"
                                    label-position="begin"
                                    :end-text="'0 дней 00 часов'"
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
                                        <div class="active time p-2 align-items-center justify-content-center"
                                             style="background-color: rgb(243,122,138)">
                                            <span>{{ scope.props.endText }}</span>
                                        </div>
                                    </template>
                                </vue-countdown-timer>
                            </div>
                        </div>
                        <div class="btn_arbitration">
                            <button @click="connectArbitr" class="btn-base button-icon w-auto"
                                    style="border-radius: 5px">
                                Обратиться в арбитраж
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="time_is_up" v-if="dateExpired">
            <div class="notif d-flex p-3 justify-content-between">
                <img class="mr-4" src="/icons/settingsGreen.svg" alt="">
                <div class="align-items-center d-flex notif__text">
                    <div class="mr-3 order">Управление заказом</div>
                    <div class="w-100">
                        <p>Время выполнения заказа истекло <b>{{ dateStop }} в {{ timeStop }}.</b></p>
                        <template v-if="user.role == 2">
                            <p>Для подтверждения выполения заказа вам нужно нажать на кнопку "Подтверждаю
                                выполнение".</p>
                        </template>
                        <template v-else-if="user.role == 3">
                            <p>Ожидайте подтверждения выполнения заказа от Заказчика.</p>
                        </template>
                        <p>Если
                            <template v-if="user.role == 3">Заказчик не подтвердит выполнение заказа</template>
                            <template v-if="user.role == 2">вы не подтвердите завершение через кнопку</template>
                            - он будет подтвержден автоматически
                            <b>{{ confirmDate }} в {{ confirmTime }}</b></p>
                    </div>
                    <div class="notif__buttons">
                        <div class="btn_arbitration mb-2" v-if="user.role == 2">
                            <button class="btn-base button-icon button-green"
                                    :style="{'width': user.role == 3 ? '100%' : '255px', 'border-radius': '5px'}"
                                    @click="confirmDeal">
                                Подтверждаю выполнение
                            </button>
                        </div>
                        <div class="btn_arbitration">
                            <button class="btn-base button-icon"
                                    :style="{'width': user.role == 3 ? '100%' : '255px', 'border-radius': '5px'}"
                                    @click="connectArbitr">
                                Обратиться в арбитраж
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="false" class="time_is_up" v-else-if="dateExpired">
            <div class="notif d-flex p-3 justify-content-between" v-if="user.role == 2">
                <img class="mr-4" src="/icons/settingsGreen.svg" alt="">
                <div class="align-items-center d-flex notif__text">
                    <div class="mr-3 order">Управление заказом</div>
                    <div class="w-100">
                        <p>Время выполнения заказа истекло <b>{{ dateStop }} в {{ timeStop }}.</b></p>
                        <p>Ожидайте подтверждения выполнения заказа от Заказчика.</p>
                        <p>Или выполение будет подтверждено автоматически <b>{{ confirmDate }} в {{ confirmTime }}</b>
                        </p>
                    </div>
                    <div class="notif__buttons">
                        <div class="btn_arbitration mb-2">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon button-green"
                                    @click="confirmDeal">
                                Подтверждаю выполнение
                            </button>
                        </div>
                        <div class="btn_arbitration">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon"
                                    @click="connectArbitr">
                                Обратиться в арбитраж
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="notif d-flex p-3 justify-content-between" v-if="user.role == 3">
                <img class="mr-4" src="/icons/settingsGreen.svg" alt="">
                <div class="align-items-center d-flex notif__text">
                    <div class="mr-3 order">Управление заказом</div>
                    <div class="w-100">
                        <p>Время выполнения заказа истекло <b>{{ dateStop }} в {{ timeStop }}.</b></p>
                        <p>Ожидайте подтверждения выполнения заказа от Заказчика.</p>
                        <p>Или выполение будет подтверждено автоматически <b>{{ confirmDate }} в {{ confirmTime }}</b>
                        </p>
                    </div>
                    <div class="notif__buttons">
                        <div class="btn_arbitration">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon"
                                    @click="connectArbitr">
                                Обратиться в арбитраж
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueCountdownTimer from 'vuejs-countdown-timer';
import moment from "moment";
import Vue from "vue";
import {mapActions} from "vuex";

Vue.use(VueCountdownTimer);
export default {
    props: {
        get_datePayment: [Boolean, String, Date],
        get_dealId: Number,
        tenderId: {
            type: Number,
            default: null
        },
        directId: {
            type: Number,
            default: null
        },
        completedAt: {
            type: [String, Date],
            default: null
        },
        confirmedAt: {
            type: [String, Date],
            default: null
        }
    },
    data() {
        return {
            date_payment: this.get_datePayment, showPaymentExpired: false, dateStop: null, timeStop: null,
            confirmDate: null, confirmTime: null, fullDateStop: null,
        }
    },
    computed: {
        user: function () {
            return window.user;
        },
        dateExpired() {
            if (this.fullDateStop) {
                return moment(moment(this.fullDateStop).format()).isBefore(moment(new Date()).format());
            }
            else return null;
        }
    },
    methods: {
        ...mapActions(["connectArbitration"]),
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
        connectArbitr() {
            this.$store.dispatch("connectArbitration", {id: this.get_dealId, role: this.user.role})
                .then(response => {
                    this.$store.dispatch("getDeal", {id: this.get_dealId});
                });
        },
        async confirmDeal() {
            if (this.$props.tenderId) {
                await this.$store.dispatch("dealDone", {
                    id: this.$props.get_dealId,
                    tender_id: this.$props.tenderId
                }).then(() => {
                    this.$store.dispatch("getDeal", {id: this.$props.get_dealId});
                });
            }
            if (this.$props.directId) {
                await this.$store.dispatch("dealDone", {
                    id: this.$props.get_dealId,
                    direct_id: this.$props.directId
                }).then(() => {
                    this.$store.dispatch("getDeal", {id: this.$props.get_dealId});
                });
            }
        },
        getCountdownStyle() {
            return {backgroundColor: '#6FB77F'};
        },
        getEndCountdownStyle() {
            return {backgroundColor: 'rgb(243,122,138)'};
        }
    },
    mounted() {
        const __startTime = moment(new Date()).format();
        const __endTime = moment(this.completedAt);

        const __duration = moment.duration(moment(__endTime).diff(__startTime));
        const __hours = __duration.asHours();
        const __days = __duration.asDays();

        this.showPaymentExpired = __days < 0 && __hours < 0;
        this.fullDateStop = __endTime;

        this.dateStop = moment(this.completedAt).format('LL');
        this.timeStop = moment(this.completedAt).format('LT');

        this.confirmDate = moment(this.confirmedAt).format('LL');
        this.confirmTime = moment(this.confirmedAt).format('LT');

    },
    name: "TransactionManagement",
    components: {moment},
}
</script>

<style scoped>
.countdown {
    border-radius: 5px;
    width: auto;
    background-color: #6FB77F;
    color: white;
    font-size: 22px;
    max-height: 49px;
}

.btn_arbitration .button-green {
    background-color: rgb(111, 183, 127) !important;
    color: white !important;
    border: none !important;
}

.notif__order {
    display: flex;
}

.notif__order .btn_arbitration button {
    width: max-content !important;
}

@media (max-width: 960px) {
    .notif__order {
        display: block;
    }

    .order__management {
        flex-wrap: wrap;
    }

    .countdown {
        font-size: 15px;
        height: 35px;
        margin-bottom: 20px !important;
    }

    .notif__order .btn_arbitration button {
        width: auto !important;
    }
}
</style>
