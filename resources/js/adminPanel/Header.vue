<template>
    <div class="sb-menu-statistic position-absolute" style="right: 0">
        <ul class="sb-menu-statistic__list c-header-nav mfs-auto">
            <p class="header-block__title mx-2">Заказчиков: <b><span>{{ statistic.customersCount }}</span></b></p>
            <p class="header-block__title mx-2">Исполнителей: <b><span>{{ statistic.executorsCount }}</span></b></p>
            <p class="header-block__title mx-2">Объектов: <b><span>{{ statistic.objectsCount }}</span></b></p>
            <p class="header-block__title mx-2">Сделок: <b><span>{{ statistic.dealsCount }}</span></b></p>
        </ul>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    data: function () {
        return {}
    },
    methods: {
        ...mapActions(["adminMainStatistic"]),
    },
    computed: {
        ...mapGetters({
            statistic: "admin_main_statistic"
        }),
    },
    created() {
        this.adminMainStatistic();
    }
}
</script>

<style scoped>

</style>
