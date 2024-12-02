<template>
    <div class="row pt-2">
        <ValidationProvider v-slot="{ errors }" :rules="validationRules" class="col-12">
            <div class="row block__services col-lg-12">
                <div class="col-12 p-0 pb-3">
                    <p class="caption">{{ label }} <span style="color: rgb(243, 122, 138)">*</span>
                        <span class="additionally text-invalid-notif">{{
                                errors[0] != null ? errorMessage : null
                            }}</span>
                    </p>
                </div>
                <div class="col-sm-11 col-md-4 m-0 p-0" v-for="item in options">
                    <div class="row">
                        <label class="col-12 d-flex float-left">
                            <input class="checkService d-none" type="checkbox" :value="item.id"
                                   v-model="localSelectedValues"/>
                            <span></span>
                            <p class="pl-3 textForCheckBox">{{ item.title }}</p>
                        </label>
                    </div>
                </div>
            </div>
        </ValidationProvider>
    </div>
</template>

<script>
import {ValidationProvider} from 'vee-validate';

export default {
    name: 'CheckBoxGroup',
    components: {ValidationProvider},
    props: {
        options: {
            type: Array,
            required: true
        },
        selectedOptions: {
            type: Array,
            required: true
        },
        label: {
            type: String,
            required: true
        },
        errorMessage: {
            type: String,
            default: 'выберите несколько вариантов'
        },
        validationRules: {
            type: String,
            default: 'required'
        }
    },
    computed: {
        localSelectedValues: {
            get() {
                return this.selectedOptions.slice();
            },
            set(value) {
                this.$emit('update:selectedOptions', value);
            }
        }
    },
};
</script>

<style scoped>
.sb-admin-create-object .block__services label span {
    border: 1px solid gray !important;
}
</style>
