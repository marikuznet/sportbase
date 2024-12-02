<template>
    <div class="mb-3 mt-3" style="background-color: white">
        <div class="filter-menu-row container pl-0 pr-0 justify-content-between d-none d-lg-flex"
             :class="{'flex-column': !buttonsFilter}">
            <div class="active-archive__button d-flex pb-4 pt-4 w-100" v-if="filterBtn">
                <template v-for="(btn, index) in buttonsFilter">
                    <button type="button" :class="{ 'active': btn.isActive }"
                            @click="setActiveButton(index);  $emit('handleUpdate', btn.status); status=btn.status"
                            class="sb-button-blue flex-fill flex-lg-grow-0 flex-md-grow-0 justify-content-center mr-2">
                        <span>{{ btn.title }}</span>
                        <span class="countActive">{{ btn.stats }}</span>
                    </button>
                </template>
            </div>
            <div class="search-and-filter d-flex pb-4 pt-4">
                <div class="search-wrapper w-100">
                    <input class="input-search searchField" type="search" name="search-object"
                           v-model="filter.search" id="search-object" placeholder="Поиск в каталоге тендеров"
                           autocomplete="off">
                    <img class="icon" src="/icons/search-icon.svg" alt="search-icon">
                </div>
                <button type="button" class="sb-button-blue ml-2 justify-content-center" data-toggle="collapse"
                        data-target="#filters" aria-expanded="false">
                    <span>Фильтры</span>
                    <span v-if="countsFilter > 0" class="active-filter-count ml-2">{{ countsFilter }}</span>
                    <img v-if="countsFilter > 0" class="pl-3" src="/icons/direct/funnelFillBlue.svg"
                         alt="filter">
                </button>
            </div>
        </div>
        <div class="filter-menu-row-mobile container ctnPad justify-content-between d-flex d-lg-none flex-wrap">
            <div class="active-archive__button block-table d-flex flex-md-nowrap flex-wrap gap-2 ms-0 pb-3 pt-2 w-100"
                 v-if="filterBtn">
                <template v-for="(btn, index) in buttonsFilter">
                    <button type="button" :class="{ 'active': btn.isActive }"
                            @click="setActiveButton(index); $emit('handleUpdate', btn.status); status=btn.status"
                            class="sb-button-blue borderBlue flex-fill flex-lg-grow-0 flex-md-grow-0 justify-content-center">
                        <span>{{ btn.title }}</span>
                        <span class="countActive">{{ btn.stats }}</span>
                    </button>
                </template>
            </div>
            <div class="search-and-filter d-block pb-4 pt-4 w-100">
                <div class="d-flex">
                    <div class="d-block w-100">
                        <div class="search-wrapper w-100 d-flex">
                            <input class="input-search searchField" type="search" name="search-object"
                                   placeholder="Поиск в каталоге объектов"
                                   v-model="filter.search" autocomplete="off">
                            <img class="icon" src="/icons/search-icon.svg" alt="search-icon">
                        </div>
                    </div>
                    <div class="d-block">
                        <button type="button" class="button ml-2 justify-content-center button-borderBlue h-100"
                                data-toggle="collapse"
                                data-target="#filters" aria-expanded="false">
                            <span class="d-lg-block d-none">Фильтры</span>
                            <img class=" d-lg-none d-block" src="/icons/direct/funnelBlue.svg" alt="filter">
                            <span v-if="countsFilter > 0" class="active-filter-count ml-2">{{ countsFilter }}</span>
                            <img v-if="countsFilter > 0" class="pl-3 d-lg-block d-none"
                                 src="/icons/direct/funnelFillBlue.svg"
                                 alt="filter">
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="filters" class="collapse filters-data pb-1" style="background-color: white">
            <div class="container p-0 mb-4">
                <div class="block-info-filter">
                    <div class="row">
                        <div class="col-md-6 d-lg-none d-flex">
                            <div class="d-flex">
                                <p>Выберите фильтры</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="option">
                                <p>Дата пребывания</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="date position-relative mr-1 w-100">
                                        <input class="custom-date-input date w-100" type="date"
                                               placeholder="Укажите дату" v-model="filter.start_date">
                                    </div>
                                    <span>-</span>
                                    <div class="date w-100 position-relative ml-1">
                                        <input class="custom-date-input date w-100" type="date"
                                               placeholder="Укажите дату" v-model="filter.end_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row option">
                                <div class="col-12">
                                    <label class="w-100 select-wrapper mb-xl-2" for="food">Объект
                                        <v-select id="select-object" labelTitle="Выберите значение" textProp="title"
                                                  valueProp="id" :items="filters_data.object" v-model="models.object"
                                                  :options="filters_data.object" name="category"
                                                  class="selectpicker mt-1" return-object
                                                  @input="pushListItem(filter.objects, $event, 'id', 'object')">
                                        </v-select>
                                    </label>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex flex-wrap mt-3">
                                        <div v-for="(item, index) in filter.objects" :id="item.id"
                                             class="type-list-border__item"
                                             :key="item.id" :value="{id: item.id, title: item.title}">
                                            {{ item.title }}
                                            <span @click="filter.objects.splice(index, 1)"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="option">
                                <p>Стоимость <span class="valute">(руб в сутки за одного человека)</span></p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="mr-4 price">от</span>
                                    <div class="date position-relative mr-1">
                                        <input class="sum w-100" type="text" placeholder="1000" maxlength="5"
                                               v-model.lazy="filter.minPrice">
                                    </div>
                                    <span class="ml-4 mr-4 price">до</span>
                                    <div class="date position-relative ml-1">
                                        <input class="sum w-100" type="text" placeholder="10000" maxlength="5"
                                               v-model.lazy="filter.maxPrice">
                                    </div>
                                    <div class="sum position-relative ml-4 w-50">
                                        <v-select id="valute" labelTitle="руб." textProp="title"
                                                  valueProp="id" class="selectpicker select-wrapper h-100"
                                                  name="category" return-object>
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row option">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="w-100 select-wrapper mb-xl-2" for="food">
                                                Предоставляемое питание
                                                <v-select id="food" labelTitle="Выберите значение"
                                                          textProp="title" valueProp="id" :options="filters_data.food"
                                                          name="category" class="selectpicker mt-1"
                                                          v-model="models.food"
                                                          @input="pushListItem(filter.foods, $event, 'id', 'food')"
                                                          return-object>
                                                </v-select>
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap mt-3">
                                                <div v-for="(item, index) in filter.foods" :id="item.id"
                                                     class="type-list-border__item"
                                                     :key="item.id" :value="{id: item.id, title: item.title}">
                                                    {{ item.title }}
                                                    <span @click="filter.foods.splice(index, 1)"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="w-100 select-wrapper mb-xl-2" for="services">
                                                Предоставляемые услуги
                                                <v-select id="services" labelTitle="Выберите значение"
                                                          textProp="title" valueProp="id" class="selectpicker mt-1"
                                                          :options="filters_data.services" v-model="models.services"
                                                          name="category" return-object
                                                          @input="pushListItem(filter.services, $event, 'id', 'services')">
                                                </v-select>
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap mt-3">
                                                <div v-for="(item, index) in filter.services"
                                                     class="type-list-border__item"
                                                     :id="item.id" :key="item.id"
                                                     :value="{id: item.id, title: item.title}">
                                                    {{ item.title }}
                                                    <span @click="filter.services.splice(index, 1)"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="w-100 select-wrapper mb-xl-2" for="infrastructure">
                                                Инфраструктура
                                                <v-select id="infrastructure" labelTitle="Выберите значение"
                                                          textProp="title" valueProp="id" class="selectpicker mt-1"
                                                          :options="filters_data.infrastructures"
                                                          v-model="models.infrastructures"
                                                          name="category" return-object
                                                          @input="pushListItem(filter.infrastructures, $event, 'id', 'infrastructures')">
                                                </v-select>
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap mt-3">
                                                <div v-for="(item, index) in filter.infrastructures"
                                                     class="type-list-border__item" :id="item.id"
                                                     :key="index" :value="{id: index, title: item}">
                                                    {{ item.title }}
                                                    <span @click="filter.infrastructures.splice(index, 1)"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="false">
                                    <label class="w-100 select-wrapper mb-xl-2" for="accred">
                                        Наличие аккредитации<a>Минспорта</a>
                                        <v-select id="accred" labelTitle="Без разницы" textProp="title"
                                                  valueProp="id" class="selectpicker mt-1" name="category"
                                                  return-object>
                                        </v-select>
                                    </label>
                                </div>
                                <div class="align-self-center col-md-6">
                                    <button type="button" @click="resetFilter"
                                            class="button button-borderBlue w-100 justify-content-center">
                                        Сбросить все фильтры
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import VSelect from "@alfsnd/vue-bootstrap-select";

