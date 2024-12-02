<template>
    <div id="overlay">
        <div class="modal-dialog" style="margin: 10vh auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center">Отказаться от сделки</h3>
                    <button type="button" class="close" @click="$emit('visibleFalse')" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-center mb-4" style="font-size: 1.25rem; color: #0B3158;">
                        Укажите причину отказа (можно выбрать несколько)
                    </p>
                    <div class="checkBox">
                        <label v-for="rejection in allRejections" :key="rejection.id" class="d-flex align-items-center">
                            <input type="checkbox" class="checkBox__check d-none" :value="rejection.id" v-model="selectedRejections">
                            <span></span>
                            <p class="pl-3 checkBox__title">{{ rejection.title }}</p>
                        </label>
                        <input v-if="selectedRejections.includes(6)" v-model="customReason" type="text" class="form-control mb-3 fs-6 text-start" placeholder="Введите свою причину">
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        <button type="button" class="w-100 btn btn-yes text-white" @click="confirmRejection">
                            Подтвердить отказ от сделки
                        </button>
                    </div>
                    <span>
                        <i style="color: grey">Сделка будет отменена у Заказчика и Исполнителя, без возможности ее продолжить</i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
    name: "RejectDeal",
    props: ['idDeal', 'isAdmin', 'idUser'],
    data() {
        return {
            selectedRejections: [],
            deal: {},
            customReason: null
        }
    },
    computed: {
        ...mapGetters({
            allRejections: 'AllRejectionsDeal',
        }),
    },
    methods: {
        ...mapActions(['rejectDeal', "fetchRejectionDeals"]),
        confirmRejection() {
            const idDirect = this.deal.direct ? this.deal.direct.id : null;
            const idResponse = this.deal.responsesTender ? this.deal.responsesTender.id : null;
            const userRole = this.isAdmin ? this.idUser : user.role;

            this.rejectDeal({
                id: this.idDeal,
                rejectionsDeal: this.selectedRejections,
                user_role: userRole,
                idDirect,
                idResponse,
                reason_cancelled: this.customReason
            }).then(() => {
                this.$emit("visibleFalse");
                this.$emit("updateDeal");
            });
        },
    },
    mounted() {
        this.fetchRejectionDeals();
        this.$store.dispatch('getDeal', { id: this.idDeal }).then(response => {
            this.deal = response;
        });
    }
}
</script>

<style scoped>
/* Add any specific styles for your component here */
</style>
