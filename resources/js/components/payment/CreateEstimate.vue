<template>
    <div class="main-estimate" style="min-width: 600px">
        <transition :name="modalClass">
            <div class="simple-modal">
                <div :class="`${modalClass}-backdrop`" @click="closeModal" data-backdrop="static">
                    <div :class="[{'simple-modal-scrollable': scrollable}, `${modalClass}-container`]">
                        <div :class="`${modalClass}-content`" role="dialog" aria-labelledby="header-estimate"
                             aria-describedby="body-estimate" @click.stop>
                            <header style="background-color: white" id="header-estimate"
                                    :class="`${modalClass}-header`">
                                <slot id="body-estimate" name="header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="title-block">
                                            <p class="title-block__caption">Создать смету</p>
                                        </div>
                                        <div class="blockImg">
                                            <img @click="closeModal"
                                                 class="close-icon cursor-pointer"
                                                 src="/icons/stages/cancel.svg"
                                                 alt="Закрыть"
                                                 ref="closeButton"/>
                                        </div>
                                    </div>
                                </slot>
                            </header>

                            <div v-if="estimateLoading" class="loading-overlay">
                                <img src="/images/load.gif" alt="Загрузка" class="loading-icon">
                            </div>

                            <div class="d-flex justify-content-center my-4">
                                <p class="title-estimate">
                                    <b v-if="step === 0">СПОРТИВНЫЙ ОБЪЕКТ</b>
                                    <b v-if="step === 1">РАЗМЕЩЕНИЕ И ПИТАНИЕ</b>
                                    <b v-if="step === 2">ДОПОЛНИТЕЛЬНЫЕ УСЛУГИ</b>
                                    <b v-if="step === 3">ПОДТВЕРЖДЕНИЕ</b>
                                </p>
                            </div>

                            <sport-object-section v-if="deal && dealRequest" :request="dealRequest"
                                                  :deal-create-date="deal.deal_date"
                                                  :sport-object="deal.direct ? deal.direct.sportObject
                                                : deal.responsesTender.sportObject"/>

                            <template v-if="estimateInput || edit">
                                <sport-object-estimate v-if="step === 0" :modal-class="modalClass" :deal-data="deal"
                                                       :idEstimate="idEstimate" @nextStep="nextStep" :edit="edit"
                                                       @closeModal="closeModal"/>
                                <accomodation-type-and-food-estimate v-if="step === 1" :modal-class="modalClass"
                                                                     :deal-data="deal" :idEstimate="idEstimate"
                                                                     @nextStep="nextStep" @prevStep="step--"
                                                                     :edit="edit" @closeModal="closeModal"/>
                                <additional-services-estimate v-if="step === 2" :modal-class="modalClass"
                                                              :deal-data="deal" :idEstimate="idEstimate"
                                                              @nextStep="nextStep" @prevStep="step--" :edit="edit"
                                                              @closeModal="closeModal"/>
                                <confirm-estimate v-if="step === 3" :modal-class="modalClass" :deal-data="deal"
                                                  :idEstimate="idEstimate" :edit="edit" @prevStep="step--"
                                                  @closeModal="closeModal" @confirmEstimate="confirmEstimate"/>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import SportObjectEstimate from "../estimate/SportObjectEstimate";
import AccomodationTypeAndFoodEstimate from "../estimate/AccomodationTypeAndFoodEstimate";
import AdditionalServicesEstimate from "../estimate/AdditionalServicesEstimate";
import ConfirmEstimate from "../estimate/ConfirmEstimate";
import {mapActions, mapGetters} from "vuex";
import SportObjectSection from "../deal/SportObjectSection";

export default {
    props: {
        create: {},
        deal: {},
        scrollable: {
            type: Boolean,
            default: true,
        },
        modalClass: {
            type: String,
            default: 'simple-modal',
        },
        idDeal: {
            type: Number
        },
        dealData: {
            type: Object
        },
        idEstimate: {
            type: Number
        },
        edit: {
            type: Boolean
        }
    },
    name: "CreateEstimate",
    components: {
        SportObjectSection, ConfirmEstimate, AdditionalServicesEstimate, AccomodationTypeAndFoodEstimate,
        SportObjectEstimate
    },
    data() {
        return {
            step: 0, show: true
        }
    },
    computed: {
        estimateInput: {
            get: function () {
                return this.create;
            },
            set: function (newValue) {
                this.$emit('update:create', false)
            }
        },
        dealRequest() {
            return this.$props.deal?.direct || this.$props.deal?.responsesTender;
        },
        ...mapGetters({
            estimateLoading: 'estimateLoading'
        }),
    },
    methods: {
        nextStep() {
            this.step++;
        },
        confirmEstimate() {
            this.show = false;
            this.$emit('visibleModal', false);
            this.$store.dispatch("getDeal", {id: this.$props.idDeal});
        },
        closeModal() {
            this.$emit('visibleModal', false);
            this.show = false;
        }
    },
    mounted() {
        if (this.show) {
            this.$nextTick(() => {
                this.$refs.closeButton.focus();
            });
        }
    },
}
</script>

<style>
.simple-modal .estimate-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    transition: opacity 0.3s ease;
    z-index: 9999;
}

.simple-modal .estimate-container {
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    width: auto;
    margin: 16px;
}

.simple-modal .estimate-scrollable {
    overflow-x: hidden;
    overflow-y: auto;
}

.simple-modal .estimate-content {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 100%;
    max-width: 700px;
    margin: 1.75rem auto;
    padding: 20px 30px;
    border-radius: 5px;
    color: #000;
    background-color: #fff;
    box-sizing: border-box;
    transform: translate(0, 0);
    transition: all 0.3s ease;
}

.simple-modal .estimate-header {
    padding-bottom: 16px;
    font-size: 25px;
    text-align: center;
}

.simple-modal .estimate-footer {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 80px;
    text-align: center;
}

.simple-modal .estimate-enter,
.simple-modal .estimate-leave-to {
    opacity: 0;
}

.simple-modal .estimate-enter-active,
.simple-modal .estimate-leave-active {
    transition: opacity 0.2s ease;
}
</style>

<style scoped>
.simple-modal-content {
    max-width: 800px !important;
}

.loading-overlay {
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 10000;
}

.loading-icon {
    width: 40px;
}
</style>
