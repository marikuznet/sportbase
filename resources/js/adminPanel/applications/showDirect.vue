<template>
    <main>
        <breadcrumbs
            :items="[{text: 'Заявки (Прямые)', href: '/admin/applications/direct'}, {text: `ID: ${direct.id}`, active:true}]"/>
        <div class="container">
            <div class="row">
                <direct-modal v-if="indexDirect === direct.id" @close="closeDirect" :scrollable="true"
                              body-id="null" header-id="null" :id="direct.id"></direct-modal>
                <div class="col-lg-8">
                    <div class="block-application__direct" v-if="direct">
                        <div class="border-black direct-block mb-2">
                            <div class="bg-gray-100 text-body b-b-2 pt-3 pl-3 pr-3 pb-3 mb-2"
                                 style="background-color: lightgray;">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p><b>Заказчик:</b>
                                            <a :href="`/admin/users/profile/${direct.customer_info.user_id}`">
                                                {{ direct.customer_info.title }}
                                                (ID: {{ direct.customer_info.user_id }})
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p><b>Исполнитель:</b>
                                            <a :href="`/admin/users/profile/${direct.owner_info.user_id}`">
                                                {{ direct.owner_info.title }}
                                                (ID: {{ direct.owner_info.user_id }})
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-lg-12">
                                        <p class="m-0"><b>Объект</b>
                                            <a :href="`/admin/sport-objects/show/${direct.sportObject.id}`">
                                                {{ direct.sportObject.title }} (id: {{
                                                    direct.sportObject.id
                                                }})
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="details-direct pl-3 pr-3">
                                <div class="row">
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
                                <div class="row">
                                    <div class="col-12">
                                        <h6><b>Комментарий.</b> {{ direct.comment }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="border-black pl-3 pr-3 pt-3">
                        <div id="overlay" v-if="showDeleteModal === direct.id">
                            <div class="modal-dialog" style="top: 25%">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title text-center">Уведомление</h3>
                                        <button type="button" class="close"
                                                @click="showDeleteModal = null">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <p style="font-size: calc(1.25rem); color: #0B3158"
                                           class="text-center mb-4">
                                            Вы действительно хотите удалить заявку?</p>
                                        <div class="d-flex">
                                            <button class="w-100 btn btn-yes" type="button"
                                                    @click="deleteDirect(direct.id)">
                                                Да
                                            </button>
                                            <button type="button" @click="showDeleteModal = null"
                                                    class="w-100 btn btn-no">
                                                <ins>НЕТ</ins>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6><b>Статус</b></h6>
                        <h6 v-if="!direct.deal" :class="getStatusClass(direct.archive)">
                            {{ getStatusTitle(direct.archive) }}</h6>
                        <h6 v-else class="text-success">{{ `Сделка #${direct.deal_id}` }}</h6>
                        <h6><b>Подробности</b></h6>
                        <h6>Тип объекта: {{ direct.sportObject_type }}</h6>
                        <h6>ID заявки: {{ direct.id }}</h6>
                        <h6>Тип заявки: Прямая заявка</h6>
                        <h6>Даты пребывания: {{ direct.startDate }} - {{ direct.endDate }} {{ direct.endDate_year }}
                            {{ direct.spreadDate }}</h6>
                        <h6>Стоимость (общ.): {{ direct.minPrice * direct.colPeople }} руб</h6>
                        <template v-if="direct.archive === 0">
                            <h6><b>Управление</b></h6>
                            <p @click="showEditDirect(direct.id)"><a class="cap" href="#"><i
                                class="fa fa-edit mr-2"></i>РЕДАКТИРОВАТЬ</a>
                            <p @click="showDeleteModal = direct.id">
                                <a class="cap" href="#"><i style="color:red;" class="fa fa-window-close mr-2">
                                </i>УДАЛИТЬ</a>
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
import directModal from "../../components/requests/directModal";
import Breadcrumbs from "../elements/Breadcrumbs";


export default {
    props: ['id'],
    data() {
        return {
            indexDirect: null, showDirect: false, showDeleteModal: null,
            statuses: [
                {status: 0, title: 'Ожидает решения от Исполнителя', class: ''},
                {status: 1, title: 'Заключена сделка', class: 'text-success'},
                {status: 2, title: 'Отклонена (Заказчиком)', class: 'text-danger'},
                {status: 3, title: 'Отклонена (Исполнителем)', class: 'text-danger'}
            ]
        }
    },
    methods: {
        ...mapActions(["delDirect"]),
        deleteDirect(direct_id) {
            this.delDirect({id: direct_id});
            window.location.href = "/admin/applications/direct/show/" + this.$props.id;
        },
        showEditDirect(direct_id) {
            this.showDirect = true;
            this.indexDirect = direct_id;
        },
        closeDirect() {
            this.showDirect = false;
            this.indexDirect = null;
        },
        getStatusClass(archive) {
            const status = this.statuses.find(item => item.status === archive);
            return status ? status.class : '';
        },
        getStatusTitle(archive) {
            const status = this.statuses.find(item => item.status === archive);
            return status ? status.title : '';
        }
    },
    computed: {
        ...mapGetters({directApplications: "getAdminDirectApplications", direct: "getAdminDirect"}),
        details() {
            return [
                {label: 'Вид спорта', items: this.direct.type_sports.map(item => item.title)},
                {label: 'Инфраструктура', items: this.direct.infrastructures.map(item => item.title)},
                {label: 'Адрес объекта', items: [`${this.direct.country}, ${this.direct.city}`]},
                {
                    label: 'Дата пребывания', items: [`с ${this.direct.startDate} по ${this.direct.endDate}
                                                ${this.direct.endDate_year} ${this.direct.spreadDate}`]
                },
                {label: 'Тип питания', items: this.direct.typeFoods.map(item => item.title)},
                {label: 'Дополнительные услуги', items: this.direct.additionsTender.map(item => item.title)},
                {label: 'Количество человек', items: [`${this.direct.colPeople}`]},
                {label: 'Cтоимость (за 1го человека)', items: [`${this.direct.minPrice} руб/сутки`]},
            ];
        }
    },
    watch: {},
    mounted() {
        this.$store.dispatch("getDirectApplicationById", {id: this.$props.id})
    },
    components: {
        Breadcrumbs, directModal,
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
