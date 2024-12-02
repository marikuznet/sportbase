<template>
    <main>
        <breadcrumbs :items="[{text:'Заявки (Тендерные)', href: '/admin/applications/tender'},
        {text: `Тендер (id: ${tender.id})`, active:true}]"/>

        <div v-if="tender" class="container">
            <modal-notification id="sb-notification-delete" ref="sb-notification-delete"
                                modal_class="sb-notification-delete" title="Удаление"
                                :content="`Подтвердите удаление тендера #${tender.id}`"
                                @left_action="deleteTender(tender.id)"
                                @right_action="closeModalDelete()"
                                left_button="Удалить" right_button="НЕ УДАЛЯТЬ"/>

            <h6><b>Показать подробнее №{{ tender.id }}</b></h6>
            <div v-if="tender" class="row">
                <tender-modal v-if="indexTender === tender.id" @close="closeTender" :scrollable="true"
                              body-id="tender-modal-body" header-id="tender-modal-header"
                              :id="tender.id"></tender-modal>
                <div class="col-lg-8">
                    <div class="border-black">
                        <div class="mb-2">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-12 b-b-2 mb-3 pt-3 bg-gray-100">
                                        <div class="align-items-center d-flex">
                                            <b>ЗАЯВКА ОТ ЗАКАЗЧИКА</b>
                                            <h6 class="text-muted m-0 p-0 ml-2">
                                                Дата создания заявки:{{ tender.fullDate }}
                                            </h6>
                                        </div>
                                        <div v-if="tender.customer_info" class="d-flex align-items-baseline">
                                            <b class="mr-2">Заказчик</b>
                                            <h6><b>
                                                {{ tender.customer_info.title }} (ID: {{
                                                    tender.customer_info.user_id
                                                }})</b></h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" v-for="(detail, key) in detailsTender" :key="key">
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
                                    <h6>
                                        <b>Комментарий.</b> <i>{{ tender.comment }}</i>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <hr width="100%">
                        <div class="col-12">
                            <div class="row ">
                                <h6 class="col-auto">ОТКЛИКИ ИСПОЛНИТЕЛЕЙ ({{ tender.allResponses_count }})</h6>
                                <h6 class="col-auto">Фильтрация</h6>
                                <select class="col-2" name="" id="">
                                    <option value="">Все ({{ tender.allResponses_count }})</option>
                                    <option value="">Отклоненные ({{ countResponsesCancel }})</option>
                                    <option value="">Одобренные ({{ countResponsesDeal }})</option>
                                </select>
                                <a class="col-5 text-right" href="#" style="color: red">отклонить все отклики</a>
                            </div>
                        </div>

                        <div class="executor" v-for="response in tender.responses">
                            <div class="title col-lg-12 mt-3 pb-3" style="background-color: lightgray;">
                                <div class="d-flex justify-content-between pt-3">
                                    <div class="name-date mr-2">
                                        <div class="date d-flex">
                                            <i class="fa fa-calendar mr-2"></i>
                                            <h6>{{ response.createDate_month + ' ' + response.createDate_year }} в
                                                {{ response.createDate_time }}</h6>
                                        </div>
                                        <div class="name d-flex">
                                            <div class="img">
                                                <img src="" alt="">
                                            </div>
                                            <h6><b>{{ response.company_info.title }}</b></h6>
                                        </div>
                                    </div>

                                    <div class="rating mr-2">
                                        <h6><b>{{ response.sportObject.title }}</b></h6>
                                        <div class="city d-flex align-items-center">
                                            <img src="/icons/direct/world.svg" alt="">
                                            <h6 class="m-0 ml-3 mr-3">Россия, {{
                                                    response.sportObject.region + ', ' + response.sportObject.city
                                                }}</h6>
                                            <p class="price m-0">от {{ response.sportObject.accm_minPrice }} руб. /
                                                чел.</p>

                                            <div class="rating align-items-center col-auto d-flex">
                                                <rating-messages :average_rating="response.sportObject.average_rating"
                                                                 :reviews_count="response.sportObject.reviews_count"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex btn-action" v-if="response.responsesTender_archive === 0">
                                        <button class="btn btn-small mr-3"
                                                style="background-color: green;color: white; height: 40px !important;">
                                            Выбрать исполнителем
                                        </button>
                                        <button class="btn btn-small"
                                                @click="delResponse(response.responsesTender.id)"
                                                style="background-color: red;color: white; height: 40px !important; width: 120px !important">
                                            Отклонить
                                        </button>
                                    </div>
                                    <div class="d-flex btn-action align-items-center" style="color: red"
                                         v-else-if="response.responsesTender_archive === 2">
                                    <span>
                                        Отклонена (Заказчиком)
                                        <i style="color:red;" class="fa fa-window-close mr-2"></i>
                                    </span>
                                    </div>
                                    <div class="d-flex btn-action align-items-center" style="color: red"
                                         v-else-if="response.responsesTender_archive === 3">
                                    <span>
                                        Отклонена (Исполнителем)
                                        <i style="color:red;" class="fa fa-window-close mr-2"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-lg-6" v-for="(detail, key) in detailsResponse(response)" :key="key">
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
                                    <h6>
                                        <b>Комментарий.</b> <i>{{ response.comment }}</i>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="border-black pl-3 pr-3 pt-3">
                        <h6><b>Статус</b></h6>
                        <h6 v-if="tender.archive === 0">сбор предложений от Исполнителей</h6>
                        <h6 v-else-if="tender.archive === 2">Отклонена (Заказчиком)</h6>
                        <h6><b>Заказчик</b></h6>
                        <h6 v-if="tender.customer_info">{{ tender.customer_info.title }}</h6>
                        <h6><b>Исполнитель</b></h6>
                        <h6>не выбран</h6>
                        <h6><b>Подробности</b></h6>
                        <h6>ID заявки: {{ tender.id }}</h6>
                        <h6>Тип заявки: Тендерная заявка</h6>
                        <h6>Даты пребывания: {{ tender.startDate_day }} - {{ tender.endDate }}
                            {{ tender.endDate_year }}
                            {{ tender.spreadDate }}</h6>
                        <h6>Стоимость (общ.): {{ tender.colPeople * tender.minPrice }} руб</h6>
                        <template v-if="tender.archive === 0">
                            <h6><b>Управление</b></h6>
                            <p @click="showEditTender(tender.id)"><a class="cap" href="#"><i
                                class="fa fa-edit mr-2"></i>РЕДАКТИРОВАТЬ</a>
                            <p data-toggle="modal" data-target="#sb-notification-delete"><a class="cap" href="#">
                                <i style="color:red;" class="fa fa-window-close mr-2"></i>УДАЛИТЬ</a>
                            </p>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import tenderModal from "../../components/requests/tenderModal";
