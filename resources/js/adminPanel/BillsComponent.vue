<template>
    <div class="m-auto mfs-3 mfs-r-3">
        <div class="justify-content-between px-3 p-1rem">
            <div class="col-12 justify-content-left text-left">
                <p style="margin-top:10px;margin-bottom:10px;">Список смет и счетов</p>
            </div>
        </div>
        <div class="mfs-3 w-100 mt-3">
            <div class="row w-100 mt-3">
                <div class="col justify-content-right text-right">
                    <a class="btn btn-primary btn-active m-t-b-5" v-on:click="showFiltersBlock=!showFiltersBlock"><i
                        class="cil-filter"></i> Фильтр</a>
                </div>
            </div>
            <div class="mfs-r-3" v-show="showFiltersBlock">
                <div class="card card-body">
                    <div class="container">
                        <div class="row w-100">
                            <div class="col"></div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="ccmonth">Предоставляемое питание</label>
                                    <select class="w-100 form-control" id="ccmonth">
                                        <option>Любое</option>
                                        <option>9</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="ccmonth">Предоставляемые услуги</label>
                                    <select class="w-100 form-control" id="ccmonth">
                                        <option>Любые</option>
                                        <option>12</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        <div class="row mt-3 w-100">
                            <div class="col"></div>
                            <div class="col">
                                <label for="ccmonth">Инфраструктура</label>
                                <select class="w-100 form-control" id="ccmonth">
                                    <option>Любая</option>
                                    <option>12</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="ccmonth">Наличие акредитации <b><u>Минспорта</u></b></label>
                                <select class="w-100 form-control" id="ccmonth">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                </select>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mfs-r-3 mfs-3">
            <div class="overflow-auto">
                <table-data-component :items="billsTable.tableItems" :columns="billsTable.tableColumns"
                                      :headers="billsTable.tableHeaders">
                    <template #status="{ item }">
                        <p :style="'color:'+ statusPayment.filter(p => p.id === item.status)[0].color">
                            {{ statusPayment.filter(p => p.id === item.status)[0].title }}
                        </p>
                    </template>
                </table-data-component>
            </div>
        </div>
    </div>
</template>
<script>
import TableComponent from '../adminPanel/TableComponent.vue';
import {mapActions, mapGetters} from "vuex";
import TableDataComponent from "./elements/TableDataComponent";

export default {
    components: {TableDataComponent, TableComponent},
    data() {
        return {
            showFiltersBlock: false, paymentShow: false,
            statusPayment: [
                {id: 1, title: 'Уведомить об оплате', color: '#6283E5'},
                {id: 2, title: 'На модерации', color: '#0B3158'},
                {id: 5, title: 'Оплачен', color: '#6FB77F'},
                {id: 3, title: 'Ожидает оплаты', color: '#6283E5'},
                {id: 4, title: 'Просрочен', color: '#e45868'},
                /* {id: 2, title: 'ожидает оплаты', color: '#3c4b64'},
                 {id: 3, title: 'отменен'},
                 {id: 3, title: 'оплачен', color: 'green'},
                 {id: 4, title: 'просрочен', color: 'red'},*/
            ]
        }
    },
    computed: {
        ...mapGetters({
            bills: 'GetEstimatesAdmin',
        }),
        paginated_bills() {
            const invoiceCountMap = {};
            return this.bills.map((bill) => {
                const dealId = bill.deal_id;
                if (!invoiceCountMap.hasOwnProperty(dealId)) {
                    invoiceCountMap[dealId] = 1;
                } else {
                    invoiceCountMap[dealId]++;
                }
                const invoiceNumber = invoiceCountMap[dealId];

                if (invoiceNumber > 1) {
                    return {
                        ...bill,
                       // status: 4,
                        numInvoice: invoiceNumber
                    };
                }

                return bill;
            });
        },
        billsTable() {
            let headers = [
                {label: "Дата созд."}, {label: "ID сделки"}, {label: "Объект"},
                {label: "Заказчик"}, {label: "Исполнитель"}, {label: "Смета"},
                {label: "Счет"}, {label: "Статус"},
            ];
            let columns = [
                {prop: "created_at", class: "text-center"},
                {prop: "deal_id", class: "text-center"},
                {prop: "bill_object", class: "text-center", html: true},
                {prop: "bill_customer", class: "text-center", html: true},
                {prop: "bill_created_object", class: "text-center", html: true},
                {prop: "id_bill", class: "text-center underline"},
                {prop: "id_bill", class: "text-center underline"},
                {prop: "status", class: "text-center underline"},
            ];
            let items = this.paginated_bills.map(bill => ({
                ...bill,
                bill_object: `<a href="/admin/sport-objects/show/${bill.sportObject.id}">
                                ${bill.sportObject.title} (ID: ${bill.sportObject.id})
                            </a>`,
                bill_customer: `<a href="/admin/users/profile/${bill.customer_info.id}">
                                ${bill?.customer_info?.title ?? ''} (ID:${bill.customer_info.id})
                            </a>`,
                bill_created_object: `<a href="/admin/users/profile/${bill.sportObject.created.user_id}">
                                ${bill.sportObject.created.title ?? ''} (ID:${bill.sportObject.created.user_id})
                            </a>`,
                id_bill: `№${bill.id} (${bill.numInvoice || 1})`,
                status: (bill.payment_overdue && bill.is_overdue && bill.status <= 3) ? 4 : bill.status
            }));
            return {
                tableHeaders: headers,
                tableColumns: columns,
                tableItems: items
            }
        },
    },
    methods: {
        ...mapActions(["fetchDeals"]),
    },
    mounted() {
        console.log("Mounted")
    },
    created() {
        this.$store.dispatch('adminFetchEstimates');
    }
};
</script>
<style lang="scss">
.btn {
    width: 150px;
    border-radius: .5rem;
}

.btn-active {
    color: white !important;
}

.mfs-r-3 {
    margin-right: 1.5rem !important;
}

.p-1rem {
    padding: 1rem !important;
}

.m-t-b-5 {
    margin-top: 5px;
    margin-bottom: 5px;
}

.m-t-b-10 {
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
