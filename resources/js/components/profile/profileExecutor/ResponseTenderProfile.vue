<template>
    <div class="shadow modal-info-object-request tender mb-3 ml-0 mr-0">
        <response-tender-modal v-if="false" :id="'sb-response-tender-' + response.id" :ref="'sb-response-tender-' + response.id"
                               :key="'edit-' + response.id" modal_class="sb-response-tender"
                               :response-tender="response" :edit_mode="true"
                               @getData="saveResponse(response.id)" @closeModal="closeModal(response.id)"/>

        <modal-notification :id="'sb-notification-delete-' + response.id" :key="'delete-' + response.id"
                            :ref="'sb-notification-delete-' + response.id"
                            modalClass="sb-notification-delete"
                            title="Форма согласия"
                            content="Вы действительно хотите отклонить отклик?"
                            @left_action="deleteResponse(response.id)"
                            @right_action="closeModalDelete(response.id)"
                            left_button ="ДА" right_button="НЕТ">
        </modal-notification>


        <div class="title-info d-flex flex-wrap pl-4 pr-4 pt-3 pb-3 justify-content-between">
            <div class="logo d-flex align-items-center">
                <p class="ispr">Ваш отклик</p>
            </div>
            <div class="d-flex g-2">
                <div :class="{'notification-red': [2, 3].includes(response.archive)}"
                     class="d-flex mr-2 w-auto min-vw-0">
                    <img v-if="![0, 1].includes(response.archive)" alt="info" class="pr-2"
                         src="/icons/direct/information.svg">
                    <deal-status-section :data="response" v-if="response.archive === 1"/>

                    <p class="text-white text-nowrap align-items-center d-flex">
                        {{ response.archive === 2 ? 'Отклонен Заказчиком' : '' }}
                        {{ response.archive === 3 ? 'Отклонен Вами' : '' }}
                    </p>
                    <button v-if="response.archive === 0 && getStatusArchiveResponseTender(response.fullStartDate)"
                            type="button" data-toggle="modal" :data-target="'#sb-notification-delete-'+response.id"
                            class="button button-icon active btn-delete tender d-flex justify-content-between">
                        <span>Удалить отклик</span>
                        <img class="pl-3" src="/icons/direct/trash.svg" alt="trash">
                    </button>
                </div>
                <button v-if="response.archive === 0 && getStatusArchiveResponseTender(response.fullStartDate)"
                        @click="setSelectedResponse(response)"
                        data-toggle="modal" :data-target="`#sb-response-tender-${response.id}`"
                        type="button" title="Редактировать отклик"
                        class="blue border-rounded button-icon emailSvg ml-2 sb-button-blue">
                    <img src="/icons/sportObjects/edit.svg" alt="edit">
                </button>
            </div>
        </div>
        <div class="container request-object p-4 border-0"
             v-if="response.sportObject">
            <div class="titleObject pb-2 justify-content-between d-flex">
                <p class="captionObject text-uppercase">
                    {{ response.sportObject.title }}
                    <span class="pl-3 text-nowrap text-muted text-lowercase objectId">
                        id {{ response.sportObject.id }}
                    </span>
                </p>
            </div>
            <div class="info-request-object d-flex flex-wrap justify-content-between">
                <div class="d-flex pb-3">
                    <div class="create mr-4">
                        <div class="title d-flex pb-2">
                            <img src="/icons/direct/XMLID_14_.svg" alt="">
                            <p class="pl-3 caption">Ваш отклик</p>
                        </div>
                        <div class="field-green">
                            <p class="text-nowrap d-flex">{{ response.createDate_month }}
                                <span class="d-none d-lg-flex pl-1 pr-1">{{ response.createDate_year }} </span>
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
                <hr class="d-flex d-lg-none" width="100%" style="padding: 0 !important;">
                <div class="rating-messages d-flex justify-content-between">
                    <div class="d-flex">
                        <div class="rating align-items-center col-auto d-flex">
                            <div class="d-flex">
                                <star-rating :increment="0.5" :starSize="16"
                                             :activeColor="'#F5AE67'"
                                             :showRating="false"
                                             :rating="response.sportObject.average_rating"
                                             :read-only="true"/>
                                <div>
                                    <p>
                                        {{ response.sportObject.average_rating | formatRating }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center col-auto d-flex">
                            <div class="d-flex">
                                <img class="pr-1" src="/icons/direct/chat.svg"
                                     alt="chat">
                                <div class="d-flex align-items-center">
                                    <p>
                                        {{ response.sportObject.reviews_count }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="d-flex d-lg-none" style="padding: 0 !important;">
            </div>
        </div>
        <Request :prop_request="response"></Request>
    </div>
</template>

<script>

import * as moment from "moment";
import DealStatusSection from "../../tenders/DealStatusSection";
import StarRating from "vue-star-rating";
import Request from "../../Request";
import {mapActions} from "vuex";
import ResponseTenderModal from "../../tenders/ResponseTenderModal";

export default {
    name: "ResponseTenderProfile",
    components: {ResponseTenderModal, DealStatusSection, StarRating, Request},
    props: ['response'],
    methods: {
        ...mapActions(["deleteResponseTender"]),
        deleteResponse(id_response) {
            this.deleteResponseTender({
                id: id_response,
                user_role: user.role,
            });
            window.location.reload();
        },
        closeModalDelete(index) {
            $('#sb-notification-delete-' + index).modal('toggle');
        },
        getStatusArchiveResponseTender(date) {
            return moment(date).isAfter(moment().format(), 'day');
        },
        setSelectedResponse(response) {
            this.$emit('setSelectedResponse', response)
        },
        saveResponse(id){
            this.$emit('refreshData');
            $(`#sb-response-tender-${id}`).modal('toggle');
        },
        closeModal(id) {
            $(`#sb-response-tender-${id}`).modal('toggle')
        },
    }
}
</script>

<style scoped>

</style>
