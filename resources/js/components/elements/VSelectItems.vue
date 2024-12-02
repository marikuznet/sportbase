<template>
    <div :class="class_wrapper" :id="id">
        <div class="select-wrapper" :class="class_select_wrapper">
            <v-select class="selectpicker" :class_v_select="class_v_select" :options="options"
                      @input="saveValue" :labelTitle="label" v-model="selectedIndex" textProp="title" valueProp="id"/>
        </div>
        <div class="sb-selected" :class="class_selected_items" v-if="selectedItems.length > 0">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-wrap mt-3">
                        <div v-for="(item, index) in selectedItems"
                             class="type-list-border__item" :id="item.id"
                             :key="item.id" :value="{id: item.id, title: item.title}">
                            {{ item.title }}
                            <span @click="selectedItems.splice(index, 1)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VSelect from "@alfsnd/vue-bootstrap-select";

export default {
    name: "VSelectItems",
    components: {VSelect},
    props: {
        class_wrapper: {
            type: String,
            default: ''
        },
        class_select_wrapper: {
            type: String,
            default: ''
        },
        class_v_select: {
            type: String,
            default: ''
        },
        class_selected_items: {
            type: String,
            default: ''
        },
        id: {
            type: String,
            default: ''
        },
        label: {
            type: String,
            default: ''
        },
        options: {
            type: Array | String,
            required: true,
        },
        selectedItems: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            selectedIndex: null
        }
    },
    computed: {},
    methods: {
        saveValue(value) {
            if (value) {
                if (value.id === 0) {
                    this.$emit('updateSelectedNull');
                } else {
                    const existingItem = this.selectedItems.find(selItem => selItem.id === value.id);
                    if (!existingItem) {
                        this.$set(this.selectedItems, this.selectedItems.length, value);
                    }
                }
                this.$nextTick(() => {
                    this.selectedIndex = null;
                });
            }
        },
    },
    mounted() {
    }
}
</script>

<style scoped>

</style>
