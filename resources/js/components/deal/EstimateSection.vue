<template>
    <div class="details d-flex flex-wrap flex-lg-nowrap pr-5 pl-5 pt-4 pb-4 mb-4 position-relative">
        <div class="position-absolute w-100 pr-5"
             style="top: -20px; text-align: center; margin-left: -1.5rem !important;">
            <img src="/icons/logo.png" alt="">
        </div>
        <div class="estimate shadow d-flex p-3 align-items-center w-50 mr-3">
            <p>{{ message }}</p>
            <button v-if="buttonLabel" type="button" @click="$emit('createEstimate')" class="btn-base ml-0 ml-lg-5">
                {{ buttonLabel }}
            </button>
        </div>
        <div class="cancel shadow d-flex p-3 align-items-center w-50">
            <p>{{ cancelMessage }}</p>
            <button type="button" @click="$emit('showReject')" class="btn-base button-icon ml-0 ml-lg-5">
                {{ cancelLabel }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "EstimateSection",
    props: {
        message: String,
        buttonLabel: String,
        cancelMessage: String,
        cancelLabel: String,
    },
}
</script>

<style scoped>

</style>
