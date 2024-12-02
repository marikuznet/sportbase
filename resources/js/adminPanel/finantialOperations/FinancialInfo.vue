<template>
    <div class="expanses_and_profits">
        <div class="row w-100 mt-4">
            <div class="col-12 col-lg-3">
                <p class="font-weight-bold">Доходы и расходы системы</p>
            </div>
        </div>
        <div class="row w-100 mb-3 pb-2 pt-2 badge-secondary">
            <div class="col-12 col-lg-3">
                <span>Заработано (всего): <b>{{ statistic.all_money }} руб</b></span>
            </div>
            <div class="col-12 col-lg-3">
                <span>Заработано (на рекламе): <b>{{ statistic.money_advertisements }} руб</b></span>
            </div>
            <div class="col-12 col-lg-3">
                <span>Заработано (на сделках): <b>{{ statistic.money_deals }} руб</b></span>
            </div>
            <div class="col-12 col-lg-3">
                <span>Выплачено (исполнителям): <b>{{ statistic.paid_executor }} руб</b></span>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "FinancialInfo",
    computed: {
        ...mapGetters({
            statistic: "admin_finance_finance_income"
        })
    }
}
</script>

<style scoped>

</style>