import Breadcrumbs from "../elements/Breadcrumbs";
import RatingMessages from "../../components/elements/RatingMessages";

export default {
    props: ['id'],
    data() {
        return {
            showTender: false, indexTender: null, showDeleteModal: null,
            responses: []
        }
    },
    methods: {
        ...mapActions(["fetchResponsesAndTenders", "fetchAdminTenders", "delTender", "deleteResponseTender",
            "fetchTypeFoods", "fetchAdditionTender", "fetchRequirementInfrastructures", "fetchCities",
            "fetchSportTypes"]),
        deleteTender(idTender) {
            this.delTender({id: idTender});
            window.location.href = "/admin/applications/tender";
        },
        closeModalDelete() {
            $('#sb-notification-delete').modal('hide');
        },
        delResponse(idResponse) {
            this.deleteResponseTender({id: idResponse, user_role: 2});
            window.location.href = "/admin/applications/tender/show/" + this.$props.id;
        },
        showEditTender(tender_id) {
            this.showTender = true;
            this.indexTender = tender_id;
        },
        closeTender() {
            this.showTender = false;
            this.indexTender = null;
        },
        detailsResponse(response) {
            return [
                {label: 'Вид спорта', items: response.type_sports.map(item => item.title)},
                {label: 'Инфраструктура', items: response.infrastructures.map(item => item.title)},
                {label: 'Адрес объекта', items: [`${response.country}, ${response.city}`]},
                {
                    label: 'Дата пребывания', items: [`с ${response.startDate} по ${response.endDate}
                                            ${response.endDate_year}
                                            ${response.spreadDate}`]
                },
                {label: 'Тип питания', items: response.typeFoods.map(item => item.title)},
                {label: 'Дополнительные услуги', items: response.additionsTender.map(item => item.title)},
                {label: 'Количество человек', items: [`${response.colPeople}`]},
                {label: 'Cтоимость (за 1го человека)', items: [`${response.minPrice} руб/сутки`]},
            ];
        }
    },
    computed: {
        ...mapGetters({
            allResponsesCount: "AllResponsesOnTenderCount",
            responsesCancelCount: 'responsesCancelTenderCount', responsesDeal: "responsesTenderWithDealCount"
        }),
        tender() {
            return this.$store.getters.getAdminTender;
        },
        countResponses() {
            return this.responses.length;
        },
        countResponsesCancel() {
            return 0;
            return this.responsesCancelCount(this.$props.id);
        },
        countResponsesDeal() {
            return this.responsesDeal(this.$props.id);
        },
        detailsTender() {
            if (this.tender && Array.isArray(this.tender.type_sports) && Array.isArray(this.tender.infrastructures)
                && Array.isArray(this.tender.typeFoods) && Array.isArray(this.tender.additionsTender)) {
                return [
                    {label: 'Вид спорта', items: this.tender.type_sports.map(item => item.title)},
                    {label: 'Инфраструктура', items: this.tender.infrastructures.map(item => item.title)},
                    {label: 'Адрес объекта', items: [`${this.tender.country}, ${this.tender.city}`]},
                    {
                        label: 'Дата пребывания', items: [`с ${this.tender.startDate} по ${this.tender.endDate}
                                            ${this.tender.endDate_year}
                                            ${this.tender.spreadDate}`]
                    },
                    {label: 'Тип питания', items: this.tender.typeFoods.map(item => item.title)},
                    {label: 'Дополнительные услуги', items: this.tender.additionsTender.map(item => item.title)},
                    {label: 'Количество человек', items: [`${this.tender.colPeople}`]},
                    {label: 'Cтоимость (за 1го человека)', items: [`${this.tender.minPrice} руб/сутки`]},
                ];
            } else {
                return [];
            }
        }
    },
    watch: {},
    mounted() {
        Promise.all([
            this.$store.dispatch("getTenderApplicationById", {id: this.$props.id}).then((result) => {
                this.responses = result.responses;
            }),
            this.fetchTypeFoods(),
            this.fetchAdditionTender(),
            this.fetchRequirementInfrastructures(),
            this.fetchCities(),
            this.fetchSportTypes()
        ])

        /* this.$store.dispatch("getTenderApplicationById", {id: this.$props.id})
         this.$store.dispatch('adminFetchResponsesByTenders', {id: this.$props.id})
        // this.fetchResponsesAndTenders();
         this.fetchTypeFoods();
         this.fetchAdditionTender();
         this.fetchRequirementInfrastructures();
         this.fetchCities();
         this.fetchSportTypes();*/
    },
    components: {
        RatingMessages,
        Breadcrumbs,
        tenderModal,
    }
};
</script>

<style scoped>
p {
    font-size: 12px;
}

.cap {
    font-size: 16px;
}

.border-black {
    background-color: white;
    border: 1px solid black;
}

h6 {
    font-size: 12px;
}

.btn-small {
    font-size: 12px;
}

.object-city .city .price {
    background-color: green;
    font-size: 12px;
    color: white;
    padding-left: 10px;
    padding-right: 10px;
    margin-left: 10px;
}

.object-city .rating {
    background-color: white;
    padding: 2px;
    margin-left: 10px;
}

.object-city .rating img {
    width: 16px;
}

.span-comma:not(:last-child):after {
    content: ",";
}
</style>
