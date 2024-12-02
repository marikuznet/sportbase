<template>
    <div class="sb-direct-response">
        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="direct_applications_loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <menu-component :active="0"></menu-component>
        <main class="proposal-card" style="min-height: 600px;">
            <div class="container ctnPad pl-0">
                <div class="pt-3">
                    <h3 class="caption">Ваши заявки на аренду объектов</h3>
                </div>
            </div>
            <filters @updateData="getDirectApplications" @handleUpdate="getDirectApplications"
                     @update-filter="filter = $event" :filter-btn="filterBtn"/>

            <div class="p-4">
                <div class="sb-items_objects" style="min-height: 100vh">
                    <sb-direct-application :items="direct_applications" @updateData="getDirectApplications"/>
                </div>
                <paginator :pagination="direct_applications_pagination" @changePages="changePages"
                           @changeColPages="changeColPages"/>
            </div>

        </main>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from '../../NavBar'
import extendedinf from "../../ExtendedFooterInformation";
import VSelect from "@alfsnd/vue-bootstrap-select";
import MenuComponent from "./menuComponent";
import {mapActions, mapGetters} from 'vuex';
import RequestTitleTender from "../../RequestTitleTender";
import Filters from "../../Filters";
import Request from "../../Request";
import Pagination from "../../Pagination";
import SbDirectApplication from "../profileCustomer/SbDirectApplication";
import Paginator from "../../Paginator";

export default {
    data: function () {
        return {
            objects_data: {perPage: 10, currentPage: 1, status: 'active'},
            filter: {
                minPrice: null, maxPrice: null, start_date: null, end_date: null, object: null, foods: [],
                services: [], infrastructures: [], accred: [],
            },
            filterBtn: [{title: 'Активные', isActive: true, stats: 0, status: 'active'},
                {title: 'Архив', isActive: false, stats: 0, status: 'archive'}],
        }
    },
    methods: {
        async getDirectApplications(status = this.objects_data.status, limit = this.objects_data.perPage,
                                    page = this.objects_data.currentPage, filter = this.filter) {
            await this.$store.dispatch('fetchDirectRequests', {
                status: status, limit: limit, page: page, filter: filter
            });
            await this.$store.dispatch('getStatisticsByDirect').then(() => {
                this.filterBtn[0].stats = this.direct_statistics.activeCount;
                this.filterBtn[1].stats = this.direct_statistics.archiveCount;
            });
        },
        async changePages(page) {
            this.objects_data.currentPage = page;
            await this.getDirectApplications();
        },
        async changeColPages(limit) {
            this.objects_data.perPage = limit;
            await this.getDirectApplications();
        },
    },
    computed: {
        ...mapGetters({
            direct_applications_loading: 'direct_applications_loading',
            direct_applications: 'getDirectApplications',
            direct_applications_pagination: 'direct_applications_pagination',

            direct_statistics: 'getDirectStatistic',
        }),
        user: function () {
            return window.user;
        },
    },
    components: {
        Paginator, SbDirectApplication, Pagination, Request, Filters, RequestTitleTender, MenuComponent, navbar,
        extendedinf, VSelect,
    },
    created() {
        this.getDirectApplications();
    }
}
</script>

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
</style>
<style>
.logo-round {
    width: 40px;
    height: 40px;
    background-color: transparent;
}

.logo-round img {
    border-radius: 100%;
}
</style>
