<template>
    <div class="container-response-body ">
        <div class="border-bottom-solid border-left-0 border-right-0 border-top-solid executor-body pl-4 pr-4">
            <div class="row w-100">
                <div class="col-12 col-sm-12 col-md-6 pt-2">
                    <!-- вид спорта -->
                    <div>
                        <div class="d-flex">
                            <div class="col-md-12 p-0">
                                <div class="pt-2">
                                    <p class="captionText_l">Виды спорта</p>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="buta pl-2 pr-2 p-2"
                                         v-for="sport in prop_request.type_sports">
                                        <p>{{ sport.title }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- регион -->
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex flex-wrap">
                                    <div class="butt pr-2">
                                        <p class="captionText_l">Регион</p>
                                    </div>
                                    <div class="butt">
                                        <img src="/icons/direct/world.svg">
                                    </div>
                                    <div class="butt">
                                        <p class="country">Россия</p>
                                    </div>
                                    <div class="butn p-2 text-white">
                                        <p class="text-white">{{ prop_request.city }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- тип питания -->
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pt-2">
                                    <p class="captionText_l">Тип питания</p>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="buta pl-2 pr-2 p-2" v-for="food in prop_request.typeFoods">
                                        <p>{{ food.title }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Количество человек -->
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row pl-1 pt-2">
                                    <p class="captionText_l">Количество человек</p>
                                </div>
                                <div class="d-flex">
                                    <div class="buta pl-2 pr-2 p-2">
                                        <p>{{ prop_request.colPeople }} человек</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Стоимость за человека -->
                    <div class="pb-lg-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row pl-1 pt-2">
                                    <p class="captionText_l">Стоимость (за человека)</p>
                                </div>
                                <div class="d-flex">
                                    <div
                                        class="align-items-center butn d-flex p-2 pl-2 pr-2 text-nowrap">
                                        <p class="text-white">{{ prop_request.minPrice }} руб.</p>
                                    </div>
                                    <div class="butt pl-2 pr-2 text-nowrap">
                                        <p>за сутки</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="white3-2 col-12 col-sm-12 col-md-6 pt-2 pl-3 pr-3">
                    <!-- Инфраструктура -->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row pl-1 pt-2">
                                    <p class="captionText_l">Инфраструктура</p>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="buta pl-2 pr-2 p-2"
                                         v-for="infr in prop_request.infrastructures">
                                        <p>{{ infr.title }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Дата пребывания -->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="pt-2">
                                    <p class="captionText_l">Дата пребывания</p>
                                </div>
                                <div class="d-flex date-of-stay">
                                    <div class="butt d-none d-lg-flex">
                                        <p>с</p>
                                    </div>
                                    <div class="butg pl-2 pr-2 ">
                                        <p>{{ prop_request.startDate }}</p>
                                    </div>
                                    <div class="butt">
                                        <p>по</p>
                                    </div>
                                    <div class="butg pl-2 pr-2">
                                        <p>{{ prop_request.endDate }}</p>
                                    </div>
                                    <div class="butt d-none d-lg-flex">
                                        <p>{{ prop_request.endDate_year }}</p>
                                    </div>
                                    <div class="buta mt-2 pl-2 pr-2 d-flex align-items-center">
                                        <p>{{ prop_request.spreadDate }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Дополнительные услуги -->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row pl-1 pt-2">
                                    <p class="captionText_l">Дополнительные услуги</p>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="buta pl-2 pr-2 p-2"
                                         v-for="addition in prop_request.additionsTender">
                                        <p>{{ addition.title }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="executor-footer border-0 pl-4 pr-4" :id="'response-'+prop_request.id">
            <div class="pt-4 pb-4">
                <p class="captionText_l">Сообщение</p>
                <p class="message-text">{{ prop_request.comment }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['prop_request'],
    name: "Request",
    data() {
        return {}
    },
    computed: {
        request() {
            return this.$props.prop_request;
        }
    },
}
</script>

<style scoped>

</style>
