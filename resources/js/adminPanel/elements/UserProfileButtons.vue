<template>
    <div class="sb-page__profile-buttons container row top d-lg-flex sb-settings-performers__buttons">
        <a v-for="(item, index) in items" :key="index" :href="item.href" class="col-2 p-0">
            <button class="w-100 p-2 sb-settings-performers-button" :class="{'active': item.active, 'bg-transparent': !item.active}"
                    :name="item.name">
                {{ item.title }}
            </button>
        </a>
    </div>
</template>

<script>
export default {
    name: "UserProfileButtons",
    props: {
        items: {
            type: Array,
            default: () => {
                return [];
            },
        }
    }
}
</script>

<style scoped>

</style>
