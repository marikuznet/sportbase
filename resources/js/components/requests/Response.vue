<template>
    <div class="sb-response">
        <div class="row no-gutters typeSport">
            <div class="col-lg-4 col-sm-12">
                <ValidationProvider rules="required|vSelectLength" v-slot="props">
                    <input type="text" hidden v-model="modelResponse.type_sports.length">
                    <label class="w-100 caption select-wrapper mb-xl-2 pt-3" for="typeSport" @click="syncSports">
                        Вид спорта
                        <v-select id="typeSport" labelTitle="Выберите вид спорта" textProp="title"
                                  class="selectpicker mt-1" style="border: none !important;" valueProp="id"
                                  :options="responseData.typeSports" @input="addSportType" ref="typeSports"
                                  v-model="selSports" :class="{'is-invalid': modelResponse.type_sports.length === 0}">
                        </v-select>
                    </label>
                </ValidationProvider>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="sport-type-list d-flex">
                    <div v-for="(item, index) in modelResponse.type_sports" :key="index"
                         class="sport-type-list__item">
                        {{ item.title }}
                        <span @click="modelResponse.type_sports.splice(index, 1)"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row no-gutters requirementsInfrastructure">
            <div class="col-lg-12">
                <ValidationProvider rules="required" v-slot="props" name="infrastructures">
                    <h2 class="caption">Требования к инфраструктуре
                        <span class="additionally text-invalid-notif">
                            {{ props.errors[0] != null ? errorsTender['checkBoxes'] : null }}
                        </span>
                    </h2>
                    <div class="col-lg-12 p-0">
                        <div id="collapseSport" aria-labelledby="headingSport"
                             class="accordion-collapse collapse show">
                            <div class="sport-list d-flex flex-wrap justify-content-between">
                                <div class="label-checkbox-wrapp sport-list__item"
                                     v-for="(item, index) in allInfrastructures">
                                    <input type="checkbox" name="checkbox-sport" :id="'sport-'+index"
                                           v-model="modelResponse.infrastructures"
                                           class="label-checkbox-wrapp__checkbox"
                                           :value="{id: item.id, title: item.title}">
                                    <label :for="'sport-'+index" class="label-checkbox-wrapp__label">
                                        {{ item.title }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </ValidationProvider>
            </div>
        </div>
        <div class="row no-gutters regionEvent d-flex justify-content-between">
            <div class="col-lg-5 leftPart d-flex">
                <label class="w-100 caption select-wrapper mb-xl-2 pr-2 p-0" for="region">Регион мероприятия
                    <v-select id="region" v-model="modelResponse.city_name" class="selectpicker input-label"
                              :options="responseData.cities" textProp="title" valueProp="id" @input="getCity_id"
                              labelTitle="Выберите регион проведения">
                    </v-select>
                </label>
            </div>
            <div class="col-lg-2">
                <ValidationProvider rules="required" v-slot="{ valid, errors, dirty, invalid }">
                    <label class="w-100 caption select-wrapper mb-xl-2">
                        Дата начала
                        <input type="date" name="search-object" placeholder="Укажите дату" :min="nowDate"
                               @change="setEndDate" v-model="modelResponse.startDate"
                               class="input-profile-info input-label"
                               :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }">
                    </label>
                </ValidationProvider>
            </div>
            <div class="col-auto d-flex align-items-center justify-content-center">
                —
            </div>
            <div class="col-lg-2">
                <ValidationProvider rules="required" v-slot="{ valid, errors, dirty, invalid }">
                    <label class="w-100 caption select-wrapper mb-xl-2 pr-2">
                        Дата окончания
                        <input type="date" name="search-object" placeholder="Укажите дату"
                               :min="minEndDate" v-model="modelResponse.endDate"
                               class="input-profile-info input-label"
                               :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }">
                    </label>
                </ValidationProvider>
            </div>
            <div class="col-lg-2">
                <label class="w-100 caption select-wrapper mb-xl-2" for="dates">Разброс даты
                    <v-select id="dates" v-model="modelResponse.spreadDate" class="selectpicker input-label"
                              :options="[{id: 1, title: '1 день'},{id: 2, title: '2 дня'},{id: 3, title: '3 дня'}]"
                              textProp="title" valueProp="id" labelTitle="3 дня">
                    </v-select>
                </label>
            </div>
        </div>
        <div class="row no-gutters typeFood">
            <div class="col-lg-12">
                <ValidationProvider rules="required" v-slot="{ valid, errors, dirty, invalid }">
                    <h2 class="caption sub-caption mb-2">Тип питания
                        <span class="additionally text-invalid-notif">
                            {{ errors[0] != null ? errorsTender['checkBoxes'] : null }}
                    </span>
                    </h2>
                    <div class="col-lg-12 p-0">
                        <div class="col-lg-12 d-flex flex-wrap label_radio p-0">
                            <div class="label-radio-wrapp food-list__item"
                                 v-for="item in responseData.typeFoods">
                                <input class="label-radio-wrapp__radio d-none" type="checkbox" name="food"
                                       :value="{id: item.id, title: item.title}" v-model="modelResponse.typeFoods"
                                       :id="'food-'+item.id">
                                <label class="label-radio-wrapp__label" :for="'food-'+item.id">
                                    {{ item.title }}
                                </label>
                            </div>
                        </div>
                    </div>
                </ValidationProvider>
            </div>
        </div>
        <div class="row no-gutters dopServices">
            <div class="col-lg-12">
                <ValidationProvider rules="required" v-slot="{ valid, errors, dirty, invalid }">
                    <h2 class="caption sub-caption mb-2">Дополнительные услуги
                        <span class="additionally text-invalid-notif">
                            {{ errors[0] != null ? errorsTender['checkBoxes'] : null }}
                        </span>
                    </h2>
                    <div class="col-lg-12 d-flex flex-wrap label_radio p-0">
                        <div class="label-radio-wrapp type-list__item"
                             v-for="item in responseData.additions">
                            <input class="label-radio-wrapp__radio d-none" type="checkbox" :id="'addition-'+item.id"
                                   v-model="modelResponse.additionsTender" name="addition"
                                   :value="{id: item.id, title: item.title}">
                            <label class="label-radio-wrapp__label" :for="'addition-'+item.id">
                                {{ item.title }}
                            </label>
                        </div>
                    </div>
                </ValidationProvider>
            </div>
        </div>
        <div class="row no-gutters blockPrice">
            <div class="row col-people">
                <div class="col-lg-3 col-6">
                    <ValidationProvider rules="required|numeric|max:6|positive" v-slot="{ failed, errors }">
                        <label class="w-100 caption select-wrapper mb-xl-2">Кол-во человек
                            <input type="text" name="search-object" maxlength="4" :class="{ 'is-invalid': failed }"
                                   pattern="^([0-9]+)$" placeholder="30" autocomplete="off"
                                   v-model="modelResponse.colPeople" class="input-profile-info mt-1">
                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                        </label>
                    </ValidationProvider>
                </div>
                <div class="col-lg-9">
                    <label class="d-none d-lg-block w-100 caption select-wrapper mb-xl-2">
                        Стоимость за человека <span>в сутки с питанием </span>
                        <div class="d-flex">
                            <ValidationProvider
                                :rules="`required|numeric|max:6|minPrice:${modelResponse.priceForPerson}|positive`"
                                v-slot="{ failed, errors }">
                                <input type="text" name="search-object" placeholder="1200"
                                       v-model="modelResponse.minPrice" autocomplete="off"
                                       class="input-profile-info text-center mt-1" :class="{ 'is-invalid': failed }"
                                       style="margin-right: 1rem" maxlength="6" pattern="^([0-9]+)$">
                                <span class="error-valid">{{ errors[0] }}</span>
                            </ValidationProvider>
                            <div class="d-flex align-items-center w-100">
                                <slider class="ml-3 w-100" v-model="value" v-bind="value" :max="8000"
                                        :tooltips="false"
                                        @change="changeSlider" style="background-color: transparent;" :step="100"/>
                            </div>
                            <ValidationProvider
                                :rules="`required|numeric|max:6|maxPrice:${modelResponse.minPrice}|positive`"
                                v-slot="{ failed, errors }">
                                <input type="text" name="search-object" placeholder="4000"
                                       v-model="modelResponse.priceForPerson"
                                       class="input-profile-info text-center mt-1" :class="{ 'is-invalid': failed }"
                                       style="margin-left:1rem" autocomplete="off" maxlength="6"
                                       pattern="^([0-9]+)$">
                                <span class="error-valid">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                    </label>
                    <div class="col-lg-9 d-block d-lg-none">
                        <div class="d-flex justify-content-between">
                            <p style="color: #32325D; font-size: calc(0.75rem)">1200</p>
                            <p style="color: #32325D; font-size: calc(0.75rem)">8000</p>
                        </div>
                        <div class="d-flex">
                            <input class="w-100" type="range" multiple value="0,100"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row no-gutters blockPrice">
            <h2 class="caption">Комментарий</h2>
            <div class="col-lg-12 label_radio">
                <ValidationProvider rules="required" v-slot="{ failed, errors }">
                    <textarea name="comment" id="comment" class="w-100" v-model="modelResponse.comment"
                              style="color: #32325D;" :class="{ 'is-invalid': failed }"/>
                    <span class="error-valid">{{ errors[0] }}</span>
                </ValidationProvider>
            </div>
        </div>
        <div class="row blockFooter">
            <slot name="more-block"></slot>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import Slider from '@vueform/slider/dist/slider.vue2.js';
