<template>
    <div class="block__address-main" :class="$props.defaultClass">
        <h5 class="caption">{{ $props.titleBlock }}<span v-if="!$props.titleBlock"
                                                         class="additionally">(для отображения на сайте)</span></h5>
        <div class="infoAboutAddress" v-if="$props.showInput">
            <div class="g-3 g-lg-0 row">
                <div class="col-lg-6 ">
                    <label class="w-100 caption select-wrapper mb-xl-2" for="">Страна
                        <v-select labelTitle="Выбрать" class="selectpicker" v-model="address.country"
                                  :options="countries" textProp="title" valueProp="id" @input="inputCountry">
                        </v-select>
                    </label>
                </div>
                <div class="col-lg-6 ">
                    <ValidationProvider v-slot="{errors, failed}" :rules="'required'">
                        <label class="w-100 caption select-wrapper mb-xl-2" for="">Область, округ, провинция
                            <span style="color: rgb(243, 122, 138)">*</span>
                            <v-select id="region" valueProp="id" class="selectpicker" :class="{'is-invalid': failed}"
                                      textProp="title" labelTitle="Выбрать" :options="regionsWithCountry"
                                      @input="inputRegion" v-model="address.region">
                            </v-select>
                        </label>
                        <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                    </ValidationProvider>
                </div>
                <div class="col-lg-6">
                    <ValidationProvider v-slot="{errors, failed}" :rules="'required'">
                        <label class="w-100 caption select-wrapper mb-xl-2" for="">Город
                            (населенный пункт)
                            <span style="color: rgb(243, 122, 138)">*</span>
                            <v-select id="city" textProp="title" valueProp="id"
                                      :class="{'is-invalid': failed}" labelTitle="Выбрать" v-model="address.city"
                                      class="selectpicker" @input="getCity_id" :options="citiesWithRegion">
                            </v-select>
                        </label>
                        <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                    </ValidationProvider>
                </div>
                <div class="col-lg-6">
                    <ValidationProvider v-slot="{ failed, errors }"
                                        :rules="'required|numeric|max:6|min:6|'">
                        <label class="caption mb-0 pb-0 w-100" for="">Почтовый индекс
                            <span style="color: rgb(243, 122, 138)">*</span>
                            <input type="text" v-model="address.postIndex"
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
                                        :rules="'max:200|required'">
                        <label class="w-100 caption" for="">Улица, номер дома и офиса
                            <span style="color: rgb(243, 122, 138)">*</span>
                            <input :class="{ 'is-invalid': failed }" type="text" @blur="blurStreet"
                                   v-model="address.street" placeholder="Введите имя улицы, номер дома и офиса"
                                   class="input-profile-info w-100" autocomplete="off">
                        </label>
                        <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                    </ValidationProvider>
                </div>
            </div>
        </div>
        <slot name="address">

        </slot>
        <div class="mapAddress pt-3" v-if="$props.showMap" :style="`height: ${$props.mapHeight}px`">
            <yandex-map @click="showLocation" style="height:100%" :coords="coords" :zoom="17"
                        :controls="['searchControl']" :settings="settings"
                        :detailed-controls="{ zoomControl: { position: { right: 10, top: 50 } } }">
                <ymap-marker v-model="coords" marker-type="placemark" :coords="coords" :markerId="1"
                             :icon="{color: 'green'}"
                             :options="{draggable:draggableMarker, iconShadow:true, iconShadowImageOffset:[2,-20],
                                                    iconShadowImageSize: [29, 7]}" @input="getCity_id"/>
            </yandex-map>
        </div>
    </div>
</template>

<script>
import VSelect from "@alfsnd/vue-bootstrap-select";
import {yandexMap, ymapMarker, loadYmap} from 'vue-yandex-maps';
import axios from "axios";
import {mapActions, mapGetters} from "vuex";
import country from "../store/modules/country";
import eventBus from '../event-bus';

