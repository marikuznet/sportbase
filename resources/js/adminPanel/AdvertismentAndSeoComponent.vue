<template>
    <div class="m-auto mfs-3 mfs-r-3">
        <div class="sb-loading align-items-center d-flex justify-content-center loading position-fixed"
             v-if="advertisements_loading">
            <div class="spinner-border text-info" role="status"/>
        </div>
        <div class="row justify-content-between px-3 p-1rem">
            <div class="col-lg-6 col-12 justify-content-left">
                <p style="margin-top:10px;margin-bottom:10px;">
                    {{ isAdvert ? 'Реклама и продвижение (Сделки на рекламу)' : '' }}
                    {{ !IsAdvert ? 'Управление рекламными тарифами' : '' }}
                </p>
            </div>
            <div class="col-lg-6 col-12 justify-content-right text-right sb-btn-actions">
                <a class="btn btn-left btn-outline-info" :class="{'btn-info btn-active': IsAdvert}"
                   href="/admin/advertisment_and_seo_orders">Реклама</a>
                <a style="margin-left:-6px" class="btn btn-outline-info btn-right"
                   :class="{'btn-info btn-active': !IsAdvert}"
                   href="/admin/advertisment_and_seo_price">Тарифы</a>
            </div>
        </div>

        <div v-if="IsAdvert">
            <div class="overflow-auto">
                <table-data-component :items="advertisementsTable.tableItems"
                                      :columns="advertisementsTable.tableColumns"
                                      :headers="advertisementsTable.tableHeaders" />
            </div>
        </div>

        <div v-if="!IsAdvert" className="col-12 mfs-r-3 mfs-3">
            <p class="caption"><b>Управление рекламными тарифами</b></p>
            <div class="row advert">
                <div class="col-md-6 pb-4" v-for="item in advertising_tariffs">
                    <modal-advertisement :id="'sb-advertisement-'+item.id" :title="item.title">
                        <template #body>
                            <h6><b>Название продвижения</b></h6>
                            <input class="w-100" type="text" v-model="item.title">
                            <h6><b>Описание(для пользователей)</b></h6>
                            <textarea name="" class="w-100" rows="10" v-model="item.description">
                                {{item.description}}
                            </textarea>
                        </template>
                        <template #footer>
                            <div class="d-flex justify-content-center mb-4">
                                <button class="w-100 btn btn-yes text-white" @click="onSave(item)" data-dismiss="modal">
                                    Сохранить
                                </button>
                            </div>
                        </template>
                    </modal-advertisement>

                    <div class="blockHigh" style="border: 1px solid black; background-color: white">
                        <div class="blockTitle pt-3">
                            <div>
                                <p>{{ item.title }}</p>
                            </div>
                            <div class="imgEdit">
                                <img data-toggle="modal" :data-target="'#sb-advertisement-'+item.id"
                                     src="/icons/sportObjects/edit.svg" alt="" style="cursor: pointer">
                            </div>
                        </div>
                        <div class="blockText p-3">
                            <div class="descr__block">
                                <p><b>Описание (для пользователей): </b>{{ item.description }}</p><br><br>
                                <div class="row">
                                    <div class="col-md-3">
                                        Продолжит. (дней)
                                    </div>
                                    <div class="col-md-3">
                                        Стоимость (один день)
                                    </div>
                                    <div class="col-md-3">
                                        Стоимость (все дни)
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                                <div class="row mb-2" v-for="(price, index) in item.price">
                                    <div class="col-md-3">
                                        <input type="text" v-model="price.days" @keypress="onlyNumber" maxlength="3">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" v-model="price.oneDay" @keypress="onlyNumber" maxlength="4">
                                    </div>
                                    <div class="col-md-3" v-if="price.days && price.oneDay">
                                        <input disabled type="text" v-model="price.days * price.oneDay">
                                    </div>
                                    <div class="col-md-3">
                                        <img
                                            @click="savePrice(item)"
                                            src="/icons/settings/check-mark.svg" alt="" style="cursor: pointer">
                                        <img @click="removePrice(item, price.days)"
                                             src="/icons/stages/cancel.svg" alt="" style="cursor: pointer">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="#" @click="item.price.push({})">добавить еще</a>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ModalAdvertisement from "./elements/modal";
import {mapActions, mapGetters} from 'vuex';
import TableDataComponent from "./elements/TableDataComponent";

export default {
    components: {TableDataComponent, ModalAdvertisement},
    props: ['isAdvert'],
    data() {
        return {
            advert: null, isShowFiltersBlock: false,
        }
    },
    methods: {
        ...mapActions(["setAdvertisementTitle"]),
        onSave(item) {
            this.setAdvertisementTitle(item);
            $('#sb-advertisement-' + item.id).modal('hide');
        },
        onlyNumber($event) {
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if (keyCode < 48 || keyCode > 57) {
                $event.preventDefault();
            }
        },
        savePrice(item) {
            this.$store.dispatch('setAdvertisementPrice', item).then(result => {
                this.$store.dispatch('getAdvertisingTariffs');
            })
        },
        removePrice(item, days_price) {
            item.price.splice(item.price.findIndex((item) => item.days == days_price), 1);
            this.$store.dispatch('setAdvertisementPrice', item).then(result => {
                this.$store.dispatch('getAdvertisingTariffs');
            })
        }
    },
    computed: {
        ...mapGetters({
            advertising_tariffs: 'advertising_tariffs',
            advertisements: 'advertisements',
            advertisements_loading: 'advertisement_loading'
        }),
        IsAdvert() {
            this.advert = this.isAdvert;
            return this.advert;
        },
        advertisementsTable() {
            return {
                tableHeaders: [
                    {label: "ID номер"},
                    {label: "Дата запуска"},
                    {label: "Объект"},
                    {label: "Тип продвижения"},
                    {label: "Продолжит."},
                    {label: "Стоимость общ."},
                    {label: "Статус"},
                ],
                tableColumns: [
                    {prop: "id", class: "text-center"},
                    {prop: "date_start", class: "text-center"},
                    {prop: "object", class: "text-center", html: true},
                    {prop: "type_advertisement", class: "text-center"},
                    {prop: "days", class: "text-center"},
                    {prop: "amount", class: "text-center"},
                    {prop: "statusAdv", class: "text-center"},
                ],
                tableItems: this.advertisements.map(advertisement => ({
                    ...advertisement,
                    object: `<a href="/admin/sport-objects/show/${advertisement.sport_object.id}">${advertisement.sport_object.title} (ID:${advertisement.sport_object.id})</a>`,
                    days: advertisement.days + ' дней',
                    amount: advertisement.amount + ' руб.',
                    statusAdv: advertisement.status,
                    type_advertisement: advertisement.tariff.title,
                }))
            }
        }
    },
    created() {
        this.$store.dispatch('getAdvertisingTariffs');
        this.$store.dispatch('getAdvertisements');
    }
};
</script>
<style scoped>
table tr td, table th {
    text-align: center;
}
</style>

<style style="scss">
.btn {
    width: 150px;
}

.btn-left {
    border-radius: .5rem 0 0 .5rem;
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

.advert .blockTitle {
    display: flex;
    justify-content: space-between;
    padding-left: 1rem;
    padding-right: 1rem;
    background-color: lightgray;
    align-items: center;
}
</style>
