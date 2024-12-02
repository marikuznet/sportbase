<template>
    <div>
        <navbar></navbar>
        <div class="container-fluid" style="background-color: white; min-height: 500px">
            <div class="row justify-content-center pb-5 h-100 align-items-center">
                <div class="col-md-6">
                    <h3 class="text-white text-center">Восстановление пароля</h3>
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="">
                                <input type="hidden" name="token" value="">
                                <div class="form-group row p-5 pb-0">
                                    <p style="color: black; font-style: italic; font-size: 15px; color: darkgray">Lorem
                                        ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum
                                        laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
                                        Proin sodales pulvinar sic tempor. Sociis natoque penatibus et magnis dis
                                        parturient montes, nascetur ridiculus mus.</p>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h5 class="align-items-center d-flex h-100">Введите новый пароль</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <input style="font-size: 18px" class="form-control" type="text" required
                                                   placeholder="Ваш новый пароль" v-model="password">
                                        </div>
                                    </div>
                                </div>
                                <form v-if="message === null" v-on:submit.prevent="onReset">
                                    <div
                                        class="bottom-logIn row row-cols-1 row-cols-lg-2 mt-3 pt-3 mx-auto mb-0 mb-lg-5">
                                        <button type="submit" class="button-logIn button-dark col mb-2 mb-lg-0">
                                            <p>Сменить пароль</p>
                                        </button>
                                    </div>
                                </form>
                                <div class="mt-4 password-return text-center" v-else>
                                    <h5>{{ message }}</h5>
                                    <form action="/auth/forgot-password">
                                        <div
                                            class="bottom-logIn row row-cols-1 row-cols-lg-2 mt-3 pt-3 mx-auto mb-0 mb-lg-5">
                                            <button type="submit" class="button-logIn button-dark col mb-2 mb-lg-0">
                                                <p>Запросить еще раз</p>
                                            </button>
                                        </div>
                                    </form>
                                </div>
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
    name: "ResetInputPassword",
    data() {
        return {
            password: null, message: null,
        }
    },
    components: {
        navbar,
        extendedinf
    },
    mounted() {
    },
    methods: {
        onReset() {
            let urlParamsToken = window.location.href.split('?')[0];
            let token = urlParamsToken.split('reset-password/')[1];

            let urlParams = new URLSearchParams(window.location.search);
            let email = urlParams.get('email');

            axios.post('/auth/reset-password', {
                email: email,
                password: this.password,
                token: token,
            }).then(res => {
                window.location.href = "/auth";
            }).catch(error => {
                this.message = "Полученные данные неккоректны";
            });
        }
    }
}
</script>

<style scoped>

</style>
