<template>
    <ValidationObserver v-slot="{invalid}" tag="form" @submit.prevent="nextStep">
        <section class="table-responsive-md">
            <slot :class="`${modalClass}-body`">
                <div class="infr-block"
                     v-for="(item, index) in additionalRent.infrastructures">
                    <div class="checkBox">
                        <label class="d-flex align-items-center">
                            <input class="checkBox__check d-none" type="checkbox"
                                   v-model="additionalRent.infrastructures[index].check">
                            <span></span>
                            <p class="pl-3 checkBox__title">{{ item.title }}
                                <b>({{ additionalRentPrice(index) }} руб)</b>
                            </p>
                        </label>
                    </div>
                    <div class="rent-conference" v-if="additionalRent.infrastructures[index].check">
                        <div class="table-rent">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span>Стоимость аренды</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="align-items-center d-flex row">
                                            <div class="col-4">
                                                <ValidationProvider rules="required|numeric|max:5|min:1"
                                                                    v-slot="{ valid, errors, dirty, invalid }">
                                                    <label>
                                                        <input type="text" placeholder="стоимость"
                                                               class="input-profile-info" required
                                                               :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                               autocomplete="off" pattern="^([0-9]+)$"
                                                               maxlength="5"
                                                               :value="additionalRent.infrastructures[index].price"
                                                               @input="inputPrice($event, index)">
                                                    </label>
                                                </ValidationProvider>
                                            </div>
                                            <div class="col-8">
                                                <span>руб/час</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span>Даты аренды</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center date-rent">
                                            <label>
                                                <input type="date" name="search-object"
                                                       class="input-profile-info input-label mt-1"
                                                       :min="nowDate" required
                                                       @change="setEndDate(index)"
                                                       @input="inputDate($event, index)"
                                                       v-model="additionalRent.infrastructures[index].start_date">
                                            </label>
                                            <span class="ml-2 mr-2">&#8212;</span>
                                            <label>
                                                <input type="date" name="search-object"
                                                       class="input-profile-info input-label mt-1"
                                                       :min="additionalRent.infrastructures[index].start_date"
                                                       required @input="inputDate($event, index)"
                                                       v-model="additionalRent.infrastructures[index].end_date">
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-days-training">
                            <table class="table table-borderless">
                                <tr class="table-days-training__title">
                                    <td width="25%" class="pl-0">
                                        <div class="d-flex align-items-center">
                                            <span>Время аренды</span>
                                        </div>
                                    </td>
                                    <td width="37%">
                                        <label style="white-space: nowrap">
                                            <input type="radio" name="radio"
                                                   :name="'checkTime-'+index"
                                                   @change="additionalRent.infrastructures[index].time = false"
                                                   :value="false"
                                                   :checked="!additionalRent.infrastructures[index].time">
                                            в одно время
                                        </label>
                                    </td>
                                    <td width="38%">
                                        <label style="white-space: nowrap">
                                            <input type="radio" name="radio"
                                                   :name="'checkTime-'+index"
                                                   @change="additionalRent.infrastructures[index].time = true"
                                                   :value="true"
                                                   :checked="additionalRent.infrastructures[index].time">
                                            в разное время
                                        </label>
                                    </td>
                                </tr>
                                <tr v-if="!additionalRent.infrastructures[index].time">
                                    <td></td>
                                    <td class="table-days-training__time">
                                        <div class="d-block d-flex align-items-center ">
                                            <label style="white-space: nowrap" class="mb-0">
                                                <input type="time" name="time"
                                                       @input="setEndTimeOnce(index)"
                                                       v-model="additionalRent.infrastructures[index].timing_once[0].start_1_at"/>
                                            </label>
                                            <span class="ml-2 mr-2">&#8212;</span>
                                            <label style="white-space: nowrap" class="mb-0">
                                                <input type="time" name="time"
                                                       v-model="additionalRent.infrastructures[index].timing_once[0].start_1_end"/>
                                            </label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>

                                <tr v-if="additionalRent.infrastructures[index].time">
                                    <td></td>
                                    <td class="table-days-training__time" colspan="2">
                                        <div class="row"
                                             v-for="(time, indexTime) in additionalRent.infrastructures[index].timing">
                                            <div class="col-5">
                                                <label class="w-50"
                                                       style="white-space: nowrap">
                                                    {{ indexTime + 1 }}й день
                                                    ({{ getWeekDay(time.id) }})
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-block d-flex align-items-center ">
                                                    <label style="white-space: nowrap" class="mb-0">
                                                        <input type="time" name="time"
                                                               @input="setEndTime(index, indexTime)"
                                                               v-model="additionalRent.infrastructures[index].timing[indexTime].start_1_at"/>
                                                    </label>
                                                    <span class="ml-2 mr-2">&#8212;</span>
                                                    <label style="white-space: nowrap" class="mb-0">
                                                        <input type="time" name="time"
                                                               v-model="additionalRent.infrastructures[index].timing[indexTime].start_1_end"/>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-block">

                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="checkBox">
                    <label class="d-flex align-items-center">
                        <input class="checkBox__check d-none" type="checkbox"
                               :value="additionalRent.checkLaundry"
                               v-model="additionalRent.checkLaundry">
                        <span></span>
                        <p class="pl-3 checkBox__title">Услуги прачечной
                            <b>({{ sumLaundryShow }} руб)</b>
                        </p>
                    </label>
                </div>
                <div class="row" v-if="additionalRent.checkLaundry">
                    <div class="col-6">
                        <div class="align-items-center d-flex row block-laundry">
                            <div class="col-6 block-laundry__caption">
                                Объем стирки
                            </div>
                            <div class="col-6">
                                <div class="align-items-center d-flex row">
                                    <div class="col-8">
                                        <ValidationProvider rules="required|numeric|max:5|min:1"
                                                            v-slot="{ valid, errors, dirty, invalid }">
                                            <label>
                                                <input type="text" placeholder="123"
                                                       class="input-profile-info" required
                                                       :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                       autocomplete="off" pattern="^([0-9]+)$"
                                                       maxlength="3" minlength="1"
                                                       :value="additionalRent.washingVolume"
                                                       @input="handleInputField($event, 'washingVolume', 999)">
                                            </label>
                                        </ValidationProvider>
                                    </div>
                                    <div class="col-4">
                                        <span class="block-laundry__caption">кг</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="align-items-center d-flex row block-laundry">
                            <div class="col-6 block-laundry__caption">
                                Стоимость
                            </div>
                            <div class="col-6">
                                <div class="align-items-center d-flex row">
                                    <div class="col-8">
                                        <ValidationProvider
                                            rules="required|numeric|max:5|min:1"
                                            v-slot="{ valid, errors, dirty, invalid }">
                                            <label>
                                                <input type="text" placeholder="123"
                                                       class="input-profile-info" required
                                                       :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                       autocomplete="off" pattern="^([0-9]+)$"
                                                       maxlength="3" minlength="1"
                                                       :value="additionalRent.priceWashing"
                                                       @input="handleInputField($event, 'priceWashing', 1000)">
                                            </label>
                                        </ValidationProvider>
                                    </div>
                                    <div class="col-4">
                                        <span class="block-laundry__caption">руб/кг</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="checkBox">
                    <label class="d-flex align-items-center">
                        <input class="checkBox__check d-none" type="checkbox"
                               :value="additionalRent.checkTransfer"
                               v-model="additionalRent.checkTransfer">
                        <span></span>
                        <p class="pl-3 checkBox__title">Трансфер от/до аэропорта на автобусе
                            <b>({{ sumTransfer }} руб)</b>
                        </p>
                    </label>
                </div>
                <div class="block-transfer" v-if="additionalRent.checkTransfer">
                    <div class="row mb-2">
                        <div class="col-8">
                            <div class="align-items-center d-flex row block-transfer">
                                <div class="col-6 block-transfer__caption">
                                    Стоимость аренды
                                </div>
                                <div class="col-6">
                                    <div class="align-items-center d-flex row">
                                        <div class="col-10">
                                            <ValidationProvider
                                                rules="required|numeric|max:5|min:3"
                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <label>
                                                    <input type="text"
                                                           placeholder="от 100 до 10 000"
                                                           class="input-profile-info" required
                                                           :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                           autocomplete="off" pattern="^([0-9]+)$"
                                                           maxlength="5" minlength="3"
                                                           @input="handleInputField($event, 'priceTransfer', 10000)"
                                                           :value="additionalRent.priceTransfer">
                                                </label>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-2">
                                            <span class="block-transfer__caption">руб/час</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="align-items-center d-flex row block-transfer">
                                <div class="col-6 block-transfer__caption">
                                    Период (продолжительность )
                                </div>
                                <div class="col-6">
                                    <div class="align-items-center d-flex row">
                                        <div class="col-10">
                                            <ValidationProvider
                                                rules="required|numeric|max:3|min:2"
                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <label>
                                                    <input type="text" placeholder="от 10 до 100"
                                                           class="input-profile-info" required
                                                           :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                           autocomplete="off" pattern="^([0-9]+)$"
                                                           maxlength="3" minlength="2"
                                                           @input="handleInputField($event, 'durationTransfer', 100)"
                                                           :value="additionalRent.durationTransfer">
                                                </label>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-2">
                                            <span class="block-transfer__caption">часов</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                        </div>
                    </div>
                </div>
            </slot>
        </section>
        <section>
            <slot name="slot-footer" :class="`${modalClass}-footer`">
                <p :class="`${modalClass}-price`"
                   class="d-flex justify-content-center caption mb-2">
                    Стоимость дополнительных услуг: <b class="ml-2">{{ totalPriceShow }} руб
                    ({{ colServices }} услуги)</b>
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
import {mapActions, mapGetters} from "vuex";
import * as moment from "moment";
import SportObjectSection from "../deal/SportObjectSection";

