<template>
    <div class="block-estimate container p-0 mt-5" v-if="shouldShowEstimate()">
        <div class="time_to_end-estimate d-flex align-items-center pt-4 pb-3 position-relative"
             style="border: 1px solid #BAC4DF;border-radius: 10px;">
            <div class="logo d-flex justify-content-center mb-3 position-absolute w-100" style="top: -20px;">
                <img src="/icons/logo.png" alt="logo">
            </div>
            <div class="details d-flex pr-4 pl-4 position-relative w-100">
                <div class="estimate shadow d-flex p-3 align-items-center w-50 mr-3">
                    <p>{{ getEstimateMessage() }}</p>
                    <button v-if="shouldShowCreateEstimateButton()" type="button" @click="$emit('createEstimate')"
                            class="ml-5">
                        Создать смету повторно
                    </button>
                </div>
                <div class="cancel shadow d-flex p-3 align-items-center w-50">
                    <p>Если вас <span style="color: #E45868">не устраивают условия</span>, отклоните предложение</p>
                    <button type="button" @click="$emit('getShowReject')" class="button-icon ml-5">
                        Отклонить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TimeToEndEstimate",
    props: {
        stopTimer: Boolean,
        indexEst: Number,
        length: Number,
        step: Number,
        showCustomer: Number,
        idEstimate: Number,
    },
    computed: {
        user() {
            return window.user;
        }
    },
    methods: {
        shouldShowEstimate() {
            if (this.user.role === 3 && this.stopTimer && this.indexEst === this.length - 1 && this.step < 2) {
                return true;
            }
            if (this.user.role === 2 && this.stopTimer && this.showCustomer === 1 && this.indexEst === this.length - 1 && this.step < 2) {
                return true;
            }
            return false;
        },
        shouldShowCreateEstimateButton() {
            return this.user.role === 3 && this.stopTimer && this.indexEst === this.length - 1 && this.step < 2;
        },
        getEstimateMessage() {
            if (this.user.role === 3) {
                return `Время актуальности счета на оплату №${this.idEstimate} истекло. Вы можете создать смету и счет повторно`;
            }
            if (this.user.role === 2) {
                return `Время оплаты по счету №${this.idEstimate} истекло. Ожидайте, когда Исполнитель создаст и пришлет счет еще раз.`;
            }
            return '';
        },
    },
}
</script>

<style scoped>

</style>
