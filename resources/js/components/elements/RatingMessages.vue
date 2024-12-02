<template>
    <div class="rating-messages d-none d-lg-flex justify-content-between">
        <div class="d-flex">
            <div class="rating align-items-end col-auto d-flex">
                <div class="d-flex">
                    <star-rating :increment="0.5" :starSize="16"
                                 :activeColor="'#F5AE67'"
                                 :showRating="false"
                                 :rating="rating"
                                 :read-only="true"></star-rating>
                    <div>
                        <p>{{ rating | formatRating }}</p>
                    </div>
                </div>
            </div>
            <div class="align-items-end col-auto d-flex">
                <div class="d-flex">
                    <img class="pr-1" src="/icons/direct/chat.svg" alt="calendar">
                    <div class="d-flex align-items-center">
                        <p>{{ reviews }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StarRating from "vue-star-rating";
export default {
    name: "RatingMessages",
    components: {StarRating},
    props:{
        average_rating: {
            default: 0
        },
        reviews_count: {
            default: 0
        }
    },
    computed: {
        rating(){
            return this.$props.average_rating
        },
        reviews(){
            return this.$props.reviews_count
        }
    }
}
</script>

<style scoped>

</style>
