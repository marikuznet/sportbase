<template>
    <div class="min-vh-100 d-grid" style="grid-template-rows: auto 1fr auto;">
        <navbar></navbar>
        <div class="align-items-center content content-gradient d-flex justify-content-center overflow-hidden
                    position-relative py-5 text-center">
            <div class="position-absolute rectangleBackground d-none d-lg-block w-100 h-100">
                <img src="/images/hockeyBackground.png" alt="back" style="object-fit: cover"
                     class="rectangleBackground__background h-100 w-100"/>
                <div class="rectangleBackground__rectangles position-absolute">
                    <img src="/images/WhiteRectangle.png" alt="" class="rectangleBackground__rectangles-white"/>
                    <img src="/images/BlueRectangle.png" alt="" class="rectangleBackground__rectangles-blue"/>
                    <img src="/images/RedRectangle.png" alt="" class="rectangleBackground__rectangles-red"/>
                </div>
            </div>
            <div class="">
                <div class="top mb-5 my-lg-5">
                    <h1 class="title m-0">СПОРТБАЗА<span>.РФ</span></h1>
                    <em class="comment-italics">"Игра только по твоим правилам"</em>
                </div>
                <form name="body" class="middle" v-on:submit.prevent="onSubmit">
                    <h2 class="middle__title pb-3 mb-0 mb-lg-3">Войти в личный кабинет</h2>
                    <div v-if="error" class="form-wrapper__error mt-1 mb-3">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="#FF9E2C"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.6692 12.2683L10.7751 1.4659C10.3864 0.856647 9.72272 0.492889 8.99996 0.492889C8.27713 0.492889 7.6135 0.856647 7.22484 1.4659L0.330705 12.2682C-0.0830902 12.9167 -0.110541 13.7387 0.259297 14.4135C0.629135 15.088 1.33673 15.5071 2.10594 15.5071H15.894C16.6632 15.5071 17.3708 15.0881 17.7408 14.4133C18.1105 13.7387 18.083 12.9168 17.6692 12.2683ZM8.99996 13.6888C8.36597 13.6888 7.8521 13.1748 7.8521 12.5409C7.8521 11.9069 8.36603 11.393 8.99996 11.393C9.63394 11.393 10.1478 11.9069 10.1478 12.5409C10.1478 13.1748 9.63388 13.6888 8.99996 13.6888ZM10.591 5.71221L10.0256 9.51872C9.94239 10.079 9.4207 10.4658 8.86044 10.3826C8.40779 10.3153 8.06841 9.96043 7.99863 9.53169L7.38468 5.73271C7.24175 4.84819 7.8429 4.01527 8.72742 3.87234C9.61193 3.72941 10.4449 4.33056 10.5878 5.21508C10.6147 5.38164 10.6137 5.55358 10.591 5.71221Z"
                                fill="white"/>
                        </svg>
                        <span class="pl-3 pt-1">{{ error }}</span>
                    </div>
                    <div v-if="nonVerification" class="form-wrapper__error mt-1 mb-3">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="#FF9E2C"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.6692 12.2683L10.7751 1.4659C10.3864 0.856647 9.72272 0.492889 8.99996 0.492889C8.27713 0.492889 7.6135 0.856647 7.22484 1.4659L0.330705 12.2682C-0.0830902 12.9167 -0.110541 13.7387 0.259297 14.4135C0.629135 15.088 1.33673 15.5071 2.10594 15.5071H15.894C16.6632 15.5071 17.3708 15.0881 17.7408 14.4133C18.1105 13.7387 18.083 12.9168 17.6692 12.2683ZM8.99996 13.6888C8.36597 13.6888 7.8521 13.1748 7.8521 12.5409C7.8521 11.9069 8.36603 11.393 8.99996 11.393C9.63394 11.393 10.1478 11.9069 10.1478 12.5409C10.1478 13.1748 9.63388 13.6888 8.99996 13.6888ZM10.591 5.71221L10.0256 9.51872C9.94239 10.079 9.4207 10.4658 8.86044 10.3826C8.40779 10.3153 8.06841 9.96043 7.99863 9.53169L7.38468 5.73271C7.24175 4.84819 7.8429 4.01527 8.72742 3.87234C9.61193 3.72941 10.4449 4.33056 10.5878 5.21508C10.6147 5.38164 10.6137 5.55358 10.591 5.71221Z"
                                fill="white"/>
                        </svg>
                        <span class="pl-3 pt-1">{{ nonVerification }}</span>
                    </div>
                    <div class="middle__inputBlock d-grid">
                        <input type="text" class="inputBlock__mail mt-1 mb-2" placeholder="Ваш email" v-model="login"
                               v-bind:class="{ error: loginError }"/>
                        <input type="password" class="inputBlock__password mt-1 mb-2" placeholder="Пароль"
                               v-model="password" v-bind:class="{ error: passwordError }"/>
                        <p class="inputBlock__radioButton__text my-3 py-1 py-lg-3 mx-auto d-flex justify-content-center">
                            <input type="checkbox" class="save-password-check" name="savePassword"
                                   v-model="savePassword" id="save_password"/>
                            <label class="agreeRules text-start label-circlog" for="save_password">
                                Сохранить пароль
                            </label>
                        </p>
                    </div>
                    <button type="submit"
                            class="middle__button mx-auto d-flex justify-content-center  button button-fill button-register mb-3"
                            :disabled="loading === true">
                        <p class="button__text">Войти</p>
                    </button>
                    <div v-if="false" class="socialButton pt-2">
                        <a v-if="false" href="#"><img src="/icons/facebook.svg" alt="F" class="socialButton__facebook"/></a>
                        <a v-if="false" href="#"><img src="/icons/gmail.svg" alt="G" class="socialButton__gmail"/></a>
                        <a href="#"><img src="/icons/vk.svg" alt="VK" class="socialButton__vk"/></a>
                        <a href="#"><img src="/icons/odnoklassniki.svg" alt="O"
                                         class="socialButton__odnoklassniki"/></a>
                    </div>
                </form>
                <div class="bottom-logIn row mt-3 pt-3 mx-auto mb-0 mb-lg-5">
                    <button class="button-forgotPassword button-dark mb-2 mb-lg-0"
                            onclick="location.href='/auth/forgot-password'">
                        <p>Забыли пароль?</p>
                    </button>
                    <button class="button-checkIn button-dark mt-2 mt-lg-0" onclick="location.href='/auth/registration'"
                            type="button">
                        <p>Регистрация</p>
                    </button>
                </div>
            </div>
        </div>
        <bottom></bottom>
    </div>
