<template>
    <label class="caption w-100">
        {{ textLabel }}
        <span style="color: rgb(243, 122, 138)">*</span>
        <span class="text-muted float-right font-weight-normal">
      {{ model | stripHTMLTags | stringLength }} /2000
    </span>
        <ValidationProvider v-slot="{ errors, validated, onBlur, untouched }"
                            :rules="`required|editorLength|editorMaxLength:${maxLength}`">
            <vue-editor class="bg-white" :maxlength="maxLength" id="editor" :editorToolbar="customToolbar"
                        @keydown.native="handleKeyDown" @keydown.ctrl.prevent
                        @input="$emit('update:text', $event)" @keydown.meta.prevent
                        :editor-style="{ color: '#0B3158'}" :value="model"
                        :class="{ 'is-invalid': !untouched && validated && (errors.length > 0) }" @click.native.stop
                        placeholder="Текст вашего сообщения" name="description" required tabindex="0"
                        @blur="onBlur"/>
            <span class="error-valid" v-if="!untouched && errors.length">{{ errors[0] }}</span>
        </ValidationProvider>
    </label>
</template>

<script>
export default {
    name: "CustomVueEditor",
    props: {
        textLabel: {
            type: String,
        },
        text: {
            type: String,
            required: true
        },
        maxLength: {
            type: Number,
        },
        props: {
            required: true
        }
    },
    data() {
        return {
            customToolbar: [
                [{'header': [1, 2, 3, 4, 5, 6, false]}],
                [{
                    'color': ['#0B3158', '#000000', '#e60000', '#ff9900', '#ffff00', '#008a00', '#0066cc', '#9933ff', '#ffffff']
                }, {'background': []}], ['bold', 'italic'],
                [{'list': 'bullet'}, {'list': 'ordered'}, {'align': []}]
            ], isOpen: false,
        }
    },
    computed: {
        model() {
            return this.$props.text;
        }
    },
    methods: {
        handleKeyDown(event) {
            if (this.text.replace(/<\/?[^>]+(>|$)/g, '').length >= this.maxLength &&
                event.keyCode !== 8) {
                event.preventDefault()
            }
        },
        onBlur() {
            setTimeout(() => {
                this.isOpen = false;
            }, 100);
        },
    }
}
</script>

<style scoped>
.vc-color-picker-popover {
    z-index: 9999;
}
</style>

<style>
.ql-editor > * {
    font-size: 17px;
}
</style>
