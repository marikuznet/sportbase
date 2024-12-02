<template>
    <div>
        <label class="caption w-100">Что включено в стоимость проживания
            <span style="color: rgb(243, 122, 138)">*</span>
            <span class="text-muted float-right font-weight-normal">{{ includedLength - 1 }}/100</span>
        </label>

        <div class="closePriceAllLive p-0 d-flex align-items-center mb-2"
             v-for="(item, index) in included">
            <div class="w-100 d-flex align-items-center">
                <img v-if="item.title !== ''" @click.prevent="deleteIncludedPricing(index)"
                     class="position-absolute" style="z-index: 1; right: 25px" src="/icons/stages/exit.svg" alt="exit">
                <div class="col-sm-12 p-0 m-0">
                    <div class="h-100">
                        <input type="text" v-model="item.title" autocomplete="off" name="options"
                               placeholder="Введите название опции" class="input-profile-info titleOption w-100">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 p-0 m-0 buttonOption">
            <button type="button" @click="addIncludedPricing" class="btn" :disabled="invalid">
                Добавить опцию +
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "IncludedPricingForm",
    props: {
        included: Array,
        includedLength: Number,
        invalid: Boolean
    },
    methods: {
        addIncludedPricing() {
            this.$emit("add-included-pricing");
        },
        deleteIncludedPricing(index) {
            this.$emit("delete-included-pricing", index);
        }
    }
}
</script>

<style scoped>

</style>
