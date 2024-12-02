<template>
    <ValidationObserver v-slot="{invalid}" tag="form" ref="observer" @submit.prevent="nextStep">
        <section class="table-responsive-md">
            <slot :class="`${modalClass}-body`">
                <div class="checkBox">
                    <label class="d-flex align-items-center">
                        <input class="checkBox__check d-none" type="checkbox"
                               :value="accmRent.checkAccm" v-model="accmRent.checkAccm">
                        <span></span>
                        <p class="pl-3 checkBox__title">Включить в смету стоимость проживания</p>
                    </label>
                </div>
                <div v-if="accmRent.checkAccm">
                    <div class="table-rent">
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span>Даты размещения</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center date-rent">
                                        <input type="date" name="search-object"
                                               class="input-profile-info input-label mt-1"
                                               :min="nowDate" required @change="setEndDate"
                                               v-model="accmRent.startDate">
                                        <span class="ml-2 mr-2">&#8212;</span>
                                        <input type="date" name="search-object"
                                               class="input-profile-info input-label mt-1"
                                               :min="accmRent.startDate" required
                                               v-model="accmRent.endDate">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-baseline">
                                    <div class="d-flex align-items-center">
                                        <span>Условия и стоимость</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="accommodations-block"
                                         v-for="(accm, index) in accmRent.accommodations"
                                         v-if="accm">
                                        <div class="checkBox">
                                            <label class="d-flex align-items-center"
                                                   :for="'accmCheck-'+index">
                                                <input class="checkBox__check accmCheck d-none"
                                                       type="checkbox" :id="'accmCheck-'+index"
                                                       :value="false"
                                                       v-model="accmRent.accommodations[index].check">
                                                <span></span>
                                                <p class="pl-3 checkBox__title">
                                                    {{ accm.title }} ({{ accm.options['sum'] }}
                                                    руб.)
                                                </p>
                                            </label>
                                        </div>
                                        <div class="row align-items-end"
                                             v-if="accmRent.accommodations[index].check">
                                            <div class="row">
                                                <div class="col-4">
                                                    <p><b>Количество мест</b></p>
                                                </div>
                                                <div class="col-4">
                                                    <p><b>Количество номеров</b></p>
                                                </div>
                                                <div class="col-4">
                                                    <p><b>Стоимость (за номер)</b></p>
                                                </div>
                                            </div>
                                            <div class="row"
                                                 v-for="(option, indexOption) in accm.options">
                                                <div class="col-4">
                                                    <div class="select-wrapper">
                                                        <v-select class="selectpicker"
                                                                  labelTitle="выбрать"
                                                                  textProp="title" valueProp="id"
                                                                  :options="places" :items="places"
                                                                  v-model="accmRent.accommodations[index].options[indexOption].places">
                                                        </v-select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <ValidationProvider
                                                        rules="required|numeric|max:2|min:1"
                                                        v-slot="{ valid, errors, dirty, invalid }">
                                                        <input type="text" minlength="1"
                                                               class="input-profile-info" required
                                                               placeholder="1-30" autocomplete="off"
                                                               pattern="^([0-9]+)$" maxlength="2"
                                                               :value="accmRent.accommodations[index].options[indexOption].colNum"
                                                               @input="inputNum($event, index, indexOption)">
                                                    </ValidationProvider>
                                                </div>
                                                <div class="col-5">
                                                    <div class="align-items-center d-flex row">
                                                        <div class="col-9">
                                                            <ValidationProvider
                                                                rules="required|numeric|max:5|min:1"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                                <input type="text"
                                                                       placeholder="100 - 10 000"
                                                                       class="input-profile-info"
                                                                       required autocomplete="off"
                                                                       pattern="^([0-9]+)$"
                                                                       maxlength="5" minlength="1"
                                                                       :value="accmRent.accommodations[index].options[indexOption].price"
                                                                       @input="inputPriceNum($event, index, indexOption)">
                                                            </ValidationProvider>
                                                        </div>
                                                        <div class="col-2">
                                                            <span>руб</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p @click="addAccm(accm.id)"
                                               style="font-size: 12px; color: #E45868;"><a href="#">
                                                + Добавить еще</a></p>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span>Питание</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="type-food row w-100">
                                        <label class="caption select-wrapper mb-xl-2 col-8 pr-2 ps-2"
                                               for="priceFood">
                                            <v-select id="priceFood" labelTitle="Выбрать стоимость"
                                                      textProp="title" valueProp="id"
                                                      :options="priceFood" :items="priceFood"
                                                      class="selectpicker" required
                                                      :value="accmRent.titlePriceFood"
                                                      @input="getPriceFood">
                                            </v-select>
                                        </label>
                                        <label for="typeFood"
                                               v-if="accmRent.titlePriceFood != 'Выбрать стоимость' && accmRent.typePriceFood"
                                               class="caption select-wrapper mb-xl-2 col-4">
                                            <v-select id="typeFood" labelTitle="Выбрать тип"
                                                      required textProp="title" valueProp="id"
                                                      :options="typeFoods" :items="typeFoods"
                                                      :value="accmRent.typePriceFood"
                                                      @input="getTypeFood" class="selectpicker">
                                            </v-select>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="accmRent.titlePriceFood == 'Не входит в стоимость' && visiblePriceFood">
                                <td>
                                </td>
                                <td>
                                    <div class="align-items-center d-flex type-food">
                                        <p>Стоимость (за 1го чел. в сутки)</p>
                                        <div class="align-items-center d-flex row ms-0">
                                            <div class="col-8">
                                                <ValidationProvider
                                                    rules="required|numeric|max:5|min:2"
                                                    v-slot="{ valid, errors, dirty, invalid }">
                                                    <input type="text" placeholder="0"
                                                           class="input-profile-info" required
                                                           :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                           autocomplete="off" pattern="^([0-9]+)$"
                                                           maxlength="5" minlength="2" :value="accmRent.priceFood"
                                                           @input="handleInputField($event, 'priceFood', 10000)">
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-4">
                                                <span>руб</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </slot>
        </section>
        <section>
            <slot name="slot-footer" :class="`${modalClass}-footer`">
                <p v-if="accmRent.checkAccm" :class="`${modalClass}-price`" class="caption mb-2">
                    Стоимость размещения: <b class="ml-2">{{ totalPlaces }} руб (за
                    {{ accmRentDays }} суток)</b>
                </p>
                <p v-if="accmRent.checkAccm" :class="`${modalClass}-price`" class="caption mb-2">
                    Стоимость питания: <b class="ml-2">{{ accmRentPriceFood }} руб (за {{
                        accmRentDays
                    }} суток)</b>
                </p>
                <div class="pagination d-flex justify-content-center">
                    <div class="pagination__button">
                        <a class="align-items-center btn d-flex h-100 justify-content-center"
                           href="#"
                           @click="$emit('prevStep')">
                            <u>ВЕРНУТЬСЯ</u>
                        </a>
                    </div>
                    <div class="pagination__button">
                        <button type="submit"
                                class="button button-green justify-content-center">Далее
                        </button>
                    </div>
                </div>
            </slot>
        </section>
    </ValidationObserver>
