<template>
    <div class="container body mr-lg-5 ml-lg-5 mb-lg-4" style="width: auto;">
        <div class="row points-rating">
            <div class="col-md-4">
                <div class="row mb-lg-2 flex-column">
                    <rating-message caption="Инфраструктура"
                                    :rating="getRating('infrastructure')"
                                    @update-model="setRating('infrastructure', $event)"/>
                </div>
                <div class="row flex-column">
                    <rating-message caption="Состояние спортивных сооружений"
                                    :rating="getRating('sport_object')"
                                    @update-model="setRating('sport_object', $event)"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row mb-lg-2 flex-column">
                    <rating-message caption="Питание"
                                    :rating="getRating('food')"
                                    @update-model="setRating('food', $event)"/>
                </div>
                <div class="row flex-column">
                    <rating-message caption="Территория"
                                    :rating="getRating('territory')"
                                    @update-model="setRating('territory', $event)"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row mb-lg-2 flex-column">
                    <rating-message caption="Расположение"
                                    :rating="getRating('place')"
                                    @update-model="setRating('place', $event)"/>
                </div>
                <div class="row flex-column">
                    <rating-message caption="Цена/качество"
                                    :rating="getRating('price')"
                                    @update-model="setRating('price', $event)"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RatingMessage from "../../profile/profileCustomer/RatingMessage";

export default {
    name: "GroupRatingMessage",
    components: {RatingMessage},
    props: {
        isAdmin: {
            type: Boolean,
            required: true
        },
        initialReviewData: {
            default: null,
        },
    },
    data(){
      return {
          reviewModel: {
              infrastructure: 0, sport_object: 0, food: 0, territory: 0, place: 0, price: 0, status: 0,
              text: '<p style="color: #0B3158"></p>', deal_id: this.dealId, user_id: null,
          }
      }
    },
    methods: {
        getRating(key) {
            return this.isAdmin ? this.initialReviewData[key] : this.reviewModel[key];
        },
        setRating(key, value) {
            if (this.isAdmin) {
                this.$emit('update-initial-rating', { key, value });
            } else {
                this.$emit('update-model-rating', { key, value });
            }
        },
    }
}
</script>

<style>
.rating-messages .rate {
    min-width: 40px;
    text-align: center;
}

</style>
