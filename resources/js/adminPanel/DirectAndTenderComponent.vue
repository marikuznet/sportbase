<template>
    <div class="m-aut mfs-3 mfe-n3">
        <div class="col-6 justify-content-left">
            <p style="margin-top:10px;margin-bottom:10px;">
                Заявки ({{ IsDirect ? 'Прямые заявки' : 'Тендерные заявки' }})
            </p>
        </div>
        <div class="col-12 mb-3">
            <div class="sb-btn-actions">
                <a class="btn btn-outline-info btn-left fw-bold" href="/admin/applications/direct"
                   :class="{'btn-info text-white': IsDirect}">
                    Прямые заявки ({{ countDirectApplications }})
                </a>
                <a style="margin-left:-6px" class="btn btn-outline-info btn-right fw-bold"
                   :class="{'btn-info text-white': !IsDirect}" href="/admin/applications/tender">
                    Тендерные заявки ({{ tendersCount }})
                </a>
            </div>
        </div>

        <div class="row justify-content-between px-3">
            <div class="col-3">
                <p><b>{{ isDirect ? 'Прямые заявки' : 'Тендерные заявки' }}</b></p>
            </div>
            <div v-if="isDirect" class="col-4 d-flex">
                <a class="font-sm pr-3 text-uppercase link" v-on:click="direct_applications = true"
                   :class="{'active-link': !direct_applications}">
                    Активные <span>({{ directApplicationsActiveCount }})</span>
                </a>
                <a class="font-sm text-uppercase link" v-on:click="direct_applications = false"
                   :class="{'active-link': direct_applications}">
                    Архивные <span>({{ directApplicationsArchiveCount }})</span>
                </a>
            </div>
            <div v-else class="col-4 d-flex">
                <a class="font-sm pr-3 link" @click="tender_applications = true"
                   :class="{'active-link': !tender_applications}">
                    Активные <span>({{ tendersActiveCount }})</span>
                </a>
                <a class=" font-sm link" @click="tender_applications = false"
                   :class="{'active-link': tender_applications}">
                    Архивные <span>({{ tendersArchiveCount }})</span>
                </a>
            </div>
            <div class="col-5">
                <div class="row">
                    <div class="col-8">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Поиск в каталоге">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-4">
                        <a v-on:click="showFiltersBlock=!showFiltersBlock" class="text-white btn btn-primary"><i
                            class="fa fa-filter">
                        </i> ФИЛЬТР <i class="fa fa-caret-down fa-lg"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 mt-1">
            <div class="mfe-3 mfs-n3" v-show="showFiltersBlock">
                <div class="card card-body">
                    <div class="">
                        <div class="row">
                            <div class="col-3">
                                <label for="">Стоимость (руб. в сутки за одного человека)</label>
                                <div class="row">
                                    <div class="form-group d-flex">
                                        <input class="form-control" type="text" placeholder="от 1000" maxlength="6"
                                               minlength="2" v-model="filter.minPrice">
                                        <p> - </p>
                                        <input class="form-control" type="text" placeholder="до 10000" maxlength="6"
                                               minlength="2" v-model="filter.maxPrice">
                                        <select name="" id="" class="w-100 form-control">
                                            <option>руб</option>
                                            <option>usd</option>
                                            <option>euro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="food">Предоставляемое питание</label>
                                            <v-select id="food" class="selectpicker" :options="foodsFilterWithAny"
                                                      :items="foodsFilterWithAny"
                                                      textProp="title" valueProp="id" v-model="filter.foodId">
                                            </v-select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="infr">Инфраструктура</label>
                                            <v-select id="infr" class="selectpicker" :options="infrFilterWithAny"
                                                      :items="infrFilterWithAny"
                                                      textProp="title" valueProp="id" v-model="filter.infrId">
                                            </v-select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="services">Предоставляемые услуги</label>
                                    <v-select id="services" class="selectpicker" :options="servicesFilterWithAny"
                                              :items="servicesFilterWithAny"
                                              textProp="title" valueProp="id" v-model="filter.serviceId">
                                    </v-select>
                                </div>
                                <!--<div class="form-group" v-show="b">
                                    <label for="accred">Наличие акредитации <b><u>Минспорта</u></b></label>
                                    <select class="w-100 form-control" id="accred">
                                        <option>Без разницы</option>
                                        <option>Да</option>
                                        <option>Нет</option>
                                    </select>
                                </div>!-->
                            </div>
                            <div class="col-3">
                                <label for="">Дата пребывания</label>
                                <div class="row w-50">
                                    <div class="form-group d-flex">
                                        <input class="form-control" type="date" v-model="filter.dateStart">
                                        <p> - </p>
                                        <input class="form-control" type="date" v-model="filter.dateEnd">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <template v-if="IsDirect">
            <div class="col-12">
                <div class="overflow-auto">
                    <table-data-component :items="directTable.tableItems" :columns="directTable.tableColumns"
                                          :headers="directTable.tableHeaders">
                        <template v-if="direct_applications" #action="{ id }">
                            <direct-modal v-if="indexDirect === id" @close="closeDirect" :scrollable="true"
                                          body-id="direct-modal-body" header-id="direct-modal-header"
                                          :id="id"></direct-modal>
                            <a :href="'/admin/applications/direct/show/' + id" target="_blank"
                               style="color:black !important"><i class="fa fa-info-circle"></i></a>
                            <a @click="showEditDirect(id)" href="#" style="color: lightblue !important;"><i
                                class="fa fa-edit"></i></a>
                            <a @click="showDeleteModal = id"
                               style="color: red !important; cursor:pointer;">
                                <i class="fas fa-window-close"></i>
                            </a>
                        </template>
                        <template v-else-if="!direct_applications" #action="{ id }">
                            <a :href="'/admin/applications/direct/show/' + id"><u>подробнее</u></a>
                        </template>
                        <template #status="{item}">
                            <p :style="`color: ${item.colorStatus}`">{{ item.status }}</p>
                        </template>
                        <template #modals>
                            <div id="overlay" v-if="showDeleteModal !== null">
                                <div class="modal-dialog" style="top: 25%">
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
                                                Вы действительно хотите удалить прямую заявку
                                                #{{ showDeleteModal }}?</p>
                                            <div class="d-flex">
                                                <button class="w-100 btn btn-yes" type="button"
                                                        @click="delDirect({id: showDeleteModal})">
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
                        </template>
                    </table-data-component>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="col-12">
                <div class="overflow-auto">
                    <table-data-component :items="tenderTable.tableItems" :columns="tenderTable.tableColumns"
                                          :headers="tenderTable.tableHeaders">
                        <template v-if="tender_applications" #action="{ id }">
                            <a style="color:black !important"
                               :href="'/admin/applications/tender/show/' + id"><i
                                class="fa fa-info-circle"></i></a>
                            <a @click="showEditTender(id)" style="color: lightblue !important;" href="#"><i
                                class="fa  fa-edit"></i></a>
                            <a @click="showDeleteModal = id" style="color: red !important; cursor: pointer">
                                <i class="fas fa-window-close"></i>
                            </a>
                        </template>
                        <template v-else-if="!tender_applications" #action="{ id }">
                            <a :href="'/admin/applications/tender/show/' + id">подробнее</a>
                        </template>

                        <template v-if="tender_applications" #status="{ item }">
                            <template v-if="!item.hasDeal">
                                сбор предложений от Исполнителей
                            </template>
                            <template v-else>
                                <template v-if="item.deal.step === 1 && ![2, 3].includes(item.deal.status)">
                                    <div class="d-flex justify-content-center align-items-center notification-blue
                                            border-radius__10">
                                            <span>Ожидает решения
                                                {{ item.deal.accept_by_customer === 1 ? 'Исполнителя' : '' }}
                                                {{ item.deal.accept_by_executor === 1 ? 'Заказчика' : '' }}
                                            </span>
                                    </div>
                                </template>
                                <template v-if="item.deal.step > 1">
                                    {{ item.deal.step === 2 ? 'В процессе выполнения (шаг 2)' : '' }}
                                    {{ item.deal.step === 3 ? 'В процессе выполнения (шаг 3)' : '' }}
                                    {{ item.deal.step === 4 ? 'В процессе выполнения (шаг 4)' : '' }}
                                    {{ item.deal.step === 5 ? 'В процессе выполнения (шаг 5)' : '' }}
                                </template>
                            </template>
                        </template>
                        <template v-else #status="{item}">
                            <template v-if="!item.hasDeal && (item.archive === 2 || item.archive === 3)">
                                <p class="text-danger">{{ item.archive === 2 ? 'Отклонена (Заказчиком)' : '' }}
                                    {{ item.archive === 3 ? 'Отклонена (Исполнителем)' : '' }}</p>
                            </template>
                            <template
                                v-else-if="item.hasDeal && (item.deal.complete === 1 || item.deal.complete === 2)">
                                <p class="text-success">{{ `Завершена (сделка №${item.deal.id})` }}</p>
                            </template>
                            <template
                                v-else-if="item.hasDeal && (item.deal.complete !== 1 || item.deal.complete !== 2)">
                                <p class="text-success">{{ 'Сделка заключена' }}</p>
                            </template>
                            <template
                                v-else-if="new Date(item.start_date) < new Date()">
                                <p class="text-danger">{{ 'Заявка просрочена' }}</p>
                            </template>

                        </template>
                        <template #modals v-if="tender_applications">
                            <div id="overlay" v-if="showDeleteModal !== null">
                                <div class="modal-dialog" style="top: 25%">
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
                                                Вы действительно хотите удалить тендерную заявку #{{
                                                    showDeleteModal
                                                }}?</p>
                                            <div class="d-flex">
                                                <button class="w-100 btn btn-yes" type="button"
                                                        @click="delTender({id: showDeleteModal})">
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
                            <template>
                                <tender-modal v-if="indexTender !== null" @close="closeTender" :scrollable="true"
                                              body-id="null" header-id="null" :id="indexTender"></tender-modal>
                            </template>
                        </template>
                    </table-data-component>
                </div>
            </div>
        </template>
    </div>
