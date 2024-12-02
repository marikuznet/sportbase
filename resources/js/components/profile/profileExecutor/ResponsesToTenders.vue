<template>
    <div>
        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="responses_tender_loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <menu-component :active="3"></menu-component>
        <main class="proposal-card" style="min-height: 600px">
            <div class="container ctnPad pl-0">
                <div class="pt-3">
                    <h3 class="caption">Отклики на тендеры</h3>
                </div>
            </div>
            <filters @updateData="getResponses" @handleUpdate="getResponses" @update-filter="filter = $event"
                     :filter-btn="filterBtn"/>
            <div class="tenders-content">
                <div class="container-request tender mb-4" v-for="tender in allResponses">
                    <div class="border-rounded container request-object p-0 pl-lg-0 pr-lg-0 pl-3 pr-3">
                        <div class="pr-lg-5 pl-lg-5 pt-3 pb-3">
                            <div class="titleObject pb-2 justify-content-between d-flex">
                                <div class="d-flex align-items-center">
                                    <p class="captionObject text-uppercase">Тендер №{{ tender.id }}
                                    </p>
                                    <div class="block__circle mr-2 ml-2">
                                        <img alt="logo" :src="'/storage/listings/logos/' + tender.customer_info.user_id
                                                     + '/' + tender.customer_info.logo">
                                    </div>
                                    <p class="ispr">{{ tender.customer_info.title }}</p>
                                </div>
                                <div class="d-flex">
                                    <button type="button" style="border-radius: 10px; width: 50px"
                                            class="shadow sb-button-blue button-icon emailSvg blue mr-2 h-100">
                                        <svg id="email" xmlns="http://www.w3.org/2000/svg" width="20.76"
                                             height="15.206" viewBox="0 0 20.76 15.206">
                                            <path style="fill: #6283E5" id="Контур_44478" data-name="Контур 44478"
                                                  d="M18.136,24.61H2.624A2.627,2.627,0,0,0,0,27.234v9.959a2.627,2.627,0,0,0,2.624,2.624H18.136a2.627,2.627,0,0,0,2.624-2.624V27.234A2.627,2.627,0,0,0,18.136,24.61Zm-.41,1.692L10.38,31.977,3.033,26.3Zm.41,11.822H2.624a.932.932,0,0,1-.931-.931V27.4l8.17,6.311a.846.846,0,0,0,1.035,0l8.17-6.311v9.788A.932.932,0,0,1,18.136,38.124Z"
                                                  transform="translate(0 -24.61)" fill="#fff"/>
                                        </svg>
                                        <!--<div class="notification-block">
                                            12
                                        </div>!-->
                                    </button>
                                    <div v-if="false"
                                         class="border-green mr-2 d-none d-lg-flex justify-content-center
                                         align-items-center">
                                        <span class="pl-2 pr-2">Выбран исполнителем</span>
                                    </div>

                                    <div data-toggle="collapse" :data-target="'#tender-'+tender.id"
                                         aria-expanded="false" style="cursor:pointer"
                                         class="arrow-button d-none d-lg-flex justify-content-center shadow">
                                        <img width="20px" src="/icons/downArrowRed.svg" alt="arrow">
                                    </div>
                                    <div data-toggle="collapse" :data-target="'#tender-'+tender.id"
                                         aria-expanded="false" style="cursor:pointer; width: 36px; height: 36px"
                                         class="arrow-button d-flex d-lg-none justify-content-center shadow">
                                        <img width="13px" src="/icons/downArrowRed.svg" alt="arrow">
                                    </div>
                                </div>
                            </div>
                            <request-title-tender :show-rating="false" :prop_tender="tender"/>
                        </div>

                        <div :id="'tender-' + tender.id" class="collapse info-full-request-object pr-lg-5 pl-lg-5"
                             style="border: none !important; border-top: 1px solid lightgray !important;">
                            <div class="response">
                                <div class="info-full-request-object pt-4 pb-4"
                                     style="border: none !important; background-color: white">
                                    <ResponseTenderModal v-if="selectedResponse"
                                                         :id="'sb-response-tender-' + selectedResponse.id"
                                                         :ref="'sb-response-tender-' + selectedResponse.id"
                                                         :key="'edit-' + selectedResponse.id"
                                                         modal_class="sb-response-tender"
                                                         :response-tender="selectedResponse" :edit_mode="true"
                                                         @getData="saveResponse(selectedResponse.id)"
                                                         @closeModal="closeModalEdit(selectedResponse.id)"/>
                                    <ModalInfoObject v-if="tender" :tender="tender"></ModalInfoObject>
                                    <template v-for="response in filteredResponses(tender)">
                                        <ResponseTenderProfile :key="response.id" :response="response"
                                                               @refreshData="refreshData"
                                                               @closeModal="closeModal"
                                                               @setSelectedResponse="setSelectedResponse($event)"/>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <paginator :offset="responses_data.perPage" :pagination="responses_tender_pagination"
                       @changePages="changePages" @changeColPages="changeColPages"/>
        </main>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from '../../NavBar'
