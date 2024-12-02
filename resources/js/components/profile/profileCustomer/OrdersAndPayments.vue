<template>
    <div class="sb-orders-and-payments">
        <div class="align-items-center d-flex justify-content-center loading position-fixed" v-if="loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <menu-component-customer v-if="user.role === 2" active="5"></menu-component-customer>
        <menu-component-executor v-if="user.role === 3" active="5"></menu-component-executor>
        <main class="proposal-card" style="min-height: 600px">
            <modal-notification v-if="selectedEstimate" id="sb-notification-confirm-payment"
                                ref="sb-notification-confirm-payment"
                                modal_class="sb-notification-confirm-payment" title="Подтверждение оплаты">
                <template #body>
                    <p class="fs-5 mb-2">Вы подтвержаете оплату счета №{{ selectedEstimate.id }} на сумму
                        {{ selectedEstimate.sum }} руб.</p>
                    <p class="fs-5">Для ускорения подтверждения оплаты прикрепите документ подтверждающий оплату
                        (выписка, фото, скан).</p>

                    <div class="btn_arbitration upload-btn">
                        <input type="file" ref="file" class="d-none" id="vue-file-upload-input"
                               @change="addImage">
                        <button v-if="currentImage == null" class="btn-base button-icon border-blue"
                                @click="addDocument">
                            Загрузить файл
                            <img class="ml-3" src="/icons/Solid.svg" alt="">
                        </button>
                        <p v-else-if="currentImage != null">Файл загружен</p>
                    </div>
                </template>
                <template #footer>
                    <div class="d-flex justify-content-center">
                        <button @click="confirmEstimate(selectedEstimate.deal_id, selectedEstimate.id)" type="button"
                                class="btn btn-primary mb-3">Уведомить об оплате
                        </button>
                    </div>
                </template>
            </modal-notification>

            <div class="container ctnPad pl-0">
                <div class="pt-3">
                    <h3 class="caption">Заказы и оплаты</h3>
                </div>
            </div>
            <filters :filter-btn="filterBtn" @updateData="fetchOrders" @handleUpdate="fetchOrders"
                     @update-filter="filter = $event" active-status="orders"/>

            <div v-if="ordersData.status.toString() === 'orders'">
                <notification-block v-if="isNotificationOrders" :is-mobile="isMobile"
                                    @dismiss="dismissOrdersNotification"/>

                <all-orders :orders="orders" :archive-orders="archive_orders"/>
            </div>

            <div v-if="ordersData.status.toString() === 'estimates'">
                <notification-block v-if="isNotificationEstimate" :is-mobile="isMobile"
                                    @dismiss="dismissOrdersNotification"/>

                <div class="container p-0">
                    <div class="block-table">
                        <table class="table pb-2">
                            <tbody>
                            <tr class="head-table">
                                <th width="20%">№ сметы</th>
                                <th>Дата создания</th>
                                <th>№ заказа</th>
                                <th>Сумма (итого)</th>
                                <th>Статус</th>
                                <th>Детали</th>
                            </tr>
                            <tr class="body-table" v-for="estimate in estimatesData">
                                <td>{{ estimate.id }}</td>
                                <td>{{ estimate.created_at ? estimate.created_at : '' }}</td>
                                <td>{{ estimate.deal_id }}</td>
                                <td>{{ estimate.sum }} руб.</td>
                                <td class="text-center">
                                    <template v-if="paymentStatus = paymentsStatus.find(p => p.id === estimate.status)">
                                        <template v-if="estimate.is_overdue && ![2,3,5].includes(estimate.status)">
                                            <span :style="'color:#E45868'">
                                                Просрочена
                                            </span>
                                        </template>
                                        <template v-else-if="paymentStatus.title === 'Уведомить об оплате'">
                                            <!--@click="confirmEstimate(estimate.deal_id, estimate.id)"!-->
                                            <a v-if="user.role === 2" href="#"
                                               @click.prevent="selectedEstimate = estimate"
                                               data-toggle="modal" data-target="#sb-notification-confirm-payment">
                                                Уведомить об оплате
                                            </a>
                                            <span v-if="user.role === 3" :style="'color:' + paymentStatus.color">Ожидает оплаты</span>
                                        </template>
                                        <span v-else :style="'color:' + paymentStatus.color">
                                                {{ paymentStatus.title }}
                                            </span>
                                    </template>
                                </td>
                                <td>
                                    <img @click="openInvoice(estimate)" class="mr-2 cursor-pointer"
                                         src="/icons/pdf-file.svg" alt="">
                                    <img @click="openPayment(estimate)" class="cursor-pointer" width="30px"
                                         src="/icons/information.svg" alt="">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <paginator :pagination="estimates_pagination" @changePages="fetchOrders" @handleUpdate="fetchOrders"
                               @changePerPage="changePerPage"/>
                </div>
            </div>

            <orders-payments v-if="ordersData.status.toString() === 'payments'"></orders-payments>
            <paginator v-if="ordersData.status === 'payments'" :pagination="estimates_pagination" :status="'payments'"
                       @changePages="fetchOrders" @handleUpdate="fetchOrders" @changePerPage="changePerPage"/>
        </main>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from '../../NavBar'
