<template>
    <div class="m-auto mfs-3 mfs-r-3">
        <div class="sb-loading align-items-center d-flex justify-content-center loading position-fixed"
             v-if="loading">
            <div class="spinner-border text-info" role="status"/>
        </div>
        <div class="row justify-content-between px-3 p-1rem ml-3">
            <div class="justify-content-left">
                <p style="margin-top:10px;margin-bottom:10px;">
                    {{ (IsProcessing && Number(IsProcessing) !== 4) ? 'Сделки (На согласовании)' : '' }}
                    {{ (!IsProcessing && Number(IsProcessing) !== 4) ? 'Сделки (В исполнении)' : '' }}
                    {{ Number(IsProcessing) == 4 ? 'Сделки (Завершены)' : '' }}
                </p>
            </div>
            <div class="justify-content-right text-right sb-btn-actions">
                <a class="btn btn-outline-info btn-left" href="/admin/deals/processing"
                   :class="{'btn-info btn-active': IsProcessing === true}">
                    На согласовании ({{ deals_IsProcessingCount }})
                </a>
                <a style="margin-left:-4px" class="btn btn-outline-info btn-center" href="/admin/deals/in_progress"
                   :class="{'btn-info btn-active': IsProcessing === false}">
                    В исполнении ({{ deals_InProgressCount }})
                </a>
                <a style="margin-left:-4px" class="btn btn-outline-info btn-right"
                   href="/admin/deals/finished" :class="{'btn-info btn-active': IsProcessing === 4}">
                    Завершены {{ deals_FinishCount }}
                </a>
            </div>
            <div class="row d-flex justify-content-between pt-4" v-if="false">
                <div class="col-3">
                    <p><b>Список сделок</b></p>
                </div>
                <div class="col-4 d-flex">
                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-8">
                            <form action="" method="get">
                                <input name="s" placeholder="Поиск в каталоге" type="search">
                                <button class="search_button" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-4">
                            <a v-on:click="showFiltersBlock=!showFiltersBlock" class="text-white btn btn-primary"><i
                                class="fa fa-filter">
                            </i> ФИЛЬТР <i class="fa fa-caret-down fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="IsProcessing == 4" class="col-12 ">
            <div class="overflow-auto">
                <table-data-component :items="dealsTable.tableItems" :columns="dealsTable.tableColumns"
                                      :headers="dealsTable.tableHeaders">
                    <template #action="{id}">
                        <a :href="'/admin/deals/show/' + id" style="color: blue">
                            подробнее
                        </a>
                    </template>
                    <template #status="{ item }">
                        <div v-if="item.estimates.length > 0" class="d-flex gap-2">
                            <div style="cursor:pointer"
                                 class="d-none d-lg-flex justify-content-center"
                                 @click="showInvoice(item.id, item.estimates[item.estimates.length - 1].id)">
                                <img width="20px" src="/icons/pdf-file.svg" alt="">
                            </div>
                            <div style="cursor:pointer"
                                 class="d-none d-lg-flex justify-content-center"
                                 @click="showPayment(item.id, item.estimates[item.estimates.length - 1].id)">
                                <img width="20px" src="/icons/pdf-file.svg" alt="payment">
                            </div>
                        </div>
                        <p v-else>нет</p>
                    </template>
                </table-data-component>
            </div>
        </div>
        <div v-else-if="IsProcessing" class="col-12 ">
            <div class="overflow-auto">
                <table class="table">
                    <thead>
                    <th class="text-center text-nowrap">ID номер<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Дата созд.<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th width="10%" class="text-center text-nowrap">Тип заявки<i
                        class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Объект<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Заказчик<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Исполнитель<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Докум.<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Статус<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Действие</th>
                    </thead>
                    <tbody>
                    <tr v-for="deal in paginatedDeals">
                        <td class="text-center">
                            <div id="overlay" v-if="showDeleteModal == deal.id">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title text-center">Уведомление</h3>
                                            <button type="button" class="close"
                                                    @click="showDeleteModal = null">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <p style="font-size: calc(1.25rem); color: #0B3158"
                                               class="text-center mb-4">
                                                Вы действительно хотите удалить сделку?</p>
                                            <div class="d-flex">
                                                <button class="w-100 btn btn-yes" type="button"
                                                        @click="delDeal({id: deal.id})">
                                                    Да
                                                </button>
                                                <button type="button" @click="showDeleteModal = null"
                                                        class="w-100 btn btn-no">
                                                    <ins>НЕТ</ins>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ deal.id }}
                        </td>
                        <td class="text-center">
                            {{ deal.tender ? deal.tender.fullDate : (deal.direct ? deal.direct.fullDate : '') }}
                        </td>
                        <td>{{ deal.tender ? 'Тендерная заявка' : 'Прямая заявка' }}</td>
                        <td class="text-center">{{ deal.sportObject.title }} (ID: {{ deal.sportObject.id }})</td>
                        <td class="underline text-center">{{
                                deal.tender ?
                                    deal.tender.customer_info.title + " " + `(ID:${deal.tender.customer_info.user_id})` :
                                    deal.direct.customer_info.title + " " + `(ID:${deal.direct.customer_info.user_id})`
                            }}
                        </td>
                        <td class="underline">
                            {{
                                deal.responsesTender ?
                                    deal.responsesTender.company_info.title + " " + `(ID: ${deal.responsesTender.company_info.user_id})` :
                                    deal.direct.owner_info.title + " " + `(ID: ${deal.direct.owner_info.user_id})`
                            }}
                        </td>
                        <td class="underline">
                            <div v-if="deal.estimates.length > 0" class="d-flex gap-2">
                                <div style="cursor:pointer"
                                     class="d-none d-lg-flex justify-content-center"
                                     @click="showInvoice(deal.id, deal.estimates[deal.estimates.length - 1].id)">
                                    <img width="20px" src="/icons/pdf-file.svg" alt="">
                                </div>
                                <div style="cursor:pointer"
                                     class="d-none d-lg-flex justify-content-center"
                                     @click="showPayment(deal.id, deal.estimates[deal.estimates.length - 1].id)">
                                    <img width="20px" src="/icons/pdf-file.svg" alt="payment">
                                </div>
                            </div>
                            <p v-else>нет</p>
                        </td>
                        <td v-if="deal.complete == 1 || deal.complete == 2" class="text-center" style="color: blue">
                            {{ deal.complete == 1 ? 'Сделка завершена (успешно)' : 'Сделка завершена (с арбитражем)' }}
                        </td>
                        <td v-else-if="deal.accept_by_customer == 0" class="text-center" style="color: blue">
                            ожидает решения (от Заказчика)
                        </td>
                        <td v-else-if="deal.accept_by_executor == 0" class="text-center" style="color: blue">
                            ожидает решения (от Исполнителя)
                        </td>
                        <td width="10%">
                            <a :href="'/admin/deals/show/' + deal.id" style="color:black !important">
                                <i class="fa mx-2 fa-info-circle"></i>
                            </a>
                            <a @click="showDeleteModal = deal.id" style="color: red !important; cursor:pointer;">
                                <i class="fas  mx-2 fa-window-close"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else-if="!IsProcessing" class="col-12 ">
            <div class="overflow-auto">
                <table class="table">
                    <thead>
                    <th class="text-center text-nowrap">ID номер<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Дата созд.<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th width="10%" class="text-center text-nowrap">Тип заявки<i
                        class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Объект<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Заказчик<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Исполнитель<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Докум.<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Статус<i class="fa fa-caret-down mx-2 sort"></i></th>
                    <th class="text-center text-nowrap">Действие</th>
                    </thead>
                    <tbody>
                    <tr v-for="deal in paginatedDeals">
                        <td class="text-center">
                            <div id="overlay" v-if="showDeleteModal == deal.id">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title text-center">Уведомление</h3>
                                            <button type="button" class="close"
                                                    @click="showDeleteModal = null">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <p style="font-size: calc(1.25rem); color: #0B3158"
                                               class="text-center mb-4">
                                                Вы действительно хотите удалить заявку?</p>
                                            <div class="d-flex">
                                                <button class="w-100 btn btn-yes" type="button"
                                                        @click="delDeal({id: deal.id})">
                                                    Да
                                                </button>
                                                <button type="button" @click="showDeleteModal = null"
                                                        class="w-100 btn btn-no">
                                                    <ins>НЕТ</ins>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ deal.id }}
                        </td>
                        <td class="text-center">
                            {{ deal.tender ? deal.tender.fullDate : (deal.direct ? deal.direct.fullDate : '') }}
                        </td>
                        <td>{{ deal.tender ? 'Тендерная заявка' : 'Прямая заявка' }}</td>
                        <td class="text-center">{{ deal.sportObject.title }} (ID: {{ deal.sportObject.id }})</td>
                        <td class="underline text-center">{{
                                deal.tender ?
                                    deal.tender.customer_info.title + " " + `(ID:${deal.tender.customer_info.user_id})` :
                                    deal.direct.customer_info.title + " " + `(ID:${deal.direct.customer_info.user_id})`
                            }}
                        </td>
                        <td class="underline">
                            {{
                                deal.responsesTender ?
                                    deal.responsesTender.company_info.title + " " + `(ID: ${deal.responsesTender.company_info.user_id})` :
                                    deal.direct.owner_info.title + " " + `(ID: ${deal.direct.owner_info.user_id})`
                            }}
                        </td>
                        <td class="underline">
                            <div v-if="deal.estimates.length > 0" class="d-flex gap-2">
                                <div style="cursor:pointer"
                                     class="d-none d-lg-flex justify-content-center"
                                     @click="showInvoice(deal.id, deal.estimates[deal.estimates.length - 1].id)">
                                    <img width="20px" src="/icons/pdf-file.svg" alt="">
                                </div>
                                <div style="cursor:pointer"
                                     class="d-none d-lg-flex justify-content-center"
                                     @click="showPayment(deal.id, deal.estimates[deal.estimates.length - 1].id)">
                                    <img width="20px" src="/icons/pdf-file.svg" alt="payment">
                                </div>
                            </div>
                            <p v-else>нет</p>
                        </td>
                        <td class="text-center" style="color: blue">
                            {{ stepsDeal.filter(p => p.step == deal.step)[0].title }}
                        </td>
                        <td width="10%">
                            <a :href="'/admin/deals/show/' + deal.id" style="color:black !important">
                                <i class="fa mx-2 fa-info-circle"></i>
                            </a>
                            <a @click="showDeleteModal = deal.id" style="color: red !important; cursor:pointer;">
                                <!--@click="" style="color: red !important; cursor:pointer;">!-->
                                <i class="fas  mx-2 fa-window-close"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>


