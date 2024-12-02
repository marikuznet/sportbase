<template>
    <div class="main-stage secondStage">
        <div class="container pb-5">
            <nav aria-label="breadcrumb" class="pt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $props.object == null ? 'Добавить новый объект' : 'Редактировать объект' }}
                    </li>
                </ol>
            </nav>

            <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center">
                <div class="col-md-12">
                    <h1 class="title__stage text-uppercase text-center d-flex d-xl-flex justify-content-center justify-content-xl-center"
                        style="font-size: calc(1.875rem);">
                        <strong>{{ $props.object == null ? 'Добавить новый объект' : 'Редактировать объект' }}</strong>
                    </h1>
                </div>
                <hr class="caption-stage__hr mt-3">
            </div>

            <div class="mt-0">
                <div class="container">
                    <div class="row addObject-stage__one">
                        <stepper-item icon="/icons/stages/real-estate.svg" title="Информация об объекте"
                                      line-image="/icons/stages/firstWhite.svg"/>
                        <stepper-item icon="/icons/stages/like.svg"
                                      :title="`Подтверждение ${ $props.object == null ? ' добавления' : ' редактирования' }`"
                                      line-image="/icons/stages/secondBlue.svg"/>
                        <stepper-item icon="/icons/stages/growing.svg" title="Продвижение на сайте"
                                      line-image="/icons/stages/thirdWhite.svg"/>
                    </div>
                </div>
            </div>
            <div class="main-content__stage container" v-if="sportObject">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10 col-12 pl-4 pr-4 p-0">
                        <div class="row">
                            <div class="col-12 col-md-12 pt-5">
                                <div>
                                    <h1 class="caption__title">Название и тип объекта</h1>
                                </div>
                            </div>
                        </div>
                        <div class="row aboutObject pb-3">
                            <div class="col-sm-12 col-md-12">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-8">
                                        <label class="w-100 caption" for="">Полное название объекта
                                            <input type="text" name="search-object" v-model="sportObject.title"
                                                   placeholder="AquaLife Спортивно-гостиничный комплекс"
                                                   class="input-profile-info" readonly>
                                        </label>
                                    </div>
                                    <div class="col-lg-4 col-sm-12" v-if="sportObject.objectType">
                                        <label class="w-100 caption select-wrapper mb-xl-2" for="">Категория объекта
                                            <input type="text" name="search-object" placeholder="Стадион"
                                                   class="input-profile-info" readonly
                                                   :value="sportObject.objectType.title ? sportObject.objectType.title : sportObject.objectType">
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-8 col-sm-8 col-md-2 text-nowrap pt-2">
                                                <label class="w-100 caption select-wrapper mb-xl-2" for="">Фото
                                                    объекта
                                                </label>
                                            </div>
                                        </div>
                                        <div class="blockUploadImages  d-flex">
                                            <div v-for="(data, index) in imagesObject" :key="index"
                                                 class="blockImage d-flex align-items-center justify-content-center">
                                                <div class="image-preview h-100" style="cursor: context-menu">
                                                    <img class="img-responsive h-100" :src="data">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row pt-3">
                                            <div class="col-12 col-sm-12 d-flex d-lg-flex justify-content-start
                                            justify-content-lg-start justify-content-xl-start">
                                                <div
                                                    class="descriptionObject text-left d-lg-flex justify-content-lg-center align-items-lg-center w-100">
                                                    <label class="caption w-100">Описание объекта
                                                        <div class="description__object mt-2">
                                                            <p class="textDescription p-4"
                                                               v-html="sportObject.description">
                                                            </p>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row pt-3">
                                            <div class="col-12 col-sm-12 d-flex d-lg-flex justify-content-start
                                            justify-content-lg-start justify-content-xl-start">
                                                <div
                                                    class="descriptionObject text-left d-lg-flex
                                                        justify-content-lg-center align-items-lg-center w-100">
                                                    <label class="caption w-100">Доступные виды спорта
                                                        <div class="label-checkbox-wrapp service_list__item mt-2
                                                            d-flex flex-wrap">
                                                            <div v-for="(item, index) in sportTypes">
                                                                <label
                                                                    class="label-checkbox-wrapp__label label__service"
                                                                    v-for="sport in sportObject.sports"
                                                                    v-if="item.id === sport"
                                                                    v-model="sportObject.sports" :value="item.id">
                                                                    {{ item.title }}
                                                                </label>
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
                                                        <div
                                                            class="label-checkbox-wrapp service_list__item mt-2
                                                                d-flex flex-wrap">
                                                            <div v-for="(item, index) in allServices">
                                                                <label
                                                                    class="label-checkbox-wrapp__label label__service"
                                                                    v-for="service in sportObject.services"
                                                                    v-if="item.id === service"
                                                                    v-model="sportObject.services" :value="item.id">
                                                                    {{ item.title }}
                                                                </label>
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
                            <div class="row pt-3">
                                <div class="col-lg-7 col-sm-12 d-flex d-lg-flex justify-content-start
                                            justify-content-lg-start justify-content-xl-start">
                                    <div class="descriptionObject text-left d-lg-flex justify-content-lg-center w-100">
                                        <label class="caption w-100">Общее описание условий и правил проживания
                                            <div class="description__object mt-2">
                                                <p class="textDescription p-4"
                                                   v-html="sportObject.pricing.description"></p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-sm-12 d-flex d-lg-flex justify-content-start
                                            justify-content-lg-start justify-content-xl-start">
                                    <div
                                        class="descriptionObject text-left d-lg-flex justify-content-lg-center align-items-lg-center w-100">
                                        <label class="caption w-100">Включено в стоимость
                                            <div class="serviceOn mt-2 pt-4">
                                                <ul class="el__list mx-2 pb-4">
                                                    <li v-for="(item, index) in sportObject.pricing.included"
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

                        <modalLivePricing v-show="isShowModalLivePricing" :show="isShowModalLivePricing"
                                          :scrollable="true" @close="toggleModalLivePricing"
                                          header-pricing-id="modalHeader" body-pricing-id="modalBody">
                            <template #header>
                                <div class="headerIncludePrice__modal d-flex">
                                    <p style="margin-right: auto !important;" class="caption">
                                        Стоимость проживания</p>
                                    <img style="cursor: pointer"
                                         @click="toggleModalLivePricing"
                                         src="/icons/stages/cancel.svg" alt="cancel">
                                </div>
                            </template>
                            <template #body>
                                <table class="table table-responsive">
                                    <thead>
                                    <th width="50%">Месяц пребывания 2022</th>
                                    <th width="50%">Стоимость за 1 человека в сутки</th>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in month">
                                        <td>{{ item.text }}</td>
                                        <td>от {{ item.minPrice }} до {{ item.maxPrice }} руб.</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </template>
                        </modalLivePricing>

                        <div class="row mt-2" v-if="sportObject.pricing.typeLiving.length > 0">
                            <div class="col-12 col-md-12 pt-3">
                                <div>
                                    <label class="caption w-100">Типы проживания и стоимость</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="sportObject.pricing.typeLiving.length > 0">
                            <div class="col-12 col-sm-12 col-md-6 mb-3"
                                 v-for="(item,index) in sportObject.pricing.typeLiving">
                                <div class="typeLive border-grey h-100">
                                    <div class="block__title d-flex">
                                        <p class="caption type-living__title">
                                            {{ item.title.title ? item.title.title : item.title }}</p>
                                    </div>
                                    <div class="block__text type-living__description" style="min-height: 230px">
                                        <p class="text p-4" v-html="item.description"></p>
                                    </div>
                                    <div class="block__text block__price">
                                        <p class="priceForPer pl-4 pr-4" style="bottom: 65px;">
                                            Стоимость (за 1 человека)
                                        </p>
                                        <div class="block__price d-flex pr-4 pl-4 pb-4" style="bottom: 0">
                                            <span class="text pt-2 pr-2">от</span>
                                            <p class="priceMin button-blueBorder borderblock  px-3
                                                        d-inline-block py-2 fw-light text-white"
                                               style="font-size: calc(1rem);">
                                                {{ item.price[currentMonth].minPrice }} руб
                                            </p>
                                            <span class="text pt-2 pl-2 pr-2">до</span>
                                            <p class="priceMax button-blueBorder borderblock  px-3
                                                d-inline-block py-2 fw-light text-white mr-2"
                                               style="font-size: calc(1rem);">
                                                {{ item.price[currentMonth].maxPrice }} руб</p>
                                            <button @click="toggleModalLive(index)" type="button"
                                                    class="button btnInformation button-borderBlue align-items-lg-center
                                                                    justify-content-center d-flex mx-auto">
                                                <img src="/icons/stages/information.svg" alt="" class="pr-3">
                                                Подробнее
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row pt-3 pb-3" v-if="sportObject.pricing.infrastructures.length > 0">
                            <div class="col-12 col-sm-8 col-md-12">
                                <div class="row">
                                    <div class="col-12 p-0">
                                        <div class="col-sm-12 pb-3">
                                            <p class="caption">Инфраструктура</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4"
                                         v-for="(item, index) in sportObject.pricing.infrastructures">
                                        <div class="infrastruct el wrapper shadow bg-white borderblock mb-3">
                                            <div class="ul__list_objects">
                                                <img :src="item.image && item.image != '/storage/listings/infrastruct/null'
                                                ? item.image  : '/images/no-photo.png'"
                                                     alt="Image" class="el__img w-100" style="object-fit: cover;">
                                                <p class="el__title p-4">{{ item.title }}</p>
                                                <ul class="el__list list-overflow mx-2 pb-4"
                                                    :class="{'h-auto': infrastructure_detail}">
                                                    <li v-for="option in item.options"
                                                        v-if="option.title !== ''">
                                                        <p class="fs-6 opacity-7">{{ option.title }}</p>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div v-if="item.options.length > 4"
                                                 class="justify-content-center align-items-lg-center d-flex">
                                                <button type="button"
                                                        @click="!infrastructure_detail ? infrastructure_detail = true : infrastructure_detail = false"
                                                        class="button button-border btnViewFull justify-content-between">
                                                    {{ !infrastructure_detail ? 'Показать полностью' : 'Скрыть' }}
                                                    <img src="/icons/arrowDownBlue.svg" alt="">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 pt-3" style="border-top: 1px solid #BAC4DF;">
                            <div class="col-12 col-md-12 pt-3">
                                <div>
                                    <h1 class="caption__title">Адрес объекта</h1>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div v-if="sportObject && sportObject.address"
                                 class="row block__address-main_map p-0 pt-2 pb-2">
                                <div class="col-lg-6 col-md-12 col-xs-12">
                                    <label class="w-100 caption" for="">Адрес
                                        <input type="text" name="search-object" readonly
                                               placeholder=""
                                               :value="`${sportObject.objectCountry}, ${sportObject.objectCity}, ${sportObject.address.street}`"
                                               class="input-profile-info mt-2">
                                    </label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-xs-12">
                                    <label class="w-100 caption" for="">Почтовый индекс
                                        <input type="text" name="search-object" readonly
                                               v-model="sportObject.address.postIndex"
                                               placeholder="" class="input-profile-info mt-2">
                                    </label>
                                </div>
                                <div class="mapAddress pt-3" style="height: 600px">
                                    <yandex-map style="height:100%" :coords="coordsObject" :zoom="17"
                                                :settings="settings">
                                        <ymap-marker :coords="coordsObject" :markerId="1" :icon="{color: 'green'}"/>
                                    </yandex-map>
                                </div>
                            </div>
                        </div>

                        <div class="btnNextPrev row d-flex pt-4 mb-4">
                            <div class="col-lg-6 col-md-6 col-xs-6 col-6">
                                <form action="/stage/first">
                                    <button type="button" @click="prevStep"
                                            class="sb-prev-stage button button-border btnSize justify-content-center"
                                            style="width: 200px; border-radius: 5px; color: #6283E5">
                                        <img class="pr-2" src="/icons/prevBlue.svg" alt="prev">
                                        Назад
                                    </button>
                                </form>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-6 col-6 mb-lg-4 d-flex justify-content-end">
                                <button type="button" @click="onSave"
                                        class="button button-green btnSize justify-content-center"
                                        style="width: 200px !important; border-radius: 5px;">
                                    Далее
                                    <img class="pl-2" src="/icons/next.svg" alt="next">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import modalLivePricing from '../addObject/ModalLivePricing';
