<template>
    <main class="container-fluid">
        <ValidationObserver v-slot="props" tag="form" ref="observer" @submit.prevent="onSave">
            <div class="row">
                <div class="col-lg-6">
                    <div class="block__profile-main_info pt-4">
                        <h4 class="caption text-success">Основная информация</h4>
                        <div class="row about__company">
                            <div class="col-lg-4">
                                <label class="w-100 caption">Логотип компании
                                    <div class="block__upload" style="grid-gap: 15px;">
                                        <div class="block__upload-image d-flex justify-content-center"
                                             style="width: 180px;height: 110px; cursor: pointer">
                                            <img :src="imageSrc.logo || '/icons/stages/file-upload.svg'"
                                                 :class="{'object-fit-cover': imageSrc.logo}"
                                                 style="border-radius: 10px" class="h-100 p-4" alt="upload">
                                        </div>
                                        <input ref="logoExecutor" type="file" class="d-none"
                                               accept="image/jpeg, image/jpg, image/png"
                                               @change="addImage($event, '/admin/settings/uploadLogo', 'logo')">

                                        <p class="caption__logo">Высота и ширина должны быть не менее 250х250 пикс.</p>
                                    </div>
                                </label>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ValidationProvider rules="required" vid="title" v-slot="{ errors, failed }">
                                            <div class="name-wrapper w-100 my-2 me-3 mb-xl-2">
                                                <label class="w-100 caption">Название компании
                                                    <span style="color: rgb(243, 122, 138)">*</span>
                                                    <span class="float-right text-muted font-weight-normal">
                                                    <!--{{ infoCompanyDetail.title.length }} /100!-->
                                                        </span>
                                                    <input :maxlength="maxNameCompany" type="text" autocomplete="off"
                                                           :class="{ 'is-invalid': failed }"
                                                           v-model="settingsModel.title"
                                                           placeholder="ПромТехИнвест" class="input-profile-info w-100">
                                                </label>
                                                <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                            </div>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="w-100 caption">Номер телефона
                                            <div class="row">
                                                <div class="row p-0 m-0" v-for="phone in settingsModel.phones">
                                                    <div class="col-4 col-employees-wrapper select-wrapper mb-xl-2">
                                                        <label class="w-100 caption select-wrapper mb-xl-2"
                                                               for="phoneComp">
                                                            <v-select id="phoneComp" labelTitle="+7"
                                                                      v-model="phone.code"
                                                                      class="selectpicker" :options="codePhone">
                                                            </v-select>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-8">
                                                        <input type="text" name="phoneCompany"
                                                               v-model="phone.phone" maxlength="10"
                                                               placeholder="900 000 00 00" autocomplete="off"
                                                               class="input-profile-info w-100">
                                                    </div>
                                                </div>

                                                <div class="col-4 d-none d-lg-block"></div>
                                                <div class="col-lg-8 col-8 d-none d-lg-block">
                                                    <a class="pl-4" href="#" @click.prevent="addOncePhone"
                                                       style="color: #6283E5; font-weight: normal; font-size: calc(1.125rem)">
                                                        Добавить еще +
                                                    </a>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <ValidationProvider rules="required" v-slot="{errors}" vid="email">
                                            <label class="w-100 caption">Email адрес (компании)
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <span class="error-valid"
                                                      v-show="hasError">неверный формат записи</span>
                                                <input type="text" v-model="settingsModel.email"
                                                       :class="[isEmailValid()]" placeholder="mail@mail.com"
                                                       class="input-profile-info w-100">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="w-100 caption">Адрес сайта
                                            <input type="text" placeholder="www.sitename.com"
                                                   class="input-profile-info w-100" v-model="settingsModel.site">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row about__company">
                            <div class="col-lg-12 h-100">
                                <custom-vue-editor :max-length="maxDescriptionCompany" :props="props"
                                                   @update:text="settingsModel.description = $event"
                                                   :text="settingsModel.description"
                                                   text-label="Описание компании"/>
                            </div>
                        </div>
                        <div class="block__address-main pt-4">
                            <h5 class="caption text-success">Адрес компании</h5>
                            <div class="addAddressButton d-flex pb-2">
                                <button type="button" class="btn btn-behance mr-2">
                                    Фактический
                                </button>
                                <button type="button" class="btn btn-secondary">
                                    Юридический
                                </button>
                            </div>
                            <div v-if="false" class="infoAboutAddress">
                                <div class="row">
                                    <div class="col-lg-6 ">
                                        <label class="w-100 caption select-wrapper mb-xl-2">Страна
                                            <v-select labelTitle="Выбрать" class="selectpicker"
                                                      v-model="infoCompanyDetail.country"
                                                      :options="allCountries"
                                                      textProp="title" valueProp="id">
                                            </v-select>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 ">
                                        <ValidationProvider v-slot="{errors, failed}"
                                                            :rules="infoCompanyDetail.country != null ? 'required': ''">
                                            <label class="w-100 caption select-wrapper mb-xl-2">Область,
                                                округ, провинция
                                                <span v-if="infoCompanyDetail.country != null"
                                                      style="color: rgb(243, 122, 138)">*</span>
                                                <v-select id="region" valueProp="id" class="selectpicker"
                                                          :class="{'is-invalid': failed}" textProp="title"
                                                          v-model="infoCompanyDetail.region"
                                                          labelTitle="Выбрать"
                                                          :options="regionsWithCountry">
                                                </v-select>
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                    <div class="col-lg-6">
                                        <ValidationProvider v-slot="{errors, failed}"
                                                            :rules="infoCompanyDetail.country != null ? 'required': ''">
                                            <label class="w-100 caption select-wrapper mb-xl-2">Город
                                                (населенный пункт)
                                                <span v-if="infoCompanyDetail.country != null"
                                                      style="color: rgb(243, 122, 138)">*</span>
                                                <v-select id="city" textProp="title" valueProp="id"
                                                          :class="{'is-invalid': failed}"
                                                          labelTitle="Выбрать" v-model="infoCompanyDetail.city"
                                                          class="selectpicker" @input="getCity_id"
                                                          :options="citiesWithRegion(region_id)">
                                                </v-select>
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                    <div class="col-lg-6">
                                        <ValidationProvider v-slot="{ failed, errors }"
                                                            :rules="infoCompanyDetail.country != null ? 'required|numeric|max:6|min:6|': ''">
                                            <label class="w-100 caption mt-lg-3">Почтовый индекс
                                                <span v-if="infoCompanyDetail.country != null"
                                                      style="color: rgb(243, 122, 138)">*</span>
                                                <input type="text" v-model="infoCompanyDetail.postIndex"
                                                       :class="{ 'is-invalid': failed }"
                                                       placeholder="000 000" class="input-profile-info"
                                                       autocomplete="off" pattern="^([0-9]+)$"
                                                       maxlength="6" minlength="6">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                    <div class="col-lg-12">
                                        <ValidationProvider v-slot="{ failed, errors }"
                                                            :rules="infoCompanyDetail.country != null ? 'max:200|required': ''">
                                            <label class="w-100 caption">Улица, номер дома и офиса
                                                <span v-if="infoCompanyDetail.country != null"
                                                      style="color: rgb(243, 122, 138)">*</span>
                                                <input :class="{ 'is-invalid': failed }" type="text"
                                                       v-model="infoCompanyDetail.address"
                                                       placeholder="Введите имя улицы, номер дома и офиса"
                                                       class="input-profile-info" autocomplete="off"
                                                       :disabled="infoCompanyDetail.country == null">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                            </div>
                            <div class="mapAddress pt-3" style="height: 600px">
                                <yandex-map @click="showLocation" style="height:100%" :coords="center"
                                            :zoom="17" :settings="settings">
                                    <ymap-marker v-model="marker"
                                                 marker-type="placemark"
                                                 :coords="coords"
                                                 :markerId="1"
                                                 :icon="{color: 'green', glyph: 'bicycle'}"
                                                 :options="{draggable:true, iconShadow:true, iconShadowImageOffset:[2,-20],
                                                    iconShadowImageSize: [29, 7]}"/>
                                </yandex-map>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="pt-4">
                        <main class="details_payment">
                            <div class="pb-2 pl-lg-4 pr-lg-4">
                                <div class="title__block font-weight-bold mt-4">
                                    <h4 class="text-success">Платежные реквизиты</h4>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ValidationProvider rules="required" v-slot="{ errors, failed }">
                                            <label class="caption w-100">Юридическое наименование
                                                <span style="color: rgb(243, 122, 138)">*</span>

                                                <span class="d-flex">
                                                <v-select labelTitle="Выбрать" v-model="settingsModel.ur_pre"
                                                          class="w-auto selectpicker select-wrapper mr-3"
                                                          :options="urName"
                                                ></v-select>
                                                <input type="text" v-model="settingsModel.ur_title"
                                                       name="search-object" placeholder="ПромТехИнвест"
                                                       class="input-profile-info w-100" required
                                                       :class="{ 'is-invalid': failed }"
                                                       autocomplete="off" maxlength="13">
                                                </span>
                                            </label>
                                        </ValidationProvider>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <ValidationProvider rules="required|numeric|max:13"
                                                            v-slot="{ errors, failed }">
                                            <label class="w-100 caption">ИНН
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <input v-model="settingsModel.tin" type="text"
                                                       name="search-object" placeholder="Введите ИНН"
                                                       class="input-profile-info w-100" required
                                                       :class="{ 'is-invalid': failed }"
                                                       autocomplete="off" maxlength="13">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ValidationProvider rules="required|numeric|max:9"
                                                            v-slot="{ errors, failed }">
                                            <label class="w-100 caption">КПП
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <input v-model="settingsModel.numKpp" type="text"
                                                       name="search-object" placeholder="Введите КПП"
                                                       class="input-profile-info w-100" required
                                                       :class="{ 'is-invalid': failed }"
                                                       autocomplete="off" maxlength="9">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ValidationProvider rules="required|numeric|max:9"
                                                            v-slot="{ errors, failed }">
                                            <label class="w-100 caption">БИК
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <input v-model="settingsModel.bic" type="text"
                                                       name="search-object" placeholder="Введите БИК"
                                                       class="input-profile-info w-100" required
                                                       :class="{ 'is-invalid': failed }"
                                                       autocomplete="off" maxlength="9">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ValidationProvider v-slot="{errors, failed}" rules="required">
                                            <label class="w-100 caption">Банковские реквизиты
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <input v-model="settingsModel.requisites" type="text"
                                                       name="search-object" required
                                                       :class="{'is-invalid': failed}"
                                                       placeholder="1234 5678 9102 3456    в Московский банк ПАО Сбербанк г.Москва"
                                                       class="input-profile-info w-100" autocomplete="off">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ValidationProvider rules="required|numeric|max:20"
                                                            v-slot="{ errors, failed }">
                                            <label class="w-100 caption">К/С
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <input v-model="settingsModel.kc" type="text" name="search-object"
                                                       required :class="{ 'is-invalid': failed }"
                                                       placeholder="Введите К/С" class="input-profile-info w-100"
                                                       autocomplete="off" maxlength="20">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ValidationProvider rules="required|numeric|max:10"
                                                            v-slot="{ errors, failed }">
                                            <label class="w-100 caption">ОКПО
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <input v-model="settingsModel.okpo" type="text" name="search-object"
                                                       required :class="{ 'is-invalid': failed }"
                                                       placeholder="Введите ОКПО" class="input-profile-info w-100"
                                                       autocomplete="off" maxlength="10">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ValidationProvider rules="required|numeric|max:11"
                                                            v-slot="{ errors, failed }">
                                            <label class="w-100 caption">ОКАТО
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <input v-model="settingsModel.okato" type="text" name="search-object"
                                                       :class="{ 'is-invalid': failed }" placeholder="Введите ОКАТО"
                                                       class="input-profile-info w-100" autocomplete="off"
                                                       maxlength="11">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ValidationProvider rules="required|numeric|max:13"
                                                            v-slot="{ errors, failed }">
                                            <label class="w-100 caption">ОГРН
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <input v-model="settingsModel.ogrn" type="text"
                                                       name="search-object" :class="{ 'is-invalid': failed }"
                                                       placeholder="Введите ОГРН" class="input-profile-info w-100"
                                                       autocomplete="off" maxlength="13">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="title__block font-weight-bold mt-4">
                                    <h4 class="text-success">Печать и подпись</h4>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-4"><h5 class="font-weight-bold">Печать компании</h5></div>
                                    <div class="col-lg-8">
                                        <div class="block__upload">
                                            <div class="block__upload-image d-flex justify-content-center"
                                                 style="width: 150px; height: 150px;">
                                                <img :src="imageSrc.print || '/icons/stages/file-upload.svg'"
                                                     :class="{'object-fit-cover': imageSrc.print}"
                                                     style="border-radius: 10px" class="w-100 h-100 p-4" alt="upload">
                                            </div>
                                            <input ref="print" type="file" class="d-none"
                                                   accept="image/jpeg, image/jpg, image/png"
                                                   @change="addImage($event, '/admin/settings/uploadPrint', 'print')">
                                            <div class="d-flex flex-wrap flex-column">
                                                <button @click="$refs.print.click()" type="button"
                                                        class="btn btn-outline-success">Заменить
                                                </button>
                                                <p class="caption__logo"><i>Высота и ширина должны
                                                    быть не менее 250х250 пикс.</i></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4"><h5 class="font-weight-bold">Подпись директора</h5></div>
                                    <div class="col-lg-8">
                                        <div class="block__upload">
                                            <div class="block__upload-image d-flex justify-content-center"
                                                 style="width: 150px; height: 150px;">
                                                <img :src="imageSrc.signature || '/icons/stages/file-upload.svg'"
                                                     style="border-radius: 10px" class="w-100 h-100 p-4"
                                                     :class="{'object-fit-cover': imageSrc.signature}" alt="upload">
                                            </div>
                                            <input ref="signature" type="file" class="d-none"
                                                   accept="image/jpeg, image/jpg, image/png"
                                                   @change="addImage($event, '/admin/settings/uploadSignature', 'signature')">
                                            <div class="d-flex flex-wrap flex-column">
                                                <button @click="$refs.signature.click()" type="button"
                                                        class="btn btn-outline-success">Заменить
                                                </button>
                                                <p class="caption__logo"><i>Высота и ширина должны
                                                    быть не менее 250х250 пикс.</i></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-behance mb-4 d-block">Сохранить
                </button>
            </div>
        </ValidationObserver>
    </main>
