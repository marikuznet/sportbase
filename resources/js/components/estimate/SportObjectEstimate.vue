<template>
    <ValidationObserver v-slot="{invalid}" tag="form" ref="observer" @submit.prevent="nextStep">
        <section class="table-responsive-md">
            <slot :class="`${modalClass}-body`">
                <div class="checkBox">
                    <label class="d-flex align-items-center">
                        <input class="checkBox__check d-none" type="checkbox"
                               v-model="objectRent.checkSport" :value="objectRent.checkSport">
                        <span></span>
                        <p class="pl-3 checkBox__title">Включить в смету аренду спорт. объекта</p>
                    </label>
                </div>
                <div class="rent-object" v-if="objectRent.checkSport">
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
                                        <div class="col-8">
                                            <ValidationProvider rules="required|numeric|max:5|min:1|positive"
                                                                v-slot="{ errors, failed }">
                                                <input type="text" placeholder="стоимость" class="input-profile-info"
                                                       required @input="inputPrice" :value="objectRent.price"
                                                       :class="{ 'is-invalid': failed }" maxlength="5" minlength="1">
                                                <span class="error-valid mt-2">{{ errors[0] }}</span>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-4">
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
                                        <input type="date" name="search-object"
                                               class="input-profile-info input-label mt-1" :min="nowDate"
                                               required @change="setEndDate" v-model="objectRent.startDate">

                                        <span class="ml-2 mr-2">&#8212;</span>

                                        <input type="date" name="search-object"
                                               class="input-profile-info input-label mt-1"
                                               :min="objectRent.startDate" required v-model="objectRent.endDate">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span>Тренировки</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="label-radio-wrapp training-list__item">
                                            <input name="training-type" id="training-no" type="radio" value="0" checked
                                                   class="label-radio-wrapp__radio d-none"
                                                   v-model="objectRent.training">
                                            <label for="training-no"
                                                   class="label-radio-wrapp__label d-flex align-items-center">нет</label>
                                        </div>
                                        <div class="label-radio-wrapp training-list__item">
                                            <input name="training-type" id="training-one" value="1" type="radio"
                                                   class="label-radio-wrapp__radio d-none align-items-center"
                                                   v-model="objectRent.training">
                                            <label for="training-one"
                                                   class="label-radio-wrapp__label d-flex align-items-center">1
                                                раз/день</label>
                                        </div>
                                        <div class="label-radio-wrapp training-list__item">
                                            <input name="training-type" id="training-two" value="2" type="radio"
                                                   class="label-radio-wrapp__radio d-none align-items-center"
                                                   v-model="objectRent.training">
                                            <label for="training-two"
                                                   class="label-radio-wrapp__label d-flex align-items-center">2
                                                раза/день</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-days-training" v-if="objectRent.training != 0">
                        <table class="table table-borderless">
                            <tr class="table-days-training__title">
                                <td width="25%">
                                    <div class="d-flex align-items-center">
                                        <span>Дни и время тренировок</span>
                                    </div>
                                </td>
                                <td width="37%">
                                    <label style="white-space: nowrap" class="align-items-center d-flex mb-0 pb-0">
                                        <input :value="objectRent.time"
                                               @change="objectRent.time = false" type="radio"
                                               :checked="objectRent.time === false"
                                               name="radio">в одно время
                                    </label>
                                </td>
                                <td width="38%">
                                    <label style="white-space: nowrap" class="align-items-center d-flex mb-0 pb-0">
                                        <input :value="objectRent.time"
                                               @change="objectRent.time = true" type="radio"
                                               :checked="objectRent.time === true"
                                               name="radio">в разное время
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <b>день пребывания</b>
                                </td>
                                <td>
                                    <b>время тренировки</b>
                                </td>
                            </tr>
                            <table-days-training-time v-if="!objectRent.time"
                                                      :training="Number(objectRent.training)"
                                                      :trainingTime="objectRent.trainingTime"
                                                      @update-training-time="objectRent.trainingTime = $event"/>

                            <tr v-if="objectRent.training != 0 && objectRent.time"
                                v-for="(date, index) in allDate">
                                <td></td>
                                <td>
                                    {{ index + 1 }}й день ({{ getWeekDay(date) }})
                                </td>
                                <td class="table-days-training__time">
                                    <div class="d-block">
                                        <label style="white-space: nowrap">1-я
                                            <ValidationProvider rules="required"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <input :class="{ 'is-invalid': errors[0] }"
                                                       required @input="setEndTime(index)"
                                                       v-model="objectRent.trainingTime_diff[index].start_1_at"
                                                       type="time" name="time" class="w-50"
                                                       max="18:00"/>
                                            </ValidationProvider>
                                            <ValidationProvider rules="required|greaterThanStart"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <input :class="{ 'is-invalid': errors[0] }"
                                                       type="time" name="time" class="w-50" required
                                                       v-model="objectRent.trainingTime_diff[index].end_1_at"
                                                       :rules="`required|greaterThanStart:${objectRent.trainingTime_diff[index].start_1_at}`"/>
                                            </ValidationProvider>
                                        </label>
                                        <label v-if="objectRent.training == 2"
                                               style="white-space: nowrap">2-я
                                            <ValidationProvider rules="required"
                                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <input :class="{ 'is-invalid': errors[0] }" required
                                                       v-model="objectRent.trainingTime_diff[index].start_2_at"
                                                       type="time" name="time" class="w-50"
                                                       @input="setEndTime(index)"/>
                                            </ValidationProvider>
                                            <ValidationProvider
                                                :rules="`required|greaterThanStart:${objectRent.trainingTime_diff[index].start_2_at}`"
                                                v-slot="{ valid, errors, dirty, invalid }">
                                                <input required :class="{ 'is-invalid': errors[0] }"
                                                       v-model="objectRent.trainingTime_diff[index].end_2_at"
                                                       type="time" name="time" class="w-50"/>
                                            </ValidationProvider>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </slot>
        </section>
        <template>
            <slot name="slot-footer" :class="`${modalClass}-footer`">
                <p :class="`${modalClass}-price`" v-if="objectRent.checkSport"
                   class="d-flex justify-content-center caption mb-2">
                    Стоимость аренды объекта: <b class="ml-2">{{ objectRentPrice }} руб (за
                    {{ objectRentDays }} суток)</b>
                </p>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="button button-green justify-content-center">Далее
                    </button>
                </div>
            </slot>
        </template>
    </ValidationObserver>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import * as moment from "moment";
