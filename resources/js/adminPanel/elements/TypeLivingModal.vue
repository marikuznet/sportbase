<template>
    <div class="row">
        <modal id="sb-add-accommodation" ref="sb-add-accommodation"  modal_dialog_class="modal-lg"
               :title="!actionSaveTypeLive ? 'Добавить тип проживания' : 'Редактировать тип проживания'">
            <template #body>
                <ValidationObserver tag="form" ref="observer">
                    <label class="w-100 caption select-wrapper mb-xl-2"
                           for="typeObject">Тип объекта
                        <v-select id="typeObject" labelTitle="Выбрать" textProp="title" valueProp="id"
                                  :items="allAccmTypes"
                                  class="selectpicker mt-1" :options="allAccmTypes" @input="getAccType_id"
                                  v-model="titleAccType">
                        </v-select>
                    </label>
                    <ValidationProvider rules="required|max:500" v-slot="{ errors }">
                        <label class="caption w-100 mt-4">Описание объекта
                            <span class="error-valid text-danger" v-if="errors[0]">(* {{
                                    errors[0]
                                }})</span>

                            <span class="text-muted float-right font-weight-normal">
                            {{ descriptionObjectLive.length }}/500
                        </span>
                            <vue-editor :class="{ 'is-invalid': errors[0] }" :maxlength="maxDescriptionObjectLive"
                                        id="editor2" required :editorToolbar="customToolbar"
                                        v-model="descriptionObjectLive"/>
                        </label>
                    </ValidationProvider>
                    <p class="caption">Стоимость проживания в 2021 году
                        <span class="additionalyPriceLive text-muted">   (руб за 1 чел. в сутки)</span>
                    </p>
                    <div class="priceList" v-for="(item, index) in month">
                        <div class="month d-flex pt-2 align-items-center d-flex justify-content-start">
                            <p class="nameMonth align-items-center d-flex m-0">
                                {{ item.text }}</p>
                            <span class="text pl-1 pr-1">от</span>
                            <input type="text" name="search-object" maxlength="5"
                                   minlength="3" onkeyup="this.value = this.value.replace(/[^\d]/g,'');"
                                   placeholder="100" v-model="minPriceAcc[index]"
                                   class="input__price-month flex-fill" autocomplete="off">
                            <span class="text pl-1 pr-1">до</span>
                            <input type="text" name="search-object" maxlength="5"
                                   minlength="3" onkeyup="this.value = this.value.replace(/[^\d]/g,'');"
                                   placeholder="10 000" v-model="maxPriceAcc[index]"
                                   class="input__price-month flex-fill" autocomplete="off">
                        </div>
                    </div>
                </ValidationObserver>
            </template>
            <template #footer>
                <div class="justify-content-center d-flex pt-3 mb-4">
                    <button data-dismiss="modal" type="button" @click="saveTypeLivingHandler" class="btn btn-success
                                        justify-content-center">
                        Сохранить
                    </button>
                </div>
            </template>
        </modal>
        <div class="col-12 p-0">
            <div class="col-sm-12 pb-3 p-0">
                <label class="caption">Типы проживания и стоимость
                    <span class="spanRightMobile text-muted font-weight-normal">
                            {{ accommodations.length }}/100
                        </span>
                </label>
            </div>
        </div>
        <div class="col-sm-12 buttonOption pb-4 p-0">
            <button type="button" :data-target="'#sb-add-accommodation'" data-toggle="modal"
                    class="btn btn-info">
                Добавить опцию +
            </button>
        </div>

        <div class="blockTypeLiveClose col-12 col-sm-12 col-md-6 pl-0 mb-3"
             v-for="(item, index) in accommodations">
            <div class="typeLive h-100">
                <div class="block__title d-flex px-3 py-2">
                    <p class="caption mr-1">{{
                            item.pricing.accomodationType_title
                        }}</p>
                    <div class="btnFunc d-flex">
                        <a :data-target="'#sb-add-accommodation'" data-toggle="modal" @click="editTypeLivingHandler(index)"
                           class="pr-2 mr-1"><span
                            class="btnAction align-items-lg-center justify-content-center d-flex"><img
                            src="/icons/stages/edit.svg" alt=""></span></a>
                        <a @click="deleteTypeLivingHandler(index)"><span
                            class="btnAction align-items-lg-center justify-content-center d-flex"><img
                            src="/icons/stages/cancel.svg" alt=""></span></a>
                    </div>
                </div>
                <div class="block__text" style="min-height: 230px">
                    <p class="text p-4">{{ item.pricing.description }}</p>
                    <p class="priceForPer pl-4 pr-4 position-absolute"
                       style="bottom: 65px;">
                        Стоимость (за 1 человека)
                    </p>
                    <div
                        class="block__price d-flex pr-4 pl-4 pb-4 position-absolute"
                        style="bottom: 0">
                        <span class="text pt-2 pr-2">от</span>
                        <span class="priceMin button-blueBorder borderblock  px-3 d-inline-block py-2 fw-light"
                              style="font-size: calc(1rem);">
                            {{ item.pricing.price[0].minPrice }} руб
                        </span>
                        <span class="text pt-2 pl-2 pr-2">до</span>
                        <span class="priceMax button-blueBorder borderblock px-3 d-inline-block py-2 fw-light mr-2"
                              style="font-size: calc(1rem);">
                            {{ item.pricing.price[0].maxPrice }} руб
                        </span>
                        <button @click="toggleModalLive(index)" type="button"
                                class="btn btn-info align-items-lg-center justify-content-center d-flex mx-auto">
                            <img src="/icons/stages/information.svg" alt="" class="pr-3">
                            Подробнее
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import modal from './modal';
import vSelect from '@alfsnd/vue-bootstrap-select';
import {mapGetters} from "vuex";

