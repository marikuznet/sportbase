<template>
    <div class="mfs-3 mfe-3">
        <div class="sb-loading align-items-center d-flex justify-content-center loading position-fixed"
             v-if="users_loading">
            <div class="spinner-border text-info" role="status"/>
        </div>
        <div class="row mt-3">
            <div class="col-lg-6 col-12">
                <h4>Пользователи <span>({{ !isCustomer ? "Исполнители" : "Заказчики" }})</span></h4>
            </div>
            <div class="col-lg-6 col-12 h-100 d-flex justify-content-end sb-btn-actions">
                <a class="btn btn-outline-info" :class="{'btn-info text-white': isCustomer}"
                   href="/admin/users/customers">
                    Заказчики ({{ statistic.customersCount }})
                </a>
                <a style="margin-left:-6px" class="btn btn-outline-info btn-right fw-bold" href="/admin/users/executors"
                   :class="{'btn-info text-white': !isCustomer}">
                    Исполнители ({{ statistic.executorsCount }})
                </a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-lg-3">
                <p><b>{{ !isCustomer ? "Список исполнителей" : "Список заказчиков" }} </b></p>
            </div>
            <div class="input-group mb-4 remember-me-link col-12 col-lg-2" v-if="!isCustomer">
                <div class="input-group-prepend mr-2">
                    <input class="sb-checkbox form-check inuput-group-prepend" type="checkbox"
                           name="remember" id="verify" v-model="filter.verify"/>
                </div>
                <label class="form-check-label" for="verify">
                    на верификации ({{ statistic.verifyExecutorsCount }})
                </label>
            </div>
            <div class="input-group mb-4 remember-me-link col-12 col-lg-2" v-if="!isCustomer">
                <div class="input-group-prepend mr-2">
                    <input class="sb-checkbox form-check input-group-prepend" type="checkbox"
                           name="remember" id="block" v-model="filter.block"/>
                </div>
                <label class="form-check-label" for="block">
                    Заблокированные ({{ statistic.blockExecutorsCount }})
                </label>
            </div>
            <div class="input-group mb-4 remember-me-link col-12 col-lg-2" v-if="isCustomer">
                <div class="input-group-prepend mr-2">
                    <input class="sb-checkbox form-check input-group-prepend" type="checkbox" name="remember"
                           id="remember" v-model="filter.block">
                </div>
                <label class="form-check-label" for="remember">
                    Заблокированные({{ statistic.blockCustomersCount }})
                </label>
            </div>
            <div class="input-group mb-4 remember-me-link col-12 col-lg-2" v-if="isCustomer"/>
            <div class="col col-lg-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Поиск в каталоге"
                           v-model="filter.search_field">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
            </div>
            <div class="col-auto col-lg-2 d-flex h-100 justify-content-end">
                <a href="#"
                   class="sb-btn-filter text-white btn btn-primary d-flex justify-content-center">
                    <i class="fa fa-filter"></i>
                    <span class="d-lg-block d-none">ФИЛЬТР</span>
                    <i class="d-lg-block d-none fa fa-caret-down fa-lg"></i>
                </a>
            </div>
        </div>
        <div class="row mt-3 p-1">
            <div v-if="!isCustomer" id="executors" class="col-12">
                <div class="justify-content-between row mb-4 mb-lg-2">
                    <div class="col-12">
                        <div class="overflow-auto" style="min-height: 600px">
                            <table-data-component :items="usersTable.tableItems" :columns="usersTable.tableColumns"
                                                  :headers="usersTable.tableHeaders">
                                <template #status="{ item }">
                                    <div class="d-flex position-relative align-items-center">
                                            <span class="badge text-white mr-2 fa-1x" :class="{'bg-danger': item.block === 1,
                                                'bg-info': item.status === 10 ,
                                                'bg-success': item.status === 11,
                                                'text-reset': item.status === 9 && item.block === 0 }">
                                                {{ item.block === 1 ? 'заблокированный' : null }}
                                                {{ item.status === 9 && item.block === 0 ? 'зарегистрирован' : null }}
                                                {{ item.status === 10 && item.block === 0 ? 'на верификации' : null }}
                                                {{ item.status === 11 && item.block === 0 ? 'активный' : null }}
                                            </span>
                                        <div>
                                            <div class="btn-group sb-btn-info">
                                                <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        class="btn btn-ghost-info dropdown-toggle d-flex align-items-center"
                                                        aria-expanded="false">
                                                    <i class="fa fa-info"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a v-if="item.status === 9 || item.status === 10"
                                                       class="dropdown-item" href="#"
                                                       @click="setStatus(item.id, 11)">Верифицировать</a>
                                                    <a class="dropdown-item" href="#"
                                                       @click="delUser({id: item.id})">Удалить</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a v-if="item.block === 0" class="dropdown-item" href="#"
                                                       @click="setBlock(item.id, 1)">
                                                        Заблокировать
                                                    </a>
                                                    <a v-else class="dropdown-item" href="#"
                                                       @click="setBlock(item.id, 0)">
                                                        Разблокировать
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template #action="{ item }">
                                    <a style="cursor:pointer;" class="text-black-50"
                                       :class="{'nonActive': item.status === 12 || item.status === 9}"
                                       :href="'/admin/users/profile/' + item.id">подробнее
                                    </a>
                                </template>
                            </table-data-component>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="isCustomer" id="customers" class="col-12">
                <div class="justify-content-between row mb-4 mb-lg-2">
                    <div class="col-12">
                        <div class="overflow-auto" style="min-height: 600px">
                            <table-data-component :items="usersTable.tableItems" :columns="usersTable.tableColumns"
                                                  :headers="usersTable.tableHeaders">
                                <template #status="{ item }">
                                    <div class="d-flex position-relative align-items-center">
                                            <span class="badge text-white mr-2 fa-1x"
                                                  :class="{'bg-danger': item.block === 1, 'bg-success': item.block === 0 }">
                                                {{ item.block === 1 ? 'заблокированный' : null }}
                                                {{ item.block === 0 ? 'активный' : null }}
                                            </span>
                                        <div>
                                            <div class="btn-group sb-btn-info">
                                                <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        class="btn btn-ghost-info dropdown-toggle d-flex align-items-center"
                                                        aria-expanded="false">
                                                    <i class="fa fa-info"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#"
                                                       @click="delUser({id: item.id})">Удалить</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a v-if="item.block === 0" class="dropdown-item" href="#"
                                                       @click="setBlock(item.id, 1)">
                                                        Заблокировать
                                                    </a>
                                                    <a v-else class="dropdown-item" href="#"
                                                       @click="setBlock(item.id, 0)">
                                                        Разблокировать
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template #action="{ id }">
                                    <a class="text-black-50" :href="'/admin/users/profile/' + id">подробнее</a>
                                </template>
                            </table-data-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import TableDataComponent from "./elements/TableDataComponent";

