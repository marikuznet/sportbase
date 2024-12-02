<template>
    <div>
        <div class="align-items-center d-flex justify-content-center loading position-fixed" v-if="tenders_loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <div class="content__tenderCatalog container-fluid p-0 ">
            <div class="top container-fluid px-5 px-lg-0 ">
                <div class="container py-0 py-lg-3 text-center px-0" v-show="isCustomer || user === 0">
                    <p class="top__title  py-3 ">Тендерные заявки</p>
                    <form action="/create/tender">
                        <button class="top__button button button-fill d-block mx-auto my-0 my-lg-3 mb-2 p-lg-4 p-3">
                            <p class="fw-bold">Заявка на проведение тендера</p>
                        </button>
                    </form>
                    <p class="top__text pb-5 pt-lg-2 pt-4">Если в каталоге не можете найти нужного объекта - можете
                        оставить заявку и мы вам поможем подобрать нужный объект</p>
                </div>
                <div class="container py-0 py-lg-3 text-center px-0" v-show="isExecutor">
                    <p class="top__title  py-3 ">Тендерные заявки</p>
                    <p class="top__text pb-5 pt-lg-2 pt-4">Каталог заявок на аренду объекта. Вы можете откликаться на
                        заявки Заказчиков и заключать с ними сделки.</p>
                </div>
            </div>
            <div class="middle container-fluid  d-lg-flex p-0 overflow-hidden">
                <div class="wrapper filter_sort">
                    <div class="options row m-0 col-lg-8 col-md-12 float-right">
                        <div class="search order-3 order-lg-1 pt-3 px-0">
                            <input type="text" class="search__input borderblock w-100 text-start inputInf"
                                   id="search__input" v-model="filter.searchTender" name="search__input"
                                   placeholder="Поиск по базе">
                        </div>
                        <div class="products order-1 borderBlockBottom order-lg-2 py-3 px-0">
                            <div class="button-blueBorder borderblock shadow px-4 w-100 d-flex justify-content-between">
                                <p>Доступные тендеры</p>
                                <p class="count text-end"><b>{{ tenders_statistic.activeTendersCount }}</b></p>
                            </div>
                        </div>
                        <div
                            class="d-flex filters flex-column justify-content-between m-0 mt-3 mt-lg-0 order-2 order-lg-3 px-0 row">
                            <div class="d-flex">
                                <div class="col d-lg-none Mobile filters__sortby borderblock bg-white inputInf dropdown
                                    show w-100 me-3">
                                    <p class="dropdown-toggle text-Blue" role="button" id="dropdownMenuLink"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ sortRules[filter.sortIndex].title }}
                                    </p>
                                    <div class="dropdown-menu fs-5 w-100 border-0  pt-0"
                                         aria-labelledby="dropdownMenuLink">
                                        <p class="dropdown-item text-Blue  py-3 borderBlockBottom" v-for="(rule, index)
                                    in sortRules" :key="rule.key" :value="rule.key" @click="filter.sortIndex  = index">
                                            {{ rule.title }}
                                        </p>
                                    </div>
                                </div>
                                <button class="borderblock filters__Menu__trigger d-lg-none" type="button"
                                        data-toggle="collapse" data-target="#collapseFilters"
                                        aria-controls="collapseFilters"></button>
                            </div>
                            <div class="col col-auto filters__all filters__Menu">
                                <div id="collapseFilters" class="collapse show filters__Menu__options d-block">
                                    <label class="pt-2 px-0">Вид спорта</label>
                                    <v-select-items id="sport" class_wrapper="sport-type filters-block__item"
                                                    :options="sportsList"
                                                    :selected-items="filter.selectedSportsList"
                                                    label="Выберите вид спорта"
                                                    @updateSelectedNull="filter.selectedSportsList = []; filter.sportId = null"/>

                                    <label class="pt-2 px-0">Регион</label>
                                    <v-select-items id="region" class_wrapper="sport-type filters-block__item"
                                                    :options="regionsList"
                                                    :selected-items="filter.selectedRegionsList"
                                                    label="Выберите регион"
                                                    @updateSelectedNull="filter.selectedRegionsList = []; filter.regionId = null"/>

                                    <label class="pt-2 px-0" for="peopleCount">Количество человек</label>
                                    <div class="sport-type filters-block__item" id="peopleCount">
                                        <div class="select-wrapper">
                                            <v-select class="selectpicker" :options="filterColPeople"
                                                      :items="filterColPeople"
                                                      textProp="title" valueProp="id" v-model="filter.colId"/>
                                        </div>
                                    </div>
                                    <label class="pt-2 px-0" for="price">Стоимость за ночь</label>
                                    <div class="sport-type filters-block__item" id="price">
                                        <div class="select-wrapper">
                                            <v-select class="selectpicker" :options="priceOfNight" :items="priceOfNight"
                                                      textProp="title" valueProp="id" v-model="filter.priceId"/>
                                        </div>
                                    </div>
                                    <div class="row row-col-2 m-0 pt-2 px-0">
                                        <div class="col col-6 inputWrapper">
                                            <label class="pt-2 px-0 " for="dateStart">Дата от</label>
                                            <input v-model="filter.dateStart" type="date" id="dateStart"
                                                   class="text-start w-100 d-block pt-2 filters__sortby borderblock bg-white inputInf show"
                                                   placeholder="01.01.2021">
                                        </div>
                                        <div class="col col-6 inputWrapper">
                                            <label class="pt-2 px-0" for="dateEnd">до</label>
                                            <input v-model="filter.dateEnd" :min="filter.dateStart" type="date"
                                                   class="text-start w-100 d-block pt-2 filters__sortby borderblock bg-white inputInf show"
                                                   placeholder="01.01.2021" id="dateEnd">
                                        </div>
                                    </div>
                                    <div v-show="isCustomer">
                                        <label class="d-flex float-left checkBox position-relative mt-3 mb-3
                                                align-items-center p-0">
                                            <input class="checkRequests d-none" type="checkbox"
                                                   v-model="filter.requests">
                                            <span class="mr-2 position-relative"></span>
                                            Показать только мои заявки ({{ tenders_statistic.myTendersCount }})
                                        </label>
                                    </div>
                                    <div v-show="isExecutor">
                                        <label class="d-flex float-left checkBox position-relative mt-3 mb-3
                                                align-items-center p-0">
                                            <input class="checkRequests d-none" type="checkbox"
                                                   v-model="filter.responses">
                                            <span class="mr-2 position-relative"></span>
                                            Показать только с моими откликами
                                            ({{ tenders_statistic.myResponsesTenderCount }})
                                        </label>
                                    </div>
                                    <button type="button" @click.prevent="resetFilter" class="button button-red d-block
                                             w-100 borderblock my-4">
                                        <p>Сбросить все фильтры</p>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tender-content content col col-12 col-lg-auto pb-5 px-5 px-lg-0 shadow">
                    <div class="container-fluid py-4 d-none d-lg-block bg-white px-4 p-0">
                        <p class="text-Blue opacity-7 d-lg-inline-block ">Сортировать по</p>
                        <div class="d-lg-inline-block filters__sortby inputInf dropdown show ">
                            <p class="dropdown-toggle text-Blue px-4 comboBox mr-4" href="#" role="button"
                               id="dropdownSort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ sortRules[filter.sortIndex].title }}
                            </p>
                            <div class="dropdown-menu fs-5 w-100 border-0  pt-0" aria-labelledby="dropdownSort">
                                <p class="dropdown-item text-Blue  py-3 borderBlockBottom"
                                   v-for="(rule, index) in sortRules"
                                   :key="rule.key" :value="rule.key"
                                   @click="filter.sortIndex  = index; sort_selected = rule.key">
                                    {{ rule.title }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="content__wrapper bg-light">
                        <div class="tenders-items">
                            <response-tender-modal :id="'sb-response-tender'" :ref="'sb-response-tender'"
                                                   :key="tender.id" modal_class="sb-response-tender"
                                                   :response-tender="tender" :edit_mode="response_edit_mode"
                                                   @getData="refreshData" @closeModal="closeModal"/>
                            <div class="pb-4 pt-2 tenders" v-for="item in tenders">
                                <tender-list :tender="item" :has-sport-objects="hasSportObjects" :key="item.id"
                                             @getTenders="getTenders"
                                             @showResponseTenderModal="showModal"/>
                            </div>
                        </div>
                        <paginator :offset="10" :pagination="pagination_data" @changePages="getTenders"/>
                    </div>
                </div>
            </div>
        </div>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from './NavBar.vue'
import extendedinf from './ExtendedFooterInformation.vue'
import responseTender from './requests/responseTender';
import MenuComponent from './profile/menuComponent';
import {mapActions, mapGetters, mapMutations} from "vuex";
import VSelect from "@alfsnd/vue-bootstrap-select";

import VueCompositionAPI from '@vue/composition-api';
import Paginator from "./Paginator";
import TenderList from "./TenderList";
import VSelectItems from "./elements/VSelectItems";
import ResponseTenderModal from "./tenders/ResponseTenderModal";
import axios from "axios";

Vue.use(VueCompositionAPI);


export default {
    data() {
        return {
            isCustomer: false,
            isExecutor: false,
            filterColPeople: [
                {id: 0, title: 'Любое', col: 0},
                {id: 1, title: 'до 100', col: 100},
                {id: 2, title: 'до 200', col: 200},
                {id: 3, title: 'до 500', col: 500},
                {id: 4, title: 'до 1000', col: 1000},
            ],
            priceOfNight: [
                {id: 0, title: 'Любая', col: 0},
                {id: 1, title: 'до 2000 руб', col: 2000},
                {id: 2, title: 'до 3000 руб', col: 3000},
                {id: 3, title: 'до 5000 руб', col: 5000},
                {id: 4, title: 'до 10000 руб', col: 10000},
            ],
            filter: {
                sportId: null,
                regionId: null,
                colId: {id: 0, title: "Любое", col: 0},
                priceId: {id: 0, title: "Любая", col: 0},
                price: null,
                dateStart: null,
                dateEnd: null,
                maxPrice: null,
                sortIndex: 0,
                searchTender: '',
                requests: false,
                responses: false,
                selectedSportsList: [],
                selectedRegionsList: []
            },
            sortRules: [
                {id: 1, key: 'new:desc', title: 'Сначала новые'},
                {id: 2, key: 'new:asc', title: 'Сначала старые'},
                {id: 3, key: 'minPrice:asc', title: 'Возрастанию цен'},
                {id: 4, key: 'minPrice:desc', title: 'Убыванию цен'},
                {id: 5, key: 'responses:asc', title: 'Количеству откликов'},
            ],
            sort_selected: null,
            tender: {},
            response_edit_mode: false,
            hasSportObjects: false,
            sportsList: [],
            regionsList: [],
        }
    },
    methods: {
        ...mapActions(["fetchSportTypes", "fetchRegions", "getTendersStatistic", "getFilteredTenders", "fetchRequirementInfrastructures"]),

        resetFilter() {
            this.filter = {
                sportId: null,
                regionId: null,
                colId: {id: 0, title: "Любое", col: 0},
                priceId: {id: 0, title: "Любая", col: 0},
                dateStart: null,
                dateEnd: null,
                sortIndex: 0,
                searchTender: '',
                requests: false,
                responses: false,
                selectedSportsList: [],
                selectedRegionsList: [],
            };
        },

        async getTenders(page = 1) {
            const {
                selectedSportsList,
                selectedRegionsList,
                colId,
                priceId,
                dateStart,
                dateEnd,
                searchTender,
                requests,
                responses
            } = this.filter;
            await this.$store.dispatch("getFilteredTenders", {
                page: page,
                filters: {
                    type: "verify",
                    total: 10,
                    searchTender: searchTender,
                    sports: selectedSportsList,
                    region: selectedRegionsList,
                    col: colId,
                    price: priceId,
                    dateStart: dateStart,
                    dateEnd: dateEnd,
                    requests: requests,
                    responses: responses,
                    sort: this.sort_selected,
                }
            });
            window.scrollTo(0, 0);
        },

        async getCountSportObjects() {
            try {
                const response = await axios.get('/api/users/sport-objects/count');
                this.hasSportObjects = response.data === 1;
            } catch (error) {
                console.error(error);
            }
        },

        showModal(request) {
            this.tender = request;
            this.response_edit_mode = request.myResponses_count >= 1;
        },

        closeModal() {
            $('#sb-response-tender').modal('toggle')
        },

        async refreshData() {
            $('#sb-response-tender').modal('toggle');
            await this.getTenders();
            await this.$store.dispatch('getTendersStatistic');
        },

        async initializeData() {
            await this.$store.dispatch("setTendersLoading", true);
            await Promise.all([
                this.fetchSportTypes(),
                this.fetchRegions(),
                this.getTendersStatistic(),
                this.getCountSportObjects(),
            ]);
            await this.$store.dispatch("setTendersLoading", false);

            this.sportsList = [{id: 0, title: 'Любой'}, ...this.items_sport_types];
            this.regionsList = [{id: 0, title: 'Любой'}, ...this.items_regions];
        }
    },

    async mounted() {
        if (this.user.role === 2) this.isCustomer = true;
        if (this.user.role === 3) this.isExecutor = true;

        await this.initializeData();
        this.getTenders();
    },

    computed: {
        ...mapGetters({
            tenders: 'AllTenders',
            tenders_statistic: 'tenders_statistic',
            items_sport_types: 'AllSportTypes',
            items_regions: 'AllRegions'
        }),
        user() {
            return window.user;
        },
        pagination_data() {
            return this.$store.getters.tenders_pagination;
        },
        tenders_loading() {
            return this.$store.getters.tenders_loading;
        }
    },

    watch: {
        filter: {
            handler() {
                this.getTenders(this.pagination_data ? this.pagination_data.currentPage : 1);
            },
            deep: true
        }
    },
    components: {
        ResponseTenderModal, VSelectItems, TenderList, Paginator, navbar, extendedinf, responseTender, MenuComponent,
        VSelect
    }
}
</script>
<style>
.content__tenderCatalog .comboBox {
    color: #6283E5;
}

.filters__Menu__options .dropdown-toggle,
.filters__Menu__options #dateStart,
.filters__Menu__options #dateEnd {
    font-weight: lighter;
    font-size: calc(1.06rem);
}

.search #search__input {
    font-size: calc(1.06rem);
}

.checkBox span {
    min-width: 21px;
    width: 24px;
    height: 23px;
    border: 1px solid #E4EBFE;
    border-radius: 5px;
}

.checkRequests[type=checkbox]:checked + span:before { /* <-- ставим иконку, когда чекбокс включен  */
    content: url('/icons/blueRectangle.svg');
    position: absolute;
    top: -17px;
    left: -21px;
    font-size: 23px;
}

.filters__Menu label {
    font-size: calc(1.125rem);
    font-weight: bold;
}

.content__wrapper .tenders-items {
    min-height: 555px;
}

@media (max-width: 991px) {
    .requiment .borderblock {
        border: 2px solid #bac4df;
    }

    .filters__Menu label {
        font-size: calc(1rem);
    }

    .wrapper.filter_sort {
        display: flex;
    }
}
</style>