import SportObjectSection from "../deal/SportObjectSection";
import TimeInput from "../deal/TimeInput";
import TableDaysTrainingTime from "./TableDaysTrainingTime";


export default {
    name: 'PAModal',
    components: { TableDaysTrainingTime, TimeInput, SportObjectSection },
    props: {
        modalClass: {
            type: String,
            default: 'simple-modal',
        },
        dealData: {
            type: Object,
            required: true,
        },
        idEstimate: {
            type: Number,
            default: null,
        },
        edit: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            nowDate: null,
            objectRent: {
                checkSport: false,
                sum: 0,
                price: '',
                startDate: this.formatDate(new Date()),
                endDate: this.formatDate(new Date(Date.now() + 1 * 24 * 60 * 60 * 1000)),
                colDays: 0,
                training: 0,
                time: false,
                trainingTime_diff: [{ start_1_at: '', end_1_at: '', start_2_at: '', end_2_at: '' }],
                trainingTime: [{ start_1_at: '', end_1_at: '', start_2_at: '', end_2_at: '' }],
            },
        };
    },
    computed: {
        ...mapGetters({
            estimateLoading: 'estimateLoading',
            estimateGetters: 'estimateGetters',
        }),
        objectRentDays() {
            const endDate = new Date(this.objectRent.endDate);
            const timeDiff = Math.abs(endDate.setDate(endDate.getDate() + 1) - new Date(this.objectRent.startDate));
            this.objectRent.colDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            return this.objectRent.colDays;
        },
        objectRentPrice() {
            let totalPrice = 0;
            if (this.objectRent.training === 0) {
                totalPrice = 0;
                return totalPrice.toFixed(2);
            }
            if (!this.objectRent.time) {
                totalPrice = this.priceTraining(0) * this.objectRentDays;
            } else {
                const trainingTimes = this.objectRent.trainingTime_diff || this.objectRent.trainingTime;
                for (let i = 0; i < trainingTimes.length; i++) {
                    totalPrice += this.priceTraining(i);
                }
            }
            this.objectRent.sum = totalPrice;
            return totalPrice.toFixed(2);
        },
        allDate() {
            if (!this.objectRent.time) return [];
            const dates = [];
            this.objectRent.trainingTime_diff = [];
            const start = new Date(this.objectRent.startDate);
            const end = new Date(this.objectRent.endDate);

            for (let d = start; d <= end; d.setDate(d.getDate() + 1)) {
                const dateStr = this.formatDate(new Date(d));
                dates.push(dateStr);
                this.objectRent.trainingTime_diff.push({ id: dateStr, start_1_at: '', end_1_at: '', start_2_at: '', end_2_at: '' });
            }
            return dates;
        },
        dealRequest() {
            return this.dealData?.direct || this.dealData?.responsesTender;
        },
    },
    methods: {
        ...mapActions(["addObject", "setStoreEstimate"]),

        // Close modal
        closeModal() {
            this.$emit('closeModal', false);
        },

        // Close modal on Escape key
        escCloseModal(e) {
            if (this.show && e.key === 'Escape') {
                this.closeModal();
            }
        },

        // Set end date based on the number of days added
        setEndDate(daysToAdd) {
            const startDate = moment(this.objectRent.startDate);
            this.objectRent.endDate = startDate.add(daysToAdd, 'days').format('YYYY-MM-DD');
            this.objectRent.trainingTime_diff = [];
        },

        // Get the day of the week
        getWeekDay(date) {
            const days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
            return days[new Date(date).getDay()];
        },

        // Handle price input
        inputPrice(event) {
            const value = event.target.value;
            if (value.length === 1 && value === "0") return;

            if (value <= 10000) {
                this.objectRent.price = value;
            }
            this.$forceUpdate();
        },

        setEndTime(index) {
            const timeFormats = ['HH:mm', 'H:mm'];
            const { start_1_at, start_2_at } = this.objectRent.trainingTime_diff[index];
            this.objectRent.trainingTime_diff[index].end_1_at = moment(start_1_at, timeFormats).add(1, 'hour').format('HH:mm');
            this.objectRent.trainingTime_diff[index].end_2_at = moment(start_2_at, timeFormats).add(1, 'hour').format('HH:mm');
        },

        priceTraining(index) {
            const { price } = this.objectRent;
            const trainingTime = this.objectRent.time ? this.objectRent.trainingTime_diff : this.objectRent.trainingTime;
            const { start_1_at = 0, end_1_at = 0, start_2_at = 0, end_2_at = 0 } = trainingTime[index];

            const minutes1 = moment(end_1_at, 'HH:mm').diff(moment(start_1_at, 'HH:mm'), 'minutes');
            const minutes2 = this.objectRent.training === 2 ? moment(end_2_at, 'HH:mm').diff(moment(start_2_at, 'HH:mm'), 'minutes') : 0;
            const totalMinutes = minutes1 + minutes2;
            const totalHours = Math.floor(totalMinutes / 60);
            const totalMinutesRemainder = totalMinutes % 60;

            return isNaN(totalHours * price + totalMinutesRemainder * (price / 60)) ? 0 : (totalHours * price) + (totalMinutesRemainder * (price / 60));
        },

        async nextStep() {
            const success = await this.$refs.observer.validate();
            if (success) {
                this.addObject({ object: this.objectRent });
                this.$emit('nextStep');
            } else {
                const firstErrorField = Object.keys(this.$refs.observer.errors).find(key => this.$refs.observer.errors[key].length);
                this.$refs.observer.refs[firstErrorField].$el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        },

        formatDate(date) {
            return moment(date).format("YYYY-MM-DD");
        }
    },
    async mounted() {
        const { fullStartDate, fullEndDate, colPeople, minPrice } = this.dealRequest;
        this.objectRent.startDate = this.formatDate(new Date(fullStartDate));
        this.objectRent.endDate = this.formatDate(new Date(fullEndDate));
        this.objectRent.colPeople = colPeople;
        this.objectRent.minPrice = minPrice;

        if (this.edit) {
            await this.$store.dispatch('getEstimate', { id: this.idEstimate });
            this.objectRent = this.estimateGetters.rentSportObject;

            if (this.objectRent.checkSport) {
                const { start_date, end_date } = this.estimateGetters.rentSportObject;
                this.objectRent.startDate = this.formatDate(new Date(start_date));
                this.objectRent.endDate = this.formatDate(new Date(end_date));
                this.addObject({ object: this.objectRent });
            }
        } else {
            const object = JSON.parse(localStorage.getItem('objectRent'));
            if (object) {
                this.objectRent = object.object;
            }
        }
    },
    destroyed() {
        window.removeEventListener('keydown', this.escCloseModal);
    },
};
</script>

<style scoped>
.is-invalid {
    color: rgb(243, 122, 138) !important;
    border: 1px solid rgb(243, 122, 138) !important;
}
</style>
