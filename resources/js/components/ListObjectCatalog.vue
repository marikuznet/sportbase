<template>
    <div>
        <div class="content-objects-list d-flex align-content-start flex-wrap p-4 pe-0">
            <div id="overlay" v-show="showNotify == true">
                <div class="modal-dialog" style="margin-top: 20%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">Уведомление</h3>
                            <button type="button" class="close" @click="showNotify = false">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <p style="font-size: calc(1.25rem); color: #0B3158"
                               class="text-center mb-4">
                                Отправлять Заявки и отклики могут только зарегистрированные и
                                авторизованные ЗАКАЗЧИКИ
                            </p>
                            <div class="d-flex">
                                <button class="w-100 btn btn-yes" @click="authUser">
                                    Авторизоваться
                                </button>
                                <button type="button" class="w-100 btn btn-no" @click="authRegister">
                                    <ins>ЗАРЕГИСТРИРОВАТЬСЯ</ins>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-objects-list__item object-block object-block-border me-3 mb-3 pb-0 w-100"
                 v-for="item in paginatedSportObjects">
                <div v-if="item.hasVIP" class="object-block__vip-label">vip</div>
                <div class="object-block__fast-forward-label" v-if="item.hasHighlightion == 1">
                    <img src="/icons/sportObjects/fast-forward.svg" alt="fast">
                </div>
                <div class="d-flex w-100" style="height: 340px">
                    <div class="object-block__img w-50 h-100" :class="{'classPromotion': item.hasPromotion}">
                        <img class="h-100" :src="'/storage/listings/objects/'+ item.id + '/' + item.image[0]" alt="3">
                    </div>
                    <div class="border-0 b-a-0 h-100 object-block__content position-relative shortInformation">
                        <div class="row top__title p-0">
                            <div class="col-lg-11 shortInformation__objectName ">
                                <p class="overflow-hidden fs-3 fs-lg-1 fw-bold text-uppercase">
                                    {{ item.title }}
                                </p>
                            </div>
                            <div class=" col-1">
                                <div class="object-block-favorites-wrapp">
                                    <input class="object-block-favorites__checkbox" type="checkbox"
                                           :value="item.id" @click="addFavourite(item)" :checked="isFavourite(item)"
                                           :name="'favorites-heart-obj-' + item.id"
                                           :id="'favorites-heart-obj-' + item.id">
                                    <label class="object-block-favorites__label"
                                           :for="'favorites-heart-obj-' + item.id">
                                        <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.0193 1.51891C13.832 0.483103 11.9106 2.06844 10.698
                                                        3.47532C10.1996 4.05355 9.2293 3.98927 8.7741 3.37645C7.62889
                                                        1.83468 5.62652 0.11665 3.16253 1.51891C-0.384959 3.5378 1.16251
                                                        7.51891 2.66253 9.51892C4.39799 11.8328 7.65041 14.4661 9.02416
                                                        15.5325C9.3952 15.8205 9.91428 15.7996 10.2743 15.498C11.8057
                                                        14.2151 14.4246 12.1044 16.1625 10.0189C18.9546 6.6684 19.5193
                                                        3.1764 16.0193 1.51891Z"
                                                stroke="#B7C2CC" stroke-width="3"/>
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex top__comment py-3 px-0 justify-content-between">
                            <div class=" top__comment__country">
                                <p class="top__comment__country__name  country__name d-inline-block fs-5">
                                    {{ item.country }}, {{ item.city }}
                                </p>
                            </div>

                            <div class="row">
                                <div class="rating-messages d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div class="rating align-items-center col-auto d-flex">
                                            <div class="d-flex">
                                                <star-rating :increment="0.5" :starSize="16"
                                                             :activeColor="'#F5AE67'"
                                                             :showRating="false"
                                                             :rating="item.average_rating"
                                                             :read-only="true"></star-rating>
                                                <div>
                                                    <p style="font-size: calc(1rem); color: #0B3158">
                                                        {{ item.average_rating | formatRating }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto top__comment__comments px-2">
                                        <p class="top__comment__comments__text comment">{{ item.reviews_count }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="object-block__descr flex-grow-0">
                            {{ item.description.replace(/<\/?[^>]+(>|$)/g, "").replace(/\.([^\s])/g, '. $1') }}
                        </div>
                        <div class="bottom-0 position-absolute price px-5 px-lg-2 py-4 row w-100">
                            <div class="col-12 col-xl-6 price__text px-0">
                                <p class="price__text__top fs-5 fw-bold">Цены от</p>
                                <p class="comment fs-5">
                                    <span class="fs-1 fw-bold">от {{ item.accm_minPrice }} ₽</span>
                                    в сутки
                                </p>
                            </div>

                            <response-tender v-show="user.role == 2 && indexSport == item.id"
                                             :scrollable="true"
                                             header-id="modalHeader"
                                             body-id="modalBody"
                                             @close="indexSport = null">
                                <template #header>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="titleTender">
                                            <p class="caption">Запросить расчет объекта</p>
                                        </div>
                                        <div class="blockImg">
                                            <img
                                                @click="indexSport = null"
                                                style="cursor:pointer"
                                                src="/icons/stages/cancel.svg" alt="">
                                        </div>
                                    </div>

                                </template>
                                <template #body class="blockResponseBody">
                                    <ValidationObserver v-slot="{invalid}" tag="form" @submit.prevent="onSave">
                                        <div class=" titleObject d-flex justify-content-between mt-4 p-4"
                                             style="background-color: lightgray;">
                                            <div class="title">
                                                <p class="caption">{{ item.title }}</p>
                                            </div>
                                            <div class="city d-flex">
                                                <div class="img-city">
                                                    <img src="" alt="">
                                                </div>
                                                <p style="color: #6283e5" class="caption fs-5">{{ item.country }},
                                                    {{ item.region }}</p>
                                            </div>
                                            <div class="price">
                                                <span class="fs-5 fw-bold">от 0 €</span>
                                            </div>
                                            <div class="rating-messages d-flex justify-content-between">
                                                <div class="d-flex">
                                                    <div class="rating align-items-center col-auto d-flex">
                                                        <div class="d-flex">
                                                            <img class="pr-1" src="/icons/direct/star.svg">
                                                            <img class="pr-1" src="/icons/direct/star.svg">
                                                            <img class="pr-1" src="/icons/direct/star.svg">
                                                            <img class="pr-1" src="/icons/direct/star.svg">
                                                            <img class="pr-1" src="/icons/direct/star.svg">
                                                            <div>
                                                                <p class="fs-5" style="color: #6283e5">0.0</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row typeSport">
                                            <div class="col-lg-4 col-sm-12">
                                                <ValidationProvider rules="required|rules.select2"
                                                                    v-slot="{ valid, errors, dirty, invalid }">
                                                    <label class="w-100 caption select-wrapper mb-xl-2 pt-3"
                                                           for="">Вид спорта
                                                        <v-select labelTitle="Выберите вид спорта"
                                                                  textProp="title" valueProp="id"
                                                                  class="selectpicker mt-1" required
                                                                  :options="allSportTypes"
                                                                  @input="addSportType">
                                                        </v-select>
                                                    </label>
                                                </ValidationProvider>
                                                <div class="sport-type-list d-flex" style="width: fit-content;">
                                                    <div v-for="(item, index) in direct.type_sports"
                                                         :key="index" class="sport-type-list__item">
                                                        {{ item.title }}
                                                        <span
                                                            @click="direct.type_sports.splice(index, 1)"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row requirementsInfrastructure">
                                            <div class="col-lg-12">
                                                <p class="caption">Требования к инфраструктуре
                                                    <span
                                                        class="additionally">выберите несколько вариантов</span>
                                                </p>
                                                <div class="col-lg-12 p-0">
                                                    <div id="collapseSport" aria-labelledby="headingSport"
                                                         class="accordion-collapse collapse show">
                                                        <div
                                                            class="sport-list d-flex flex-wrap justify-content-between">
                                                            <div
                                                                class="label-checkbox-wrapp sport-list__item"
                                                                v-for="(item, index) in allInfrastructures">
                                                                <input type="checkbox" name="checkbox-sport"
                                                                       v-model="direct.infrastructures"
                                                                       :id="'sport-'+index"
                                                                       class="label-checkbox-wrapp__checkbox"
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
                                        <div class="row requirementsInfrastructure">
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
                                                                <input class="label-radio-wrapp__radio"
                                                                       type="radio"
                                                                       v-model="direct.accred"
                                                                       :value="true"
                                                                       name="accreditation-type"
                                                                       id="accreditation-yes" checked>
                                                                <label class="label-radio-wrapp__label"
                                                                       for="accreditation-yes">Да</label>
                                                            </div>
                                                            <div
                                                                class="label-radio-wrapp accreditation-list__item">
                                                                <input class="label-radio-wrapp__radio"
                                                                       type="radio"
                                                                       v-model="direct.accred"
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
                                                <label class="w-100 caption select-wrapper mb-xl-2 pr-2"
                                                       for="">Регион мероприятия
                                                    <v-select class="selectpicker input-label mt-2"
                                                              :options="allCities"
                                                              textProp="title" valueProp="id"
                                                              @input="getCity_id"
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
                                                               placeholder="Укажите дату"
                                                               :min="nowDate" required
                                                               v-model="direct.startDate" @change="setEndDate"
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
                                                               :min="direct.startDate" required
                                                               v-model="direct.endDate"
                                                               class="input-profile-info input-label mt-1"
                                                               :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }">
                                                    </label>
                                                </ValidationProvider>
                                                <label class="w-100 caption select-wrapper mb-xl-2" for="">Разброс
                                                    даты
                                                    <v-select labelTitle="+3 дня" textProp="title"
                                                              value="+3 дня"
                                                              v-model="direct.spreadDate"
                                                              valueProp="id" required
                                                              class="selectpicker input-label mt-1">
                                                    </v-select>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row typeFood">
                                            <div class="col-lg-12">
                                                <p class="caption sub-caption mb-2">Тип питания
                                                    <span class="additionally">выберите несколько вариантов</span></p>
                                                <div class="col-lg-12 p-0">
                                                    <div class="col-lg-12 p-0 d-flex label_radio">
                                                        <div class="label-radio-wrapp food-list__item"
                                                             v-for="(item, index) in allTypeFoods">
                                                            <input class="label-radio-wrapp__radio d-none"
                                                                   type="checkbox"
                                                                   name="food" :value="{id: item.id, title: item.title}"
                                                                   v-model="direct.typeFoods" :id="'food-'+item.id">
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
                                                <p class="caption">Дополнительные услуги
                                                    <span class="additionally">выберите несколько вариантов</span>
                                                </p>
                                                <div class="col-lg-12 p-0 d-flex label_radio">
                                                    <div class="label-radio-wrapp type-list__item"
                                                         v-for="(item, index) in allAdditionTender">
                                                        <input class="label-radio-wrapp__radio"
                                                               type="checkbox"
                                                               v-model="direct.additionsTender"
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
                                            <div class="row col-people">
                                                <div class="col-lg-3 col-6">
                                                    <ValidationProvider rules="required|numeric|max:6"
                                                                        v-slot="{ valid, errors, dirty, invalid }">
                                                        <label class="w-100 caption select-wrapper mb-xl-2"
                                                               for="">Кол-во человек
                                                            <input type="text" name="search-object"
                                                                   maxlength="4" pattern="^([0-9]+)$"
                                                                   placeholder="30" required
                                                                   v-model="direct.colPeople"
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
                                                                       v-model="direct.minPrice"
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
                                                                       required v-model="direct.priceForPerson"
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
                                        <div class="row blockPrice">
                                            <p class="caption">Комментарий</p>
                                            <div class="col-lg-12 label_radio">
                                                <ValidationProvider rules="required"
                                                                    v-slot="{ valid, errors, dirty, invalid }">
                                    <textarea name="comment" id="comment" class="w-100" v-model="direct.comment"
                                              style="color: #32325D;" required
                                              :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"></textarea>
                                                </ValidationProvider>
                                            </div>
                                        </div>
                                        <div data-v-3a2741fb=""
                                             class="buttonSend row d-flex justify-content-center">
                                            <button type="submit" data-v-3a2741fb=""
                                                    class="top__button button button-fill d-block mx-auto
                                                                my-0 my-lg-3 mb-2 p-lg-4 p-3 d-flex justify-content-around"
                                                    style="width: 390px; position: absolute; bottom: -7%;">
                                                <p data-v-3a2741fb="" class="fw-bold">Отправить заявку</p>
                                            </button>
                                        </div>
                                    </ValidationObserver>
                                </template>
                            </response-tender>

                            <template v-if="user.role !== 3">
                                <div class="col-12 col-xl-6 price__Button px-0 pt-3 pt-lg-0">
                                    <button type="button" @click="getUser(item.id)" style="left: 0"
                                            class="bottom-0 button button-fill price__button rounded-0 shadow w-100">
                                        <p class="price__button__text w-100 text-start position-relative">
                                            Запросить расчет
                                        </p>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions, mapGetters} from "vuex";