export default {
    components: {SportObjectSection},
    data() {
        return {
            time: false, nowDate: null,
            additionalRent: {
                checkLaundry: false, checkTransfer: false, sumLaundry: null, sumTransfer: null, priceTransfer: null,
                durationTransfer: null, washingVolume: null, priceWashing: null, totalPrice: null, infrastructures: [],
            }
        }
    },
    computed: {
        ...mapGetters({
            estimateAdditional: 'EstimateAdditional',
            getEstimate: 'AllDeal_estimates',
            estimateLoading: 'estimateLoading'
        }),
        sumLaundryShow() {
            this.additionalRent.sumLaundry = this.additionalRent.washingVolume * this.additionalRent.priceWashing
            return this.additionalRent.checkLaundry ? this.additionalRent.sumLaundry : 0;
        },
        sumTransfer() {
            this.additionalRent.sumTransfer = this.additionalRent.durationTransfer * this.additionalRent.priceTransfer;
            return this.additionalRent.checkTransfer ? this.additionalRent.sumTransfer : 0;
        },
        totalPriceShow() {
            let totalPrice = 0;
            for (let i = 0; i < this.additionalRent.infrastructures.length; i++) {
                this.additionalRent.infrastructures[i].sum = parseInt(this.additionalRentPrice(i));
                totalPrice += parseInt(this.additionalRentPrice(i));
            }
            this.additionalRent.totalPrice = this.sumLaundryShow + this.sumTransfer + totalPrice;
            return this.additionalRent.totalPrice;
        },
        myDeal() {
            return this.dealData;
        },
        dealRequest() {
            return this.dealData?.direct || this.dealData?.responsesTender;
        },
        sportObject() {
            return this.dealRequest.sportObject;
        },
        estimateState() {
            return this.estimateAdditional;
        },
        colServices() {
            let total = 0;
            this.additionalRent.checkLaundry ? total += 1 : total += 0;
            this.additionalRent.checkTransfer ? total += 1 : total += 0;
            total += this.additionalRent.infrastructures.filter(p => p.check).length;
            return total;
        },
        editEstimates() {
            return this.getEstimate.filter(p => p.id == this.$props.idEstimate)[0];
        },
    },
    methods: {
        ...mapActions(["addAdditional"]),
        closeModal() {
            this.$props.estimate = false;
            this.$emit('closeModal', false);
        },
        escCloseModal(e) {
            if (this.show && e.key === 'Escape') {
                this.closeModal();
            }
        },
        setEndDate(index) {
            let startDates = new Date(this.additionalRent.infrastructures[index].start_date);
            this.additionalRent.infrastructures[index].end_date = new Date(startDates + 2 * 24 * 60 * 60 * 1000).toISOString().slice(0, 10);
        },
        handleInputField(event, targetField, maxValue) {
            const value = event.target.value;
            if (value.length === 1 && value === "0") {
                return;
            }
            if (value <= maxValue) {
                this.additionalRent[targetField] = value;
                this.$forceUpdate();
            }
        },
        inputPrice(event, index) {
            const value = event.target.value;
            if (value.length === 1 && value === "0") {
                return;
            }
            if (value <= 10000) this.additionalRent.infrastructures[index].price = Number(value);
            this.$forceUpdate();
        },
        setEndTime(index, indexTime) {
            const startTime = this.additionalRent.infrastructures[index].timing[indexTime].start_1_at;
            const m = moment(startTime, 'HH:mm').add(1, 'hours');
            this.additionalRent.infrastructures[index].timing[indexTime].start_1_end = m.format('HH:mm');
        },
        setEndTimeOnce(index) {
            const startTime = this.additionalRent.infrastructures[index].timing_once[0].start_1_at;
            const m = moment(startTime, 'HH:mm').add(1, 'hours');
            this.additionalRent.infrastructures[index].timing_once[0].start_1_end = m.format('HH:mm');
        },
        getWeekDay(date) {
            date = new Date(date);
            const days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
            const day = date.getDay();

            return days[day];
        },
        diffTime(start_time, end_time) {
            if (start_time == null || end_time == null) return 0;
            const startTime = moment(start_time, 'HH:mm');
            const endTime = moment(end_time, 'HH:mm');
            const diffMinutes = endTime.diff(startTime, 'minutes');
            return Math.abs(diffMinutes);
        },
        priceInfrastructure(index) {
            let total = 0.00;
            if (!this.additionalRent.infrastructures[index].time && this.additionalRent.infrastructures[index].timing_once[0].start_1_at) {
                total = this.priceInfrastructureHelper(this.additionalRent.infrastructures[index].timing_once[0].start_1_at, this.additionalRent.infrastructures[index].timing_once[0].start_1_end, this.additionalRent.infrastructures[index].price);
            } else {
                for (let n = 0; n < this.additionalRent.infrastructures[index].timing.length; n++) {
                    if (this.additionalRent.infrastructures[index].timing[n].start_1_at !== '') {
                        total += this.priceInfrastructureHelper(this.additionalRent.infrastructures[index].timing[n].start_1_at, this.additionalRent.infrastructures[index].timing[n].start_1_end, this.additionalRent.infrastructures[index].price);
                    }
                }
            }
            return (total ? total : 0).toFixed(2);
        },

        priceInfrastructureHelper(start_time, end_time, price) {
            const minutes = this.diffTime(start_time, end_time);
            return parseInt(((minutes / 60) * price) + ((price * minutes % 60) / 60));
        },

        additionalRentPrice(index) {
            if (!this.additionalRent.infrastructures[index].check) return 0.00;
            const total = this.additionalRent.infrastructures[index].time
                ? this.additionalRent.infrastructures.reduce((acc, infrastructure) => acc + parseFloat(this.priceInfrastructure(infrastructure.index)), 0)
                : parseFloat(this.priceInfrastructure(index));

            const people = this.myDeal.direct ? this.myDeal.direct.colPeople : this.myDeal.tender.colPeople;
            const diffDays = this.calculateDiffDays(this.additionalRent.infrastructures[index].start_date, this.additionalRent.infrastructures[index].end_date);

            return (diffDays * total).toFixed(2);
          //  return (diffDays * total * people).toFixed(2);
        },

        calculateDiffDays(startDate, endDate) {
            const start = moment(startDate);
            const end = moment(endDate);
            return end.diff(start, 'days') + 1;
        },

        inputDate($event, index) {
            let timing = [];
            const firstDate = new Date(this.additionalRent.infrastructures[index].start_date);
            const secondDate = new Date(this.additionalRent.infrastructures[index].end_date);

            timing.push({
                id: firstDate.toISOString().slice(0, 10),
                start_1_at: '', start_1_end: ''
            })

            while (firstDate < secondDate) {
                firstDate.setDate(firstDate.getDate() + 1);
                timing.push({
                    id: firstDate.toISOString().slice(0, 10),
                    start_1_at: '',
                    start_1_end: ''
                })
            }
            this.additionalRent.infrastructures[index].timing = timing;
        },
        async mountedRent() {
            if (this.$props.edit) {
                const {rentAddition} = await this.$store.dispatch('getEstimate', {id: this.$props.idEstimate});
                this.additionalRent = rentAddition;
                this.additionalRent.infrastructures = rentAddition.infrastructures;
            } else {
                if (localStorage.getItem('additionalRent') != null) {
                    let object = JSON.parse(localStorage.getItem('additionalRent'));
                    this.additionalRent = object.additional
                    this.additionalRent.infrastructures = object.additional.infrastructures;
                }
            }
            if (this.additionalRent.infrastructures.length === 0) {
                const startDate = new Date(this.myDeal.direct ? this.myDeal.direct.fullStartDate : this.myDeal.responsesTender.fullStartDate).toISOString().slice(0, 10);
                const endDate = new Date(this.myDeal.direct ? this.myDeal.direct.fullEndDate : this.myDeal.responsesTender.fullEndDate).toISOString().slice(0, 10);

                for (let i = 0; i < this.sportObject.infrastructures.length; i++) {
                    const infrastructure = this.sportObject.infrastructures[i];

                    if (infrastructure.title !== '') {
                        let price = '';
                        let sum = 0;
                        let time = false;
                        let timing_once = [{start_1_at: '', start_1_end: ''}];
                        let timing = [];

                        this.additionalRent.infrastructures.push({
                            id: infrastructure.id,
                            check: false,
                            title: infrastructure.title,
                            price: price,
                            sum: sum,
                            start_date: startDate,
                            end_date: endDate,
                            time: time,
                            timing: timing,
                            timing_once: timing_once,
                        });

                        const firstDate = new Date(startDate);
                        const secondDate = new Date(endDate);
                        timing.push({
                            id: firstDate.toISOString().slice(0, 10),
                            start_1_at: '',
                            start_1_end: '',
                        });

                        while (firstDate < secondDate) {
                            firstDate.setDate(firstDate.getDate() + 1);
                            timing.push({
                                id: firstDate.toISOString().slice(0, 10),
                                start_1_at: '',
                                start_1_end: '',
                            });
                        }
                    }
                }
            }
        },
        nextStep: function () {
            this.addAdditional({additional: this.additionalRent});
            this.$emit('nextStep');
        },
    },
    mounted() {
        this.mountedRent();
    },
    destroy() {
        window.removeEventListener('keydown', this.escCloseModal);
    },
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