</template>
<script>
import {mapGetters, mapActions} from "vuex";
import VSelect from "@alfsnd/vue-bootstrap-select";
import VueCompositionAPI from '@vue/composition-api';
import Slider from '@vueform/slider/dist/slider.vue2.js';
import directModal from "../components/requests/directModal";
import tenderModal from "../components/requests/tenderModal";
import TableDataComponent from "./elements/TableDataComponent";
import ModalNotification from "../adminPanel/elements/modal"

Vue.use(VueCompositionAPI);


export default {
    props: ['isDirect'],
    data() {
        return {
            application: null, showFiltersBlock: false, showDirect: false, indexDirect: null,
            direct_applications: true, tender_applications: true,
            filter: {
                minPrice: null, maxPrice: '', foodId: '' || {id: 0, title: "Любое", col: 0},
                serviceId: '' || {id: 0, title: "Любые", col: 0}, infrId: '' || {id: 0, title: "Любая", col: 0},
                dateStart: null, dateEnd: null,
            }, showDeleteModal: null, showTender: false, indexTender: null,
        }
    },
    methods: {
        ...mapActions(["fetchDirectApplications", "fetchAdminTenders", "delDirect", "delTender"]),
        showEditDirect(direct_id) {
            this.showDirect = true;
            this.indexDirect = direct_id;
        },
        showEditTender(tender_id) {
            this.showTender = true;
            this.indexTender = tender_id;
        },
        closeDirect() {
            this.showDirect = false;
            this.indexDirect = null;
        },
        closeTender() {
            this.showTender = false;
            this.indexTender = null;
        },
    },
    computed: {
        ...mapGetters({
            directApplicationsActive: "adminDirectApplicationsActive",
            directApplicationsActiveCount: "adminDirectApplicationsActiveCount",
            directApplicationsArchive: "DirectApplicationsArchive",
            directApplicationsArchiveCount: "DirectApplicationsArchiveCount",
            countDirectApplications: "adminDirectApplicationsCount",
            tendersActive: "tendersActive",
            tendersActiveCount: "tendersActiveCount",
            tendersArchive: "tendersArchive",
            tendersArchiveCount: "tendersArchiveCount",
            tendersCount: "AllTendersCount",
            allTypeFoods: 'AllTypeFoods',
            allInfrastructures: 'AllRequirementInfrastructures',
            allServices: 'AllAdditionTender',
        }),
        directTable() {
            return {
                tableHeaders: [
                    {label: "ID номер"},
                    {label: "Дата созд."},
                    {label: "Дата пребыв."},
                    {label: "Тип объекта"},
                    {label: "Объект"},
                    {label: "Заказчик"},
                    {label: "Исполнитель"},
                    {label: "Статус"},
                    {label: "Действие"}
                ],
                tableColumns: [
                    {prop: "id", class: "text-center"},
                    {prop: "dateCreate", class: "text-center"},
                    {prop: "dateObservation", class: ""},
                    {prop: "sportObject_type", class: "text-center"},
                    {prop: "sportObject_title", class: "underline text-center", html: true},
                    {prop: "customer_title", class: "underline", html: true},
                    {prop: "sportObject_created", class: "underline", html: true},
                    {prop: "status", class: "text-center"},
                    {prop: "action", class: "text-center"}
                ],
                tableItems: this.paginatedDirects.map(direct => ({
                    ...direct,
                    customer_title: `<a href="/admin/users/profile/${direct.customer_info.id}">${direct.customer_info.title} (ID:${direct.customer_info.id})</a>`,
                    sportObject_title: `<a href="/admin/sport-objects/show/${direct.sportObject.id}">
                                ${direct.sportObject.title} (ID: ${direct.sportObject.id})
                            </a>`,
                    sportObject_created: `<a href="/admin/users/profile/${direct.sportObject.created.id}">
                                ${direct.sportObject.created.title} (ID: ${direct.sportObject.created.id})
                            </a>`,
                }))
            }
        },
        tenderTable() {
            return {
                tableHeaders: [
                    {label: "ID номер"},
                    {label: "Дата созд."},
                    {label: "Дата пребыв."},
                    {label: "Гео. регион"},
                    {label: "Заказчик"},
                    {label: "Исполнитель"},
                    {label: "Статус"},
                    {label: "Действие"}
                ],
                tableColumns: [
                    {prop: "id", class: "text-center"},
                    {prop: "createDate", class: "text-center"},
                    {prop: "dateOfStay", class: ""},
                    {prop: "region", class: "underline text-center"},
                    {prop: "customer_title", class: "underline", html: true},
                    {prop: "title_executor", class: "underline", html: true},
                    {prop: "status", class: "text-center"},
                    {prop: "action", class: "text-center"}
                ],
                tableItems: this.paginatedTenders.map(tender => ({
                    ...tender,
                    customer_title: tender.customer_info.title ? `<a href="/admin/users/profile/${tender.customer_info.user_id}">${tender.customer_info.title ?? ''} (ID:${tender.customer_info.user_id ?? ''})</a>` : '',
                    title_executor: tender.executor_info.title ? `<a href="/admin/users/profile/${tender.executor_info.user_id}">${tender.executor_info.title ?? ''} (ID:${tender.executor_info.user_id ?? ''})</a>` : ''
                }))
            }
        },

        IsDirect() {
            this.application = this.isDirect;
            return this.application;
        },
        foodsFilterWithAny: function () {
            /* if (this.showDirect || this.showTender) this.allTypeFoods.splice(0, 1);
             else this.allTypeFoods.unshift({'id': 0, title: 'Любое'});
             return this.allTypeFoods;*/
        },
        servicesFilterWithAny: function () {
            /*if (this.showDirect || this.showTender) this.allServices.splice(0, 1);
            else this.allServices.unshift({'id': 0, title: 'Любые'});
            return this.allServices;*/
        },
        infrFilterWithAny: function () {
            /* if (this.showDirect || this.showTender) this.allInfrastructures.splice(0, 1);
             else this.allInfrastructures.unshift({'id': 0, title: 'Любая'});
             return this.allInfrastructures;*/
        },

        paginatedDirects() {
            const filterDirects = (directs) => {
                return directs.filter(direct => {
                    return this.filter.foodId.id == 0 || direct.typeFoods.find(item => item.id == this.filter.foodId.id);
                }).filter(direct => {
                    return this.filter.serviceId.id == 0 || direct.additionsTender.find(item => item.id == this.filter.serviceId.id);
                }).filter(direct => {
                    return this.filter.infrId.id == 0 || direct.infrastructures.find(item => item.id == this.filter.infrId.id);
                }).filter(direct => {
                    return this.filter.minPrice == null || direct.minPrice >= this.filter.minPrice;
                }).filter(direct => {
                    return this.filter.maxPrice == '' || this.filter.maxPrice >= direct.minPrice;
                }).filter(direct => {
                    const first = new Date(direct.fullStartDate);
                    const second = new Date(this.filter.dateStart);
                    return this.filter.dateStart == null || first >= second;
                }).filter(direct => {
                    var first = new Date(direct.fullEndDate);
                    var second = new Date(this.filter.dateEnd);
                    return this.filter.dateEnd == null || first <= second;
                });
            };

            if (this.direct_applications) {
                return filterDirects(this.directApplicationsActive.map(direct => ({
                    ...direct,
                    status: 'ожидает решения от Исполнителя'
                })));
            } else {
                return filterDirects(this.directApplicationsArchive.map(direct => ({
                    ...direct,
                    status: direct.archive === 2 ? 'Отклонена (Заказчиком)' :
                        direct.archive === 3 ? 'Отклонена (Исполнителем)' :
                            direct.hasDeal ? `Сделка #${direct.dealId}` : '',
                    colorStatus: direct.archive === 2 ? '#e45868' :
                        direct.archive === 3 ? '#e45868' :
                            direct.hasDeal ? '#6FB77F' : ''
                })));
            }
        },
        paginatedTenders() {
            const filterTenders = (tenders) => {
                return tenders.filter(tender => {
                    return this.filter.foodId.id == 0 || tender.typeFoods.find(item => item.id == this.filter.foodId.id);
                }).filter(tender => {
                    return this.filter.serviceId.id == 0 || tender.additionsTender.find(item => item.id == this.filter.serviceId.id);
                }).filter(tender => {
                    return this.filter.infrId.id == 0 || tender.infrastructures.find(item => item.id == this.filter.infrId.id);
                }).filter(tender => {
                    return this.filter.minPrice == null || tender.minPrice >= this.filter.minPrice;
                }).filter(tender => {
                    return this.filter.maxPrice == '' || this.filter.maxPrice >= tender.minPrice;
                }).filter(tender => {
                    var first = new Date(tender.fullStartDate);
                    var second = new Date(this.filter.dateStart);
                    return this.filter.dateStart == null || first >= second;
                }).filter(tender => {
                    var first = new Date(tender.fullEndDate);
                    var second = new Date(this.filter.dateEnd);
                    return this.filter.dateEnd == null || first <= second;
                });
            };

            if (this.tender_applications) {
                return filterTenders(this.tendersActive.map(direct => ({
                    ...direct,
                    status: direct.archive === 2 ? 'Отклонена (Заказчиком)' :
                        direct.archive === 3 ? 'Отклонена (Исполнителем' :
                            direct.hasDeal ? `Сделка #${direct.dealId}` : ''
                })));
            } else {
                return filterTenders(this.tendersArchive);
            }
        }
    },
    mounted() {
        this.fetchDirectApplications();
        this.fetchAdminTenders();

    },
    watch: {},
    components: {
        TableDataComponent,
        VSelect, Slider, directModal, tenderModal, ModalNotification
    }
};
</script>
<style></style>
<style>

