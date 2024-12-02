<template>
    <label style="white-space: nowrap">
        {{ label }}
        <ValidationProvider rules="required" v-slot="{ valid, errors, dirty, invalid }">
            <input required v-model="time" type="time" name="time" class="w-50" @input="setEndTime"/>
        </ValidationProvider>
    </label>
</template>

<script>
export default {
    name: "TimeInput",
    props: ['value', 'label'],
    computed: {
        time: {
            get() {
                return this.value;
            },
            set(newValue) {
                this.$emit('input', newValue);
            },
        },
    },
    methods: {
        setEndTime() {
            // code to update the end time
        },
    },
}
</script>

<style scoped>

</style>
