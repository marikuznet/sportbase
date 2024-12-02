<template>
    <div v-if="!isMobile" class="container d-flex block-info p-4 shadow mt-4 mb-4"
         style="background-color: white; border-radius: 10px">
        <img class="pr-4" src="/icons/information.svg" alt="">
        <p>На этой странице отображаются выплаты (от системы) по вашим сметам. Будьте внимательны,
            платеж может быть завершет в течении 3х рабочих дней после изменения статуса. Описание
            статусов: <span style="color: #6FB77F">выплачена</span> - оплата успешно отправлена на
            ваши реквизиты; <span style="color: #6283E5">ожидает выплаты</span> - выплата
            не сделана (находится в процессе); <span style="color:#E45868">не завершена</span> -
            отклонена по любой причине (cделка отменилась или по ней происходит арбитраж)</p>
        <img @click="dismissNotification" style="cursor: pointer" class="pl-4"
             src="/icons/direct/redClose.svg" alt="close">
    </div>
    <div v-else style="background-color: white; border-radius: 10px"
         class="mobile block-info container d-block p-4 shadow mt-4 mb-4">
        <div class="d-flex justify-content-between w-100 pb-4">
            <img width="30px" class="" src="/icons/information.svg" alt="info" style="cursor: pointer">
            <img @click="dismissNotification" width="17px" src="/icons/direct/redClose.svg" alt="close">
        </div>
        <p style="font-size: calc(0.88rem); line-height: 2">На этой странице отображаются выплаты (от
            системы) по вашим сметам. Будьте внимательны,
            платеж может быть завершет в течении 3х рабочих дней после изменения статуса. Описание
            статусов: <span style="color: #6FB77F">выплачена</span> - оплата успешно отправлена на
            ваши реквизиты; <span style="color: #6283E5">ожидает выплаты</span> - выплата
            не сделана (находится в процессе); <span style="color:#E45868">не завершена</span> -
            отклонена по любой причине (cделка отменилась или по ней происходит арбитраж)</p>
    </div>
</template>

<script>
export default {
    name: "NotificationBlock",
    props: {
        isMobile: Boolean
    },
    methods: {
        dismissNotification() {
            this.$emit('dismiss');
        }
    }
}
</script>

<style scoped>
.block-info {
    background-color: white;
    border-radius: 10px;
}

.mobile.block-info {
    margin-left: 1.5rem;
    margin-right: 1.5rem;
    width: auto;
}
</style>
