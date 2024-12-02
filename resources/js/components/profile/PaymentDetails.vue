<template>
    <div>
        <div class="align-items-center d-flex justify-content-center loading position-fixed" v-if="loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <menu-component-customer v-if="user.role==2" active="6"></menu-component-customer>
        <menu-component-executor v-if="user.role==3" active="6"></menu-component-executor>

        <nav class="navbar navbar-expand-xl navbar-light pt-1 pb-0 menuAuthCompany Mobile d-lg-none">
            <div class="profile_user_background">
                <div class="container">
                    <ul class="navbar-nav nav navbar-collapse d-lg-none profile__user">
                        <li v-on:click.prevent="showOrHideMenu"
                            class="nav-item mx-auto d-flex" style="margin-left: 0 !important; cursor: pointer">
                            <a class="nav-link text-white">
                                <img class="img__icon-settings" src="/icons/settings/real-estateWhite.svg"
                                     alt="">
                                Платежные реквизиты</a>
                            <img class="arrowDown" src="/icons/selectArowWhite.svg" alt="arrow">
                        </li>
                    </ul>
                    <div class="profileAction navbar-collapse nav navbar-nav" style="width: 100%;" v-if="showProfile">
                        <li v-bind:class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a href="/profile/settings"
                               class="nav-link text-white userIcon">
                                <img class="img__icon-settings" style="width: 20px"
                                     src="/icons/settings/userWhite.svg"
                                     alt="">
                                Профиль пользователя</a>
                        <li v-bind:class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/profile/notification">
                                <img class="img__icon-settings" src="/icons/settings/notificationWhite.svg"
                                     alt="">
                                Оповещания</a>
                        </li>
                        <li v-bind:class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/profile/security">
                                <img class="img__icon-settings" src="/icons/settings/securityWhite.svg" alt="">
                                Безопасность</a>
                        </li>
                        <li v-bind:class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/auth/logout">
                                <img class="img__icon-settings" src="/icons/settings/logout.svg" alt="">
                                Выйти из профиля</a>
                        </li>
                    </div>
                </div>
            </div>
        </nav>
        <main class="main-payment">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <left-menu :active="1"></left-menu>
                    </div>
                    <div class="col-lg-8">
                        <div class="block-payment shadow mb-lg-0 mt-lg-0 mt-5 mb-5">
                            <div class="title__block d-none d-lg-block p-4">
                                <h3 class="caption">Платежные реквизиты</h3>
                            </div>
                            <hr width="100%" class="d-none d-lg-block">
                            <ValidationObserver v-slot="{invalid, errors}" ref="observer" tag="form"
                                                @submit.prevent="onSave">
                                <main class="details_payment">
                                    <div class="pb-2 pl-lg-4 pr-lg-4 pt-4">
                                        <label class="select-wrapper w-100 caption p-0" for="">Юридическое наименование
                                            <span style="color: rgb(243, 122, 138)">*</span>
                                            <div class="row">
                                                <div class="col-4">
                                                    <v-select class="selectpicker" v-model="modelPayment.legal_name"
                                                              :options="urName" :items="urName" labelTitle="Выбрать"
                                                              textProp="text" valueProp="text" @input="getLegal_text">
                                                    </v-select>
                                                </div>
                                                <div class="col-8">
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                    <ValidationProvider rules="required|max:100"
                                                                        v-slot="{ errors, failed }">
                                                        <input v-model="modelPayment.title" type="text"
                                                               name="search-object" placeholder="ПромТехИнвест"
                                                               class="input-profile-info"
                                                               :class="{ 'is-invalid': failed }"
                                                               autocomplete="off" required maxlength="100">
                                                    </ValidationProvider>
                                                </div>
                                            </div>
                                        </label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <ValidationProvider rules="required|numeric|max:13"
                                                                    v-slot="{ errors, failed }">
                                                    <label class="w-100 caption" for="">ИНН
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <input v-model="modelPayment.tin" type="text"
                                                               name="search-object" placeholder="Введите ИНН"
                                                               class="input-profile-info" required
                                                               :class="{ 'is-invalid': failed }"
                                                               autocomplete="off" maxlength="13">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-lg-6">
                                                <ValidationProvider rules="required|numeric|max:9"
                                                                    v-slot="{ errors, failed }">
                                                    <label class="w-100 caption" for="">КПП
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <input v-model="modelPayment.numKpp" type="text"
                                                               name="search-object" placeholder="Введите КПП"
                                                               class="input-profile-info" required
                                                               :class="{ 'is-invalid': failed }"
                                                               autocomplete="off" maxlength="9">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-lg-6">
                                                <ValidationProvider rules="required|numeric|max:9"
                                                                    v-slot="{ errors, failed }">
                                                    <label class="w-100 caption" for="">БИК
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <input v-model="modelPayment.bic" type="text"
                                                               name="search-object" placeholder="Введите БИК"
                                                               class="input-profile-info" required
                                                               :class="{ 'is-invalid': failed }"
                                                               autocomplete="off" maxlength="9">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-lg-12">
                                                <ValidationProvider v-slot="{errors, failed}" rules="required">
                                                    <label class="w-100 caption" for="">Банковские реквизиты
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <input v-model="modelPayment.requisites" type="text"
                                                               name="search-object" required
                                                               :class="{'is-invalid': failed}"
                                                               placeholder="1234 5678 9102 3456    в Московский банк ПАО Сбербанк г.Москва"
                                                               class="input-profile-info" autocomplete="off">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-lg-6">
                                                <ValidationProvider rules="required|numeric|max:20"
                                                                    v-slot="{ errors, failed }">
                                                    <label class="w-100 caption" for="">К/С
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <input v-model="modelPayment.kc" type="text"
                                                               name="search-object" required
                                                               :class="{ 'is-invalid': failed }"
                                                               placeholder="Введите К/С" class="input-profile-info"
                                                               autocomplete="off" maxlength="20">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-lg-6">
                                                <ValidationProvider rules="required|numeric|max:10"
                                                                    v-slot="{ errors, failed }">
                                                    <label class="w-100 caption" for="">ОКПО
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <input v-model="modelPayment.okpo" type="text"
                                                               name="search-object" required
                                                               :class="{ 'is-invalid': failed }"
                                                               placeholder="Введите ОКПО" class="input-profile-info"
                                                               autocomplete="off" maxlength="10">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-lg-6">
                                                <ValidationProvider rules="required|numeric|max:11"
                                                                    v-slot="{ errors, failed }">
                                                    <label class="w-100 caption" for="">ОКАТО
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <input v-model="modelPayment.okato" type="text"
                                                               name="search-object"
                                                               :class="{ 'is-invalid': failed }"
                                                               placeholder="Введите ОКАТО" class="input-profile-info"
                                                               autocomplete="off" maxlength="11">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-lg-6">
                                                <ValidationProvider rules="required|numeric|max:13"
                                                                    v-slot="{ errors, failed }">
                                                    <label class="w-100 caption" for="">ОГРН
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <input v-model="modelPayment.orgn" type="text"
                                                               name="search-object"
                                                               :class="{ 'is-invalid': failed }"
                                                               placeholder="Введите ОГРН" class="input-profile-info"
                                                               autocomplete="off" maxlength="13">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                                <div class="block__address-main pl-lg-4 pr-lg-4 details_payment">
                                    <h5 class="caption">Адрес компании <span
                                        class="additionally">(для отображения на сайте)</span></h5>
                                    <div class="addAddressButton d-flex flex-column flex-lg-row pb-2">
                                        <button type="button"
                                                :class="{ 'active': showManually }"
                                                @click="switchManually" class="mb-2 mb-lg-0 sb-button-blue mr-md-2">
                                            <p>Ввести вручную</p>
                                        </button>
                                        <button type="button" :class="{ 'active': showMap }" class="sb-button-blue"
                                                @click="switchMap">
                                            <img class="pr-3" alt="">
                                            <p>Указать на карте</p>
                                        </button>
                                    </div>
                                    <div class="infoAboutAddress" v-if="showManually">
                                        <div class="row">
                                            <div class="col-lg-6 ">
                                                <label class="w-100 caption select-wrapper mb-xl-2" for="">Страна
                                                    <span v-if="modelPayment.country != null"
                                                          style="color: rgb(243, 122, 138)">*</span>
                                                    <v-select labelTitle="Выбрать" class="selectpicker"
                                                              v-model="modelPayment.country" :options="allCountries"
                                                              textProp="title" valueProp="id">
                                                    </v-select>
                                                </label>
                                            </div>
                                            <div class="col-lg-6 ">
                                                <ValidationProvider v-slot="{errors, failed}"
                                                                    :rules="modelPayment.country != null ? 'required': ''">
                                                    <label class="w-100 caption select-wrapper mb-xl-2" for="">Область,
                                                        округ, провинция
                                                        <span v-if="modelPayment.country != null"
                                                              style="color: rgb(243, 122, 138)">*</span>
                                                        <v-select id="region" valueProp="id" class="selectpicker"
                                                                  :class="{'is-invalid': failed}" textProp="title"
                                                                  v-model="modelPayment.region" labelTitle="Выбрать"
                                                                  :options="regionsWithCountry">
                                                        </v-select>
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-lg-6">
                                                <ValidationProvider v-slot="{errors, failed}"
                                                                    :rules="modelPayment.country != null ? 'required': ''">
                                                    <label class="w-100 caption select-wrapper mb-xl-2" for="">Город
                                                        (населенный пункт)
                                                        <span v-if="modelPayment.country != null"
                                                              style="color: rgb(243, 122, 138)">*</span>
                                                        <v-select id="city" textProp="title" valueProp="id"
                                                                  :class="{'is-invalid': failed}"
                                                                  labelTitle="Выбрать" v-model="modelPayment.city"
                                                                  class="selectpicker" @input="getCity_id"
                                                                  :options="citiesWithRegion(region_id)">
                                                        </v-select>
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-lg-6">
                                                <ValidationProvider v-slot="{ failed, errors }"
                                                                    :rules="modelPayment.country != null ? 'required|numeric|max:6|min:6|': ''">
                                                    <label class="w-100 caption" for="">Почтовый индекс
                                                        <span v-if="modelPayment.country != null"
                                                              style="color: rgb(243, 122, 138)">*</span>
                                                        <input type="text" v-model="modelPayment.postIndex"
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
                                                                    :rules="modelPayment.country != null ? 'max:200|required': ''">
                                                    <label class="w-100 caption" for="">Улица, номер дома и офиса
                                                        <span v-if="modelPayment.country != null"
                                                              style="color: rgb(243, 122, 138)">*</span>
                                                        <input :class="{ 'is-invalid': failed }" type="text"
                                                               v-model="modelPayment.address"
                                                               placeholder="Введите имя улицы, номер дома и офиса"
                                                               class="input-profile-info" autocomplete="off"
                                                               :disabled="modelPayment.country == null">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mapAddress pt-3" v-if="showMap" style="height: 300px">
                                        <yandex-map @click="showLocation" style="height:100%" :coords="center"
                                                    :zoom="17" :settings="settings">
                                            <ymap-marker v-model="marker"
                                                         marker-type="placemark"
                                                         :coords="coords"
                                                         :markerId="1"
                                                         :balloon="{header: 'header', body: 'body', footer: 'footer'}"
                                                         :icon="{color: 'green', glyph: 'bicycle'}"
                                                         :options="{draggable:true, iconShadow:true, iconShadowImageOffset:[2,-20],
                                                    iconShadowImageSize: [29, 7]}" @input="getCity_id"/>
                                        </yandex-map>
                                    </div>
                                </div>
                                <button type="submit" class="button button-green button-center mb-4 d-block">Сохранить
                                </button>
                            </ValidationObserver>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from '../NavBar'
