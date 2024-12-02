<template>
    <div class="rating-messages d-flex justify-content-between align-items-center">
        <p class="caption sb-rate__title">{{ caption }}</p>
        <div class="d-flex">
            <ValidationProvider v-slot="{ errors }">
                <div class="rating align-items-center col-auto d-flex">
                    <div class="d-flex align-items-center">
                        <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'" :showRating="false"
                                     v-model="localRating"/>
                        <div class="rate p-2 ml-3" :class="{'is-invalid': errors[0]}">
                            <p style="font-size: calc(1rem); color: #0B3158">{{ localRating }}</p>
                        </div>
                    </div>
                    <div v-if="errors.length" class="invalid-feedback">{{ errors[0] }}</div>
                </div>
            </ValidationProvider>
        </div>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating';

export default {
    name: "RatingMessage",
    components: {StarRating},
    props: {
        caption: {
            type: String,
            required: true,
        },
        rating: {
            type: Number,
            required: true,
        },
        rules: {
            type: String,
            default: "required",
        },
    },
    data() {
        return {
            localRating: this.rating,
        };
    },
    watch: {
        localRating: function (value, oldValue) {
            this.$emit('update-model', this.localRating);
        }, deep: true
    }
}
</script>

<style scoped>

</style>
