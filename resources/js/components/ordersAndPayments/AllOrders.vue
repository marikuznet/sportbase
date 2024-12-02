<template>
    <div>
        <!-- Активные заказы -->
        <div style="background-color: white">
            <div class="container active-order p-0 pt-3 pb-3 d-flex justify-content-between align-items-center
                    px-4 px-lg-0">
                <h3 class="caption">Активные заказы</h3>
                <div class="arrow-button d-flex justify-content-center shadow cursor-pointer"
                     data-toggle="collapse" data-target="#activeOrders" aria-expanded="true">
                    <img width="20px" alt="down" src="/icons/downArrowRed.svg" class="cursor-pointer">
                </div>
            </div>
        </div>
        <v-order-component v-if="orders" id="activeOrders" class="collapse show" :orders="orders">
        </v-order-component>

        <!-- Завершенные заказы -->
        <div class="mt-3 mb-3" style="background-color: white">
            <div class="container active-order p-0 pt-3 pb-3 d-flex justify-content-between align-items-center
                    px-4 px-lg-0">
                <h3 class="caption">Завершенные заказы</h3>
                <div class="arrow-button d-flex justify-content-center shadow cursor-pointer"
                     data-toggle="collapse" data-target="#finishOrders" aria-expanded="true">
                    <img width="20px" alt="down" src="/icons/downArrowRed.svg">
                </div>
            </div>
        </div>
        <v-order-component v-if="archiveOrders" id="finishOrders" class="collapse show mb-5" :orders="archiveOrders">
        </v-order-component>
    </div>
</template>

<script>
export default {
    name: "AllOrders",
    props: {
        orders: {
            type: Array,
            required: true
        },
        archiveOrders: {
            type: Array,
            required: true
        }
    },
    methods: {
        /* toggleActiveOrders() {
             const activeOrdersElement = document.getElementById('activeOrders');
             if (activeOrdersElement.classList.contains('show')) {
                 activeOrdersElement.classList.remove('show');
             } else {
                 activeOrdersElement.classList.add('show');
             }
         },*/
    }
}
</script>

<style scoped>

</style>