import extendedinf from "../ExtendedFooterInformation";
import MenuComponentExecutor from "./menuComponent";
import MenuComponentCustomer from "./profileCustomer/menuComponent";
import VSelect from "@alfsnd/vue-bootstrap-select";
import leftMenu from "./leftMenu";
import {mapActions, mapGetters} from "vuex";
import {yandexMap, ymapMarker} from 'vue-yandex-maps';
import axios from "axios";
import AddressForm from "../AddressForm";

export default {
    data: function () {
        return {
            settings: this.$apiSettings.yandexMap,
            marker: [53.235963, 34.353203], coords: [53.235963, 34.353203],
            delivery_path: [[54, 39], [55, 39], [56, 40], [57, 41],],
            delivery_path_stroke: {color: '#ff0000', width: 4, style: '2 0'}, center: [54, 39],
            selected: 'Выбрать' || 'defaultValue', country_id: null, region_id: null,
            showProfile: false,
            urName: ["ООО", "ОАО", "ЗАО"],
            paymentDetails: '',
            showMap: false, showManually: true, image: '',
            modelPayment: {
                legal_name: 'ООО', title: null, tin: null, numKpp: null, bic: null, requisites: null, kc: null,
                okpo: null, okato: null, orgn: null, address_id: null, country: null, region: null, city: null,
                postIndex: null, address: null, longtitude: null, latitude: null, city_id: null,
            }, resetRegion: false, resetCity: false, loading: false, regionsWithCountry: [],
        }
    },
    components: {
        AddressForm,
        MenuComponentCustomer, MenuComponentExecutor, leftMenu, navbar, extendedinf, VSelect, yandexMap, ymapMarker,
    },
    methods: {
        ...mapActions(["fetchCities", "fetchCountries", "fetchRegions", "fetchPaymentDetails",
            "setPaymentDetails"]),

        getGeocode() {
            axios.get('/get/geocoder', {
                params: {
                    api: 'a5dcb900-70e8-4ce9-9128-481140e584c3',
                    lat: this.coords[0],
                    long: this.coords[1]
                }
            }).then(resp => {
                this.modelPayment.country = resp.data.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.Address.Component[0].name.replace(' ');
                this.modelPayment.region = resp.data.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.Address.Component[2].name;
                this.modelPayment.city = resp.data.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.Address.Component[4].name;
                this.modelPayment.address = resp.data.GeoObjectCollection.featureMember[0].GeoObject.name;
                this.modelPayment.postIndex = resp.data.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.Address.postal_code;
                this.modelPayment.longtitude = resp.data.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ')[1];
                this.modelPayment.latitude = resp.data.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ')[0];

                this.validateCity();
            })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                });
        },
        showLocation: function (e) {
            this.coords = e.get('coords');
            this.center = this.coords;
            this.getGeocode();
        },
        validateCity() {
            axios.post('/create/newCity', {
                titleCountry: this.modelPayment.country,
                titleRegion: this.modelPayment.region,
                titleCity: this.modelPayment.city
            }).then((response) => {
                this.fetchCities()
                this.fetchCountries()
                this.fetchRegions()
            }).catch((error) => {
                console.log(error)
            })
        },
        showOrHideMenu() {
            this.showProfile = !this.showProfile;
        },
        switchMap() {
            this.showManually = false;
            this.showMap = true
            //this.image = 'icons/settings/maps-and-flagsWhite.svg';
        },
        switchManually() {
            this.showManually = true;
            this.showMap = false;
            //this.image = 'icons/settings/maps-and-flags.svg';
        },
        getCity_id(allCities) {
            this.modelPayment.city_id = allCities.id;
        },
        getLegal_text(legal) {
            this.modelPayment.legal_name = legal;
        },
        async onSave() {
            await this.$refs.observer.validate().then(success => {
                if (!success) {
                    setTimeout(() => {
                        const errors = Object.entries(this.$refs.observer.errors)
                            .map(([key, value]) => ({key, value}))
                            .filter(error => error["value"].length);
                        this.$refs.observer.refs[errors[0]["key"]].$el.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });
                    }, 100);
                } else {
                    if (this.city) this.modelPayment.city_id = this.city.id;
                    if (this.legal) this.modelPayment.legal_name = this.legal;

                    this.setPaymentDetails(this.modelPayment);
                    window.location.reload();
                }
            });
        },
        fillInfo(info) {
            this.modelPayment.title = info?.title;
            this.modelPayment.tin = info?.tin;
            this.modelPayment.numKpp = info?.numKpp;
            this.modelPayment.bic = info?.bic;
            this.modelPayment.requisites = info?.requisites;
            this.modelPayment.kc = info?.kc;
            this.modelPayment.okpo = info?.okpo;
            this.modelPayment.okato = info?.okato;
            this.modelPayment.orgn = info?.orgn;
            this.modelPayment.legal_name = info?.legal_name;
            this.modelPayment.postIndex = info?.address?.postIndex ?? null;
            this.modelPayment.address = info?.address?.address ?? null;
            this.modelPayment.address_id = info?.address?.id ?? null;
            this.modelPayment.country = info?.address?.country ?? null;
            this.modelPayment.region = info?.address?.region ?? null;
            this.modelPayment.city = info?.address?.city ?? null;
        }
    },
    async mounted() {
        this.center = [53.235963, 34.353203];
        if (this.showMap === false) {
            this.image = '/icons/settings/maps-and-flags.svg';
        } else if (this.showMap === true) {
            this.image = '/icons/settings/maps-and-flagsWhite.svg';
        }
        this.modelPayment.legal_name = 'OOO';

        this.loading = true;
        await this.fetchCountries().then(result => {
            if (this.modelPayment.country != null) this.country_id = result.find(f => f.title == this.modelPayment.country).id;
        });
        await this.fetchRegions().then(result => {
            if (this.country_id != null) this.regionsWithCountry = this.regions(this.country_id);
            if (this.modelPayment.region != null) this.region_id = this.AllRegions.find(f => f.title == this.modelPayment.region).id;
        });
        await this.fetchCities().then(result => {
            if (this.region_id != null) this.citiesWithRegion(this.region_id);
        });
        await this.$store.dispatch('getPaymentDetailsByUser');
        if (this.country_id != null) this.regionsWithCountry = this.regions(this.country_id);

        this.loading = false;
    },
    computed: {
        ...mapGetters({
            allCities: 'AllCities', allCountries: 'AllCountries', AllRegions: 'AllRegions',
            regions: 'RegionsWithCountryId', citiesWithRegion: 'CityWithRegionId', paymentDetail: 'AllPaymentDetails',
        }),
        user: function () {
            return window.user;
        },
        paymentWatch() {
            return this.paymentDetail;
        },
        city() {
            return this.allCities.filter(item => item.title === this.modelPayment.city)[0]
        },
        legal() {
            return this.urName.filter(item => item.text === this.modelPayment.legal_name)[0];
        },
    },
    watch: {
        paymentWatch: {
            handler: async function (info) {
                await this.fillInfo(info);
                // if (this.modelPayment.country != null) this.country_id = this.allCountries.find(f => f.title == this.modelPayment.country).id;
                // if (this.modelPayment.region != null) this.region_id = this.allRegions.find(f => f.title == this.modelPayment.region).id;
            }, deep: true
        },
        'modelPayment.country': {
            handler: function (newValue) {
                this.country_id = newValue?.id ?? null;
                if (this.country_id != null)
                    this.regionsWithCountry = this.regions(this.country_id);
                if (this.country_id) {
                    this.resetRegion = true;
                    this.resetCity = true;
                }
                if (this.resetRegion) this.modelPayment.region = null;
                if (this.resetCity) this.modelPayment.city = null;
            }, deep: true
        },
        'modelPayment.region': {
            handler: function (newValue) {
                this.region_id = newValue?.id ?? null;
                this.citiesWithRegion(this.region_id);
                if (this.region_id) this.resetCity = true;
                if (this.resetCity) this.modelPayment.city = null;
            }, deep: true
        },
    }
}
</script>

<style>
.is-invalid {
    color: rgb(243, 122, 138) !important;
    border: 1px solid rgb(243, 122, 138) !important;
}
</style>
