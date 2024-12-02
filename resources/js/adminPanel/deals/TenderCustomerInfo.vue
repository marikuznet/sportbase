<template>
    <div v-if="isCustomer" class="row mb-3">
        <div class="col-3">
            <h6>Заказчик</h6>
            <div class="d-flex">
                <div class="img mr-1 block__circle" style="width: 40px; height: 40px">
                    <img class="w-100 h-100"
                         :src="`/storage/listings/logos/${myDeal.tender.customer_info.user_id}/${myDeal.tender.customer_info.logo}`"
                         alt="logo">
                </div>
                <p><b>{{ myDeal.tender.customer_info.title }}</b></p>
            </div>
        </div>
        <div class="col-9">
            <div class="block-grey pl-3 pr-3 pt-1">
                <p class="mb-0">Предлагаю вам заключить сделку на выполнение задания по тендеру
                    №{{ myDeal.tender.id }} (сообщение сформировано автоматически).</p>
            </div>
            <div class="block-days-ago">
                <p class="text-muted">{{ fromNow(myDeal.deal_date_ago) }}</p>
            </div>
        </div>
    </div>

    <div v-else class="row mb-3">
        <div class="col-9">
            <div class="block-grey pl-3 pr-3 pt-1">
                <p class="mb-0">
                    Вы приняли условия по тендеру №{{ myDeal.tender.id }}. Сформируйте смету и счет на оплату услуг,
                    далее отправьте ее заказчику. (сообщение сформировано автоматически).</p>
            </div>
            <div class="block-days-ago">
                <p class="text-muted">{{ fromNow(myDeal.deal_date_ago) }}</p>
            </div>
        </div>
        <div class="col-3">
            <h6>Исполнитель</h6>
            <div class="d-flex">
                <div class="img mr-1 block__circle" style="width: 40px; height: 40px">
                    <img class="w-100 h-100" :src="`/storage/listings/logos/${myDeal.sportObject.created.user_id}/${myDeal.sportObject.created.image}`" alt="logo">
                </div>
                <p><b>{{ myDeal.sportObject.created.title }}</b></p>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "TenderCustomerInfo",
    props: ["myDeal", "isCustomer"],
    methods: {
        fromNow(deal_date) {
            const fromNow = moment(deal_date);
            return fromNow.fromNow();
        },
    }
}
</script>

<style scoped>

</style>
