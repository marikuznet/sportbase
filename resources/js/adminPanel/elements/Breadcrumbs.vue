<template>
    <div class="sb-page__breadcrumbs">
        <nav aria-label="breadcrumb" class="d-flex justify-content-between">
            <ol class="breadcrumb b-a-0">
                <li class="breadcrumb-item fs-lg-5" v-for="(item, index) in items" :key="index"
                    :class="{ active: item[0], 'active': item.active}" :disabled="item.active">
                    <a :href="item.href" class="breadcrumb-link letter-spacing-2 text-wrap">{{ item.text }}</a>
                </li>
            </ol>
        </nav>
    </div>
</template>

<script>
export default {
    name: "Breadcrumbs",
    props: {
        items: {
            type: Array,
            default: () => {
                return [];
            },
        },
    },
}
</script>

<style scoped>
</style>
