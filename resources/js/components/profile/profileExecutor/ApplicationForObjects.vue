<template>
    <div>
        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="directApplicationsLoading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <menu-component :active="2"></menu-component>
        <main class="proposal-card" style="min-height: 600px">
            <div class="container ctnPad pl-0">
                <div class="pt-3">
                    <h3>Заявки от заказчиков на аренду объектов</h3>
                </div>
            </div>

            <filters @updateData="fetchDirectApplications" @handleUpdate="fetchDirectApplications"
                     @update-filter="filter = $event" :filter-btn="filterBtn"/>

            <div class="p-4">
                <div class="sb-items_objects" style="min-height: 100vh">
                    <sb-direct-application :items="directApplications" @updateData="fetchDirectApplications"/>
                </div>

                <paginator :pagination="directApplicationsPagination" @changePages="changePages"
                           @changeColPages="changeColPages"/>
            </div>
        </main>
        <extendedinf/>
    </div>
</template>

<script>
import navbar from '../../NavBar'
import extendedinf from "../../ExtendedFooterInformation";
import VSelect from "@alfsnd/vue-bootstrap-select";
import MenuComponent from "../menuComponent";
import {mapActions, mapGetters} from "vuex";
import StarRating from 'vue-star-rating';
import Pagination from "../../Pagination";
import SbDirectApplication from "./SbDirectApplication";
import Filters from "../../Filters";
import Paginator from "../../Paginator";

export default {
    data: function () {
        return {
            objectsData: {perPage: 10, currentPage: 1, status: 'active'},
            filter: {
                minPrice: null, maxPrice: null, start_date: null, end_date: null, object: null, foods: [],
                services: [], infrastructures: [], accred: [],
            },
            filterBtn: [{title: 'Активные', isActive: true, stats: 0, status: 'active'},
                {title: 'Архив', isActive: false, stats: 0, status: 'archive'}],
        }
    },
    methods: {
        ...mapActions(["addToDirectArchive", "storeDealDirect",]),

        async fetchDirectApplications(status = this.objectsData.status, limit = this.objectsData.perPage,
                                      page = this.objectsData.currentPage, filter = this.filter) {
            this.objectsData.status = status;
            await this.$store.dispatch('fetchDirectRequests', { status, limit, page, filter });
            await this.$store.dispatch('getStatisticsByDirect').then(() => {
                this.filterBtn[0].stats = this.directStatistics.activeCount;
                this.filterBtn[1].stats = this.directStatistics.archiveCount;
            });
        },
        async changePages(page) {
            this.objectsData.currentPage = page;
            await this.fetchDirectApplications();
        },
        async changeColPages(limit) {
            this.objectsData.perPage = limit;
            await this.fetchDirectApplications();
        },
    },
    computed: {
        ...mapGetters({
            directApplicationsLoading: 'direct_applications_loading',
            directApplicationsPagination: 'direct_applications_pagination',
            directApplications: 'getDirectApplications',
            directStatistics: 'getDirectStatistic',
        }),
        user: function () {
            return window.user;
        },
    },
    created() {
        this.fetchDirectApplications();
    },
    components: {
        Paginator, Filters, SbDirectApplication, Pagination, MenuComponent, navbar, extendedinf, VSelect, StarRating
    },
}
</script>

<style scoped>
.sb-items_objects {
    min-height: 400px;
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
    min-width: 650px;
    border-radius: 5px;
}

#search-object-mobile {
    height: 45px;
    border-radius: 10px;
}

@media (max-width: 960px) {
    .sb-filter__block {
        width: auto;
    }

    .block-info-filter {
        margin: 0 1.5rem;
    }
}


</style>
