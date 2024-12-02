<template>
    <div class="main-stage firstStage">
        <div class="container pb-5">
            <nav aria-label="breadcrumb" class="pt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $props.object == null ? 'Добавить новый объект' : 'Редактировать объект' }}
                    </li>
                </ol>
            </nav>

            <div class="caption-stage row d-flex d-xl-flex justify-content-center justify-content-xl-center">
                <div class="col-md-12">
                    <h1 class="title__stage text-uppercase text-center d-flex justify-content-center"
                        style="font-size: calc(1.875rem);">
                        <strong>{{ $props.object == null ? 'Добавить новый объект' : 'Редактировать объект' }}</strong>
                    </h1>
                </div>
                <hr class="caption-stage__hr mt-3">
            </div>

            <div class="row create-object-stepper">
                <stepper-item icon="/icons/stages/real-estate.svg" title="Информация об объекте"
                              line-image="/icons/stages/first.svg"/>
                <stepper-item icon="/icons/stages/like.svg"
                              :title="`Подтверждение ${ $props.object == null ? ' добавления' : ' редактирования' }`"
                              line-image="/icons/stages/secondWhite.svg"/>
                <stepper-item icon="/icons/stages/growing.svg" title="Продвижение на сайте"
                              line-image="/icons/stages/thirdWhite.svg"/>
            </div>

            <div class="main-content__stage" v-if="sportObject">
                <div class="row mr-4 ml-4 ml-lg-0 mr-lg-0">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10 col-12 p-0">
                        <ValidationObserver v-slot="props" tag="form" ref="observer" @submit.prevent="nextStep">
                            <div class="row">
                                <div class="col-12 col-md-12 pt-4">
                                    <h1 class="caption__title">Название и тип объекта</h1>
                                </div>
                            </div>

                            <div class="row row_name-and-object">
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-8">
                                            <label class="w-100 caption" for="nameOb">Полное название объекта
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <span id="nameOb" class="float-right text-muted font-weight-normal">
                                                    {{ sportObject.title.length }}/300
                                                </span>
                                                <ValidationProvider rules="required|max:300"
                                                                    v-slot="{ failed, errors }">
                                                    <input :maxlength="maxNameObject" v-model="sportObject.title"
                                                           :class="{ 'is-invalid': failed }" type="text"
                                                           class="input-profile-info"
                                                           placeholder="AquaLife Спортивно-гостиничный комплекс">
                                                    <span class="error-valid">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </label>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="w-100 caption select-wrapper mb-xl-2" for="category">
                                                Категория объекта <span style="color: rgb(243, 122, 138)">*</span>
                                                <v-select id="category" labelTitle="Выбрать" textProp="title"
                                                          valueProp="id" class="selectpicker mt-1" name="category"
                                                          :options="listData.list_objectTypes"
                                                          v-model="sportObject.objectType"
                                                          return-object @input="getCategoryId">
                                                </v-select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row_photo-and-description-object">
                                <ValidationProvider rules="photosCount" v-slot="{errors, failed}" class="col-12">
                                    <input type="text" v-model="countPhoto" disabled class="d-none">
                                    <div class="col-sm-12 p-0">
                                        <div class="row">
                                            <div class="col-12 col-md-12 text-nowrap pt-2 w-100">
                                                <label class="w-100 caption select-wrapper mb-xl-2" for="photo">Фото
                                                    объекта <span style="color: rgb(243, 122, 138)">*</span>
                                                    <span id="photo"
                                                          class="spanRightMobile pl-4 text-muted font-weight-normal">
                                                        {{ countPhoto }}/10
                                                        <span class="error-valid" style="float: none">
                                                            {{ errors[0] }}
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="blockUploadImages d-flex d-lg-flex justify-content-start">
                                            <div v-for="(data, index) in filesPreview" :key="index"
                                                 class="blockImage d-flex align-items-center justify-content-center">
                                                <div class="image-preview h-100 position-relative">
                                                    <img @click="openinput" class="img-responsive h-100"
                                                         :src="data" alt="">
                                                    <div @click="removeFile(index)"
                                                         class="align-items-center d-flex justify-content-center position-absolute remove-image">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12.207"
                                                             height="12.206"
                                                             viewBox="0 0 12.207 12.206">
                                                            <rect id="Прямоугольник_6113" data-name="Прямоугольник 6113"
                                                                  width="3.342" height="13.92" rx="1.671"
                                                                  transform="translate(0.001 2.363) rotate(-45)"
                                                                  fill="#9dabb8"/>
                                                            <rect id="Прямоугольник_6114" data-name="Прямоугольник 6114"
                                                                  width="3.34" height="13.92" rx="1.67"
                                                                  transform="translate(9.843 0) rotate(45)"
                                                                  fill="#9dabb8"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="image-input image-input-tbd d-flex"
                                                 v-if="filesPreview.length < option.maxFileCount">
                                                <div class="image-preview blockImage d-flex justify-content-center
                                                    align-items-center position-relative" @click="openinput">
                                                    <div class="imgUpload"/>
                                                </div>
                                                <input type="file" ref="file" class="d-none" id="vue-file-upload-input"
                                                       @change="addImage" accept="image/jpeg, image/jpg, image/png">
                                            </div>
                                        </div>

                                        <div class="row captionUploadPhoto pl-1 pt-1">
                                            <p class="label">Формат фотографий - не менее 500px по широкой
                                                и узкой стороне / jpg или png без alpha канала</p>
                                        </div>

                                        <div class="row pt-2">
                                            <div class="col-12 col-sm-12 d-flex d-lg-flex justify-content-start
                                                        justify-content-lg-start justify-content-xl-start">
                                                <div class="text-left d-lg-flex justify-content-lg-center w-100">
                                                    <custom-vue-editor text-label="Описание объекта"
                                                                       style="font-size: 16px"
                                                                       @update:text="sportObject.description = $event"
                                                                       :max-length="maxDescriptionObject"
                                                                       :text="sportObject.description" :props="props"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ValidationProvider>
                            </div>
                            <check-box-group :options="allServices"
                                             :selectedOptions="sportObject.services"
                                             label="Предоставляемые услуги"
                                             :validationRules="'required'"
                                             @update:selectedOptions="sportObject.services = $event"/>

                            <check-box-group :options="sportTypes"
                                             :selectedOptions="sportObject.sports"
                                             label="Доступные виды спорта"
                                             :validationRules="'required'"
                                             @update:selectedOptions="sportObject.sports = $event"/>

                            <div style="margin-top: 1%;">
                                <div class="row">
                                    <div class="p-0">
                                        <hr class="hr1">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 mb-lg-0">
                                <div class="col-12 pt-3 pl-3">
                                    <h1 class="caption__title">условия и цены</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-7 pl-3">
                                    <custom-vue-editor text-label="Общее описание условий и правил проживания"
                                                       @update:text="sportObject.pricing.description = $event"
                                                       :max-length="maxDescriptionLive"
                                                       :text="sportObject.pricing.description" :props="props"/>
                                </div>
                                <div class="col-12 col-sm-12 col-md-5">
                                    <included-pricing-form :included="sportObject.pricing.included"
                                                           :included-length="sportObject.pricing.included.length"
                                                           @add-included-pricing="addIncludedPricing"
                                                           @delete-included-pricing="deleteIncludedPricing"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mt-3 mt-lg-0">
                                    <div class="col-sm-12 p-0 pb-lg-3 pt-lg-0">
                                        <ValidationProvider :vid="`accommodation_length`" rules="accommodationsCount"
                                                            v-slot="{errors, failed, touched}">
                                            <input type="text" v-model="sportObject.pricing.typeLiving.length" disabled
                                                   class="d-none">
                                            <p class="caption">Типы проживания и стоимость
                                                <span class="spanRightMobile text-muted font-weight-normal">
                                                {{ sportObject.pricing.typeLiving.length }}/100
                                                <span class="error-valid">{{ errors[0] }}</span>
                                            </span>
                                            </p>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="col-sm-12 buttonOption pb-4">
                                    <button type="button" @click="openModalAccommodation" data-toggle="modal"
                                            data-target="#sb-type-living" class="button button-borderBlue">
                                        Добавить опцию +
                                    </button>
                                </div>
                            </div>

                            <ValidationObserver :vid="'living'" mode="eager" disabled>
                                <type-living-pricing :type-living="sportObject.pricing.typeLiving"
                                                     :types="accommodation_types" :pricing="sportObject.pricing"
                                                     @update-type-living="handleUpdateTypeLiving"
                                                     @add-type-living="handleAddTypeLiving"
                                                     @delete-living="handleDeleteLiving"/>
                            </ValidationObserver>

                            <div class="row">
                                <div class="col-12 col-sm-8 col-md-12 p-0">
                                    <sb-modal id="sb-infrastructure" ref="sb-infrastructure"
                                              modal_dialog_class="modal-lg"
                                              :title="infrastructureEditId != null ? 'Редактировать объект инфраструктуры'
                                              : 'Добавить объект инфраструктуры'"
                                              modal_class="sb-infrastructure p-0 px-4" modal_title_class="text-xl-left">
                                        <template #body>
                                            <label class="w-100 caption mt-3" for="nameObject">Название объекта
                                                <input type="text" name="search-object" autocomplete="off"
                                                       v-model="titleInfrastructure" id="nameObject"
                                                       placeholder="Тренажерный зал" class="input-profile-info">
                                            </label>
                                            <div class="uploadImage">
                                                <p class="caption">Фото объекта</p>
                                                <div class="d-flex flex-lg-nowrap flex-wrap">
                                                    <div class="block__upload mb-2 mb-lg-0">
                                                        <div class="block__upload-image"
                                                             style="width: 110px;height: 110px;">
                                                            <div style="overflow: hidden"
                                                                 class="block__rectangle d-flex justify-content-center">
                                                                <img class="img__upload" v-if="!imageSrc"
                                                                     style="width: 30px;"
                                                                     src="/icons/settings/file-upload.svg"
                                                                     alt="">
                                                                <img alt="" v-show="imageSrc" :src="imageSrc"
                                                                     class="img__upload Image-input__image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="file" accept="image/jpeg, image/jpg, image/png"
                                                           class="d-none" id="vue-file-upload-inp"
                                                           @change="addImageInfrastructure">
                                                    <div class="text d-flex flex-wrap">
                                                        <div @click="openinputInfrastructure"
                                                             class="text-upload d-flex align-items-center justify-content-center ml-lg-3 ml-0">
                                                            Загрузить новую фотографию
                                                            <img class="pl-4"
                                                                 src="/icons/stages/file-upload.svg"
                                                                 alt=""/>
                                                        </div>
                                                        <div class="subtitle pl-lg-3 pl-0 pt-1">Формат фотографий -
                                                            не менее 500px по широкой и узкой стороне / jpg или
                                                            png без alpha канала
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="caption w-100 mt-3 mb-0">Опции<span
                                                    class="text-muted float-right font-weight-normal">
                                                            {{ countOptions }}/100</span>
                                                </label>
                                                <div class="closeOptions p-0 d-flex align-items-center"
                                                     v-for="(item, index) in objectOptionsInfrastructure">
                                                    <img v-if="item.title !== ''" class="position-absolute"
                                                         @click.prevent="deleteOptionsInfrastruct(index)"
                                                         style="z-index: 1; right: 45px; cursor:pointer"
                                                         src="/icons/stages/exit.svg" alt="exit">
                                                    <input type="file" class="d-none"
                                                           accept="image/jpeg, image/jpg, image/png"
                                                           id="file-upload-infrastructure"
                                                           @change="addImage">
                                                    <div class="col-sm-12 p-0 m-0">
                                                        <div class="h-100 mb-2">
                                                            <input type="text" autocomplete="off"
                                                                   :key="item.id" name="search-object"
                                                                   v-model="item.title"
                                                                   placeholder="Введите название опции"
                                                                   class="input-price-info h-100">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 p-0 m-0 buttonOption">
                                                    <button type="button" @click="addObjectOptionsInfra"
                                                            class="button button-borderBlue">Добавить опцию +
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="justify-content-center d-flex pt-3">
                                                <button type="button" @click="saveInfrastructure"
                                                        class="button button-green justify-content-center">
                                                    Сохранить
                                                </button>
                                            </div>
                                        </template>
                                    </sb-modal>
                                    <div class="col-12 p-0">
                                        <div class="col-sm-12">
                                            <ValidationProvider rules="infrastructuresCount" v-slot="{errors, failed}">
                                                <input type="text" v-model="infrastructuresCount" disabled
                                                       class="d-none">
                                                <p class="caption pb-lg-3">Инфраструктура
                                                    <span class="text-muted font-weight-normal">
                                                        {{ sportObject.pricing.infrastructures.length }}/100
                                                        <span class="error-valid">{{ errors[0] }}</span>
                                                    </span>
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                    <div class="buttonOption pb-4 col-12 col-sm-12 d-flex d-xl-flex
                                                justify-content-center justify-content-xl-start">
                                        <button data-toggle="modal" data-target="#sb-infrastructure" type="button"
                                                @click="clearInfrastructureModal" class="button button-borderBlue">
                                            Добавить опцию +
                                        </button>
                                    </div>
                                    <div class="row row-cols-sm-1 row-cols-md-3 row-cols-12 px-3">
                                        <div v-if="item.title !== '' " class="blockInfrastructure col"
                                             v-for="(item, index) in sportObject.pricing.infrastructures">
                                            <div class="infrastruct el wrapper shadow bg-white borderblock mb-3">
                                                <div class="btnFunc d-flex">
                                                    <a data-toggle="modal" data-target="#sb-infrastructure"
                                                       @click.prevent="editInfrastructure(index)" class="pr-2" href="#">
                                                    <span
                                                        class="btnAction align-items-lg-center justify-content-center d-flex">
                                                        <img src="/icons/stages/edit.svg" alt="edit">
                                                    </span>
                                                    </a>
                                                    <a @click.prevent="deleteInfrastructure(index)"><span
                                                        class="btnAction align-items-lg-center justify-content-center d-flex"><img
                                                        src="/icons/stages/cancel.svg" alt="del"></span></a>
                                                </div>
                                                <div class="ul__list_objects">
                                                    <img :src="item.image && item.image != '/storage/listings/infrastruct/null'
                                                    ? item.image : '/images/no-photo.png'" alt="Image"
                                                         style="border-radius: 8px 8px 0 0;object-fit: cover;"
                                                         class="el__img w-100">
                                                    <p class="el__title p-4">{{ item.title }}</p>
                                                    <ul class="list-overflow mx-2 pb-4"
                                                        :class="{'h-auto': infrastructure_detail}">
                                                        <li v-for="option in item.options"
                                                            v-if="option.title !== ''">
                                                            <p class="fs-6 opacity-7">
                                                                {{ option.title }}</p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div v-if="item.options.length > 4"
                                                     class="justify-content-center align-items-lg-center d-flex">
                                                    <button type="button"
                                                            @click="!infrastructure_detail ? infrastructure_detail = true : infrastructure_detail = false"
                                                            class="button button-borderBlue btnViewFull justify-content-between">
                                                        {{ !infrastructure_detail ? 'Показать полностью' : 'Скрыть' }}
                                                        <img src="/icons/arrowDownBlue.svg" alt="">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="block__address-main_info pt-4 pb-2">
                                    <address-form :show-input="true" :title-block="'АДРЕС ОБЪЕКТА'" default-class=""
                                                  :map-height="500" :address-prop="sportObject.address"
                                                  :coords="[sportObject.address.latitude, sportObject.address.longtitude]"
                                                  @update-address="sportObject.address = $event"/>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="block_rul col-sm-12 mt-4">
                                    <div class="text-center">
                                        <p class="text__rules d-flex">
                                            <img class="pr-3" src="/icons/stages/information.svg">
                                            <span class="confidently">Нажимая на кнопку "Далее", вы соглашаетесь с
                                            <a href="/terms">Правилами платформы</a> и
                                            <a href="#">Политикой Конфиденицальности</a>
                                                </span>
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 d-flex pt-4 pb-4">
                                <div class="text-center mx-auto">
                                    <button type="submit" class="button button-green justify-content-center">Далее
                                    </button>
                                </div>
                            </div>
                        </ValidationObserver>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import VSelect from "@alfsnd/vue-bootstrap-select";
