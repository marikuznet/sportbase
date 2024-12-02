<template>
    <div>
        <navbar></navbar>
        <div class="container-fluid" style="background-color: white">
            <div class="row justify-content-center pb-5 align-items-center">
                <div class="col-md-6">
                    <h3 class="text-white text-center">Восстановление пароля</h3>
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="">
                                <input type="hidden" name="token" value="">
                                <div class="form-group row p-5 pb-0">
                                    <p class="mb-5" style="color: black; font-style: italic; font-size: 15px; color: darkgray">
                                        Забыли пароль? Не беспокойтесь, мы поможем Вам восстановить доступ к Вашей
                                        учетной записи. Пожалуйста, введите свой номер телефона или адрес электронной
                                        почты, чтобы мы могли отправить Вам инструкции по восстановлению пароля.
                                    </p>
                                    <div v-if="error" class="form-wrapper__error mt-1 mb-3 justify-content-center">
                                        <svg width="18" height="16" viewBox="0 0 18 16" fill="#e45868"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.6692 12.2683L10.7751 1.4659C10.3864 0.856647 9.72272 0.492889 8.99996 0.492889C8.27713 0.492889 7.6135 0.856647 7.22484 1.4659L0.330705 12.2682C-0.0830902 12.9167 -0.110541 13.7387 0.259297 14.4135C0.629135 15.088 1.33673 15.5071 2.10594 15.5071H15.894C16.6632 15.5071 17.3708 15.0881 17.7408 14.4133C18.1105 13.7387 18.083 12.9168 17.6692 12.2683ZM8.99996 13.6888C8.36597 13.6888 7.8521 13.1748 7.8521 12.5409C7.8521 11.9069 8.36603 11.393 8.99996 11.393C9.63394 11.393 10.1478 11.9069 10.1478 12.5409C10.1478 13.1748 9.63388 13.6888 8.99996 13.6888ZM10.591 5.71221L10.0256 9.51872C9.94239 10.079 9.4207 10.4658 8.86044 10.3826C8.40779 10.3153 8.06841 9.96043 7.99863 9.53169L7.38468 5.73271C7.24175 4.84819 7.8429 4.01527 8.72742 3.87234C9.61193 3.72941 10.4449 4.33056 10.5878 5.21508C10.6147 5.38164 10.6137 5.55358 10.591 5.71221Z"
                                                fill="#e45868"/>
                                        </svg>
                                        <span class="pl-3 pt-1 text-blue">{{ error }}</span>
                                    </div>
                                    <h5 v-if="false" class="pt-4">Введите свой логин</h5>
                                    <div class="row pb-4">
                                        <div class="col-md-4 pt-3"><label>
                                            <input type="radio" name="reset" v-model="resetPhone" :value="true">
                                        </label> <span style="font-size: 18px">Номер телефона</span>
                                        </div>
                                        <div class="col-md-6">
                                            <input style="font-size: 18px" class="form-control" type="text"
                                                   placeholder="+7123456789" v-model="phone" maxlength="11">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 pt-3"><label>
                                            <input type="radio" name="reset" checked v-model="resetPhone"
                                                   :value="false">
                                        </label> <span style="font-size: 18px">E-mail адрес</span>
                                        </div>
                                        <div class="col-md-6">
                                            <input style="font-size: 18px" id="email" class="form-control" type="email"
                                                   placeholder="mail@gmail.com" name="email" v-model="login">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="d-flex justify-content-center">
                                        <span style="font-size: 18px" v-if="message !== null">
                                            {{ message }}
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <form class="middle" v-on:submit.prevent="onReset" v-if="!send">
                                    <div class="form-group row mb-0">
                                        <div>
                                            <button type="submit" :disabled="loading"
                                                    class="middle__button button button-register button-fill mb-3 mx-auto d-block">
                                                <p class="button__text">Восстановить пароль</p>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <extendedinf></extendedinf>
    </div>

</template>

<script>
import navbar from './NavBar.vue'
import extendedinf from './ExtendedFooterInformation.vue'
import axios from "axios";


export default {
    data() {
        return {
            loading: false, send: false,
            login: "", phone: "",
            loginError: "", phoneError: "",
            message: null, resetPhone: false,
        }
    },
    components: {
        navbar,
        extendedinf
    },
    computed: {
        error: function () {
            if (this.loginError) {
                return this.loginError;
            }
            if (this.phoneError) {
                return this.phoneError;
            }
            return "";
        }
    },
    methods: {
        onReset() {
            this.loginError = "";
            this.phoneError = "";

            if (this.resetPhone && (!this.phone || this.phone === '')) {
                this.phoneError = "Введите номер телефона";
                return;
            }

            if (!this.resetPhone && (!this.login || this.login === '')) {
                this.loginError = "Введите почту";
                return;
            }

            if (this.resetPhone && !/^((11|\+7)[\- ]?)?\(?\d{3,5}\)?[\- ]?\d{1}[\- ]?\d{1}[\- ]?\d{1}[\- ]?\d{1}[\- ]?\d{1}(([\- ]?\d{1})?[\- ]?\d{1})?$/.test(this.phone)) {
                this.phoneError = 'Номер телефона не соответствует формату';
                return;
            }

            this.loading = true;
            axios.post('/auth/forgot-password/mail', {
                login: this.resetPhone ? "" : this.login,
                phone: this.resetPhone ? this.phone : ""
            })
                .then(res => {
                    if (res.data == '0') {
                        this.message = "Код для восстановления пароля отправлен в сообщении";
                    } else {
                        this.send = true;
                        this.message = "Ссылка для восстановления пароля отправлена на почту";
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 400) {
                        this.loading = false;
                        if (this.resetPhone && (!this.phone || this.phone === '')) {
                            this.phoneError = "Введите номер телефона";
                        }

                        if (!this.resetPhone && (!this.login || this.login === '')) {
                            this.loginError = "Введите почту";
                        }

                        if (!/^((11|\+7)[\- ]?)?\(?\d{3,5}\)?[\- ]?\d{1}[\- ]?\d{1}[\- ]?\d{1}[\- ]?\d{1}[\- ]?\d{1}(([\- ]?\d{1})?[\- ]?\d{1})?$/.test(this.phone)) {
                            this.phoneError = 'Номер телефона не соответствует формату';
                        }
                    }
                })
                .finally(() => {
                    this.send = false;
                });
        }
    },
    mounted() {
    }
}
</script>

<style scoped>

</style>
