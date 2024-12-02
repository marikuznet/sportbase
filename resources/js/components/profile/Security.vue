<template>
    <div>
        <navbar></navbar>
        <menu-component-customer v-if="user.role==2" active="6"></menu-component-customer>
        <menu-component-executor v-if="user.role==3" active="6"></menu-component-executor>

        <nav class="navbar navbar-expand-xl navbar-light pt-1 pb-0 menuAuthCompany Mobile d-lg-none">
            <div class="profile_user_background">
                <div class="container">
                    <ul class="navbar-nav nav navbar-collapse d-lg-none profile__user">
                        <li v-on:click.prevent="showOrHideMenu"
                            class="nav-item mx-auto d-flex" style="margin-left: 0 !important; cursor: pointer">
                            <a class="nav-link text-white" href="/profile/security">
                                <img class="img__icon-settings" src="/icons/settings/securityWhite.svg" alt="">
                                Безопасность</a>
                            <img class="arrowDown" src="/icons/selectArowWhite.svg" alt="arrow">
                        </li>
                    </ul>
                    <div class="profileAction navbar-collapse nav navbar-nav" style="width: 100%;" v-if="showProfile">
                        <li v-bind:class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a href="/profile/settings"
                               class="nav-link text-white userIcon">
                                <img class="img__icon-settings" style="width: 20px"
                                     src="/icons/settings/userWhite.svg"
                                     alt="">
                                Профиль пользователя</a>
                        <li v-bind:class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/profile/payment">
                                <img class="img__icon-settings" src="/icons/settings/real-estateWhite.svg"
                                     alt="">
                                Платежные реквизиты</a>
                        </li>
                        <li v-bind:class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a class="nav-link text-white">
                                <img class="img__icon-settings" src="/icons/settings/notificationWhite.svg"
                                     alt="">
                                Оповещания</a>
                        </li>
                        <li v-bind:class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/auth/logout">
                                <img class="img__icon-settings" src="/icons/settings/logout.svg" alt="">
                                Выйти из профиля</a>
                        </li>
                    </div>
                </div>
            </div>
        </nav>
        <main class="main-security">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <left-menu :active="3"></left-menu>
                    </div>
                    <div class="col-lg-8">
                        <div class="block-security shadow h-100">
                            <div class="title__block d-none d-lg-block">
                                <h3 class="caption p-4">Безопасность</h3>
                                <div v-if="error" class="form-wrapper__error mt-1 mb-3">
                                    <svg width="18" height="16" viewBox="0 0 18 16" fill="red"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M17.6692 12.2683L10.7751 1.4659C10.3864 0.856647 9.72272 0.492889 8.99996 0.492889C8.27713 0.492889 7.6135 0.856647 7.22484 1.4659L0.330705 12.2682C-0.0830902 12.9167 -0.110541 13.7387 0.259297 14.4135C0.629135 15.088 1.33673 15.5071 2.10594 15.5071H15.894C16.6632 15.5071 17.3708 15.0881 17.7408 14.4133C18.1105 13.7387 18.083 12.9168 17.6692 12.2683ZM8.99996 13.6888C8.36597 13.6888 7.8521 13.1748 7.8521 12.5409C7.8521 11.9069 8.36603 11.393 8.99996 11.393C9.63394 11.393 10.1478 11.9069 10.1478 12.5409C10.1478 13.1748 9.63388 13.6888 8.99996 13.6888ZM10.591 5.71221L10.0256 9.51872C9.94239 10.079 9.4207 10.4658 8.86044 10.3826C8.40779 10.3153 8.06841 9.96043 7.99863 9.53169L7.38468 5.73271C7.24175 4.84819 7.8429 4.01527 8.72742 3.87234C9.61193 3.72941 10.4449 4.33056 10.5878 5.21508C10.6147 5.38164 10.6137 5.55358 10.591 5.71221Z"
                                            fill="white"/>
                                    </svg>
                                    <span style="color: #FA4B5B; font-size:14px" class="pt-1">{{ error }}</span>
                                </div>
                            </div>
                            <ValidationObserver v-slot="{invalid}" tag="form" @submit.prevent="onChangePassword">
                                <input type="hidden" name="_token" :value="csrf">
                                <div class="reset__password">
                                    <div class="row p-4">
                                        <div class="col-lg-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <label for="">Старый (текущий) пароль
                                                    <span style="color: rgb(243, 122, 138)">*</span>
                                                    <input type="password" name="oldPassword" v-model="oldPassword"
                                                           placeholder="Введите текущий пароль"
                                                           class="input-profile-info mt-2" required
                                                           :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                           autocomplete="off">
                                                </label>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-lg-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <label class="w-100" for="">Новый пароль
                                                    <span style="color: rgb(243, 122, 138)">*</span>
                                                    <input type="password" name="newPassword" v-model="newPassword"
                                                           required placeholder="Новый пароль"
                                                           :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                           class="input-profile-info mt-2" autocomplete="off">
                                                </label>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-lg-4">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <label for="">Новый пароль еще раз
                                                    <span style="color: rgb(243, 122, 138)">*</span>
                                                    <input type="password" name="newPasswordTo" v-model="newPasswordTo"
                                                           placeholder="Повторите новый пароль"
                                                           class="input-profile-info mt-2" required
                                                           autocomplete="off"
                                                           :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }">
                                                </label>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="button-center button button-green ml-4 mb-4 d-block">
                                    Сохранить
                                </button>
                            </ValidationObserver>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from '../NavBar'
import extendedinf from "../ExtendedFooterInformation";
import MenuComponentExecutor from "./menuComponent";
import MenuComponentCustomer from "./profileCustomer/menuComponent";
import VSelect from "@alfsnd/vue-bootstrap-select";
import leftMenu from "./leftMenu";
import axios from "axios";


export default {
    data: function () {
        return {
            showProfile: false,
            lengthError: null,
            oldPassword: null,
            newPassword: null,
            newPasswordTo: null,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    components: {
        MenuComponentCustomer,
        MenuComponentExecutor,
        leftMenu,
        navbar,
        extendedinf,
    },
    computed: {
        error: function () {

        },
        user: function () {
            return window.user;
        },
    },
    methods: {
        showOrHideMenu() {
            this.showProfile = !this.showProfile;
        },
        onChangePassword() {
            this.loading = true;
            axios
                .post('/profile/changePassword', {
                    oldPassword: this.oldPassword,
                    newPassword: this.newPassword,
                    newPasswordTo: this.newPasswordTo,
                })
                .then(res => {
                    this.loading = false;
                    if (res.data == '0') {
                        window.location.href = `/auth`;

                    } else if (res.data == '1') {
                        window.location.href = '/profile/security';
                    }
                });
        }
    }
}
</script>

<style scoped>

</style>
