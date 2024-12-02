<template>
    <div v-if="tender" class="tenders__el  bg-white shadow borderblock border-0  my-3">
        <div class="tenders__el__title borderBlockBottom p-0 p-lg-4 justify-content-between">
            <div class="col col-auto d-lg-flex d-block p-0">
                <div class="tenderNumberBlock col col-12 col-lg-auto d-flex d-lg-block
                                            justify-content-between borderBlockBottom py-3 py-lg-0 p-0">
                    <p class="tenderNumber text-Blue fw-bold col col-auto my-auto p-0">
                        Тендер
                        №{{ tender.id }}</p>
                    <p class="date text-Blue col col-auto my-auto p-0">
                        {{ tender.createDate }}</p>
                </div>
                <div class="col col-12 col-lg-auto d-flex px-0 px-4 py-3 py-lg-0">
                    <div class="circleUser ml-2 mr-2">
                        <img v-if="tender.customer_info.logo" class="userImage w-100 h-100" alt="Img"
                             :src="'/storage/listings/logos/' + tender.customer_info.user_id + '/' + tender.customer_info.logo">
                    </div>
                    <div class="userTitle px-4 col col-auto  my-auto">
                        <p class="userName text-Blue fw-bold fs-3">
                            {{ tender.customer_info.title }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col col-12 col-lg-auto d-lg-flex d-block px-4 px-lg-0">
                <div class="col col-auto my-auto px-0 px-lg-2 py-2" v-if="tender.customer_info.phone">
                    <p class=" number text-lightBlue border-lightBlue borderblock px-3 py-2">
                        {{ tender.customer_info.phone }}
                    </p>
                </div>
                <div class="block__eMail col col-auto my-auto pt-2 pb-3 py-lg-0" v-if="tender.customer_info.email">
                    <p class="eMail text-lightBlue border-lightBlue borderblock px-3 py-2">
                        {{ tender.customer_info.email }}
                    </p>
                </div>
            </div>
        </div>
        <div class="tenders__el__sportType borderBlockBottom p-4">
            <div class="type">
                <p class=" text-lightBlue border-lightBlue borderblock d-inline-block px-3 py-2 mr-2"
                   v-for="sport in tender.type_sports">
                    {{ sport.title }}</p>
            </div>
        </div>
        <div class="tenders__el__region px-4 py-2 pb-0 mt-2">
            <div class="region d-inline-block">
                <p class="button-blueBorder borderblock px-3 py-2 d-inline-block fw-light">
                    {{ tender.region }}</p>
                <p class=" country__name text-lightBlue px-lg-3 d-inline-block">
                    <span class="d-none d-lg-inline-block">{{ tender.city }}</span>
                </p>
            </div>
        </div>
        <div class="tenders__el__price borderBlockBottom px-4 py-3 ">
            <div class="peopleCount d-block d-lg-inline-block pb-2 p-lg-0 mr-3">
                <p class=" button-blueBorder borderblock px-3 d-inline-block py-2 fw-light">
                    {{ tender.colPeople }}</p>
            </div>
            <div class="priceMin d-inline-block mr-3">
                <p class=" button-blueBorder borderblock  px-3  d-inline-block py-2 fw-light">
                    {{ tender.minPrice }} руб.</p>
            </div>
            <div class="priceMax d-inline-block">
                <p class=" button-blueBorder borderblock px-3  d-inline-block py-2 fw-light">
                    {{ tender.priceForPerson }} руб.</p>
            </div>
        </div>
        <div class="tenders__el__date borderBlockBottom p-4 pt-3 pb-3">
            <div class="date">
                <p class="date-start text-Blue border-green borderblock px-lg-3  px-2 ml-3
                                        d-inline-block py-1 text-capitalize">
                    {{ tender.startDate }}</p>
                <p class="text-Blue d-inline-block px-lg-1 px-0">-</p>
                <p class="date-end text-Blue border-green borderblock px-lg-3  px-2
                                        d-inline-block py-1 text-capitalize">
                    {{ tender.endDate }}</p>
                <p class="borderblock text-Blue border-blue date-add px-lg-3  px-2 d-inline-block py-1 mx-lg-2">
                    {{ tender.spreadDate }}</p>
            </div>
        </div>
        <div class="tenders__el__comment borderBlockBottom p-4">
            <div class="pos-f-t">
                <nav class="navbar bg-white p-0 d-lg-none d-flex">
                    <button v-if="showIndex == tender.id" @click="showIndex = null"
                            :class="!showIndex ? 'button__blueBorder' : 'button-blue'"
                            class="mb-3 down button__blueBorder button borderblock closeDescr">
                        <span :class="!showIndex ? 'text-Blue' : 'text-white'">
                            {{ !showIndex ? 'Открыть полное описание' : 'Закрыть полное описание' }}
                        </span>
                    </button>
                </nav>
                <div v-show="showIndex == tender.id">
                    <div class="requiment borderBlockBottom p-0 pb-3">
                        <div class="p-0 pt-lg-3">
                            <p class="text-Blue borderblock d-block d-lg-inline-block m-1 px-3 py-1 border-bold"
                               v-for="infrastructures in tender.infrastructures">
                                {{ infrastructures.title }}</p>
                            <p class="text-Blue borderblock border-red m-1 px-3 py-1 border-bold"
                               v-show="tender.accred == 1">Наличие аккредитации МИНСПОРТА</p>
                        </div>
                    </div>
                    <div class=" py-3 comment">
                        <p class="text-dark py-3">{{ tender.comment }}</p>
                    </div>
                </div>
                <nav class="navbar bg-white p-0">
                    <button @click="showDescription(tender.id)" class="mb-3 trigger
                             button closeDescr borderblock d-lg-flex d-none"
                            :class="!showIndex ? 'button__blueBorder' : 'button-blue'">
                        <span :class="!showIndex ? 'text-Blue' : 'text-white'">
                            {{ !showIndex ? 'Открыть полное описание' : 'Закрыть полное описание' }}
                        </span>
                    </button>
                    <div class="wrapper clickResponses d-flex">
                        <div class="responceCount d-inline-block py-3 py-lg-0 ">
                            <p class="borderblock fw-bold text-Blue d-inline-block  px-3">
                                {{ tender.allResponses_count }}
                            </p>
                        </div>
                        <button v-if="user == 0" data-target="#sb-auth-users" data-toggle="modal" class="responce button-fill
                                    borderblock border-0 d-inline-block button-fill button"/>

                        <div class="tender-executor d-flex align-items-center ml-4" v-else-if="user.role == 2">
                            <p class="text-muted">
                                {{ user.id == tender.customer_info.user_id ? 'Ваша' : 'Чужая' }} тендерная заявка
                            </p>
                        </div>
                        <div class="ml-lg-4 responceBlock" v-else>
                            <button v-if="hasSportObjects"
                                    class="responce button-fill button borderblock border-0 d-inline-block"
                                    :data-target="'#sb-response-tender'" data-toggle="modal"
                                    data-modal="sb-response-tender"
                                    @click="$emit('showResponseTenderModal', tender)"
                                    :class="{'myResponse': tender.myResponses_count >= 1}">
                            </button>
                            <button v-else class="responce button-fill button borderblock border-0 d-inline-block"
                                    :data-target="'#sb-not-sport-objects'" data-toggle="modal"
                                    data-modal="sb-not-sport-objects">
                            </button>
                        </div>
                    </div>
                </nav>
                <modal id="sb-auth-users" ref="sb-auth-users" modal_class="sb-auth-users"
                       content="Отправлять отклики на тендеры могут только зарегистрированные и авторизованные ИСПОЛНИТЕЛИ"
                       @left_action="authUser" @right_action="authRegister" left_button="Авторизоваться"
                       right_button="ЗАРЕГИСТРИРОВАТЬСЯ"></modal>

                <modal id="sb-not-sport-objects" ref="sb-not-sport-objects" modal_class="sb-not-sport-objects"
                       content="Добавьте объект или дождитесь верификации объекта для возможности отклика на тендер"
                       @left_action="closeModal" @right_action="addSportObject" left_button="Отмена"
                       right_button="Добавить объект"></modal>
            </div>
        </div>
    </div>
</template>

<script>
import responseTender from './requests/responseTender';
import VueCompositionAPI from '@vue/composition-api';

Vue.use(VueCompositionAPI);
import Slider from '@vueform/slider/dist/slider.vue2.js';
import VSelect from "@alfsnd/vue-bootstrap-select";
import Vue from "vue";

import Modal from './elements/Modal';
import ResponseTenderModal from "./tenders/ResponseTenderModal";

export default {
    name: "TenderList",
    components: {ResponseTenderModal, responseTender, Slider, VSelect, Modal},
    props: {
        tender: {
            type: Array | Object,
            required: true,
            default: function () {
                return [];
            }
        },
        hasSportObjects: {
            type: Boolean,
            required: true,
        }
    },
    data() {
        return {
            showIndex: null,
        }
    },
    computed: {
        user() {
            return window.user;
        },
    },
    methods: {
        authUser() {
            window.location.href = '/auth';
        },
        authRegister() {
            window.location.href = '/auth/registration';
        },
        showDescription(tender_id) {
            this.showIndex = this.showIndex == null ? tender_id : null;
        },
        closeModal() {
            $('#sb-not-sport-objects').modal('hide');
        },
        addSportObject() {
            window.location.href = '/sport-objects/create';
        }
    }
}
</script>

<style scoped>
.v-dropdown-container {
    overflow: auto !important;
    max-height: 280px !important;
}

.label-radio-wrapp__label {
    height: 55px;
    font-size: calc(1.2em);
}

.border-bold {
    border-width: 2px;
}

.circleUser {
    width: 43px;
    height: 43px;
    border-radius: 100%;
    overflow: hidden;
}

.border-green {
    border: 2px solid #56c46f;
}

.border-blue {
    border: 2px solid #bac4df;
}

.myResponse {
    background-color: #79cb8c;
    border: 1px solid #309848;
}

.myResponse::after {
    content: url("/icons/email.svg");
    padding-left: 20px;
}

.myResponse::before {
    content: "Мой отклик" !important;
}

#overlay {
    z-index: 999;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.2);
}

.tender-executor {
    width: 120px;
}

.tender-executor p {
    font-size: calc(1rem);
}

.content__tenderCatalog .middle .content__wrapper .tenders__el__title .userImage {
    width: 25%;
}

@media (max-width: 991px) {
    .tenders__el__title .userName {
        font-size: calc(1.125rem) !important;
    }

    .label-checkbox-wrapp__label, .label-radio-wrapp__label {
        font-size: calc(0.81rem);
    }

    .closeDescr {
        font-size: calc(0.875rem) !important;
        font-weight: normal !important;
    }

    .requiment .borderblock {
        border: 2px solid #bac4df;
    }

    .filters__Menu label {
        font-size: calc(1rem);
    }

    .wrapper.filter_sort {
        display: flex;
    }

    .clickResponses {
        flex-wrap: wrap !important;
    }

    .clickResponses .responceCount {
        width: 100% !important;
    }

    .clickResponses .responceBlock {
        width: 100% !important;
    }
}
</style>
