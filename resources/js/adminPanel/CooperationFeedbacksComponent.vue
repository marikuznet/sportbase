<template>
    <div class="mr-5 ml-5">
        <div class="d-flex justify-content-between p-1rem px-3">
            <div class="justify-content-left">
                <p style="margin-top:10px;margin-bottom:10px;">Отзывы
                    <span v-if="isModerating === true"> (На модерации)</span>
                    <span v-else-if="isModerating === false"> (Отклонённые)</span>
                    <span v-else> (Одобренные)</span>
                </p>
            </div>
            <div class="justify-content-right text-right">
                <a class="btn btn-outline-info btn-left"
                   :class="{'btn-active btn-info': isModerating && isModerating != null}"
                   href="/admin/cooperation_feedbacks_moderating">На модерации
                    ({{ feedbacks_moderating_count }})</a>
                <a style="margin-left:-4px" class="btn btn-outline-info btn-center"
                   href="/admin/cooperation_feedbacks_refused"
                   :class="{'btn-active btn-info': !isModerating && isModerating != null}">
                    Отклонённые ({{ feedbacks_refused_count }})
                </a>
                <a style="margin-left:-4px" class="btn btn-outline-info btn-right"
                   :class="{'btn-active btn-info': isModerating === null}"
                   href="/admin/cooperation_feedbacks_accepted">Одобренные ({{ feedbacks_accepted_count }})</a>
            </div>
        </div>
        <div class="mfs-3 w-100 mt-3">
            <div class="row w-100 mt-3">
                <div class="col justify-content-right text-right">
                    <a class="btn btn-primary btn-active m-t-b-5" v-on:click="showFiltersBlock=!showFiltersBlock"><i
                        class="cil-filter"></i> Фильтр</a>
                </div>
            </div>
            <div v-if="false" class="mfs-r-3" v-show="showFiltersBlock">
                <div class="card card-body">
                    <div class="container">
                        <div class="row w-100">
                            <div class="col"></div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="ccmonth">Предоставляемое питание</label>
                                    <select class="w-100 form-control" id="ccmonth">
                                        <option>Любое</option>
                                        <option>9</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="ccmonth">Предоставляемые услуги</label>
                                    <select class="w-100 form-control" id="ccmonth">
                                        <option>Любые</option>
                                        <option>12</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        <div class="row mt-3 w-100">
                            <div class="col"></div>
                            <div class="col">
                                <label for="ccmonth">Инфраструктура</label>
                                <select class="w-100 form-control" id="ccmonth">
                                    <option>Любая</option>
                                    <option>12</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="ccmonth">Наличие акредитации <b><u>Минспорта</u></b></label>
                                <select class="w-100 form-control" id="ccmonth">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                </select>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mfs-r-3 mfs-3">
            <div class="overflow-auto">
                <ViewRating v-if="selectedReview" :get-review="selectedReview" :id-review="selectedReview.id"/>
                <modal-notification v-if="selectedReview && selectedReview.id" id="sb-notification-review-delete"
                                    modal_class="sb-notification" title="Отклонить отзыв"
                                    content="Вы действительно хотите отклонить отзыв?"
                                    @left_action="refuseReview(selectedReview.id)"
                                    @right_action="closeModalDeleteReview()"
                                    left_button="ДА" right_button="НЕТ">
                    <template #body>
                        <p>Вы подтверждаете отклонение отзыва ID: {{ selectedReview.id }}?</p>
                        <label class="d-flex float-left">
                            <input @change="changeShowReason" class="checkService d-none"
                                   type="checkbox"/>
                            <span class="reason-checkbox-border position-relative"></span>
                            <p class="textForCheckBox reason-checkbox">указать причину отклонения</p>
                        </label>
                        <textarea v-model="reasonDeleteReview" :disabled="!isShowReasonField" name="text-review"
                                  id="text-review" cols="30" rows="5"
                                  class="form-control"></textarea>
                    </template>
                </modal-notification>
                <modal-notification v-if="selectedReview && selectedReview.reasonDeleted"
                                    id="sb-notification-reason-cancelled" modal_class="sb-notification"
                                    title="Причина отклонения"
                                    :content="selectedReview.reasonDeleted">
                    <template #footer>
                        <div class="mb-3 text-center">
                            <a @click="closeModalReasonDelete" href="javascript:void(0);" style="color: red; font-size: 18px;">ЗАКРЫТЬ</a>
                        </div>
                    </template>
                </modal-notification>

                <div class="block-review mb-5" v-for="review in paginatedFeedbacks" v-if="review">
                    <div class="order pl-5 pr-5 pt-4">
                        <div class="titleObject numOrder pb-2 justify-content-between align-items-center d-flex">
                            <p class="captionObject text-uppercase">Заказ номер №<span>{{ review.deal.id }}</span>
                            </p>
                            <div class="align-items-center block-moderation d-flex position-relative">
                                <div v-if="IsModerating == null" class="moderation-review">
                                    <p style="color: green">одобрен</p>
                                </div>
                                <div v-else-if="IsModerating == false" class="moderation-review">
                                    <a @click="showModalReasonCancelled(review)" href="javascript:void(0);"
                                       style="color: red">отклонен</a>
                                </div>
                                <div v-else class="moderation-review">
                                    <a @click="showModalDeleteReview(review)" class="mr-3"
                                       style="color: red !important;"
                                       href="javascript:void(0);">
                                        <i class="fas fa-2x fa-minus-square"></i>
                                    </a>
                                    <a @click="editableReview = true; dataReview = review" class="mr-3"
                                       style="color: lightblue !important;" href="javascript:void(0);">
                                        <i class="fa fa-2x fa-edit"></i>
                                    </a>
                                    <a @click="verifyReview(review.id)" style="color: green !important;" href="javascript:void(0);">
                                        <i class="fas fa-2x fa-check-square"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="executor-object">
                            <div class="title-info d-flex flex-wrap pr-2 pt-2 pb-2 justify-content-between">
                                <div class="logo d-flex align-items-center">
                                    <p class="ispr m-0">Заказчик</p>
                                    <div class="logo__circle mr-2 ml-2" style="width: 40px; height: 40px">
                                        <img class="h-100 w-100" style="border-radius: 100%"
                                             :src="'/storage/listings/logos/' + review.user_customer_info.user_id
                                             + '/' + review.user_customer_info.logo">
                                    </div>
                                    <p style="color: #6283E5 !important" class="ispr m-0">
                                        {{ review.user_customer_info.title }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container inRequestObject ml-5 mr-5 mb-2 w-auto pt-4 pb-4 pl-0"
                         style="border-radius: 10px">
                        <div class="titleObject pb-2 justify-content-between d-lg-flex d-none">
                            <p class="captionObject text-uppercase">{{ review.sportObject.title }}
                                <span class="pl-3 text-nowrap text-muted text-lowercase objectId">id {{
                                        review.sportObject.id
                                    }}</span>
                            </p>
                            <div class="rating-messages d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="rating align-items-center col-auto d-flex">
                                        <div class="d-flex">
                                            <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                         :showRating="false"
                                                         :rating="review.sportObject.average_rating"
                                                         :read-only="true"/>
                                            <div>
                                                <p class="m-0">{{
                                                        review.sportObject.average_rating | formatRating
                                                    }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="align-items-center col-auto d-flex">
                                        <div class="d-flex">
                                            <img class="pr-1" src="/icons/direct/chat.svg">
                                            <div class="d-flex align-items-center">
                                                <p class="m-0">{{ review.sportObject.reviews_count }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info-request-object d-flex flex-wrap justify-content-between align-items-center">
                            <div class="d-lg-flex d-none pb-3">
                                <div class="left d-flex">
                                    <div class="create mr-2">
                                        <div class="title d-flex pb-2">
                                            <img src="/icons/direct/XMLID_14_.svg">
                                            <p class="pl-3 caption">Создана</p>
                                        </div>
                                        <div class="field-green">
                                            <p class="caption m-0 p-2 text-nowrap">{{
                                                    getDate(review.deal.deal_date_ago)
                                                }}</p>
                                        </div>
                                    </div>
                                    <div class="create address mr-2 d-none d-lg-block">
                                        <div class="title d-flex pb-2">
                                            <p class="caption">Адрес</p>
                                        </div>
                                        <div class="field-green d-flex">
                                            <p class="caption m-0 p-2 text-nowrap">
                                                {{
                                                    review.sportObject.country + ", " + review.sportObject.city
                                                    + ", " + review.sportObject.address
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-lg-none pb-3 w-100">
                                <div class="create">
                                    <div class="title d-flex pb-2 align-items-end">
                                        <img src="/icons/direct/XMLID_14_.svg" alt="">
                                        <p style="font-size: calc(0.875rem);" class="pl-2 caption">Создана</p>
                                    </div>
                                    <div class="field-green mb-3" style="max-width: 120px !important;">
                                        <p class="caption m-0 p-2 text-nowrap">
                                            {{ getDate(review.deal.deal_date_ago) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="create mobile-address mr-2 mb-3">
                                    <div class="title d-flex">
                                        <p class="caption">Адрес</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="subtitle text-nowrap">{{
                                                review.sportObject.country + ", " + review.sportObject.city
                                                + ", " + review.sportObject.address
                                            }}</p>
                                    </div>
                                </div>
                                <div class="rating-messages mb-3 pt-0 justify-content-between">
                                    <div class="d-flex">
                                        <div class="rating align-items-center col-auto d-flex">
                                            <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                         :showRating="false" :rating="review.sportObject.average_rating"
                                                         :read-only="true"/>
                                            <div>
                                                <p class="m-0">
                                                    {{ review.sportObject.average_rating.toPrecision(3) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="align-items-center col-auto d-flex">
                                            <div class="d-flex">
                                                <img class="pr-1" src="/icons/direct/chat.svg" alt="icon-chat">
                                                <div class="d-flex align-items-center">
                                                    <p class="m-0">0</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-0 ml-5 mr-5 mb-5 d-lg-flex d-none">
                        <div class="review mr-2">
                            <div class="title d-flex pb-2">
                                <p class="caption">Отзыв</p>
                            </div>
                            <div class="rating rating-detailed d-block p-4 shadow"
                                 @click="showModalRating(review, review.id)">
                                <p class="text-nowrap d-flex">Оценка суммарная</p>
                                <div class="align-items-center d-flex">
                                    <div class="d-flex">
                                        <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                     :showRating="false" :rating="review.average"
                                                     :read-only="true"/>
                                        <div class="ml-3">
                                            <p style="font-size: calc(1.375rem)">{{ review.average.toFixed(2) }}</p>
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
                                    {{ review.text.replace(/<\/?[^>]+(>|$)/g, "") }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="d-lg-none review mb-5 ml-4 mr-4">
                        <div class="rating w-100 p-4 mb-3 text-center" @click="showModalRating(review, review.id)">
                            <p>Оценка суммарная</p>
                            <div class="d-flex justify-content-center">
                                <div class="d-flex">
                                    <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                 :showRating="false" :rating="review.average"
                                                 :read-only="true"></star-rating>
                                    <div class="ml-3">
                                        <p style="font-size: calc(1.375rem)">{{ review.average.toFixed(2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="caption text-center mb-3">Текст отзыва</p>
                        <div class="rating border-0">
                            <div class="text p-4">
                                <p class="d-flex" style="font-size: calc(0.875rem);">
                                    {{ review.text.replace(/<\/?[^>]+(>|$)/g, "") }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <review v-if="editableReview" :editable-review-data="editableReview"
                            :initial-review-data="dataReview" :review-id="review.id" :can-add-review="!review"
                            :deal-id="review.deal.id" @closeEditor="closeReview" :is-admin="true"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TableComponent from '../adminPanel/TableComponent.vue';
import {mapActions, mapGetters} from "vuex";
import Review from "../components/deal/Review";
import moment from "moment";
import StarRating from 'vue-star-rating'
import ViewRating from "../components/ViewRating";

export default {
    components: {ViewRating, Review, TableComponent, StarRating},
    props: ['isModerating'],
    data() {
        return {
            moderating: null,
            showFiltersBlock: false, indexReview: null,
            editableReview: false, dataReview: null,
            selectedReview: null,
            isShowReasonField: false,
            reasonDeleteReview: ""
        }
    },
    computed: {
        ...mapGetters({
            feedbacks_moderating: 'AllFeedbacksModerating',
            feedbacks_moderating_count: 'AllFeedbacksModeratingCount',
            feedbacks_accepted: 'AllFeedbacksAccepted',
            feedbacks_accepted_count: 'AllFeedbacksAcceptedCount',
            feedbacks_refused: 'AllFeedbacksRefused',
            feedbacks_refused_count: 'AllFeedbacksRefusedCount',

        }),
        IsModerating() {
            this.moderating = this.$props.isModerating;
            return this.moderating;
        },
        paginatedFeedbacks() {
            if (this.IsModerating == true) {
                return this.feedbacks_moderating;
            } else if (this.IsModerating == false) {
                return this.feedbacks_refused;
            } else {
                return this.feedbacks_accepted;
            }
        }
    },
    methods: {
        ...mapActions(["fetchDealsCooperationFeedbackAdmin"]),
        getDate(date) {
            return moment(moment(date)).format('LL') + " в " + moment(moment(date)).format('LT');
        },
        showModalRating(review) {
            this.selectedReview = review;

            this.$nextTick(() => {
                $("#view-detail-rating").modal("show");
            });
        },
        async verifyReview(id) {
            await this.$store.dispatch('verifyReview', {id});
            this.fetchDealsCooperationFeedbackAdmin();
        },
        async refuseReview(id) {
            if (this.isShowReasonField) {
                if (this.reasonDeleteReview && this.reasonDeleteReview.trim() !== "") {
                    const reasonDeleted = this.reasonDeleteReview;
                    await this.$store.dispatch('refusedReview', {id, reasonDeleted});
                    this.fetchDealsCooperationFeedbackAdmin();
                    this.closeModalDeleteReview();
                } else return alert("Введите причину отклонения")
            } else {
                await this.$store.dispatch('refusedReview', {id});
                this.fetchDealsCooperationFeedbackAdmin();
                this.closeModalDeleteReview();
            }
        },
        closeReview() {
            this.editableReview = false;
            this.fetchDealsCooperationFeedbackAdmin()
        },
        showModalDeleteReview(review) {
            this.selectedReview = review;

            this.$nextTick(() => {
                $('#sb-notification-review-delete').modal('show');
            });
        },
        changeShowReason() {
            this.isShowReasonField = !this.isShowReasonField;
        },
        closeModalDeleteReview() {
            $('#sb-notification-review-delete').modal('hide');
        },

        showModalReasonCancelled(review) {
            this.selectedReview = review;

            this.$nextTick(() => {
                $("#sb-notification-reason-cancelled").modal('show')
            })
        },
        closeModalReasonDelete() {
            $("#sb-notification-reason-cancelled").modal('hide')
        }
    },
    watch: {},
    mounted() {
        console.log("Mounted", this.isModerating);
    },
    created() {
        this.$nextTick(() => {
            this.fetchDealsCooperationFeedbackAdmin();
        });
    }
};
</script>
<style scoped>
.points-rating > .row {
    flex-direction: column !important;
}

* > p {
    margin: 0 !important;
}

.btn {
    width: 150px;
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

.caption {
    color: #0B3158;
}

.review .title p {
    font-weight: bold;
    font-size: 16px;
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

* > p {
    font-size: 17px;
}

.block-review {
    background-color: white;
    border: 2px solid grey;
    border-radius: 15px;
}

.field-green {
    border: 1px solid;
    border-radius: 10px;
}

.rating-detailed:hover {
    cursor: pointer;
    background: rgba(0, 0, 0, 0.1);
}

.reason-checkbox {
    padding-left: 5px;
}

.reason-checkbox-border {
    width: 30px;
    height: 32px;
    border-radius: 5px;
    border: 1px solid lightgray;
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
