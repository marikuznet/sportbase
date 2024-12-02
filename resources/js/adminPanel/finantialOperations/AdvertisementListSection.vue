<template>
    <div class="overflow-auto">
        <div class="sb-loading align-items-center d-flex justify-content-center loading position-fixed"
             v-if="paymentAdvertisementsLoading">
            <div class="spinner-border text-info" role="status"/>
        </div>
        <div id="modal-payment-advertisement" class="modal-confirmed">
            <div class="modal-content">
                <span class="close text-right" @click="closePaymentAdvertisementHint">&times;</span>
                <p id="note"></p>
            </div>
        </div>
        <div id="modal-overdue-advertisement" class="modal-confirmed">
            <div class="modal-content">
                <span class="close text-right" @click="closePaymentAdvertisementOverdueHint">&times;</span>
                <p id="note-overdue"></p>
            </div>
        </div>
        <table-data-component :items="advertisementsTable.tableItems"
                              :headers="advertisementsTable.tableHeaders"
                              :columns="advertisementsTable.tableColumns">
            <template #status="{item}">
                <a v-if="item.transaction_status === 'succeeded'" href="#"
                   @click="showPaymentAdvertisementHint(item, $event)"
                   :class="{'text-success': item.transaction_status === 'succeeded'}">
                    Оплачена
                </a>
                <p v-if="item.transaction_status === 'canceled'"
                   :class="{'text-danger': item.transaction_status === 'canceled'}">
                    Отменена
                </p>
                <p v-if="item.transaction_status === 'created' && (new Date(item.end_date_payment_full) >= new Date())"
                   :class="{'text-primary': item.transaction_status === 'created'}">
                    Ожидает оплаты
                </p>

                <a href="#" @click="showPaymentAdvertisementOverdueHint(item, $event)"
                   v-if="item.transaction_status === 'created' && (new Date(item.end_date_payment_full) <= new Date())"
                   :class="{'text-danger': item.transaction_status === 'created'}">
                    Просрочена
                </a>
            </template>
        </table-data-component>
    </div>
</template>

<script>
import TableDataComponent from "../elements/TableDataComponent";
import {mapGetters} from "vuex";

export default {
    name: "AdvertisementListSection",
    components: {
        TableDataComponent
    },
    computed: {
        ...mapGetters({
            paymentAdvertisementsLoading: 'payment_advertisements_loading',
            paymentAdvertisements: 'payment_advertisements',
        }),
        advertisementsTable() {
            return {
                tableHeaders: [
                    {label: "Дата оплаты"},
                    {label: "ID номер"},
                    {label: "Тип продвижения"},
                    {label: "Дата запуска"},
                    {label: "Объект"},
                    {label: "Продолжит."},
                    {label: "Стоимость общ."},
                    {label: "Оплата"},
                ],
                tableColumns: [
                    {prop: "dateStart", class: "text-center"},
                    {prop: "id", class: "text-center"},
                    {prop: "type_advertisement", class: "text-center"},
                    {prop: "dateStart", class: "text-center"},
                    {prop: "object", class: "text-center", html: true},
                    {prop: "days", class: "text-center"},
                    {prop: "amount", class: "text-center"},
                    {prop: "status", class: "text-center"},
                ],
                tableItems: this.paymentAdvertisements.map(advertisement => ({
                    ...advertisement,
                    object: `<a href="/admin/sport-objects/show/${advertisement.sportObject.id}">${advertisement.sportObject.title} (ID:${advertisement.sportObject.id})</a>`,
                    days: advertisement.duration + ' дней',
                    amount: advertisement.sum + ' руб.',
                    statusAdv: advertisement.status,
                }))
            }
        },
    },
    methods: {
        closePaymentAdvertisementHint() {
            const modal = document.getElementById('modal-payment-advertisement');
            modal.style.display = 'none';
        },
        showPaymentAdvertisementHint(payment, $event) {
            const modal = document.getElementById('modal-payment-advertisement');
            const link = $event.target;
            const linkRect = link.getBoundingClientRect();
            const modalWidth = modal.offsetWidth;

            let leftPosition = linkRect.left + window.scrollX;
            if (leftPosition + modalWidth > window.innerWidth) {
                leftPosition = window.innerWidth - modalWidth - 100;
            }

            modal.style.left = (leftPosition - 100) + 'px';
            modal.style.top = linkRect.bottom + window.scrollY + 'px';
            modal.style.display = 'block';

            const noteDiv = document.getElementById('note');
            noteDiv.innerHTML = `<p>Дата и время подтверждения оплаты: ${payment.dateStart}</p>`;
        },
        closePaymentAdvertisementOverdueHint() {
            const modal = document.getElementById('modal-overdue-advertisement');
            modal.style.display = 'none';
        },
        showPaymentAdvertisementOverdueHint(payment, $event) {
            const modal = document.getElementById('modal-overdue-advertisement');
            const link = $event.target;
            const linkRect = link.getBoundingClientRect();
            const modalWidth = modal.offsetWidth;

            let leftPosition = linkRect.left + window.scrollX;
            if (leftPosition + modalWidth > window.innerWidth) {
                leftPosition = window.innerWidth - modalWidth - 100;
            }

            modal.style.left = (leftPosition - 100) + 'px';
            modal.style.top = linkRect.bottom + window.scrollY + 'px';
            modal.style.display = 'block';

            const noteDiv = document.getElementById('note-overdue');
            noteDiv.innerHTML = `<p>Конечная дата и время оплаты: ${new Date(payment.end_date_payment_full).toLocaleDateString()} / ${new Date(payment.end_date_payment_full).toLocaleTimeString()}</p>`;
        },
    }
}
</script>

<style scoped>

</style>
