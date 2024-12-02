<template>
    <div class="col-md-4 text-center">
        <div class="d-flex justify-content-center align-items-center pb-4">
            <img :alt="title" class="image__stage" :src="icon" />
        </div>
        <div class="dottedLine">
            <img :src="lineImage" :alt="lineAlt" />
        </div>
        <div class="pb-4">
            <p class="subtitle__blue"><strong>{{ title }}</strong></p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        icon: String,
        title: String,
        lineImage: String,
        lineAlt: String
    }
}
</script>

<style scoped>

</style>
