<template>
    <tr>
        <td></td>
        <td>все дни пребывания</td>
        <td class="table-days-training__time">
            <div class="d-block">
                <label style="white-space: nowrap">1-я
                    <ValidationProvider rules="required" v-slot="{ valid, errors, dirty, invalid }">
                        <input :class="{ 'is-invalid': errors[0] }" class="w-50" type="time" name="time" required
                               v-model="trainingTime[0].start_1_at"
                               @input="setEndTimeOnce(0, 'start_1_at')"/>
                    </ValidationProvider>
                    <ValidationProvider :rules="`required|greaterThanStart:${trainingTime[0].start_1_at}`"
                                        v-slot="{ valid, errors, dirty, invalid }">
                        <input :class="{ 'is-invalid': errors[0] }" class="w-50" type="time" name="time" required
                               v-model="trainingTime[0].end_1_at"/>
                    </ValidationProvider>
                </label>
                <label v-if="training === 2" style="white-space: nowrap">2-я
                    <ValidationProvider rules="required" v-slot="{ valid, errors, dirty, invalid }">
                        <input :class="{ 'is-invalid': errors[0] }" @input="setEndTimeOnce(0, 'start_2_at')" required
                               v-model="trainingTime[0].start_2_at"
                               type="time" name="time" class="w-50"/>
                    </ValidationProvider>
                    <ValidationProvider :rules="`required|greaterThanStart:${trainingTime[0].start_2_at}`"
                                        v-slot="{ valid, errors, dirty, invalid }">
                        <input :class="{ 'is-invalid': errors[0] }" required v-model="trainingTime[0].end_2_at"
                               type="time" name="time" class="w-50"/>
                    </ValidationProvider>
                </label>
            </div>
        </td>
    </tr>
</template>

<script>
import * as moment from "moment";

export default {
    name: "TableDaysTrainingTime",
    data() {
        return {};
    },
    computed: {
        showSecondRow() {
            return this.training === 2;
        },
    },
    props: {
        training: {
            type: Number,
            default: 0,
        },
        trainingTime: {
            type: Array,
            required: true
        }
    },
    methods: {
        setEndTimeOnce(index, start) {
            const timeStart = this.trainingTime[index][start];
            const [hours, minutes] = timeStart.split(':');
            const m = moment({hours, minutes}).add(1, 'hours');
            this.trainingTime[index][`end_${start.split('_')[1]}_at`] = m.format('HH:mm');
            this.$emit('update-training-time', this.trainingTime);
        },
    },
}
</script>

<style scoped>

</style>