export default {
    name: "Filters",
    props: {
        filterBtn: {
            type: Array,
            default: null
        },
        activeStatus: {
            type: String,
            default: 'active'
        }
    },
    data() {
        return {
            listAccred: [
                {id: 0, title: 'Без разницы', col: 0},
                {id: 1, title: 'Да', col: true},
                {id: 2, title: 'Нет', col: false},
            ],
            filter: {
                minPrice: null, maxPrice: null, start_date: null, end_date: null, objects: [], foods: [],
                services: [], infrastructures: [], accred: [], search: null
            }, buttonsFilter: [], status: this.$props.activeStatus,
            models: {object: null, food: null, services: null, infrastructures: null}
        }
    },
    methods: {
        resetFilter() {
            this.filter = {
                minPrice: null, maxPrice: null, start_date: null, end_date: null, objects: [], foods: [],
                services: [], infrastructures: [], accred: [], search: null
            }
        },
        pushListItem(list, item, idKey, model) {
            if (item[idKey] === null) {
                list.splice(0, list.length);
            } else if (!list.some(data => data[idKey] === item[idKey])) {
                list.push({
                    'id': item[idKey],
                    'title': item.title
                });
            }
            this.$nextTick(() => {
                this.models[model] = null;
            });
        },
        setActiveButton(index) {
            this.filterBtn.forEach((btn, i) => {
                btn.isActive = i === index;
            });
            this.$emit('handleUpdate', this.filterBtn[index].status);
            this.status = this.filterBtn[index].status;
        }

    },
    computed: {
        ...mapGetters({
            filters_data: 'filters',
        }),
        countsFilter() {
            return Object.values(this.filter).filter(value => {
                if (Array.isArray(value)) {
                    return value.length > 0;
                } else {
                    return value !== null && value !== '';
                }
            }).length;
        },
    },
    watch: {
        filter: {
            handler: function (newVal, oldVal) {
                this.$emit('update-filter', this.filter);
                this.$emit('updateData', this.status);
            },
            deep: true
        }
    },
    components: {
        VSelect
    },
    created() {
        this.$store.dispatch('getFilters');
    },
    mounted() {
        this.buttonsFilter = this.$props.filterBtn;
    }
}
</script>

