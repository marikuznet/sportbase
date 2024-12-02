<template>
    <transition :name="modalClass">
        <div :class="modalClass">
            <div :class="`tender-backdrop`" @click="closeModal">
                <div :class="[{'simple-modal-scrollable': scrollable}, `${modalClass}-container`]">
                    <div :class="`tender-content`" role="dialog" :aria-labelledby="headerId"
                         :aria-describedby="bodyId" @click.stop>
                        <header style="background-color: white" :id="headerId">
                            <slot :id="bodyId" name="header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="titleTender">
                                        <p class="caption">Редактировать тендерную заявку</p>
                                    </div>
                                    <div class="blockImg">
                                        <img @click="closeModal" style="cursor:pointer" src="/icons/stages/cancel.svg"
                                             alt="">
                                    </div>
                                </div>
                            </slot>
                        </header>
                        <section>
                            <slot name="body">
                                <ValidationObserver ref="observer" v-slot="{invalid}" tag="form" @submit.prevent="onSave">
                                    <div class="row typeSport">
                                        <div class="col-lg-4 col-sm-12">
                                            <ValidationProvider :rules="'required|vSelectLength'"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <input type="text" hidden v-model="tenderModel.type_sports.length">
                                                <label class="w-100 caption select-wrapper mb-xl-2 pt-3 p-0"
                                                       for="">Вид спорта
                                                    <span v-if="tenderModel.type_sports.length === 0"
                                                          class="text-danger">выберите несколько значений</span>
                                                    <v-select id="typeSport"
                                                              :class="{'is-invalid': tenderModel.type_sports.length === 0}"
                                                              labelTitle="Выберите вид спорта"
                                                              textProp="title" valueProp="id"
                                                              class="selectpicker mt-1 h-auto" required
                                                              :options="allSportTypes"
                                                              @input="addSportType">
                                                    </v-select>
                                                </label>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-12">
                                            <div class="sport-type-list d-flex">
                                                <div v-for="(item, index) in tenderModel.type_sports" :key="index"
                                                     class="align-items-center d-flex justify-content-center sport-type-list__item">
                                                    <h6 class="m-0" style="min-width: max-content">{{ item.title }}</h6>
                                                    <span @click="tenderModel.type_sports.splice(index, 1)">
                                                        <i style="color:red;" class="fa fa-window-close ml-2"/>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row requirementsInfrastructure">
                                        <div class="col-lg-12">
                                            <ValidationProvider rules="required|vSelectLength">
                                                <input type="text" hidden v-model="tenderModel.infrastructures.length">
                                            </ValidationProvider>
                                            <label class="caption sub-caption mb-2">Требования к инфраструктуре
                                                <span v-if="tenderModel.infrastructures.length === 0"
                                                      :class="'text-danger'">выберите несколько вариантов</span>
                                            </label>
                                            <div class="col-lg-12 p-0">
                                                <div id="collapseSport" aria-labelledby="headingSport"
                                                     class="accordion-collapse collapse show">
                                                    <div
                                                        class="sport-list d-flex flex-wrap justify-content-between">
                                                        <div
                                                            class="label-checkbox-wrapp sport-list__item"
                                                            v-for="(item, index) in allInfrastructures">
                                                            <input type="checkbox" name="checkbox-sport"
                                                                   v-model="tenderModel.infrastructures"
                                                                   :id="'sport-'+index"
                                                                   class="label-checkbox-wrapp__checkbox d-none"
                                                                   :value="{id: item.id, title: item.title}">
                                                            <label :for="'sport-'+index"
                                                                   class="label-checkbox-wrapp__label">{{
                                                                    item.title
                                                                }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row requirementsInfrastructure" v-if="false">
                                        <div class="col-lg-12">
                                            <p class="caption sub-caption pb-2.notification .text__Notification ">
                                                Наличие аккредитации
                                            </p>
                                            <div class="col-lg-12 p-0">
                                                <div id="collapseАccreditation"
                                                     class="accordion-collapse collapse show"
                                                     aria-labelledby="headingАccreditation"
                                                     data-bs-parent="#accordionАccreditation">
                                                    <div class="d-flex">
                                                        <div
                                                            class="label-radio-wrapp accreditation-list__item">
                                                            <input class="label-radio-wrapp__radio d-none"
                                                                   type="radio"
                                                                   v-model="tenderModel.accred"
                                                                   :value="true"
                                                                   name="accreditation-type"
                                                                   id="accreditation-yes" checked>
                                                            <label class="label-radio-wrapp__label"
                                                                   for="accreditation-yes">Да</label>
                                                        </div>
                                                        <div
                                                            class="label-radio-wrapp accreditation-list__item">
                                                            <input class="label-radio-wrapp__radio d-none"
                                                                   type="radio"
                                                                   v-model="tenderModel.accred"
                                                                   :value="false"
                                                                   name="accreditation-type"
                                                                   id="accreditation-no">
                                                            <label class="label-radio-wrapp__label"
                                                                   for="accreditation-no">Нет</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row regionEvent d-flex justify-content-between">
                                        <div class="col-lg-5 leftPart d-flex">
                                            <label class="w-100 caption select-wrapper mb-xl-2 pr-2 p-0"
                                                   for="">Регион мероприятия
                                                <span v-if="city_name == null"
                                                      style="color: rgb(243, 122, 138)">*</span>
                                                <v-select id="region" :class="{'is-invalid': city_name == null}"
                                                          class="selectpicker input-label mt-2"
                                                          :options="allCities" v-model="city_name"
                                                          textProp="title" valueProp="id" @input="getCity_id"
                                                          labelTitle="Выберите регион проведения">
                                                </v-select>
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <label class="w-100 caption select-wrapper mb-xl-2"
                                                       for="">Дата начала
                                                    <input type="date" name="search-object"
                                                           placeholder="Укажите дату" required
                                                           v-model="tenderModel.startDate" @change="setEndDate"
                                                           class="input-profile-info input-label mt-1"
                                                           :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }">
                                                </label>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-lg-5 rightPart d-flex">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <label class="w-100 caption select-wrapper mb-xl-2 pr-2"
                                                       for="">Дата окончания
                                                    <input type="date" name="search-object"
                                                           placeholder="Укажите дату"
                                                           :min="tenderModel.startDate" required
                                                           v-model="tenderModel.endDate"
                                                           class="input-profile-info input-label mt-1"
                                                           :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }">
                                                </label>
                                            </ValidationProvider>
                                            <label class="w-100 caption select-wrapper mb-xl-2" for="">Разброс
                                                даты
                                                <v-select labelTitle="+3 дня" textProp="title"
                                                          value="+3 дня"
                                                          v-model="tenderModel.spreadDate"
                                                          valueProp="id" required
                                                          class="selectpicker input-label mt-1">
                                                </v-select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row typeFood">
                                        <div class="col-lg-12">
                                            <ValidationProvider rules="required|vSelectLength">
                                                <input type="text" hidden v-model="tenderModel.typeFoods.length">
                                            </ValidationProvider>
                                            <label class="caption sub-caption mb-2">Тип питания
                                                <span v-if="tenderModel.typeFoods.length === 0"
                                                      :class="'text-danger'">выберите несколько вариантов</span>
                                            </label>
                                            <div class="col-lg-12 p-0">
                                                <div class="col-lg-12 p-0 d-flex label_radio">
                                                    <div class="label-radio-wrapp food-list__item"
                                                         v-for="(item, index) in allTypeFoods">
                                                        <input class="label-radio-wrapp__radio d-none"
                                                               type="checkbox" name="food"
                                                               :value="{id: item.id, title: item.title}"
                                                               v-model="tenderModel.typeFoods" :id="'food-'+item.id">
                                                        <label class="label-radio-wrapp__label"
                                                               :for="'food-'+item.id">
                                                            {{ item.title }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row dopServices">
                                        <div class="col-lg-12">
                                            <ValidationProvider rules="required|vSelectLength">
                                                <input type="text" hidden v-model="tenderModel.additionsTender.length">
                                            </ValidationProvider>
                                            <label class="caption">Дополнительные услуги
                                                <span v-if="tenderModel.additionsTender.length === 0"
                                                      :class="'text-danger'">выберите несколько вариантов</span>
                                            </label>
                                            <div class="col-lg-12 p-0 d-flex label_radio">
                                                <div class="label-radio-wrapp type-list__item"
                                                     v-for="(item, index) in allAdditionTender">
                                                    <input class="label-radio-wrapp__radio d-none"
                                                           type="checkbox"
                                                           v-model="tenderModel.additionsTender"
                                                           name="addition" :id="'addition-'+item.id"
                                                           :value="{id: item.id, title: item.title}"
                                                           :checked="index == 0">
                                                    <label class="label-radio-wrapp__label"
                                                           :for="'addition-'+item.id">
                                                        {{ item.title }}
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row blockPrice">
                                        <div class="col-12 col-people">
                                            <div class="row">
                                                <div class="col-lg-3 col-6">
                                                    <ValidationProvider rules="required|numeric|max:6"
                                                                        v-slot="{ valid, errors, dirty, invalid }">
                                                        <label class="w-100 caption select-wrapper mb-xl-2 p-0"
                                                               for="">Кол-во человек
                                                            <input type="text" name="search-object"
                                                                   maxlength="4" pattern="^([0-9]+)$"
                                                                   placeholder="30" required
                                                                   v-model="tenderModel.colPeople"
                                                                   :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                                   class="input-profile-info mt-1 text-center"
                                                                   autocomplete="off">
                                                        </label>
                                                    </ValidationProvider>
                                                </div>
                                                <div class="col-lg-9">
                                                    <label
                                                        class="d-none d-lg-block w-100 caption select-wrapper mb-xl-2"
                                                        for="">Стоимость за человка
                                                        <span>в сутки с питанием</span>
                                                        <div class="d-flex">
                                                            <ValidationProvider
                                                                rules="required|numeric|max:6"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                                <input type="text" name="search-object"
                                                                       placeholder="1200"
                                                                       v-model="tenderModel.minPrice"
                                                                       required autocomplete="off"
                                                                       class="input-profile-info text-center mt-1"
                                                                       :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                                       style="margin-right: 1rem"
                                                                       maxlength="6" pattern="^([0-9]+)$">
                                                            </ValidationProvider>
                                                            <div class="d-flex align-items-center w-100">
                                                                <Slider class="ml-3 w-100" v-model="value"
                                                                        v-bind="value" :max="8000" :tooltips="false"
                                                                        @update="change_values"
                                                                        style="background-color: transparent;"
                                                                        :step="100"
                                                                ></Slider>
                                                            </div>
                                                            <ValidationProvider
                                                                rules="required|numeric|max:6"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                                <input type="text" name="search-object"
                                                                       placeholder="4000"
                                                                       required v-model="tenderModel.priceForPerson"
                                                                       class="input-profile-info text-center mt-1"
                                                                       :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                                       style="margin-left:1rem"
                                                                       autocomplete="off"
                                                                       maxlength="6" pattern="^([0-9]+)$">
                                                            </ValidationProvider>
                                                        </div>
                                                    </label>
                                                    <div class="col-lg-9 d-block d-lg-none">
                                                        <div class="d-flex justify-content-between">
                                                            <p style="color: #32325D; font-size: calc(0.75rem)">
                                                                1200</p>
                                                            <p style="color: #32325D; font-size: calc(0.75rem)">
                                                                8000</p>
                                                        </div>
                                                        <div class="d-flex">
                                                            <input class="w-100" type="range" multiple value="0,100"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row blockPrice">
                                        <label class="caption col-12">Комментарий</label>
                                        <div class="col-lg-12 label_radio">
                                            <ValidationProvider rules="required"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <textarea name="comment" id="comment" class="w-100 form-control"
                                                          v-model="tenderModel.comment"
                                                          style="color: #32325D;" required rows="5"
                                                          :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"></textarea>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                    <div class="buttonSend row d-flex justify-content-center">
                                        <button type="submit"
                                                class="top__button button button-fill d-block mx-auto btn btn-success
                                                                my-0 my-lg-3 mb-2 p-lg-4 p-3 d-flex justify-content-around font-weight-bold"
                                                style="width: 390px; position: absolute; bottom: -7%;">
                                            Сохранить
                                        </button>
                                    </div>
                                </ValidationObserver>
                            </slot>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import VSelect from "@alfsnd/vue-bootstrap-select";
import {mapActions, mapGetters} from 'vuex';
import Slider from '@vueform/slider/dist/slider.vue2.js';

export default {
    name: 'PAModal',
    props: {
        id: {
            type: Number,
            default: null,
        },
        show: {
            type: Boolean,
            default: false,
        },
        scrollable: {
            type: Boolean,
            default: false,
        },
        headerId: {
            type: String,
            required: true,
            default: null,
        },
        bodyId: {
            type: String,
            required: true,
            default: null,
        },
        modalClass: {
            type: String,
            default: 'simple-modal',
        },
    },
    data() {
        return {
            tenderModel: {
                id: null, infrastructures: [], additionsTender: [], typeFoods: [], type_sports: [],
                startDate: new Date().toISOString().slice(0, 10),
                endDate: new Date(Date.now() + (24 * 60 * 60 * 1000)).toISOString().slice(0, 10),
                colPeople: '', accred: false, spreadDate: '', minPrice: '', priceForPerson: '', comment: '',
                city_id: null, infoCompany_id: '', createDate: '', user_id: user.id, sportObject_id: null,
            }, city_name: '', value: [1200, 4000], showTender: false,
        }
    },
    async mounted() {
        const actions = [
            this.$store.dispatch('fetchSportTypes'),
            this.$store.dispatch('fetchRequirementInfrastructures'),
            this.$store.dispatch('fetchCities'),
            this.$store.dispatch('fetchTypeFoods'),
            this.$store.dispatch('fetchAdditionTender'),
        ];
        await Promise.all(actions);

        window.addEventListener('keydown', this.escCloseModal);
        //this.change_values();

        this.showTender = true;
        const tender = await this.$store.dispatch("getTenderApplicationById", {id: this.$props.id});
        this.tenderModel.id = this.$props.id;
        this.tenderModel.type_sports = tender.type_sports;
        this.tenderModel.infrastructures = tender.infrastructures;
        this.tenderModel.typeFoods = tender.typeFoods;
        this.tenderModel.additionsTender = tender.additionsTender;
        this.tenderModel.startDate = new Date(tender.fullStartDate).toISOString().slice(0, 10);
        this.tenderModel.endDate = new Date(tender.fullEndDate).toISOString().slice(0, 10);
        this.tenderModel.colPeople = tender.colPeople;
        this.tenderModel.spreadDate = tender.spreadDate;
        this.tenderModel.minPrice = tender.minPrice;
        this.tenderModel.accred = tender.accred;
        this.tenderModel.priceForPerson = tender.priceForPerson;

        this.tenderModel.comment = tender.comment;
        this.city_name = tender.city;
        this.tenderModel.tender_id = tender.id;
    },
    destroy() {
        window.removeEventListener('keydown', this.escCloseModal);
    },
    watch: {
        allInfrastructures: {
            handler: function (newValue) {
                this.tenderModel.infrastructures.push({id: newValue[0].id, title: newValue[0].title});
            }, deep: true
        },
        allTypeFoods: {
            handler: function (newValue) {
                this.tenderModel.typeFoods.push({id: newValue[0].id, title: newValue[0].title});
            }, deep: true
        },
        allAdditionTender: {
            handler: function (newValue) {
                this.tenderModel.additionsTender.push({id: newValue[0].id, title: newValue[0].title});
            }, deep: true
        },
    },
    methods: {
        closeModal() {
            this.showTender = false;
            this.$emit('close');
        },
        escCloseModal(e) {
            if (this.show && e.key === 'Escape') {
                this.closeModal();
            }
        },
        addSportType(allSportTypes) {
            if (!this.tenderModel.type_sports.some(data => data.id === allSportTypes.id)) {
                this.tenderModel.type_sports.push({
                    'id': allSportTypes.id,
                    'title': allSportTypes.title
                });
            }
        },
        getCity_id(allCities) {
            this.tenderModel.city_id = allCities.id;
        },
        change_values() {
            this.tenderModel.minPrice = this.value[0];
            this.tenderModel.priceForPerson = this.value[1];
        },
        setEndDate() {
            let startDate = new Date(this.direct.startDate);
            this.direct.endDate = new Date(startDate + (2 * 24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
        },
        async onSave() {
            this.tenderModel.city_id = this.allCities.find(item => item.title === this.city_name).id;

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
                    this.$store.dispatch("updateTender", this.tenderModel);
                    this.$store.dispatch("getTenderApplicationById", {id: this.$props.id})
                    this.closeModal();
                }
            });
        }
    },
    computed: {
        ...mapGetters({
            allInfrastructures: 'AllRequirementInfrastructures',
            allAdditionTender: 'AllAdditionTender',
            allCities: 'AllCities',
            allTypeFoods: 'AllTypeFoods',
            getTender: "GetTenderId",
            allSportTypes: "AllSportTypes",
        }),
    },
    components: {
        VSelect, Slider
    }
};
</script>
<style>
#typeSport.is-invalid .v-select-toggle,
#region.is-invalid .v-select-toggle {
    border: 1px solid #e45868 !important;
}
</style>

