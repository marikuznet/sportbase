<template>
    <div>
        <section class="table-responsive-md">
            <slot :class="`${modalClass}-body`">
                <div class="rent-object mb-3" v-if="sportObject.checkSport">
                    <div class="row mb-2">
                        <p><b>Аренда спортивного объекта</b> (итого:
                            {{ Number(sportObject.sum).toFixed(2) }} руб)</p>
                    </div>
                    <div class="row">
                        <div class="col-4"><p class="caption">Стоимость аренды</p></div>
                        <div class="col-8"><p>{{ Number(sportObject.price).toFixed(2) }} руб/час</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4"><p class="caption">Даты аренды</p></div>
                        <div class="col-8"><p>
                            {{
                                getTextDate(sportObject.startDate, sportObject.endDate)
                            }}</p></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><p class="caption">Тренировки</p></div>
                        <div v-if="parseInt(sportObject.training) === 0" class="col-8"><p>нет</p>
                        </div>
                        <div v-else-if="parseInt(sportObject.training) === 1" class="col-8"><p>1
                            раз/день</p>
                        </div>
                        <div v-else-if="parseInt(sportObject.training) === 2" class="col-8"><p>2
                            раза/день</p>
                        </div>
                    </div>
                    <div class="row" v-if="parseInt(sportObject.training) !== 0">
                        <div class="col-4"><p class="caption">Дни и время тренировок</p></div>
                        <div class="col-8">
                            <p v-if="!sportObject.time">в одно время</p>
                            <p v-if="sportObject.time">в разное время</p>
                            <div class="row" v-if="!sportObject.time">
                                <div class="col-6">
                                    <p><b>день</b></p>
                                    <div class="d-flex align-items-center ">
                                        <p>все дни пребывания</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p><b>время тренировки</b></p>
                                    <p>первая:
                                        {{
                                            sportObject.trainingTime[0].start_1_at + ' - '
                                            + sportObject.trainingTime[0].end_1_at
                                        }}</p>
                                    <p v-if="sportObject.training == 2">вторая:
                                        {{
                                            sportObject.trainingTime[0].start_2_at + ' - '
                                            + sportObject.trainingTime[0].end_2_at
                                        }}
                                    </p>
                                </div>
                            </div>
                            <div class="different-training" v-if="sportObject.time">
                                <div class="row">
                                    <div class="col-6"><p><b>день</b></p></div>
                                    <div class="col-6"><p><b>время тренировки</b></p></div>
                                </div>
                                <div class="row"
                                     v-for="(item, index) in sportObject.trainingTime_diff">
                                    <div class="align-items-center col-6 d-flex">
                                        <p>{{ index + 1 }}-й ({{ getWeekDay(item.id) }})</p>
                                    </div>
                                    <div class="col-6">
                                        <p>первая: {{ item.start_1_at }} - {{ item.end_1_at }}</p>
                                        <p v-if="sportObject.training === 2">вторая:
                                            {{ item.start_2_at }} - {{ item.end_2_at }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="living-rent mb-3" v-if="accommodationPrice.checkAccm">
                    <div class="row mb-2">
                        <p><b>Проживание и питание</b> (итого:
                            {{ Number(accommodationPrice.sumPriceFood + accommodationPrice.sumAccm).toFixed(2) }} руб)
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-4"><p class="caption">Даты размещения</p></div>
                        <div class="col-8"><p>{{
                                getTextDate(accommodationPrice.startDate, accommodationPrice.endDate)
                            }}</p></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><p class="caption">Условия и стоимость</p></div>
                        <div class="col-8">
                            <div class="row mb-3"
                                 v-for="item in accommodationPrice.accommodations"
                                 v-if="item.check">
                                <p>{{ item.title }}</p>
                                <div class="row">
                                    <div class="col-4"><p><b>Количество мест</b></p></div>
                                    <div class="col-4"><p><b>Количество номеров</b></p></div>
                                    <div class="col-4"><p><b>Стоимость (за номер в сутки)</b></p>
                                    </div>
                                </div>
                                <div class="row" v-for="option in item.options">
                                    <div class="col-4"><p>{{ option.places.id }}</p></div>
                                    <div class="col-4"><p>{{ option.colNum }}</p></div>
                                    <div class="col-4"><p>{{ Number(option.price).toFixed(2) }} руб</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><p class="caption">Питание</p></div>
                        <div class="col-8">
                            <p class="mb-2"
                               v-if="accommodationPrice.titlePriceFood === 'Включено в стоимость'">
                                {{ 'Включено в стоимость' }}</p>
                            <p class="mb-2"
                               v-if="accommodationPrice.titlePriceFood === 'Не входит в стоимость'">{{
                                    'Не входит в стоимость'
                                }} (оплачивается)</p>
                            <div class="row">
                                <div class="col-3">
                                    <p>Тип:</p>
                                    <p>{{ accommodationPrice.typePriceFood }}</p>
                                </div>
                                <div class="col-9">
                                    <p>Стоимость (за 1го чел. в сутки):</p>
                                    <p>
                                        {{
                                            accommodationPrice.priceFood ?
                                                Number(accommodationPrice.priceFood).toFixed(2) : 0.00
                                        }}
                                        руб</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="addition-block mb-3" v-if="additionalRent">
                    <div class="row mb-2">
                        <p><b>Дополнительные услуги</b></p>
                    </div>
                    <div class="row" v-for="infrastructure in additionalRent.infrastructures"
                         v-if="infrastructure.check">
                        <div class="col-3">
                            <p>Аренда {{ infrastructure.title }} (итого:
                                {{ Number(infrastructure.sum).toFixed(2) }} руб)</p>
                        </div>
                        <div class="col-3">
                            <p>Стоимость аренды: {{ Number(infrastructure.price).toFixed(2) }} руб</p>
                        </div>
                        <div class="col-3">
                            <p>Даты аренды: {{
                                    getTextDate(infrastructure.start_date, infrastructure.end_date)
                                }}</p>
                        </div>
                        <div class="col-3" v-if="!infrastructure.time">
                            <p>Время аренды (в одно время):</p>
                            <p>c {{ infrastructure.timing_once[0].start_1_at }} до
                                {{ infrastructure.timing_once[0].start_1_end }}</p>
                        </div>
                    </div>

                    <div class="row" v-if="additionalRent.checkLaundry">
                        <div class="col-3">
                            <p>Услуги прачечной (итого:
                                {{ Number(additionalRent.sumLaundry).toFixed(2) }}
                                руб)</p>
                        </div>
                        <div class="col-3">
                            <p>Объем стирки: {{ Number(additionalRent.washingVolume) }} </p>
                        </div>
                        <div class="col-3">
                            <p>Стоимость: {{ Number(additionalRent.priceWashing).toFixed(2) }}
                                руб</p>
                        </div>
                    </div>
                    <div class="row" v-if="additionalRent.checkTransfer">
                        <div class="col-3">
                            <p>Трансфер от/до аэропорта на автобусе (итого:
                                {{ Number(additionalRent.sumTransfer).toFixed(2) }} руб)</p>
                        </div>
                        <div class="col-3">
                            <p style="word-break: break-all;">Период (продолжительность):
                                {{ Number(additionalRent.durationTransfer) }} часов</p>
                        </div>
                        <div class="col-3">
                            <p>Стоимость: {{ Number(additionalRent.priceTransfer).toFixed(2) }}
                                руб</p>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><p><b>Стоимость (итого)</b></p></div>
                    <div class="col-8">
                        <p>Аренда объекта:
                            <b>{{ sportObject.sum ? Number(sportObject.sum).toFixed(2) : '0.00' }}
                                руб (за
                                {{ getDaysText(sportObject.colDays ? sportObject.colDays : 0) }})</b>
                        </p>
                        <p>Размещение: <b>{{
                                accommodationPrice.sumAccm ?
                                    Number(accommodationPrice.sumAccm).toFixed(2) : '0.00'
                            }} руб (за {{
                                getDaysText(accommodationPrice.daysAccm ? accommodationPrice.daysAccm : 0)
                            }} )</b>
                        </p>
                        <p>Питание: <b>{{
                                accommodationPrice.sumPriceFood ?
                                    Number(accommodationPrice.sumPriceFood).toFixed(2) : '0.00'
                            }} руб (за {{
                                getDaysText(accommodationPrice.daysAccm ? accommodationPrice.daysAccm : 0)
                            }})</b>
                        </p>
                        <p>Дополнительные услуги:
                            <b>{{
                                    additionalRent.totalPrice ?
                                        Number(additionalRent.totalPrice).toFixed(2) : '0.00'
                                }} руб (за {{ additionalCount }})</b>
                        </p>
                        <p>Итого к оплате: <b>{{ sumEstimate }} руб</b></p>

                        <div class="d-flex mb-3 mt-3">
                            <img class="mr-4" src="/icons/information.svg" alt="">
                            <p style="font-size: calc(0.875rem)" class="mr-5">Счет на оплату сформирован
                                автоматически из сметы. При изменении сметы счет будет создан
                                повторно.</p>
                        </div>
                    </div>
                </div>
            </slot>
        </section>
        <section>
            <slot name="slot-footer" :class="`${modalClass}-footer`">
                <div class="pagination d-flex justify-content-center">
                    <div class="pagination__button">
                        <a class="align-items-center btn d-flex h-100 justify-content-center" href="#"
                           @click="$emit('prevStep')">
                            <u>ВЕРНУТЬСЯ</u>
                        </a>
                    </div>
                    <div class="pagination__button">
                        <button type="button" @click="newEstimate"
                                class="button button-green justify-content-center">Сохранить смету
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex mb-3 mt-3 justify-content-center">
                        <p style="font-size: calc(0.875rem); color: green" class="mr-5">Вы можете
                            сохранять и редактировать смету много раз, до момента ее отправки Заказчику.
                        </p>
                    </div>
                </div>
            </slot>
        </section>
    </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import moment from "moment";
import axios from "axios";
import SportObjectSection from "../deal/SportObjectSection";

export default {
    components: {SportObjectSection},
    data() {
        return {
            time: false,
            sportObject: {
                checkSport: false, sum: 0, price: '', startDate: null, endDate: null,
                colDays: 0, training: 0, time: false, trainingTime_diff: [],
                trainingTime: [{start_1_at: '', start_2_at: ''}, {start_1_at: '', start_2_at: ''}],
            },
            accommodationPrice: {
                checkAccm: false, priceFood: null, sumPriceFood: 0, titlePriceFood: null, typeFood_id: null,
                typePriceFood: null, startDate: null, endDate: null, accommodations: [], sumAccm: 0, daysAccm: 0,
            },
            additionalRent: {
                checkLaundry: false, checkTransfer: false,
                sumLaundry: null, sumTransfer: null, priceTransfer: null, durationTransfer: null,
                washingVolume: null, priceWashing: null, totalPrice: null, infrastructures: [],
            }
        }
    },
    computed: {
        ...mapGetters({
            getDealTender: 'GetDeal',
            allTypeFood: 'AllTypeFoods',
            estimateGetters: 'estimateGetters'
        }),
        dealRequest() {
            return this.dealData?.direct || this.dealData?.responsesTender;
        },
        sumEstimate() {
            const sportSum = this.sportObject.sum ? Number(this.sportObject.sum) : 0;
            const accmSum = this.accommodationPrice.sumAccm ? Number(this.accommodationPrice.sumAccm) : 0;
            const priceFoodSum = this.accommodationPrice.sumPriceFood ? Number(this.accommodationPrice.sumPriceFood) : 0;
            const additionalRentSum = this.additionalRent.totalPrice ? Number(this.additionalRent.totalPrice) : 0;

            return (sportSum + accmSum + priceFoodSum + additionalRentSum).toFixed(2);
        },

        additionalCount() {
            let additionalCount = 0;
            if (this.additionalRent.checkLaundry) additionalCount++;
            if (this.additionalRent.checkTransfer) additionalCount++;
            additionalCount += this.additionalRent.infrastructures.filter(infrastructure => infrastructure.check).length;

            return this.getServiceText(additionalCount);
        }
    },
    methods: {
        ...mapActions(["storeEstimate", "setEstimate", "fetchDeal_estimates"]),
        closeModal() {
            this.$props.estimate = false;
            this.$emit('closeModal', false);
        },
        escCloseModal(e) {
            if (this.show && e.key === 'Escape') {
                this.closeModal();
            }
        },
        getWeekDay(date) {
            date = new Date(date);
            const days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
            const day = date.getDay();

            return days[day];
        },
        getTextDate(start, end) {
            let start_d = moment(new Date(start)).format('LL');
            let end_d = moment(new Date(end)).format('LL');
            return "с " + start_d + " по " + end_d;
        },
        getServiceText(count) {
            let text = "услуг";
            const lastDigit = count % 10;
            const lastTwoDigits = count % 100;
            if (lastDigit === 1 && lastTwoDigits !== 11) {
                text = "услуга";
            } else if (lastDigit >= 2 && lastDigit <= 4 && (lastTwoDigits < 10 || lastTwoDigits >= 20)) {
                text = "услуги";
            }
            return `${count} ${text}`;
        },
        getDaysText(count) {
            let text = "суток";
            if (count === 1) text = 'сутки'
            return `${count} ${text}`;
        },

        newEstimate() {
            if (this.accommodationPrice.typePriceFood) {
                this.accommodationPrice.typeFood_id = this.allTypeFood.find(p => p.title == this.accommodationPrice.typePriceFood)?.id;
            }
            if (this.$props.edit) {
                this.accommodationPrice.id = this.estimateGetters.rentAccommodation.id;
            }
            const estimateData = {
                sportObject_id: this.dealRequest.sportObject.id,
                deal_id: this.dealData.id,
                object: this.sportObject,
                accommodation: this.accommodationPrice,
                additional: this.additionalRent,
                sum: this.sumEstimate,
            };
            if (this.$props.edit) {
                this.$store.dispatch('setEstimate', estimateData).then(() => {
                    this.$emit('confirmEstimate');
                })
            } else {
                this.$store.dispatch('storeEstimate', estimateData)
                    .then(() => {
                        this.$emit('confirmEstimate');
                    });
            }
            if (localStorage.getItem('objectRent') != null) {
                localStorage.removeItem('objectRent');
            }
            if (localStorage.getItem('accommodationRent') != null) {
                localStorage.removeItem('accommodationRent');
            }
            if (localStorage.getItem('additionalRent') != null) {
                localStorage.removeItem('additionalRent');
            }
        },
        loadFromLocalStorage(key, callback) {
            const value = localStorage.getItem(key);
            if (value !== null) {
                const object = JSON.parse(value);
                callback(object);
            }
        }
    },
    mounted() {
        this.loadFromLocalStorage('objectRent', (object) => {
            if (object.object.checkSport) this.sportObject = object.object;
        });
        this.loadFromLocalStorage('accommodationRent', (object) => {
            if (object.accommodation.checkAccm) {
                this.accommodationPrice = object.accommodation;
                this.accommodationPrice.accommodations = object.accommodation.accommodations;
                this.accommodationPrice.typeFood_id = object.accommodation.typeFood_id;
            }
        });
        this.loadFromLocalStorage('additionalRent', (object) => {
            this.additionalRent = object.additional;
            this.additionalRent.infrastructures = object.additional.infrastructures;
        });
    },
    destroy() {
        window.removeEventListener('keydown', this.escCloseModal);
    },
    name: 'PAModal',
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
        edit: {
            type: Boolean
        },
    },
}
</script>

<style scoped>

</style>
