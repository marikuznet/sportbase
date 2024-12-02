<template>
    <div>
        <div class="edit-review">
            <div v-if="shouldShowAddReviewPrompt && isPersonalAccount"
                 class="edit-review__caption mb-lg-5 pb-lg-0 pb-5">
                <div class="edit-review__title text-center">
                    <p class="fs-4 fw-bold text-primary">Вы еще не оставили отзыв по данному заказу</p>
                </div>
                <div class="text-center">
                    <button class="btn btn-base btn-blue mt-3 p-2 shadow" @click="toggleReviewForm(true)">
                        Оставить отзыв
                    </button>
                </div>
            </div>

            <div v-if="user.role !== 3" class="review-cooperation edit-review__body mb-lg-5 pt-3 pb-3">
                <template v-if="user.role === 2">
                    <div class="title d-lg-flex d-none justify-content-between pl-4 pr-4">
                        <div class="left d-flex align-items-center">
                            <img class="mr-3" src="/icons/starGreen.svg" alt="icon-star">
                            <p class="leave-review">Оставьте ваш отзыв о сотрудничестве</p>
                        </div>
                        <div class="right d-flex align-items-center">
                            <p class="mr-5">Или завершить заказ с возможностью оставить отзыв позже</p>
                            <div class="">
                                <button style="width: 200px; border-radius: 5px" @click="completeDeal"
                                        class="btn-base button-icon border-green">Завершить заказ
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="title d-flex flex-wrap d-lg-none justify-content-between pl-4 pr-4 pt-3">
                        <div class="d-flex">
                            <div class="flex-grow-0 mr-3">
                                <img width="24px" class="mr-3" src="/icons/starGreen.svg" alt="icon-star">
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-3 order leave-review" style="font-size: calc(0.875rem);">
                                    Оставьте ваш отзыв о сотрудничестве
                                </p>
                                <div class="w-100 enum mb-3">
                                    <p>Или завершить заказ с возможностью оставить отзыв позже</p>
                                </div>
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="col-12">
                                <div class="text-center">
                                    <button style="width: 255px; border-radius: 5px" @click="completeDeal"
                                            class="btn-base button-icon border-green">
                                        Завершить заказ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr width="100%">
                </template>

                <ValidationObserver v-slot="{ invalid, errors }" ref="formReview" tag="form"
                                    @submit.prevent="onSaveReview">

                    <group-rating-message :is-admin="isAdmin" :initial-review-data="initialReviewData"
                                          @update-model-rating="updateModelRating"
                                          @update-initial-rating="updateInitialRating"></group-rating-message>

                    <ValidationProvider :rules="`editorLength|editorMaxLength:${maxReview}`" v-slot="{ errors }">
                        <div class="text-review ml-lg-5 mr-lg-5 mb-4">
                            <div class="title mb-2 d-flex justify-content-between">
                                <p style="color: #0B3158; font-size: calc(1.25rem)">Текст отзыва</p>
                                <p style="color: #6283E5; font-size: calc(1.125rem); font-weight: normal">
                                    {{ reviewTextLength }}/500
                                </p>
                            </div>
                            <div class="d-flex justify-content-end">
                                <span class="error-valid text-danger" v-if="errors[0]">* {{ errors[0] }}</span>
                            </div>
                            <vue-editor ref="editorReview" :editorToolbar="customToolbar" type="text"
                                        @keydown.native="handleKeyDown" @keydown.ctrl.prevent
                                        @keydown.meta.prevent placeholder="Текст вашего сообщения" required
                                        :maxlength="maxReview" v-model="reviewText" :class="{'is-invalid': errors[0]}"/>
                            <div class="text-center">
                                <button type="submit" class="btn btn-base btn-green mt-3 p-2 shadow text-white">
                                    {{ editableReviewData ? 'Сохранить' : 'Оставить отзыв' }}
                                </button>
                            </div>
                        </div>
                    </ValidationProvider>
                </ValidationObserver>
            </div>

            <div class="notif justify-content-between"
                 v-if="user.role === 3 && (info_review && info_review.status === 1)">
                <div class="d-flex align-items-end p-3">
                    <img class="mr-4" src="/icons/starGreen.svg" alt="">
                    <div class="mr-3 order">Заказчик оставил отзыв о вашем сотрудничестве</div>
                </div>
                <div class="p-0 ml-5 mr-5 mb-5 d-lg-flex d-none">
                    <div class="review mr-2">
                        <div class="title d-flex pb-2">
                            <p class="caption">Отзыв</p>
                        </div>
                        <div class="rating d-block p-4 shadow">
                            <p class="text-nowrap d-flex">Оценка суммарная</p>
                            <div class="align-items-center d-flex">
                                <div class="d-flex">
                                    <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                 :showRating="false" :rating="parseFloat(info_review.average)"
                                                 :read-only="true"/>
                                    <div class="ml-3">
                                        <p style="font-size: calc(1.375rem)">
                                            {{ info_review.average ? info_review.average.toFixed(2) : 0 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="review mr-2 w-100">
                        <div class="title d-flex pb-2">
                            <p class="caption">Текст отзыва</p>
                        </div>
                        <div class="text p-4">
                            <p class="d-flex">
                                {{ info_review.text | stripHTMLTags }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-0 ml-3 mr-3 mb-3 d-lg-none d-flex">
                    <div class="d-flex flex-wrap">
                        <div class="review w-100">
                            <div class="rating d-block p-4 shadow">
                                <p style="font-size: calc(0.875rem)" class="text-nowrap d-flex">Оценка суммарная</p>
                                <div class="align-items-center d-flex">
                                    <div class="d-flex">
                                        <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                     :showRating="false" :rating="parseFloat(info_review.average)"
                                                     :read-only="true"/>
                                        <div class="ml-3">
                                            <p style="font-size: calc(1.375rem)">{{
                                                    info_review.average.toFixed(2)
                                                }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="review mr-2 w-100">
                            <div class="title d-flex pb-2">
                                <p style="font-size: calc(0.94rem)" class="caption ml-5 pt-2 pb-3">Текст
                                    отзыва</p>
                            </div>
                            <div class="text p-4">
                                <p style="font-size: calc(0.875rem)" class="d-flex">
                                    {{ info_review.text.replace(/<\/?[^>]+(>|$)/g, "") }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="allReviews">
                    <div class="reviews p-3 d-lg-flex d-none align-items-center shadow mt-3 mb-3 ml-4 mr-4">
                        <img class="mr-4" src="/icons/information.svg" alt="">
                        <p class="mr-5">Посмотреть все отзывы вы можете на странице</p>
                        <button @click="showReviews" class="btn-base pl-3 pr-3 pt-2 pb-2">Отзывы о сотрудничестве
                        </button>
                    </div>
                    <div class="reviews p-3 d-block d-lg-none align-items-center shadow mt-3 mb-3 ml-2 mr-2">
                        <div class="d-flex mb-3">
                            <img class="mr-4" src="/icons/information.svg" alt="info">
                            <p style="font-size: calc(0.875rem)" class="mr-5">Посмотреть все отзывы вы можете на
                                странице</p>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button @click="showReviews" style="font-size: calc(0.875rem)"
                                    class="btn-base pl-3 pr-3 pt-2 pb-2">
                                Отзывы о сотрудничестве
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating'
import {mapActions, mapGetters} from "vuex";
import RatingMessage from "../profile/profileCustomer/RatingMessage";
import GroupRatingMessage from "../profile/profileCustomer/GroupRatingMessage";


export default {
    name: "Review",
    components: {GroupRatingMessage, RatingMessage, StarRating},
    props: {
        editableReviewData: {
            type: Boolean,
            default: null,
        },
        dealId: {
            type: Number
        },
        canAddReview: {
            type: Boolean,
            default: false,
        },
        initialReviewData: {
            default: null,
        },
        reviewId: {
            default: null
        },
        isAdmin: {
            type: Boolean,
            default: false
        },
        reviewData: {
            type: Object,
            default: function () {
                return {};
            }
        },
        isPersonalAccount: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            maxReview: 500,
            customToolbar: [
                [{'header': [1, 2, 3, 4, 5, 6, false]}],
                [{
                    'color': ['#0B3158', '#000000', '#e60000', '#ff9900', '#ffff00', '#008a00', '#0066cc', '#9933ff', '#ffffff'],
                    'background': []
                }],
                ['bold', 'italic'],
                [{'list': 'bullet'}, {'list': 'ordered'}, {'align': []}],
            ],
            reviewModel: this.initializeReviewModel(),
            showAddReview: false,
        };
    },
    computed: {
        ...mapGetters({
            //review: 'GetDealReview',
        }),
        user: function () {
            return window.user;
        },
        info_review() {
            return this.reviewData;
        },
        shouldShowAddReviewPrompt() {
            return this.user.role === 2 && this.canAddReview && !this.showAddReview;
        },
        reviewText: {
            get() {
                return this.isAdmin ? this.initialReviewData.text : this.reviewModel.text;
            },
            set(value) {
                const target = this.isAdmin ? 'initialReviewData' : 'reviewModel';
                this.$set(this[target], 'text', value);
            }
        },
        reviewTextLength() {
            return this.reviewText.replace(/<[^>]*>/g, '').length;
        }
    },
    methods: {
        ...mapActions([
            "storeDealReview",
            "fetchDeals",
            "fetchDealsCooperationFeedbackAdmin"
        ]),
        initializeReviewModel() {
            return {
                infrastructure: 0,
                sport_object: 0,
                food: 0,
                territory: 0,
                place: 0,
                price: 0,
                status: 0,
                text: '<p style="color: #0B3158"></p>',
                deal_id: this.dealId,
                user_id: null,
            };
        },
        updateModelRating({key, value}) {
            this.$set(this.reviewModel, key, value);
        },
        updateInitialRating({key, value}) {
            this.$set(this.initialReviewData, key, value);
        },
        completeDeal() {
            this.$store.dispatch("dealComplete", {
                id: this.dealId,
                idComplete: 1,
            }).then(() => window.location.href = "/orders-and-payments");
        },
        async addReviewMethod() {
            this.reviewModel.deal_id = this.dealId;
            this.reviewModel.user_id = this.initialReviewData?.user_customer_info?.user_id || this.user.id;

            if (this.editableReviewData || this.canAddReview) {
                await this.storeDealReview(this.reviewModel);
                this.$emit('getReviews');
                this.toggleReviewForm(false);
                this.$emit('closeEditor');
            }
        },
        showReviews() {
            window.location.href = "/reviews";
        },
        onSaveReview() {
            this.$refs.formReview.validate().then(success => {
                if (success) {
                    this.handleSaveReview();
                } else {
                    this.scrollToFirstError();
                }
            });
        },
        handleSaveReview() {
            if (this.isAdmin) {
                this.populateAdminReviewModel();
                this.storeDealReview(this.reviewModel);
                this.$emit('getReviews');
                this.toggleReviewForm(false);
                this.$emit('closeEditor');
            } else {
                this.addReviewMethod();
            }
        },
        populateAdminReviewModel() {
            Object.assign(this.reviewModel, {
                infrastructure: this.initialReviewData.infrastructure,
                sport_object: this.initialReviewData.sport_object,
                food: this.initialReviewData.food,
                territory: this.initialReviewData.territory,
                place: this.initialReviewData.place,
                price: this.initialReviewData.price,
                text: this.initialReviewData.text,
                deal_id: this.initialReviewData.deal.id,
                user_id: this.initialReviewData.user_customer_info.user_id,
                status: 0,
            });
        },
        scrollToFirstError() {
            setTimeout(() => {
                const errors = Object.entries(this.$refs.formReview.errors)
                    .map(([key, value]) => ({key, value}))
                    .filter(error => error.value.length);

                if (errors.length > 0) {
                    this.$refs.formReview.refs[errors[0].key].$el.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });
                }
            }, 100);
        },
        handleKeyDown(e) {
            if (this.reviewTextLength >= this.maxReview && e.keyCode !== 8) {
                e.preventDefault();
            }
        },
        toggleReviewForm(show) {
            this.showAddReview = show;
        },
    },
    mounted() {
        if (this.isAdmin) {
            this.populateAdminReviewModel();
        }
    },
    watch: {
        editableReviewData(newValue) {
            if (newValue) {
                Object.assign(this.reviewModel, this.initialReviewData);
            }
        }
    }
}
</script>

<style>

#editorReview p {
    color: rgb(11, 49, 88) !important;
}

.review-cooperation .title p {
    color: #0B3158;
    font-size: calc(1.25rem);
}

.review-cooperation {
    background-color: white;
    border: 2px solid #BAC4DF;
    border-radius: 10px;
}

.review-cooperation.edit-review__body {
    border: none;
}

.review-cooperation .leave-review {
    font-weight: bold;
}

.review-cooperation .body .caption {
    color: #0B3158;
    font-size: calc(1rem);
}

.rating-messages .rate {
    border: 1px solid rgba(98, 131, 229, 0.3);
    border-radius: 14px;
}

#editorReview {
    border-radius: 0 0 10px 10px;
}

