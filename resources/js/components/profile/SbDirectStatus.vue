<template>
    <div class="sb-direct-status d-flex justify-content-between flex-wrap">
        <div class="logo d-none d-lg-flex align-items-center">
            <p class="sb-user-info">{{ customer_info ? 'Заказчик' : 'Исполнитель' }}</p>
            <div class="logo__circle mr-2 ml-2" style="width: 40px; height: 40px">
                <img v-if="customer_info" class="h-100 w-100" style="border-radius: 100%"
                     :alt="'logo-'+customer_info.user_id"
                     :src="'/storage/listings/logos/' + customer_info.user_id + '/' + customer_info.logo">
                <img v-if="executor_info" class="h-100 w-100" style="border-radius: 100%"
                     :alt="'logo-'+ executor_info.user_id"
                     :src="'/storage/listings/logos/' + executor_info.user_id + '/' + executor_info.logo">
            </div>
            <p class="sb-user-info">{{ customer_info ? customer_info.title : executor_info.title }}</p>
        </div>
        <div class="logo d-lg-none flex-wrap align-items-center w-100">
            <p class="sb-user-info">{{ customer_info ? 'Заказчик' : 'Исполнитель' }}</p>
            <div class="d-flex align-items-center justify-content-between pb-2">
                <div class="d-flex">
                    <div class="logo__circle mr-2 ml-2" style="width: 40px; height: 40px">
                        <img v-if="customer_info" class="h-100 w-100" style="border-radius: 100%"
                             :src="'/storage/listings/logos/' + customer_info.user_id + '/' + customer_info.logo"
                             :alt="'logo-'+ customer_info.user_id">
                        <img v-if="executor_info" class="h-100 w-100" style="border-radius: 100%"
                             :src="'/storage/listings/logos/' + executor_info.user_id + '/' + executor_info.logo"
                             :alt="'logo-'+ executor_info.user_id">
                    </div>
                    <p class="sb-user-info d-flex align-items-center">
                        {{ customer_info ? customer_info.title : executor_info.title }}
                    </p>
                </div>

                <div class="d-flex d-lg-none">
                    <button type="button" style="border-radius: 10px" role="button"
                            class="sb-button-blue button-icon emailSvg blue mr-2 h-100">
                        <svg id="email" xmlns="http://www.w3.org/2000/svg" width="20.76"
                             height="15.206"
                             viewBox="0 0 20.76 15.206">
                            <path style="fill: #6283E5" id="Контур_44478"
                                  data-name="Контур 44478"
                                  d="M18.136,24.61H2.624A2.627,2.627,0,0,0,0,27.234v9.959a2.627,2.627,0,0,0,2.624,2.624H18.136a2.627,2.627,0,0,0,2.624-2.624V27.234A2.627,2.627,0,0,0,18.136,24.61Zm-.41,1.692L10.38,31.977,3.033,26.3Zm.41,11.822H2.624a.932.932,0,0,1-.931-.931V27.4l8.17,6.311a.846.846,0,0,0,1.035,0l8.17-6.311v9.788A.932.932,0,0,1,18.136,38.124Z"
                                  transform="translate(0 -24.61)" fill="#fff"/>
                        </svg>
                        <!--<div class="notification-block">
                            12
                        </div>!-->
                    </button>
                    <div style="height: 40px; width: 40px" @click="showIndexHandler"
                         class="pr-3 pl-3 arrow-button justify-content-center shadow align-items-center d-flex cursor-pointer">
                        <img width="30px" src="/icons/upArrowRed.svg" alt=""
                             :class="{'rotate-arrow': showIndex !== directId}">
                    </div>
                </div>
            </div>
        </div>

        <div class="right d-flex">
            <button v-if="isSendMessages && user.role === 3" type="button"
                    @click="showSendMessageCustomer(customer_info.user_id)"
                    class="d-lg-block d-none sb-button-blue button-icon emailSvg blue p-0 mr-2 h-100">
                <svg id="email" xmlns="http://www.w3.org/2000/svg" width="20.76" height="15.206"
                     viewBox="0 0 20.76 15.206">
                    <path style="fill: #6283E5" id="Контур_44478" data-name="Контур 44478"
                          d="M18.136,24.61H2.624A2.627,2.627,0,0,0,0,27.234v9.959a2.627,2.627,0,0,0,2.624,2.624H18.136a2.627,2.627,0,0,0,2.624-2.624V27.234A2.627,2.627,0,0,0,18.136,24.61Zm-.41,1.692L10.38,31.977,3.033,26.3Zm.41,11.822H2.624a.932.932,0,0,1-.931-.931V27.4l8.17,6.311a.846.846,0,0,0,1.035,0l8.17-6.311v9.788A.932.932,0,0,1,18.136,38.124Z"
                          transform="translate(0 -24.61)" fill="#fff"/>
                </svg>
                <!--<div class="notification-block">
                    12
                </div>!-->
            </button>

            <div class="sb-status-action d-flex mr-lg-2" v-if="status === 0 && user.role === 3">
                <button type="button" @click="$emit('createDeal')"
                        class="button button-icon dealSvg mr-2 w-100 justify-content-center h-100">
                    <span style="white-space: nowrap">Принять условия</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="23.63"
                         height="20.837" viewBox="0 0 23.63 20.837">
                        <path id="deal_1_" data-name="deal (1)"
                              d="M23.63,9.405,14.725.5,11.854,3.371,8.9.507,0,9.41l3.587,3.514A2.374,2.374,0,0,0,5.595,16.57h0s0,.005,0,.008a2.379,2.379,0,0,0,2.376,2.376h.007s0,0,0,.007a2.375,2.375,0,0,0,3.8,1.9,2.408,2.408,0,0,0,3.839-1.957,2.409,2.409,0,0,0,2.429-2.435h.1a2.409,2.409,0,0,0,2.012-3.592ZM16.375,13.89,15.43,14.9l.942.88,0,0a1.026,1.026,0,0,1-1.429,1.47l-.01-.01,0,0L14,16.307l-.985.971.989,1A1.026,1.026,0,0,1,12.6,19.752a2.375,2.375,0,0,0-2.24-3.168h-.007s0,0,0-.007A2.379,2.379,0,0,0,7.975,14.2h0s0-.005,0-.008A2.375,2.375,0,0,0,4.64,12.019L1.967,9.4,8.918,2.449l1.958,1.9L7.662,7.563a2.409,2.409,0,0,0,3.407,3.407L13.75,8.288l4.96,4.958c.037.047.075.092.113.135a1.032,1.032,0,0,1-.015,1.382,1.026,1.026,0,0,1-1.394.1Zm-7.01,5.07a.993.993,0,1,1,.993.993A.994.994,0,0,1,9.365,18.961ZM6.982,16.578a.993.993,0,1,1,.993.993A.994.994,0,0,1,6.982,16.578ZM4.6,14.194a.993.993,0,1,1,.993.993.994.994,0,0,1-.993-.993ZM19.25,11.829l-5.5-5.5L10.091,9.992A1.026,1.026,0,1,1,8.64,8.541l6.085-6.085,6.949,6.949Zm0,0"
                              transform="translate(0 -0.5)" fill="#fff"/>
                    </svg>
                </button>
                <button type="button" @click="$emit('cancelResponse')" data-toggle="modal"
                        data-target="#sb-notification-delete"
                        class="button mr-lg-2 button-icon active btn-delete d-flex justify-content-center h-100">
                    <span style="color: #E45868">Отклонить</span>
                    <img class="pl-3" src="/icons/direct/trash.svg" alt="trash">
                </button>
            </div>
            <div class="sb-status-action notification d-flex mr-lg-2" v-if="status === 0 && user.role === 2">
                <img class="pr-2" src="/icons/direct/information.svg" alt="">
                <p class="sb-application-status text-white text-nowrap align-items-center d-flex pl-2 pr-2">
                    Ожидайте, когда Исполнитель ответит на вашу заявку
                </p>
            </div>
            <div class="sb-status-action d-flex" v-if="status === 1">
                <div class="blockDeal d-flex mb-2 mr-lg-2 cursor-pointer"
                     style="border: 1px solid #52AF67; border-radius: 10px"
                     @click="$emit('showDeal')">
                    <div class="notification-green d-flex mr-2 w-auto">
                        <img class="pr-2" src="/icons/direct/information.svg" alt="info">
                        <p class="sb-application-status text-white align-items-center d-flex">
                            В исполнении
                        </p>
                    </div>
                    <p @click="openDeal(dealId)"
                       class="sb-application-status__id w-auto d-flex align-items-center pr-lg-5 pr-3 num-deal">
                        сделка № {{ dealId }}
                    </p>
                </div>
            </div>
            <div class="sb-status-action d-flex" v-if="status === 2">
                <div class="notification-red border-rounded mr-lg-2 d-flex align-items-center mb-2 mb-lg-0">
                    <img class="pr-2" src="/icons/direct/information.svg" alt="info">
                    <span>{{ user.role === 2 ? 'Отклонена Вами' : null }}</span>
                    <span>{{ user.role === 3 ? 'Отклонена (Заказчиком)' : null }}</span>
                </div>
            </div>
            <div class="sb-status-action d-flex" v-if="status === 3">
                <div class="notification-red border-rounded mr-lg-2 d-flex justify-content-center
                                align-items-center pl-3 pr-3">
                    <img class="pr-2" src="/icons/direct/information.svg" alt="info">
                    <span>{{ user.role === 3 ? 'Отклонена Вами' : null }}</span>
                    <span>{{ user.role === 2 ? 'Отклонена (Исполнителем)' : null }}</span>
                    <!--Исполнитель отклонил заявку {{ item.cancelDate }}!-->
                </div>
            </div>

            <div class="sb-status-action d-flex" v-if="status === 4 || status === 5">
                <div class="blockDeal d-flex mb-2 mr-lg-2 cursor-pointer"
                     style="border: 1px solid #52AF67; border-radius: 10px"
                     @click="$emit('showDeal')">
                    <div class="notification-green d-flex mr-2 w-auto" v-if="dealData.complete === 1">
                        <img class="pr-2" src="/icons/direct/information.svg" alt="info">
                        <p class="sb-application-status text-white align-items-center d-flex textl">
                            Успешно завершена
                        </p>
                    </div>
                    <div class="notification-red d-flex mr-2 w-auto" v-if="dealData.complete === 2">
                        <img class="pr-2" src="/icons/direct/information.svg" alt="info">
                        <p class="sb-application-status text-white align-items-center d-flex textl">
                            Завершена с арбитражем
                        </p>
                    </div>
                    <p class="sb-application-status__id w-auto d-flex align-items-center pr-lg-5 pr-3 num-deal text-truncate">
                        сделка № {{ dealId }}
                    </p>
                </div>
            </div>

            <div v-if="isShowArrow && user.role === 3" data-toggle="collapse" :data-target="'#response-' + directId"
                 class="pr-3 pl-3 arrow-button justify-content-center shadow align-items-center d-lg-flex d-none cursor-pointer">
                <img width="30px" src="/icons/downArrowRed.svg" alt="">
            </div>

            <div class="d-flex justify-content-between"
                 v-if="(isSendMessages && user.role === 2) || (isDeleteResponse && user.role === 2)">
                <button v-if="isSendMessages && user.role === 2" type="button"
                        @click="showSendMessageCustomer(executor_info.user_id)"
                        class="sb-button-blue button-icon emailSvg blue mr-2" title="Отправить сообщение">
                    <svg id="email" xmlns="http://www.w3.org/2000/svg" width="20.76"
                         height="15.206" viewBox="0 0 20.76 15.206">
                        <path style="fill: #6283E5" id="Контур_44478" data-name="Контур 44478"
                              d="M18.136,24.61H2.624A2.627,2.627,0,0,0,0,27.234v9.959a2.627,2.627,0,0,0,2.624,2.624H18.136a2.627,2.627,0,0,0,2.624-2.624V27.234A2.627,2.627,0,0,0,18.136,24.61Zm-.41,1.692L10.38,31.977,3.033,26.3Zm.41,11.822H2.624a.932.932,0,0,1-.931-.931V27.4l8.17,6.311a.846.846,0,0,0,1.035,0l8.17-6.311v9.788A.932.932,0,0,1,18.136,38.124Z"
                              transform="translate(0 -24.61)" fill="#fff"/>
                    </svg>
                    <!--<div class="notification-block">
                        12
                    </div>!-->
                </button>
                <button v-if="isDeleteResponse && user.role === 2 && status === 0" type="button"
                        title="Редактировать заявку" data-toggle="modal" data-target="#sb-response-modal"
                        class="sb-button-blue button-icon emailSvg blue mr-2">
                    <img src="/icons/sportObjects/edit.svg" alt="edit">
                </button>
                <button v-if="isDeleteResponse && user.role === 2 && status === 0" type="button"
                        @click="$emit('deleteDirect')" title="Удалить заявку"
                        data-toggle="modal" data-target="#sb-notification-delete"
                        class="active btn-delete button button-icon d-flex justify-content-center">
                    <span>Удалить заявку</span>
                    <img src="/icons/direct/trash.svg" alt="">
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SbDirectStatus",
    props: {
        isSendMessages: {
            type: Boolean,
            default: true
        },
        isDeleteResponse: {
            type: Boolean,
            default: true
        },
        isShowArrow: {
            type: Boolean,
            default: true
        },
        status: {
            type: Number,
            default: 0,
            required: true
        },
        directId: {
            type: Number,
            default: null,
            required: true
        },
        dealId: {
            type: Number,
            default: null
        },
        customer_info: {
            type: Object,
            default: null
        },
        executor_info: {
            type: Object,
            default: null
        },
        dealData: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            showIndex: null
        }
    },
    computed: {
        user() {
            return window.user;
        }
    },
    methods: {
        showIndexHandler() {
            this.showIndex == null ? this.showIndex = this.directId : this.showIndex = null;
            this.$emit('setShowIndex', this.showIndex);
        },
        showSendMessageCustomer(user_id) {
            window.location.href = `/messages#${user_id}`;
        },
        openDeal(dealId) {
            window.location.href = `/transaction/deal/${dealId}`;
        }
    }
}
</script>

<style scoped>
.notification-red, .notification-green, .notification-blue, .notification-orange{
    width: auto;
}
</style>
