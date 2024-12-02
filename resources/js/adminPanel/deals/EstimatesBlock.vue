<template>
    <div>
        <div class="mb-3" v-for="(estimate, index) in estimates">
            <div class="row">
                <div class="col-9">
                    <div class="block-estimate border-black pl-3 pr-3">
                        <div class="row border-bottom pt-3 pb-3">
                            <div class="col-5">
                                <b>Смета №{{ estimate.id }}</b>
                            </div>
                            <div class="col-3">
                                <a href="#">Смета на услуги</a>
                            </div>
                            <div class="col-3">
                                <a href="#">Счет на оплату услуг</a>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <h6><b>Аренда спортивного объекта</b></h6>
                                <div class="rent-object">
                                    <h6>Стоимость аренды: {{ estimate.rentSportObject.price }}
                                        руб/час</h6>
                                    <h6>Даты пребывания: c
                                        {{ getDate(estimate.rentSportObject.start_date) }} по
                                        {{ getDate(estimate.rentSportObject.end_date) }}
                                        {{ getYear(estimate.rentSportObject.end_date) }}</h6>
                                </div>
                            </div>
                            <div class="col-6" v-if="estimate.rentAccommodation.checkAccm">
                                <h6><b>Размещение</b></h6>
                                <div class="rent-accom">
                                    <h6>Количество и стоимость проживания:</h6>

                                    <div v-for="accm in estimate.rentAccommodation.accommodations"
                                         v-if="accm.check">
                                        <h6>{{ accm.title }}</h6>
                                        <div v-if="accm.options" v-for="option in accm.options">
                                            <h6>* {{ option.places['title'] }}: {{ option.price }}
                                                руб/сутки</h6>
                                        </div>
                                    </div>
                                    <h6>Даты размещения: c
                                        {{ getDate(estimate.rentAccommodation.start_date) }} по
                                        {{ getDate(estimate.rentAccommodation.end_date) }}
                                        {{ getYear(estimate.rentAccommodation.end_date) }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <h6><b>Питание</b></h6>
                                <h6 v-if="estimate.rentAccommodation.titlePriceFood == 'Входит в стоимость'">
                                    Включено в стоимость ({{ estimate.rentAccommodation.typeFood }})
                                </h6>
                                <h6 v-else>Не включено в стоимость
                                    ({{ estimate.rentAccommodation.typeFood }})</h6>
                            </div>
                            <div class="col-6">
                                <h6><b>Сумма к оплате</b></h6>
                                <h6>Стоимость аренды:
                                    <b>{{ estimate.rentSportObject.sum.toFixed(2) }}
                                        руб </b><span class="days">за {{
                                            getDays(estimate.rentSportObject.start_date, estimate.rentSportObject.end_date)
                                        }} суток</span>
                                </h6>
                                <h6>Стоимость размещения:
                                    <b>{{ estimate.rentAccommodation.sumAccm.toFixed(2) }}
                                        руб </b><span
                                        class="days">за {{
                                            getDays(estimate.rentAccommodation.start_date, estimate.rentAccommodation.end_date)
                                        }} суток</span>
                                </h6>
                                <h6>Стоимость питания:
                                    <b>{{ estimate.rentAccommodation.sumPriceFood }}
                                        руб </b> <span class="days">за {{
                                            getDays(estimate.rentAccommodation.start_date, estimate.rentAccommodation.end_date)
                                        }} суток</span>
                                </h6>
                                <h6>Стоимость дополнительных услуг:
                                    <b>{{ estimate.rentAddition.totalPrice.toFixed(2) }}</b>
                                </h6>
                                <h6>Итого: <b>{{
                                        (estimate.rentSportObject.sum + estimate.rentAccommodation.sumPriceFood + estimate.rentAccommodation.sumAccm
                                            + estimate.rentAddition.totalPrice).toFixed(2)
                                    }} руб</b></h6>
                            </div>
                        </div>
                        <div
                            v-if="estimate.show_customer == 0 || estimate.show_customer == null || (estimate.show_customer == 1 && estimate.status < 3)"
                            class="row info-block ml-0">
                            <p style="color: lightskyblue">Счет на оплату сформирован автоматически
                                из сметы. При изменении сметы счет будет создан повторно.</p>
                        </div>
                        <div
                            v-if="estimate.show_customer == 0 || estimate.show_customer == null || (estimate.show_customer == 1 && estimate.status < 3)"
                            class="row pt-3 align-items-center" style="background-color: lightgray">
                            <div class="col-6">
                                <p v-if="isCustomer" style="color: dodgerblue">
                                    Смета и счет на оплату получены от Исполнителя. Оплатите ее в
                                    течении 3х дней.</p>
                                <p v-if="!isCustomer" style="color: dodgerblue">
                                    Смета и счет отправлены заказчику на оплату. Ожидайте подтверждения оплаты от
                                    заказчика.</p>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <p style="color: dodgerblue">Осталось времени до конца срока оплаты по счету</p>
                                    </div>
                                    <div v-if="estimate.show_customer == 1 && index == estimates.length - 1"
                                         class="col-6">
                                        <div>
                                            <vue-countdown-timer
                                                :start-time="estimate.date_send"
                                                :end-time="momentDay(estimate.date_send)"
                                                :interval="1000"
                                                label-position="begin"
                                                :end-text="'0 дня 00 часа'"
                                                :day-txt="'дня'"
                                                :hour-txt="'часа'">
                                                <template slot="countdown" slot-scope="scope">
                                                    <div
                                                        class="active time p-2 align-items-center justify-content-center"
                                                        style="background-color: #6FB77F">
                                                        <span>{{ scope.props.days }}</span>
                                                        {{
                                                            getNoun(scope.props.dayTxt, ' день', ' дня', ' дней')
                                                        }}
                                                        <span>{{ scope.props.hours }}</span>
                                                        {{
                                                            getNoun(scope.props.hourTxt, ' час', ' часа', ' часов')
                                                        }}
                                                    </div>
                                                </template>
                                                <template slot="end-text" slot-scope="scope">
                                                    <div
                                                        class="active time p-2 align-items-center justify-content-center"
                                                        style="background-color: rgb(243,122,138)">
                                                        <span>{{ scope.props.endText }}</span>
                                                    </div>
                                                </template>
                                            </vue-countdown-timer>
                                        </div>
                                    </div>
                                    <div class="col-6" v-else>
                                        <div
                                            class="block-darkGrey p-1 d-flex justify-content-center">
                                            <h6><b>0 дней 00 часов</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <p>Исполнитель</p>
                    <div class="d-flex">
                        <div class="img mr-1 block__circle" style="width: 40px; height: 40px">
                            <img class="w-100 h-100"
                                 :src="`/storage/listings/logos/${myDeal.sportObject.created.user_id}/${myDeal.sportObject.created.image}`"
                                 alt="logo">
                        </div>
                        <p><b>{{ myDeal.sportObject.created.title }}</b></p>
                    </div>
                </div>
            </div>
            <div class="block-days-ago">
                <p class="text-muted">{{ fromNow(estimate.deal_date_ago) }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "EstimatesBlock",
    props: ["estimates", "myDeal", "isCustomer"],
    methods: {
        fromNow(deal_date) {
            const fromNow = moment(deal_date);
            return fromNow.fromNow();
        },
        getDate(date) {
            return moment(new Date(date)).format("D MMMM");
        },
        getYear(date) {
            return moment(new Date(date)).format("YYYY");
        },
        getDays(start, end) {
            let start_date = moment(new Date(start));
            let end_date = moment(new Date(end)).add(1, 'day');
            return end_date.diff(start_date, 'days');
        },
        momentDay(date) {
            const __startTime = moment(moment(new Date())).format();
            const __endTime = moment(moment(date).add(3, 'days')).format();
            const __duration = moment.duration(moment(__endTime).diff(__startTime));
            const __hours = __duration.asHours();
            const __days = __duration.asDays();
            this.showPaymentExpired = __days < 0 && __hours < 0;
            return moment(date).add(3, 'days')
        },
        getNoun(number, one, two, five) {
            let n = Math.abs(number);
            n %= 100;
            if (n >= 5 && n <= 20) {
                return five;
            }
            n %= 10;
            if (n === 1) {
                return one;
            }
            if (n >= 2 && n <= 4) {
                return two;
            }
            return five;
        },
    }
}
</script>

<style scoped>

</style>