import responseTender from './requests/responseTender';
import VSelect from "@alfsnd/vue-bootstrap-select";
import VueCompositionAPI from '@vue/composition-api';
import Slider from '@vueform/slider/dist/slider.vue2.js';
import StarRating from 'vue-star-rating';

Vue.use(VueCompositionAPI);

export default {
    data() {
        return {
            size: 20,                  // Number of items per page
            pageNumber: 1,             // Current page number
            showNotify: false,         // Toggle for showing notifications
            indexSport: null,          // Selected sport object ID
            direct: {
                infrastructures: [],
                additionsTender: [],
                typeFoods: [],
                type_sports: [],
                startDate: new Date().toISOString().slice(0, 10),
                endDate: new Date(Date.now() + 24 * 60 * 60 * 1000).toISOString().slice(0, 10),
                colPeople: '',
                accred: false,
                spreadDate: '',
                minPrice: '',
                priceForPerson: '',
                comment: '',
                city_id: null,
                infoCompany_id: '',
                createDate: '',
                user_id: window.user.id, // Assuming `window.user.id` is set elsewhere
                sportObject_id: null,
            },
            value: [1200, 4000],        // Price range for filtering
            nowDate: new Date().toISOString().slice(0, 10),
            favorites: []              // List of favorite objects
        };
    },
    computed: {
        ...mapGetters({
            allSportObjects: 'AllSportObjects',
            infoCompanies: 'AllInfoCompanies',
            allTypeFoods: 'AllTypeFoods',
            allAdditionTender: 'AllAdditionTender',
            allSportTypes: 'AllSportTypes',
            allInfrastructures: 'AllRequirementInfrastructures',
            allCities: 'AllCities',
        }),
        pages() {
            return Math.ceil(this.allSportObjects.length / this.size);
        },
        paginatedSportObjects() {
            const from = (this.pageNumber - 1) * this.size;
            const to = from + this.size;
            const filtered = this.allSportObjects.filter(p => p.verify === 1 && p.visible === 1);

            return filtered
                .slice()
                .sort((a, b) => (a.id > b.id) ? 1 : -1)
                .sort((a, b) => (a.hasVIP < b.hasVIP) ? 1 : -1)
                .slice(from, to);
        },
        user() {
            return window.user;
        },
        getInfo() {
            return this.infoCompanies.id;
        },
    },
    methods: {
        ...mapActions([
            "fetchTypeFoods",
            "fetchAdditionTender",
            "fetchRequirementInfrastructures",
            "fetchCities",
            "fetchSportTypes",
            "storeDirectApplication"
        ]),
        addFavourite(object) {
            const index = this.favorites.findIndex(item => item.id === object.id);
            if (index !== -1) {
                this.favorites.splice(index, 1);
            } else {
                this.favorites.push(object);
            }
            localStorage.setItem('favorites', JSON.stringify(this.favorites));
        },
        isFavourite(object) {
            return this.favorites.some(item => item.id == object.id);
        },
        pageClick(page) {
            this.pageNumber = page;
        },
        pagePrev() {
            if (this.pageNumber > 1) {
                this.pageNumber--;
            }
        },
        pageNext() {
            if (this.pageNumber < this.pages) {
                this.pageNumber++;
            }
        },
        showFilterBlock() {
            this.showFilters = !this.showFilters;
        },
        addSportType(sportType) {
            if (!this.direct.type_sports.some(data => data.id === sportType.id)) {
                this.direct.type_sports.push({
                    id: sportType.id,
                    title: sportType.title
                });
            }
        },
        authUser() {
            window.location.href = '/auth';
        },
        authRegister() {
            window.location.href = '/auth/registration';
        },
        onSave() {
            const today = new Date();
            const date = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`;

            this.direct.infoCompany_id = this.getInfo;
            this.direct.sportObject_id = this.indexSport;
            this.direct.createDate = date;
            this.direct.spreadDate = '+ 3дня';
            this.direct.dateResponse = date;

            this.storeDirectApplication(this.direct);
            this.indexSport = null;
        },
        getCity_id(city) {
            this.direct.city_id = city.id;
        },
        change_values() {
            this.direct.minPrice = this.value[0];
            this.direct.priceForPerson = this.value[1];
        },
        setEndDate() {
            const startDate = new Date(this.direct.startDate);
            this.direct.endDate = new Date(startDate.getTime() + 2 * 24 * 60 * 60 * 1000).toISOString().slice(0, 10);
        },
        getUser(idObject) {
            this.indexSport = idObject;
            if (this.user.role !== 2) {
                this.showNotify = true;
            }
        }
    },
    watch: {
        allInfrastructures: {
            handler(newValue) {
                if (newValue.length > 0) {
                    this.direct.infrastructures.push({
                        id: newValue[0].id,
                        title: newValue[0].title
                    });
                }
            },
            deep: true
        },
        allTypeFoods: {
            handler(newValue) {
                if (newValue.length > 0) {
                    this.direct.typeFoods.push({
                        id: newValue[0].id,
                        title: newValue[0].title
                    });
                }
            },
            deep: true
        },
        allAdditionTender: {
            handler(newValue) {
                if (newValue.length > 0) {
                    this.direct.additionsTender.push({
                        id: newValue[0].id,
                        title: newValue[0].title
                    });
                }
            },
            deep: true
        }
    },
    created() {
        this.fetchTypeFoods();
        this.fetchAdditionTender();
        this.fetchRequirementInfrastructures();
        this.fetchCities();
        this.fetchSportTypes();
    },
    mounted() {
        const favorites = localStorage.getItem('favorites');
        if (favorites) {
            try {
                this.favorites = JSON.parse(favorites);
            } catch (error) {
                localStorage.removeItem('favorites');
            }
        }
    },
    components: {
        responseTender,
        VSelect,
        Slider,
        StarRating
    }
};
</script>
<style scoped>
.label-checkbox-wrapp__label, .label-radio-wrapp__label {
    height: 55px;
    display: flex;
    align-items: center;
}

.object-block__img {
    border-radius: 10px 0 0 10px;
}
</style>
