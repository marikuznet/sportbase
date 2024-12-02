<template>
    <sb-modal id="sb-response-modal" ref="sb-response-modal" title="Запросить расчет объекта"
              modal_dialog_class="modal-xl">
        <template #body class="blockResponseBody">
            <ValidationObserver v-slot="props" ref="observer" tag="form" @submit.prevent="onSave">
                <response @sendResponse="sendResponseMethod($event)" :send-request="sendRequest"
                          @submit.prevent="sendRequest ? onSave() : null" :edit-response="modelRequest">
                </response>
                <div class="buttonSend row d-flex justify-content-center" style="height: 35px">
                    <button @click="sendRequestMethod" type="button" class="top__button button button-fill d-block mx-auto
                              my-0 my-lg-3 mb-2 p-lg-4 p-3 d-flex justify-content-around"
                            style="width: 390px; position: absolute; bottom: -7%;">
                        <p class="fw-bold text-white">Отправить заявку</p>
                    </button>
                </div>
            </ValidationObserver>
        </template>
        <template #footer>

        </template>
    </sb-modal>
</template>

<script>
import SbModal from "./SbModal";
import VSelect from "@alfsnd/vue-bootstrap-select";
import {mapGetters} from 'vuex';
import Slider from '@vueform/slider/dist/slider.vue2.js';
import Response from "../requests/Response";

export default {
    name: "SbResponseModal",
    components: {Response, SbModal, VSelect, Slider},
    props: {
        idSportObject: {
            type: Number,
            default: null
        },
        modelRequest: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            modelResponse: {}, sendRequest: false
        }
    },
    methods: {
        sendResponseMethod(response) {
            this.modelResponse = response;
            this.onSave();
        },
        sendRequestMethod() {
            this.sendRequest = true;
        },
        async onSave() {
            await this.$refs.observer.validate().then(success => {
                if (!success) {
                    setTimeout(() => {
                        const errors = Object.entries(this.$refs.observer.errors)
                            .map(([key, value]) => ({key, value}))
                            .filter(error => error["value"].length);
                        this.$refs.observer.refs[errors[0]["key"]].$el.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });
                    }, 100);
                } else {
                    if (this.$props.modelRequest) {
                        this.modelResponse.sportObject_id = this.modelResponse.sportObject.id;
                        this.$store.dispatch('setDirectApplication', this.modelResponse).then(() => {
                            window.location.href = "/my-rental-requests";
                        });
                    } else {
                        this.modelResponse.sportObject_id = this.idSportObject;
                        this.$store.dispatch('storeDirectApplication', this.modelResponse).then(() => {
                            window.location.href = "/my-rental-requests";
                        });
                    }

                }
            });
            this.sendRequest = false;
        },
    },
    mounted() {
        if (this.$props.modelRequest != null) {
            this.modelResponse = this.$props.modelRequest
        }
    }
}
</script>
