<template>
    <div class="main-stage admin-first-stage">
        <div class="container pb-5">
            <div class="main-content__stage" v-if="sportObject">
                <div class="row mr-4 ml-4 ml-lg-0 mr-lg-0">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10 col-12 p-0">
                        <ValidationObserver v-slot="props" tag="form" ref="observer" @submit.prevent="onSave">
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
                                                           class="input-profile-info w-100"
                                                           placeholder="AquaLife Спортивно-гостиничный комплекс">
                                                    <span class="error-valid">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </label>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label class="w-100 caption select-wrapper mb-xl-2" for="category">
                                                Категория объекта <span style="color: rgb(243, 122, 138)">*</span>
                                                <v-select id="category" labelTitle="Выбрать" textProp="title"
                                                          valueProp="id" class="selectpicker" name="category"
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
                                                <label class="w-100 caption select-wrapper mb-xl-2" for="photo">
                                                    Фото объекта <span style="color: rgb(243, 122, 138)">*</span>
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
                                                    <img @click="openinput" class="img-responsive h-100 w-100"
                                                         :src="data" :alt="`img-${index}`" style="object-fit: cover">
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
                                            <div class="d-flex image-input image-input-tbd"
                                                 v-if="filesPreview.length < option.maxFileCount">
                                                <div class="image-preview blockImage d-flex justify-content-center
                                                    align-items-center position-relative" @click="openinput">
                                                    <div class="imgUpload"/>
                                                </div>
                                                <input type="file" ref="file" class="d-none" id="vue-file-upload-input"
                                                       @change="addImage" accept="image/jpeg, image/jpg, image/png">
                                            </div>
                                        </div>

                                        <div class="captionUploadPhoto pl-1 pt-1">
                                            <p class="label">Формат фотографий - не менее 500px по широкой
                                                и узкой стороне / jpg или png без alpha канала</p>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm-12 d-flex">
                                                <custom-vue-editor text-label="Описание объекта" class="w-100"
                                                                   @update:text="sportObject.description = $event"
                                                                   :max-length="maxDescriptionObject"
                                                                   :text="sportObject.description" :props="props"/>
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
                                    <h1 class="caption__title">Условия и цены</h1>
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
                                            data-target="#sb-type-living" class="btn button button-borderBlue">
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
                                              :title="tempInfrastructure.editId != null ? 'Редактировать объект инфраструктуры'
                                              : 'Добавить объект инфраструктуры'"
                                              modal_class="sb-infrastructure p-0" modal_title_class="text-xl-left">
                                        <template #body>
                                            <label class="w-100 caption mt-3" for="nameObject">Название объекта
                                                <input type="text" name="search-object" autocomplete="off"
                                                       v-model="tempInfrastructure.title" id="nameObject"
                                                       placeholder="Тренажерный зал"
                                                       class="input-profile-info w-100">
                                            </label>
                                            <div class="uploadImage">
                                                <label class="caption">Фото объекта</label>
                                                <div class="d-flex flex-lg-nowrap flex-wrap">
                                                    <div class="block__upload mb-2 mb-lg-0">
                                                        <div class="block__upload-image"
                                                             style="width: 110px;height: 110px;">
                                                            <div style="overflow: hidden"
                                                                 class="block__rectangle d-flex justify-content-center">
                                                                <img class="img__upload"
                                                                     v-if="!tempInfrastructure.imageSrc"
                                                                     style="width: 30px;"
                                                                     src="/icons/settings/file-upload.svg" alt="">
                                                                <img alt="" v-show="tempInfrastructure.imageSrc"
                                                                     :src="tempInfrastructure.imageSrc"
                                                                     class="img__upload Image-input__image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="file" accept="image/jpeg, image/jpg, image/png"
                                                           class="d-none" id="vue-file-upload-inp"
                                                           @change="addImageInfrastructure">
                                                    <div class="text d-flex flex-wrap">
                                                        <div @click="openinputInfrastructure"
                                                             class="align-items-center d-flex form-control justify-content-center ml-0 ml-lg-3 text-upload w-50">
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
                                                     v-for="(item, index) in tempInfrastructure.options">
                                                    <img v-if="item.title !== '' && index > 0" class="position-absolute"
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
                                                                   class="input-price-info h-100 w-100">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 p-0 m-0 buttonOption">
                                                    <button type="button" @click="addObjectOptionsInfra"
                                                            class="btn">Добавить опцию +
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                        <template #footer>
                                            <div class="justify-content-center d-flex pt-3">
                                                <button type="button" @click="saveInfrastructure" data-dismiss="modal"
                                                        class="btn btn-success justify-content-center">
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
                                                <label class="caption pb-lg-3">Инфраструктура
                                                    <span class="text-muted font-weight-normal">
                                                        {{ sportObject.pricing.infrastructures.length }}/100
                                                        <span class="error-valid">{{ errors[0] }}</span>
                                                    </span>
                                                </label>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                    <div class="buttonOption pb-4 col-12 col-sm-12 d-flex d-xl-flex
                                                justify-content-center justify-content-xl-start">
                                        <button data-toggle="modal" data-target="#sb-infrastructure" type="button"
                                                @click="clearInfrastructureModal" class="btn">
                                            Добавить опцию +
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="blockInfrastructure col-12 col-sm-12 col-md-4"
                                             v-for="(item, index) in sportObject.pricing.infrastructures"
                                             v-if="item.title !== '' ">
                                            <div class="infrastruct el wrapper shadow bg-white borderblock mb-3">
                                                <div
                                                    class="bg-gray-900 block__title d-flex justify-content-end pl-4 pr-4 pt-3 pb-3">
                                                    <a data-toggle="modal" data-target="#sb-infrastructure"
                                                       @click.prevent="editInfrastructure(index)" class="pr-2" href="#">
                                                    <span
                                                        class="align-items-lg-center btnAction d-flex justify-content-center">
                                                        <img src="/icons/stages/edit.svg" alt="edit">
                                                    </span>
                                                    </a>
                                                    <a @click.prevent="deleteInfrastructure(index)">
                                                        <span
                                                            class="align-items-lg-center btnAction d-flex justify-content-center">
                                                            <img src="/icons/stages/cancel.svg" alt="del">
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="ul__list_objects">
                                                    <img
                                                        :src="item.image && item.image != '/storage/listings/infrastruct/null' ? item.image : '/images/no-photo.png'"
                                                        alt="Image" style="object-fit: cover;"
                                                        class="el__img w-100">
                                                    <p class="el__title p-4 mb-0">{{ item.title }}</p>
                                                    <ul class="list-overflow mx-2 pb-4"
                                                        :class="{'h-auto': infrastructure_detail}">
                                                        <li v-for="option in item.options"
                                                            v-if="option.title !== ''">
                                                            <p class="fs-6 opacity-7 mb-0">
                                                                {{ option.title }}</p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div v-if="item.options.length > 4"
                                                     class="justify-content-center align-items-lg-center d-flex">
                                                    <button type="button"
                                                            @click="!infrastructure_detail ? infrastructure_detail = true : infrastructure_detail = false"
                                                            class="btn btn-behance btnViewFull justify-content-between">
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
                                    <address-form v-if="sportObject" :show-input="true" :title-block="'АДРЕС ОБЪЕКТА'"
                                                  default-class="" :map-height="500"
                                                  :coords="[sportObject.address.latitude, sportObject.address.longtitude]"
                                                  @update-address="sportObject.address = $event"
                                                  :address-prop="sportObject.address"/>
                                </div>
                            </div>
                            <div class="col-sm-12 d-flex pt-4 pb-4">
                                <div class="text-center mx-auto">
                                    <button type="submit" class="btn btn-success justify-content-center">
                                        Сохранить
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

