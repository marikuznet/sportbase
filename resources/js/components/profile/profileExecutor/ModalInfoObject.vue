<template>
    <div class="shadow modal-info-object-request tender mb-3 mr-0 ml-0">
        <div class="title-info d-flex flex-wrap p-4 justify-content-between">
            <div class="logo d-flex align-items-center">
                <p class="ispr">Заявка от заказчика</p>
            </div>
        </div>
        <Request :prop_request="tender"></Request>
    </div>
</template>

<script>
import Request from "../../Request";
export default {
    name: "ModalInfoObject",
    components: {Request},
    props: ['tender']
}
</script>

<style>
</style>