.ql-toolbar.ql-snow {
    border-radius: 10px 10px 0 0;
}

.btn-green {
    background-color: #6FB77F;
    color: white;
    border-radius: 5px;
    width: 200px;
    height: 50px;
}

.review-cooperation .border-green {
    background-color: transparent;
    color: #6FB77F;
    font-size: 18px !important;
    border: 1px solid;
}

.edit-review__caption {
    border-top: 1px solid #0B3158;
    padding-top: 2.5rem;
}

@media (max-width: 960px) {
    .review-cooperation .body {
        margin-left: 0.5rem !important;
        margin-left: 0 !important;
    }

    .review-cooperation .title p {
        font-size: calc(0.875rem) !important;
    }

    .review-cooperation .body {
        margin-left: 1rem !important;
        margin-right: 1rem !important;
    }

    .text-review {
        margin-left: 1.5rem !important;
        margin-right: 1.5rem !important;
    }

    .review-cooperation .body .caption {
        font-size: calc(0.81rem);
    }

    .rating img {
        width: 16px;
    }

    .rating .rate p {
        font-size: calc(0.81rem) !important;
    }

    .points-rating {
        margin-bottom: 30px;
    }

    .points-rating .row {
        margin-bottom: 10px;
    }

    .rating-messages .rating {
        padding-right: 0 !important;
    }

    .text-review .title p {
        font-size: calc(1rem) !important;
        font-weight: bold;
    }

    .text-review button {
        width: 255px;
        height: 45px;
        font-size: calc(0.875rem);
    }
}
</style>
