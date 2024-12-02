<template>
    <div>
        <navbar></navbar>
        <div style="background-color: #F9F9F9">
            <section class="container p-0 block-estimate pb-4">
                <p class="caption-stage pt-4">Шаг 3 управление заказом</p>
                <p class="sub-caption-stage caption-stage pb-4 ">Добавление файла</p>

                <main>
                    <div class="logo d-flex justify-content-center mb-3">
                        <img src="/icons/logo.png" alt="">
                    </div>
                    <div class="notif d-lg-flex d-none align-items-center p-3 justify-content-between">
                        <img class="mr-4" src="/icons/wallet.svg" alt="">
                        <div class="w-100">
                            <p>Вы уведомили об оплате по счету №12334, так же прикрепили
                                документ об оплате. Ожидайте подтверждении оплаты от системы.</p>
                        </div>
                        <div class="btn_arbitration">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon border-green">Документ
                                об оплате
                            </button>
                        </div>
                    </div>
                    <div class="notif d-lg-none align-items-center p-3 justify-content-between">
                        <div class="d-flex">
                            <div class="flex-grow-0 mr-3">
                                <img width="24px" src="/icons/wallet.svg" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p style="color: #59728B" class="pb-4">Вы уведомили об оплате по счету №12334, так же
                                    прикрепили документ об оплате. Ожидайте подтверждении оплаты от системы.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="btn_arbitration text-center">
                                    <button style="width: 255px; border-radius: 5px" class="btn-base button-icon border-green">
                                        Документ об оплате
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-4 d-lg-block d-none">
                        <p class="ago">Сегодня</p>
                    </div>
                    <div class="pb-4 d-lg-none d-block">
                        <p class="ago">Сегодня</p>
                    </div>

                    <div class="logo d-flex justify-content-center mb-3">
                        <img src="/icons/logo.png" alt="">
                    </div>

                    <div class="notif d-lg-none align-items-center p-3 justify-content-between">
                        <div class="d-flex">
                            <div class="flex-grow-0 mr-3">
                                <img width="24px" src="/icons/warning-green.svg" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p style="color: #59728B" class="pb-4">Вы подтвердили оплату по счету №123456. Для
                                    ускорения подтверждения прикрепите документ подтверждающий оплату</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="btn_arbitration text-center">
                                    <button style="width: 255px; border-radius: 5px" class="btn-base button-icon border-blue">
                                        Загрузить файл
                                        <img class="ml-3" src="/icons/Solid.svg" alt="">
                                    </button>
                                </div>
                                <div class="btn_arbitration text-center">
                                    <button style="width: 255px; border-radius: 5px" class="btn-base button-icon button-blue">
                                        Подтвердить оплату
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="notif d-lg-flex d-none align-items-center p-3 justify-content-between">
                        <img class="mr-4" src="/icons/warning-green.svg" alt="">
                        <div class="w-100">
                            <p>Вы подтвердили оплату по счету №123456. Для ускорения подтверждения
                                прикрепите документ подтверждающий оплату</p>
                        </div>
                        <div class="btn_arbitration upload-btn">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon border-blue">
                                Загрузить файл
                                <img class="ml-3" src="/icons/Solid.svg" alt="">
                            </button>
                        </div>
                        <div class="btn_arbitration">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon button-blue">
                                Подтвердить оплату
                            </button>
                        </div>
                    </div>
                    <div class="pb-4 d-lg-block d-none">
                        <p class="ago">Сегодня</p>
                    </div>
                    <div class="pb-4 d-lg-none d-block">
                        <p class="ago">Сегодня</p>
                    </div>

                    <p class="sub-caption-stage caption-stage pt-4 pb-4">Управление заказом - время
                        идет</p>

                    <div class="logo d-flex justify-content-center mb-3">
                        <img src="/icons/logo.png" alt="">
                    </div>

                    <div class="notif d-lg-flex d-none align-items-center p-3 justify-content-between">
                        <img class="mr-4" src="/icons/settingsGreen.svg" alt="">
                        <div class="mr-3 order">Управление заказом</div>
                        <div class="w-100 d-flex align-items-center">
                            <p class="mr-5">Заказ выполняется. До завершения осталось:</p>
                            <div class="active end-time p-2 d-flex align-items-center justify-content-center">
                                3 дня 22 часа
                            </div>
                        </div>
                        <div class="btn_arbitration">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon">Обратиться в арбитраж
                            </button>
                        </div>
                    </div>

                    <div class="notif d-flex d-lg-none flex-wrap p-3 justify-content-center">
                        <div class="d-flex">
                            <div class="flex-grow-0 mr-3">
                                <img width="24px" class="mr-4" src="/icons/settingsGreen.svg" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-3 order" style="font-size: calc(0.875rem);">Управление заказом</p>
                                <p class="mr-5">Заказ выполняется. До завершения осталось:</p>
                                <div class="active end-time p-2 d-flex align-items-center justify-content-center mt-2">
                                    3 дня 22 часа
                                </div>
                            </div>
                        </div>
                        <div class="btn_arbitration mt-4">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon">Обратиться в арбитраж
                            </button>
                        </div>
                    </div>
                    <div class="pb-4 d-lg-block d-none">
                        <p class="ago">1 день назад</p>
                    </div>
                    <div class="pb-4 d-lg-none d-block">
                        <p class="ago">1 день назад</p>
                    </div>

                    <p class="sub-caption-stage caption-stage pt-4 pb-4">Управление заказом - время
                        истекло</p>

                    <div class="logo d-flex justify-content-center mb-3">
                        <img src="/icons/logo.png" alt="">
                    </div>
                    <div class="notif d-lg-flex d-none align-items-center p-3 justify-content-between">
                        <img class="mr-4" src="/icons/settingsGreen.svg" alt="">
                        <div class="mr-3 order">Управление заказом</div>
                        <div class="w-100">
                            <p>Время выполнения заказа истекло <b>1 января 2021 в 15:48.</b></p>
                            <p>Ожидайте подтверждения выполения заказа от Заказчика.</p>
                            <p>Или выполение будет подтверждено автоматически <b>8 января 2021 в 15:48</b></p>
                        </div>
                        <div class="btn_arbitration">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon">Обратиться в арбитраж
                            </button>
                        </div>
                    </div>
                    <div class="notif d-lg-none align-items-center p-3 justify-content-between">
                        <div class="d-flex">
                            <div class="flex-grow-0 mr-3">
                                <img width="25px" class="mr-4" src="/icons/settingsGreen.svg" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-3 order" style="font-size: calc(0.875rem);">Управление заказом</div>
                                <div class="w-100 enum">
                                    <p class="mb-2">Время выполнения заказа истекло <b>1 января 2021 в 15:48.</b></p>
                                    <p class="mb-2">Ожидайте подтверждения выполения заказа от Заказчика.</p>
                                    <p class="mb-2">Или выполнение будет подтверждено автоматически <b>8 января 2021 в
                                        15:48</b>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="btn_arbitration d-flex justify-content-center">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon">Обратиться в
                                арбитраж
                            </button>
                        </div>
                    </div>
                    <div class="pb-4 d-lg-block d-none">
                        <p class="ago">1 день назад</p>
                    </div>
                    <div class="pb-4 d-lg-none d-block">
                        <p class="ago">1 день назад</p>
                    </div>

                    <p class="sub-caption-stage caption-stage pt-4 pb-4">Добавление арбитра</p>
                    <div class="d-flex add-referee">
                        <div class="w-25 left">
                            <p class="title-referee">Арбитр</p>
                            <div class="d-flex referee mb-1">
                                <div class="img mr-3">
                                    <img src="/icons/photo_arbitr.svg" alt="">
                                </div>
                                <div class="name">
                                    <p class="caption">Андрей Иванов</p>
                                    <p class="sub-caption">сотрудник службы поддержки</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-75 right">
                            <div class="message-referee p-3">
                                <p>К вашему заказу был добавлен арбитр (сотрудник службы поддержки). Он ознакомится с
                                    деталями заказа и переписки в течении 24 часов и задаст уточняющие вопрос (на этой
                                    странице). Ожидайте ответа арбитра в ближайшее время.</p>
                            </div>
                        </div>
                    </div>

                    <p class="sub-caption-stage caption-stage pt-4 pb-4">Чат</p>
                    <p class="d-block mb-2 "
                        style="font-size: calc(1.125rem); color: #0B3158; font-weight: bold">Ваше сообщение в заказе</p>
                    <div class="chat">
                        <vue-editor id="editorChat" :editorToolbar="customToolbar" placeholder="Текст вашего сообщения"
                                    v-model="chat">
                        </vue-editor>
                    </div>


                    <p class="sub-caption-stage caption-stage pt-4 pb-4">Системные предупреждения</p>
                    <div class="logo d-flex justify-content-center mb-3">
                        <img src="/icons/logo.png" alt="">
                    </div>
                    <div class="notif d-lg-flex d-none align-items-center p-3 justify-content-between">
                        <img class="mr-4" src="/icons/warning-red.svg" alt="">
                        <div class="w-100">
                            <p>Для участия в заказе заполните полностью информацию о вашей компании на странице</p>
                        </div>
                        <div class="btn_arbitration">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon border-blue">Профиль
                                пользователя
                            </button>
                        </div>
                    </div>
                    <div class="notif d-lg-none align-items-center p-3 justify-content-between">
                        <div class="d-flex">
                            <div class="flex-grow-0 mr-3">
                                <img width="24px" src="/icons/warning-red.svg" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p style="color: #59728B" class="pb-4">Для участия в заказе заполните полностью
                                    информацию о вашей компании на странице</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="btn_arbitration text-center">
                                    <button style="width: 255px; border-radius: 5px" class="btn-base button-icon border-blue">
                                        Профиль пользователя
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-4 d-lg-block d-none">
                        <p class="ago">Сегодня</p>
                    </div>
                    <div class="pb-4 d-lg-none d-block">
                        <p class="ago">Сегодня</p>
                    </div>


                    <div class="logo d-flex justify-content-center mb-3">
                        <img src="/icons/logo.png" alt="">
                    </div>

                    <div class="notif d-lg-flex d-none align-items-center p-3 justify-content-between">
                        <img class="mr-4" src="/icons/warning-red.svg" alt="">
                        <div class="w-100">
                            <p>Для участия в заказе укажите платежные данные (реквизиты) компании в аккаунте на
                                странице</p>
                        </div>
                        <div class="btn_arbitration">
                            <button style="width: 255px; border-radius: 5px" class="btn-base button-icon border-blue">Платежные
                                реквизиты
                            </button>
                        </div>
                    </div>
                    <div class="notif d-lg-none align-items-center p-3 justify-content-between">
                        <div class="d-flex">
                            <div class="flex-grow-0 mr-3">
                                <img width="24px" src="/icons/warning-red.svg" alt="">
                            </div>
                            <div class="flex-grow-1">
                                <p style="color: #59728B" class="pb-4">Для участия в заказе укажите платежные данные
                                    (реквизиты) компании в аккаунте на странице</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="btn_arbitration text-center">
                                    <button style="width: 255px; border-radius: 5px" class="btn-base button-icon border-blue">
                                        Платежные реквизиты
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-4 d-lg-block d-none">
                        <p class="ago">Сегодня</p>
                    </div>
                    <div class="pb-4 d-lg-none d-block">
                        <p class="ago">Сегодня</p>
                    </div>

                    <p class="sub-caption-stage caption-stage pt-4 pb-4">Оставление отзыва о сотрудничестве</p>
                    <div class="logo d-none d-lg-flex  justify-content-center mb-3">
                        <img src="/icons/logo.png" alt="">
                    </div>

                    <div class="review-cooperation">
                        <div class="title d-lg-flex d-none justify-content-between pl-4 pr-4 pt-3">
                            <div class="left d-flex align-items-center">
                                <img class="mr-3" src="/icons/settingsGreen.svg" alt="">
                                <p class="leave-review">Оставьте ваш отзыв о сотрудничестве</p>
                            </div>
                            <div class="right d-flex align-items-center">
                                <p class="mr-5">Или завершить заказ с возможностью оставить отзыв позже</p>
                                <div class="btn_arbitration">
                                    <button style="width: 200px; border-radius: 5px" class="btn-base button-icon border-green">
                                        Завершить заказ
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="title d-flex flex-wrap d-lg-none justify-content-between pl-4 pr-4 pt-3">
                            <div class="d-flex">
                                <div class="flex-grow-0 mr-3">
                                    <img width="24px" class="mr-3" src="/icons/settingsGreen.svg" alt="">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-3 order leave-review" style="font-size: calc(0.875rem);">
                                        Оставьте ваш отзыв о сотрудничестве
                                    </p>
                                    <div class="w-100 enum mb-3">
                                        <p>Или завершить заказ с возможностью оставить отзыв позже</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row w-100">
                                <div class="col-12">
                                    <div class="btn_arbitration text-center">
                                        <button style="width: 255px; border-radius: 5px"
                                                class="btn-base button-icon border-green">
                                            Завершить заказ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr width="100%">
                        <div class="container body mr-lg-5 ml-lg-5 mb-lg-4" style="width: auto;">
                            <div class="row points-rating ">
                                <div class="col-md-4">
                                    <div class="row mb-lg-2">
                                        <div class="rating-messages d-flex justify-content-between align-items-center">
                                            <p class="caption">Инфраструктура</p>
                                            <div class="d-flex">
                                                <div class="rating align-items-center col-auto d-flex">
                                                    <div class="d-flex align-items-center">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <div class="rate p-2 ml-3">
                                                            <p style="font-size: calc(1rem); color: #0B3158">5</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="rating-messages d-flex justify-content-between align-items-center">
                                            <p class="caption">Состояние спортивных сооружений</p>
                                            <div class="d-flex">
                                                <div class="rating align-items-center col-auto d-flex">
                                                    <div class="d-flex align-items-center">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <div class="rate p-2 ml-3">
                                                            <p style="font-size: calc(1rem); color: #0B3158">4.5</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-lg-2">
                                        <div class="rating-messages d-flex justify-content-between align-items-center">
                                            <p class="caption">Питание</p>
                                            <div class="d-flex">
                                                <div class="rating align-items-center col-auto d-flex">
                                                    <div class="d-flex align-items-center">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <div class="rate p-2 ml-3">
                                                            <p style="font-size: calc(1rem); color: #0B3158">4.5</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="rating-messages d-flex justify-content-between align-items-center">
                                            <p class="caption">Территория</p>
                                            <div class="d-flex">
                                                <div class="rating align-items-center col-auto d-flex">
                                                    <div class="d-flex align-items-center">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <div class="rate p-2 ml-3">
                                                            <p style="font-size: calc(1rem); color: #0B3158">4.5</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-lg-2">
                                        <div class="rating-messages d-flex justify-content-between align-items-center">
                                            <p class="caption">Расположение</p>
                                            <div class="d-flex">
                                                <div class="rating align-items-center col-auto d-flex">
                                                    <div class="d-flex align-items-center">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <div class="rate p-2 ml-3">
                                                            <p style="font-size: calc(1rem); color: #0B3158">5</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="rating-messages d-flex justify-content-between align-items-center">
                                            <p class="caption">Цена/качество</p>
                                            <div class="d-flex">
                                                <div class="rating align-items-center col-auto d-flex">
                                                    <div class="d-flex align-items-center">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <img class="pr-1" src="/icons/direct/star.svg">
                                                        <div class="rate p-2 ml-3">
                                                            <p style="font-size: calc(1rem); color: #0B3158">4.5</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-review ml-lg-5 mr-lg-5 mb-4">
                            <div class="title mb-2 d-flex justify-content-between">
                                <p style="color: #0B3158; font-size: calc(1.25rem)">Текст отзыва</p>
                                <p style="color: #6283E5; font-size: calc(1.125rem); font-weight: normal">{{
                                    review.length }}/500</p>
                            </div>
                            <vue-editor :maxlength="maxReview" id="editor"
                                        :editorToolbar="customToolbar"
                                        placeholder="Текст вашего сообщения"
                                        v-model="review"></vue-editor>
                            <div class="text-center">
                                <button class="btn-base btn-green p-2 mt-3">Оставить отзыв</button>
                            </div>
                        </div>
                    </div>

                </main>
            </section>
        </div>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from '../NavBar'
