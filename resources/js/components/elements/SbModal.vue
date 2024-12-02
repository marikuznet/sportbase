<template>
    <div class="modal fade" tabindex="-1" role="dialog" :aria-labelledby="modal_class" :id="id" :ref="id"
         aria-hidden="true" data-backdrop="static" :class="modal_class">
        <div class="modal-dialog" :class="modal_dialog_class" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 :class="modal_title_class" class="modal-title text-center w-100">{{ title }}</h3>
                    <button type="button" class="close" :data-modal="id" @click="closeModal">
                        <span aria-hidden="true">
                            <img src="/icons/cancel.svg" alt="close">
                        </span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <slot name="body">
                        <p style="font-size: calc(1.25rem); color: #0B3158"
                           class="text-center">
                            {{ content }}</p>
                    </slot>
                </div>
                <div v-if="is_show_footer" class="modal-footer">
                    <slot name="footer">

                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SbModal",
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
        modal_title_class: {
            type: String,
            default: ''
        },
        modal_dialog_class: {
            type: String,
            default: ''
        },
        is_show_footer: {
            type: Boolean,
            default: true
        }
    },
    methods: {
        closeModal() {
            $('#' + this.id).modal('toggle');
        }
    },
}
</script>

<style scoped>

</style>