</template>

<script>
import VSelect from "@alfsnd/vue-bootstrap-select";
import CustomVueEditor from "../components/elements/CustomVueEditor";
import {yandexMap, ymapMarker} from 'vue-yandex-maps';
import axios from "axios";

export default {
    name: "PaymentDetails",
    components: {CustomVueEditor, VSelect, yandexMap, ymapMarker},
    data() {
        return {
            settingsModel: {
                title: null, phones: [], email: null, site: null, description: "", ur_name: null,
                ur_pre: null, ur_title: null, tin: null, numKpp: null, bic: null,
                requisites: null, kc: null, okpo: null, okato: null, ogrn: null, logo: null, print: null,
                signature: null, fact_address_id: null, ur_address_id: null
            },
            urName: ["ООО", "ОАО", "ЗАО"],
            infoCompanyDetail: {
                title: null, emailCompany: null, descriptionCompany: '<p style="color: #0B3158"></p>',
                imageUpload: null, imagePrint: null, imageSignature: null, site: null, phonesCompany: [],
            },
            phonesSave: [],
            codePhone: [{id: 1, text: "+7"}, {id: 2, text: "+8"}],
            hasError: false,
            regEmail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            maxNameCompany: 100, maxDescriptionCompany: 2000,
            marker: [53.235963, 34.353203], coords: [53.235963, 34.353203], center: [53.235963, 34.353203],
            imageSrc: {logo: null, signature: null, print: null},
            settings: this.$apiSettings.yandexMap,
        }
    },
    computed: {
        legal() {
            return this.urName.filter(item => item.text === this.settingsModel.ur_pre)[0];
        },
    },
    methods: {
        async getSettings() {
            try {
                const response = await axios.get("/admin/settings");
                const settings = response.data.settings;

                if (settings) {
                    this.settingsModel = settings;
                    this.imageSrc = {
                        logo: settings.logo ? `/storage/settings/${settings.logo}` : null,
                        print: settings.print ? `/storage/settings/${settings.print}` : null,
                        signature: settings.signature ? `/storage/settings/${settings.signature}` : null,
                    };
                }
            } catch (error) {
                console.error("Ошибка при загрузке настроек:", error);
            }
        },
        getLegal_text(legal) {
            this.settingsModel.ur_pre = legal;
        },
        addOncePhone() {
            this.settingsModel.phones.push({code: '+7', phone: ''});
        },
        isEmailValid: function () {
            const emailTrue = this.regEmail.test(this.settingsModel.email);
            this.hasError = !emailTrue;
            return emailTrue ? 'has-success' : 'has-error';
        },
        showLocation: function (e) {
            this.coords = e.get('coords');
            this.center = this.coords;
            this.getGeocode();
        },
        getGeocode() {

        },
        uploadImage(image, uploadPath, imageType) {
            let formData = new FormData();
            formData.append('file', image);
            let fileName;
            if (imageType === 'logo') {
                fileName = "logo." + image.name.split('.')[1];
                this.settingsModel.logo = fileName;
            } else if (imageType === 'print') {
                fileName = "print." + image.name.split('.')[1];
                this.settingsModel.print = fileName;
            } else if (imageType === 'signature') {
                fileName = "signature." + image.name.split('.')[1];
                this.settingsModel.signature = fileName;
            }

            axios.post(uploadPath, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).catch(error => {
                console.log(error);
            });
        },

        addImage: async function (event, uploadPath, imageType) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const vm = this;
                reader.onload = async function (e) {
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = async function () {
                        if (img.width < 250 || img.height < 250) {
                            alert("Изображение должно быть не менее 250x250 пикселей");
                            return;
                        }
                        vm.imageSrc[imageType] = e.target.result;

                        try {
                            await vm.uploadImage(input.files[0], uploadPath, imageType);
                        } catch (error) {
                            console.log(error);
                        }
                    };
                };
                reader.readAsDataURL(input.files[0]);
            }
        },

        async onSave() {
            const validationSuccess = await this.$refs.observer.validate();
            if (!validationSuccess) {
                setTimeout(() => {
                    const errors = Object.entries(this.$refs.observer.errors)
                        .map(([key, value]) => ({key, value}))
                        .filter(error => error["value"].length);
                    this.$refs.observer.refs[errors[0]["key"]].$el.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });
                }, 100);
                return;
            } else {
                axios.post("/admin/settings/save", this.settingsModel)
                    .catch(error => {
                        console.log(error);
                    }).then(() => {
                        window.location.reload();
                })
            }
        }
    },
    mounted() {
        this.addOncePhone();
        this.getSettings();
    }
}
</script>

<style scoped>
.block__upload {
    border: 1px solid lightgrey;
    padding: 10px;
}

.object-fit-cover {
    object-fit: cover;
}
</style>
