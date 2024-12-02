<template>
    <main>
        <div class="align-items-center d-flex justify-content-center loading position-fixed" v-if="loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <div class="main-stage">

            <div v-if="Number(infoUser ? infoUser.status : 0) === 11">
                <v-create-object-first v-if="addStep === 0" @nextStep="addStep++" :object="sportObject"
                                       @loading="getStatusLoad"/>
                <v-create-object-second v-else-if="addStep === 1" @nextStep="addStep++" :object="sportObject"
                                        @prevStep="addStep--" @setSportObjectId="handleSetSportObjectId"/>
                <v-create-object-third v-else-if="addStep === 2" @nextStep="addStep++" :object="sportObject"
                                       @prevStep="addStep--" :id-object="idObject"
                                       @loading="getStatusLoad"/>
            </div>
            <div v-else class="container pt-5">
                <div class="d-flex">
                    <img class="mr-4" src="/icons/information.svg" alt="">
                    <p v-if="Number(infoUser ? infoUser.status : 0) === 10" class="text-Blue">Для добавления нового
                        объекта добавьте информацию о вашей компании на
                        странице
                        <a href="/profile/settings">Профиль пользователя.</a>
                        После добавления информации на этой странице ваш аккаунт будет отправлен
                        на проверку (модерацию). После модерации вы сможете размещать объекты.</p>
                    <p v-if="Number(infoUser ? infoUser.status : 0) === 13" class="text-Blue">Ваш профиль находится
                        на верификации.
                        Дождитесь проверки (модерации) информации на странице <a href="/profile/settings">Профиль
                            пользователя.</a> После модерации вы сможете размещать объекты.</p>
                </div>
            </div>
        </div>
        <extendedinf></extendedinf>
    </main>
</template>

<script>
import navbar from '../NavBar'
import extendedinf from "../ExtendedFooterInformation";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "CreateObject",
    components: {navbar, extendedinf},
    props: {
        id: {default: null},
        sportObject: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            addStep: 0, loading: false, infoUser: {}, idObject: null,
            sportObjectState: this.getStateSportObject
        }
    },
    methods: {
        ...mapActions(['setStateSportObject']),
        getStatusLoad(x) {
            this.loading = x;
        },
        handleSetSportObjectId(object) {
            this.idObject = object;
        },
    },
    computed: {
        ...mapGetters(["getStateSportObject"]),
        user: function () {
            return window.user;
        },
    },
    watch: {
        addStep: {
            handler: function (value) {
                window.scroll(0, 0)
            }, deep: true
        },
        sportObjectState: {
            handler: function (value) {
                console.log(value)
            }, deep: true
        },
    },
    mounted() {
        this.loading = true;
        this.$store.dispatch("getCurrentUser").then(result => {
            this.infoUser = result;
            this.loading = false;
        })
    },
    created() {
    }
}
</script>

<style scoped>

</style>
