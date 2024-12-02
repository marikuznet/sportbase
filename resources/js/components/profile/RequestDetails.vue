<template>
    <div class="row w-100">
        <div class="col-12 col-sm-12 col-md-6 pt-2">
            <!-- Вид спорта -->
            <div class="container">
                <div class="d-flex">
                    <div class="col-md-12 p-0">
                        <div class="pt-2">
                            <p class="captionText_l">Виды спорта</p>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="buta pl-2 pr-2 p-2" v-for="sport in direct.type_sports" :key="sport.id">
                                <p>{{ sport.title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Регион -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex">
                            <div class="butt pr-2">
                                <p class="captionText_l">Регион</p>
                            </div>
                            <div class="butt">
                                <img src="/icons/direct/world.svg"/>
                            </div>
                            <div class="butt">
                                <p class="country">{{ direct.sportObject.country }}</p>
                            </div>
                            <div class="butn p-2 text-white">
                                <p class="text-white">{{ direct.sportObject.city }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Тип питания -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pt-2">
                            <p class="captionText_l">Тип питания</p>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="buta pl-2 pr-2 p-2" v-for="food in direct.typeFoods" :key="food.id">
                                <p>{{ food.title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Количество человек -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row pl-1 pt-2">
                            <p class="captionText_l">Количество человек</p>
                        </div>
                        <div class="d-flex">
                            <div class="buta pl-2 pr-2 p-2">
                                <p>{{ direct.colPeople }} человек</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Стоимость за человека -->
            <div class="container pb-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row pl-1 pt-2">
                            <p class="captionText_l">Стоимость (за человека)</p>
                        </div>
                        <div class="d-flex">
                            <div class="butn pl-2 pr-2 p-2">
                                <p class="text-white">{{ direct.minPrice }} руб.</p>
                            </div>
                            <div class="butt pl-2 pr-2">
                                <p>за сутки</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="white3-2 col-12 col-sm-12 col-md-6 pt-2">
            <!-- Инфраструктура -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row pl-1 pt-2">
                            <p class="captionText_l">Инфраструктура</p>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="buta pl-2 pr-2 p-2" v-for="infr in direct.infrastructures" :key="infr.id">
                                <p>{{ infr.title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Дата пребывания -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pt-2">
                            <p class="captionText_l">Дата пребывания</p>
                        </div>
                        <div class="d-flex date-of-stay">
                            <div class="butt d-none d-lg-flex">
                                <p>с</p>
                            </div>
                            <div class="butg pl-2 pr-2">
                                <p>{{ direct.startDate }}</p>
                            </div>
                            <div class="butt">
                                <p>по</p>
                            </div>
                            <div class="butg pl-2 pr-2">
                                <p>{{ direct.endDate }}</p>
                            </div>
                            <div class="butt d-none d-lg-flex">
                                <p>{{ direct.endDate_year }}</p>
                            </div>
                            <div class="buta mt-2 pl-2 pr-2 d-flex align-items-center">
                                <p>{{ direct.spreadDate }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Дополнительные услуги -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row pl-1 pt-2">
                            <p class="captionText_l">Дополнительные услуги</p>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="buta pl-2 pr-2 p-2" v-for="addition in direct.additions" :key="addition.id">
                                <p>{{ addition.title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "RequestDetails",
    props: {
        direct: {
            type: Object,
            required: true,
        }
    }
}
</script>

<style scoped>

</style>
