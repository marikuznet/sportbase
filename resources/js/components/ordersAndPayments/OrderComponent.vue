<template>
    <div class="sb-order-component container">
        <div v-for="deal in orders" :key="deal.id">
            <div class="container mt-3 p-0">
                <div class="container request-object p-0" style="border-radius: 10px 10px 10px 10px;">
                    <div class="col cursor-pointer order pl-lg-5 pt-4"
                         @click="showPageDeal(deal.id, deal.application.id)">
                        <div class="titleObject numOrder pb-2 justify-content-between d-flex flex-column flex-md-row">
                            <h4 class="mb-3 mb-md-0 text-uppercase">Заказ №<span>{{ deal.id }}</span></h4>
                            <div class="d-flex" v-if="[2, 3].includes(deal.status)">
                                <div
                                    class="d-flex notification-red justify-content-center align-items-center border-radius__10">
                                    <span>
                                        {{ deal.status === 2 ? "Сделка отклонена (Заказчиком)" : '' }}
                                        {{ deal.status === 3 ? "Сделка отклонена (Исполнителем)" : '' }}
                                    </span>
                                </div>
                            </div>
                            <template v-if="![2, 3].includes(deal.status)">
                                <div class="d-flex justify-content-center align-items-center border-radius__10"
                                     :class="{'notification-green': deal.step > 1 && deal.step <=5,
                                     'notification-red': deal.step >= 6 || deal.complete === 2 }">
                                    <span v-if="deal.complete === 1">Сделка успешно завершена</span>
                                    <span v-else-if="deal.complete === 2">Сделка завершена с арбитражем</span>
                                    <span v-else>{{ getStatusDeal(deal.step) }}</span>
                                </div>
                            </template>
                            <template v-if="deal.step === 1 && ![2, 3].includes(deal.status)">
                                <div class="d-flex justify-content-center align-items-center notification-orange
                                        border-radius__10"
                                     v-if="(deal.accept_by_customer === 1 && user.role === 3) || (deal.accept_by_executor === 1 && user.role === 2)">
                                    <span>Ожидает вашего решения</span>
                                </div>
                                <div class="d-flex justify-content-center align-items-center notification-blue
                                            border-radius__10" v-else>
                                    <span>Ожидает решения
                                        {{ deal.accept_by_customer === 1 ? 'Исполнителя' : '' }}
                                        {{ deal.accept_by_executor === 1 ? 'Заказчика' : '' }}
                                        </span>
                                </div>
                            </template>
                        </div>
                        <div class="executor-object">
                            <div class="title-info d-flex flex-wrap pr-2 pt-2 pb-2 justify-content-between">
                                <div class="logo d-lg-flex d-none align-items-center">
                                    <h5>Исполнитель</h5>
                                    <div class="logo__circle mr-2 ml-2" style="width: 40px; height: 40px">
                                        <img class="h-100 w-100" style="border-radius: 100%"
                                             :src="getExecutorLogo(deal)" alt="logo">
                                    </div>
                                    <h5 style="color: #6283E5 !important">
                                        {{ getExecutorName(deal) }}
                                    </h5>
                                </div>
                                <div class="logo pt-3 d-lg-none align-items-center flex-wrap">
                                    <h5>Исполнитель</h5>
                                    <div class="d-flex">
                                        <div class="logo__circle mr-2 ml-2" style="width: 40px; height: 40px">
                                            <img class="h-100 w-100" style="border-radius: 100%"
                                                 :src="getExecutorLogo(deal)" alt="logo">
                                        </div>
                                        <h5 style="color: #6283E5 !important;" class="d-flex align-items-center">
                                            {{ getExecutorName(deal) }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr width="100%">
                    <div class="container request-object col pb-3"
                         style="border: none; border-radius: 15px">
                        <div class="titleObject pb-2 justify-content-between d-lg-flex d-none">
                            <h5 class="text-uppercase">
                                {{ deal.sport_object.title }}
                                <span class="pl-3 text-nowrap text-muted text-lowercase objectId">id
                                    {{ deal.sport_object.id }}
                                </span>
                            </h5>
                            <div class="rating-messages d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="rating align-items-center col-auto d-flex">
                                        <div class="d-flex">
                                            <star-rating :increment="0.5" :starSize="16"
                                                         :activeColor="'#F5AE67'" :showRating="false"
                                                         :rating="deal.sport_object.average_rating"
                                                         :read-only="true"/>
                                            <div>
                                                <p>{{ deal.sport_object.average_rating | formatRating }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="align-items-center col-auto d-flex">
                                        <div class="d-flex">
                                            <img class="pr-1" src="/icons/direct/chat.svg" alt="">
                                            <div class="d-flex align-items-center">
                                                <p>{{ deal.sport_object.reviews_count }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mobile titleObject numOrder pb-2 justify-content-between d-lg-none d-block">
                            <h4 class="text-uppercase">
                                {{ deal.sport_object.title }}
                                <span class="pl-3 text-nowrap text-muted text-lowercase objectId">
                                    id{{ deal.sport_object.id }}
                                </span>
                            </h4>
                            <div class="rating-messages d-none d-lg-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="rating align-items-center col-auto d-flex">
                                        <div class="d-flex">
                                            <star-rating :increment="0.5" :starSize="16"
                                                         :activeColor="'#F5AE67'"
                                                         :showRating="false"
                                                         :rating="deal.sport_object.average_rating"
                                                         :read-only="true"></star-rating>
                                            <div>
                                                <p>{{ deal.sport_object.average_rating.toPrecision(3) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="align-items-center col-auto d-flex">
                                        <div class="d-flex">
                                            <img class="pr-1" src="/icons/direct/chat.svg">
                                            <div class="d-flex align-items-center">
                                                <p>{{ deal.sport_object.reviews_count }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info-request-object d-flex flex-wrap justify-content-between align-items-center">
                            <div class="d-lg-flex d-none pb-3">
                                <div class="left d-flex">
                                    <div class="create mr-2">
                                        <div class="title d-flex pb-2">
                                            <img src="/icons/direct/XMLID_14_.svg">
                                            <p class="pl-3 caption">Создана</p>
                                        </div>
                                        <div class="field-green">
                                            <p class="text-nowrap d-flex">{{ createDateFull(deal) }}</p>
                                        </div>
                                    </div>
                                    <div class="create address mr-2 d-none d-lg-block">
                                        <div class="title d-flex pb-2">
                                            <p class="caption">Адрес</p>
                                        </div>
                                        <div class="field-green d-flex">
                                            <p class="text-nowrap caption">{{ getAddress(deal) }}</p>
                                        </div>
                                    </div>
                                    <div class="create mr-2">
                                        <div class="title d-flex pb-2">
                                            <p class="caption">Стоимость</p>
                                            <p class="d-lg-none d-block">(за человека)</p>
                                        </div>
                                        <div class="price d-flex align-items-center">
                                            <div class="field-blue mr-2">
                                                <p class="text-nowrap">{{ getMinPrice(deal) }} руб.</p>
                                            </div>
                                            <p class="text-nowrap">за сутки</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-lg-none pb-3 ">
                                <div class="create">
                                    <div class="title d-flex pb-2 align-items-end">
                                        <img src="/icons/direct/XMLID_14_.svg" alt="date">
                                        <p class="pl-2 caption">Создана</p>
                                    </div>
                                    <div class="field-green mb-3">
                                        <p class="text-nowrap d-flex">{{ createDateFull(deal) }}</p>
                                    </div>
                                </div>
                                <div class="create mobile-address mr-2 mb-3">
                                    <div class="title d-flex">
                                        <p class="caption">Адрес</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="subtitle text-nowrap">{{ getAddress(deal) }}</p>
                                    </div>
                                </div>
                                <div class="left d-flex mb-3">
                                    <div class="create mr-2">
                                        <div class="title d-flex pb-1">
                                            <p class="caption">Стоимость</p>
                                        </div>
                                        <div class="price d-flex align-items-center">
                                            <div class="field-blue mr-2">
                                                <p class="text-nowrap">{{ getMinPrice(deal) }} руб.</p>
                                            </div>
                                            <p class="text-nowrap">за сутки</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="rating-messages mb-3 pt-0 justify-content-between">
                                    <div class="d-flex">
                                        <div class="rating align-items-center col-auto d-flex">
                                            <div class="d-flex">
                                                <star-rating :increment="0.5" :starSize="16"
                                                             :activeColor="'#F5AE67'"
                                                             :showRating="false"
                                                             :rating="deal.sport_object.average_rating"
                                                             :read-only="true"></star-rating>
                                                <div>
                                                    <p>{{ deal.sport_object.average_rating | formatRating }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="align-items-center col-auto d-flex">
                                            <div class="d-flex">
                                                <img class="pr-1" src="/icons/direct/chat.svg">
                                                <div class="d-flex align-items-center">
                                                    <p>{{ deal.sport_object.reviews_count }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="arrow-button d-flex d-lg-none justify-content-center shadow"
                                     style="cursor:pointer"
                                     @click="openInvoice(deal.estimates[deal.estimates.length - 1])">
                                    <img width="20px" src="/icons/pdf-file.svg" alt="">
                                </div>
                            </div>
                            <div class="arrow-button d-none d-lg-flex justify-content-center shadow"
                                 style="cursor:pointer" @click="openInvoice(deal.estimates[deal.estimates.length - 1])">
                                <img width="20px" src="/icons/pdf-file.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating';
import {mapGetters, mapActions} from 'vuex';
import moment from "moment";
import DealStatusSection from "../tenders/DealStatusSection";

export default {
    name: "OrderComponent",
    components: {DealStatusSection, StarRating, moment},
    props: {
        orders: {
            type: Array,
            default: null
        }
    },
    computed: {
        ...mapGetters({
            getEstimate: 'GetEstimates',
        }),
        user: function () {
            return window.user;
        },
    },
    data() {
        return {
            statusDealEnum: [{step: 2, title: 'В процессе выполнения (шаг 2)', color: '#56C46F'},
                {step: 3, title: 'В процессе выполнения (шаг 3)', color: '#56C46F'},
                {step: 4, title: 'Завершена', color: '#56C46F'},
                {step: 5, title: 'Завершена', color: '#56C46F'},
                // {step: 4, title: 'В процессе выполнения (шаг 4)', color: '#56C46F'},
                // {step: 5, title: 'В процессе выполнения (шаг 5)', color: '#56C46F'},
                {step: 6, title: 'На арбитраже (со стороны Заказчика)', color: '#e45868'},
                {step: 7, title: 'На арбитраже (со стороны Исполнителя)', color: '#e45868'}
            ],
        }
    },
    methods: {
        showPageDeal(deal_id, application_id) {
            window.location.href = `/transaction/deal/${deal_id || application_id}`;
        },
        getStatusDeal(step) {
            const deal = this.statusDealEnum.find(f => f.step === step);
            return deal?.title ?? '';
        },
        momentMonthDate(date) {
            return moment(moment(date)).format('LL');
        },
        downloadInvoice(estimate) {
            let services = [];
            let accommodations = estimate.rentAccommodation.accommodations;

            if (estimate.rentSportObject.checkSport && estimate.rentSportObject.sum != 0)
                services.push({
                    title: 'Аренда спортивного объекта',
                    price: estimate.rentSportObject.sum,
                    justification: estimate.rentSportObject.price + 'руб/час' + "\n",
                });

            if (estimate.rentAccommodation.checkAccm) {
                let options = '';
                let justif = "Даты размещения: " + this.momentMonthDate(estimate.rentAccommodation.start_date) + " - "
                    + this.momentMonthDate(estimate.rentAccommodation.end_date) + "\n ";

                for (let i = 0; i < accommodations.length; i++) {
                    if (accommodations[i].check) {
                        justif += accommodations[i].title;
                        for (let a = 0; a < accommodations[i].options.length; a++) {
                            let colNum = accommodations[i].options[a].colNum != null ? accommodations[i].options[a].colNum : 1;
                            let places = accommodations[i].options[a].places.title;
                            options += " (" + places + " , номеров: " + colNum + ")";
                        }
                        justif += options + "; \n";
                    }
                }
                services.push({
                    title: 'Размещение',
                    price: estimate.rentAccommodation.sumAccm,
                    justification: justif,
                });
            }
            if (estimate.rentAccommodation.checkAccm && estimate.rentAccommodation.priceFood != null) {
                services.push({
                    title: 'Питание',
                    price: estimate.rentAccommodation.sumPriceFood,
                    justification: "Тип питания: " + estimate.rentAccommodation.typeFood + "\n",
                });
            }

            let infrastructures = estimate.rentAddition.infrastructures;
            let justif_infr = '';
            for (let i = 0; i < infrastructures.length; i++) {
                if (infrastructures[i].check) {
                    justif_infr = "Даты размещения: " + this.momentMonthDate(infrastructures[i].start_date) + " - "
                        + this.momentMonthDate(infrastructures[i].end_date) + " \n ";
                    services.push({
                        title: infrastructures[i].title,
                        price: infrastructures[i].price,
                        justification: justif_infr,
                    })
                }
            }
            if (estimate.rentAddition.checkLaundry) services.push({
                title: 'Услуги прачечной',
                price: estimate.rentAddition.sumLaundry,
                justification: 'Объем стирки: ' + estimate.rentAddition.washingVolume + ' кг, цена за кг: '
                    + estimate.rentAddition.priceWashing + ' руб. \n',
            });
            if (estimate.rentAddition.checkTransfer) services.push({
                title: 'Трансфер от/до аэропорта на автобусе',
                price: estimate.rentAddition.sumTransfer,
                justification: 'Период(продолжительность): ' + estimate.rentAddition.durationTransfer
                    + " часов, стоимость за час: " + estimate.rentAddition.priceTransfer + " руб. \n",
            });
            let total = services.reduce((sum, service) => sum + Number(service.price), 0);

            axios.put('/invoices/download/', {
                'deal_id': estimate.deal_id,
                'est_id': estimate.id,
                'services': services,
                'total': total,
            }).then(response => {
                window.open("/storage/listings/estimate/" + estimate.deal_id + "/" + estimate.id, '_blank');
            })
        },
        openInvoice(estimate) {
            window.open(`/storage/listings/estimate/${estimate.deal_id}/${estimate.id}`, '_blank');
        },
        getExecutorName(deal) {
            return deal.tender ? deal.responses_tender.company_info.full_name : deal.application.owner_info.title;
        },
        getExecutorLogo(deal) {
            return `/storage/listings/logos/${deal.tender ? deal.responses_tender.company_info.user_id : deal.application.owner_info.user_id}/${deal.tender ? deal.responses_tender.company_info.image : deal.application.owner_info.image}`;
        },
        createDateFull(deal) {
            return deal.direct ? `${deal.application.createDate_full} в ${deal.application.createDate_time}` : `${deal.responses_tender.createDate_month} ${deal.responses_tender.createDate_year} в ${deal.responses_tender.createDate_time}`;
        },
        getAddress(deal) {
            return `Россия, ${deal.direct ? deal.application.sport_object.city : deal.responses_tender.sport_object.city}, ${deal.direct ? deal.application.sport_object.address : deal.responses_tender.sport_object.address}`;
        },
        getMinPrice(deal) {
            return deal.direct ? deal.application.sport_object.minPrice : deal.responses_tender.sport_object.minPrice;
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
