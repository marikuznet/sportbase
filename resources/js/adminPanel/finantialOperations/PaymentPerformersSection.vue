<template>
    <div class="overflow-auto">
        <modal v-if="selectedPayment" :id="'sb-notification-payment-'+selectedPayment.id" ref="sb-notification-payment"
               modal_class="sb-notification-payment" title="Уведомление о выплате"
               @left_action="cancelPaymentNotification(selectedPayment.id)"
               @right_action="confirmExecutorPayment(selectedPayment)"
               left_button="ОТМЕНА" right_button="Подтвердить выплату">
            <template #body>
                <p>Вы подтверждаете выплату Исполнителю</p>
                <div class="row">
                    <div class="col-lg-3">Плательщик</div>
                    <div class="col-lg-9">{{ selectedPayment.sportObject.title }} (ID:{{
                            selectedPayment.sportObject.id
                        }})
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">№ счета</div>
                    <div class="col-lg-9">{{ selectedPayment.id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3">Сумма (руб)</div>
                    <div class="col-lg-9">{{ selectedPayment.total_amount }}</div>
                </div>
                <p>Вы можете прикрепить документ, подтверждающий выплату (фото, скан, выписка)</p>
                <input @change="addImageDocument" type="file" class="form-control-lg w-100 pb-5" name="document"
                       accept="image/jpeg, image/gif, image/jpg, image/png">
            </template>
        </modal>

        <div id="modal-confirmed-executor" class="modal-confirmed">
            <div class="modal-content">
                <span class="close text-right" @click="closeExecutorPaymentConfirmation">&times;</span>
                <p id="note-executor"></p>
            </div>
        </div>
        <table class="table">
            <thead>
            <th class="text-center text-nowrap">Дата оплаты<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">ID сделки<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Объект<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Заказчик<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Исполнитель<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Счет<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Сумма (руб)<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Выплата<i class="fa fa-caret-down sort mx-2"></i></th>
            </thead>
            <tbody>
            <tr v-for="payment in paymentPerformers" v-if="payment">
                <td>{{ payment.dates.payment }}</td>
                <td class="text-center">{{ payment.deal_id }}</td>
                <td>
                    <a v-if="payment.sportObject" :href="`/admin/sport-objects/show/${payment.sportObject.id}`">
                        {{ payment.sportObject.title }} (ID:{{ payment.sportObject.id }})
                    </a>
                </td>
                <td>
                    <a v-if="payment.customer_info" :href="`/admin/users/profile/${payment.customer_info.id}`">
                        {{ payment.customer_info.title }}
                    </a>
                </td>
                <td>
                    <a v-if="payment.created_info" :href="`/admin/users/profile/${payment.created_info.id}`">
                        {{ payment.created_info.title }}
                    </a>
                </td>
                <td class="text-center">№{{ payment.id }} ({{ payment.order_number }})</td>
                <td class="text-center">{{ payment.total_amount }} ({{ payment.order_number }})</td>
                <td class="text-center">
                    <ins v-if="payment.status === 5" @click="showPaymentConfirmationHint(payment, $event)"
                         style="color: #6FB77F">
                        {{ payment.status === 5 ? 'Выплачена' : null }}
                    </ins>
                    <button class="btn btn-info text-white" v-if="payment.status === 3"
                            @click="showModalForPayment(payment.id, payment)">
                        Уведомить
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import modal from "../elements/modal";
import axios from "axios";

export default {
    name: "PaymentPerformersSection",
    components: {
        modal
    },
    props: {
        paymentPerformers: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            selectedPayment: null, image_document: null
        }
    },
    methods: {
        closeExecutorPaymentConfirmation() {
            const modal = document.getElementById('modal-confirmed-executor');
            modal.style.display = 'none';
        },
        cancelPaymentNotification(payment_id) {
            $('#sb-notification-payment-' + payment_id).modal('hide');
        },
        confirmExecutorPayment(payment) {
            const formData = new FormData();
            formData.append('file', this.image_document.original);
            formData.append('deal_id', payment.deal_id);

            axios.post(`/admin/estimate/${payment.id}/payment`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                this.$emit('getPayments');
                $('#sb-notification-payment-' + payment.id).modal('hide');
            }).catch(error => {
                console.error(error);
            });
        },
        showPaymentConfirmationHint(payment, $event) {
            const modal = document.getElementById('modal-confirmed-executor');
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

            const noteDiv = document.getElementById('note-executor');
            noteDiv.innerHTML = `
    <p>Дата и время подтверждения оплаты: ${payment.dates.payment_to_executor}</p>
    <p class="${payment.payment_doc ? '' : 'd-none'}">Документ о подтверждении: <a target="_blank" href="/storage/deal/${payment.deal_id}/${payment.payment_doc}">Документ</a></p>
`;
        },

        showModalForPayment(payment_id, payment) {
            this.selectedPayment = payment;
            this.$nextTick().then(() => {
                $('#sb-notification-payment-' + payment_id).modal('show');
            });
        },

        addImageDocument: async function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const supportedFormats = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

                const file = input.files[0];

                if (supportedFormats.includes(file.type)) {
                    const reader = new FileReader();
                    const vm = this;

                    reader.onload = async function (e) {
                        const img = new Image();
                        img.src = e.target.result;
                        img.onload = async function () {
                            if (img.width <= 250 || img.height <= 250) {
                                alert("Изображение должно быть не менее 250x250 пикселей");
                                return;
                            }
                            try {
                                vm.image_document = {
                                    original: file,
                                    preview: e.target.result,
                                };
                            } catch (error) {
                                console.log(error);
                            }
                        };
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert("Неподдерживаемый формат изображения. Пожалуйста, выберите изображение в формате jpg, jpeg, png или gif.");
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