import VSelect from "@alfsnd/vue-bootstrap-select";

export default {
    name: "Response",
    components: {Slider, VSelect},
    props: {
        sendRequest: {
            type: Boolean,
            default: false,
        },
        editResponse: {
            default: () => {
            }
        },
        isSendStorage: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            modelResponse: {
                infrastructures: [], additionsTender: [], typeFoods: [], type_sports: [], id: null,
                startDate: null, endDate: null, sportObject_id: null, colPeople: '', accred: false, spreadDate: '',
                minPrice: '', priceForPerson: '', comment: '', city_id: null, infoCompany_id: '', createDate: '',
                user_id: user.id, dateResponse: '', tender_id: '', city_name: null
            }, value: [800, 1200],
            errorsTender: {checkBoxes: 'выберите несколько вариантов'}, allSportObjects: [], temp_sports: [],
            temp_region: null, selSports: null, _isSettingModelResponse: null
        }
    },
    computed: {
        ...mapGetters({
            infoCompanies: 'AllInfoCompanies',
            allInfrastructures: 'AllRequirementInfrastructures',
            responseData: 'responseData',
        }),
        user() {
            return window.user;
        },
        getInfoId() {
            if (this.infoCompanies) return this.infoCompanies.id;
        },
        nowDate() {
            return this.addDays(new Date(), 1).toISOString().slice(0, 10);
        },
        minEndDate() {
            return this.addDays(this.modelResponse.startDate, 1).toISOString().slice(0, 10)
        }
    },
    methods: {
        syncSports() {
            this.temp_sports = this.modelResponse.type_sports;
        },
        addSportType(type) {
            if (!this.modelResponse.type_sports.some(data => data.id === type.id)) {
                this.modelResponse.type_sports.push({
                    'id': type.id,
                    'title': type.title
                });
            }
            this.$nextTick(() => {
                this.selSports = null;
            });
        },
        getCity_id(city) {
            this.modelResponse.city_id = city.id;
        },
        addDays(date, days) {
            const newDate = new Date(date.valueOf());
            newDate.setDate(newDate.getDate() + days);
            return newDate;
        },
        setEndDate() {
            this.modelResponse.endDate = this.addDays(this.modelResponse.startDate, 1).toISOString().slice(0, 10);
        },
        changeSlider(value) {
            this.modelResponse.minPrice = value[0];
            this.modelResponse.priceForPerson = value[1];
        },
        updateValue() {
            const {minPrice, priceForPerson} = this.modelResponse;
            if (minPrice !== "" && priceForPerson !== "") {
                this.value = [Number(minPrice), Number(priceForPerson)];
            }
        }
    },
    async created() {
        const date = new Date();
        this.modelResponse.startDate = this.addDays(date, 1).toISOString().slice(0, 10);
        this.setEndDate();

        this.modelResponse.spreadDate = "3 дня";

        await this.$store.dispatch("getDataResponse");
        this.modelResponse.city_name = this.responseData.cities[0].title;

        this.modelResponse.typeFoods.push({
            id: this.responseData.typeFoods[0].id,
            title: this.responseData.typeFoods[0].title
        });

        this.modelResponse.additionsTender.push({
            id: this.responseData.additions[0].id,
            title: this.responseData.additions[0].title
        });

        await this.$store.dispatch('fetchRequirementInfrastructures');
        this.modelResponse.infrastructures.push({
            id: this.allInfrastructures[0].id,
            title: this.allInfrastructures[0].title
        });

        if (this.$props.editResponse) {
            this.modelResponse = this.$props.editResponse;
            this.modelResponse.startDate = new Date(this.$props.editResponse.fullStartDate).toISOString().slice(0, 10);
            this.modelResponse.endDate = new Date(this.$props.editResponse.fullEndDate).toISOString().slice(0, 10);
            this.modelResponse.city_name = this.modelResponse.city;
        }
    },
    watch: {
        'modelResponse.minPrice': 'updateValue',
        'modelResponse.priceForPerson': 'updateValue',
        sendRequest: {
            handler: function (value) {
                if (value) {
                    const today = new Date();
                    const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                    this.modelResponse.createDate = date;
                    this.modelResponse.infoCompany_id = this.getInfoId;
                    this.modelResponse.spreadDate = this.modelResponse.spreadDate.title ?? this.modelResponse.spreadDate;
                    this.modelResponse.city_id = this.modelResponse.city_name?.id ?? this.responseData.cities.find(f => f.title === this.modelResponse.city_name).id;
                    this.modelResponse.dateResponse = date;
                    this.$emit('sendResponse', this.modelResponse);
                }
            }, deep: true
        },
        modelResponse: {
            handler(newValue) {
                if (this.isSendStorage) {
                    if (!this.user) {
                        const storedTender = localStorage.getItem("temp-tender");
                        if (storedTender && JSON.stringify(newValue) !== storedTender) {
                            localStorage.setItem("temp-tender", JSON.stringify(newValue));
                        } else if (!storedTender) {
                            localStorage.setItem("temp-tender", JSON.stringify(newValue));
                        }
                    } else {
                        const tempTender = JSON.parse(localStorage.getItem("temp-tender"));
                        if (tempTender && JSON.stringify(newValue) !== JSON.stringify(tempTender)) {
                            if (this._isSettingModelResponse) return;

                            this._isSettingModelResponse = true;

                            this.modelResponse = {
                                ...tempTender,
                                user_id: this.user.id,
                                city_name: tempTender.city_name?.title
                            };

                            this.$nextTick(() => {
                                this._isSettingModelResponse = false;
                            });
                        }
                    }
                }
            },
            deep: true
        },
    },

}
</script>

<style scoped>

</style>
