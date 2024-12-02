<template>
    <div>
        <modal-notification id="sb-notification-delete" ref="sb-notification-delete"
                            modal_class="sb-notification-delete" title="Удаление"
                            :content="`Подтвердите удаление '${sportObject.title}'`"
                            @left_action="deleteObject()"
                            @right_action="closeModalDelete()"
                            left_button="Удалить" right_button="НЕ УДАЛЯТЬ"/>

        <div class="admin-show-object" v-if="sportObject">
            <div class="">
                <breadcrumbs
                    :items="[{text: 'Объекты (Списком)', href: '/admin/sport-objects/checking'}, {text: `${sportObject.title}`, active: true}]"/>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-12">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div>
                                        <h1 class="caption__title">Название и тип объекта</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row aboutObject pb-3">
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-8">
                                            <label class="w-100 caption" for="title">Полное название объекта
                                                <div class="input-readonly" id="title">
                                                    {{ sportObject.title }}
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="w-100 caption select-wrapper mb-xl-2" for="category">Категория
                                                объекта
                                                <div class="input-readonly" id="category">
                                                    {{ sportObject.objectType_title }}
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-8 col-sm-8 col-md-2 text-nowrap pt-2">
                                                    <label class="w-100 caption select-wrapper mb-xl-2"
                                                           for="images">Фото
                                                        объекта
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="blockUploadImages  d-flex" id="images">
                                                <div v-for="(data, index) in sportObject.image" :key="data.id"
                                                     class="blockImage d-flex align-items-center justify-content-center">
                                                    <div class="image-preview h-100"
                                                         style="cursor: context-menu">
                                                        <img class="img-responsive h-100" loading="lazy"
                                                             :alt="`object-img-${index}`"
                                                             :src="'/storage/listings/objects/'+ sportObject.id + '/' + data">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pt-3">
                                                <div class="col-12 col-sm-12 d-flex d-lg-flex justify-content-start
                                            justify-content-lg-start justify-content-xl-start">
                                                    <div
                                                        class="descriptionObject text-left d-lg-flex justify-content-lg-center align-items-lg-center w-100">
                                                        <label class="caption w-100">Описание объекта
                                                            <div class="input-readonly mt-2">
                                                                <p class="textDescription"
                                                                   v-html="sportObject.description"></p>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pt-3">
                                                <div class="col-12 col-sm-12 d-flex d-lg-flex justify-content-start
                                            justify-content-lg-start justify-content-xl-start">
                                                    <div class="descriptionObject text-left d-lg-flex
                                                        justify-content-lg-center align-items-lg-center w-100">
                                                        <label class="caption w-100">Доступные виды спорта
                                                            <div class="label-checkbox-wrapp service_list__item mt-2
                                                            d-flex flex-wrap">
                                                                <div class="input-readonly"
                                                                     v-for="sport in sportObject.sports">
                                                                    {{ sport.title }}
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-sm-12 d-flex d-lg-flex justify-content-start
                                            justify-content-lg-start justify-content-xl-start">
                                                    <div
                                                        class="descriptionObject text-left d-lg-flex justify-content-lg-center align-items-lg-center w-100">
                                                        <label class="caption w-100">Предоставляемые услуги
                                                            <div class="label-checkbox-wrapp service_list__item mt-2
                                                                d-flex flex-wrap">
                                                                <div v-for="service in sportObject.services">
                                                                    <div class="input-readonly">
                                                                        {{ service.title }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12 col-md-12 pt-3">
                                    <div>
                                        <h1 class="caption__title">УСЛОВИЯ И ЦЕНЫ</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 row pt-3">
                                    <div class="col-lg-6 col-sm-12 d-flex d-lg-flex justify-content-start
                                            justify-content-lg-start justify-content-xl-start">
                                        <div class="descriptionObject text-left d-lg-flex justify-content-lg-center
                                                    w-100">
                                            <label class="caption w-100">Общее описание условий и правил
                                                проживания
                                                <div class="input-readonly">
                                                    {{
                                                        sportObject.termsAndPrices.replace(/<\/?[^>]+(>|$)/g, "")
                                                    }}
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 d-flex d-lg-flex justify-content-start
                                            justify-content-lg-start justify-content-xl-start">
                                        <div class="descriptionObject text-left d-lg-flex justify-content-lg-center
                                                    align-items-lg-center w-100">
                                            <label class="caption w-100">Включено в стоимость
                                                <div class="">
                                                    <ul class="el__list mx-2 pb-4">
                                                        <li v-for="item in sportObject.accomodationConditionAndPricing_included"
                                                            v-if="item.title !== ''">
                                                            <p class="fs-6">{{ item.title }}</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <template v-if="sportObject.accommodations.length > 0">
                                <div class="row mt-2">
                                    <div class="col-12 col-md-12 pt-3">
                                        <div>
                                            <label class="caption w-100">Типы проживания и стоимость</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6"
                                         v-for="(item,index) in sportObject.accommodations">
                                        <div class="typeLive border-grey h-100">
                                            <div class="block__title d-flex pl-4 pt-3">
                                                <p class="caption">{{ item.accomodationType_title }}</p>
                                            </div>
                                            <div class="block__text">
                                                <p class="text p-4 overflow-hidden" v-html="item.description"></p>
                                            </div>
                                            <div class="block__bottom pr-4 pl-4 pb-4">
                                                <p>Стоимость (за 1 человека)</p>
                                                <div class="d-flex">
                                                    <span class="text pt-2 pr-2">от</span>
                                                    <p class="align-items-center bg-gray-200 border-info d-flex mb-0 px-3 py-2 rounded"
                                                       style="font-size: calc(1rem);">
                                                        {{ item.pricing[new Date().getMonth()].minPrice }} руб.
                                                    </p> <span class="text pt-2 pl-2 pr-2">до</span>
                                                    <p class="align-items-center bg-gray-200 border-info d-flex mb-0 px-3 py-2 rounded"
                                                       style="font-size: calc(1rem);">
                                                        {{ item.pricing[new Date().getMonth()].maxPrice }} руб.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div v-if="sportObject.infrastructures.length > 0" class="row pt-3 pb-3">
                                <div class="col-12 col-sm-8 col-md-12">
                                    <div class="row">
                                        <div class="col-12 p-0">
                                            <div class="col-sm-12 pb-3">
                                                <p class="caption"
                                                   style="font-size: 1rem !important; font-weight: bold;">
                                                    Инфраструктура
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-4"
                                             v-for="item in sportObject.infrastructures">
                                            <div
                                                class="infrastructure el wrapper shadow bg-white borderblock mb-3">
                                                <div>
                                                    <div style=" height: 200px; overflow: hidden; ">
                                                        <img
                                                            :src="'/storage/listings/infrastruct/' + item.image"
                                                            alt="Image"
                                                            class="el__img w-100">
                                                    </div>

                                                    <p class="el__title p-4">{{ item.title }}</p>
                                                    <ul class="el__list list-overflow mx-2 pb-4">
                                                        <li v-for="option in item.options"
                                                            v-if="option.title !== ''">
                                                            <p class="fs-6 opacity-7">{{ option.title }}</p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div v-if="false"
                                                     class="justify-content-center align-items-lg-center d-flex">
                                                    <button type="button"
                                                            class="button button-border btnViewFull justify-content-between">
                                                        Показать полностью
                                                        <img src="/icons/arrowDownBlue.svg" alt="">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12 block__address-main_info pt-4 pb-2">
                                    <address-form :show-input="false" :title-block="'АДРЕС ОБЪЕКТА'" default-class=""
                                                  :address-prop="{country: sportObject.country, city: sportObject.city,
                                                  city_id: sportObject.city_id, street: sportObject.address,
                                                  region: sportObject.region, postIndex: sportObject.postIndex,
                                                  longtitude: sportObject.longtitude, latitude: sportObject.latitude}"
                                                  :map-height="500" :draggable-marker="false" :is-show-location="false">
                                        <template #address>
                                            <div v-if="sportObject && sportObject.address" class="row">
                                                <div class="col-lg-6 col-md-12 col-xs-12">
                                                    <label class="w-100 caption" for="">Адрес
                                                        <input type="text" name="search-object" readonly placeholder=""
                                                               :value="`${sportObject.country}, ${sportObject.city}, ${sportObject.address}`"
                                                               class="input-profile-info mt-2 w-100">
                                                    </label>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-xs-12">
                                                    <label class="w-100 caption" for="">Почтовый индекс
                                                        <input type="text" name="search-object" readonly
                                                               v-model="sportObject.postIndex"
                                                               placeholder="" class="input-profile-info mt-2 w-100">
                                                    </label>
                                                </div>
                                            </div>
                                        </template>
                                    </address-form>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center pt-4 mb-4">
                                <div class="d-flex justify-content-end">
                                    <button type="button" @click="openEditPage"
                                            class="btn btn-success justify-content-center"
                                            style="width: 200px !important; border-radius: 5px;">
                                        Редактировать
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="borderBlockBottom p-2 blockInfoAdvertistime">
                                <div class="blockOwner">
                                    <p><b>Владелец</b></p>
                                    <div class="d-flex">
                                        <img loading="lazy" :src="'/storage/listings/logos/' + sportObject.created.user_id + '/'
                                        + sportObject.created.image" alt="logo" style="width: 20px; height: 20px">
                                        <a :href="'/admin/users/profile/' + sportObject.created.user_id">
                                            {{ sportObject.created.title }} (ID:{{ sportObject.created.user_id }})
                                        </a>
                                    </div>
                                </div>
                                <div v-if="sportObject.advertisements.length " class="blockAdvertistime">
                                    <hr>
                                    <p><b>Реклама и продвижение</b></p>
                                    <template v-for="advertisement in sportObject.advertisements">
                                        <p class="mb-0">Тариф: <span>{{ advertisement.rate.title }}</span></p>
                                        <p>Сроки и стоимость: <span>
                                            {{ advertisement.days }} дней, {{ advertisement.amount }}руб</span></p>
                                    </template>
                                </div>
                                <div class="blockControl">
                                    <hr>
                                    <p><b>Управление</b></p>
                                    <div class="sb-actions d-flex flex-column">
                                        <button class="btn text-left" @click="verifyObject"
                                                v-if="sportObject.verify === 0">
                                            <img src="/icons/settings/check-mark.svg" alt="">
                                            ОДОБРИТЬ ОБЪЕКТ
                                        </button>
                                        <button class="btn text-left" data-toggle="modal"
                                                data-target="#sb-notification-delete">
                                            <img src="/icons/tenders/close-button.svg" alt="">
                                            УДАЛИТЬ ОБЪЕКТ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {yandexMap, ymapMarker} from 'vue-yandex-maps';
