<template>
    <div class="filter-select py-3 filters-block__item">
        <div class="select-wrapper">
            <span class="select-label">{{ label }}</span>
            <v-select class="selectpicker" :options="options" @input="addItem($event)" :labelTitle="labelTitle"
                      v-model="selectedIndex" textProp="title" valueProp="id"
            >
            </v-select>
        </div>
        <div class="sb-selected-items" v-if="selectedItems.length > 0">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-wrap mt-3">
                        <div v-for="(item, index) in selectedItems"
                             class="type-list-border__item" :id="item.id"
                             :key="item.id" :value="{id: item.id, title: item.title}">
                            {{ item.title }}
                            <span @click="removeItem(index)"/>
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
    components: {
        VSelect
    },
    name: "FilterSelect",
    props: {
        label: {
            type: String,
            required: true
        },
        labelTitle: {
            type: String,
            required: true
        },
        options: {
            type: Array,
            required: true
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
    methods: {
        addItem(item) {
            if (item) {
                if (!this.selectedItems.some(selItem => selItem.id === item.id) && item.id !== 0) {
                    this.selectedItems.push(item);
                }
                this.$nextTick(() => {
                    this.selectedIndex = null;
                });
            }
        },
        removeItem(index) {
            this.selectedItems.splice(index, 1);
        },
    }
}
</script>

<style scoped>

</style>