</template>


<script>
import VSelect from "@alfsnd/vue-bootstrap-select";
import {mapActions, mapGetters} from 'vuex';
import SportObjectSection from "../deal/SportObjectSection";

export default {
    data() {
        return {
            nowDate: null,
            priceFood: [{id: 0, title: 'Включено в стоимость'}, {id: 1, title: 'Не входит в стоимость'}],
            typeFoodVisible: false, visiblePriceFood: false, places: [{id: 1, title: '1-местный'},
                {id: 2, title: '2-местный'}, {id: 3, title: '3-местный'}, {id: 4, title: '4-местный'}],
            accmRent: {
                checkAccm: false, priceFood: null, sumPriceFood: 0, titlePriceFood: 'Выбрать стоимость' || 'default',
                typePriceFood: 'Выбрать тип' || 'default', startDate: new Date().toISOString().slice(0, 10),
                endDate: new Date(Date.now() + 1 * 24 * 60 * 60 * 1000).toISOString().slice(0, 10),
                accommodations: [], sumAccm: 0, daysAccm: 0, typeFood_id: null,
            }, typeFoods: [], totalPlaces: 0,
        }
    },
    name: 'PAModal',
    computed: {
        ...mapGetters({
            allTypeFoods: 'AllTypeFoods',
            estimateLoading: 'estimateLoading'
        }),
        accmRentDays() {
            let endDate = new Date(this.accmRent.endDate);
            const timeDiff = Math.abs(endDate.setDate(endDate.getDate() + 1) - new Date(this.accmRent.startDate));
            this.accmRent.daysAccm = Math.ceil(timeDiff / (1000 * 3600 * 24));
            return this.accmRent.daysAccm;
        },
        accmRentPriceFood() {
            this.accmRent.sumPriceFood = this.accmRentDays * this.accmRent.priceFood * this.dealRequest.colPeople;
            return this.accmRent.sumPriceFood;
        },
        myDeal() {
            return this.dealData;
        },
        sportObject() {
            return this.dealRequest.sportObject;
        },
        dealRequest() {
            //TODO this.dealData?.tender Уточнить, возможно нужно ориентироваться на тендер (для шапки и кол-ва человек)
            return this.dealData?.direct || this.dealData?.responsesTender;
        },
    },
    methods: {
        ...mapActions(["fetchTypeFoods", "addAccommodation"]),
        closeModal() {
            this.$emit('closeModal', false);
        },
        escCloseModal(e) {
            if (this.show && e.key === 'Escape') {
                this.closeModal();
            }
        },
        setEndDate() {
            let startDates = new Date(this.accmRent.startDate);
            this.accmRent.endDate = new Date(startDates + (2 * 24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
        },
        handleInputField(event, targetField, maxValue) {
            const value = event.target.value;
            if (value.length === 1 && value === "0") {
                return;
            }
            if (value <= maxValue) {
                this.accmRent[targetField] = value;
                this.$forceUpdate();
            }
        },

        inputNum(event, index, indexOption) {
            const value = event.target.value;
            if (value.length === 1 && value === "0") {
                return;
            }
            if (value <= 30) this.accmRent.accommodations[index].options[indexOption].colNum = value;
            this.$forceUpdate();
        },
        inputPriceNum(event, index, indexOption) {
            const value = event.target.value;
            if (value.length === 1 && value === "0") {
                return;
            }
            if (value <= 10000) this.accmRent.accommodations[index].options[indexOption].price = value;
            this.$forceUpdate();
        },
        getPriceFood(food) {
            if (food.id === 0 || food.id === 1) {
                this.typeFoodVisible = true;
                this.accmRent.titlePriceFood = food.title ?? food;
            }
            if (food.id === 0) {
                this.visiblePriceFood = false;
                this.accmRent.priceFood = null;
            } else if (food.id === 1) this.visiblePriceFood = true;
        },
        getTypeFood(price) {
            this.accmRent.typePriceFood = price.title ?? price;
            this.accmRent.typeFood_id = price.id ?? price;
        },
        nextStep: function () {
            this.$refs.observer.validate().then(success => {
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
                    this.addAccommodation({accommodation: this.accmRent});
                    this.$emit('nextStep');
                }
            });
        },
        addAccm(id) {
            let index = this.accmRent.accommodations.map(el => el.id).indexOf(id);
            this.accmRent.accommodations[index].options.push({
                places: '', colPlace: '', colNum: '', price: '', sum: 0
            });
        },
        initializeAccommodationFromEdit(rentAccommodation) {
            this.accmRent = {
                ...this.accmRent,
                ...rentAccommodation,
                startDate: new Date(rentAccommodation.start_date).toISOString().slice(0, 10),
                endDate: new Date(rentAccommodation.end_date).toISOString().slice(0, 10),
                typePriceFood: rentAccommodation.typeFood,
                titlePriceFood: rentAccommodation.checkAccm ? rentAccommodation.titlePriceFood : 'Не входит в стоимость',
            };
        },

        initializeAccommodationFromLocalStorage(localStorageData) {
            const {accommodation} = localStorageData;
            this.accmRent = {
                ...this.accmRent,
                ...accommodation,
                accommodations: accommodation.accommodations,
            };
            this.typeFoodVisible = this.accmRent.titlePriceFood.title === 'Включено в стоимость';
            this.visiblePriceFood = this.accmRent.titlePriceFood.title !== 'Не входит в стоимость';
        },

        initializeAccommodationFromSportObject() {
            if (this.sportObject) {
                this.accmRent.accommodations = this.sportObject.accommodations.map((accommodation) => ({
                    id: accommodation.idAccType,
                    check: false,
                    title: accommodation.type,
                    options: [{places: '', colPlace: '', colNum: '', price: '', sum: 0}],
                }));
            }
        }
    },
    async mounted() {
        const [typeFoods, dealData] = await Promise.all([
            this.fetchTypeFoods(),
            this.$props.edit ? this.$store.dispatch('getEstimate', {id: this.$props.idEstimate}) : null,
        ]);

        this.accmRent.typePriceFood = {id: typeFoods[0].id, title: typeFoods[0].title};

        const deal = this.myDeal.direct || this.myDeal.responsesTender;
        this.accmRent.startDate = new Date(deal.fullStartDate).toISOString().slice(0, 10);
        this.accmRent.endDate = new Date(deal.fullEndDate).toISOString().slice(0, 10);

        if (this.$props.edit) {
            this.initializeAccommodationFromEdit(dealData.rentAccommodation);
        } else {
            const localStorageData = JSON.parse(localStorage.getItem('accommodationRent'));
            if (localStorageData) {
                this.initializeAccommodationFromLocalStorage(localStorageData);
            } else {
                this.initializeAccommodationFromSportObject();
            }
        }
    },
    watch: {
        allTypeFoods: {
            handler: function (newValue) {
                this.typeFoods.push({id: newValue[0].id, title: newValue[0].title});
                this.typeFoods.push({id: newValue[1].id, title: newValue[1].title});
                this.typeFoods.push({id: newValue[2].id, title: newValue[2].title});
            }, deep: true
        },
        'accmRent.accommodations': {
            handler: function (accm) {
                this.totalPlaces = 0;
                this.accmRent.sumAccm = 0;
                for (let i = 0; i < accm.length; i++) {
                    if (accm[i].check) {
                        let options = accm[i].options;
                        let sumOptions = 0;
                        options.reduce((acc, a) => {
                            if (Number(a['price']) && Number(a['colNum']))
                                sumOptions += (Number(a['price']) * Number(a['colNum']))
                        }, 0);
                        this.accmRent.accommodations[i].options.sum = (sumOptions * this.accmRentDays);
                        this.totalPlaces += (sumOptions * this.accmRentDays);
                        this.accmRent.sumAccm += (sumOptions * this.accmRentDays);
                    }
                }
            }, deep: true
        }
    },
    destroy() {
        window.removeEventListener('keydown', this.escCloseModal);
    },
    components: {
        SportObjectSection,
        VSelect,
    },
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        modalClass: {
            type: String,
            default: 'simple-modal',
        },
        dealData: {
            type: Object
        },
        idEstimate: {
            type: Number
        },
        edit: {
            type: Boolean
        }
    },
}
</script>

<style scoped>

</style>