import extendedinf from "../ExtendedFooterInformation";
import VSelect from "@alfsnd/vue-bootstrap-select";
import {VueEditor} from 'vue2-editor';

export default {
    data: function () {
        return {
            review: '', maxReview: 500,
            chat: '',
            customToolbar: [
                [{'header': [1, 2, 3, 4, 5, 6, false]}],
                [{
                    'color': ['#0B3158', '#000000', '#e60000', '#ff9900', '#ffff00', '#008a00', '#0066cc', '#9933ff', '#ffffff'],
                    'background': []
                }],
                ['bold', 'italic'],
                [{'list': 'bullet'}, {'list': 'ordered'}, {'align': []}],
            ],
        }
    },
    methods: {},
    components: {
        navbar, extendedinf, VSelect, VueEditor
    },
}
</script>

<style scoped>
.button-blue {
    background-color: #6283E5 !important;
    color: white;
    font-size: calc(1.06rem) !important;
    height: 47px;
}

.caption-stage {
    margin-bottom: 55px;
}

.sub-caption-stage {
    font-size: calc(1.75rem);
    margin-bottom: 0;
}

.border-green {
    color: #6FB77F !important;
    border: 1px solid #6FB77F !important;
}

.border-blue {
    color: #6283E5 !important;
    border: 1px solid #6283E5 !important;
}

