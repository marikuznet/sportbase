<template>
    <div class="sb-financial-operations m-auto mfs-3 mfs-r-3">
        <div>
            <div class="col-12 col-lg-5 justify-content-left">
                <p style="margin-top:10px;margin-bottom:10px;">Финансовые операции (Счета на оплату)</p>
            </div>
            <div class="float-left justify-content-left text-left w-100 sb-btn-actions mb-lg-3">
                <a class="btn btn-outline-info btn-left" :class="{'btn-active btn-info': isModerating == 1}"
                   href="/admin/finantial_operations_payment_bills">
                    Счета на оплату ({{ displayedEstimates.length }})
                </a>
                <a class="btn btn-outline-info btn-center" :class="{'btn-active btn-info': isModerating == 2}"
                   href="/admin/finantial_operations_payment_advertisment_bills">
                    Оплаты за рекламу ({{ statistic.paymentAdvertisementCount }})
                </a>
                <a class="btn btn-outline-info btn-center text-nowrap" :class="{'btn-active btn-info': isModerating == 3}"
                   href="/admin/finantial_operations_payment_emploees_bills">
                    Выплаты исполнителям ({{ paymentPerformersCount }}) <!--statistic.paymentPerformers!-->
                </a>
                <a class="btn btn-outline-info btn-right" :class="{'btn-active btn-info': isModerating == 4}"
                   href="/admin/finantial_operations_payment_ins_and_outs">
                    Доходы и расходы
                </a>
            </div>
        </div>

        <div class="mfs-3 w-100 mt-4 mb-4">
            <financial-info v-if="isModerating == 4"/>

            <div class="row w-100">
                <div class="col-12 col-lg-3 float-left justify-content-left text-left">
                    <p v-if="isModerating == 3" class="font-weight-bold" style="margin-top: 10px">Список выплат
                        исполнителям</p>
                    <p v-if="isModerating == 4" class="font-weight-bold" style="margin-top: 10px">Список операций</p>
                </div>
                <div class="col-3"></div>
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-9 col-lg-8">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Поиск в каталоге">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-3 col-lg-4 d-flex justify-content-end">
                            <a v-on:click="showFiltersBlock=!showFiltersBlock"
                               class="sb-btn-filter text-white btn btn-primary d-flex justify-content-center">
                                <i class="fa fa-filter"></i>
                                <span class="d-lg-block d-none">ФИЛЬТР</span>
                                <i class="d-lg-block d-none fa fa-caret-down fa-lg"></i>
                            </a>
                        </div>
                    </div>
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
        <payment-list-section v-if="isModerating == '1'" :estimates="displayedEstimates"/>
        <advertisement-list-section v-if="isModerating == '2'"/>
        <payment-performers-section v-if="isModerating == '3'" @getPayments="getPayments" :payment-performers="paymentPerformers"/>
        <!--TODO: Поправить таблицу isModerating == '4' !-->
        <operations-list-section v-if="false"/>
    </div>
</template>
<script>
import TableComponent from '../adminPanel/TableComponent.vue';
import {mapGetters} from "vuex";
import FinancialInfo from "./finantialOperations/FinancialInfo";
import PaymentListSection from "./finantialOperations/PaymentListSection";
import AdvertisementListSection from "./finantialOperations/AdvertisementListSection";
import PaymentPerformersSection from "./finantialOperations/PaymentPerformersSection";
import OperationsListSection from "./finantialOperations/OperationsListSection";

export default {
    components: {
        OperationsListSection,
        PaymentPerformersSection,
        AdvertisementListSection,
        PaymentListSection,
        FinancialInfo, TableComponent
    },
    props: ['isModerating'],
    data() {
        return {
            moderating: null, showFiltersBlock: false, paymentShow: null, paymentIdx: null,
        }
    },
    computed: {
        ...mapGetters({
            estimatesPayment: 'GetEstimatesPaymentAdmin',
            paymentPerformers: 'GetPaymentPerformers',
            paymentPerformersCount: 'GetPaymentPerformersCount',
            statistic: "admin_finance_statistic",

            paymentAdvertisementsCount: 'payment_advertisements_count',
        }),
        IsModerating() {
            this.moderating = this.isModerating;
            return this.moderating;
        },
        displayedEstimates() {
            return this.estimatesPayment;
        },
        payments() {
            return [
                {id: 1, title: 'Уведомить об оплате', color: '#6283E5'},
                {id: 2, title: 'На модерации', color: '#0B3158'},
                {id: 3, title: 'Оплачена', color: '#6FB77F'},
                {id: 4, title: 'Не оплачена', color: '#E45868'},
            ]
        },
    },
    methods: {
        getDaySuffix(number) {
            if (number % 10 === 1 && number % 100 !== 11) {
                return 'день';
            } else if (number % 10 >= 2 && number % 10 <= 4 && (number % 100 < 10 || number % 100 >= 20)) {
                return 'дня';
            } else {
                return 'дней';
            }
        },
        getPayments() {
            this.$store.dispatch('getPayments');
        }
    },
    created() {
        this.getPayments();
        this.$store.dispatch('getPaymentAdvertisements');
        this.$store.dispatch('adminFinanceStatistic');
        this.$store.dispatch('adminFinancesIncomeStatistic')
    }
};
</script>
<style lang="scss">
.modal-dialog {
    margin: 15rem auto !important;
}

.btn {
    width: 200px !important;
}

.btn-left {
    border-radius: .5rem 0 0 .5rem;
}

.btn-center {
    border-radius: 0 0 0 0;
}

.btn-right {
    border-radius: 0 .5rem .5rem 0;
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

.form-control {
    height: auto !important;
}

.modal-confirmed {
    display: none;
    position: absolute;

    .modal-content {
        background-color: #fefefe;
        padding: 10px 20px;
        border: 1px solid #888;
        width: 200px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 16px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
}
</style>
