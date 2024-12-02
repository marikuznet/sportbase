<template>
    <div class="row">
        <sb-modal v-if="(isEditLiving && accommodation) || !isEditLiving" id="sb-type-living"
                  modal_dialog_class="modal-lg px-4" :is_show_footer="false"
                  :title="isEditLiving ? 'Редактировать стоимость и условия проживания'
                                              : 'Добавить стоимость и условия проживания'"
                  modal_class="sb-type-living p-0" modal_title_class="text-xl-left">
            <template #body>
                <ValidationObserver v-slot="{ invalid, failed, props }" tag="form" ref="observer-living"
                                    @submit.prevent="saveTypeLiving">
                    <label class="w-100 caption select-wrapper mb-xl-2 mb-4" for="typeObject">
                        Тип объекта
                        <v-select id="typeObject" labelTitle="Выбрать" textProp="title" valueProp="id"
                                  class="selectpicker mt-1" :options="types" @input="getAccTypeId"
                                  v-model="accommodation.title">
                        </v-select>
                    </label>
                    <custom-vue-editor text-label="Описание объекта"
                                       @update:text="accommodation.description = $event"
                                       :max-length="2000" :text="accommodation.description" :props="props"/>

                    <p class="caption">Стоимость проживания в {{ new Date().getFullYear() }} году
                        <span class="additionalyPriceLive text-muted">(руб за 1 чел. в сутки)</span>
                    </p>
                    <div class="priceList" v-for="(item, index) in month">
                        <div class="month pt-2">
                            <div class="row">
                                <div class="col-lg-2 col-sm-2 d-flex">
                                    <p class="nameMonth align-items-center d-flex font-weight-bold">
                                        {{ item.text }}
                                    </p>
                                </div>
                                <div class="col-lg-5 col-sm-5 mb-2 mb-lg-0">
                                    <ValidationProvider :vid="`accommodation_min_price_${index}`"
                                                        v-slot="{errors, failed}" rules="required|min:3|max:5">
                                        <div class="month-min d-flex align-items-center">
                                            <span class="text mx-auto pl-1 pr-1 font-weight-bold">от</span>
                                            <input type="text" name="search-object"
                                                   maxlength="5" minlength="3" placeholder="100"
                                                   v-model="accommodation.minPrice[index]"
                                                   class="input__price-month w-100" autocomplete="off"
                                                   onkeyup="this.value = this.value.replace(/[^\d]/g,'');"
                                                   :class="{'is-invalid': failed}">
                                        </div>
                                    </ValidationProvider>
                                </div>
                                <div class="col-lg-5 col-sm-5 mb-2 mb-lg-0">
                                    <ValidationProvider :vid="`accommodation_max_price_${index}`"
                                                        v-slot="{errors, failed}" rules="required|min:3|max:5">
                                        <div class="month-max d-flex align-items-center">
                                            <span class="text pl-1 pr-1 mx-auto font-weight-bold">до</span>
                                            <input type="text" name="search-object"
                                                   maxlength="5" minlength="3" placeholder="10 000" autocomplete="off"
                                                   v-model="accommodation.maxPrice[index]"
                                                   class="input__price-month w-100"
                                                   onkeyup="this.value = this.value.replace(/[^\d]/g,'');"
                                                   :class="{'is-invalid': failed}">
                                        </div>
                                    </ValidationProvider>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="justify-content-center d-flex pt-3">
                        <button type="submit" class="button button-green justify-content-center">
                            Сохранить
                        </button>
                    </div>
                </ValidationObserver>
            </template>
        </sb-modal>
        <sb-modal id="sb-price-living" ref="sb-price-living" title="Стоимость проживания"
                  modal_title_class="text-xl-left" modal_class="sb-price-living p-0 px-4" :is_show_footer="false">
            <template #body>
                <table class="table table-responsive">
                    <thead>
                    <th width="50%">Месяц пребывания {{ new Date().getFullYear() }}</th>
                    <th width="50%">Стоимость за 1 человека в сутки</th>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in month">
                        <td>{{ item.text }}</td>
                        <td>от {{ item.minPrice }} до {{ item.maxPrice }} руб.</td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </sb-modal>


        <div class="col-12">
            <div class="d-inline d-lg-flex row row-cols-1 row-cols-lg-2 row-cols-md-2 row-cols-sm-1">
                <div v-for="(item, index) in typeLiving" class="blockTypeLiveClose col mb-3">
                    <div class="typeLive">
                        <div class="block__title d-flex">
                            <p class="caption type-living__title">
                                {{ item.title.title ? item.title.title : item.title }}</p>
                            <div class="btnFunc d-flex">
                                <a data-toggle="modal" data-target="#sb-type-living"
                                   @click="editAccommodationLiving(index)" class="pr-2">
                                <span class="btnAction align-items-lg-center
                                   justify-content-center d-flex">
                                    <img src="/icons/stages/edit.svg" alt="edit-living">
                                </span>
                                </a>
                                <a @click="deleteAccommodationLiving(index)">
                                <span class="btnAction align-items-lg-center
                                   justify-content-center d-flex">
                                    <img src="/icons/stages/cancel.svg" alt="delete-living">
                                </span>
                                </a>
                            </div>
                        </div>
                        <div class="block__text type-living__description" style="min-height: 230px">
                            <p class="text p-4" v-html="item.description">
                                {{ item.description | stripHTMLTags | stringLength }}</p>
                        </div>
                        <div class="block__text block__price">
                            <p class="priceForPer pl-4 pr-4"
                               style="bottom: 65px;">
                                Стоимость (за 1 человека)
                            </p>
                            <div class="block__price d-flex pr-4 pl-4 pb-4" style="bottom: 0">
                                <span class="text pt-2 pr-2">от</span>
                                <p class="priceMin button-blueBorder borderblock  px-3
                                                        d-inline-block py-2 fw-light text-white"
                                   style="font-size: calc(1rem);">
                                    {{ item.price[currentMonth].minPrice }} руб
                                </p>
                                <span class="text pt-2 pl-2 pr-2">до</span>
                                <p class="priceMax button-blueBorder borderblock px-3 d-inline-block py-2 fw-light text-white mr-2"
                                   style="font-size: calc(1rem);">
                                    {{ item.price[currentMonth].maxPrice }} руб</p>
                                <button data-toggle="modal" data-target="#sb-price-living"
                                        @click="toggleModalLive(index)" type="button"
                                        class="button btnInformation button-borderBlue align-items-lg-center justify-content-center d-flex mx-auto">
                                    <img src="/icons/stages/information.svg" alt=""
                                         class="pr-3">
                                    Подробнее
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SbModal from "../elements/SbModal";
import CustomVueEditor from "../elements/CustomVueEditor";
import {extend} from "vee-validate";
import eventBus from '../../event-bus';