import {mapActions, mapGetters} from 'vuex';
import axios from "axios";
import eventBus from '../../event-bus';

import {extend} from 'vee-validate';
import SbModal from "../elements/SbModal";
import IncludedPricingForm from "./IncludedPricingForm";
import CustomVueEditor from "../elements/CustomVueEditor";
import AddressForm from "../AddressForm";
import CheckBoxGroup from "./CheckBoxGroup";
import TypeLivingPricing from "./TypeLivingPricing";
import StepperItem from "./StepperItem";

extend('photosCount', {
    validate: (value => {
        return value > 0;
    }),
    message: 'Не добавлено ни одного фото'
});
extend('infrastructuresCount', {
    validate: (value => {
        return value > 0;
    }),
    message: 'Не добавлено ни одной инфраструктуры'
});

export default {
    props: {
        object: {
            type: Object,
            default: null
        },
        id: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            // Объект спортивного объекта
            sportObject: {
                title: '',
                objectType: null,
                objectType_id: null,
                images: [],
                description: '<p style="color: #0B3158"></p>',
                files: [],
                storageImages: [],
                services: [],
                sports: [],
                pricing: {
                    accCondPricing_id: null,
                    included_id: null,
                    accm_minPrice: null,
                    description: '<p style="color: #0B3158"></p>',
                    included: [{id: 0, title: ''}],
                    typeLiving: [],
                    infrastructures: []
                },
                object_id: null,
                address: {
                    country: null,
                    region: null,
                    city: null,
                    postIndex: null,
                    street: null,
                    city_id: null,
                },
                user_id: user.id,
                id: null,
            },
            // Превью файлов
            filesPreview: [],
            // Данные списка
            listData: {list_objectTypes: []},
            // Максимальная длина названия объекта
            maxNameObject: 300,
            // Максимальная длина описания объекта
            maxDescriptionObject: 2000,
            // Максимальная длина описания проживания
            maxDescriptionLive: 1000,
            // Изображение
            image: '',
            // Счетчики
            countOptions: 0,
            countPhoto: 0,
            // Загрузка
            loading: false,
            option: {maxFileCount: 10},
            // Идентификатор следующего включенного в цену
            nextIdIncludedPrice: 0,
            // Идентификатор следующего включенного в опции
            nextIdOptions: 0,
            // Изображение инфраструктуры
            ImageInfrastructure: '',
            // Название инфраструктуры
            titleInfrastructure: '',
            // Количество объектов
            countObject: 0,
            // Идентификатор инфраструктуры
            infrastructureId: null,
            // Опции объекта инфраструктуры
            objectOptionsInfrastructure: [],
            // Источник изображения
            imageSrc: '',
            // Изображение инфраструктуры
            imageInfrastructures: '',
            // Редактирование инфраструктуры
            isEditInfrastructure: false,
            // Идентификатор редактируемой инфраструктуры
            infrastructureEditId: null,
            // Файл
            file: '',
            // Редактирование объекта
            isEditObject: false,
            // Детализация инфраструктуры
            infrastructure_detail: false,
            // Текущий месяц
            currentMonth: new Date().getMonth(),
            // Месяцы
            month: [
                {id: 0, text: 'Январь', title: 'january', minPrice: 0, maxPrice: 0},
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
                {id: 11, text: 'Декабрь', title: 'december', minPrice: 0, maxPrice: 0}
            ],
            // Типы спорта
            sportTypes: [],
            // Все услуги
            allServices: []
        }
    },
    watch: {
        sportObject: {
            async handler(sportObject) {
                if (sportObject.title !== "") {
                    //this.sportObject.address = sportObject.address
                    this.setStoreSportObject({
                        object: this.sportObject,
                        edit: this.isEditObject
                    });
                }
                if (sportObject.objectType == null) {
                    this.sportObject.objectType = this.listData.list_objectTypes[0];
                }
            },
            deep: true
        },
    },
    computed: {
        ...mapGetters({
            getterSportTypes: 'AllSportTypes',
            allCities: 'AllCities',
            gettersServices: 'AllServices',
            accommodation_types: "AllAccomodationTypes",
            object_types: "AllObjectTypes",
        }),
        city_id() {
            return this.allCities.find(item => item.title === this.sportObject.address.city);
        },
        user: function () {
            return window.user;
        },
        infrastructuresCount() {
            return this.sportObject.pricing.infrastructures.length;
        },
        typeLivingCount() {
            return this.sportObject.pricing.typeLiving.length;
        },
    },
    methods: {
        ...mapActions(["fetchSportTypes",
            "fetchServices", "fetchAccomodationTypes", "setStoreSportObject", "fetchObjectTypes"]),
        openModalAccommodation() {
            eventBus.$emit('open-modal-accommodation');
        },
        openinput: function () {
            document.getElementById("vue-file-upload-input").click();
        },
        async getImageBase64(fullPath) {
            const response = await fetch(fullPath);
            const blob = await response.blob();
            return new Promise(resolve => {
                const reader = new FileReader();
                reader.onload = () => resolve(reader.result);
                reader.readAsDataURL(blob);
            });
        },
        addImage: function (e) {
            const tmpFiles = e.target.files;
            if (tmpFiles.length === 0) {
                return false;
            }
            const file = tmpFiles[0];
            const self = this;
            const reader = new FileReader();
            reader.onload = function (e) {
                const image = new Image();
                image.src = reader.result;
                image.onload = async function () {
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Размер файла не должен превышать 5 МБ. Попробуйте сжать изображение');
                        return;
                    }
                    if (image.width >= 500 && image.height >= 500 && ['image/jpeg', 'image/png']
                        .includes(file.type) && !file.type.includes('alpha')) {
                        let formData = new FormData();
                        formData.append('file', file);
                        if (this.isEditObject) {
                            formData.append('id', self.sportObject.id);
                            formData.append('edit', true);
                        }
                        await axios.post('/uploadImages', formData, {
                            'headers': {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(response => {
                            self.sportObject.storageImages.push(response.data);
                        })
                        const previewImage = reader.result;
                        self.filesPreview.push(previewImage);
                        self.countPhoto++;
                    } else {
                        alert('Формат фотографий - не менее 500px по широкой и узкой стороне / jpg или png без alpha канала');
                    }
                };
            };
            reader.readAsDataURL(file);
        },
        removeFile: function (index) {
            let image = this.sportObject.storageImages[index];
            let edit = this.isEditObject;
            let object_id = this.$props.object?.id ?? null;

            if (object_id === null) {
                this.filesPreview.splice(index, 1);
                this.sportObject.storageImages.splice(index, 1);
                this.sportObject.images.splice(index, 1);
                this.countPhoto--;
                return;
            }
            axios.post('/removeImage', {
                object_id, edit, image
            }).then((response) => {
                this.filesPreview.splice(index, 1);
                this.sportObject.images.splice(index, 1);
                this.sportObject.storageImages.splice(index, 1);
                document.getElementById("vue-file-upload-input").value = null;
                this.countPhoto--;
            }).catch((error) => {
                console.error('Error removing image:', error);
            });
        },
        addIncludedPricing() {
            const MAX_INCLUDED_COUNT = 100;

            const included = this.sportObject.pricing.included;
            const lastIncluded = included[included.length - 1];
            if (included.length <= MAX_INCLUDED_COUNT && lastIncluded.title !== '') {
                this.nextIdIncludedPrice++;
                included.push({id: this.nextIdIncludedPrice, title: ''});
            }
        },
        deleteIncludedPricing(index) {
            const included = this.sportObject.pricing.included;
            if (included.length > 1 && index >= 0 && index < included.length) {
                included.splice(index, 1);
                this.nextIdIncludedPrice--;
            }
        },
        getCity_id(cities) {
            this.sportObject.address.city_id = cities.id;
        },
        /**Действия "типы проживания и стоимость"*/
        handleUpdateTypeLiving(data) {
            const {index, newData} = data;
            this.$set(this.sportObject.pricing.typeLiving, index, newData);
        },
        handleAddTypeLiving(newData) {
            this.sportObject.pricing.typeLiving.push(newData);
        },
        handleDeleteLiving(index) {
            this.$delete(this.sportObject.pricing.typeLiving, index)
        },

        /**Инфраструктура*/
        addObjectOptionsInfra() {
            if (this.countOptions < 101) {
                if (this.objectOptionsInfrastructure[this.nextIdOptions].title !== '') {
                    this.objectOptionsInfrastructure.push({
                        id: this.nextIdOptions,
                        title: this.objectOptionsInfrastructure[this.nextIdOptions].title
                    });
                    this.countOptions++;
                    this.nextIdOptions++;
                    this.objectOptionsInfrastructure[this.nextIdOptions].title = '';
                }
            }
        },
        uploadImageInfrastruct(image) {
            let formData = new FormData();
            formData.append('file', image);
            axios.post('/uploadImages/infrastruct', formData, {
                'headers': {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                this.imageInfrastructures = response.data;
            })
        },
        addImageInfrastructure: function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const vm = this;
                reader.onload = function (e) {
                    vm.imageSrc = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
                this.uploadImageInfrastruct(input.files[0]);
            }
        },
        saveInfrastructure() {
            const {
                isEditInfrastructure, infrastructureEditId, titleInfrastructure, imageSrc,
                imageInfrastructures, objectOptionsInfrastructure
            } = this;
            const {pricing} = this.sportObject;

            if (isEditInfrastructure) {
                const infrastructure = {
                    id: this.infrastructureId, title: titleInfrastructure, image: imageSrc,
                    imageInfr: imageInfrastructures, options: objectOptionsInfrastructure
                };

                const newInfrastructures = [...pricing.infrastructures];
                newInfrastructures[infrastructureEditId] = infrastructure;

                this.$set(this.sportObject.pricing, 'infrastructures', newInfrastructures);
            } else if (titleInfrastructure !== '') {
                const infrastructure = {
                    id: null, title: titleInfrastructure, image: imageSrc,
                    imageInfr: imageInfrastructures, options: objectOptionsInfrastructure
                };

                this.sportObject.pricing.infrastructures = [...pricing.infrastructures, infrastructure];
            }
            this.clearInfrastructureModal();
            $('#sb-infrastructure').modal('hide');
        },
        editInfrastructure(index) {
            const {pricing} = this.sportObject;
            const infrastructure = pricing.infrastructures[index];
            this.infrastructureEditId = index;
            this.infrastructureId = infrastructure.id;
            this.titleInfrastructure = infrastructure.title;
            this.imageSrc = infrastructure.image;
            this.objectOptionsInfrastructure = infrastructure.options;
            this.setEditingInfrastructureState();
        },
        setEditingInfrastructureState() {
            if (this.objectOptionsInfrastructure.length === 0) {
                this.objectOptionsInfrastructure.push({id: 0, title: ''});

                this.countOptions = 0;
                this.nextIdOptions = 1;
                this.isEditInfrastructure = true;
                return;
            }
            if (this.objectOptionsInfrastructure[this.objectOptionsInfrastructure.length - 1].title !== '') {
                this.objectOptionsInfrastructure.push({id: 0, title: ''});
            }
            this.countOptions = this.objectOptionsInfrastructure.length - 1;
            this.nextIdOptions = this.objectOptionsInfrastructure.length - 1;
            this.isEditInfrastructure = true;
        },
        deleteInfrastructure(index) {
            this.$delete(this.sportObject.pricing.infrastructures, index);
        },
        deleteOptionsInfrastruct(index) {
            if (this.countOptions > 0) {
                this.$delete(this.objectOptionsInfrastructure, index)
                this.countOptions--;
                this.nextIdOptions--;
            }
        },
        clearInfrastructureModal() {
            this.titleInfrastructure = '';
            this.imageSrc = '';
            this.objectOptionsInfrastructure = [];
            this.objectOptionsInfrastructure.push({
                id: 0,
                title: ''
            });
            this.countOptions = 0;
            this.nextIdOptions = 0;
            this.infrastructureEditId = null;
        },
        openinputInfrastructure: function () {
            document.getElementById("vue-file-upload-inp").click();
        },
        getCategoryId(category) {
            if (category == 'undefined') {
                console.log('undefined')
            } else this.sportObject.objectType_id = category.id;
        },
        async nextStep() {
            await this.$refs.observer.validate().then(success => {
                if (!success) {
                    setTimeout(() => {
                        const errors = Object.entries(this.$refs.observer.errors)
                            .map(([key, value]) => ({key, value}))
                            .filter(error => error["value"].length);
                        const firstErrorRef = this.$refs.observer.refs[errors[0]["key"]];
                        if (firstErrorRef && firstErrorRef.$el) {
                            firstErrorRef.$el.scrollIntoView({
                                behavior: "smooth",
                                block: "center"
                            });
                        }
                    }, 100);
                } else {
                    this.$emit('nextStep');
                }
            });
        },
        async editSportObject(sportObject) {
            const {
                id, title, objectType_title, images, services, sports, description, accommodations,
                accomodationConditionAndPricing_id, accomodationConditionAndPricing_included,
                accomodationConditionAndPricing_included_id, city_id, country, region, city, postIndex, address,
                advertisements, latitude, longtitude
            } = sportObject;

            const newImages = images.map(image => `/storage/listings/objects/${this.$props.object.id}/${image}`);
            const newServices = services.map(service => service.id);
            const newSports = sports.map(sport => sport.id);
            const newInfrastructures = sportObject.infrastructures.map(({infrastructure_id, title, image, options}) =>
                ({
                    id: infrastructure_id,
                    title,
                    image: `/storage/listings/infrastruct/${image}`,
                    imageInfr: image,
                    options
                }));

            const newPricing = {
                accm_minPrice: sportObject.accm_minPrice,
                description: sportObject.termsAndPrices,
                included: accomodationConditionAndPricing_included.filter(item => item.title !== '').concat({
                    id: this.nextIdIncludedPrice,
                    title: ''
                }),
                accCondPricing_id: accomodationConditionAndPricing_id,
                included_id: accomodationConditionAndPricing_included_id,
                infrastructures: newInfrastructures,
                typeLiving: accommodations.map(accommodation => ({
                    id: accommodation.id,
                    idAccType: accommodation.idAccType,
                    title: accommodation.type,
                    description: accommodation.description,
                    price: accommodation.price
                }))
            };

            const newAddress = {city_id, country, region, city, postIndex, street: address, latitude, longtitude};

            this.sportObject = {
                ...this.sportObject,
                title,
                objectType: this.listData.list_objectTypes.find(item => item.title === objectType_title),
                objectType_id: this.listData.list_objectTypes.find(item => item.title === objectType_title).id,
                images: newImages,
                countPhoto: newImages.length,
                storageImages: images,
                description,
                services: newServices,
                sports: newSports,
                pricing: newPricing,
                address: newAddress,
                id,
                advertisements
            };
            await this.getCoords(this.sportObject);

            const objectId = this.$props.object?.id;

            const imageFolder = objectId ? `/storage/listings/objects/${objectId}/` : '/storage/listings/objects/temp/';
            const tempImages = this.sportObject.storageImages.map(image => this.getImageBase64(imageFolder + image));
            this.filesPreview = await Promise.all(tempImages);

            this.files = this.sportObject.images;
            this.countPhoto = this.sportObject.storageImages.length;

            this.countObject += accommodations.length;
            this.nextIdIncludedPrice++;
            this.infrastructureId += sportObject.infrastructures.length;
        },
        async fillSportObject(storedObject) {
            this.sportObject = {
                ...this.sportObject,
                title: storedObject.title,
                objectType: this.listData.list_objectTypes.find(item => item.title === storedObject.objectType.title),
                images: storedObject.images,
                countPhoto: storedObject.images.length,
                storageImages: storedObject.storageImages,
                description: storedObject.description,
                services: storedObject.services,
                sports: storedObject.sports,
                pricing: {
                    ...this.sportObject.pricing,
                    accm_minPrice: storedObject.pricing.accm_minPrice,
                    description: storedObject.pricing.description,
                    included: storedObject.pricing.included,
                    typeLiving: storedObject.pricing.typeLiving || [],
                    infrastructures: storedObject.pricing.infrastructures || []
                },
                address: {
                    ...this.sportObject.address,
                    country: storedObject.address.country,
                    region: storedObject.address.region,
                    city: storedObject.address.city,
                    postIndex: storedObject.address.postIndex,
                    street: storedObject.address.street,
                    city_id: storedObject.address.city_id,
                    latitude: storedObject.address.latitude,
                    longtitude: storedObject.address.longtitude
                },
                id: storedObject.id
            };

            //await this.getCoords(storedObject);
        },
        async getCoords(storedObject) {
            if (storedObject.address.latitude != null && storedObject.address.longtitude != null) {
                eventBus.$emit('update-address-object', [storedObject.address.latitude, storedObject.address.longtitude], storedObject.address);
                return;
            }

            if (storedObject.address.postIndex != null) {
                const country = storedObject.address.country.title || storedObject.address.country;
                const city = storedObject.address.city.title || storedObject.address.city;
                const address = encodeURI(`${country}+${city}+${storedObject.address.street}`);

                try {
                    const resp = await axios.get('/api/v1/get/coords', {params: {address}});
                    const coords = resp.data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ');

                    eventBus.$emit('update-address-object', [parseFloat(coords[1]), parseFloat(coords[0])], storedObject.address);
                } catch (error) {
                    console.error(error);
                }
            }
        },
        eventCreateObject() {
            localStorage.removeItem('object');
        },
        updateAddressField(address) {
            this.sportObject.address = address
        },
    },
    async created() {
        this.$emit("loading", true);

        eventBus.$on('create-object', this.eventCreateObject);
        eventBus.$on('update-address-field', this.updateAddressField);

        const fetchPromises = [
            this.$store.dispatch('fetchSportTypes').then(() => {
                this.sportTypes = this.getterSportTypes;
            }),
            this.$store.dispatch('fetchServices').then(() => {
                this.allServices = this.gettersServices;
            }),
            this.$store.dispatch('fetchAccomodationTypes'),
            this.$store.dispatch('fetchObjectTypes').then(list_objectTypes => {
                this.listData.list_objectTypes = list_objectTypes;
            })
        ];

        await Promise.all(fetchPromises);

        const objectId = this.$props.object?.id;
        const objectFromLocalStorage = JSON.parse(localStorage.getItem('object'));

        if (objectFromLocalStorage != null && Number(objectFromLocalStorage.id)
            === (this.$props.object ? Number(this.$props.object.id) : 0)) {
            await this.fillSportObject(objectFromLocalStorage);
        } else if (this.$props.object) {
            const timeout = this.$props.object ? 1000 : 0;
            await new Promise(resolve => setTimeout(resolve, timeout));
            this.editSportObject(this.$props.object);
        } else {
            this.sportObject.objectType = this.listData.list_objectTypes[0];
            this.sportObject.objectType_id = this.listData.list_objectTypes[0].id;
        }

        const imageFolder = objectId ? `/storage/listings/objects/${objectId}/` : '/storage/listings/objects/temp/';
        const imagesPromises = this.sportObject.storageImages.map(image => this.getImageBase64(imageFolder + image));
        this.filesPreview = await Promise.all(imagesPromises);

        if (this.$props.object != null) {
            const findObjectType = this.listData.list_objectTypes.find(item => item.title == this.sportObject.objectType);
            this.sportObject.objectType_id = findObjectType ? findObjectType.id : null;
            const filesPreviewPromises = this.sportObject.storageImages.map(async (image) => {
                const fullPath = `/storage/listings/objects/${this.$props.object.id}/${image}`;
                return await this.getImageBase64(fullPath);
            });
            this.filesPreview = await Promise.all(filesPreviewPromises);
        } else {
            const filesPreviewPromises = this.sportObject.storageImages.map(async (image) => {
                const fullPath = `/storage/listings/objects/temp/${image}`;
                return await this.getImageBase64(fullPath);
            });
            this.filesPreview = await Promise.all(filesPreviewPromises);
        }

        this.files = this.sportObject.images;
        this.countPhoto = this.sportObject.storageImages.length;

        this.$emit("loading", false);
    },

    name: "FirstStage",
    components: {
        StepperItem,
        TypeLivingPricing, CheckBoxGroup, AddressForm, CustomVueEditor, IncludedPricingForm, SbModal, VSelect
    }
}
</script>

<style>
.ql-editor.ql-blank::before {
    color: lightgrey !important;
    font-style: normal !important;
    font-weight: 100;
}

.ql-color-picker .ql-picker-options {
    z-index: 100000 !important;
}

.descriptionObject .textDescription > * {
    font-size: 17px;
}
</style>
<style scoped>
</style>