<style scoped lang="scss">
.button {
    height: 45px;
    width: 150px;
    border-radius: 5px;
}

@media (max-width: 960px) {
    .sb-filter__block {
        width: auto;
    }

    .block-info-filter {
        margin: 0 1.5rem;
    }
}

.filter-menu-row-mobile .button {
    height: 45px;
    width: 45px;
    border-radius: 10px;
}

.button-border {
    color: #6283E5;
}

#search-object {
    height: 45px;
    min-width: 650px;
    border-radius: 5px;
}

#search-object-mobile {
    height: 45px;
    border-radius: 10px;
}

.search-and-filter {
    .active-filter-count {
        color: white !important;
    }
}

.sb-button-blue[aria-expanded=true] {
    background: #6283e5;

    span {
        color: white !important;
    }

    img {
        filter: brightness(5) !important;
    }

    .active-filter-count {
        background: white !important;
        color: #6283e5 !important;
    }
}

.custom-date-input {
    appearance: none;
    background-image: url('/icons/direct/calendar.svg');
    background-repeat: no-repeat;
    background-size: auto;
    background-position: right;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    opacity: 0;
}

.search-and-filter {
    .button-borderBlue:hover {
        img {
            filter: brightness(5) !important;
        }
    }
}

@media (max-width: 960px) {
    .block-table {
        /*  overflow: auto;
          margin-bottom: 1rem;
          margin-left: 1.3rem;*/
    }
}
</style>
