<template>
    <div class="modal fade simple-modal-scrollable" :id="id" tabindex="-1" role="dialog" aria-hidden="true">
        <div :class="modal_class">
            <div class="modal-dialog modal-xl" :class="'dialog-'+modal_class">
                <div class="modal-content">
                    <div class="modal-header">
                        <slot :id="'header-'+id" name="header"></slot>
                    </div>

                    <div class="modal-body p-4">
                        <slot :id="'body-'+id" name="body"></slot>
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
        modal_class: {
            type: String,
            default: ''
        },
    },
}
</script>

<style scoped>

</style>