extend('accommodationsCount', {
    validate: (value => {
        return value > 0;
    }),
    message: 'Не добавлено ни одного типа проживания'
});
export default {
    name: "TypeLivingPricing",
    components: {CustomVueEditor, SbModal},
    props: {
        typeLiving: {
            type: Array,
            required: true
        },
        pricing: {
            type: Object,
            required: true
        },
        types: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            month: [{id: 0, text: 'Январь', title: 'january', minPrice: 0, maxPrice: 0},
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
                {id: 11, text: 'Декабрь', title: 'december', minPrice: 0, maxPrice: 0}],
            currentMonth: new Date().getMonth(),
            accommodation: {
                id: null, accType: '', title: '', description: '', minPrice: [], maxPrice: []
            }, isEditLiving: false, maxDescriptionLive: 2000,
            addAccTypeAndPrice: [], lengthLiving: 0
        }
    },
    watch: {
        typeLiving: {
            async handler(items) {
                this.lengthLiving = items.length;
            },
            deep: true
        },
    },
    methods: {
        getAccTypeId(accType) {
            this.accommodation.accType = accType.id;
        },
        toggleModalLive(index) {
            const {typeLiving} = this.pricing;
            const {price} = typeLiving[index];
            this.livePricing = typeLiving[index];
            price.forEach(({minPrice, maxPrice}, index) => {
                [this.month[index].minPrice, this.month[index].maxPrice] = [minPrice, maxPrice];
            });
        },
        toggleTypeLivingModal() {
            this.isEditLiving = false;
            this.accommodation.title = this.types[0];
            this.accommodation.description = '<p style="color: #0B3158"></p>';
            this.accommodation.minPrice = [];
            this.accommodation.maxPrice = [];
        },
        getPricing() {
            this.addAccTypeAndPrice = [];
            for (let i = 0; i < 12; i++) {
                this.addAccTypeAndPrice.push({
                    id: i,
                    title: this.month[i].title,
                    minPrice: this.accommodation.minPrice[i] === undefined ? 0 : this.accommodation.minPrice[i],
                    maxPrice: this.accommodation.minPrice[i] === undefined ? 0 : this.accommodation.maxPrice[i],
                });
            }
        },
        editAccommodationLiving(index) {
            this.isEditLiving = true;
            this.typeLivingId = index;
            this.accommodation = null;

            this.accommodation = {
                id: this.typeLiving[index].id,
                title: this.typeLiving[index].title,
                description: this.typeLiving[index].description,
                minPrice: [],
                maxPrice: []
            };

            for (let i = 0; i < 12; i++) {
                this.accommodation.minPrice[i] = this.typeLiving[index].price[i].minPrice;
                this.accommodation.maxPrice[i] = this.typeLiving[index].price[i].maxPrice;
            }
        },
        async saveTypeLiving() {
            await this.$refs["observer-living"].validate().then(success => {
                if (!success) {
                    setTimeout(() => {
                        const errors = Object.entries(this.$refs["observer-living"].errors)
                            .map(([key, value]) => ({key, value}))
                            .filter(error => error["value"].length);
                        this.$refs["observer-living"].refs[errors[0]["key"]].$el.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });
                    }, 100);
                } else {
                    this.getPricing();

                    if (this.isEditLiving) {
                        const newTypeLiving = {
                            id: this.accommodation.id,
                            idAccType: this.accommodation.accType,
                            title: this.accommodation.title,
                            description: this.accommodation.description,
                            price: this.addAccTypeAndPrice,
                        };
                        this.$emit('update-type-living', {index: this.typeLivingId, newData: newTypeLiving});
                    } else {
                        const newTypeLiving = {
                            id: null,
                            idAccType: this.accommodation.accType,
                            title: this.accommodation.title,
                            description: this.accommodation.description,
                            price: this.addAccTypeAndPrice,
                        };
                        this.$emit('add-type-living', newTypeLiving);
                    }

                    this.countObject++;
                    $('#sb-type-living').modal('hide');
                }
            });
        },
        deleteAccommodationLiving(index) {
            this.$emit('delete-living', index)
        },
    },
    mounted() {
        eventBus.$on('open-modal-accommodation', this.toggleTypeLivingModal);
    }
}
</script>

<style lang="scss">
.type-living {
    &__title {
        font-size: 19px !important;
    }

    &__description {
        & .text > * {
            font-size: 16px;
        }
    }
}
</style>
