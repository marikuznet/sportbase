<template>
    <div class="deal-customer m-0 p-0 pl-4 pl-lg-0 pr-4 pr-lg-0">
        <template v-if="user.role === 3 && estimatesLength === 0">
            <estimate-section :message="'Если вас устраивают условия, сформируйте смету'"
                              :button-label="'Создать смету'" :cancel-label="'Отклонить'"
                              :cancel-message="'Если вас не устраивают условия, отклоните предложение'"
                              @createEstimate="$emit('createEstimate')" @showReject="$emit('showReject')"/>
        </template>

        <template v-if="user.role === 2 && (estimatesLength === 0 || showCustomer === 0 || showCustomer == null)">
            <estimate-section :button-label="null" :cancel-label="'Отказаться'"
                              :message="'Ожидайте когда Исполнитель сформирует (создаст) смету и пришлет счет на оплату услуг'"
                              :cancel-message="'Если вас не устраивают условия сделки, вы можете отказаться от нее'"
                              @createEstimate="$emit('createEstimate')" @showReject="$emit('showReject')"/>
        </template>

        <div v-if="false" class="notifications pb-4 d-block">
            <p class="ago">{{ fromNow(myDeal.deal_date_ago) }}</p>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import RejectDeal from "./RejectDeal";
import moment from "moment";
import EstimateSection from "./EstimateSection";

export default {
    components: {EstimateSection, RejectDeal},
    props: ['dealId', 'status', 'timer', 'estimatesLength', 'showCustomer'],
    name: "AwaitingDecision",
    data() {
        return {
            rejections: [],
        }
    },
    computed: {
        ...mapGetters({
            infoCompany: 'AllInfoCompanies', allRejections: 'AllRejectionsDeal', allEstimates: 'AllDeal_estimates'
        }),
        user: function () {
            return window.user;
        }
    },
    methods: {
        ...mapActions(['rejectDeal']),
        fromNow(deal_date) {
            const fromNow = moment(deal_date);
            return fromNow.fromNow();
        },
    }
}
</script>

<style scoped>

</style>
