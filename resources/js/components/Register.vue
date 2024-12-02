<template>
    <div class="min-vh-100 d-grid" style="grid-template-rows: auto 1fr auto;">
        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <div class="content-gradient text-center py-5 position-relative content overflow-hidden">
            <div class="position-absolute rectangleBackground d-none d-lg-block h-100 w-100">
                <img src="/images/girlBackground.png" alt="back" style="object-fit: cover"
                     class="rectangleBackground__background h-100 w-100">
                <div class="rectangleBackground__rectangles position-absolute">
                    <img src="/images/WhiteRectangle.png" alt="" class="rectangleBackground__rectangles-white ">
                    <img src="/images/BlueRectangle.png" alt="" class="rectangleBackground__rectangles-blue ">
                    <img src="/images/RedRectangle.png" alt="" class="rectangleBackground__rectangles-red  ">
                </div>
            </div>
            <div class="top mb-2 mt-lg-5">
                <h2 class="middle__title pb-3 mb-0 mb-lg-3">Регистрация</h2>
                <div v-if="error" class="form-wrapper__error mt-1 mb-3">
                    <svg width="18" height="16" viewBox="0 0 18 16" fill="#FF9E2C" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.6692 12.2683L10.7751 1.4659C10.3864 0.856647 9.72272 0.492889 8.99996 0.492889C8.27713 0.492889 7.6135 0.856647 7.22484 1.4659L0.330705 12.2682C-0.0830902 12.9167 -0.110541 13.7387 0.259297 14.4135C0.629135 15.088 1.33673 15.5071 2.10594 15.5071H15.894C16.6632 15.5071 17.3708 15.0881 17.7408 14.4133C18.1105 13.7387 18.083 12.9168 17.6692 12.2683ZM8.99996 13.6888C8.36597 13.6888 7.8521 13.1748 7.8521 12.5409C7.8521 11.9069 8.36603 11.393 8.99996 11.393C9.63394 11.393 10.1478 11.9069 10.1478 12.5409C10.1478 13.1748 9.63388 13.6888 8.99996 13.6888ZM10.591 5.71221L10.0256 9.51872C9.94239 10.079 9.4207 10.4658 8.86044 10.3826C8.40779 10.3153 8.06841 9.96043 7.99863 9.53169L7.38468 5.73271C7.24175 4.84819 7.8429 4.01527 8.72742 3.87234C9.61193 3.72941 10.4449 4.33056 10.5878 5.21508C10.6147 5.38164 10.6137 5.55358 10.591 5.71221Z"
                            fill="white"/>
                    </svg>
                    <span class="pl-3 pt-1">{{ error }}</span>
                </div>
                <div v-if="success && !error" class="form-wrapper__error mt-1 mb-3">
                    <svg width="18" height="16" viewBox="0 0 18 16" fill="#FF9E2C" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.6692 12.2683L10.7751 1.4659C10.3864 0.856647 9.72272 0.492889 8.99996 0.492889C8.27713 0.492889 7.6135 0.856647 7.22484 1.4659L0.330705 12.2682C-0.0830902 12.9167 -0.110541 13.7387 0.259297 14.4135C0.629135 15.088 1.33673 15.5071 2.10594 15.5071H15.894C16.6632 15.5071 17.3708 15.0881 17.7408 14.4133C18.1105 13.7387 18.083 12.9168 17.6692 12.2683ZM8.99996 13.6888C8.36597 13.6888 7.8521 13.1748 7.8521 12.5409C7.8521 11.9069 8.36603 11.393 8.99996 11.393C9.63394 11.393 10.1478 11.9069 10.1478 12.5409C10.1478 13.1748 9.63388 13.6888 8.99996 13.6888ZM10.591 5.71221L10.0256 9.51872C9.94239 10.079 9.4207 10.4658 8.86044 10.3826C8.40779 10.3153 8.06841 9.96043 7.99863 9.53169L7.38468 5.73271C7.24175 4.84819 7.8429 4.01527 8.72742 3.87234C9.61193 3.72941 10.4449 4.33056 10.5878 5.21508C10.6147 5.38164 10.6137 5.55358 10.591 5.71221Z"
                            fill="white"/>
                    </svg>
                    <span class="pl-3 pt-1">{{ success }}</span>
                </div>
                <div class="buttonUserMode row row-cols-2  mt-3 pt-3 mx-auto mb-0 ">
                    <!--    button-fill активная кнопка (розовая) -->
                    <div class="col ">
                        <button v-bind:class="{button_fill: activeLink === 1}" v-on:click.prevent="activeLink = 1"
                                @click="isCustomer = true"
                                class="button-customer button p-0 py-4 w-100">
                            <p class="mx-auto">Я Заказчик</p>
                        </button>
                    </div>
                    <div class="col ">
                        <button v-bind:class="{button_fill: activeLink === 2}" v-on:click.prevent="activeLink = 2"
                                id="button-executive" @click="isCustomer = false"
                                type="button" class="button-executive button p-0 py-4 w-100">
                            <p class="mx-auto">Я Исполнитель</p>
                        </button>
                    </div>
                </div>

            </div>
            <form class="middle" v-on:submit.prevent="onRegister">
                <div class="middle">
                    <div class="middle__inputBlock d-grid">
                        <input v-model="form.name" class="inputBlock__password mt-1 mb-2" placeholder="Ваше имя"
                               type="text" v-bind:class="{ error: nameError }">
                        <input v-model="form.email" type="text" class="inputBlock__mail mt-1 mb-2"
                               placeholder="Ваш email" :class="{ error: emailError }" @input="validateEmail">
                        <div v-if="errorsEmail" class="error-message text-danger fs-5">{{ errorsEmail }}</div>
                        <input hidden v-model="form.phone" type="text" class="inputBlock__password mt-1 mb-2"
                               placeholder="Ваш телефон" v-bind:class="{ error: phoneError }">
                        <input v-model="form.password" type="password" class="inputBlock__password mt-1 mb-2"
                               placeholder="Ваш пароль" v-bind:class="{ error: passwordError }" readonly
                               onfocus="this.removeAttribute('readonly');">
                        <div v-if="errorMessage" class="error-message text-danger fs-5">{{ errorMessage }}</div>

                        <textarea v-model="form.info" v-if="activeLink === 2" class="inputBlock__info mt-1 mb-2" id=""
                                  rows="4"
                                  placeholder="Информация об объекте"></textarea>
                        <p class="inputBlock__radioButton__text my-3 py-1 py-lg-3 mx-auto d-flex justify-content-center">
                            <input type="radio" class="inputBlock__radioButton radio" name="agreeRules"
                                   :value="true" :checked="true" id="agreeRules"
                                   style="width: 25px !important; min-width: 25px">

                            <label class="agreeRules text-start label-circl" for="agreeRules">Я согласен(на) с Политикой
                                обработки персональных данных и Правилами использования платформы.</label>
                        </p>
                    </div>
                    <div class="enterCode">
                    </div>
                    <button type="submit"
                            class="middle__button button button-register button-fill mb-3 mx-auto d-block">
                        <p class="button__text">Регистрация</p>
                    </button>
                    <div v-if="false" class="socialButton pt-2">
                        <a href="#"><img src="/icons/facebook.svg" alt="F" class="socialButton__facebook"></a>
                        <a href="#"><img src="/icons/gmail.svg" alt="G" class="socialButton__gmail"></a>
                        <a href="#"><img src="/icons/vk.svg" alt="VK" class="socialButton__vk"></a>
                        <a href="#"><img src="/icons/odnoklassniki.svg" alt="O"
                                         class="socialButton__odnoklassniki"></a>
                    </div>
                </div>
            </form>
            <form action="/auth">
                <div class="bottom-logIn row row-cols-1 row-cols-lg-2 mt-3 pt-3 mx-auto mb-0 mb-lg-5">
                    <button type="submit" class="button-logIn button-dark col mb-2 mb-lg-0">
                        <p>Уже зарегистрированы?</p>
                    </button>
                </div>
            </form>
        </div>
        <bottom></bottom>
    </div>
