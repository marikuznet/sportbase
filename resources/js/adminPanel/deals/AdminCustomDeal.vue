<template>
    <div v-if="deal" class="custom-deal">
        <div class="border-black mb-2">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-12 b-b-2 mb-3 pt-3 bg-gray-100">
                        <div v-if="dealType === 'direct'" class="bg-gray-100 text-body pt-3 pl-3 pr-3 pb-3"
                             style="background-color: lightgray;">
                            <div class="row">
                                <div class="col-4">
                                    <p><b>создана:</b> {{ deal.fullDate }}</p>
                                </div>
                                <div class="col-4">
                                    <p><b>пребывание:</b> {{ deal.startDate_day }} -
                                        {{ deal.endDate }}
                                        {{ deal.spreadDate }}</p>
                                </div>
                                <div class="col-2"><p>{{ deal.colPeople }} чел</p></div>
                                <div class="col-2"><p>до {{ deal.priceForPerson }} Р/чел</p></div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <b>{{ sportObject.title }} (id: {{
                                            sportObject.id
                                        }})</b>
                                </div>
                                <div class="col-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                     :showRating="false" :rating="sportObject.average_rating"
                                                     :read-only="true"></star-rating>
                                        {{ sportObject.average_rating }}
                                    </div>
                                </div>
                                <div class="col-2"><p>отзывы: {{ sportObject.reviews_count }}</p></div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <b>Заказчик {{ deal.customer_info.title }}
                                        (ID: {{ deal.customer_info.user_id }})</b>
                                </div>
                            </div>
                        </div>
                        <div v-if="dealType !== 'direct'" class="align-items-center d-flex">
                            <b>{{
                                    dealType === 'tender' ? 'ЗАЯВКА ОТ ЗАКАЗЧИКА' : (dealType === 'response' ? 'ОТКЛИК ИСПОЛНИТЕЛЬ' : '')
                                }}</b>
                            <h6 class="text-muted m-0 p-0 ml-2">
                                Дата создания заявки: {{ deal.fullDate }}
                            </h6>
                        </div>
                        <div v-if="dealType === 'tender'" class="d-flex align-items-baseline">
                            <b class="mr-2">Заказчик</b>
                            <h6><b>{{ deal.customer_info.title }} (ID: {{ deal.customer_info.user_id }})</b></h6>
                        </div>
                        <div v-if="dealType === 'response'" class="d-flex align-items-baseline">
                            <b class="mr-2">Исполнитель</b>
                            <h6><b>{{ deal.sportObject.created.title }} (ID: {{ deal.sportObject.created.user_id }})</b>
                            </h6>
                        </div>
                    </div>
                    <div class="col-lg-6" v-for="(detail, key) in details" :key="key">
                        <div class="item-request mb-3">
                            <h6><b>{{ detail.label }}</b></h6>
                            <h6>
                                <span v-for="(item, index) in detail.items">
                                    {{ item }}{{ index < detail.items.length - 1 ? ', ' : '' }}
                                </span>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="item-request">
                    <h6><b>Комментарий.</b> <i>{{ deal.comment }}</i></h6>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating';

export default {
    name: "AdminCustomDeal",
    components: {StarRating},
    props: {
        deal: Object,
        dealType: String,
        sportObject: Object
    },
    computed: {
        details() {
            return [
                {label: 'Вид спорта', items: this.deal.type_sports.map(item => item.title)},
                {label: 'Инфраструктура', items: this.deal.infrastructures.map(item => item.title)},
                {label: 'Адрес объекта', items: [`${this.deal.country}, ${this.deal.city}`]},
                {
                    label: 'Дата пребывания', items: [`с ${this.deal.startDate} по ${this.deal.endDate}
                                                ${this.deal.endDate_year}
                                                ${this.deal.spreadDate}`]
                },
                {label: 'Тип питания', items: this.deal.typeFoods.map(item => item.title)},
                {label: 'Дополнительные услуги', items: this.deal.additionsTender.map(item => item.title)},
                {label: 'Количество человек', items: [`${this.deal.colPeople}`]},
                {label: 'Cтоимость (за 1го человека)', items: [`${this.deal.minPrice} руб/сутки`]},
            ];
        }
    }
}
</script>

<style scoped>

</style>