export default {
    props: {
        titleBlock: {
            type: String,
            default: 'Адрес компании'
        },
        showMap: {
            type: Boolean,
            default: true
        },
        showInput: {
            type: Boolean,
            default: true
        },
        defaultClass: {
            type: String,
            default: 'p-4'
        },
        mapHeight: {
            default: 300
        },
        draggableMarker: {
            default: true
        },
        isShowLocation: {
            type: Boolean,
            default: true
        },
        addressProp: {
            type: Object
        }
    },
    data() {
        return {
            address: {
                country: null, region: null, city: null, postIndex: null, street: null, city_id: null,
            },
            regionsWithCountry: [], citiesWithRegion: [], country_id: null, region_id: null,
            settings: this.$apiSettings.yandexMap, coords: [53.235963, 34.353203],
            tempData: {countries: null, regions: null, cities: null},

        }
    },
    computed: {
        ...mapGetters({
            allCities: 'AllCities', allRegions: 'AllRegions', countries: 'AllCountries', regions: 'RegionsWithCountryId'
        })
    },
    methods: {
        ...mapActions(["fetchCities", "fetchCountries", "fetchRegions"]),
        getGeocode() {
            axios.get('/get/geocoder', {
                params: {
                    api: 'a5dcb900-70e8-4ce9-9128-481140e584c3',
                    lat: this.coords[0],
                    long: this.coords[1]
                }
            }).then(resp => {
                const address = resp.data.GeoObjectCollection.featureMember[0].GeoObject;
                if (address && address.metaDataProperty && address.metaDataProperty.GeocoderMetaData) {
                    const components = address.metaDataProperty.GeocoderMetaData.Address.Component;
                    const postalCode = address.metaDataProperty.GeocoderMetaData.Address.postal_code;
                    const region = address.metaDataProperty.GeocoderMetaData.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName;

                    if (Array.isArray(components)) {
                        components.forEach(component => {
                            switch (component.kind) {
                                case 'country':
                                    this.address.country = component.name;
                                    const country = this.tempData.countries.find(f => f.title == this.address.country);
                                    this.inputCountry(country);
                                    this.address.region = region;
                                    break;
                                case 'area':
                                    if (component.name.startsWith("городской округ ")) {
                                        this.address.area = component.name.substring("городской округ ".length);
                                    } else {
                                        this.address.area = component.name;
                                    }
                                    break;
                                case 'locality':
                                    this.address.city = component.name;
                                    const city = this.tempData.cities.find(f => f.title == this.address.city);
                                    this.getCity_id(city);
                                    break;
                                default:
                                    break;
                            }
                        });
                    }
                    if (region) {
                        const tempRegion = this.tempData.regions.find(f => f.title == region);
                        this.inputRegion(tempRegion);
                    }
                    this.address.postIndex = postalCode;
                    this.address.street = address.name;

                    const posString = address.Point.pos;
                    const posArray = posString.split(" ");
                    const latitude = parseFloat(posArray[1]);
                    const longtitude = parseFloat(posArray[0]);

                    this.address.latitude = latitude;
                    this.address.longtitude = longtitude;

                }
                this.$emit('update-address', this.address);
                //this.validateCity();
            }).catch(error => {
                console.log(error);
                this.errored = true;
            });
        },
        showLocation: function (e) {
            if (!this.isShowLocation) {
                return false;
            }
            this.coords = e.get('coords');
            this.getGeocode();
        },
        validateCity() {
            axios.post('/create/newCity', {
                titleCountry: this.address.country,
                titleRegion: this.address.region,
                titleCity: this.address.city
            }).then((response) => {
                this.fetchCities()
                this.fetchCountries()
                this.fetchRegions()
            }).catch((error) => {
                console.log(error)
            })
        },
        getCoords(address) {
            let temp_address = address.replace(' ', '+');
            let long = null;
            let lat = null;
            axios.get('/api/v1/get/coords', {
                params: {
                    address: temp_address
                }
            }).then(resp => {
                const coords = resp.data.response.GeoObjectCollection.featureMember[0]['GeoObject']['Point']['pos'].split(' ');
                long = parseFloat(coords[0]);
                lat = parseFloat(coords[1]);
                this.coords = [lat, long];
            }).catch(error => {
                console.log(error);
            });
        },
        inputCountry(country) {
            this.country_id = country?.id ?? this.getCountryIdByTitle(country);
            this.regionsWithCountry = this.filterRegionsByCountryId(this.country_id);
            eventBus.$emit('update-address-field', this.address);
        },
        inputRegion(region) {
            this.region_id = region?.id ?? this.getRegionIdByTitle(region);
            this.citiesWithRegion = this.filterCitiesByRegionId(this.region_id);
            eventBus.$emit('update-address-field', this.address);
        },
        getCity_id(city) {
            this.city_id = city?.id ?? this.getCityIdByTitle(city)
            this.address.city_id = this.city_id;
            eventBus.$emit('update-address-field', this.address);
        },
        getCountryIdByTitle(title) {
            if (this.tempData.countries && this.tempData.countries.length > 0) {
                const country = this.tempData.countries.find(c => c.title === title);
                return country ? country.id : null;
            } else {
                return null;
            }
        },
        getRegionIdByTitle(title) {
            if (this.tempData.regions && this.tempData.regions.length > 0) {
                const region = this.tempData.regions.find(r => r.title === title);
                return region ? region.id : null;
            } else {
                return null;
            }
        },
        getCityIdByTitle(title) {
            if (this.tempData.cities && this.tempData.cities.length > 0) {
                const city = this.tempData.cities.find(r => r.title === title);
                return city ? city.id : null;
            } else {
                return null;
            }
        },
        filterRegionsByCountryId(countryId) {
            if (this.tempData.regions && this.tempData.regions.length > 0) {
                return this.tempData.regions.filter(r => r.country_id === countryId);
            } else {
                return [];
            }
        },
        filterCitiesByRegionId(regionId) {
            if (this.tempData.cities && this.tempData.cities.length > 0) {
                return this.tempData.cities.filter(c => c.region_id.id === regionId);
            } else {
                return [];
            }
        },
        updateAddressObject(item, address) {
            this.coords = item;
            if (address.latitude != null && address.longtitude != null) {
                this.address.country = address.country;
                const country = this.tempData.countries.find(f => f.title == this.address.country);
                this.inputCountry(country);
                this.address.region = address.region;
                this.address.area = address.region;
                this.address.city = address.city;
                const city = this.tempData.cities.find(f => f.title == this.address.city);
                this.getCity_id(city);
                this.address.city_id = address.city_id;
                this.address.postIndex = address.postIndex;
                this.address.street = address.street;
                this.address.longtitude = address.longtitude;
                this.address.latitude = address.latitude;
                return;
            }
            axios.get('/get/geocoder', {
                params: {
                    api: 'a5dcb900-70e8-4ce9-9128-481140e584c3',
                    lat: this.coords[0],
                    long: this.coords[1]
                }
            }).then(resp => {
                const tempAddress = resp.data.GeoObjectCollection.featureMember[0].GeoObject;
                if (tempAddress && tempAddress.metaDataProperty && tempAddress.metaDataProperty.GeocoderMetaData) {
                    const components = tempAddress.metaDataProperty.GeocoderMetaData.Address.Component;
                    const region = tempAddress.metaDataProperty.GeocoderMetaData.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName;

                    if (Array.isArray(components)) {
                        components.forEach(component => {
                            switch (component.kind) {
                                case 'country':
                                    this.address.country = component.name;
                                    const country = this.tempData.countries.find(f => f.title == this.address.country);
                                    this.inputCountry(country);
                                    this.address.region = region;
                                    break;
                                case 'area':
                                    this.address.area = component.name;
                                    break;
                                case 'locality':
                                    this.address.city = component.name;
                                    const city = this.tempData.cities.find(f => f.title == this.address.city);
                                    this.getCity_id(city);
                                    break;
                                default:
                                    break;
                            }
                        });
                    }
                    if (region) {
                        const tempRegion = this.tempData.regions.find(f => f.title == region);
                        this.inputRegion(tempRegion);
                    }
                    this.address.postIndex = address.postIndex;
                    this.address.street = address.street;

                    const posString = tempAddress.Point.pos;
                    const posArray = posString.split(" ");
                    const latitude = parseFloat(posArray[1]);
                    const longtitude = parseFloat(posArray[0]);

                    this.address.latitude = latitude;
                    this.address.longtitude = longtitude;
                }
                this.$emit('update-address', this.address);
                //this.validateCity();
            }).catch(error => {
                console.log(error);
                this.errored = true;
            });
        },
        async adminCoords(item, tempAddress) {
            try {
                if (tempAddress.latitude != null && tempAddress.longtitude != null) {
                    this.coords = [tempAddress.latitude, tempAddress.longtitude];
                } else {
                    const country = tempAddress.country?.title || tempAddress.country;
                    const city = tempAddress.city.title || tempAddress.city;
                    const address = encodeURI(`${country}+${city}+${tempAddress.street}`);
                    const resp = await axios.get('/api/v1/get/coords', {params: {address}});
                    const coords = resp.data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ');
                    this.coords = [coords[1], coords[0]];
                }

                if(this.tempData.countries && this.tempData.regions && this.tempData.cities) {
                    const region = tempAddress.region;
                    this.address.country = tempAddress.country;
                    const country = this.tempData.countries.find(f => f.title == this.address.country);
                    this.inputCountry(country);

                    this.address.region = region;
                    this.address.city = tempAddress.city;
                    const city = this.tempData.cities.find(f => f.title == this.address.city);
                    this.getCity_id(city);

                    if (region) {
                        const tempRegion = this.tempData.regions.find(f => f.title == region);
                        this.inputRegion(tempRegion);
                    }
                }

                this.address.postIndex = tempAddress.postIndex;
                this.address.street = tempAddress.street;
                this.address.latitude = tempAddress.latitude;
                this.address.longtitude = tempAddress.longtitude;

                this.$emit('update-address', this.address);
            } catch (error) {
                console.error(error);
            }
        },
        showCoords(coords) {
            this.coords = coords;
        },
        blurStreet() {
            let addressTemp = encodeURI(`${this.address.country.title ?? this.address.country}+${this.address.city.title || this.address.city}+${this.address.street}`);
            this.getCoords(addressTemp)
        }
    },
    async created() {
        eventBus.$on('update-address-object', this.updateAddressObject);
        eventBus.$on('admin-address-object', this.adminCoords);

        const localStorageItems = ['object', 'admin-object', 'edit-object'];
        let storedObject = null;

        for (const item of localStorageItems) {
            const localStorageItem = localStorage.getItem(item);
            if (localStorageItem) {
                storedObject = JSON.parse(localStorageItem);
                break;
            }
        }

        await Promise.all([
            this.fetchCountries().then(() => {
                this.tempData.countries = this.countries;
            }),
            this.fetchRegions().then(() => {
                this.tempData.regions = this.allRegions;
            }),
            this.fetchCities().then(() => {
                this.tempData.cities = this.allCities;
            })
        ]);

        this.address = this.addressProp;

        if (storedObject == null && this.addressProp.postIndex != null) {
            if (this.addressProp && this.addressProp.latitude != null && this.addressProp.longtitude != null) {
                this.coords = [this.addressProp.latitude, this.addressProp.longtitude];
            } else {
                let addressTemp = encodeURI(`${this.addressProp.country.title ?? this.addressProp.country}+${this.addressProp.city.title || this.addressProp.city}+${this.addressProp.street}`);
                this.getCoords(addressTemp);
            }
        }
    },
    watch: {
        address: {
            handler: function (value) {
                this.$emit('update-address', value);
            }, deep: true
        }
    },
    components: {VSelect, yandexMap, ymapMarker},
    name: "AddressForm",
}
</script>

<style scoped>

</style>

<style>
.block__address-main .v-dropdown-container {
    max-height: 180px;
    overflow-y: scroll;
}
</style>
