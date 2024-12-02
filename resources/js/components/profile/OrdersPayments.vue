<template>
    <div>
        <notification-block v-if="notificationEstimate" :is-mobile="isMobile"
                            @dismiss="dismissOrdersNotification"/>

        <div class="d-lg-flex d-none container block-info block-background-white p-4 d-flex shadow mt-4 mb-4
                    justify-content-between">
            <div class="block-notify-payments d-flex align-items-center">
                <div class="earnings-block d-flex mr-4">
                    <p class="m-2">Заработано (Всего)</p>
                    <div class="background-block-blue p-2 d-flex align-items-center">
                        <span>{{ sumPaymentEstimates }} руб</span>
                    </div>
                </div>
                <div class="paid-block d-flex mr-4">
                    <p class="m-2">Выплачено</p>
                    <div class="border-block-grey p-2 d-flex align-items-center">
                        <span>{{ sumPaymentEstimates }} руб</span>
                    </div>
                </div>
                <div class="remains-block d-flex">
                    <p class="m-2">Осталось к выплате</p>
                    <div class="border-block-grey p-2 d-flex align-items-center">
                        <span>{{ sumWaitingPayment }} руб</span>
                    </div>
                </div>
            </div>
            <button class="button-green-paid pr-3 pl-3">Запросить выплату</button>
        </div>
        <div class="ml-4 mr-4">
            <div class="d-lg-none d-block container block-info block-background-white p-4 d-flex shadow mt-4 mb-4"
                 style="border: 1px solid #BAC4DF">
                <div class="row justify-content-center">
                    <div class="earnings-block col-7 text-center">
                        <p class="m-2">Заработано (Всего)</p>
                        <div class="align-items-center background-block-blue d-flex p-2">
                            <span>{{ sumPaymentEstimates }} руб</span>
                        </div>
                    </div>
                    <div class="paid-block col-7 text-center">
                        <p class="m-2">Выплачено</p>
                        <div class="border-block-grey p-2 d-flex align-items-center">
                            <span>{{ sumPaymentEstimates }} руб</span>
                        </div>
                    </div>
                    <div class="remains-block col-7 text-center">
                        <p class="m-2">Осталось к выплате</p>
                        <div class="border-block-grey p-2  d-flex align-items-center">
                            <span>{{ sumWaitingPayment }} руб</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="button-green-paid m-2 p-2 pl-3 pr-3 w-100">Запросить выплату</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container p-0">
            <div class="block-table">
                <table class="table pb-2">
                    <tbody>
                    <tr class="head-table">
                        <th width="20%">№ сметы</th>
                        <th>Дата создания</th>
                        <th>№ заказа</th>
                        <th>Дата оплаты</th>
                        <th>Сумма (итого)</th>
                        <th>Выплата (вам)</th>
                    </tr>
                    <tr class="body-table" v-for="estimate in estimates">
                        <td>{{ estimate.id }}</td>
                        <td>{{ estimate.created_at }}</td>
                        <td>{{ estimate.deal_id }}</td>
                        <td>{{ estimate.payment_at ? estimate.payment_at : '' }}</td>
                        <td>{{ estimate.sum }} руб.</td>
                        <td>
                            <template v-if="paymentStatus = paymentsStatus.find(p => p.id === estimate.status)">
                                <span :style="'color:' + paymentStatus.color">{{ paymentStatus.title }}</span>
                            </template>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import NotificationBlock from "../ordersAndPayments/NotificationBlock";

export default {
    name: "OrdersPayments",
    components: {NotificationBlock},
    data() {
        return {
            notificationEstimate: true,
            sumPaymentEstimates: 0,
            sumWaitingPayment: 0
        }
    },
    computed: {
        ...mapGetters({estimates: 'estimates_payment'}),
        isMobile() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent);
        },
        user: function () {
            return window.user;
        },
        paymentsStatus() {
            return [
                {id: 1, title: 'Уведомить об оплате', color: '#6283E5'},
                {id: 2, title: 'На модерации', color: '#0B3158'},
                {id: 5, title: 'Выплачена', color: '#6FB77F'},
                {id: 3, title: 'Ожидает оплаты', color: '#6283E5'},
            ]
        },
    },
    methods: {
        dismissOrdersNotification() {
            this.hideOrdersNotification();
        },
        hideOrdersNotification() {
            this.notificationEstimate = false;
        },
        getSumPayments(){
            axios.get("/api/payments/statistic").then((response) => {
                let data = response.data;

                this.sumPaymentEstimates = data.sumPaymentEstimates;
                this.sumWaitingPayment = data.sumWaitingEstimates;
            })
        }
    },
    mounted() {
        this.getSumPayments();
    }

}
</script>

<style scoped>
table {
    border-collapse: separate;
    width: 100%;
    border-spacing: 3px 5px;
}

.head-table > th {
    background-color: #6283E5 !important;
    color: white;
    padding: 10px !important;
    border-radius: 5px;
    font-size: calc(1.06rem);
}

.body-table > td {
    background-color: white !important;
    padding: 10px !important;
    border-radius: 5px;
    border: none;
    color: #0B3158;
    font-size: calc(1.06rem);
}

.block-background-white {
    background-color: white;
    border-radius: 10px;
}

.background-block-blue {
    border-radius: 10px;
    background-color: #6283E5;
    color: white;
}

.border-block-grey {
    border-radius: 10px;
    border: 1px solid #BAC4DF;
    color: #0B3158;
}

.button-green-paid {
    background-color: #56C46F;
    border-radius: 10px;
    color: white;
}

@media (max-width: 960px) {
    .block-table {
        overflow: auto;
        margin-bottom: 1rem;
        margin-left: 1.3rem;
    }

    .head-table th {
        min-width: 150px;
    }

    .body-table td {
        white-space: nowrap;
        padding-right: 50px !important;
    }
}

</style>
