<template>
    <div>
        <transition :name="modalClass" v-if="modal">
            <div class="simple-modal">
                <div :class="`${modalClass}-backdrop`" @click="closeModal">
                    <div :class="[{'simple-modal-scrollable': scrollable}, `${modalClass}-container`]">
                        <div :class="`${modalClass}-content`" role="dialog" :aria-labelledby="headerId"
                             :aria-describedby="bodyId" @click.stop style="max-width: 1200px;">
                            <header style="background-color: white" :id="headerId" :class="`${modalClass}-header`">
                                <slot :id="bodyId" name="header" :tender="editResponse">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="title-block">
                                            <p class="title-block__caption">Откликнуться на тендерную заявку №</p>
                                        </div>
                                        <div class="blockImg">
                                            <img @click="closeModal" style="cursor:pointer"
                                                 src="/icons/stages/cancel.svg" alt="">
                                        </div>
                                    </div>
                                </slot>
                            </header>
                            <response :send-request="sendRequest" :edit-response="editResponse"
                                      @sendResponse="sendResponseMethod($event)"></response>
                            <slot name="footer">

                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <ValidationObserver v-slot="props" ref="observer" tag="form" @submit.prevent="sendRequest ? onSave() : null">
            <response v-if="!modal" @sendResponse="sendResponseMethod($event)" :send-request="sendRequest"
                      :is-send-storage="isSaveStorage">
                <template #more-block>
                    <slot name="customer-info">
                    </slot>
                </template>
            </response>
        </ValidationObserver>
    </div>
</template>

<script>
import Response from "../requests/Response";

export default {
    components: {Response},
    data() {
        return {
            modelResponse: {}
        }
    },
    computed: {},
    methods: {
        closeModal() {
            this.$emit('closeModal', false);
        },
        escCloseModal(e) {
            if (this.show && e.key === 'Escape') {
                this.closeModal();
            }
        },
        async onSave() {
            const isValid = await this.$refs.observer.validate();
            if (isValid) {
                const action = this.editResponse ? 'updateTender' : 'storeTender';
                await this.$store.dispatch(action, this.modelResponse);

                if (!this.editResponse && localStorage.getItem("temp-tender")) {
                    localStorage.removeItem("temp-tender");
                }
                if (this.editResponse) {
                    window.location.href = '/tenders/my-tenders';
                } else {
                    window.location.href = '/tender-catalog';
                }
            } else {
                this.scrollToError();
            }
            this.$emit('changeSendRequest');
        },

        scrollToError() {
            setTimeout(() => {
                const firstErrorKey = Object.keys(this.$refs.observer.errors).find(
                    (key) => this.$refs.observer.errors[key].length
                );
                if (firstErrorKey) {
                    this.$refs.observer.refs[firstErrorKey].$el.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                    });
                }
            }, 100);
        },

        sendResponseMethod(response) {
            this.modelResponse = response;
        },
    },
    mounted() {
        window.addEventListener('keydown', this.escCloseModal);
    },
    destroy() {
        window.removeEventListener('keydown', this.escCloseModal);
    },
    name: "TenderModal",
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        scrollable: {
            type: Boolean,
            default: true,
        },
        headerId: {
            type: String,
            required: true,
            default: null,
        },
        bodyId: {
            type: String,
            required: true,
            default: null,
        },
        modalClass: {
            type: String,
            default: 'simple-modal',
        },
        modal: {
            type: Boolean,
            default: false,
        },
        sendRequest: {
            type: Boolean,
            default: false,
        },
        editResponse: {
            default: () => {
            }
        },
        isSaveStorage: {
            type: Boolean,
            default: false
        }
    },
    watch: {
        sendRequest: {
            handler: function (send) {
                if (send) this.onSave();
            }, deep: true
        },
    }
}
</script>
<style lang="scss">
.simple-modal {
    &-backdrop {
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

    &-container {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        width: auto;
        margin: 16px;
    }

    &-scrollable {
        overflow-x: hidden;
        overflow-y: auto;
    }

    &-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 100%;
        max-width: 1200px;
        margin: 1.75rem auto;
        padding: 20px 30px;
        border-radius: 5px;
        color: #000;
        background-color: #fff;
        box-sizing: border-box;
        transform: translate(0, 0);
        transition: all 0.3s ease;
    }

    &-header {
        padding-bottom: 16px;
        font-size: 25px;
        text-align: center;
    }

    &-footer {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 80px;
        text-align: center;
    }

    &-enter,
    &-leave-to {
        opacity: 0;
    }

    &-enter-active,
    &-leave-active {
        transition: opacity 0.2s ease;
    }
}
</style>