export default {
    name: "TypeLivingModal",
    components: {modal, vSelect},
    props: {
        accommodations: {
            type: Array,
            default: null
        }
    },
    data() {
        return {
            titleAccType: '', maxDescriptionObjectLive: 500,
            descriptionObjectLive: '',
            customToolbar: [
                [{'header': [1, 2, 3, 4, 5, 6, false]}],
                [{
                    'color': ['#0B3158', '#000000', '#e60000', '#ff9900', '#ffff00', '#008a00', '#0066cc', '#9933ff', '#ffffff'],
                    'background': []
                }],
                ['bold', 'italic'],
                [{'list': 'bullet'}, {'list': 'ordered'}, {'align': []}],
            ],
            month: [{id: 0, text: 'Январь', title: 'january'}, {id: 1, text: 'Февраль', title: 'february'},
                {id: 2, text: 'Март', title: 'march'}, {id: 3, text: 'Апрель', title: 'april'},
                {id: 4, text: 'Май', title: 'may'}, {id: 5, text: 'Июнь', title: 'june'},
                {id: 6, text: 'Июль', title: 'jule'}, {id: 7, text: 'Август', title: 'august'},
                {id: 8, text: 'Сентябрь', title: 'september'}, {id: 9, text: 'Октябрь', title: 'october'},
                {id: 10, text: 'Ноябрь', title: 'november'}, {id: 11, text: 'Декабрь', title: 'december'}],
            minPriceAcc: [], maxPriceAcc: [], actionSaveTypeLive: false, id_editTypeLive: null,
        }
    },
    computed: {
        ...mapGetters({
            allAccmTypes: "AllAccomodationTypes",
        })
    },
    methods: {
        getAccType_id(accType) {
            this.accType_id = accType.id;
            console.log(this.accType_id)
        },
        editTypeLivingHandler(index) {
            this.actionSaveTypeLive = true;
            this.id_editTypeLive = index;

            this.titleAccType = this.accommodations[index].pricing.accomodationType_title;
            this.descriptionObjectLive = this.accommodations[index].pricing.description;
            for (let i = 0; i < 12; i++) {
                this.minPriceAcc[i] = this.accommodations[index].pricing.price[i].minPrice;
                this.maxPriceAcc[i] = this.accommodations[index].pricing.price[i].maxPrice;
            }
        },
        deleteTypeLivingHandler(index) {
            this.$delete(this.accommodations, index);
        },
        getPricing() {
            this.addAccTypeAndPrice = [];
            for (let i = 0; i < 12; i++) {
                this.addAccTypeAndPrice.push({
                    id: i,
                    title: this.month[i].title,
                    minPrice: this.minPriceAcc[i] === undefined ? 0 : this.minPriceAcc[i],
                    maxPrice: this.minPriceAcc[i] === undefined ? 0 : this.maxPriceAcc[i],
                });
            }
        },
        saveTypeLivingHandler() {
            if (this.actionSaveTypeLive === false) {
                this.getPricing();
                this.descriptionObjectLive.replace(/<\/?[^>]+(>|$)/g, "");

                this.accommodations.push({
                    'id': this.countObject,
                    'idAccType': this.accType_id,
                    'title': this.titleAccType,
                    'description': this.descriptionObjectLive,
                    'price': this.addAccTypeAndPrice,
                });
                this.countObject++;
            } else {
                this.getPricing();
                this.accommodations[this.id_editTypeLive].pricing.accomodationType_title = this.titleAccType;
                this.accommodations[this.id_editTypeLive].accomodationType_id = this.accType_id;
                this.accommodations[this.id_editTypeLive].pricing.description = this.descriptionObjectLive;
                this.accommodations[this.id_editTypeLive].pricing.price = this.addAccTypeAndPrice;
            }
            $('#sb-add-accommodation').modal('toggle');
        },
    },
    created() {
        this.$store.dispatch("fetchAccomodationTypes");
    },
    mounted() {
        this.titleAccType = this.allAccmTypes[0];
    }
}
</script>

<style scoped>
.main-stage-admin .block__title {
    background-color: #f2f2f2;
}

button {
    color: white;
}

</style>
