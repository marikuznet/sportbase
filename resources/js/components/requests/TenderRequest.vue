<template>
    <div>
        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <div class="main-tender-request">
            <div class="container">
                <nav aria-label="breadcrumb" class="pt-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Главная</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Заявка на проведение тендера</li>
                    </ol>
                </nav>
                <div class="request-tender shadow mb-3">
                    <div class="title_page text-center pt-5 pl-3 pb-3">
                        <p class="title">Заявка на проведение тендера</p>
                        <p class="subtitle">Созданная заявка на проведение тендера позволяет для заказчиков</p>
                    </div>
                    <div class="block-hr d-flex justify-content-center pb-4">
                        <hr>
                    </div>
                    <div class="block_opportunities pl-4 pr-4 pb-3">
                        <div class="row">
                            <div class="col-lg-6" v-for="(options, index) in [firstColumnOptions, secondColumnOptions]"
                                 :key="index">
                                <div class="opportunity d-flex align-items-center" v-for="option in options"
                                     :key="option">
                                    <span class="check-opportunity d-flex"></span>
                                    <p>{{ option }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tender-body shadow">
                    <div class="row p-4">
                        <div class="col-1"></div>
                        <div class="col-lg-10 col-sm-12">
                            <create-tender :header-id="'tender-request-header'" :body-id="'tender-request-body'"
                                           :send-request="isSend" @changeSendRequest="isSend = false" :is-save-storage="true">
                                <template #customer-info v-if="customerInfo.user_id">
                                    <div class="customer align-items-center" :class="{'d-lg-flex d-none': true}">
                                        <p class="caption mr-2">Заказчик</p>
                                        <div class="circleUser mr-2" v-if="customerInfo.image">
                                            <img
                                                :src="`/storage/listings/logos/${customerInfo.user_id}/${customerInfo.image}`"
                                                class="userImage w-100 h-100">
                                        </div>
                                        <p class="caption">{{ getCustomerName(customerInfo) }}</p>
                                    </div>
                                    <div v-if="customerInfo.typePerson === 0" class="notification">
                                        <div class="text__Notification d-flex p-3">
                                            <div class="image__notification d-flex pr-4 mr-3">
                                                <img src="/icons/stages/information.svg" alt="" style="width: 20px">
                                            </div>
                                            <p class="text">
                                                Также вы можете переключить свой аккаунт на пользователя - физическое
                                                лицо и создавать заявки от его имени. Для этого перейдите на страницу
                                                <a href="/profile/settings">"Профиль и настройки"</a>.
                                            </p>
                                        </div>
                                    </div>
                                </template>
                            </create-tender>
                        </div>
                        <div class="col-1"></div>
                    </div>
                </div>
                <div class="mt-5" v-if="!hasInfoCompany && !nonAuth">
                    <div class="title_page text-center">
                        <p class="subtitle">Заполните информацию о компании и отправьте заявку</p>
                        <a href="/profile/settings" class="subtitle"><u>Профиль пользователя</u></a>
                    </div>
                </div>

                <div v-if="user && customerInfo.user_id">
                    <div class="buttonSend mt-5 d-lg-block d-none">
                        <button type="button" style="width: 390px;" @click="sendRequest"
                                class="top__button button button-fill d-block mx-auto my-0 my-lg-3 mb-2 p-lg-4 p-3 d-flex justify-content-around">
                            <p class="fw-bold">Отправить заявку</p>
                            <img src="/icons/tenders/list.svg" alt="">
                        </button>
                    </div>

                    <div class="d-block d-lg-none mr-5 ml-5 mt-n4 pb-4">
                        <button style="width: 390px" type="button" class="w-100 top__button button button-fill d-block mx-auto my-0 my-lg-3 mb-2 p-lg-4 p-3
                             d-flex justify-content-around" @click="sendRequest">
                            <p class="fw-bold">Отправить заявку</p>
                            <img src="/icons/tenders/list.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>

            <div v-show="nonAuth" class="container sb-non-register">
                <div class="non-authorized-tender shadow mt-3">
                    <div class="row p-4">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="title_page text-center">
                                <p class="title">Чтобы отправить заявку - вам нужно войти в аккаунт</p>
                            </div>

                            <div class="button-block-request d-flex justify-content-center pb-2">
                                <button :class="{'button-blue': showRegister, 'button-border': showLogin}"
                                        @click="switchLogin" class="button mr-2">
                                    Создать
                                </button>
                                <button :class="{'button-blue': showLogin, 'button-border': showRegister}"
                                        @click="switchRegister" class="button">
                                    Авторизоваться
                                </button>
                            </div>

                            <div v-if="error || authError"
                                 class="d-block form-wrapper__error mb-3 mt-1 text-center w-100" style="color: #F37A8A">
                                <svg width="18" height="16" viewBox="0 0 18 16" fill="#e45868"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.6692 12.2683L10.7751 1.4659C10.3864 0.856647 9.72272 0.492889 8.99996 0.492889C8.27713 0.492889 7.6135 0.856647 7.22484 1.4659L0.330705 12.2682C-0.0830902 12.9167 -0.110541 13.7387 0.259297 14.4135C0.629135 15.088 1.33673 15.5071 2.10594 15.5071H15.894C16.6632 15.5071 17.3708 15.0881 17.7408 14.4133C18.1105 13.7387 18.083 12.9168 17.6692 12.2683ZM8.99996 13.6888C8.36597 13.6888 7.8521 13.1748 7.8521 12.5409C7.8521 11.9069 8.36603 11.393 8.99996 11.393C9.63394 11.393 10.1478 11.9069 10.1478 12.5409C10.1478 13.1748 9.63388 13.6888 8.99996 13.6888ZM10.591 5.71221L10.0256 9.51872C9.94239 10.079 9.4207 10.4658 8.86044 10.3826C8.40779 10.3153 8.06841 9.96043 7.99863 9.53169L7.38468 5.73271C7.24175 4.84819 7.8429 4.01527 8.72742 3.87234C9.61193 3.72941 10.4449 4.33056 10.5878 5.21508C10.6147 5.38164 10.6137 5.55358 10.591 5.71221Z"
                                        fill="#e45868"/>
                                </svg>
                                <span class="pl-3 pt-1">{{ error || authError }}</span>
                            </div>

                            <div class="row tabRegister justify-content-center" v-if="showRegister">
                                <div class="col-lg-8">
                                    <form @submit.prevent="onRegister">
                                        <div class="form-group row d-flex align-items-center">
                                            <label class="col-lg-4 caption">Ваше имя</label>
                                            <div class="col-lg-8">
                                                <input type="text" placeholder="Иван Иванов"
                                                       class="input-profile-info mt-1" v-model="form.name"
                                                       :class="{ error: nameError }">
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex align-items-center">
                                            <label class="col-lg-4 caption">Email адрес</label>
                                            <div class="col-lg-8">
                                                <input type="email" placeholder="ivan@ivanov.ru"
                                                       class="input-profile-info mt-1" v-model="form.email"
                                                       :class="{ error: emailError }" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex align-items-center">
                                            <label class="col-lg-4 caption">Пароль</label>
                                            <div class="col-lg-8">
                                                <input type="password" placeholder="Ваш пароль"
                                                       class="input-profile-info mt-1" v-model="form.password"
                                                       :class="{ error: passwordError }" autocomplete="off" readonly
                                                       onfocus="this.removeAttribute('readonly');">
                                            </div>
                                        </div>
                                        <div class="row pt-4">
                                            <button type="submit"
                                                    class="middle__button mx-auto d-flex justify-content-center button button-fill button-register mb-3">
                                                <p class="button__text">Зарегистрироваться</p>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row tabLogin justify-content-center" v-if="showLogin">
                                <div class="col-lg-8">
                                    <form @submit.prevent="onSubmit">
                                        <div class="form-group row d-flex align-items-center">
                                            <label class="col-lg-4 caption">Ваш логин</label>
                                            <div class="col-lg-8">
                                                <input type="text" placeholder="Ваш логин"
                                                       class="input-profile-info mt-1" v-model="login"
                                                       :class="{ error: loginError }">
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex align-items-center">
                                            <label class="col-lg-4 caption">Ваш пароль</label>
                                            <div class="col-lg-8">
                                                <input type="password" placeholder="Ваш пароль"
                                                       class="input-profile-info mt-1" v-model="password"
                                                       :class="{ error: passwordError }" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row pt-4">
                                            <button type="submit"
                                                    class="middle__button mx-auto d-flex justify-content-center button button-fill button-register mb-3">
                                                <p class="button__text">Войти</p>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                </div>
            </div>

        </div>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from '../NavBar'
import extendedinf from "../ExtendedFooterInformation";
import {mapActions, mapGetters} from "vuex";
import axios from "axios";
import CreateTender from "../tenders/TenderModal";

export default {
    data() {
        return {
            loading: false,
            showRegister: true,
            showLogin: false,
            nonAuth: false,
            firstColumnOptions: [
                "Запрос сразу нескольких интересующих вас баз одним кликом",
                "Только прямые цены спортивных баз и отелей",
                "Поддержка персонального менеджера на всех этапах поездки",
                "Полный туристический пакет для вашей команды"
            ],
            secondColumnOptions: [
                "Запрос сразу нескольких интересующих вас баз одним кликом",
                "Только прямые цены спортивных баз и отелей",
                "Поддержка персонального менеджера на всех этапах поездки",
                "Полный туристический пакет для вашей команды"
            ],
            login: "",
            password: "",
            loginError: "",
            passwordError: "",
            authError: false,
            form: {name: null, email: null, password: null},
            nameError: "",
            emailError: "",
            reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            isSend: false,
            emaildentityError: ""
        };
    },
    components: {
        CreateTender,
        navbar,
        extendedinf
    },
    async created() {
        this.loading = true;
        if (!this.user) this.nonAuth = true;
        if (this.user) await this.$store.dispatch("fetchInfoCompanies");
        this.loading = false;
    },
    computed: {
        ...mapGetters({infoCompany: "AllInfoCompanies"}),
        user() {
            return window.user;
        },
        hasInfoCompany() {
            return Object.keys(this.infoCompany).length > 0;
        },
        customerInfo() {
            return this.infoCompany || false;
        },
        error() {
            return this.nameError || this.emailError || this.loginError || this.passwordError || this.emaildentityError || "";
        }
    },
    methods: {
        getCustomerName(customerInfo) {
            if (!customerInfo) return '';

            if (customerInfo.typePerson == 0) {
                return customerInfo.title || 'Название компании - заказчика';
            } else if (customerInfo.typePerson == 1) {
                return `${customerInfo.surname} ${customerInfo.name}`;
            }

            return '';
        },
        switchRegister() {
            this.showRegister = !this.showRegister;
            this.showLogin = !this.showLogin;
        },
        switchLogin() {
            this.showRegister = !this.showRegister;
            this.showLogin = !this.showLogin;
        },
        async onSubmit() {
            this.clearErrors();

            if (!this.login) this.loginError = "Введите логин";
            if (!this.password) this.passwordError = "Введите пароль";
            if (!this.reg.test(this.login)) this.emailError = "Неверный формат записи email";

            try {
                const res = await axios.post("/auth/customer", { email: this.login, password: this.password });
                this.handleAuthResponse(res.data);
            } catch (error) {
                console.error(error);
            }
        },

        async onRegister() {
            this.clearErrors();

            if (!this.form.name) this.nameError = "Введите имя";
            if (!this.form.email) this.emailError = "Введите почту";
            if (!this.reg.test(this.form.email)) this.emailError = "Неверный формат записи email";
            if (!this.form.password) this.passwordError = "Введите пароль";

            try {
                this.loading = true;
                const res = await axios.post("/auth/registration", {
                    name: this.form.name,
                    email: this.form.email,
                    password: this.form.password,
                    role: 2
                });
                this.handleRegisterResponse(res.data);
            } finally {
                this.loading = false;
            }
        },

        sendSmsVerification() {
            axios.post("/sms-verification", {phoneNumber: "phone"})
                .then(response => console.log(response));
        },
        sendRequest() {
            this.isSend = true;
        },
        clearErrors() {
            this.loginError = "";
            this.passwordError = "";
            this.authError = "";
            this.nameError = "";
            this.emailError = "";
            this.emaildentityError = "";
        },
        handleAuthResponse(responseData) {
            if(responseData === 1) window.location.reload()
            const messages = {
                0: "Отправка заявок доступна только пользователям в роли Заказчик. Авторизуйтесь или зарегистрируйтесь как заказчик.",
                nonVerify: "Подтвердите ваш аккаунт на почте",
                block: "Ваш аккаунт заблокирован"
            };
            this.authError = messages[responseData] || "";
        },
        handleRegisterResponse(responseData) {
            if (responseData === 1) {
                this.emaildentityError = "Пользователь с таким email уже существует";
            } else {
                this.form = { name: "", email: "", password: "" };
                this.switchRegister();
                this.authError = "Подтвердите ваш аккаунт на почте";
            }
        }
    }
};
</script>

<style>
#typeSport.is-invalid .v-select-toggle,
#region.is-invalid .v-select-toggle {
    border: 1px solid #e45868 !important;
}
</style>
<style scoped>
.circleUser {
    width: 43px;
    height: 43px;
    border-radius: 100%;
    overflow: hidden;
}

.container.sb-non-register {
    padding-bottom: 110px;
}

.container.sb-non-register .sb-send-sms__subtitle {
    color: #32325D;
    font-size: 18px;
    font-weight: lighter;
    margin-bottom: 15px;
}

.non-authorized-tender {
    background-color: #FFFFFF;
}

@media (max-width: 960px) {
    .tender-body .caption {
        font-size: calc(0.81rem) !important;
    }

    input.input-profile-info {
        min-width: 130px;
        text-align: center;
    }

    .tender-body {
        padding-bottom: 3rem !important;
    }

    .notification .text__Notification .text {
        font-size: calc(0.81rem);
    }

    .container.sb-non-register .sb-send-sms__subtitle {
        font-size: 13px;
    }

    .button-block-request button {
        width: 50%;
        text-align: center;
        justify-content: center;
        font-size: 13px;
    }

    .tabRegister .caption, .tabLogin .caption {
        font-size: 13px;
        background-color: white;
        width: fit-content;
        margin-left: 15px;
        padding: 0 5px;
        position: absolute;
        z-index: 1;
        top: -4px;
    }

    .sb-input-login {
        margin-top: 10px;
    }
}
</style>
<style src="@vueform/slider/themes/default.css"></style>