</template>

<script>
import bottom from './Bottom.vue'
import navbar from './NavBar.vue'
import axios from "axios";

export default {
    components: {bottom, navbar,},
    data: function () {
        return {
            form: {name: null, email: null, phone: null, password: null, info: null, role: null}, msg: [],
            nameError: "", phoneError: "", passwordError: "", emailError: "", emaildentityError: "", activeLink: 1,
            reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            isCustomer: true, success: "", errorMessage: '', errorsEmail: '', loading: false, isRegister: false
        }
    },
    computed: {
        error: function () {
            if (this.nameError) return this.nameError;
            if (this.emailError) return this.emailError;
            if (this.passwordError) return this.passwordError;
            if (this.emaildentityError) return this.emaildentityError;
            /*if (this.phoneError) {
                return this.phoneError;
            }*/
            return "";
        }
    },
    methods: {
        onRegister() {
            this.nameError = "";
            this.phoneError = "";
            this.passwordError = "";
            this.emailError = "";
            this.emaildentityError = "";

            if (!this.form.name) return (this.nameError = "Введите имя");
            if (!this.form.email) return (this.emailError = "Введите почту");
            if (!this.reg.test(this.form.email)) return (this.emailError = "Неверный формат записи email");
            if (!this.form.password) return (this.passwordError = "Введите пароль");
            if (this.errorMessage) return;
            if (this.errorsEmail) return;
            if (!this.isCustomer) {
                this.form.role = 3;
            } else this.form.role = 2;

            this.loading = true;
            axios.post('/auth/registration', {
                name: this.form.name,
                email: this.form.email,
                password: this.form.password,
                role: this.form.role,
                brief_info: this.form.info
            }).then(res => {
                if (res.data === 1) {
                    this.loading = false;
                    return (this.emaildentityError = "Пользователь с таким email уже существует");
                }
                this.loading = false;
                this.success = "Пожалуйста, подтвердите свою электронную почту";
                this.form.name = "";
                this.form.email = "";
                this.form.password = "";
                this.form.info = "";
                this.errorMessage = '';
                this.errorsEmail = '';
                this.isRegister = true;
                // window.location.href = `/`;
            });
            ///SMS-VERIFICATION
            /*if (!this.form.phone) {
                return (this.phoneError = "Введите номер телефона");
            }
            this.loading = true;
            axios
                .post('/sms-verification', {
                    params: {
                        phone: this.form.phone
                    }
                })
                .then(res => {
                    this.loading = false;
                    //window.location.href = `/home`;
                });*/
        },
        validateEmail() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const email = this.form.email.trim();
            if (!email || !emailPattern.test(email)) {
                this.errorsEmail = 'Пожалуйста, введите корректный email-адрес';
            } else {
                this.errorsEmail = '';
            }
        },
    },
    watch: {
        'form.password': {
            handler: function (value) {
                const minLength = 6;
                if (value.length < minLength && !this.isRegister) {
                    this.errorMessage = 'Пароль должен содержать более 6 символов';
                } else {
                    this.errorMessage = '';
                    this.isRegister = false;
                }
            }, deep: true
        }
    }
}

</script>