import {extend} from 'vee-validate';
import SbModal from "./SbModal";
import IncludedPricingForm from "./IncludedPricingForm";
import CustomVueEditor from "./CustomVueEditor";
import eventBus from "../../event-bus";
import AddressForm from "../../components/AddressForm";
import TypeLivingPricing from "../../components/addObject/TypeLivingPricing";
import CheckBoxGroup from "../../components/addObject/CheckBoxGroup";

extend('photosCount', {
    validate: (value => {
        return value > 0;
    }),
    message: 'Не добавлено ни одного фото'
});
extend('accommodationsCount', {
    validate: (value => {
        return value > 0;
    }),
    message: 'Не добавлено ни одного типа проживания'
});
extend('infrastructuresCount', {
    validate: (value => {
        return value > 0;
    }),
    message: 'Не добавлено ни одной инфраструктуры'
});

export default {
    props: {
        getObject: {
            type: [Object, Array],
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
                address: {
                    country: null,
                    region: null,
                    city: null,
                    postIndex: null,
                    street: null,
                    city_id: null,
                    latitude: null,
                    longtitude: null
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
            // Количество объектов
            countObject: 0,

            tempInfrastructure: {
                isEdit: false,
                editId: null,
                id: null,
                title: '',
                image: '',
                imageSrc: '',
                options: [],
            },
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
            allServices: [],
            tempObject: null
        }
    },
    watch: {
        sportObject: {
            async handler(sportObject) {
                if (sportObject.title !== "") {
                    this.setStoreSportObject({
                        object: this.sportObject,
                        edit: this.isEditObject,
                        title: 'admin-object'
                    });
                }
                if (sportObject.objectType == null) {
                    this.sportObject.objectType = this.listData.list_objectTypes[0];
                }
            },
            deep: true
        },
        '$props.getObject': {
            async handler(sportObject) {
                this.$emit("loading", true);
                const objectId = this.$props.getObject?.id;
                const objectFromLocalStorage = JSON.parse(localStorage.getItem('admin-object'));

                if (objectFromLocalStorage != null && Number(objectFromLocalStorage.id)
                    === (this.$props.getObject ? Number(this.$props.getObject.id) : 0)) {
                    await this.fillSportObject(objectFromLocalStorage);
                } else if (this.$props.getObject) {
                    this.editSportObject(this.$props.getObject);
                } else {
                    this.sportObject.objectType = this.listData.list_objectTypes[0];
                    this.sportObject.objectType_id = this.listData.list_objectTypes[0].id;
                }

                const imageFolder = objectId ? `/storage/listings/objects/${objectId}/` : '/storage/listings/objects/temp/';
                const imagesPromises = this.sportObject.storageImages.map(image => this.getImageBase64(imageFolder + image));
                this.filesPreview = await Promise.all(imagesPromises);

                if (this.$props.getObject != null) {
                    const findObjectType = this.listData.list_objectTypes.find(item => item.title == this.sportObject.objectType);
                    this.sportObject.objectType_id = findObjectType ? findObjectType.id : null;
                    const filesPreviewPromises = this.sportObject.storageImages.map(async (image) => {
                        const fullPath = `/storage/listings/objects/${this.$props.getObject.id}/${image}`;
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
            let object_id = this.$props.getObject?.id ?? null;

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
                if (this.tempInfrastructure.options[this.nextIdOptions].title !== '') {
                    this.tempInfrastructure.options.push({
                        id: this.nextIdOptions,
                        title: this.tempInfrastructure.options[this.nextIdOptions].title
                    });
                    this.countOptions++;
                    this.nextIdOptions++;
                    this.tempInfrastructure.options[this.nextIdOptions].title = '';
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
                this.tempInfrastructure.image = response.data;
            })
        },
        addImageInfrastructure: function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const supportedFormats = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                const file = input.files[0];

                if (supportedFormats.includes(file.type)) {
                    const reader = new FileReader();
                    const vm = this;

                    reader.onload = async function (e) {
                        const img = new Image();
                        img.src = e.target.result;
                        img.onload = async function () {
                            if (img.width <= 250 || img.height <= 250) {
                                alert("Изображение должно быть не менее 250x250 пикселей");
                                return;
                            }
                            try {
                                vm.tempInfrastructure.imageSrc = e.target.result;
                            } catch (error) {
                                console.log(error);
                            }
                        };
                    };
                    reader.readAsDataURL(file);
                    this.uploadImageInfrastruct(input.files[0]);
                } else {
                    alert("Неподдерживаемый формат изображения. Пожалуйста, выберите изображение в формате jpg, jpeg, png или gif.");
                }
            }
        },
        saveInfrastructure() {
            const {tempInfrastructure} = this;
            const {pricing} = this.sportObject;

            if (tempInfrastructure.isEdit) {
                const infrastructure = {
                    id: this.tempInfrastructure.id,
                    title: tempInfrastructure.title,
                    image: tempInfrastructure.imageSrc,
                    imageInfr: tempInfrastructure.imageInfr != "" ? tempInfrastructure.imageInfr : tempInfrastructure.image,
                    options: tempInfrastructure.options
                };

                const newInfrastructures = [...pricing.infrastructures];
                newInfrastructures[tempInfrastructure.editId] = infrastructure;

                this.$set(this.sportObject.pricing, 'infrastructures', newInfrastructures);
            } else if (tempInfrastructure.title !== '') {
                const infrastructure = {
                    id: null,
                    title: tempInfrastructure.title,
                    image: tempInfrastructure.imageSrc,
                    imageInfr: tempInfrastructure.image,
                    options: tempInfrastructure.options
                };

                this.sportObject.pricing.infrastructures = [...pricing.infrastructures, infrastructure];
            }
            this.clearInfrastructureModal();
            $('#sb-infrastructure').modal('hide');
        },
        editInfrastructure(index) {
            const {pricing} = this.sportObject;
            const infrastructure = pricing.infrastructures[index];
            this.tempInfrastructure.editId = index;
            this.tempInfrastructure.id = infrastructure.id;
            this.tempInfrastructure.title = infrastructure.title;
            this.tempInfrastructure.imageSrc = infrastructure.image;
            this.tempInfrastructure.imageInfr = infrastructure.imageInfr;
            this.tempInfrastructure.options = infrastructure.options;
            this.setEditingInfrastructureState();
        },
        setEditingInfrastructureState() {
            if (this.tempInfrastructure.options.length === 0) {
                this.tempInfrastructure.options.push({id: 0, title: ''});

                this.countOptions = 0;
                this.nextIdOptions = 1;
                this.tempInfrastructure.isEdit = true;
                return;
            }
            if (this.tempInfrastructure.options[this.tempInfrastructure.options.length - 1].title !== '') {
                this.tempInfrastructure.options.push({id: 0, title: ''});
            }
            this.countOptions = this.tempInfrastructure.options.length - 1;
            this.nextIdOptions = this.tempInfrastructure.options.length - 1;
            this.tempInfrastructure.isEdit = true;
        },
        deleteInfrastructure(index) {
            this.$delete(this.sportObject.pricing.infrastructures, index);
        },
        deleteOptionsInfrastruct(index) {
            if (this.countOptions > 0) {
                this.$delete(this.tempInfrastructure.options, index)
                this.countOptions--;
                this.nextIdOptions--;
            }
        },
        clearInfrastructureModal() {
            this.tempInfrastructure.title = '';
            this.tempInfrastructure.imageSrc = '';
            this.tempInfrastructure.options = [];
            this.tempInfrastructure.options.push({
                id: 0,
                title: ''
            });
            this.countOptions = 0;
            this.nextIdOptions = 0;
            this.tempInfrastructure.editId = null;
        },
        openinputInfrastructure: function () {
            document.getElementById("vue-file-upload-inp").click();
        },
        getCategoryId(category) {
            if (category == 'undefined') {
                console.log('undefined')
            } else this.sportObject.objectType_id = category.id;
        },
        async editSportObject(sportObject) {
            const {
                id, title, objectType_title, images, services, sports, description, accommodations,
                accomodationConditionAndPricing_id, accomodationConditionAndPricing_included,
                accomodationConditionAndPricing_included_id, city_id, country, region, city, postIndex, address,
                advertisements, latitude, longtitude
            } = sportObject;

            const newImages = images.map(image => `/storage/listings/objects/${this.$props.getObject.id}/${image}`);
            const newServices = services.map(service => service.id);
            const newSports = sports.map(sport => sport.id);
            const newInfrastructures = sportObject.infrastructures.map(({infrastructure_id, title, image, options}) =>
                ({
                    id: infrastructure_id,
                    title,
                    image: image == null ? null : `/storage/listings/infrastruct/${image}`,
                    imageInfr: image,
                    options
                })
            );

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
                    idAccType: accommodation.accomodationType_id,
                    title: accommodation.accomodationType_title,
                    description: accommodation.description,
                    price: accommodation.pricing
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
            eventBus.$emit('admin-address-object',
                [this.sportObject.address.latitude, this.sportObject.address.longtitude], this.sportObject.address)

            const objectId = this.$props.getObject?.id;

            const imageFolder = objectId ? `/storage/listings/objects/${objectId}/` : '/storage/listings/objects/temp/';
            const tempImages = this.sportObject.storageImages.map(image => this.getImageBase64(imageFolder + image));
            this.filesPreview = await Promise.all(tempImages);

            this.files = this.sportObject.images;
            this.countPhoto = this.sportObject.storageImages.length;

            this.countObject += accommodations.length;
            this.nextIdIncludedPrice++;
            this.tempInfrastructure.id += sportObject.infrastructures.length;
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

            eventBus.$emit('admin-address-object',
                [this.sportObject.address.latitude, this.sportObject.address.longtitude], this.sportObject.address)
        },
        updateAddressField(address) {
            this.sportObject.address = address
        },
        async onSave() {
            try {
                this.$emit("loading", true);
                await this.$store.dispatch("setAdminSportObject", this.sportObject);
                localStorage.removeItem('admin-object');
                window.location.href = `/admin/sport-objects/show/${this.sportObject.id}`;
            } catch (error) {
                console.error("Ошибка при сохранении спортивного объекта:", error);
                this.$emit("loading", false);
                alert("Произошла ошибка при сохранении. Пожалуйста, попробуйте снова.");
            }
        },
    },
    async created() {
        this.$emit("loading", true);
        eventBus.$on('update-address-field', this.updateAddressField);

        try {
            await Promise.all([
                this.$store.dispatch('fetchSportTypes').then(() => {
                    this.sportTypes = this.getterSportTypes;
                }),
                this.$store.dispatch('fetchServices').then(() => {
                    this.allServices = this.gettersServices;
                }),
                this.$store.dispatch('fetchAccomodationTypes').then(accomodationTypes => {
                    this.accomodationTypes = accomodationTypes;
                }),
                this.$store.dispatch('fetchObjectTypes').then(list_objectTypes => {
                    this.listData.list_objectTypes = list_objectTypes;
                })
            ]);

        } catch (error) {
            console.error('Ошибка загрузки данных:', error);
        } finally {
            this.$emit("loading", false);
        }
    },

    name: "FirstStage",
    components: {TypeLivingPricing, CheckBoxGroup, AddressForm, CustomVueEditor, IncludedPricingForm, SbModal, VSelect}
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

.v-select-toggle {
    height: 50px !important;
}

.ql-container.ql-snow {
    height: 200px;
}

.remove-image {
    width: 29px;
    height: 27px;
    top: 5px;
    background-color: white;
    border-radius: 3px;
    right: 30px;
    cursor: pointer;
}

.image-preview {
    width: 96px;
    height: 96px;
    cursor: pointer;
    overflow: hidden;
}

.image-preview .imgUpload {
    width: 50px;
    height: 50px;
    background: url("/icons/stages/file-upload.svg") no-repeat;
    background-position: center;
}

.image-preview:hover .imgUpload {
    background-image: url("/icons/stages/file-upload-blue.svg");
}

.image-preview .remove-image {
    width: 29px;
    height: 27px;
    top: 5px;
    right: 5px;
    background-color: white;
    border-radius: 3px;
}

.image-preview button {
    position: absolute;
    top: 45px;
    background-color: white;
    border-radius: 5px;
    width: 30px;
}

.block__upload {
    display: flex;
}

.block__upload .block__upload-image .block__rectangle {
    border: 1px solid #BAC4DF;
    border-radius: 10px;
    height: 110px;
    width: 110px
}

.block__upload .block__rectangle .img__upload {
    display: block;
    top: 41%;
    left: 12%;
}

.error-valid {
    color: rgb(243, 122, 138);
}

.admin-first-stage .priceMax, .admin-first-stage .priceMin {
    color: black !important;
}
</style>
<style scoped>
</style>
