<template>
    <div class="info-request-object d-flex flex-wrap">
        <div class="d-flex flex-lg-nowrap flex-wrap">
            <div class="create mr-4 mb-3">
                <div class="title d-flex pb-2">
                    <img src="/icons/direct/XMLID_14_.svg" alt="">
                    <p class="pl-3 caption">Создана</p>
                </div>
                <div class="field-green">
                    <p class="text-nowrap d-flex">{{ tender.createDate_month }}
                        <span class="d-none d-lg-flex pl-1 pr-1">
                            {{ tender.createDate_year }}
                        </span> в {{ tender.createDate_time }}</p>
                </div>
            </div>
            <div class="create mr-4 mb-3">
                <div class="title d-flex pb-2">
                    <img src="/icons/direct/XMLID_14_.svg" alt="">
                    <p class="pl-3 caption">Пребывание</p>
                </div>
                <div class="field-green d-none d-lg-flex">
                    <p class="text-nowrap">{{ tender.startDate_day }} -
                        {{ tender.endDate }}
                        {{ tender.endDate_year }} {{ tender.spreadDate }}</p>
                </div>
                <div class="living d-flex align-items-center">
                    <div class="field-green d-flex d-lg-none">
                        <p class="text-nowrap">{{ tender.startDate_day }} -
                            {{ tender.endDate }}
                            {{ tender.endDate_year }}</p>
                    </div>
                    <p class="text-nowrap d-flex d-lg-none">{{ tender.spreadDate }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex pb-3">
            <div class="create mr-4">
                <div class="title d-flex pb-2">
                    <p class=" caption">Человек</p>
                </div>
                <div class="field justify-content-center">
                    <p class="text-nowrap">{{ tender.colPeople }}</p>
                </div>
            </div>
            <div class="create mr-4">
                <div class="title d-flex pb-2">
                    <p class="caption">Стоимость</p>
                </div>
                <div class="price d-flex align-items-center">
                    <div class="field-blue mr-2">
                        <p class="text-nowrap mobile-font-weight-bold">{{ tender.minPrice }} руб.</p>
                    </div>
                    <p class="text-nowrap">за сутки</p>
                </div>
            </div>
        </div>
        <div v-if="showRating" class="rating-messages d-flex justify-content-between">
            <div class="d-flex">
                <div class="rating align-items-center col-auto d-flex">
                    <div class="d-flex">
                        <star-rating :increment="0.5" :starSize="16"
                                     :activeColor="'#F5AE67'"
                                     :showRating="false"
                                     :rating="0"
                                     :read-only="true"></star-rating>
                        <div>
                            <p>0</p>
                        </div>
                    </div>
                </div>
                <div class="align-items-center col-auto d-flex">
                    <div class="d-flex">
                        <img class="pr-1" src="/icons/direct/chat.svg">
                        <div class="d-flex align-items-center">
                            <p>0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import StarRating from 'vue-star-rating'

export default {
    name: "RequestTitleTender",
    props: {
        prop_tender:{
            type: Object,
        },
        showRating: {
            type: Boolean,
            default: true
        }
    },
    components: {StarRating},
    data() {
        return {
        }
    },
    computed: {
        ...mapGetters({
        }),
        tender() {
            return this.$props.prop_tender;

        }
    },
    created() {
        this.$store.dispatch("fetchDealsReviews");
    }
}
</script>

<style scoped>
@media (max-width: 960px) {
    /*.proposal-card p {
        color: #0B3158;
        font-size: calc(0.875rem);
        font-weight: bold;
    }*/
}

</style>
