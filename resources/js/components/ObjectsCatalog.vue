<template>
    <div>
        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="sport_objects_loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <div v-if="displayType != 'map'" class="head-block pb-3 pb-lg-5">
            <div class="container px-1">
                <h1 class="head-block__title mx-auto mb-4 fs-1">Каталог спортивных объектов</h1>
                <a href="/create/tender" class="button button-fill mx-auto">
                    <p class="fs-3 me-2 me-lg-4">Заявка на проведение тендера</p>
                    <div class="wrapp-icon">
                        <img src="/icons/list-white.svg" alt="list">
                    </div>
                </a>
                <h3 class="head-block__subtitle mx-auto mt-4 fs-4 p-4 p-lg-0">
                    Если в каталоге нет подходящего объекта - вы можете оставить заявку на проведение тендера
                </h3>
            </div>
        </div>
        <section class="objects-content">
            <div :class="{'container p-0': displayType != 'map'}">
                <div :class="{'row': displayType != 'map'}">
                    <!-- ASIDE -->
                    <aside v-if="displayType != 'map'" class="filters col-12 col-xl-3 p-4 p-xl-3 pb-xl-5 px-5 px-lg-0">
                        <div
                            class="search-block d-flex flex-column flex-column-reverse flex-lg-row flex-lg-row-reverse flex-xl-column pb-0 pb-xl-1 filters__all filters__Menu">
                            <div class="d-flex">
                                <div class="mb-xl-2 me-lg-0 me-3 my-0 my-lg-2 search-wrapper w-100">
                                    <input class="input-search text-left" type="search" name="search-object"
                                           id="search-object" placeholder="Поиск по базе" v-model="filter.search"
                                           autocomplete="off">
                                    <img class="icon" src="/icons/search-icon.svg" alt="search-icon">
                                </div>
                                <button class="borderblock filters__Menu__trigger d-lg-none" type="button"
                                        data-toggle="collapse" data-target="#collapseFilters"
                                        aria-controls="collapseFilters"></button>
                            </div>
                            <div class="available-objects-block w-100 my-2 mb-xl-3 me-3">
                                <div class="available-objects-block__label">Доступные объекты</div>
                                <div class="available-objects-block__count">
                                    {{ sport_objects_statistic.activeSportObjectsCount }}
                                </div>
                            </div>
                        </div>
                        <div id="collapseFilters" class="collapse show filters-block pt-3">
                            <!-- Sport Type Filter -->
                            <filter-select label="Вид спорта" :selected-items="filter.selectedSports_list"
                                           :options="filters.sports" label-title="Выберите вид спорта"></filter-select>

                            <!-- Infrastructure Filter -->
                            <div class="infrastucture accordion filters-block__item py-3" id="accordionInfrastucture">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingInfrastucture">
                                        <button class="accordion-button sb-arrow-rotate-0" type="button"
                                                data-toggle="collapse" data-target="#collapseInfrastucture"
                                                aria-expanded="false" aria-controls="collapseInfrastucture">
                                            Инфраструктура
                                        </button>
                                    </h2>
                                    <transition name="fade">
                                        <div id="collapseInfrastucture" class="accordion-collapse collapse">
                                            <div class="accordion-body infrastucture-list">
                                                <div class="label-checkbox-wrapp services-list__item flex-fill"
                                                     v-for="(item, index) in filters.infrastructures">
                                                    <input class="label-checkbox-wrapp__checkbox" type="checkbox"
                                                           name="checkbox-infrastructures"
                                                           v-model="filter.checkedInfrastructures_list"
                                                           :id="'infrastructure-'+index"
                                                           :value="{id: index, title: item}">
                                                    <label class="label-checkbox-wrapp__label w-100 text-center"
                                                           :for="'infrastructure-'+index">{{ item }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                            </div>

                            <!-- Region Filter -->
                            <filter-select label="Регион объекта" :selected-items="filter.selectedRegions_list"
                                           :options="filters.regions" label-title="Выберите регион"/>

                            <!-- Services Filter -->
                            <div class="services accordion filters-block__item py-3" id="accordionServices">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingServices">
                                        <button class="accordion-button sb-arrow-rotate-0" type="button"
                                                data-toggle="collapse" data-target="#collapseServices"
                                                aria-expanded="false" aria-controls="collapseServices">
                                            Предоставляемые услуги
                                        </button>
                                    </h2>
                                    <transition name="fade">
                                        <div id="collapseServices" class="accordion-collapse collapse">
                                            <div class="accordion-body services-list">
                                                <div class="label-checkbox-wrapp services-list__item flex-fill"
                                                     v-for="item in filters.services">
                                                    <input class="label-checkbox-wrapp__checkbox" type="checkbox"
                                                           name="checkbox-services" :id="'service-'+item.id"
                                                           :value="{id: item.id, title: item.title}"
                                                           v-model="filter.checkedServices_list">
                                                    <label class="label-checkbox-wrapp__label w-100 text-center"
                                                           :for="'service-'+item.id">{{ item.title }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                            </div>

                            <!-- Cost Filter -->
                            <div class="cost accordion filters-block__item py-3" id="accordionCost">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingCost">
                                        <button class="accordion-button sb-arrow-rotate-0" type="button"
                                                data-toggle="collapse" data-target="#collapseCost" aria-expanded="false"
                                                aria-controls="collapseCost">
                                            Стоимость за человека
                                        </button>
                                    </h2>
                                    <transition name="fade">
                                        <div id="collapseCost" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <div class="cost-fields">
                                                    <input class="cost-fields__input cost-fields__item" type="text"
                                                           name="initial-сost" id="initial-сost" placeholder="1000"
                                                           v-model="filter.minPrice" autocomplete="off" maxlength="6"
                                                           @keypress="isLetter($event)">
                                                    <span class="cost-fields__label cost-fields__item">-</span>
                                                    <input class="cost-fields__input cost-fields__item" type="text"
                                                           name="final-сost" id="final-сost" v-model="filter.maxPrice"
                                                           placeholder="8000" autocomplete="off" maxlength="6"
                                                           @keypress="isLetter($event)">
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                            </div>

                            <!-- Reset Filters Button -->
                            <button type="button" @click="resetFilter" class="button button-border mt-4">Сбросить все
                                фильтры
                            </button>
                        </div>

                        <!-- Filters Background Overlay -->
                        <div class="filters-background"></div>
                    </aside>
                    <!-- MAIN -->
                    <main class="content p-0" :class="{'pb-5 col-12 col-xl-9': displayType != 'map'}">
                        <div class="content-header d-none d-lg-flex flex-column flex-lg-row justify-content-between
                        align-items-center-lg p-3 px-4 container">

                            <filter-select v-if="displayType == 'map'" class="w-100" label=""
                                           :selected-items="filter.selectedRegions_list"
                                           :options="filters.regions" label-title="Регион"/>
                            <div v-if="displayType == 'map'" class="ms-lg-4 select-wrapper w-100">
                                <filter-select label="" :selected-items="filter.selectedSports_list"
                                               :options="filters.sports" label-title="Вид спорта"/>
                            </div>
                            <div v-if="displayType == 'map'" class="ms-lg-4 me-lg-4 py-3 search-wrapper w-100">
                                <input class="input-search text-left position-relative" type="search"
                                       name="search-object" style="height: 50px"
                                       id="search-object" placeholder="Поиск по базе" v-model="filter.search"
                                       autocomplete="off">
                                <img class="icon position-absolute" style="top: 30px" src="/icons/search-icon.svg"
                                     alt="search-icon">
                            </div>


                            <div class="content-header__sorting sorting d-flex align-items-center"
                                 v-if="displayType != 'map'">
                                <div class="sorting__label">Сортировать</div>
                                <div class="sorting__select select-wrapper sorting w-100 ms-0 ms-lg-4">
                                    <v-select v-model="filter.sort_sport" class="selectpicker" :options="filters.sports"
                                              labelTitle="Выберите вид спорта" textProp="title" valueProp="id">
                                    </v-select>
                                </div>
                            </div>

                            <div class="align-items-start content-header__display-type d-flex display-type py-3">
                                <div class="label-radio-wrapp display-type__item" @click="displayType='map'">
                                    <input class="label-radio-wrapp__radio" type="radio" name="display-type"
                                           id="display-type-map">
                                    <label class="label-radio-wrapp__label" for="display-type-map">Карта
                                        <svg class="display-map" xmlns="http://www.w3.org/2000/svg" width="18"
                                             height="18" viewBox="0 0 18 18">
                                            <path
                                                d="M17.361,0a.643.643,0,0,0-.288.068L12.2,2.5,6.693.056c-.009,0-.019,0-.029-.008A.643.643,0,0,0,6.589.024.667.667,0,0,0,6.511.008a.956.956,0,0,0-.157,0,.667.667,0,0,0-.078.016A.643.643,0,0,0,6.2.047c-.01,0-.02,0-.029.008L.386,2.627A.643.643,0,0,0,0,3.215V17.357a.643.643,0,0,0,.9.588l5.525-2.456,5.525,2.456c.01,0,.02,0,.03.006a.568.568,0,0,0,.487-.011c.01,0,.022,0,.032-.007l5.143-2.571A.643.643,0,0,0,18,14.786V.643A.643.643,0,0,0,17.361,0ZM5.79,14.368l-4.5,2V3.632l4.5-2Zm5.786,2-4.5-2V1.632l4.5,2Zm5.143-1.979-3.857,1.929V3.612l3.857-1.929Z"
                                                transform="translate(-0.004 0)" fill="#bed0e2"/>
                                        </svg>
                                    </label>
                                </div>
                                <div class="label-radio-wrapp display-type__item" @click="displayType='list'">
                                    <input class="label-radio-wrapp__radio" type="radio" name="display-type"
                                           id="display-type-list">
                                    <label class="label-radio-wrapp__label" for="display-type-list">Список
                                        <svg class="display-list" xmlns="http://www.w3.org/2000/svg" width="18"
                                             height="18" viewBox="0 0 18 18">
                                            <g transform="translate(-1517 -264)">
                                                <rect width="18" height="3" rx="1.5" transform="translate(1517 264)"
                                                      fill="#bed0e2"/>
                                                <rect width="18" height="3" rx="1.5" transform="translate(1517 271.5)"
                                                      fill="#bed0e2"/>
                                                <rect width="18" height="3" rx="1.5" transform="translate(1517 279)"
                                                      fill="#bed0e2"/>
                                            </g>
                                        </svg>
                                    </label>
                                </div>
                                <div class="label-radio-wrapp display-type__item" @click="displayType='block'">
                                    <input class="label-radio-wrapp__radio" type="radio" name="display-type"
                                           id="display-type-blocks" checked>
                                    <label class="label-radio-wrapp__label" for="display-type-blocks">Плиткой
                                        <svg class="display-blocks" xmlns="http://www.w3.org/2000/svg" width="18"
                                             height="18" viewBox="0 0 18 18">
                                            <g transform="translate(-1629 -264)">
                                                <rect width="8" height="8" rx="2" transform="translate(1629 264)"
                                                      fill="#fff"/>
                                                <rect width="8" height="8" rx="2" transform="translate(1629 274)"
                                                      fill="#fff"/>
                                                <rect width="8" height="8" rx="2" transform="translate(1639 264)"
                                                      fill="#fff"/>
                                                <rect width="8" height="8" rx="2" transform="translate(1639 274)"
                                                      fill="#fff"/>
                                            </g>
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <transition name="fade">
                            <div class="px-4" style="padding-left: 0 !important; min-height: 1033px"
                                 v-if="displayType === 'block'">
                                <div class="content-objects" v-if="sport_objects">
                                    <content-objects object-list-class="content-vip-blocks"
                                                     v-if="vipSportObjects.length > 0"
                                                     :sport-objects="vipSportObjects"/>
                                    <content-objects object-list-class="" :sport-objects="nonVipSportObjects"/>
                                </div>
                                <div class="content-objects" v-else>
                                    <content-objects object-list-class="" :sport-objects="sport_objects_sort"/>
                                </div>
                            </div>
                        </transition>

                        <transition name="fade">
                            <div v-if="displayType === 'list'">
                                <listview></listview>
                            </div>
                        </transition>

                        <transition name="fade">
                            <div v-if="displayType === 'map'">
                                <div class="map-block__img map-display" style="height: 700px">
                                    <div class="white__block"></div>
                                    <yandex-map style="height:100%" :coords="center" :zoom="4"
                                                :cluster-options="clusterOptions" :settings="settings">
                                        <ymap-marker :key="index" v-for="(object, index) in sportObjectsCoords"
                                                     :coords="object.coords" :icon="{ color: 'red' }"
                                                     :marker-id="index" cluster-name="1"
                                                     :balloon-template="balloonTemplate(object)">
                                        </ymap-marker>
                                    </yandex-map>
                                </div>
                            </div>
                        </transition>

                        <div class="content-footer" v-if="displayType === 'list' || displayType === 'block'">
                            <div class="content-banner p-5">
                                <h2 class="content-banner__title mb-4 fs-1 fw-bold">Лучшее предложение на рынке</h2>
                                <a href="#" class="button button-fill button-white button-borderWhite">К предложению</a>
                            </div>
                            <paginator v-if="pagination_data" :pagination="pagination_data" @changePages="getSportObjects"
                                       @changeColPages="changeColPages"/>

                        </div>
                    </main>
                </div>
            </div>
        </section>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from './NavBar.vue'
import extendedinf from './ExtendedFooterInformation.vue'
import VSelect from '@alfsnd/vue-bootstrap-select'
import listview from './ListObjectCatalog.vue'
import {mapGetters} from 'vuex'
import Paginator from "./Paginator";
import ContentObjects from "./sportObjects/ContentObjects";
import moment from "moment";
import FilterSelect from "./elements/FilterSelect";

import {yandexMap, ymapMarker} from 'vue-yandex-maps';
import axios from "axios";
import VSelectItems from "./elements/VSelectItems";
//const yandexMap = () => import('vue-yandex-maps');

export default {
    props: ['user'],
    data() {
        return {
            settings: this.$apiSettings.yandexMap,
            displayType: 'block',
            kindOfSport: [
                {id: 1, text: "Вид спорта - 1"},
                {id: 2, text: "Вид спорта - 2"},
                {id: 3, text: "Вид спорта - 3"}
            ],
            filter: {
                sort_sport: null,
                selectedSports_list: [],
                checkedInfrastructures_list: [],
                selectedRegions_list: [],
                search: '',
                checkedFoods_list: [],
                checkedServices_list: [],
                minPrice: '',
                maxPrice: '',
                accred: false,
                sportIndex: {id: 0, title: 'Выберите вид спорта'},
                regionIndex: {id: 0, title: 'Выберите регион'},
                now_month: moment().format('M'),
                count_pages: 10,
            },
            initialFilter: {},
            sportObjects: [],
            clusterOptions: {
                '1': {
                    clusterIconColor: '#E45868',
                    clusterDisableClickZoom: false,
                    preset: 'islands#redCircleIcon',
                }
            },
            center: [54, 39],
            sportObjectsCoords: [],
        }
    },
    components: {
        VSelectItems,
        FilterSelect, ContentObjects, Paginator, navbar, extendedinf, VSelect, listview, yandexMap, ymapMarker,
    },
    computed: {
        ...mapGetters({
            sport_objects: 'AllSportObjects',
            sport_objects_statistic: 'sport_objects_statistic',
            sport_objects_loading: 'sport_objects_loading',
            filters: 'filtersSportObject',
            items_sport_types: 'AllSportTypes',
            items_infrastructures: 'AllInfrastructures',
            items_regions: 'AllRegions',
            items_type_foods: 'AllTypeFoods',
            items_additions: 'AllAdditionTender',
            items_services: 'AllServices',
        }),
        sport_objects_sort() {
            return [...this.sport_objects]
                .sort((a, b) => (a.id > b.id ? 1 : -1))
                .sort((a, b) => (a.hasVIP < b.hasVIP ? 1 : -1));
        },
        pagination_data() {
            return this.$store.getters.sport_objects_pagination;
        },
        vipSportObjects() {
            return this.sport_objects.filter(item => item.hasVIP);
        },
        nonVipSportObjects() {
            return this.sport_objects.filter(item => !item.hasVIP);
        },
        isFiltered() {
            // Implement your logic here if needed
        },
    },
    methods: {
        resetFilter() {
            this.filter = {
                search: '',
                maxPrice: '',
                minPrice: '',
                checkedServices_list: [],
                checkedFoods_list: [],
                checkedInfrastructures_list: [],
                selectedRegions_list: [],
                selectedSports_list: [],
            };
        },
        changeColPages(pages) {
            this.filter.count_pages = pages;
        },
        async getSportObjects(page = 1, total = 10) {
            await this.$store.dispatch('fetchSportObjects', {
                page,
                total,
                filters: this.filter,
            });
        },
        isLetter(e) {
            const char = String.fromCharCode(e.keyCode);
            if (/^[0-9]+$/.test(char)) return true;
            e.preventDefault();
        },
        async fetchInitialData() {
            const actions = [
                this.$store.dispatch('getSportObjectsStatistic'),
                this.$store.dispatch('getFiltersForSportObject'),
                this.getSportObjects(),
            ];

            await Promise.all(actions);
        },
        balloonTemplate(object) {
            const { id, title, country, city, image, minPrice, description } = object;
            const cleanDescription = description.replace(/<\/?[^>]+(>|$)/g, "").replace(/\.([^\s])/g, '. $1');
            return `
        <div class="d-flex">
          <div class="object-info">
            <img width="200px" height="150px" class="w-100" src="/storage/listings/objects/${id}/${image}" alt="img">
            <div class="object-content p-4">
              <h5 class="text-info object-balloon__title mb-3">${title}</h5>
              <div class="">
                <p class="object-balloon__country fs-5 mb-3">${country} <span class="object-balloon__city">г. ${city}</span></p>
                <div class="object-balloon__block-decription mb-3">
                  <p class="object-balloon__description">${cleanDescription}</p>...
                </div>
              </div>
              <div class="object-balloon__price text-center w-100 fs-6">
                от <b class="fs-5">${minPrice} ₽</b> / с человека в сутки
              </div>
            </div>
            <div class="wrapp-button d-flex justify-content-center w-100" style="width: -moz-available;">
              <a target="_blank" href="/object-catalog/${id}" type="button" class="button button-fill  text-white">подробнее</a>
            </div>
          </div>
        </div>`;
        },
        async fetchSportObjectsCoords() {
            this.sportObjectsCoords = [];
            let sportObjects = [];

            try {
                sportObjects = await this.$store.dispatch('fetchSportObjectsWithoutPage');
            } catch (error) {
                console.error("Failed to fetch sport objects:", error);
            }

            for (const object of sportObjects) {
                let { latitude, longtitude, country, city, address, id, title, image, accm_minPrice, description } = object;
                let lat = parseFloat(latitude);
                let long = parseFloat(longtitude);

                if (!lat || !long) {
                    const temp_address = encodeURI(`${country}+${city}+${address}`).replace(' ', '+');
                    try {
                        const resp = await axios.get('/api/v1/get/coords', { params: { address: temp_address } });
                        const coords = resp.data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ');
                        lat = parseFloat(coords[0]);
                        long = parseFloat(coords[1]);
                    } catch (error) {
                        console.error("Failed to get coordinates:", error);
                        continue;
                    }
                }

                this.sportObjectsCoords.push({
                    coords: [lat, long],
                    id,
                    title,
                    country,
                    city,
                    image: image[0],
                    minPrice: accm_minPrice,
                    description
                });
            }
        },
        async handleFilterChange() {
            if (this.displayType === 'map') {
                await this.fetchSportObjectsCoords();
            } else {
                await this.getSportObjects(this.pagination_data?.currentPage || 1, this.filter.count_pages);
                window.scrollTo(0, 400);
            }
        },
        async handleMapDisplay(value) {
            if (value === 'map') {
                await this.fetchSportObjectsCoords();
            } else {
                await this.getSportObjects(this.pagination_data?.currentPage || 1, this.filter.count_pages);
            }
        },
    },
    async created() {
        await this.fetchInitialData();
        this.initialFilter = _.cloneDeep(this.filter);
    },
    mounted() {
        const favorites = localStorage.getItem('favorites');
        if (favorites) {
            try {
                this.favorites = JSON.parse(favorites);
            } catch {
                localStorage.removeItem('favorites');
            }
        }
    },
    watch: {
        filter: {
            handler: 'handleFilterChange',
            deep: true
        },
        displayType: {
            handler: 'handleMapDisplay',
            deep: true
        }
    },
}
</script>

<style lang="scss">
.object-block__descr {
    height: 63px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.object-balloon {
    &__title, &__city, &__country, &__description {
        font-family: "Muller", sans-serif;
    }

    &__title {
        color: #0b3158 !important;
        font-weight: bold;
    }

    &__city {
        color: #0b3158 !important;
    }

    &__country {
        color: #6283e5;
    }

    &__block-decription {
        max-height: 50px;
        overflow: hidden;
    }

    &__description {
        color: #0b3158 !important;
        font-size: 15px;
        font-weight: 300;
        line-height: 18px;
    }

    &__price {
        font-family: "Muller", sans-serif;
        background: #6283e5;
        color: white;
        border-radius: 10px;
        padding: 5px;
    }

    &__btn {
        font-family: "Muller", sans-serif;
        background: #E45868;
        color: white;
    }
}

.map-display {
    .ymaps-2-1-79-balloon__close + .ymaps-2-1-79-balloon__content {
        padding: 0 !important;
        margin-right: 0;
    }

    .ymaps-2-1-79-balloon_layout_normal, .ymaps-2-1-79-balloon__layout {
        border-radius: 15px;
    }

    .ymaps-2-1-79-balloon__close-button {
        opacity: 1;
        background: white url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNCIgaGVpZ2h0PSIxNCI+PHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBkPSJNMTQgLjdsLS43LS43TDcgNi4zLjcgMCAwIC43IDYuMyA3IDAgMTMuM2wuNy43TDcgNy43bDYuMyA2LjMuNy0uN0w3LjcgN3oiIGNsaXAtcnVsZT0iZXZlbm9kZCIvPjwvc3ZnPg==) 50% no-repeat;
    }
}
</style>
