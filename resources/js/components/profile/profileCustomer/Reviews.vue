<template>
    <div>
        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="reviews_loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <menu-component-customer v-if="user.role === 2" active="3"></menu-component-customer>
        <menu-component-executor v-if="user.role === 3" active="4"></menu-component-executor>
        <main class="proposal-card" style="min-height: 600px">
            <div class="container ctnPad pl-0">
                <div class="pt-3">
                    <h3 class="caption">Отзывы о сотрудничестве</h3>
                </div>
            </div>
            <filters @updateData="getReviews" @handleUpdate="getReviews" @update-filter="filter = $event"/>
            <div>
                <div class="container p-0 mt-3 order" style="min-height: 300px">
                    <view-rating v-show="showRating" :get-review="getReview" :id-review="idReview"/>
                    <div class="container request-object p-0 mb-4" style="border-radius: 10px" v-for="deal in reviews">
                        <div class="order pl-5 pr-5 pt-4" v-if="user.role === 3">
                            <div class="titleObject numOrder pb-2 justify-content-between align-items-center d-flex">
                                <p class="captionObject text-uppercase">Заказ №<span>{{ deal.id }}</span>
                                </p>
                            </div>
                            <div class="executor-object">
                                <div class="title-info d-flex flex-wrap pr-2 pt-2 pb-2 justify-content-between">
                                    <div class="logo d-flex align-items-center">
                                        <p class="ispr">Заказчик</p>
                                        <div class="logo__circle mr-2 ml-2" style="width: 40px; height: 40px">
                                            <img class="h-100 w-100" style="border-radius: 100%"
                                                 :src="'/storage/listings/logos/' + deal.user_customer_info.user_id
                                                     + '/' + deal.user_customer_info.logo">
                                        </div>
                                        <p style="color: #6283E5 !important" class="ispr">{{
                                                deal.user_customer_info.title
                                            }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order pl-5 pr-lg-5 pt-4" v-else-if="user.role === 2">
                            <div class="titleObject numOrder pb-2 justify-content-between align-items-center d-flex">
                                <p class="captionObject text-uppercase">Заказ номер №{{ deal.id }}</p>
                                <div
                                    class="align-items-center block-moderation d-flex position-relative border-radius__10">
                                    <p v-if="!deal.review" class="captionObject">новый</p>
                                    <p v-if="deal.review" class="captionObject"
                                       :style="'color: '+ moderationReviews.filter(p => p.id === deal.review.status)[0].color">
                                        {{ moderationReviews.filter(p => p.id === deal.review.status)[0].title }}</p>
                                    <div
                                        v-if="deal.review && moderationReviews.filter(p => p.id === deal.review.status)[0].edit"
                                        class="moderation-review">
                                        <button class="align-items-center d-flex h justify-content-center ml-2"
                                                data-toggle="collapse" :data-target="'#collapseAction-'+deal.review.id">
                                            <i class="fa fa-info"></i>
                                        </button>
                                        <div class="show-delete_menu ml-2 collapse position-absolute"
                                             :id="'collapseAction-'+deal.review.id">
                                            <p class="cursor-pointer"
                                               @click="editableReview = true; idReview = deal.review.id">
                                                Редактировать</p>
                                            <p class="cursor-pointer" @click="deleteReview(deal.review.id)">Удалить</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="executor-object">
                                <div class="title-info d-flex flex-wrap pr-2 pt-2 pb-2 justify-content-between">
                                    <div class="logo d-flex align-items-center">
                                        <p class="ispr">Исполнитель</p>
                                        <div class="logo__circle mr-2 ml-2" style="width: 40px; height: 40px">
                                            <img class="h-100 w-100" style="border-radius: 100%"
                                                 :src="'/storage/listings/logos/' + deal.user_executor_info.user_id
                                                     + '/' + deal.user_executor_info.logo">
                                        </div>
                                        <p style="color: #6283E5 !important" class="ispr">
                                            {{ deal.user_executor_info.title }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container inRequestObject ml-4 p-4 mr-4 mb-2 w-auto" style="border-radius: 10px">
                            <div class="titleObject pb-2 justify-content-between d-lg-flex d-none">
                                <p class="captionObject text-uppercase">{{ deal.sportObject.title }}
                                    <span class="pl-3 text-nowrap text-muted text-lowercase objectId">
                                        id {{ deal.sportObject.id }}
                                    </span>
                                </p>
                                <div class="rating-messages d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div class="rating align-items-center col-auto d-flex">
                                            <div class="d-flex">
                                                <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                             :showRating="false"
                                                             :rating="deal.sportObject.average_rating"
                                                             :read-only="true"/>
                                                <div>
                                                    <p>{{ deal.sportObject.average_rating | formatRating }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="align-items-center col-auto d-flex">
                                            <div class="d-flex">
                                                <img class="pr-1" src="/icons/direct/chat.svg">
                                                <div class="d-flex align-items-center">
                                                    <p>{{ deal.sportObject.reviews_count }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="info-request-object d-flex flex-wrap justify-content-between align-items-center">
                                <div class="d-lg-flex d-none pb-3">
                                    <div class="left d-flex">
                                        <div class="create mr-2">
                                            <div class="title d-flex pb-2">
                                                <img src="/icons/direct/XMLID_14_.svg">
                                                <p class="pl-3 caption">Создана</p>
                                            </div>
                                            <div class="field-green">
                                                <p class="text-nowrap d-flex">{{
                                                        getDate(deal.deal_date_ago)
                                                    }}</p>
                                            </div>
                                        </div>
                                        <div class="create address mr-2 d-none d-lg-block">
                                            <div class="title d-flex pb-2">
                                                <p class="caption">Адрес</p>
                                            </div>
                                            <div class="field-green d-flex">
                                                <p class="text-nowrap caption">
                                                    {{
                                                        deal.sportObject.country + ", " + deal.sportObject.city
                                                        + ", " + deal.sportObject.address
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-lg-none pb-3 w-100">
                                    <div class="create">
                                        <div class="title d-flex pb-2 align-items-end">
                                            <img src="/icons/direct/XMLID_14_.svg">
                                            <p style="font-size: calc(0.875rem);" class="pl-2 caption">Создана</p>
                                        </div>
                                        <div class="field-green mb-3" style="max-width: 120px !important;">
                                            <p class="text-nowrap d-flex">{{ getDate(deal.deal_date_ago) }}</p>
                                        </div>
                                    </div>
                                    <div class="create mobile-address mr-2 mb-3">
                                        <div class="title d-flex">
                                            <p class="caption">Адрес</p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="subtitle text-nowrap">{{
                                                    deal.sportObject.country + ", " + deal.sportObject.city
                                                    + ", " + deal.sportObject.address
                                                }}</p>
                                        </div>
                                    </div>
                                    <div class="rating-messages mb-3 pt-0 justify-content-between">
                                        <div class="d-flex">
                                            <div class="rating align-items-center col-auto d-flex">
                                                <div class="d-flex">
                                                    <star-rating :increment="0.5" :starSize="18"
                                                                 :activeColor="'#F5AE67'"
                                                                 :showRating="false"
                                                                 :rating="deal.sportObject.average_rating"
                                                                 :read-only="true"></star-rating>
                                                    <div>
                                                        <p>{{ deal.sportObject.average_rating.toPrecision(3) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="align-items-center col-auto d-flex">
                                                <div class="d-flex">
                                                    <img class="pr-1" src="/icons/direct/chat.svg">
                                                    <div class="d-flex align-items-center">
                                                        <p>{{ deal.sportObject.reviews_count }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="deal.review" class="p-0 ml-5 mr-5 mb-5 d-lg-flex d-none">
                            <div class="review mr-2">
                                <div class="title d-flex pb-2">
                                    <p class="caption">Отзыв</p>
                                </div>
                                <div class="rating d-block p-4 shadow" data-toggle="modal"
                                     data-target="#view-detail-rating"
                                     @click="showModalRating(deal.review, deal.review.id)">
                                    <p class="text-nowrap d-flex">Оценка суммарная</p>
                                    <div class="align-items-center d-flex">
                                        <div class="d-flex">
                                            <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                         :showRating="false" :rating="deal.review.average"
                                                         :read-only="true"></star-rating>
                                            <div class="ml-3">
                                                <p style="font-size: calc(1.375rem)">{{
                                                        deal.review.average
                                                    }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="review mr-2 w-75">
                                <div class="title d-flex pb-2">
                                    <p class="caption">Текст отзыва</p>
                                </div>
                                <div class="text p-4">
                                    <p class="d-flex">
                                        {{ deal.review.text.replace(/<\/?[^>]+(>|$)/g, "") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div v-if="deal.review" class="d-lg-none review mb-5 ml-4 mr-4">
                            <div class="rating w-100 p-4 mb-3 text-center">
                                <p>Оценка суммарная</p>
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex">
                                        <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                     :showRating="false" :rating="deal.review.average"
                                                     :read-only="true"/>
                                        <div class="ml-3">
                                            <p style="font-size: calc(1.375rem)">
                                                {{ deal.review.average }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="caption text-center mb-3">Текст отзыва</p>
                            <div class="rating border-0">
                                <div class="text p-4">
                                    <p class="d-flex" style="font-size: calc(0.875rem);">
                                        {{ deal.review.text.replace(/<\/?[^>]+(>|$)/g, "") }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <review :editable-review-data="editableReview" :initial-review-data="deal.review"
                                :is-personal-account="true"
                                :review-id="idReview" :can-add-review="!deal.review" @getReviews="getReviews"
                                :deal-id="deal.id" @closeEditor="closeReview"/>
                    </div>
                </div>

                <div class="container p-0 mt-5 mb-5">
                    <paginator :offset="reviews_pagination.limit" :pagination="reviews_pagination"
                               @changePages="changePages" @changeColPages="changeColPages"/>
                </div>
            </div>
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
import {mapActions, mapGetters} from "vuex";
import StarRating from 'vue-star-rating'
import moment from "moment";
import ViewRating from "../../ViewRating";
import Review from "../../deal/Review";
import Filters from "../../Filters";
import Paginator from "../../Paginator";

export default {
    data: function () {
        return {
            showRating: false, getReview: null, idReview: null,
            editableReview: false,
            moderationReviews: [{id: 0, title: 'на модерации', edit: true, color: '#0B3158'},
                {id: 1, title: 'одобрен', edit: false, color: '#6FB77F'},
                {id: 2, title: 'отклонен', edit: true, color: '#E45868'}],
            reviews_data: {status: 'executor', limit: 10, page: 1},
            filter: {
                minPrice: null, maxPrice: null, start_date: null, end_date: null, objects: [], foods: [],
                services: [], infrastructures: [], accred: [], search: null
            },
        }
    },
    computed: {
        ...mapGetters({
            reviews_loading: 'getReviewsLoading',
            reviews_pagination: 'getReviewsPagination',
        }),
        user: function () {
            return window.user;
        },
        reviews() {
            return this.$store.getters.getReviews;
        }
    },
    methods: {
        ...mapActions(["delDealReview"]),
        async getReviews(status = this.reviews_data.status, limit = this.reviews_data.limit, page = this.reviews_data.currentPage, filter = this.filter) {
            await this.$store.dispatch('getReviews', {
                status: this.user.role === 2 ? 'customer' : 'executor', limit: limit, page: page, filter: filter
            });
        },
        getDate(date) {
            return moment(moment(date)).format('LL') + " в " + moment(moment(date)).format('LT');
        },
        showModalRating(review, idReview) {
            this.showRating = true;
            this.getReview = review;
            this.idReview = idReview;
        },
        deleteReview(id) {
            this.$store.dispatch("delDealReview", {id: id}).then(() => {
                this.getReviews()
            });
        },
        closeReview() {
            this.editableReview = false;
        },
        async changePages(page) {
            this.reviews_data.page = page;
            await this.getReviews();
        },
        async changeColPages(limit) {
            this.reviews_data.limit = limit;
            await this.getReviews();
        },
    },
    mounted() {
    },
    created() {
        if (this.user.role === 3) {
            this.reviews_data.status = 'executor';
            this.getReviews();
        } else if (this.user.role === 2) {
            this.reviews_data.status = 'customer';
            this.getReviews();
        }
    },
    components: {
        Paginator, Filters, Review, ViewRating, MenuComponentExecutor, MenuComponentCustomer,
        navbar, extendedinf, VSelect, StarRating
    },
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

.review .title p {
    font-weight: bold;
    font-size: calc(1.25rem);
}

.review .rating {
    border: 1px solid #BAC4DF;
    border-radius: 10px;
}

.review .rating p {
    font-size: calc(1.125rem);
    color: #0B3158;
}

.review .text {
    border: 1px solid #BAC4DF;
    border-radius: 10px;
    background-color: #F2F5FF;
}

.review .text p {
    color: #0B3158;
    font-size: calc(1.125rem);
}

.btn-review button {
    width: 280px;
}

.blockPages {
    justify-content: space-between;
}

.titleObject .block-moderation {
    border: 1px solid #BAC4DF;
    padding: 2px 10px;
}

.moderation-review button {
    width: 20px;
    height: 20px;
    background-color: transparent;
    border: 1px solid grey;
}

.moderation-review .show-delete_menu {
    border: none;
    border-bottom: 1px solid grey;
    left: 69px;
    top: 37px;
    transition: all ease 0.8s;
}

.moderation-review .show-delete_menu p {
    border-bottom: 1px solid grey;
}

@media (max-width: 960px) {
    .blockPages {
        justify-content: center !important;
    }

    .order {
        margin-left: 1.5rem !important;
        margin-right: 1.5rem !important;
        padding-left: 0 !important;
        width: auto;
    }

    .request-object {
        padding-bottom: 0 !important;
    }

    .inRequestObject {
        border: 1px solid #BAC4DF;
        margin-right: 1.5rem !important;
        margin-left: 1.5rem !important;
    }

    .logo-company {
        width: 30px;
        margin-right: 1rem;
    }

    .request-object .captionObject {
        font-size: calc(0.94rem) !important;
    }

    .review .rating p {
        font-size: calc(0.875rem);
    }

    .rating img {
        width: 16px;
    }

    .btn-review button {
        font-size: calc(1rem);
    }
}
</style>
