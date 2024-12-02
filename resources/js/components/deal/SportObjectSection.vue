<template>
    <div v-if="request" class="request-object b-a-0 mb-4 ps-0 pe-0" style="border: none; border-bottom: 1px solid lightgray;">
        <div class="block-info__sportObject">
            <div class="align-items-start block-info__top d-flex justify-content-between">
                <div class="titleObject pb-2 justify-content-between d-flex">
                    <p class="captionObject text-uppercase">
                        {{ sportObject.title }}
                    </p>
                </div>
                <div class="rating-messages d-none d-lg-flex justify-content-between">
                    <div class="d-flex">
                        <div class="rating align-items-end d-flex">
                            <div class="d-flex">
                                <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                             :showRating="false"
                                             :rating="sportObject.average_rating"
                                             :read-only="true"/>
                                <p class="text-color_blue">{{ sportObject.average_rating | formatRating }}</p>
                            </div>
                        </div>
                        <div class="align-items-end col-auto d-flex">
                            <div class="d-flex">
                                <img class="pr-1" src="/icons/direct/chat.svg">
                                <div class="d-flex align-items-center">
                                    <p>{{ sportObject.reviews_count }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-request-object d-flex flex-wrap justify-content-between">
                <div class="d-flex flex-wrap mb-2">
                    <div class="d-flex">
                        <div class="create padding mr-2">
                            <div class="title d-flex pb-2">
                                <img src="/icons/direct/XMLID_14_.svg">
                                <p class="pl-3 caption">Создана</p>
                            </div>
                            <div class="field-green">
                                <p class="text-nowrap d-flex">{{ dealCreateDate }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="create mr-2">
                            <div class="title d-flex pb-2">
                                <p class=" caption">Человек</p>
                            </div>
                            <div class="field">
                                <p class="text-nowrap">{{ request.colPeople }} человек</p>
                            </div>
                        </div>
                        <div class="create mr-4">
                            <div class="title d-flex pb-2">
                                <p class="caption">Стоимость</p>
                            </div>
                            <div class="price d-flex align-items-center">
                                <div class="field-blue mr-2">
                                    <p class="text-nowrap">{{ request.minPrice }} руб.</p>
                                </div>
                                <p class="text-nowrap">за сутки</p>
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
    name: "SportObjectSection",
    props: {
        request: Object,
        dealCreateDate: String,
        sportObject: Object
    },
    components: {StarRating}
}
</script>

<style scoped>

</style>
