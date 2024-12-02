<template>
    <modal :id="id" :class="modal_class">
        <template #header>
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="titleTender">
                    <p class="caption">
                        {{ !edit_mode ? 'Откликнуться на тендерную заявку ' : 'Отклик тендер ' }}
                        №{{ responseTender.id }}</p>
                </div>
                <div class="blockImg close" @click="closeModal" aria-hidden="true" data-toggle="modal">
                    <img aria-hidden="true" style="cursor:pointer" src="/icons/stages/cancel.svg"
                         alt="">
                </div>
            </div>
        </template>
        <template #body>
            <ValidationObserver v-slot="props" ref="observer" tag="form">
                <div class="row typeSport mb-3">
                    <div class="col-lg-4 col-sm-12">
                        <ValidationProvider rules="required|vSelectLength" v-slot="props">
                            <input type="text" hidden v-model="modelRequest.type_sports.length">
                            <label class="w-100 caption select-wrapper mb-xl-2 pt-3" for="typeSport"
                                   @click="syncSports">
                                Вид спорта
                                <v-select id="typeSport" labelTitle="Выберите вид спорта" textProp="title"
                                          class="selectpicker mt-1" style="border: none !important;" valueProp="id"
                                          :options="tendersData.typeSports" @input="addSportType" ref="typeSports"
                                          v-model="selSports"
                                          :class="{'is-invalid': modelRequest.type_sports.length === 0}">
                                </v-select>
                            </label>
                        </ValidationProvider>
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <div class="sport-type-list d-flex">
                            <div v-for="(item, index) in modelRequest.type_sports" :key="index"
                                 class="sport-type-list__item">
                                {{ item.title }}
                                <span @click="modelRequest.type_sports.splice(index, 1)"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row requirementsInfrastructure mb-3">
                    <div class="col-lg-12">
                        <ValidationProvider rules="required" v-slot="props" name="infrastructures">
                            <p class="caption">Требования к инфраструктуре
                                <span class="additionally text-invalid-notif">
                                    {{ props.errors[0] != null ? errorsTender['checkBoxes'] : null }}
                                </span>
                            </p>
                            <div class="col-lg-12 p-0">
                                <div class="infrastructures-list d-flex flex-wrap justify-content-between">
                                    <div class="label-checkbox-wrapp sport-list__item"
                                         v-for="(item, index) in allInfrastructures">
                                        <input type="checkbox" name="infrastructures"
                                               :id="'infrastructure-'+index"
                                               v-model="modelRequest.infrastructures"
                                               class="label-checkbox-wrapp__checkbox"
                                               :value="{id: item.id, title: item.title}">
                                        <label :for="'infrastructure-'+index"
                                               class="label-checkbox-wrapp__label">
                                            {{ item.title }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </ValidationProvider>
                    </div>
                </div>
                <div class="row no-gutters regionEvent d-flex justify-content-between">
                    <div class="col-lg-5 leftPart d-flex">
                        <label class="w-100 caption select-wrapper mb-xl-2 pr-2 p-0" for="region">Регион мероприятия
                            <v-select id="region" v-model="city_name" class="selectpicker input-label"
                                      :options="tendersData.cities"
                                      textProp="title" valueProp="id" @input="getCity_id"
                                      labelTitle="Выберите регион проведения">
                            </v-select>
                        </label>
                    </div>
                    <div class="col-lg-2 pe-lg-0">
                        <ValidationProvider rules="required" v-slot="{ valid, errors, dirty, invalid }">
                            <label class="w-100 caption select-wrapper mb-xl-2">
                                Дата начала
                                <input type="date" name="search-object" placeholder="Укажите дату" :min="nowDate"
                                       @change="setEndDate" v-model="modelRequest.startDate"
                                       class="input-profile-info input-label"
                                       :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }">
                            </label>
                        </ValidationProvider>
                    </div>
                    <div class="col-auto d-flex align-items-center justify-content-center">
                        —
                    </div>
                    <div class="col-lg-2 ps-lg-0">
                        <ValidationProvider rules="required" v-slot="{ valid, errors, dirty, invalid }">
                            <label class="w-100 caption select-wrapper mb-xl-2 pr-2">
                                Дата окончания
                                <input type="date" name="search-object" placeholder="Укажите дату"
                                       :min="minEndDate" v-model="modelRequest.endDate"
                                       class="input-profile-info input-label"
                                       :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }">
                            </label>
                        </ValidationProvider>
                    </div>
                    <div class="col-lg-2">
                        <label class="w-100 caption select-wrapper mb-xl-2" for="dates">Разброс даты
                            <v-select id="dates" v-model="modelRequest.spreadDate" class="selectpicker input-label"
                                      :options="[{id: 1, title: '1 день'},{id: 2, title: '2 дня'},{id: 3, title: '3 дня'}]"
                                      textProp="title" valueProp="id" labelTitle="3 дня">
                            </v-select>
                        </label>
                    </div>
                </div>
                <div class="row typeFood mb-3">
                    <div class="col-lg-12">
                        <ValidationProvider rules="required" v-slot="props">
                            <p class="caption">Тип питания
                                <span class="additionally text-invalid-notif">
                                                {{ props.errors[0] != null ? errorsTender['checkBoxes'] : null }}
                                            </span>
                            </p>
                            <div class="col-lg-12 p-0">
                                <div id="collapseFood" aria-labelledby="headingFoods"
                                     class="accordion-collapse collapse show">
                                    <div class="sport-list d-flex flex-wrap">
                                        <div class="label-checkbox-wrapp foods-list__item mr-2"
                                             v-for="(item, index) in tendersData.typeFoods">
                                            <input type="checkbox" name="checkbox-sport"
                                                   :id="'food-'+item.id" v-model="modelRequest.typeFoods"
                                                   class="label-checkbox-wrapp__checkbox"
                                                   :value="{id: item.id, title: item.title}">
                                            <label :for="'food-'+item.id"
                                                   class="label-checkbox-wrapp__label">
                                                {{ item.title }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ValidationProvider>
                    </div>
                </div>
                <div class="row dopServices mb-3">
                    <div class="col-lg-12">
                        <ValidationProvider rules="required" v-slot="props">
                            <p class="caption">Дополнительные услуги
                                <span class="additionally text-invalid-notif">
                                                {{ props.errors[0] != null ? errorsTender['checkBoxes'] : null }}
                                            </span>
                            </p>
                            <div class="col-lg-12 p-0 d-flex label_radio">
                                <div id="collapseAdditions" aria-labelledby="headingAdditions"
                                     class="accordion-collapse collapse show">
                                    <div class="sport-list d-flex flex-wrap">
                                        <div class="label-checkbox-wrapp foods-list__item mr-2"
                                             v-for="(item, index) in tendersData.additions">
                                            <input type="checkbox" name="checkbox-sport"
                                                   :id="'addition-'+item.id"
                                                   v-model="modelRequest.additionsTender"
                                                   class="label-checkbox-wrapp__checkbox"
                                                   :value="{id: item.id, title: item.title}">
                                            <label :for="'addition-'+item.id"
                                                   class="label-checkbox-wrapp__label">
                                                {{ item.title }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ValidationProvider>
                    </div>
                </div>
                <div class="row blockPrice">
                    <div class="row col-lg-12">
                        <div class="col-lg-3 col-6">
                            <ValidationProvider rules="required|numeric|max:6|positive" v-slot="{ failed, errors }">
                                <label class="w-100 caption select-wrapper mb-xl-2">Кол-во человек
                                    <input type="text" name="search-object" maxlength="4"
                                           :class="{ 'is-invalid': failed }"
                                           pattern="^([0-9]+)$" placeholder="30" autocomplete="off"
                                           v-model="modelRequest.colPeople" class="input-profile-info mt-1">
                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                </label>
                            </ValidationProvider>
                        </div>
                        <div class="col-lg-9">
                            <label class="d-none d-lg-block w-100 caption select-wrapper mb-xl-2">
                                Стоимость за человека <span>в сутки с питанием </span>
                                <div class="d-flex">
                                    <ValidationProvider
                                        :rules="`required|numeric|max:6|minPrice:${modelRequest.priceForPerson}|positive`"
                                        v-slot="{ failed, errors }">
                                        <input type="text" name="search-object" placeholder="1200"
                                               v-model="modelRequest.minPrice" autocomplete="off"
                                               class="input-profile-info text-center mt-1"
                                               :class="{ 'is-invalid': failed }"
                                               style="margin-right: 1rem" maxlength="6" pattern="^([0-9]+)$">
                                        <span class="error-valid">{{ errors[0] }}</span>
                                    </ValidationProvider>
                                    <div class="d-flex align-items-center w-100">
                                        <slider class="ml-3 w-100" v-model="value" v-bind="value" :max="8000"
                                                :tooltips="false"
                                                @change="changeSlider" style="background-color: transparent;"
                                                :step="100"/>
                                    </div>
                                    <ValidationProvider
                                        :rules="`required|numeric|max:6|maxPrice:${modelRequest.minPrice}|positive`"
                                        v-slot="{ failed, errors }">
                                        <input type="text" name="search-object" placeholder="4000"
                                               v-model="modelRequest.priceForPerson"
                                               class="input-profile-info text-center mt-1"
                                               :class="{ 'is-invalid': failed }"
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
                <div class="row blockPrice mb-lg-5 mb-3">
                    <p class="caption col-lg-12">Комментарий</p>
                    <div class="col-lg-12 label_radio">
                        <ValidationProvider rules="required" v-slot="{ failed, errors }">
                                        <textarea name="comment" id="comment" class="w-100"
                                                  v-model="modelRequest.comment" style="color: #32325D;"
                                                  :class="{ 'is-invalid': failed }"/>
                            <span class="error-valid">{{ errors[0] }}</span>
                        </ValidationProvider>
                    </div>
                </div>
                <div class="row">
                    <div v-if="!edit_mode" class="buttonSend col d-flex justify-content-center" style="height: 75px">
                        <button @click="onSave(responseTender.id)" type="button" class="top__button button button-fill d-block mx-auto
                                                                my-0 my-lg-3 mb-2 p-lg-4 p-3 d-flex justify-content-around"
                                style="width: 390px; position: absolute; bottom: -7%;">
                            <p class="fw-bold">Отправить заявку</p>
                        </button>
                    </div>
                    <div v-if="edit_mode" class="row justify-content-center">
                        <modal-notification id="sb-cancel-response" ref="sb-cancel-response"
                                            :title="'Форма согласия'"
                                            @left_action="deleteResponse(responseTender)"
                                            left_button="ДА" right_button="НЕТ"
                                            left_button_class="w-100 btn btn-yes"
                                            right_button_class="w-100 btn btn-no"/>

                        <div class="col-3">
                            <button type="button" data-modal="sb-cancel-response" data-toggle="modal"
                                    data-target="#sb-cancel-response"
                                    class="button text-uppercase cancelResponse_button">
                                Отменить отклик
                            </button>
                        </div>
                        <div class="col-3">
                            <button type="button" @click="editTender(responseTender)"
                                    class="button text-uppercase button-blue">
                                Сохранить
                            </button>
                        </div>
                    </div>
                </div>
            </ValidationObserver>
        </template>
    </modal>
</template>

<script>
import {extend} from 'vee-validate';

import {mapActions, mapGetters} from "vuex";
import VSelect from "@alfsnd/vue-bootstrap-select";
import Slider from '@vueform/slider/dist/slider.vue2.js';
import VSelectItems from "../elements/VSelectItems";
import VueCompositionAPI from '@vue/composition-api';
import moment from "moment";
import Modal from "../Modal";

Vue.use(VueCompositionAPI);

extend('minPrice', {
    params: ['maxPrice'],
    validate(value, {maxPrice}) {
        const tempPrice = maxPrice == '' ? 0 : maxPrice;
        if (tempPrice == 0) return true;
        return Number(tempPrice) > Number(value);
    },
    message: 'неверное значение'
});
extend('maxPrice', {
    params: ['minPrice'],
    validate(value, {minPrice}) {
        const tempPrice = minPrice == '' ? 0 : minPrice;
        if (tempPrice == 0) return true;
        return Number(value) > Number(tempPrice);
    },
    message: 'неверное значение'
});
extend('positive', {
    message: 'значение должно быть больше нуля',
    validate(value) {
        return value > 0;
    }
});

export default {
    name: "ResponseTenderModal",
    props: {
        id: {
            type: String,
            default: 'sb-modal'
        },
        modal_class: {
            type: String,
            default: ''
        },
        getData: {
            type: Function,
            default: null
        },
        responseTender: {
            type: Object,
            default: {}
        },
        edit_mode: {
            type: Boolean,
            default: false
        }
    },
    components: {VSelectItems, VSelect, Slider, Modal},
    data() {
        return {
            modelRequest: {
                infrastructures: [], additionsTender: [], typeFoods: [], type_sports: [], id: null,
                startDate: null, endDate: null,
                colPeople: '', accred: false, spreadDate: '', minPrice: '', priceForPerson: '',
                comment: '', city_id: null, infoCompany_id: '', createDate: '', user_id: user.id,
                dateResponse: '', tender_id: ''
            }, value: [800, 1200], city_name: null,
            errorsTender: {checkBoxes: 'выберите несколько вариантов'}, allSportObjects: [], temp_sports: [],
            temp_region: null, selSports: null
        }
    },
    computed: {
        ...mapGetters({
            infoCompanies: 'AllInfoCompanies',
            allInfrastructures: 'AllRequirementInfrastructures',

            tendersData: 'responseData',
            sport_objects: 'sport_objects_verify'
        }),
        user() {
            return window.user;
        },
        getInfo() {
            if (this.infoCompanies)
                return this.infoCompanies.id;
        },
        nowDate() {
            return this.addDays(new Date(), 1).toISOString().slice(0, 10);
        },
        minEndDate() {
            return this.addDays(this.modelRequest.startDate, 1).toISOString().slice(0, 10)
        }
    },
    methods: {
        syncSports() {
            this.temp_sports = this.modelRequest.type_sports;
        },
        addSportType(type) {
            if (!this.modelRequest.type_sports.some(data => data.id === type.id)) {
                this.modelRequest.type_sports.push({
                    'id': type.id,
                    'title': type.title
                });
            }
            this.$nextTick(() => {
                this.selSports = null;
            });
        },
        addDays(date, days) {
            const newDate = new Date(date.valueOf());
            newDate.setDate(newDate.getDate() + days);
            return newDate;
        },
        closeModal() {
            this.$emit('closeModal');
        },
        addTypeSports(sport) {
            if (!this.modelRequest.type_sports.some(data => data.id === sport.id) && sport.id != 0) {
                this.modelRequest.type_sports.push(sport);
            }
        },
        setEndDate() {
            this.modelRequest.endDate = this.addDays(this.modelRequest.startDate, 1).toISOString().slice(0, 10);
        },
        synchRegion() {
            this.temp_region = this.city_name;
        },
        changeSlider(value) {
            this.modelRequest.minPrice = value[0];
            this.modelRequest.priceForPerson = value[1];
        },
        getCity_id(allCities) {
            this.modelRequest.city_id = allCities.id;
        },
        getCityId() {
            return this.city_name?.id ?? this.tendersData.cities.find(f => f.title === this.city_name).id;
        },
        async getUserSportObjects() {
            await this.$store.dispatch("getUserSportObjects", {id: this.user.id});
            return this.sport_objects;
        },
        getFormattedDate(date) {
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        },
        async onSave(id) {
            const isValid = await this.$refs.observer.validate();
            if (!isValid) {
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
                const cityId = this.getCityId();
                const sportObjects = await this.getUserSportObjects();
                if (sportObjects.length === 0) return;
                this.modelRequest.infoCompany_id = this.getInfo;
                this.modelRequest.createDate = this.getFormattedDate(new Date());
                this.modelRequest.spreadDate = '3 дня';
                this.modelRequest.dateResponse = this.getFormattedDate(new Date());
                this.modelRequest.tender_id = id;
                this.modelRequest.city_id = cityId;

                const responsePromises = sportObjects.map(sportObject => {
                    this.modelRequest.sportObject_id = sportObject.id;
                    this.$store.dispatch("storeResponseTender", this.modelRequest);
                });
                await Promise.all(responsePromises);
                this.$emit('getData');
            }
        },
        async editTender(tender) {
            const isValid = await this.$refs.observer.validate();
            if (!isValid) {
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
                this.modelRequest.spreadDate = '3 дня';
                this.modelRequest.city_id = this.getCityId();
                let responses = null;
                if (tender.responses) {
                    responses = tender.responses?.filter(p => p.user_id == this.user.id && p.archive == 0);
                    const responsePromises = responses.map(response => {
                        this.modelRequest.sportObject_id = response.sportObject.id;
                        this.modelRequest.id = response.id;
                        this.$store.dispatch("updateResponseTender", this.modelRequest);
                    });
                    await Promise.all(responsePromises);
                } else {
                    await this.$store.dispatch("updateResponseTender", this.modelRequest);
                }
                this.$emit('getData');
            }
        },
        async deleteResponse(request) {
            const responses = request.responses.filter(p => p.user_id === this.user.id && p.archive === 0);
            const deletePromises = responses.map(response => this.$store.dispatch("deleteResponseTender", { id: response.id, role: this.user.role }));
            await Promise.all(deletePromises);
            this.$emit('getData');
            $('#' + this.id).modal('toggle');
            $('#sb-cancel-response').modal('toggle');
        },
    },
    async created() {
        this.modelRequest.startDate = this.addDays(new Date(), 1).toISOString().slice(0, 10);
        this.setEndDate();

        await Promise.all([
            this.$store.dispatch("getDataResponse"),
            this.$store.dispatch('fetchRequirementInfrastructures'),
            this.$store.dispatch("getUserSportObjects", { id: this.user.id })
        ]);

        if (this.edit_mode) {
            const response = this.$props.responseTender.responses?.find(item => item.user_id === this.user.id) ?? this.$props.responseTender;
            this.modelRequest = {
                ...response,
                startDate: moment(response.fullStartDate).format('YYYY-MM-DD'),
                endDate: moment(response.fullEndDate).format('YYYY-MM-DD')
            };
            this.city_name = response.city;
            this.syncSports();
            this.synchRegion();
        } else {
            const [firstCity, firstTypeFood, firstAddition, firstInfrastructure] = [
                this.tendersData.cities[0],
                this.tendersData.typeFoods[0],
                this.tendersData.additions[0],
                this.allInfrastructures[0]
            ];
            this.city_name = firstCity.title;
            this.modelRequest.typeFoods.push({ id: firstTypeFood.id, title: firstTypeFood.title });
            this.modelRequest.additionsTender.push({ id: firstAddition.id, title: firstAddition.title });
            this.modelRequest.infrastructures.push({ id: firstInfrastructure.id, title: firstInfrastructure.title });
        }
    },
    watch: {
        'modelRequest.minPrice'(minPrice) {
            if (minPrice !== "") this.value = [Number(minPrice), Number(this.modelRequest.priceForPerson)];
        },
        'modelRequest.priceForPerson'(maxPrice) {
            if (maxPrice !== "") this.value = [Number(this.modelRequest.minPrice), Number(maxPrice)];
        }
    }
}
</script>

<style scoped>
#typeSport.is-invalid .v-select-toggle,
#region.is-invalid .v-select-toggle {
    border: 1px solid #e45868 !important;
}

#typeSport.is-invalid,
#region.is-invalid {
    border: none !important;
}

.is-invalid {
    color: rgb(243, 122, 138) !important;
    border: 1px solid rgb(243, 122, 138) !important;
}

.btn-yes {
    background-color: #6283E5;
    color: white;
    font-weight: bold;
}

.btn-no {
    color: #E45868;
    margin-left: 0.5rem;
}

.cancelResponse_button {
    color: #e45868;
    text-decoration: underline;
}
</style>