import {mapActions, mapGetters} from "vuex";
import {yandexMap, ymapMarker} from "vue-yandex-maps";
import axios from "axios";
import eventBus from '../../event-bus.js';
import StepperItem from "./StepperItem";

export default {
    props: ['object'],
    data() {
        return {
            settings: this.$apiSettings.yandexMap,
            sportObject: {
                title: '', objectType: null, images: [], description: '<p style="color: #0B3158"></p>',
                storageImages: [], services: [], sports: [], pricing: {
                    accCondPricing_id: null, accm_minPrice: null,
                    description: '<p style="color: #0B3158"></p>', included: [{id: 0, title: ''}],
                    typeLiving: [], infrastructures: []
                }, user_id: user.id, id: null,
            },
            month: [{id: 0, text: 'Январь', title: 'january', minPrice: 0, maxPrice: 0},
                {id: 1, text: 'Февраль', title: 'february', minPrice: 0, maxPrice: 0},
                {id: 2, text: 'Март', title: 'march', minPrice: 0, maxPrice: 0},
                {id: 3, text: 'Апрель', title: 'april', minPrice: 0, maxPrice: 0},
                {id: 4, text: 'Май', title: 'may', minPrice: 0, maxPrice: 0},
                {id: 5, text: 'Июнь', title: 'june', minPrice: 0, maxPrice: 0},
                {id: 6, text: 'Июль', title: 'jule', minPrice: 0, maxPrice: 0},
                {id: 7, text: 'Август', title: 'august', minPrice: 0, maxPrice: 0},
                {id: 8, text: 'Сентябрь', title: 'september', minPrice: 0, maxPrice: 0},
                {id: 9, text: 'Октябрь', title: 'october', minPrice: 0, maxPrice: 0},
                {id: 10, text: 'Ноябрь', title: 'november', minPrice: 0, maxPrice: 0},
                {id: 11, text: 'Декабрь', title: 'december', minPrice: 0, maxPrice: 0}],
            isShowModalLivePricing: false,
            markerIcon: {
                layout: 'default#imageWithContent', imageHref: 'icons/stages/mark.svg', imageSize: [48, 55],
                imageOffset: [0, 0], contentOffset: [0, 15],
                contentLayout: '<div style="background: red; width: 50px; color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
            }, editObject: false, infrastructure_detail: false, coordsObject: [],
            currentMonth: new Date().getMonth(),
        }
    },
    computed: {
        ...mapGetters({
            allServices: 'AllServices', sportTypes: 'AllSportTypes',
            object_id: 'sport_object_id'
        }),
        user: function () {
            return window.user;
        },
        imagesObject: function () {
            if (this.$props.object != null) {
                return this.sportObject.storageImages.map(image => `/storage/listings/objects/${this.$props.object.id}/${image}`);
            } else {
                return this.sportObject.storageImages.map(image => `/storage/listings/objects/temp/${image}`);
            }
        },
    },
    methods: {
        ...mapActions(["storeInAccomodationPrice", "storeAccomodationTypePrice", "storeCondPricingAndObject",
            "setStoreSportObject"]),
        toggleModalLivePricing() {
            this.isShowModalLivePricing = !this.isShowModalLivePricing;
        },
        toggleModalLive(index) {
            this.isShowModalLivePricing = !this.isShowModalLivePricing;
            for (let m = 0; m < this.sportObject.pricing.typeLiving[index].price.length; m++) {
                this.month[m].minPrice = this.sportObject.pricing.typeLiving[index].price[m].minPrice;
                this.month[m].maxPrice = this.sportObject.pricing.typeLiving[index].price[m].maxPrice;
            }
        },
        prevStep() {
            this.$emit('prevStep')
        },

        async onSave() {
            this.sportObject.user_id = user.id;
            if (!this.editObject) {
                await this.saveNewObject();
            } else {
                await this.updateExistingObject();
            }
        },

        async saveNewObject() {
            try {
                const accm_cond_pricing = await this.storeAccomodationCondPrice();
                const object = await this.storeSportObject(accm_cond_pricing);
                await this.uploadImages(object);
                this.$emit('setSportObjectId', object);
                this.$emit('nextStep');
            } catch (error) {
                console.error(error);
            }
        },

        async updateExistingObject() {
            try {
                await this.$store.dispatch("setSportObject", this.sportObject);
                this.$emit('nextStep');
            } catch (error) {
                console.error(error);
            }
        },

        async storeAccomodationCondPrice() {
            const response = await this.$store.dispatch("storeAccomodationCondPrice", {
                description: this.sportObject.pricing.description,
                image: JSON.stringify([]),
                included_in_accomodation_pricing: JSON.stringify(this.sportObject.pricing.included.filter(elem => elem.title !== ''))
            });
            return response.data;
        },

        async storeSportObject(accm_cond_pricing) {
            this.sportObject.accCondPricing_id = accm_cond_pricing;
            const response = await this.$store.dispatch("storeSportObject", this.sportObject);
            this.sportObject.object_id = response.data;
            return response.data;
        },

        async uploadImages(object) {
            await Promise.all(this.sportObject.storageImages.map(image => {
                return axios.post('/moveImage/' + object + '/' + image.replace('.jpg', ''), {
                    'headers': {
                        'Content-Type': 'multipart/form-data'
                    }
                });
            }));
        },

    },
    async mounted() {
        this.editObject = this.$props.object != null;

        const objectFromLocalStorage = localStorage.getItem('object');
        if (objectFromLocalStorage != null) {
            this.sportObject = JSON.parse(objectFromLocalStorage);
        }

        const {country, city, street} = this.sportObject.address;
        const countryTitle = country?.title || country;
        const cityTitle = city?.title || city;

        this.sportObject.objectCountry = countryTitle;
        this.sportObject.objectCity = cityTitle;

        if (this.sportObject.address.longtitude != null && this.sportObject.address.latitude != null) {
            this.coordsObject = [this.sportObject.address.latitude, this.sportObject.address.longtitude];
            return this.sportObject;
        }

        const address = encodeURI(`${countryTitle}+${cityTitle}+${street}`);
        try {
            const resp = await axios.get('/api/v1/get/coords', {params: {address}});
            const coords = resp.data.response.GeoObjectCollection.featureMember[0]['GeoObject']['Point']['pos'].split(' ');
            this.coordsObject = [parseFloat(coords[1]), parseFloat(coords[0])];
            this.sportObject.address.longtitude = parseFloat(coords[0]);
            this.sportObject.address.latitude = parseFloat(coords[1]);
        } catch (error) {
            console.error(error);
        }
    },
    name: "SecondStage",
    components: {StepperItem, yandexMap, ymapMarker, modalLivePricing},
}
</script>

<style scoped>

</style>
