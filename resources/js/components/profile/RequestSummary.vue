<template>
    <div class="request-object pb-0">
        <div class="titleObject pb-2 justify-content-between d-flex">
            <p class="application-caption text-uppercase">
                {{ direct.sportObject.title ? direct.sportObject.title : '' }}
                <span class="pl-3 text-nowrap text-muted text-lowercase objectId">
                    id {{ direct.sportObject.id }}
                </span>
            </p>
        </div>
        <div class="info-request-object d-flex flex-wrap justify-content-between">
            <div class="d-flex flex-wrap">
                <div class="d-flex">
                    <div class="create padding mr-2">
                        <div class="title d-flex pb-2">
                            <img src="/icons/direct/XMLID_14_.svg" alt="calendar"/>
                            <p class="pl-3 caption">Создана</p>
                        </div>
                        <div class="field-green">
                            <p class="text-nowrap d-flex">{{ direct.createDate_month }}
                                <span class="d-none d-lg-flex pl-1 pr-1">{{ direct.createDate_year }}</span> в {{ direct.createDate_time }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="create mr-2">
                        <div class="title d-flex pb-2">
                            <p class="caption">Человек</p>
                        </div>
                        <div class="field">
                            <p class="text-nowrap">{{ direct.colPeople }} человек</p>
                        </div>
                    </div>
                    <div class="create mr-4">
                        <div class="title d-flex pb-2">
                            <p class="caption">Стоимость</p>
                        </div>
                        <div class="price d-flex align-items-center">
                            <div class="field-blue mr-2">
                                <p class="text-nowrap">{{ direct.minPrice }} руб.</p>
                            </div>
                            <p class="text-nowrap">за сутки</p>
                        </div>
                    </div>
                </div>
            </div>
            <rating-messages :average_rating="direct.sportObject.average_rating" :reviews_count="direct.sportObject.reviews_count"/>
        </div>
    </div>
</template>

<script>
import RatingMessages from "../elements/RatingMessages";
export default {
    name: "RequestSummary",
    components: {RatingMessages},
    props: {
        direct: {
            type: Object,
            required: true,
        }
    }
}
</script>

<style scoped>

</style>