.button-blue {
    color: white !important;
    border: none !important;
    background-color: #6283E5 !important;
}

.btn_arbitration.upload-btn {
    margin-right: 1rem;
}

.notif .order {
    font-size: calc(1.375rem);
    font-weight: bold;
    color: #0B3158;
}

.end-time {
    background-color: #C4C7D6;
    border-radius: 5px;
    width: 190px;
    color: white;
    font-size: calc(1.375rem);
}

.active.end-time {
    font-size: calc(0.94rem);
    width: 140px;
    background-color: #6FB77F;
}

.add-referee .title-referee {
    font-size: calc(1.125rem);
    color: #E45868;
}

.add-referee .name .caption {
    color: #0B3158;
    font-size: calc(1.125rem);
    font-weight: bold;
}

.add-referee .name .sub-caption {
    color: #0B3158;
    font-size: calc(1rem);
}

.add-referee .message-referee {
    background-color: white;
    border: 1px solid #E45868;
    border-radius: 10px;
}

.add-referee .message-referee p {
    font-size: calc(1.06rem);
    color: #0B3158;
}

.review-cooperation .title p {
    color: #0B3158;
    font-size: calc(1.25rem);
}

.review-cooperation {
    background-color: white;
    border: 2px solid #BAC4DF;
    border-radius: 10px;
}