#overlay {
    z-index: 999;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.2);
}

table td {
    vertical-align: middle !important;
}

input[type=checkbox] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-tap-highlight-color: transparent;
    cursor: pointer;
}

input[type=checkbox]:focus {
    outline: 0;
}

.toggle {
    height: 22px;
    width: 44px;
    border-radius: 16px;
    display: inline-block;
    position: relative;
    margin: 0;
    border: 2px solid red;
    transition: all 0.2s ease;
}

.toggle:after {
    content: "";
    position: absolute;
    top: 2px;
    left: 2px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: white;
    box-shadow: 0 1px 2px rgba(44, 44, 44, 0.2);
    transition: all 0.2s cubic-bezier(0.5, 0.1, 0.75, 1.35);
}

.toggle:checked {
    border-color: green;
    background-color: green;
}

.toggle:checked:after {
    transform: translatex(20px);
}


.btn-active {
    background-color: lightgrey;
}

.tabs li {
    color: black !important;
    border: 1px solid black;
}

.btn {
    width: 150px;
}

.btn-left {
    border-radius: .5rem 0 0 .5rem;
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

.link {
    text-transform: uppercase;
}

.active-link {
    cursor: pointer;
    text-decoration: underline !important;
    color: blue !important;
}

.underline:hover {
    text-decoration: underline;
    cursor: pointer;
}
</style>
