<template>
    <div class="overflow-auto">
        <modal v-if="selectedPayment" :id="'confirm-payment-' + currentPaymentId" title="Уведомление об оплате">
            <template #body>
                <p class="text-center mb-4" style="font-size: 1.25rem; color: #0B3158;">
                    Вы подтверждаете получение оплаты по счету
                </p>
                <div class="payment__info">
                    <div class="row">
                        <div class="col-4"><p><b>Плательщик</b></p></div>
                        <div class="col-8">
                            <p>{{ selectedPayment.customer_info.title }} (ID: {{
                                    selectedPayment.customer_info.id
                                }})</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4"><p><b>№ счета</b></p></div>
                        <div class="col-6"><p>{{ selectedPayment.id }}</p></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><p><b>Сумма (руб)</b></p></div>
                        <div class="col-6"><p>{{ selectedPayment.total_amount }}</p></div>
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="d-flex justify-content-center mb-4">
                    <button @click="closePaymentModal" class="btn btn-no w-50 mr-2">ОТМЕНА</button>
                    <button @click="confirmPayment(selectedPayment.id, selectedPayment.deal_id)"
                            class="btn btn-yes w-50">
                        Подтвердить оплату
                    </button>
                </div>
            </template>
        </modal>

        <div id="payment-confirmation-modal" class="modal-confirmed">
            <div class="modal-content">
                <span class="close" @click="closeConfirmationHint">&times;</span>
                <p id="confirmation-note"></p>
            </div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th class="text-center">Дата оплаты</th>
                <th class="text-center">ID сделки</th>
                <th class="text-center">Объект</th>
                <th class="text-center">Плательщик</th>
                <th class="text-center">ID счета</th>
                <th class="text-center">Сумма (руб)</th>
                <th class="text-center">Подтв. док.</th>
                <th class="text-center">Оплата</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="payment in estimates" :key="payment.id">
                <td class="text-center">{{ formatPaymentDate(payment.dates.payment) }}</td>
                <td class="text-center">{{ payment.deal_id }}</td>
                <td>{{ payment.sportObject.title }} (ID: {{ payment.sportObject.id }})</td>
                <td class="text-center">{{ payment.customer_info.title }} (ID: {{ payment.customer_info.id }})</td>
                <td class="text-center">{{ payment.id }} ({{ payment.order_number }})</td>
                <td class="text-center">{{ payment.total_amount }}</td>
                <td class="text-center">
                    <a v-if="payment.documents" href="#" @click="viewDocument(payment.deal_id, payment.documents)">
                        Смотреть
                    </a>
                    <span v-else>Нет</span>
                </td>
                <td class="text-center">
                    <a v-if="payment.status === 3 || payment.status === 5" href="javascript://"
                       @click="showConfirmationHint(payment, $event)">
                        Получена
                    </a>
                    <button v-else-if="payment.status === 2" class="btn btn-confirm" @click="showPaymentModal(payment)">
                        Подтвердить
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import modal from "../elements/modal";

export default {
    name: "PaymentListSection",
    components: {modal},
    props: {
        estimates: {
            type: Array,
            required: true,
            default: () => [],
        },
    },
    data() {
        return {
            currentPaymentId: null,
            selectedPayment: null,
        };
    },
    methods: {
        closePaymentModal() {
            $(`#confirm-payment-` + this.currentPaymentId).modal('hide');

            this.selectedPayment = null;
            this.currentPaymentId = null;
        },

        showPaymentModal(payment) {
            this.selectedPayment = payment;
            this.currentPaymentId = payment.id;

            this.$nextTick(() => {
                $(`#confirm-payment-` + this.currentPaymentId).modal('show');
            });
        },

        confirmPayment(paymentId, dealId) {
            this.$store.dispatch("estimatePaymentConfirmationAdmin", {id: paymentId, deal_id: dealId}).then(() => {
                this.closePaymentModal();
                this.$store.dispatch("getPayments");
            });
            this.closePaymentModal();
        },

        closeConfirmationHint() {
            const modal = document.getElementById("payment-confirmation-modal");
            modal.style.display = "none";
        },

        viewDocument(dealId, document) {
            window.open(`/storage/listings/payment/${dealId}/${document}`);
        },

        showConfirmationHint(payment, event) {
            const modal = document.getElementById("payment-confirmation-modal");
            const linkPosition = event.target.getBoundingClientRect();
            const modalWidth = modal.offsetWidth;

            let leftPosition = linkPosition.left + window.scrollX;
            if (leftPosition + modalWidth > window.innerWidth) {
                leftPosition = window.innerWidth - modalWidth - 100;
            }

            modal.style.left = leftPosition - 100 + "px";
            modal.style.top = linkPosition.bottom + window.scrollY + "px";
            modal.style.display = "block";

            const note = document.getElementById("confirmation-note");
            note.textContent = `Дата и время подтверждения оплаты: ${payment.dates.confirmed}`;
        },

        formatPaymentDate(date) {
            return date.split("/")[0];
        },
    },
};
</script>

<style scoped>
.modal-confirmed {
    position: absolute;
    display: none;
    background-color: white;
    border: 1px solid #ccc;
    padding: 1rem;
    z-index: 10;
}

.modal-content {
    position: relative;
}

.close {
    cursor: pointer;
    font-size: 1.5rem;
    position: absolute;
    top: 0;
    right: 1rem;
}

.btn-confirm {
    background-color: #0b7dda;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    cursor: pointer;
}
</style>
