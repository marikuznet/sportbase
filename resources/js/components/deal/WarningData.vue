<template>
    <div v-if="shouldShowWarning" class="block-payment-notif">
        <div class="logo d-flex justify-content-center mb-3">
            <img src="/icons/logo.png" alt="">
        </div>
        <div class="notif d-lg-flex d-none align-items-center p-3 justify-content-between">
            <img class="mr-4" src="/icons/warning-red.svg" alt="">
            <div class="w-100">
                <p>{{ warningText }}</p>
            </div>
            <div class="btn_arbitration" v-if="shouldShowSettingsButton">
                <button type="button" @click="showSettings"
                        style="width: 255px; border-radius: 5px" class="btn-base button-icon border-blue">
                    {{ warningButtonLabel }}
                </button>
            </div>
        </div>
        <div class="notif d-lg-none align-items-center p-3 justify-content-between">
            <div class="d-flex">
                <div class="flex-grow-0 mr-3">
                    <img width="24px" src="/icons/warning-red.svg" alt="">
                </div>
                <div class="flex-grow-1">
                    <p style="color: #59728B" class="pb-4">{{ warningText }}</p>
                </div>
            </div>
            <div class="row" v-if="shouldShowSettingsButton">
                <div class="col-12">
                    <div class="btn_arbitration text-center">
                        <button style="width: 255px; border-radius: 5px" type="button"
                                @click="showSettings" class="btn-base button-icon border-blue">
                            {{ warningButtonLabel }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-4 d-block">
            <p class="ago">Сегодня</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        warning: {
            type: Number,
            required: true,
        },
    },
    name: "WarningData",
    data() {
        return {
            warningText: "",
            warningButtonLabel: "",
        }
    },
    computed: {
        shouldShowWarning() {
            return this.props_Warning !== null && this.props_Warning >= 0 && this.props_Warning <= 3;
        },
        shouldShowSettingsButton() {
            return this.props_Warning !== 2 && this.props_Warning !== 3;
        },
        props_Warning() {
            return this.$props.warning;
        },
    },
    methods: {
        showSettings() {
            const urls = {
                0: "/profile/settings",
                1: "/profile/payment",
            };
            const url = urls[this.props_Warning];
            if (url) {
                window.location.href = url;
            }
        },
    },
    mounted() {
        const warningTexts = [
            "Для участия в заказе заполните полностью информацию о вашей компании на странице",
            "Для участия в заказе укажите платежные данные (реквизиты) компании в аккаунте на странице",
            "Сделка отклонена Заказчиком",
            "Сделка отклонена Исполнителем",
        ];
        this.warningText = warningTexts[this.props_Warning] || "";

        const warningButtons = [
            "Профиль пользователя",
            "Платежные реквизиты"
        ];
        this.warningButtonLabel = warningButtons[this.props_Warning] || "";
    }
}
</script>

<style scoped>

</style>
