<template>
    <div>
        <div class="logo d-flex justify-content-center mb-3">
            <img src="/icons/logo.png" alt="logo">
        </div>
        <div class="document-payment" v-if="status === 3">
            <div class="notif d-flex align-items-center p-3 justify-content-between">
                <div class="notif__text">
                    <img class="mr-4" src="/icons/stages/check-mark.svg" alt="">
                    <div class="w-100">
                        <p v-if="user.role == 2">
                            <b>Поздравляем,</b> оплата по счету №{{ estimateId }} успешно получена. Исполнитель так же
                            уведомлен о получении оплаты и приступил к выполнению заказа.</p>
                        <p v-else-if="user.role == 3">
                            <b>Поздравляем,</b> оплата по счету №{{ estimateId }} успешно получена. Вы можете
                            приступить к выполению заказа</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="time_to_end-estimate d-flex align-items-center mt-5 pt-4 pb-3 position-relative"
             v-else-if="payment === 0" style="border: 1px solid #BAC4DF;border-radius: 10px;">
            <div class="details d-flex pr-4 pl-4 position-relative w-100">
                <div class="estimate shadow d-flex p-3 align-items-center w-50 mr-3">
                    <p>После оплаты уведомите систему, нажав на кнопку подтверждения</p>
                    <button type="button" class="ml-5" @click="confirmEstimate">
                        Уведомить об оплате
                    </button>
                </div>
                <div class="cancel shadow d-flex p-3 align-items-center w-50">
                    <p>Если вас <span style="color: #E45868">не устраивают условия</span>, отклоните
                        предложение
                    </p>
                    <button type="button" @click="$emit('reject')" class="button-icon ml-5">Отклонить
                    </button>
                </div>
            </div>
        </div>

        <div class="upload-payment mt-5" v-else-if="payment === 1 && documents == null">
            <div class="notif d-flex align-items-center p-3 justify-content-between">
                <div class="notif__text mr-lg-4">
                    <img class="mr-4" src="/icons/warning-green.svg">
                    <div class="w-100">
                        <p>Вы подтвердили оплату по счету №{{ estimateId }}. Для ускорения подтверждения
                            прикрепите документ подтверждающий оплату</p>
                    </div>
                </div>
                <div class="btn_arbitration upload-btn">
                    <input type="file" ref="file" class="d-none" id="vue-file-upload-input"
                           @change="addImage">
                    <button v-if="currentImage == null" class="btn-base button-icon border-blue" @click="addDocument">
                        Загрузить файл
                        <img class="ml-3" src="/icons/Solid.svg" alt="">
                    </button>
                    <p v-else-if="currentImage != null">Файл загружен</p>
                </div>
                <div class="btn_arbitration" v-if="currentImage != null">
                    <button class="btn-base button-icon button-blue" @click="uploadImage">
                        Подтвердить оплату
                    </button>
                </div>
            </div>
        </div>

        <div class="document-payment mt-5" v-else-if="payment === 1 && documents != null">
            <div class="notif d-flex flex-wrap align-items-center p-3 justify-content-between">
                <div class="notif__text">
                    <img class="mr-4" src="/icons/wallet.svg" alt="">
                    <div class="w-100">
                        <p>Вы уведомили об оплате по счету №{{ estimateId }}, так же прикрепили
                            документ об оплате. Ожидайте подтверждении оплаты от системы.</p>
                    </div>
                </div>
                <div class="btn_arbitration">
                    <button style="width: 255px; border-radius: 5px" class="btn-base button-icon border-green"
                            @click="showDocument">
                        Документ об оплате
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "NotifEstimate",
    props: {
        get_estimateId: {type: Number},
        getPayment: {type: Number},
        get_dealId: {type: Number},
        get_documents: {type: String, Default: null},
        get_status: {type: Number}
    },
    data() {
        return {
            currentImage: null
        }
    },
    computed: {
        user: function () {
            return window.user;
        },
        status() {
            return this.$props.get_status;
        },
        payment() {
            return this.$props.getPayment;
        },
        documents() {
            return this.$props.get_documents;
        },
        estimateId() {
            return this.$props.get_estimateId;
        }
    },
    methods: {
        addDocument() {
            document.getElementById("vue-file-upload-input").click();
        },
        addImage(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.currentImage = this.$refs.file.files.item(0);
        },
        async uploadImage() {
            let formData = new FormData();
            formData.append("file", this.currentImage);
            try {
                await axios.post(`/transaction/estimate/uploadPayment/${this.$props.get_dealId}/${this.estimateId}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.currentImage = null;
                await this.$store.dispatch("getDeal", {id: this.$props.get_dealId});
            } catch (error) {
                console.error('Error uploading image:', error);
            }
        },
        async confirmEstimate() {
            try {
                await this.$store.dispatch("estimateConfirmation", {id: this.estimateId});
                this.$emit('updateEstimate');
                await this.$store.dispatch("getDeal", {id: this.$props.get_dealId});
            } catch (error) {
                console.error('Error confirming estimate:', error);
            }
        },
        showDocument() {
            window.open(`/storage/listings/payment/${this.$props.get_dealId}/${this.documents}`);
        }
    }

}
</script>

<style scoped>

</style>
