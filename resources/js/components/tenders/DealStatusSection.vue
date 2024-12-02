<template>
    <div class="sb-deal-status">
        <div class="blockDeal d-flex mb-2 mr-2"
             style="border: 1px solid #52AF67; border-radius: 10px">
            <template v-if="data.deal">
                <div class="notification-green d-flex mr-2 w-auto min-vw-0"
                     :class="{'notification-red': data.dealData.complete === 2}">
                    <img alt="info" class="pr-2" src="/icons/direct/information.svg">
                    <p v-if="[1,2].includes(data.dealData.complete) || [4,5].includes(data.dealData.step)" class="text-white align-items-center d-flex">
                        {{ data.dealData.complete === 1 ? 'Завершена' : '' }}

                        {{ data.dealData.complete === 2 ? 'Завершена с арбитражем' : '' }}
                    </p>
                    <p v-else class="text-white align-items-center d-flex">
                        {{ data.dealData.step === 1 ? 'На согласовании' : '' }}

                        {{ data.dealData.step === 3 ? 'В процессе выполнения (шаг 3)' : '' }}

                        {{ data.dealData.step === 2 ? 'В процессе выполнения (шаг 2)' : '' }}

                        <!--{{ data.dealData.step === 4 ? 'В процессе выполнения (шаг 4)' : '' }}

                        {{ data.dealData.step === 5 ? 'В процессе выполнения (шаг 5)' : '' }}!-->
                    </p>
                </div>
            </template>

            <div class="align-items-center d-flex" v-if="data.deal">
                <a :href="'/transaction/deal/'+ data.dealData.id"
                   class="w-auto d-flex align-items-center pr-5 num-deal">
                    сделка № {{ data.dealData.id }}
                </a>
            </div>

            <div v-if="!data.deal" class="selectCustomer d-flex justify-content-center align-items-center w-auto
                pr-3 pl-3">
                <span>
                {{ user.role === 3 ? 'Выбран исполнителем' : '' }}
                {{ user.role === 2 ? 'Выбран исполнитель' : '' }}
            </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DealStatusSection",
    props: {
        data: {
            type: Object,
            required: true
        }
    },
    computed: {
        user: function () {
            return window.user;
        },
    }
}
</script>

<style scoped>

</style>
