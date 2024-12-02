<template>
    <div>
        <div class="block__about-company shadow d-none d-lg-block">
            <ul class="navbar-nav nav block__ul-settings w-100">
                <li class="">
                    <div class="block-photo__company mx-auto mt-5" style="height: 200px;width: 200px;">
                        <div class="justify-content-center d-flex align-content-center"
                             style="border-radius: 50%; border: 1px solid #BAC4DF; height: 100%;">
                            <img alt="logo" v-if="this.logoCompany == null" class="img__upload" style="width: 45px"
                                 src="/icons/settings/file-upload.svg">
                            <img class="logo__circle w-100" v-show="this.logoCompany != null"
                                 :src="this.logoCompany" alt="logo">
                        </div>
                    </div>
                    <p class="title__company text-center pt-4 pb-4">{{ titleCompany }}</p>
                </li>
                <li :class="{'is_active': showProfile}">
                    <a v-if="showProfile" class="nav-link text-white">
                        <img class="img__icon-settings" src="/icons/settings/userBlue.svg" alt="">
                        Профиль пользователя
                    </a>
                    <a v-else class="nav-link text-white" href="/profile/settings">
                        <img class="img__icon-settings" src="/icons/settings/user.svg" alt="">
                        Профиль пользователя
                    </a>
                </li>
                <li :class="{'is_active': showPay}">
                    <a v-if="showPay" class="nav-link text-white">
                        <img class="img__icon-settings" src="/icons/settings/real-estateBlue.svg" alt="">
                        Платежные реквизиты</a>
                    <a v-else class="nav-link text-white" href="/profile/payment">
                        <img class="img__icon-settings" src="/icons/settings/real-estate.svg" alt="">
                        Платежные реквизиты</a>
                </li>
                <li :class="{'is_active': showNotify}">
                    <a v-if="showNotify" class="nav-link text-white">
                        <img class="img__icon-settings" src="/icons/settings/notificationBlue.svg"
                             alt="">
                        Оповещания</a>
                    <a v-else class="nav-link text-white" href="/profile/notification">
                        <img class="img__icon-settings" src="/icons/settings/notification.svg" alt="">
                        Оповещания</a>
                </li>
                <li :class="{'is_active': showSecurity}">
                    <a v-if="showSecurity" class="nav-link text-white">
                        <img class="img__icon-settings" src="/icons/settings/securityBlue.svg"
                             alt="">Безопасность</a>
                    <a v-else class="nav-link text-white" href="/profile/security">
                        <img class="img__icon-settings" src="/icons/settings/security.svg" alt="">
                        Безопасность</a>
                </li>
                <li class="">
                    <a class="nav-link text-white" href="/auth/logout">
                        <img class="img__icon-settings" src="/icons/settings/logout.svg" alt="">
                        Выйти из профиля</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    props: ['active'],
    data: function () {
        return {
            showProfile: false, showPay: false, showNotify: false, showSecurity: false, loading: false,
        }
    },
    mounted() {

    },
    created() {
        this.loading = true;
        setTimeout(() => {
            this.isActive();
        })
        this.loading = false;
    },
    methods: {
        isActive() {
            if (this.active == 0) {
                this.showProfile = true;
            }
            if (this.active == 1) {
                this.showPay = true;
            }
            if (this.active == 2) {
                this.showNotify = true;
            }
            if (this.active == 3) {
                this.showSecurity = true;
            }
        }
    },
    computed: {
        ...mapGetters({infoCompanies: 'AllInfoCompanies', titleCompany: 'TitleCompany',}),

        logoCompany() {
            if (this.infoCompanies.image) {
                return '/storage/listings/logos/' + this.user.id + "/" + this.infoCompanies.image;
            } else return null;
        },
        user: function () {
            return window.user;
        },
    }
}
</script>

<style scoped>

</style>