<script>
import {mapActions, mapGetters} from "vuex";
import VSelect from "@alfsnd/vue-bootstrap-select";
import axios from "axios";
import TableDataComponent from "./elements/TableDataComponent";

export default {
    components: {
        TableDataComponent,
        VSelect,
    },
    props: ['isProcessing'],
    data() {
        return {
            processing: null, showDeleteModal: false, indexDeal: null,
            showFiltersBlock: false,
            filter: {
                minPrice: null, maxPrice: '', foodId: '' || {id: 0, title: "Любое", col: 0},
                serviceId: '' || {id: 0, title: "Любые", col: 0}, infrId: '' || {id: 0, title: "Любая", col: 0},
                dateStart: null, dateEnd: null,
            },
            stepsDeal: [
                {step: 2, title: 'В процессе выполнения (шаг 2)'}, {step: 3, title: 'В процессе выполнения (шаг 3)'},
                {step: 4, title: 'В процессе выполнения (шаг 4)'}, {step: 5, title: 'В процессе выполнения (шаг 5)'},
                {step: 6, title: 'На арбитраже (со стороны Заказчика)'},
                {step: 7, title: 'На арбитраже (со стороны Исполнителя)'},
            ], loading: false
        }
    },
    methods: {
        ...mapActions(["adminFetchDeals", "delDeal"]),
        showInvoice(deal_id, estimate_id) {
            window.open("/storage/listings/estimate/" + deal_id + "/" + estimate_id, '_blank')
        },
        showPayment(deal_id, estimate_id) {
            window.open("/storage/listings/payment-invoice/" + deal_id + "/" + estimate_id, '_blank')
        },
    },
    computed: {
        ...mapGetters({
            deals_IsProcessing: 'DealsIsProcessing',
            deals_IsProcessingCount: 'DealsIsProcessingCount',
            deals_InProgress: 'DealsInProgress',
            deals_InProgressCount: 'DealsInProgressCount',
            deals_Finish: 'DealsFinished',
            deals_FinishCount: 'DealsFinishCount',
        }),
        IsProcessing() {
            this.processing = this.$props.isProcessing;
            return this.processing;
        },
        paginatedDeals() {
            if (this.$props.isProcessing == 4)
                return this.deals_Finish;
            else if (this.IsProcessing) {
                return this.deals_IsProcessing;
            } else if (!this.IsProcessing) {
                return this.deals_InProgress;
            }
        },
        dealsTable() {
            let headers = [
                {label: "ID номер"}, {label: "Дата созд."}, {label: "Тип заявки"}, {label: "Объект"},
                {label: "Заказчик"}, {label: "Исполнитель"}, {label: "Докум."}, {label: "Статус"},
                {label: "Выплата исполнителю"}, {label: "Детали"}
            ];
            let columns = [
                {prop: "id", class: "text-center"},
                {prop: "deal_date_create", class: "text-center"},
                {prop: "deal_type", class: ""},
                {prop: "deal_object", class: "text-center", html: true},
                {prop: "deal_customer", class: "text-center", html: true},
                {prop: "deal_executor", class: "text-center", html: true},
                {prop: "documents", class: "text-center", html: true},
                {prop: "deal_status", class: "text-center", html: true},
                {prop: "deal_payment_executor", class: "text-center"},
                {prop: "action", class: "", width: '10%'}
            ];
            let items = this.paginatedDeals.map(deal => ({
                ...deal,
                deal_date_create: `${deal.tender ? deal.tender.fullDate : (deal.direct ? deal.direct.fullDate : '')}`,
                deal_type: `${deal.tender ? 'Тендерная заявка' : 'Прямая заявка'}`,
                deal_object: `<a href="/admin/sport-objects/show/${deal.sportObject.id}">
                                ${deal.sportObject.title} (ID: ${deal.sportObject.id})
                            </a>`,
                deal_customer: `<a href="/admin/users/profile/${deal.tender?.customer_info?.user_id || deal.direct.customer_info.user_id}">
                                ${deal.tender?.customer_info?.title || deal.direct.customer_info.title} (ID:${deal.tender?.customer_info?.user_id || deal.direct.customer_info.user_id})
                            </a>`,
                deal_executor: `<a href="/admin/users/profile/${deal.responsesTender?.company_info?.user_id ?? deal.direct?.owner_info?.user_id}">
                                ${deal.responsesTender?.company_info?.title ?? deal.direct?.owner_info?.title}
                                (ID:${deal.responsesTender?.company_info?.user_id ?? deal.direct?.owner_info?.user_id})
                            </a>`,
                deal_status: deal.status === 2 ? `<span style="color: red">Отклонена (Заказчиком)</span>` :
                    deal.status === 3 ? `<span style="color: red">Отклонена (Исполнителем)</span>` :
                        deal.complete === 1 ? `<span style="color: blue">Завершена (успешно)</span>` :
                            deal.complete === 2 ? `<span style="color: red">Завершена (с арбитражем)</span>` : '',
                deal_payment_executor: 'выплачено'
            }));
            return {
                tableHeaders: headers,
                tableColumns: columns,
                tableItems: items
            }
        },
    },
    mounted() {
        this.loading = true;
        this.adminFetchDeals().then(() => {
            this.loading = false;

            console.log(this.paginatedDeals)
        });
        console.log("Mounted", this.isProcessing)
    },
};
</script>
<style>
.btn {
    width: 150px;
}

.btn-info {
    color: #212529;
    background-color: #6cb2eb;
    border-color: #6cb2eb;
}

.btn-left {
    border-radius: .5rem 0 0 .5rem;
}

.btn-center {
    border-radius: 0 0 0 0;
}

.btn-right {
    border-radius: 0 .5rem .5rem 0;
}

.btn-active {
    color: white !important;
}

.mfs-r-3 {
    margin-right: 1.5rem !important;
}

.p-1rem {
    padding: 1rem !important;
}

.m-t-b-5 {
    margin-top: 5px;
    margin-bottom: 5px;
}

.m-t-b-10 {
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
