<template>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th v-for="(header, index) in headers" :key="index" class="text-center" @click="changeSort(index)">
                    {{ header.label }}
                    <i v-if="direction[index] === 0" class="fa fa-caret-down mx-2 sort"></i>
                    <i v-else class="fa fa-caret-up mx-2 sort"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, indexItem) in sortedItems" :key="item.id" :class="item.classRow">
                <template v-for="(column, index) in columns">
                    <td v-if="column.prop === 'action'" :width="column.width" :key="index" :class="column.class">
                        <slot name="action" :id="item.id" :item="item"></slot>
                    </td>
                    <td v-else-if="column.prop === 'advertisement'" :width="column.width" :key="index"
                        :class="column.class">
                        <slot name="advertisement" :id="item.id" :item="item" :index="indexItem"></slot>
                    </td>
                    <td v-else-if="column.prop === 'status' || column.prop === 'object_active' || column.prop === 'documents'"
                        :width="column.width" :key="index" :class="column.class">
                        <slot name="status" :item="item"></slot>
                    </td>
                    <template v-else>
                        <td :width="column.width" v-if="!column.html" :key="index" :class="column.class">
                            {{ item[column.prop] }}
                        </td>
                        <td :width="column.width" :class="column.class" v-else>
                            <div v-html="item[column.prop]"></div>
                        </td>
                    </template>
                </template>
            </tr>
            </tbody>
        </table>

        <slot name="modals"></slot>
    </div>
</template>

<script>
export default {
    name: "TableDataComponent",
    props: {
        headers: {
            type: Array,
            required: true
        },
        columns: {
            type: Array,
            required: true
        },
        items: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            direction: [],
            sortedItems: []
        }
    },
    computed: {},
    methods: {
        changeSort(index) {
            this.direction[index] = this.direction[index] === 0 ? 1 : 0;

            this.sortedItems = this.items.slice().sort((a, b) => {
                const prop = this.columns[index].prop;
                const direction = this.direction[index] === 0 ? 1 : -1;

                const valueA = this.getPropertyValue(a[prop]);
                const valueB = this.getPropertyValue(b[prop]);

                let numericValueA, numericValueB;

                if (typeof valueA === 'string' && valueA !== null) {
                    numericValueA = parseFloat(valueA.match(/\d+/)?.[0]);
                } else {
                    numericValueA = valueA;
                }

                if (typeof valueB === 'string' && valueB !== null) {
                    numericValueB = parseFloat(valueB.match(/\d+/)?.[0]);
                } else {
                    numericValueB = valueB;
                }

                if (numericValueA < numericValueB) return -1 * direction;
                if (numericValueA > numericValueB) return 1 * direction;
                return 0;
            });
        },
        getPropertyValue(value) {
            if (typeof value === 'string') {
                return value.toLowerCase();
            }
            return value;
        }
    },
    watch: {
        '$props.items': {
            handler: function (value) {
                this.changeSort(0)
            }, deep: true
        }
    },
    mounted() {
        this.changeSort(0);
    }
}
</script>

<style scoped>
.nonActive {
    color: lightgray !important;
}
</style>
