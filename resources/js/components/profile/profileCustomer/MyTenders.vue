<template>
    <div>
        <modal-notification :id="'sb-notification-delete-'+indexDelete" :ref="'sb-notification-delete-'+indexDelete"
                            v-if="indexDelete"
                            modal_class="sb-notification-delete"
                            title="Отклонить отклик"
                            content="Вы действительно хотите отклонить отклик?"
                            @left_action="deleteResponse(indexDelete)"
                            @right_action="closeModalDelete(indexDelete)"
                            left_button="ДА" right_button="НЕТ"/>

        <modal-notification :id="'sb-delete-tender-'+tenderId"
                            :ref="'sb-delete-tender-'+tenderId"
                            modal_class="sb-delete-tender"
                            title="Удалить тендер"
                            content="Вы действительно хотите удалить тендер?"
                            @left_action="addToArchiveTenders"
                            @right_action="closeModalDeleteTender"
                            left_button="ДА" right_button="НЕТ"/>

        <modal-notification :id="'sb-delete-all-responses'"
                            :ref="'sb-delete-all-responses'"
                            :modal_class="'sb-delete-all-responses'"
                            title="Отклонить все отклики"
                            content="Вы действительно хотите отклонить все отклики?"
                            @left_action="cancelAllResponses"
                            @right_action="closeModalCancelResponses"
                            left_button="ДА" right_button="НЕТ"/>

        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="tenders_loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <menu-component :active="2"></menu-component>
        <main class="proposal-card tendersRequest" style="min-height: 600px">
            <div class="container ctnPad pl-0">
                <div class="pt-3">
                    <h3 class="caption">Мои тендеры</h3>
                </div>
            </div>
            <filters @updateData="getTenders" @handleUpdate="getTenders" @update-filter="filter = $event"
                     :filter-btn="filterBtn"/>
            <div>
                <modal-notification id="sb-not-payment" ref="sb-not-payment" modal_class="sb-not-payment"
                                    content="Для участия в сделке укажите платежные данные (реквизиты) компании в аккаунте на странице Платежные реквизиты"
                                    @left_action="closeModal" @right_action="fillPayment" left_button="Отмена"
                                    right_button="Заполнить реквизиты"/>
                <div class="tenders-item" style="min-height: 50vh">
                    <tender-modal :key="dataTenderEdit.id" v-if="isShowEditTender && dataTenderEdit"
                                  :header-id="'tender-request-header'" :body-id="'tender-request-body'"
                                  :send-request="isSend" @changeSendRequest="isSend = false" :modal="isShowEditTender"
                                  @closeModal="isShowEditTender = false" :edit-response="dataTenderEdit">

                        <template #header="{ tender }">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="title-block">
                                    <p class="title-block__caption">Редактировать тендерную заявку № {{ tender.id }}</p>
                                </div>
                                <div class="blockImg">
                                    <img @click="isShowEditTender = false" style="cursor:pointer"
                                         src="/icons/stages/cancel.svg" alt="">
                                </div>
                            </div>
                        </template>

                        <template #footer>
                            <div class="buttonSend mt-5 d-lg-block d-none">
                                <button type="button" style="width: 250px; min-height: 60px" @click="isSend = true"
                                        class="top__button button button-fill d-block mx-auto my-0 my-lg-3 mb-2 p-lg-4 p-3 d-flex justify-content-around">
                                    <p class="fw-bold text-white">Сохранить</p>
                                    <img src="/icons/tenders/list.svg" alt="">
                                </button>
                            </div>

                            <div class="d-block d-lg-none mr-5 ml-5 mt-n4 pb-4">
                                <button style="width: 250px" type="button" class="w-100 top__button button button-fill d-block mx-auto my-0 my-lg-3 mb-2 p-lg-4 p-3
                             d-flex justify-content-around" @click="isSend = true">
                                    <p class="fw-bold text-white">Сохранить</p>
                                    <img src="/icons/tenders/list.svg" alt="">
                                </button>
                            </div>
                        </template>
                    </tender-modal>

                    <div v-if="tenders" class="container-request tender mb-4" v-for="tender in tenders">
                        <div class="container request-object p-0">
                            <div class="request-object__title">
                                <div class="titleObject pb-2 justify-content-between d-flex">
                                    <p class="captionObject titleObject__main text-uppercase">
                                        Тендер №{{ tender.id }}
                                    </p>
                                    <div class="d-flex">
                                        <div v-if="isArchive == 'active'" class="border-green mr-2 d-none d-lg-flex justify-content-center
                                                    align-items-center">
                                            <span class="pl-2 pr-2">Отклики от исполнителей
                                                <span class="ml-2 pl-3 pr-3 pt-2 pb-2 countResponse">
                                                    {{ tender.allResponses_count }}
                                                </span>
                                                <span class="pl-3 pr-3 pt-2 pb-2" style="color: #E45868">{{
                                                        tender.responses.filter(response => response.archive == 2
                                                            || response.archive == 3).length
                                                    }}
                                                </span>
                                            </span>
                                        </div>
                                        <template v-else>
                                            <deal-status-section :data="tender"
                                                                 v-if="tender.archive === 1"/>
                                            <div v-if="[2, 3].includes(tender.archive)"
                                                 class="border-rounded d-flex mr-2 w-auto min-vw-0"
                                                 :class="{'notification-red': tender.archive === 2 || tender.archive === 3, 'notification-green': tender.archive === 1}">
                                                <img alt="info" class="pr-2"
                                                     src="/icons/direct/information.svg">
                                                <p class="align-items-center d-flex me-3 text-nowrap text-white">
                                                    {{ tender.archive === 2 ? 'Отклонена Вами' : '' }}
                                                    {{ tender.archive === 3 ? 'Отклонена Исполнителем' : '' }}
                                                </p>
                                            </div>
                                            <!--!getStatusArchiveTender(tender.fullStartDate)!-->
                                            <div v-if="false"
                                                 class="border-rounded d-flex mr-2 notification-red w-auto">
                                                <img alt="info" class="pr-2"
                                                     src="/icons/direct/information.svg">
                                                <p class="text-white align-items-center d-flex">
                                                    Просрочена
                                                </p>
                                            </div>
                                        </template>
                                        <div data-toggle="collapse" :data-target="'#response-' + tender.id"
                                             aria-expanded="false"
                                             class="pr-3 pl-3 arrow-button justify-content-center shadow
                                             align-items-center d-lg-flex d-none cursor-pointer">
                                            <img width="30px" src="/icons/downArrowRed.svg" alt="">
                                        </div>
                                    </div>
                                </div>

                                <request-title-tender :prop_tender="tender" :showRating="false"/>
                                <div class="d-flex mt-3">
                                    <div class="border-green mr-2 d-flex d-lg-none justify-content-center
                                                    align-items-center">
                                            <span class="pl-2 pr-2">Отклики от исполнителей
                                                <span class="ml-2 pl-3 pr-3 pt-2 pb-2 countResponse">
                                                    {{ tender.allResponses_count }}
                                                </span>
                                                <span class="pl-3 pr-3 pt-2 pb-2" style="color: #E45868">{{
                                                        tender.responses.filter(response => response.archive == 2
                                                            || response.archive == 3).length
                                                    }}
                                                </span>
                                            </span>
                                    </div>
                                    <div data-toggle="collapse" :data-target="'#response-' + tender.id"
                                         aria-expanded="false" class="pr-3 pl-3 arrow-button justify-content-center
                                         shadow align-items-center d-lg-none d-flex cursor-pointer">
                                        <img width="12px" src="/icons/downArrowRed.svg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="request-object__body">
                                <div :id="'response-' + tender.id"
                                     class="collapse info-full-request-object container pt-4 pb-4 p-0 border-top-solid border-bottom-solid">
                                    <div class="my-tender-request">
                                        <div class="shadow modal-info-object-request tender mb-3">
                                            <div class="title-info d-flex flex-wrap pl-4 pr-2 pt-2 pb-2
                                                        justify-content-between" style="height: 65px">
                                                <div class="logo d-flex align-items-center">
                                                    <p class="ispr">Ваша заявка</p>
                                                </div>
                                                <template
                                                    v-if="[0].includes(tender.archive) && getStatusArchiveTender(tender.fullStartDate) && tenders_data.status == 'active'">
                                                    <div class="d-flex">
                                                        <button type="button" data-toggle="modal"
                                                                @click="tenderId = tender.id"
                                                                :data-target="'#sb-delete-tender-'+tenderId"
                                                                class="button button-icon active btn-delete tender d-flex justify-content-between align-items-stretch">
                                                            <span>Удалить заявку</span>
                                                            <img alt="trash" class="pl-3"
                                                                 src="/icons/direct/trash.svg">
                                                        </button>
                                                        <button type="button"
                                                                @click="isShowEditTender = true; dataTenderEdit = tender"
                                                                class="button btn-action__add btnAction d-flex align-items-center justify-content-center">
                                                            <img src="/icons/sportObjects/edit.svg" alt="">
                                                        </button>
                                                    </div>
                                                </template>

                                            </div>
                                            <request :prop_request="tender"></request>
                                        </div>
                                    </div>
                                    <div class="request-object__responses sb-bg-grey pt-3 border-top-solid">
                                        <div class="responseExecutors">
                                            <div class="d-flex justify-content-between flex-wrap">
                                                <div class="d-flex d-lg-none">
                                                    <h5 class="mb-2">
                                                        ОТКЛИКИ ИСПОЛНИТЕЛЕЙ</h5>
                                                </div>
                                                <div class="d-flex reject-responses mb-2">
                                                    <h5 class="w-100 align-items-center d-none d-lg-flex text-nowrap mr-3">
                                                        Отклики исполнителей
                                                    </h5>
                                                    <button type="button" :class="{ 'active': isShowAllResponses }"
                                                            @click="switchAllResponses"
                                                            class="allResponses sb-button-blue mr-2 justify-content-center">
                                                        <p>Все</p>
                                                        <p class="countActive">
                                                            {{ tender.responses.length }}
                                                        </p>
                                                    </button>
                                                    <button type="button"
                                                            :class="{ 'sb-button-red': isShowCancelResponses, 'button-border': isShowAllResponses }"
                                                            @click="switchCancelResponses"
                                                            class="cancelResponses button mr-2 justify-content-center w-100">
                                                        <span>Отклоненные</span>
                                                        <span class="countCancelResponses ml-2">{{
                                                                tender.responses.filter(response => response.archive == 2
                                                                    || response.archive == 3).length
                                                            }}
                                                        </span>
                                                    </button>
                                                </div>
                                                <template
                                                    v-if="[0,1].includes(tender.archive) && tenders_data.status == 'active'">
                                                    <div v-if="tender.responses.length > tender.responses.filter(response => response.archive == 2
                                                                    || response.archive == 3).length && getStatusArchiveTender(tender.fullStartDate)"
                                                         class="d-flex block__cancel-all-responses">
                                                        <button type="button" @click="tenderId = tender.id"
                                                                :data-target="'#sb-delete-all-responses'"
                                                                data-toggle="modal"
                                                                :data-modal="'sb-delete-all-responses'"
                                                                class="w-100 button button-icon active btn-delete tender d-flex justify-content-center align-items-stretch">
                                                            <span style="color: #E45868">Отклонить все отклики</span>
                                                            <img class="pl-3" alt="trash" src="/icons/direct/trash.svg">
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="responseExecutors showAll mb-lg-5" v-for="response in (!isShowCancelResponses ?
                            tender.responses : (tender.responses.filter(r => r.archive == 2 || r.archive == 3)))">
                                            <template>
                                                <div class="shadow executor-response">
                                                    <div
                                                        class="title-info d-flex flex-wrap pl-4 pr-4 pt-2 pb-2 justify-content-between">
                                                        <div class="logo d-lg-flex d-none align-items-center">
                                                            <h5>Исполнитель <span class="d-flex d-lg-none">(Вы)</span>
                                                            </h5>
                                                            <div class="block__circle mr-2 ml-2">
                                                                <img alt="logo"
                                                                     :src="'/storage/listings/logos/' + response.company_info.user_id + '/' + response.company_info.image">
                                                            </div>
                                                            <h5>{{ response.company_info.title }}</h5>
                                                        </div>
                                                        <div class="logo pt-3 d-lg-none align-items-center flex-wrap">
                                                            <h5>Исполнитель</h5>
                                                            <div class="d-flex">
                                                                <div class="block__circle mr-2 ml-2">
                                                                    <img alt="logo"
                                                                         :src="'/storage/listings/logos/' + response.company_info.user_id + '/' + response.company_info.image">
                                                                </div>
                                                                <h5 class="d-flex align-items-center">
                                                                    {{ response.company_info.title }}</h5>
                                                            </div>
                                                        </div>
                                                        <deal-status-section :data="response"
                                                                             v-if="response.archive === 1"/>
                                                        <div v-if="[2, 3].includes(response.archive)"
                                                             class="border-rounded d-flex w-auto min-vw-0"
                                                             :class="{'notification-red': response.archive === 2 || response.archive === 3, 'notification-green': response.archive === 1}">
                                                            <img alt="info" class="pr-2"
                                                                 src="/icons/direct/information.svg">
                                                            <p class="text-white text-nowrap align-items-center d-flex">
                                                                {{ response.archive === 2 ? 'Отклонена Вами' : '' }}
                                                                {{
                                                                    response.archive === 3 ? 'Отклонена Исполнителем' : ''
                                                                }}
                                                            </p>
                                                        </div>
                                                        <div v-if="response.archive === 0" class="right d-flex">
                                                            <div class="btn-create-deal gap-2 d-lg-flex d-none"
                                                                 v-if="!tender.deal || (tender.dealData.rejectionsDeal != null)">
                                                                <button v-if="!hasUserPayment" type="button"
                                                                        :data-target="'#sb-not-payment'"
                                                                        data-toggle="modal" data-modal="sb-not-payment"
                                                                        class="button button-icon dealSvg gap-2 mr-2 w-100 justify-content-center">
                                                                    Принять условия
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         width="23.63"
                                                                         height="20.837" viewBox="0 0 23.63 20.837">
                                                                        <path id="deal_1_" data-name="deal (1)"
                                                                              d="M23.63,9.405,14.725.5,11.854,3.371,8.9.507,0,9.41l3.587,3.514A2.374,2.374,0,0,0,5.595,16.57h0s0,.005,0,.008a2.379,2.379,0,0,0,2.376,2.376h.007s0,0,0,.007a2.375,2.375,0,0,0,3.8,1.9,2.408,2.408,0,0,0,3.839-1.957,2.409,2.409,0,0,0,2.429-2.435h.1a2.409,2.409,0,0,0,2.012-3.592ZM16.375,13.89,15.43,14.9l.942.88,0,0a1.026,1.026,0,0,1-1.429,1.47l-.01-.01,0,0L14,16.307l-.985.971.989,1A1.026,1.026,0,0,1,12.6,19.752a2.375,2.375,0,0,0-2.24-3.168h-.007s0,0,0-.007A2.379,2.379,0,0,0,7.975,14.2h0s0-.005,0-.008A2.375,2.375,0,0,0,4.64,12.019L1.967,9.4,8.918,2.449l1.958,1.9L7.662,7.563a2.409,2.409,0,0,0,3.407,3.407L13.75,8.288l4.96,4.958c.037.047.075.092.113.135a1.032,1.032,0,0,1-.015,1.382,1.026,1.026,0,0,1-1.394.1Zm-7.01,5.07a.993.993,0,1,1,.993.993A.994.994,0,0,1,9.365,18.961ZM6.982,16.578a.993.993,0,1,1,.993.993A.994.994,0,0,1,6.982,16.578ZM4.6,14.194a.993.993,0,1,1,.993.993.994.994,0,0,1-.993-.993ZM19.25,11.829l-5.5-5.5L10.091,9.992A1.026,1.026,0,1,1,8.64,8.541l6.085-6.085,6.949,6.949Zm0,0"
                                                                              transform="translate(0 -0.5)"
                                                                              fill="#fff"/>
                                                                    </svg>
                                                                </button>
                                                                <button v-else type="button"
                                                                        @click="createDeal(tender.id, response.id)"
                                                                        class="button button-icon dealSvg mr-2 gap-2 w-100 justify-content-center">
                                                                    Принять условия
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         width="23.63"
                                                                         height="20.837" viewBox="0 0 23.63 20.837">
                                                                        <path id="deal_1_" data-name="deal (1)"
                                                                              d="M23.63,9.405,14.725.5,11.854,3.371,8.9.507,0,9.41l3.587,3.514A2.374,2.374,0,0,0,5.595,16.57h0s0,.005,0,.008a2.379,2.379,0,0,0,2.376,2.376h.007s0,0,0,.007a2.375,2.375,0,0,0,3.8,1.9,2.408,2.408,0,0,0,3.839-1.957,2.409,2.409,0,0,0,2.429-2.435h.1a2.409,2.409,0,0,0,2.012-3.592ZM16.375,13.89,15.43,14.9l.942.88,0,0a1.026,1.026,0,0,1-1.429,1.47l-.01-.01,0,0L14,16.307l-.985.971.989,1A1.026,1.026,0,0,1,12.6,19.752a2.375,2.375,0,0,0-2.24-3.168h-.007s0,0,0-.007A2.379,2.379,0,0,0,7.975,14.2h0s0-.005,0-.008A2.375,2.375,0,0,0,4.64,12.019L1.967,9.4,8.918,2.449l1.958,1.9L7.662,7.563a2.409,2.409,0,0,0,3.407,3.407L13.75,8.288l4.96,4.958c.037.047.075.092.113.135a1.032,1.032,0,0,1-.015,1.382,1.026,1.026,0,0,1-1.394.1Zm-7.01,5.07a.993.993,0,1,1,.993.993A.994.994,0,0,1,9.365,18.961ZM6.982,16.578a.993.993,0,1,1,.993.993A.994.994,0,0,1,6.982,16.578ZM4.6,14.194a.993.993,0,1,1,.993.993.994.994,0,0,1-.993-.993ZM19.25,11.829l-5.5-5.5L10.091,9.992A1.026,1.026,0,1,1,8.64,8.541l6.085-6.085,6.949,6.949Zm0,0"
                                                                              transform="translate(0 -0.5)"
                                                                              fill="#fff"/>
                                                                    </svg>
                                                                </button>
                                                                <button type="button" data-toggle="modal"
                                                                        :data-target="'#sb-notification-delete-'+ response.id"
                                                                        @click="indexDelete = response.id"
                                                                        class="button button-icon active btn-delete d-flex justify-content-center align-items-stretch">
                                                                    <span style="color: #E45868">Отклонить</span>
                                                                    <img alt="trash" src="/icons/direct/trash.svg">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="container request-object p-4"
                                                         v-if="response.sportObject">
                                                        <div class="titleObject pb-2 justify-content-between d-flex">
                                                            <p class="captionObject text-uppercase">{{
                                                                    response.sportObject.title
                                                                }}<span
                                                                    class="pl-3 text-nowrap text-muted text-lowercase objectId">id {{
                                                                        response.sportObject.id
                                                                    }}</span>
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="info-request-object d-flex flex-wrap justify-content-between">
                                                            <div class="d-flex pb-3">
                                                                <div class="create mr-4">
                                                                    <div class="title d-flex pb-2">
                                                                        <img src="/icons/direct/XMLID_14_.svg">
                                                                        <p class="pl-3 caption">Отклик</p>
                                                                    </div>
                                                                    <div class="field-green">
                                                                        <p class="text-nowrap d-flex">
                                                                            {{ response.createDate_month }}
                                                                            <span class="d-none d-lg-flex pl-1 pr-1">
                                                                {{ response.createDate_year }} </span>
                                                                            в {{ response.createDate_time }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="create address mr-4 d-none d-lg-block">
                                                                    <div class="title d-flex pb-2">
                                                                        <p class="caption">Адрес</p>
                                                                    </div>
                                                                    <div class="field-green d-flex">
                                                                        <p class="text-nowrap caption">
                                                                            {{ response.sportObject.country }},
                                                                            {{ response.sportObject.city }},
                                                                            {{ response.sportObject.address }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="create mr-4">
                                                                    <div class="title d-flex pb-2">
                                                                        <p class="caption">Стоимость</p>
                                                                    </div>
                                                                    <div class="price d-flex align-items-center">
                                                                        <div class="field-blue mr-2">
                                                                            <p class="text-nowrap">
                                                                                {{ response.priceForPerson }} руб.</p>
                                                                        </div>
                                                                        <p class="text-nowrap">за сутки</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="create mobile-address mr-4 d-lg-none">
                                                                <div class="title d-flex pb-2">
                                                                    <p class="caption">Адрес</p>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <p class="subtitle text-nowrap">
                                                                        {{ response.sportObject.country }},
                                                                        {{ response.sportObject.city }},
                                                                        {{ response.sportObject.address }}</p>
                                                                </div>
                                                            </div>
                                                            <hr class="d-flex d-lg-none" width="100%"
                                                                style="padding: 0 !important;">
                                                            <div v-if="false" class="rating-messages d-flex
                                                                justify-content-between">
                                                                <div class="d-flex">
                                                                    <div
                                                                        class="rating align-items-center col-auto d-flex">
                                                                        <div class="d-flex">
                                                                            <star-rating :increment="0.5" :starSize="16"
                                                                                         :activeColor="'#F5AE67'"
                                                                                         :showRating="false"
                                                                                         :rating="response.sportObject.average_rating"
                                                                                         :read-only="true"/>
                                                                            <div>
                                                                                <p>
                                                                                    {{
                                                                                        response.sportObject.average_rating | formatRating
                                                                                    }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="align-items-center col-auto d-flex">
                                                                        <div class="d-flex">
                                                                            <img class="pr-1"
                                                                                 src="/icons/direct/chat.svg">
                                                                            <div class="d-flex align-items-center">
                                                                                <p>{{
                                                                                        response.sportObject.reviews_count
                                                                                    }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr class="d-flex d-lg-none" width="100%"
                                                                style="padding: 0 !important;">
                                                        </div>
                                                    </div>
                                                    <request :prop_request="response"></request>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <paginator :offset="tenders_data.perPage" :pagination="tenders_pagination" @changePages="changePages"
                           @changeColPages="changeColPages"/>
            </div>
        </main>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from '../../NavBar'
import extendedinf from "../../ExtendedFooterInformation";
import VSelect from "@alfsnd/vue-bootstrap-select";
import MenuComponent from "./menuComponent";
import {mapActions, mapGetters, mapMutations} from "vuex";
import Request from "../../Request";
import RequestTitleTender from "../../RequestTitleTender";
import Filters from "../../Filters";
import StarRating from 'vue-star-rating';
import Pagination from "../../Pagination";
import ModalNotification from "../../elements/Modal";
import axios from "axios";
import Paginator from "../../Paginator";
import DealStatusSection from "../../tenders/DealStatusSection";
import TenderModal from "../../tenders/TenderModal";
import * as moment from "moment";

export default {
    data: function () {
        return {
            isShowCancelResponses: false, isShowAllResponses: true,
            indexDelete: null, tenderId: null, hasUserPayment: false,
            tenders_data: {status: 'active', currentPage: 1, perPage: 10, pagination: {}},
            filter: {
                minPrice: null, maxPrice: null, start_date: null, end_date: null, objects: [], foods: [],
                services: [], infrastructures: [], accred: [], search: null
            },
            filterBtn: [{title: 'Активные', isActive: true, stats: 0, status: 'active'},
                {title: 'Архив', isActive: false, stats: 0, status: 'archive'}],
            isSend: false, isShowEditTender: false, dataTenderEdit: null,
            isArchive: 'active'
        }
    },
    methods: {
        ...mapActions(["addToTenderArchive", "deleteResponseTender", "storeDealTender"]),
        async getTenders(status = this.tenders_data.status, limit = this.tenders_data.perPage,
                         page = this.tenders_data.currentPage, filter = this.filter) {
            this.tenders_data.status = status;
            await this.$store.dispatch('fetchMyTenders', {
                status: status, limit: limit, page: page, filter: filter
            });
            this.isArchive = status;
        },
        async changePages(page) {
            this.tenders_data.currentPage = page;
            await this.getTenders();
        },
        async changeColPages(limit) {
            this.tenders_data.perPage = limit;
            await this.getTenders();
        },
        switchAllResponses() {
            this.isShowCancelResponses = false;
            this.isShowAllResponses = true
        },
        switchCancelResponses() {
            this.isShowCancelResponses = true;
            this.isShowAllResponses = false;
        },

        addToArchiveTenders() {
            this.addToTenderArchive({id: this.tenderId, user_role: user.role});
            window.location.href = '/tenders/my-tenders';
        },

        async deleteResponse(id_response) {
            this.deleteResponseTender({id: id_response, user_role: user.role}).then(res => {
                this.getTenders();
                this.closeModalDelete(id_response);
            });
        },
        async cancelAllResponses() {
            this.$store.dispatch('cancelAllResponses', {id: this.tenderId});
        },
        closeModalCancelResponses() {
            $('#sb-delete-all-responses').modal('toggle');
        },

        async createDeal(tender_id, responses_id,) {
            const data = {tender_id: tender_id, responsesTender_id: responses_id}
            const response = await this.$store.dispatch('storeDealTender', data)
            window.location.href = '/transaction/deal/' + response.deal_id;
        },
        closeModalDelete(id_response) {
            $('#sb-notification-delete-' + id_response).modal('toggle');
        },
        closeModalDeleteTender() {
            $('#sb-delete-tender-' + this.tenderId).modal('toggle');
        },
        async getHasPayment() {
            try {
                const response = await axios.get('/api/user/payment-details');
                this.hasUserPayment = response.data === 1;
            } catch (error) {
                console.error(error);
            }
        },
        closeModal() {
            $('#sb-not-payment').modal('hide');
        },
        fillPayment() {
            window.location.href = '/profile/payment';
        },
        getStatusArchiveTender(date) {
            return moment(date).isAfter(moment().format(), 'day');
        }
    },
    mounted() {
        this.getHasPayment();
        this.$store.dispatch('getFilters');
    },
    created() {
        Promise.all([
            this.getTenders(),
            this.$store.dispatch('getMyTendersStatistic').then(() => {
                this.filterBtn[0].stats = this.tenders_statistic.activeTendersCount;
                this.filterBtn[1].stats = this.tenders_statistic.archiveTendersCount;
            })
        ])
    },
    computed: {
        ...mapGetters({
            tenders: 'AllTenders',
            tenders_pagination: 'tenders_pagination',
            tenders_loading: 'tenders_loading',
            tenders_statistic: 'tenders_statistic',
        }),
        user: function () {
            return window.user;
        },
    },
    components: {
        TenderModal, moment,
        DealStatusSection, Paginator, Pagination, ModalNotification,
        Filters, RequestTitleTender, Request, MenuComponent, navbar, extendedinf, VSelect, StarRating
    },
}
</script>

<style>
.rotate-arrow {
    transform: rotate(180deg);
}

#overlay, #overlayResponse {
    z-index: 999;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.2);
}

.btn-yes {
    background-color: #6283E5;
    color: white;
    font-weight: bold;
}

.btn-no {
    color: #E45868;
    border: 2px solid #E45868;
    margin-left: 0.5rem;
}
</style>

<style scoped lang="scss">
.btn-action {
    &__add {
        border: 1px solid rgb(228, 88, 104);
        cursor: pointer;
        border-radius: 10px;
        width: 50px !important;
        margin-left: 10px;
    }
}

@media (min-width: 576px) {
    .modal-dialog {
        margin: 20rem auto !important;
    }
}

.caption {
    color: #0B3158;
}

.button {
    height: 45px;
    width: 150px;
    border-radius: 5px;
}

</style>