import extendedinf from "../../ExtendedFooterInformation";
import VSelect from "@alfsnd/vue-bootstrap-select";
import MenuComponent from "../menuComponent";
import {mapGetters} from "vuex";
import VueCompositionAPI from '@vue/composition-api';
import Slider from '@vueform/slider/dist/slider.vue2.js';
import RequestTitleTender from "../../RequestTitleTender";
import Vue from "vue";
import Paginator from "../../Paginator";
import Filters from "../../Filters";
import StarRating from 'vue-star-rating';
import * as moment from "moment";
import ResponseTenderModal from "../../tenders/ResponseTenderModal";

import ModalInfoObject from "./ModalInfoObject";
import ResponseTenderProfile from "./ResponseTenderProfile";

Vue.use(VueCompositionAPI);

export default {
    data: function () {
        return {
            filter: {
                minPrice: null, maxPrice: null, start_date: null, end_date: null, objects: [], foods: [],
                services: [], infrastructures: [], accred: [], search: null
            },
            filterBtn: [{title: 'Активные', isActive: true, stats: 0, status: 'active'},
                {title: 'Архив', isActive: false, stats: 0, status: 'archive'}],
            responses_data: {status: 'active', perPage: 10, currentPage: 1},
            selectedResponse: null
        }
    },
    methods: {
        async getResponses(status = this.responses_data.status, limit = this.responses_data.perPage,
                           page = this.responses_data.currentPage, filter = this.filter) {
            this.responses_data.status = status;
            await this.$store.dispatch('fetchResponsesTender', {
                status: status, limit: limit, page: page, filter: filter
            });
        },
        async changePages(page) {
            this.responses_data.currentPage = page;
            await this.getResponses();
        },
        async changeColPages(limit) {
            this.responses_data.perPage = limit;
            await this.getResponses();
        },
        getStatusArchiveResponseTender(date) {
            return moment(date).isAfter(moment().format(), 'day');
        },
        async refreshData() {
            $('#sb-response-tender').modal('toggle')
            const actions = [
                await this.getResponses(),
                this.$store.dispatch('getResponsesStatistic').then(() => {
                    this.filterBtn[0].stats = this.responses_tender_statistic.activeCount;
                    this.filterBtn[1].stats = this.responses_tender_statistic.archiveCount;
                }),
            ];
            await Promise.all(actions);
        },
        closeModal() {
            $('#sb-response-tender').modal('toggle')
        },
        filteredResponses(tender) {
            return tender.responses.filter(response => {
                if (this.responses_data.status === 'active') {
                    return [0, 1].includes(response.archive) || (!this.getStatusArchiveResponseTender(response.fullStartDate));
                } else if (this.responses_data.status === 'archive') {
                    return [2, 3, 4].includes(response.archive) || !this.getStatusArchiveResponseTender(response.fullStartDate);
                }
                return false;
            });
        },
        setSelectedResponse($event) {
            this.selectedResponse = $event;
        },
        saveResponse(id) {
            this.refreshData();
            $(`#sb-response-tender-${id}`).modal('toggle');
        },
        closeModalEdit(id) {
            $(`#sb-response-tender-${id}`).modal('toggle')
        },
    },
    mounted() {
        const actions = [
            this.getResponses(),
            this.$store.dispatch('getResponsesStatistic').then(() => {
                this.filterBtn[0].stats = this.responses_tender_statistic.activeCount;
                this.filterBtn[1].stats = this.responses_tender_statistic.archiveCount;
            }),
            this.$store.dispatch('fetchInfoCompanies')
        ];
        Promise.all(actions);
    },
    computed: {
        ...mapGetters({
            allResponses: 'AllResponses',
            responses_tender_loading: 'responses_tender_loading',
            responses_tender_pagination: 'responses_tender_pagination',
            responses_tender_statistic: 'responses_tender_statistic',

            infoCompanies: 'AllInfoCompanies',
        }),
        user: function () {
            return window.user;
        },
        getInfo() {
            if (this.infoCompanies)
                return this.infoCompanies.id;
        },
    },
    components: {
        ModalInfoObject, ResponseTenderProfile, ResponseTenderModal,
        Filters, Paginator, StarRating, RequestTitleTender, MenuComponent, navbar, extendedinf, VSelect, Slider
    },
}
</script>
<style>
#typeSport.is-invalid .v-select-toggle,
#region.is-invalid .v-select-toggle {
    border: 1px solid #e45868 !important;
}
</style>

<style scoped>
.tenders-content {
    min-height: 400px;
}

#typeSport.is-invalid,
#region.is-invalid {
    border: none !important;
}

#overlay {
    z-index: 999;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.2);
}

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

.button-border {
    color: #6283E5;
}

#search-object {
    height: 45px;
    min-width: 650px;
    border-radius: 5px;
}

#search-object-mobile {
    height: 45px;
    border-radius: 10px;
}

input[type=date]::-webkit-calendar-picker-indicator {
    display: none;
}

</style>
