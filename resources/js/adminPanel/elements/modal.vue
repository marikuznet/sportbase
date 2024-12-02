<template>
    <div class="modal fade sb-modal" :id="id" tabindex="-1" role="dialog" :ref="id" aria-hidden="true"
         data-backdrop="static" :class="modal_class">
        <div :class="modal_class">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-center w-100">{{ title }}</h3>
                        <button data-dismiss="modal" aria-label="Close" type="button" class="close" :data-modal="id"
                                @click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <slot name="body">
                            <p style="font-size: calc(1.25rem); color: #0B3158"
                               class="text-center">
                                {{ content }}</p>
                        </slot>
                    </div>
                    <div class="sb-modal-footer">
                        <slot name="footer">
                            <div class="d-flex justify-content-center mb-4">
                                <slot name="left_button">
                                    <button type="button" :class="left_button_class" @click="left_method"
                                            class="text-white" data-dismiss="modal" aria-label="Close">
                                        <slot name="left_button_inner">
                                            {{ left_button }}
                                        </slot>
                                    </button>
                                </slot>
                                <slot name="right_button">
                                    <button type="button" :class="right_button_class" @click="right_method"
                                            class="text-danger">
                                        <slot name="right_button_inner">
                                            {{ right_button }}
                                        </slot>
                                    </button>
                                </slot>
                            </div>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Modal",
    props: {
        id: {
            type: String,
            default: 'sb-modal'
        },
        title: {
            type: String,
            default: 'Уведомление'
        },
        content: {
            type: String,
            default: 'Вы подтверждаете выбранное действие?'
        },
        modal_class: {
            type: String,
            default: ''
        },
        modal_dialog_class: {
            type: String,
            default: ''
        },
        right_action: {
            type: Function,
            default: null
        },
        left_action: {
            type: Function,
            default: null
        },
        right_button: {
            type: String,
            default: ''
        },
        left_button: {
            type: String,
            default: ''
        },
        right_button_class: {
            type: String,
            default: 'w-100 btn btn-no'
        },
        left_button_class: {
            type: String,
            default: '"w-100 btn btn-yes'
        },
    },
    methods: {
        left_method() {
            this.$emit('left_action');
            if (this.left_action) {
                this.left_action();
                return;
            }
        },
        right_method() {
            this.$emit('right_action');
            if (this.right_action) {
                this.right_action();
                return;
            }
        },
        closeModal() {
            $('#' + this.id).modal('hide');
        }
    }
}
</script>

<style scoped>

</style>