.review-cooperation .leave-review {
    font-weight: bold;
}

.review-cooperation .body .caption {
    color: #0B3158;
    font-size: calc(1rem);
}

.rating-messages .rate {
    border: 1px solid rgba(98, 131, 229, 0.3);
    border-radius: 14px;
}

#editor {
    border-radius: 0 0 10px 10px;
}

.ql-toolbar.ql-snow {
    border-radius: 10px 10px 0 0;
}

.btn-green {
    background-color: #6FB77F;
    color: white;
    border-radius: 5px;
    width: 200px;
    height: 50px;
}

@media (max-width: 960px) {
    .details__estimate {
        width: 100% !important;
        margin-right: 0 !important;
    }

    .caption-stage {
        font-size: calc(1.5rem);
        margin-bottom: 0;
    }

    .sub-caption-stage {
        font-size: calc(1.19rem);
        margin-bottom: 0;
    }

    .notif p {
        color: #0B3158;
        font-size: calc(0.875rem);
    }

    .btn_arbitration .button-blue {
        margin-top: 10px !important;
    }

    .add-referee {
        flex-wrap: wrap;
    }

    .add-referee .left {
        margin-bottom: 25px;
    }

    .add-referee .left, .add-referee .right {
        width: 100% !important;
    }

    .add-referee .title-referee, .add-referee .name .caption {
        font-size: calc(1rem) !important;
    }

    .add-referee .name .sub-caption, .message-referee p {
        font-size: calc(0.875rem) !important;
    }

    .border-blue {
        color: #0B3158 !important;
    }

    .rating-messages {
        padding-top: 0 !important;
    }

    .review-cooperation .body {
        margin-left: 0.5rem !important;
        margin-left: 0 !important;
    }

    .review-cooperation .title p {
        font-size: calc(0.875rem) !important;
    }

    .review-cooperation .body {
        margin-left: 1rem !important;
        margin-right: 1rem !important;
    }

    .text-review {
        margin-left: 1.5rem !important;
        margin-right: 1.5rem !important;
    }

    .review-cooperation .body .caption {
        font-size: calc(0.81rem);
    }

    .rating img {
        width: 16px;
    }

    .rating .rate p {
        font-size: calc(0.81rem) !important;
    }

    .points-rating {
        margin-bottom: 30px;
    }

    .points-rating .row {
        margin-bottom: 10px;
    }

    .rating-messages .rating {
        padding-right: 0 !important;
    }

    .text-review .title p {
        font-size: calc(1rem) !important;
        font-weight: bold;
    }

    .text-review button {
        width: 255px;
        height: 45px;
        font-size: calc(0.875rem);
    }
}
</style>