<style scoped>
#typeSport.is-invalid,
#region.is-invalid {
    border: none !important;
}

.select-wrapper .selectpicker {
    height: 55px;
}

.label-checkbox-wrapp__checkbox:checked + .label-checkbox-wrapp__label,
.label-radio-wrapp__radio:checked + .label-radio-wrapp__label {
    color: white;
    background-color: #6283e5;
    border-color: #6283e5;
}

.label-radio-wrapp:not(:last-child) {
    margin-right: 0.5rem;
}

.label-radio-wrapp__label {
    height: 55px;
    font-size: calc(1.2em);
}

.label-checkbox-wrapp__label {
    padding: 0.7em 1.6em;
    color: #2d297d;
    border: 2px solid #bac4df;
    cursor: pointer;
    border-radius: 10px;
    font-size: calc(1.2em);
    -webkit-transition: 0.3s;
    transition: 0.3s;
}

.dopServices .label-radio-wrapp__label, .typeFood .label-radio-wrapp__label {
    font-weight: 400;
    font-size: calc(1.187em);
}

.label-radio-wrapp__label {
    padding: 0.7em 1.6em;
    color: #2d297d;
    border: 2px solid #bac4df;
    cursor: pointer;
    border-radius: 10px;
    font-size: 22px;
    -webkit-transition: 0.3s;
    transition: 0.3s;
    font-weight: 700;
    width: 100%;
    text-align: center;
}
</style>