</template>

<script>
import bottom from './Bottom.vue'
import navbar from './NavBar.vue'
import axios from 'axios';

export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            loading: false, login: "", password: "", user_timezone: null, loginError: "", passwordError: "",
            authError: "", nonVerification: "", savePassword: false
        }
    },
    computed: {
        error: function () {
            if (this.loginError) {
                return this.loginError;
            }
            if (this.passwordError) {
                return this.passwordError;
            }
            if (this.authError) {
                return this.authError;
            }
            return "";
        }
    },
    methods: {
        onSubmit() {
            this.loginError = "";
            this.passwordError = "";
            this.authError = "";

            if (!this.login) {
                return (this.loginError = "Введите логин");
            }

            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.login)) {
                return (this.loginError = 'Неверный логин или пароль');
            } else this.loginError = '';

            if (!this.password) {
                return (this.passwordError = "Введите пароль");
            }
            this.loading = true;
            axios.post('/auth', {
                email: this.login,
                password: this.password,
                user_timezone: this.user_timezone
            }).then((response) => {
                if (response.data == '0') {
                    return this.authError = "Неверный логин или пароль";
                } else if (response.data == '1')
                    window.location.href = '/';
                else if (response.data == 'nonVerify') {
                    this.nonVerification = "Подтвердите ваш аккаунт на почте";
                } else if (response.data == 'block') {
                    return this.authError = "Ваш аккаунт заблокирован";
                }
            }).catch(function (error) {
                console.log(error);
            });

            this.loading = false;
        },
    },
    components: {
        bottom,
        navbar,
    },
    mounted() {
        this.user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    }
}
</script>

<style>
.save-password-check {
    width: 25px;
    height: 25px;
    cursor: pointer;
    -moz-appearance: none;
    appearance: none;
    -webkit-appearance: none;
    background-color: white;
    border-radius: 50%;
    display: inline-flex;
    min-width: 25px;
    min-height: 25px;
}

.save-password-check:checked {
    width: 25px;
    height: 25px;
    cursor: pointer;
    background-color: #e45868;
    border: 5px solid white;
    min-width: 25px;
    min-height: 25px;
}
</style>