export default {
    components: {TableDataComponent},
    props: ['isCustomer'],
    data() {
        return {
            idUser: '',
            filter: {
                verify: false, block: false, search_field: '',
                usersModel: {}
            }
        }
    },
    methods: {
        ...mapActions(["fetchUsers", "delUser", "setStatusUser", "setBlockUser", "adminUsersStatistic"]),
        setStatus(idExecutor, status) {
            this.setStatusUser({id: idExecutor, status: status});
        },
        setBlock(idExecutor, block) {
            this.setBlockUser({id: idExecutor, block: block});
        },
    },
    computed: {
        ...mapGetters({
            statistic: "admin_users_statistic",
            usersExecutor: "UsersExecutor",
            usersCustomer: "UsersCustomer",
            users_loading: "users_loading",
        }),
        filterExecutors() {
            return this.usersExecutor.filter(user => {
                return !this.filter.verify || user.status === 10;
            }).filter(user => {
                return !this.filter.block || user.block === 1;
            }).filter(user => {
                return this.filter.search_field == '' || user.id == this.filter.search_field
                    || user.email.toLowerCase().indexOf(this.filter.search_field.toLowerCase()) !== -1
                    || user.name.toLowerCase().indexOf(this.filter.search_field.toLowerCase()) !== -1
            });
        },
        filterCustomers() {
            return this.usersCustomer.filter(user => {
                return this.filter.block == false || user.block === 1;
            }).filter(user => {
                return this.filter.search_field == '' || user.id == this.filter.search_field
                    || user.email.toLowerCase().indexOf(this.filter.search_field.toLowerCase()) != -1
                    || user.name.toLowerCase().indexOf(this.filter.search_field.toLowerCase()) != -1
            });
        },
        IsCustomers() {
            return this.isCustomer;
        },
        usersTable() {
            let headers = [
                {label: "ID номер"},
                {label: "Дата рег."},
                {label: "Тип"},
                {label: "Название"},
                {label: "Телефон"},
                {label: "Email"},
                {label: "Адрес"},
                {label: "Статус"},
                {label: "Детали"}
            ];
            let columns = [
                {prop: "id", class: ""},
                {prop: "created_at", class: ""},
                {prop: "user_type", class: ""},
                {prop: "user_title", class: ""},
                {prop: "user_phone", class: ""},
                {prop: "email", class: ""},
                {prop: "address", class: ""},
                {prop: "status", class: ""},
                {prop: "action", class: ""}
            ];
            let items = this.filterCustomers.map(user => ({
                ...user,
                user_type: user.info?.typePerson === 0 ? 'Юр.лицо' : 'Физ.лицо',
                user_title: user.info?.typePerson === 0 ? user.info.title :
                    user.info?.typePerson === 1 ? `${user.info.surname} ${user.info.name} ${user.info.patronymic}` : '',
                user_phone: user.info?.phone ?? null,
                classRow: user.block === 1 ? 'nonActive' : ''
            }));
            if (!this.isCustomer) {
                headers.splice(2, 1);
                columns.splice(2, 1);
                headers.splice(3, 0, {label: "Контактное лицо."});
                columns.splice(3, 0, {prop: "contact_person", class: ''});
                items = this.filterExecutors.map(user => ({
                    ...user,
                    user_type: user.info?.typePerson === 0 ? 'Юр.лицо' : 'Физ.лицо',
                    user_title: user.info?.typePerson === 0 ? user.info.title :
                        user.info?.typePerson === 1 ? `${user.info.surname} ${user.info.name} ${user.info.patronymic}` : '',
                    user_phone: user.info?.phone ?? null,
                    contact_person: user?.info?.contactPerson ? user.info.contactPerson : '',
                    classRow: (user.block === 1  || user.status === 9) ? 'nonActive' : '',
                }));
            }
            return {
                tableHeaders: headers,
                tableColumns: columns,
                tableItems: items
            }
        }
    },
    created() {
        this.adminUsersStatistic();
    },
    mounted() {
        this.fetchUsers();
    }
}
</script>

<style scoped>
.nonActive {
    color: lightgray !important;
}
</style>