import extendedinf from "../../ExtendedFooterInformation";
import VSelect from "@alfsnd/vue-bootstrap-select";
import MenuComponentExecutor from "../menuComponent";
import MenuComponentCustomer from "./menuComponent";
import {mapGetters, mapActions} from 'vuex';
import OrdersPayments from "../OrdersPayments";
import Paginator from "../../Paginator";
import Filters from "../../Filters";
import NotificationBlock from "../../ordersAndPayments/NotificationBlock";
import AllOrders from "../../ordersAndPayments/AllOrders";
import ModalNotification from "../../elements/Modal";
import axios from "axios";

export default {
    data: function () {
        return {
            isNotificationEstimate: true, isNotificationOrders: true,
            filter: {
                minPrice: null, maxPrice: null, start_date: null, end_date: null, objects: [], foods: [],
                services: [], infrastructures: [], accred: [], search: null
            },
            statusDeal: [{step: 2, title: 'В процессе выполнения (шаг 2)', color: '#56C46F'},
                {step: 3, title: 'В процессе выполнения (шаг 3)', color: '#56C46F'},
                {step: 4, title: 'Завершена', color: '#56C46F'},
                {step: 5, title: 'Завершена', color: '#56C46F'},
                //{step: 4, title: 'В процессе выполнения (шаг 4)', color: '#56C46F'},
                //{step: 5, title: 'В процессе выполнения (шаг 5)', color: '#56C46F'},
                {step: 6, title: 'На арбитраже (со стороны Заказчика)', color: '#e45868'},
                {step: 7, title: 'На арбитраже (со стороны Исполнителя)', color: '#e45868'}
            ],
            filterBtn: [{title: 'Заказы', isActive: true, stats: this.ordersCount ?? 0, status: 'orders'},
                {title: 'Сметы', isActive: false, stats: this.estimatesCount ?? 0, status: 'estimates'},
                {title: 'Выплаты', isActive: false, stats: this.paymentsCount ?? 0, status: 'payments'}],
            ordersData: {status: 'orders', perPage: 10, currentPage: 1}, loading: false,
            payments_data: {currentPage: 1, perPage: 10, pagination: {}}, archive_orders: [],
            estimatesData: [], selectedEstimate: null, currentImage: null
        }
    },
    computed: {
        ...mapGetters({
            orders: 'orders', orders_loading: 'orders_loading', orders_pagination: 'orders_pagination',
            ordersCount: 'activeOrdersCount', paymentsCount: 'paymentsCount', estimatesCount: 'estimatesCount',
            estimates: 'estimates', estimates_pagination: 'estimates_pagination',
        }),
        user: function () {
            return window.user;
        },
        paymentsStatus() {
            if (this.user.role === 2) {
                return [
                    {id: 3, title: 'Оплата получена', color: '#6283E5'},
                    {id: 5, title: 'Оплачен', color: '#6FB77F'},
                    {id: 1, title: 'Уведомить об оплате', color: '#0B3158'},
                    {id: 2, title: 'На подтверждении', color: '#6283E5'},
                    {id: 11, title: 'Просрочен', color: '#E45868'},
                ]
            } else {
                return [
                    {id: 3, title: 'Оплачен', color: '#6FB77F'},
                    {id: 5, title: 'Оплачен', color: '#6FB77F'},
                    {id: 1, title: 'Ожидает оплаты', color: '#0B3158'},
                    {id: 2, title: 'На подтверждении', color: '#6283E5'},
                    {id: 11, title: 'Просрочен', color: '#E45868'}
                ]
            }
        },
        isMobile() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent);
        }
    },
    methods: {
        openInvoice(estimate) {
            window.open(`/storage/listings/estimate/${estimate.deal_id}/${estimate.id}`, '_blank');
        },
        openPayment(estimate) {
            window.open(`/storage/listings/payment-invoice/${estimate.deal_id}/${estimate.id}`, '_blank');
        },
        resetFilter() {
            this.clearFilter();
        },
        changePerPage(pages) {
            this.updatePerPage(pages);
        },
        async fetchOrders(status = this.ordersData.status, limit = this.ordersData.perPage, page = this.ordersData.currentPage, filter = this.filter) {
            if (typeof status !== 'number') {
                this.ordersData.status = status;
            }

            this.loading = true;
            await Promise.all([
                this.fetchOrdersByStatus(status, filter, limit, page),
                this.fetchStatisticOrders()
            ]);
            this.updateFilterBtnStats();
            this.loading = false;
        },
        async confirmEstimate(dealId, estimateId) {
           await this.confirmEstimateById(estimateId);
            if (this.currentImage != null) {
                await this.uploadImage(dealId, estimateId);
            }
            $('#sb-notification-confirm-payment').modal('hide');
            await this.fetchOrders()
        },
        dismissOrdersNotification() {
            this.hideOrdersNotification();
        },

        clearFilter() {
            this.filter = {
                dateStart: null,
                dateEnd: null,
                minPrice: null,
                maxPrice: null,
                object: [],
                foods: [],
                search: '',
                services: [],
                infrastructures: [],
                accred: []
            };
        },
        updatePerPage(pages) {
            this.ordersData.perPage = pages;
            this.fetchOrders();
        },
        async fetchOrdersByStatus(status, filter, limit, page) {
            if (status.toString() === 'orders') {
                await Promise.all([
                    this.$store.dispatch('fetchActiveOrders', {status, filter}),
                    this.$store.dispatch('fetchFinishedOrders', {status, filter}).then(result => {
                        this.archive_orders = result;
                    })
                ]);
            } else if (status.toString() === 'estimates' || status.toString() === 'payments') {
                await this.$store.dispatch('getEstimates', {status, limit, page, filter}).then((result) => {
                    this.estimatesData = result.data.data;
                });
            } else {
                await this.$store.dispatch('getEstimates', {
                    status: "payments",
                    limit: this.ordersData.perPage,
                    page: status,
                    filter: this.filter
                }).then((result) => {
                    this.estimatesData = result.data.data;
                });
            }
        },
        async fetchStatisticOrders() {
            await this.$store.dispatch('getStatisticOrders');
        },
        updateFilterBtnStats() {
            this.filterBtn[0].stats = this.ordersCount;
            this.filterBtn[1].stats = this.estimatesCount;
            if (this.filterBtn[2]) this.filterBtn[2].stats = this.paymentsCount;
        },
        async confirmEstimateById(estimateId) {
            await this.$store.dispatch('estimateConfirmation', {id: estimateId});
        },
        hideOrdersNotification() {
            this.isNotificationOrders = false;
        },
        hidePaymentsFilterForCustomer() {
            if (this.user.role === 2) {
                const index = this.filterBtn.findIndex(item => item.title === 'Выплаты');
                if (index !== -1) {
                    this.filterBtn.splice(index, 1);
                }
            }
        },
        addDocument() {
            document.getElementById("vue-file-upload-input").click();
        },
        addImage(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.currentImage = this.$refs.file.files.item(0);
        },
        async uploadImage(deal_id, estimate_id) {
            let formData = new FormData();
            formData.append("file", this.currentImage);
            try {
                await axios.post(`/transaction/estimate/uploadPayment/${deal_id}/${estimate_id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.currentImage = null;
            } catch (error) {
                console.error('Error uploading image:', error);
            }
        },
    },
    mounted() {
        this.hidePaymentsFilterForCustomer();
    },
    created() {
        this.fetchOrders();
    },

    components: {
        AllOrders, NotificationBlock, ModalNotification,
        Filters, Paginator, OrdersPayments, navbar, extendedinf, VSelect, MenuComponentCustomer, MenuComponentExecutor
    },
}
</script>

<style>
@media (max-width: 568px) {
    .notification-orange, .notification-green, .notification-red {
        width: 100% !important;
    }
}
</style>

<style scoped>
.caption {
    color: #0B3158;
}

.button {
    height: 45px;
    width: 150px;
    border-radius: 5px;
}

.filter-menu-row-mobile .button {
    height: 45px;
    width: 45px;
    border-radius: 10px;
}

.countActive {
    background-color: white;
    color: #2D297D;
    border-radius: 4px;
    padding-left: 8px;
    padding-right: 8px;
    margin-left: 5px;
}

#search-object {
    height: 45px;
    /*min-width: 650px;*/
    border-radius: 5px;
}

#search-object-mobile {
    height: 45px;
    border-radius: 10px;
}

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

.blockPages {
    justify-content: space-between;
}

@media (max-width: 960px) {
    .mobile.block-info {
        margin-left: 1.5rem;
        margin-right: 1.5rem;
        width: auto;
    }

    .active-order {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }

    .active-order .caption {
        font-size: calc(1.375rem);
    }

    .arrow-button {
        width: 42px;
        height: 42px;
    }

    .request-object {
        margin-left: 1.5rem !important;
        margin-right: 1.5rem !important;
        padding: 0 !important;
        width: auto;
    }

    .request-object .order {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
        padding-top: 1rem !important;
    }

    .request-object .numOrder {
        display: block !important;
    }

    .logo-company {
        width: 30px;
        margin-right: 1rem;
    }

    .titleObject .captionObject {
        font-size: calc(0.93rem);
    }

    .titleObject .captionObject .objectId {
        padding-top: 1rem !important;
        font-size: calc(0.875rem);
    }

    .logo {
        padding-top: 1rem !important;
    }

    .caption {
        font-size: calc(0.875rem);
        font-weight: bold;
    }

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

    .blockPages {
        justify-content: center !important;
    }
}

</style>
