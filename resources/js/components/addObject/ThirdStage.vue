\
<template>
    <div class="main-stage secondStage thirdStage">
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
                <div class="sb-promotion-stage container" v-if="sportObject">
                    <div class="row addObject-stage__one">
                        <stepper-item icon="/icons/stages/real-estate.svg" title="Информация об объекте"
                                      line-image="/icons/stages/firstWhite.svg"/>
                        <stepper-item icon="/icons/stages/like.svg"
                                      :title="`Подтверждение ${ $props.object == null ? ' добавления' : ' редактирования' }`"
                                      line-image="/icons/stages/secondWhite.svg"/>
                        <stepper-item icon="/icons/stages/growing.svg" title="Продвижение на сайте"
                                      line-image="/icons/stages/thirdBlue.svg"/>
                    </div>
                    <div class="blockMark d-flex p-3">
                        <div class="textCheckMark pl-4 pr-5">
                            <img class="position-relative" style="top: 15%"
                                 src="/icons/stages/check-mark.svg" alt="mark">
                        </div>
                        <div>
                            <p class="congratulations">Поздравляем, Объект
                                "<span>{{ sportObject.title }}</span>"{{
                                    $props.object == null ? ' успешно добавлен в систему' : ' успешно обновлен'
                                }}
                            </p>
                            <p class="subtitle">Вы сможете смотреть и управлять всеми объектами на странице
                                объекта</p>
                        </div>
                    </div>
                    <div
                        class="blockMark blockSite-mark d-flex p-3 align-items-lg-center mt-3 justify-content-between">
                        <p class="congratulations pl-4" style="font-weight: normal">Здесь вы можете настроить
                            рекламу/продвижение объекта на сайте или сделать это позже на странице</p>
                        <form action="/sport-objects">
                            <button class="button buttonSportObjects button-blue btnBorder">
                                Спортивные объекты
                            </button>
                        </form>
                    </div>
                    <div class="row blockAdvertisement pt-4" v-if="advertising_tariffs">
                        <div class="col-lg-4" v-if="advertising_tariffs[0]">
                            <div class="promotion mb-3">
                                <div class="promotion__title d-flex align-items-lg-center p-4">
                                    <p class="title__promotion">{{ advertising_tariffs[0].title }}</p>
                                    <div class="price mx-auto d-flex align-items-center"
                                         style="margin-right: 0 !important;">
                                        <span class="text pt-2 pr-2 d-flex align-items-center">от</span>
                                        <p class="priceMin button-blueBorder borderblock  px-3
                                                    d-inline-block py-2
                                                    fw-light text-white" style="font-size: calc(1rem);">
                                            {{ advertising_tariffs[0].minPrice }} руб/день
                                        </p>
                                    </div>
                                </div>
                                <div class="content__promotion p-4">
                                    <div class="content-objects-list__item object-block object-block-border mb-4">
                                        <div class="object-block-favorites-wrapp">
                                            <input class="object-block-favorites__checkbox" type="checkbox"
                                                   name="checkbox-favorites">
                                            <label class="object-block-favorites__label">
                                                <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M16.0193 1.51891C13.832 0.483103 11.9106 2.06844 10.698 3.47532C10.1996 4.05355 9.2293 3.98927 8.7741 3.37645C7.62889 1.83468 5.62652 0.11665 3.16253 1.51891C-0.384959 3.5378 1.16251 7.51891 2.66253 9.51892C4.39799 11.8328 7.65041 14.4661 9.02416 15.5325C9.3952 15.8205 9.91428 15.7996 10.2743 15.498C11.8057 14.2151 14.4246 12.1044 16.1625 10.0189C18.9546 6.6684 19.5193 3.1764 16.0193 1.51891Z"
                                                        stroke="#B7C2CC" stroke-width="3"/>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="object-block__img">
                                            <div class="object-block__fast-forward-label">
                                                <img src="/icons/sportObjects/fast-forward.svg" alt="fast">
                                            </div>
                                            <img v-if="$props.object == null" alt="1"
                                                 :src="'/storage/listings/objects/' + sportObject.object_id + '/' + sportObject.storageImages[0]">
                                            <img v-else alt="1"
                                                 :src="'/storage/listings/objects/' + $props.object.id + '/' + $props.object.images[0]">
                                        </div>
                                        <div class="object-block__content">
                                            <div class="object-block__name">{{ sportObject.title }}</div>
                                            <div class="object-block__location object-location">
                                                <img class="object-location__flag" src="/icons/russia-icon.svg"
                                                     alt="russia-icon">
                                                <div class="object-location__country">
                                                    {{
                                                        sportObject.address.country.title || sportObject.address.country
                                                    }}
                                                </div>
                                                <div class="object-location__city">г.
                                                    {{
                                                        sportObject.address.city.title || sportObject.address.city
                                                    }}
                                                </div>
                                            </div>
                                            <div class="object-block__descr">
                                                {{ sportObject.description.replace(/<\/?[^>]+(>|$)/g, "") }}
                                            </div>
                                            <div class="object-block__cost text-center">
                                                <span>от 600 ₽</span> / с человека в
                                                сутки
                                            </div>
                                        </div>
                                        <div
                                            class="calculation__promotion wrapp-button d-flex justify-content-center mx-auto">
                                            <button type="button"
                                                    class=" button price__button rounded-0  button-fill shadow w-100">
                                                <p class="price__button__text w-100 text-start position-relative">
                                                    Запросить расчет
                                                </p>
                                                <img src="/icons/stages/calculation.svg" alt="">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer__promotion p-4 pb-2 border-0">
                                    <p class="title__promotion pb-2">
                                        {{ advertising_tariffs[0].title }}</p>
                                    <p class="text__promotion">
                                        {{ advertising_tariffs[0].description }}</p>
                                    <template v-if="isShowAdvertisementTariff(advertising_tariffs[0].id)">
                                        <p class="duration__promotion pt-4">продолжительность (дней)</p>
                                        <div class="btn__promotion">
                                            <div class="user-type__list type-list p-3">
                                                <div class="row d-flex justify-content-around">
                                                    <div
                                                        class="label-radio-wrapp type-list__item mx-auto p-0"
                                                        v-for="(item, index) in advertising_tariffs[0].price">
                                                        <input class="label-radio-wrapp__radio" type="radio"
                                                               name="fast-type" :checked="true"
                                                               v-model="firstAdvertisement"
                                                               :value="item" :id="'firstAdvertisement-'+index">
                                                        <label :for="'firstAdvertisement-'+index"
                                                               class="align-items-center d-flex justify-content-center label-radio-wrapp__label">
                                                            {{ item.days }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <div class="pay__promotion d-flex p-4"
                                     v-if="firstAdvertisement.days && isShowAdvertisementTariff(advertising_tariffs[0].id)">
                                    <p class="price mx-auto align-items-center justify-content-center d-flex">
                                        {{
                                            firstAdvertisement.days ? firstAdvertisement.days * firstAdvertisement.oneDay : null
                                        }}
                                        <span class="currency">руб</span></p>
                                    <p class="days mx-auto justify-content-center align-items-center d-flex">
                                        {{ firstAdvertisement.days }} дней</p>
                                    <button class="button button-disable justify-content-center mx-auto"
                                            :class="{'button-green': advertisements.first}"
                                            @click="advertisements.first = !advertisements.first"
                                            style="width: 180px; border-radius: 10px;">Выбрать
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" v-if="advertising_tariffs[1]">
                            <div class="promotion mb-3">
                                <div class=" d-flex align-items-lg-center p-4">
                                    <p class="title__promotion">{{ advertising_tariffs[1].title }}</p>
                                    <div class="price mx-auto d-flex align-items-center"
                                         style="margin-right: 0 !important;">
                                        <span class="text pt-2 pr-2 d-flex align-items-center">от</span>
                                        <p class="priceMin button-blueBorder borderblock  px-3
                                                    d-inline-block py-2
                                                    fw-light text-white" style="font-size: calc(1rem);">
                                            {{ advertising_tariffs[1].minPrice }} руб/день
                                        </p>
                                    </div>
                                </div>
                                <div class="content__promotion p-4">
                                    <div
                                        class="highlighting content-objects-list__item object-block object-block-border mb-4">
                                        <div class="object-block-favorites-wrapp">
                                            <input class="object-block-favorites__checkbox" type="checkbox"
                                                   name="checkbox-favorites">
                                            <label class="object-block-favorites__label">
                                                <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M16.0193 1.51891C13.832 0.483103 11.9106 2.06844 10.698 3.47532C10.1996 4.05355 9.2293 3.98927 8.7741 3.37645C7.62889 1.83468 5.62652 0.11665 3.16253 1.51891C-0.384959 3.5378 1.16251 7.51891 2.66253 9.51892C4.39799 11.8328 7.65041 14.4661 9.02416 15.5325C9.3952 15.8205 9.91428 15.7996 10.2743 15.498C11.8057 14.2151 14.4246 12.1044 16.1625 10.0189C18.9546 6.6684 19.5193 3.1764 16.0193 1.51891Z"
                                                        stroke="#B7C2CC" stroke-width="3"/>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="object-block__img">
                                            <img v-if="$props.object == null" alt="2"
                                                 :src="'/storage/listings/objects/' + sportObject.object_id + '/' + sportObject.storageImages[0]">
                                            <img v-else alt="2"
                                                 :src="'/storage/listings/objects/' + $props.object.id + '/' + $props.object.images[0]">
                                        </div>
                                        <div class="object-block__content">
                                            <div class="object-block__name">{{ sportObject.title }}</div>
                                            <div class="object-block__location object-location">
                                                <img class="object-location__flag" src="/icons/russia-icon.svg"
                                                     alt="russia-icon">
                                                <div class="object-location__country">
                                                    {{
                                                        sportObject.address.country.title || sportObject.address.country
                                                    }}
                                                </div>
                                                <div class="object-location__city">г.
                                                    {{
                                                        sportObject.address.city.title || sportObject.address.city
                                                    }}
                                                </div>
                                            </div>
                                            <div class="object-block__descr">
                                                {{ sportObject.description.replace(/<\/?[^>]+(>|$)/g, "") }}
                                            </div>
                                            <div class="object-block__cost text-center">
                                                <span>от 600 ₽</span> / с человека в сутки
                                            </div>
                                        </div>
                                        <div
                                            class="calculation__promotion wrapp-button d-flex justify-content-center mx-auto">
                                            <button type="button"
                                                    class=" button price__button rounded-0  button-fill shadow w-100">
                                                <p class="price__button__text w-100 text-start position-relative">
                                                    Запросить расчет
                                                </p>
                                                <img src="/icons/stages/calculation.svg" alt="">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer__promotion p-4 pb-2 border-0">
                                    <div>
                                        <p class="title__promotion pb-2">
                                            {{ advertising_tariffs[1].title }}</p>
                                        <p class="text__promotion">
                                            {{ advertising_tariffs[1].description }}</p>
                                        <template v-if="isShowAdvertisementTariff(advertising_tariffs[1].id)">
                                            <p class="duration__promotion pt-4">продолжительность (дней)</p>
                                            <div class="btn__promotion">
                                                <div class="highlighting-type__list highlighting-list p-3">
                                                    <div class="row d-flex justify-content-around">
                                                        <div
                                                            class="label-radio-wrapp highlighting-list__item mx-auto p-0"
                                                            v-for="(item, index) in advertising_tariffs[1].price">
                                                            <input class="label-radio-wrapp__radio" type="radio"
                                                                   name="highlight-type" v-model="secondAdvertisement"
                                                                   :id="'secondAdvertisement-'+index" :value="item">
                                                            <label :for="'secondAdvertisement-'+index"
                                                                   class="align-items-center d-flex justify-content-center label-radio-wrapp__label">
                                                                {{ item.days }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="pay__promotion d-flex p-4"
                                     v-if="secondAdvertisement.days && isShowAdvertisementTariff(advertising_tariffs[1].id)">
                                    <p class="price mx-auto align-items-center justify-content-center d-flex">
                                        {{
                                            secondAdvertisement.days ? secondAdvertisement.days * secondAdvertisement.oneDay : null
                                        }}
                                        <span class="currency">руб</span></p>
                                    <p class="days mx-auto justify-content-center align-items-center d-flex">
                                        {{ secondAdvertisement.days }} дней</p>
                                    <button class="button button-disable justify-content-center mx-auto"
                                            :class="{'button-green': advertisements.second}"
                                            @click="advertisements.second = !advertisements.second"
                                            style="width: 180px;border-radius: 10px;">Выбрать
                                    </button>
                                </div>
                            </div>
                            <div class="highlighting">

                            </div>
                        </div>
                        <div class="col-lg-4" v-if="advertising_tariffs[2]">
                            <div class="promotion mb-3">
                                <div class=" d-flex align-items-lg-center p-4">
                                    <p class="title__promotion">{{ advertising_tariffs[2].title }}</p>
                                    <div class="price mx-auto d-flex align-items-center"
                                         style="margin-right: 0 !important;">
                                        <span class="text pt-2 pr-2 d-flex align-items-center">от</span>
                                        <p class="priceMin button-blueBorder borderblock  px-3
                                                    d-inline-block py-2
                                                    fw-light text-white" style="font-size: calc(1rem);">
                                            {{ advertising_tariffs[2].minPrice }} руб/день
                                        </p>
                                    </div>
                                </div>
                                <div class="content__promotion p-4">
                                    <div class="content-objects-list__item object-block object-block-border mb-4">
                                        <div class="object-block-favorites-wrapp">
                                            <input class="object-block-favorites__checkbox" type="checkbox"
                                                   name="checkbox-favorites">
                                            <label class="object-block-favorites__label">
                                                <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M16.0193 1.51891C13.832 0.483103 11.9106 2.06844 10.698 3.47532C10.1996 4.05355 9.2293 3.98927 8.7741 3.37645C7.62889 1.83468 5.62652 0.11665 3.16253 1.51891C-0.384959 3.5378 1.16251 7.51891 2.66253 9.51892C4.39799 11.8328 7.65041 14.4661 9.02416 15.5325C9.3952 15.8205 9.91428 15.7996 10.2743 15.498C11.8057 14.2151 14.4246 12.1044 16.1625 10.0189C18.9546 6.6684 19.5193 3.1764 16.0193 1.51891Z"
                                                        stroke="#B7C2CC" stroke-width="3"/>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="object-block__img">
                                            <div class="object-block__vip-label">vip</div>
                                            <img v-if="$props.object == null" alt="3"
                                                 :src="'/storage/listings/objects/' + sportObject.object_id + '/' + sportObject.storageImages[0]">
                                            <img v-else alt="3"
                                                 :src="'/storage/listings/objects/' + $props.object.id + '/' + $props.object.images[0]">
                                        </div>
                                        <div class="object-block__content">
                                            <div class="object-block__name">{{ sportObject.title }}</div>
                                            <div class="object-block__location object-location">
                                                <img class="object-location__flag" src="/icons/russia-icon.svg"
                                                     alt="russia-icon">
                                                <div class="object-location__country">
                                                    {{
                                                        sportObject.address.country.title || sportObject.address.country
                                                    }}
                                                </div>
                                                <div class="object-location__city">г.
                                                    {{
                                                        sportObject.address.city.title || sportObject.address.city
                                                    }}
                                                </div>
                                            </div>
                                            <div class="object-block__descr">
                                                {{ sportObject.description.replace(/<\/?[^>]+(>|$)/g, "") }}
                                            </div>
                                            <div class="object-block__cost text-center">
                                                <span>от 600 ₽</span> / с человека в сутки
                                            </div>
                                        </div>
                                        <div
                                            class="calculation__promotion wrapp-button d-flex justify-content-center mx-auto">
                                            <button type="button"
                                                    class=" button price__button rounded-0  button-fill shadow w-100">
                                                <p class="price__button__text w-100 text-start position-relative">
                                                    Запросить расчет
                                                </p>
                                                <img src="/icons/stages/calculation.svg" alt="">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer__promotion p-4 pb-2 border-0">
                                    <p class="title__promotion pb-2">
                                        {{ advertising_tariffs[2].title }}</p>
                                    <p class="text__promotion">
                                        {{ advertising_tariffs[2].description }}</p>
                                    <template v-if="isShowAdvertisementTariff(advertising_tariffs[2].id)">
                                        <p class="duration__promotion pt-4">продолжительность (дней)</p>
                                        <div class="btn__promotion">
                                            <div class="vip-type__list vip-list p-3">
                                                <div class="row d-flex justify-content-around">
                                                    <div class="label-radio-wrapp vip-list__item mx-auto p-0"
                                                         v-for="(item, index) in advertising_tariffs[2].price">
                                                        <input class="label-radio-wrapp__radio" type="radio"
                                                               name="vip-type" v-model="thirdAdvertisement"
                                                               :id="'thirdAdvertisement-'+index" :value="item">
                                                        <label :for="'thirdAdvertisement-'+index"
                                                               class="align-items-center d-flex justify-content-center label-radio-wrapp__label">
                                                            {{ item.days }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <div class="pay__promotion d-flex p-4"
                                     v-if="thirdAdvertisement.days && isShowAdvertisementTariff(advertising_tariffs[2].id)">
                                    <p class="price mx-auto align-items-center justify-content-center d-flex">
                                        {{
                                            thirdAdvertisement.days ? thirdAdvertisement.days * thirdAdvertisement.oneDay : null
                                        }}
                                        <span class="currency">руб</span>
                                    </p>
                                    <p class="days mx-auto justify-content-center align-items-center d-flex">
                                        {{ thirdAdvertisement.days }} дней</p>
                                    <button class="button button-disable justify-content-center mx-auto"
                                            :class="{'button-green': advertisements.third}"
                                            style="width: 180px;border-radius: 10px;"
                                            @click="advertisements.third = !advertisements.third">
                                        Выбрать
                                    </button>
                                </div>
                            </div>
                            <div class="markVIP">
                            </div>
                        </div>
                    </div>

                    <div class="btnPrevAndNext d-flex justify-content-around justify-content-between pb-4 pt-4 row">
                        <div class="col-8 col-md-8 col-lg-4">
                            <button class="button button-green btnSize justify-content-center w-100"
                                    style=" border-radius: 5px; margin-right: 0 !important;" @click="payPromotion">
                                Оплатить продвижение
                                <img class="pl-2" src="/icons/next.svg" alt="">
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import axios from "axios";
import StepperItem from "./StepperItem";

export default {
    components: {StepperItem},
    props: {
        idObject: {
            default: null
        },
        object: {}
    },
    data() {
        return {
            firstAdvertisement: [],
            secondAdvertisement: [],
            thirdAdvertisement: [],
            sportObject: null,
            editObject: false,
            advertisements: {first: false, second: false, third: false}
        }
    },
    computed: {
        ...mapGetters({advertising_tariffs: 'advertising_tariffs'}),
    },
    methods: {
        ...mapActions(["getAdvertisingTariffs"]),
        payPromotion() {
            let advertisements_pay = [];
            if (this.advertisements.first) {
                advertisements_pay.push({id: this.advertising_tariffs[0].id, price: this.firstAdvertisement});
            }
            if (this.advertisements.second) advertisements_pay.push({
                id: this.advertising_tariffs[1].id,
                price: this.secondAdvertisement
            });
            if (this.advertisements.third) advertisements_pay.push({
                id: this.advertising_tariffs[2].id,
                price: this.thirdAdvertisement
            });

            let temp = advertisements_pay.map(item => {
                return item.price
            })
            let amount = temp.reduce((acc, item) => acc += item.allPrice, 0);
            axios.post('/payments/create', {
                sportObject_id: this.sportObject.object_id,
                amount: amount,
                advertisements: advertisements_pay,
                description: 'Оплата за рекламное продвижение'
            })
        },
        isShowAdvertisementTariff(id_Tariff) {
            if (this.sportObject && this.sportObject.advertisements) {
                for (const advertisement of this.sportObject.advertisements) {
                    if (advertisement.rate.id === id_Tariff) {
                        return false;
                    }
                }
            }
            return true;
        }
    },
    mounted() {
        this.$emit("loading", true);
        const objectFromLocalStorage = localStorage.getItem('object');

        if (objectFromLocalStorage != null) {
            const timeout = this.$props.object == null ? 1000 : 0;
            setTimeout(() => {
                this.sportObject = JSON.parse(objectFromLocalStorage);
                if (this.$props.object == null) {
                    this.sportObject.object_id = this.$props.idObject;
                }
                localStorage.removeItem("object");
            }, timeout);
        }

        if (this.$props.object != null) {
            this.editObject = true;
        }

        this.$emit("loading", false);
    },
    created() {
        this.$store.dispatch('getAdvertisingTariffs');
    },
    name: "ThirdStage"
}
</script>

<style scoped>
</style>