import Breadcrumbs from "./elements/Breadcrumbs";
import AddressForm from "../components/AddressForm";
import axios from "axios";
import eventBus from "../event-bus"

export default {
    props: {
        id: {
            type: Number
        },
        sportObject: {
            type: Object,
            default: null
        }
    },
    data: function () {
        return {}
    },
    computed: {},
    components: {
        AddressForm,
        Breadcrumbs,
        yandexMap, ymapMarker,
    },
    methods: {
        verifyObject() {
            this.$store.dispatch("verifySportObject", {id: this.sportObject.id})
                .then(() => window.location.href = "/admin/sport-objects/checking");
        },
        deleteObject() {
            this.$store.dispatch("delForceSportObject", {id: this.sportObject.id})
                .then(() => window.location.href = "/admin/sport-objects/checking");
        },
        closeModalDelete() {
            $('#sb-notification-delete').modal('hide');
        },
        openEditPage() {
            window.location.href = `/admin/sport-objects/edit/${this.sportObject.id}`;
        }
    },
    mounted() {
        eventBus.$emit('admin-address-object',
            [this.sportObject.latitude, this.sportObject.longtitude],
            {
                country: this.sportObject.country, city: this.sportObject.city,
                city_id: this.sportObject.city_id, street: this.sportObject.address,
                region: this.sportObject.region, postIndex: this.sportObject.postIndex,
                longtitude: this.sportObject.longtitude, latitude: this.sportObject.latitude
            })
        if (this.showMap === false) {
            this.image = '/icons/settings/maps-and-flags.svg';
        } else if (this.showMap === true) {
            this.image = '/icons/settings/maps-and-flagsWhite.svg';
        }
    },
    created() {
    }
}
</script>

<style scoped lang="scss">
body {
    font-size: 14px !important;
}

.label-checkbox-wrapp {
    gap: 10px;
}

.aboutObject .label-checkbox-wrapp__label {
    cursor: context-menu;
}

.main-stage-admin.caption,
.caption__title,
label.caption {
    font-size: 1rem;
    font-weight: bold;
}

.main-stage-admin .label-checkbox-wrapp__label {
    background-color: #f2f2f2;
    padding: 0.5rem;
    align-items: center;
    display: inline-flex;
}

.main-stage-admin .typeLive,
.main-stage-admin .block__title {
    background-color: #f2f2f2;
}

.ul__list_objects {
    background-color: #f2f2f2;
}

.blockInfoAdvertistime > p {
    font-size: 12px;
}

.blockInfoAdvertistime {
    border: 1px solid darkgrey;
}

@media (max-width: 767.98px) {
    .admin-show-object {
        .input-readonly {
            margin-right: 0;
        }

        label.caption {
            font-size: 12px;
        }

        .label-checkbox-wrapp {
            gap: 10px;

            .input-readonly {
                margin-right: 0;
            }
        }
    }
}

.typeLive {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.block__text {
    flex-grow: 1;
}

.block__bottom {
    margin-top: auto;
}


</style>
