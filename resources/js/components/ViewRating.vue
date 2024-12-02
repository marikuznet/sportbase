<template>
    <div class="modal fade show" id="view-detail-rating" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" v-if="review" data-bs-backdrop="static" @keydown.esc="closeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Детали оценки</h5>
                    <button type="button" class="close" @click="closeModal" aria-label="Close">
                        <span aria-hidden="true"><img src="/icons/tenders/close-button.svg" alt="Close button"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sb-rating-star">
                        <div class="sb-rating-star__rate">
                            <div v-for="(rating, key) in ratings" :key="key" class="sb-rate align-items-center d-flex">
                                <div class="sb-rate__title w-50">
                                    {{ rating.title }}
                                </div>
                                <div class="d-flex justify-content-end sb-rate__star w-50">
                                    <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                 :showRating="false" :rating="rating.value"
                                                 :read-only="true"></star-rating>
                                </div>
                                <div class="ml-3 sb-rate__title">
                                    {{ rating.value }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating';

export default {
    name: "ViewRating",
    props: {
        getReview: {
            type: Object,
            required: true
        },
        idReview: {
            type: [String, Number],
            required: true
        }
    },
    computed: {
        review() {
            return this.getReview;
        },
        ratings() {
            return [
                {title: 'Инфраструктура', value: this.review.infrastructure},
                {title: 'Состояние спортивных сооружений', value: this.review.sport_object},
                {title: 'Питание', value: this.review.food},
                {title: 'Территория', value: this.review.territory},
                {title: 'Расположение', value: this.review.place},
                {title: 'Цена/качество', value: this.review.price}
            ];
        }
    },
    methods: {
        closeModal() {
            $("#view-detail-rating").modal("hide");
            this.$emit('close');
        }
    },
    components: {StarRating}
}
</script>

<style scoped>
.modal-content {
    padding: 20px;
}

.modal-header, .modal-body {
    border: none;
}

.modal-title {
    color: #0B3158;
    font-size: 28px;
}

.sb-rate__title, .vue-star-rating-rating-text {
    color: #0B3158;
    font-size: 18px;
}

.sb-rating-star .sb-rate {
    margin-bottom: 0.5rem !important;
}

@media (max-width: 576px) {
    .modal-title {
        font-size: 22px;
    }

    .sb-rate__title, .vue-star-rating-rating-text {
        font-size: 16px;
    }

    .modal-content {
        padding: 15px;
    }
}
</style>
