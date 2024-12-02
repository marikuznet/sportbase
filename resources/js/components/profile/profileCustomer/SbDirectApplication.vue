<template>
    <div class="sb-direct-application ctnPad">
        <modal-notification id="sb-notification-delete" ref="sb-notification-delete" v-if="deleteDirectId"
                            modal_class="sb-notification-delete" title="Удалить заявку"
                            content="Вы действительно хотите удалить заявку?"
                            @left_action="archiveRentalRequest(deleteDirectId)"
                            @right_action="closeModalDelete()"
                            left_button="ДА" right_button="НЕТ"/>

        <div class="sb-items_objects mb-4" v-for="item in items" :key="item.id">
            <div class="container request-object customer">
                <div class="request-object__title">
                    <div class="titleObject pb-2 justify-content-between d-flex">
                        <p class="application-caption text-uppercase">{{ item.sportObject.title }}
                            <span class="pl-3 text-nowrap text-muted text-lowercase objectId">
                                id {{ item.sportObject.id }}
                            </span>
                        </p>
                        <div data-toggle="collapse" :data-target="'#response-' + item.id"
                             class="pr-3 pl-3 arrow-button justify-content-center shadow align-items-center d-lg-flex d-none cursor-pointer">
                            <img width="30px" src="/icons/downArrowRed.svg" alt="">
                        </div>
                    </div>
                    <div class="info-request-object d-flex flex-wrap">
                        <div class="d-flex flex-lg-nowrap flex-wrap pb-3">
                            <div class="create mr-lg-4 mr-1">
                                <div class="title d-flex pb-2">
                                    <img src="/icons/direct/XMLID_14_.svg" alt="">
                                    <p class="pl-3 caption">Создана</p>
                                </div>
                                <div class="field-green">
                                    <p class="text-nowrap d-flex">{{ item.createDate_month }}
                                        <span class="d-none d-lg-flex pl-1 pr-1">{{ item.createDate_year }} </span>
                                        в {{ item.createDate_time }}</p>
                                </div>
                            </div>
                            <div class="create mr-lg-4 mr-1">
                                <div class="title d-flex pb-2">
                                    <img src="/icons/direct/XMLID_14_.svg" alt="">
                                    <p class="pl-3 caption">Пребывание</p>
                                </div>
                                <div class="field-green d-none d-lg-flex">
                                    <p class="text-nowrap">{{ item.startDate_day }} -
                                        {{ item.endDate }}
                                        {{ item.endDate_year }} {{ item.spreadDate }}</p>
                                </div>
                                <div class="living d-flex align-items-center">
                                    <div class="field-green d-flex d-lg-none">
                                        <p class="text-nowrap">{{ item.startDate_day }} -
                                            {{ item.endDate }}
                                            {{ item.endDate_year }}</p>
                                    </div>
                                    <p class="text-nowrap d-flex d-lg-none">{{ item.spreadDate }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex pb-3">
                            <div class="create mr-lg-4 mr-1">
                                <div class="title d-flex pb-2">
                                    <p class=" caption">Человек</p>
                                </div>
                                <div class="field justify-content-center">
                                    <p class="text-nowrap">{{ item.colPeople }}</p>
                                </div>
                            </div>
                            <div class="create mr-lg-4 mr-1">
                                <div class="title d-flex pb-2">
                                    <p class="caption">Стоимость</p>
                                </div>
                                <div class="price d-flex align-items-center">
                                    <div class="field-blue mr-2">
                                        <p class="text-nowrap">{{ item.minPrice }} руб.</p>
                                    </div>
                                    <p class="text-nowrap">за сутки</p>
                                </div>
                            </div>
                        </div>
                        <div class="rating-messages d-flex justify-content-between">
                            <div class="d-flex justify-content-between w-100">
                                <div class="rating-feedbacks d-flex">
                                    <div class="rating align-items-center col-auto d-flex">
                                        <div class="d-flex">
                                            <star-rating :increment="0.5" :starSize="16" :activeColor="'#F5AE67'"
                                                         :showRating="false" :rating="item.sportObject.average_rating"
                                                         :read-only="true"/>
                                            <div>
                                                <p>{{ item.sportObject.average_rating | formatRating }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="align-items-center col-auto d-flex">
                                        <div class="d-flex">
                                            <img class="pr-1" src="/icons/direct/chat.svg" alt="">
                                            <div class="d-flex align-items-center">
                                                <p>{{ item.sportObject.reviews_count }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div data-toggle="collapse" :data-target="'#response-' + item.id"
                                     class="pr-3 pl-3 arrow-button justify-content-center shadow align-items-center d-flex d-lg-none cursor-pointer">
                                    <img width="30px" src="/icons/downArrowRed.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sb-bg-grey border-bottom-rounded-10">
                    <div class="collapse info-full-request-object container border-top-solid pt-4 pb-4"
                         :id="'response-' + item.id">
                        <div class="shadow modal-info-object-request">
                            <div class="title-info flex-wrap pl-lg-4 pr-lg-2 pt-2 pb-2">
                                <sb-response-modal :id-sport-object="Number(item.id)" :model-request="item"/>

                                <sb-direct-status :direct-id="item.id" :deal-id="item.deal_id"
                                                  :is-send-messages="item.archive !== 1" :deal-data="item.dealData"
                                                  :is-delete-response="item.archive !== 1"
                                                  :executor_info="item.executor_info"
                                                  :status="item.archive" @deleteDirect="setIndexDelete(item.id)"/>
                            </div>
                            <div class="executor-body border-top-solid">
                                <div class="row w-100">
                                    <div class="col-12 col-sm-12 col-md-6 pt-2">
                                        <!-- вид спорта -->
                                        <div class="container">
                                            <div class="d-flex">
                                                <div class="col-md-12 p-0">
                                                    <div class="pt-2">
                                                        <p class="captionText_l">Виды спорта</p>
                                                    </div>
                                                    <div class="d-flex flex-wrap">
                                                        <div class="buta pl-2 pr-2 p-2"
                                                             v-for="sport in item.type_sports">
                                                            <p>{{ sport.title }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- регион -->
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="butt pr-2">
                                                            <p class="captionText_l">Регион</p>
                                                        </div>
                                                        <div class="butt">
                                                            <img alt="world" src="/icons/direct/world.svg">
                                                        </div>
                                                        <div class="butt">
                                                            <p class="country">Россия</p>
                                                        </div>
                                                        <div class="butn p-2 text-white">
                                                            <p class="text-white">{{ item.sportObject.city }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- тип питания -->
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="pt-2">
                                                        <p class="captionText_l">Тип питания</p>
                                                    </div>
                                                    <div class="d-flex flex-wrap">
                                                        <div class="buta pl-2 pr-2 p-2" v-for="food in item.typeFoods">
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
                                                            <p>{{ item.colPeople }} человек</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Стоимость за человека -->
                                        <div class="container pb-lg-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row pl-1 pt-2">
                                                        <p class="captionText_l">Стоимость (за человека)</p>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div
                                                            class="align-items-center butn d-flex p-2 pl-2 pr-2 text-nowrap">
                                                            <p class="text-white">{{ item.minPrice }} руб.</p>
                                                        </div>
                                                        <div class="butt pl-2 pr-2 text-nowrap">
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
                                                        <div class="buta pl-2 pr-2 p-2"
                                                             v-for="infr in item.infrastructures">
                                                            <p>{{ infr.title }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Дата пребывания -->
                                        <div class="container ">
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
                                                            <p>{{ item.startDate }}</p>
                                                        </div>
                                                        <div class="butt">
                                                            <p>по</p>
                                                        </div>
                                                        <div class="butg pl-2 pr-2">
                                                            <p>{{ item.endDate }}</p>
                                                        </div>
                                                        <div class="butt d-none d-lg-flex">
                                                            <p>{{ item.endDate_year }}</p>
                                                        </div>
                                                        <div class="buta mt-2 pl-2 pr-2 d-flex align-items-center">
                                                            <p>{{ item.spreadDate }}</p>
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
                                                        <div class="buta pl-2 pr-2 p-2"
                                                             v-for="addition in item.additions">
                                                            <p>{{ addition.title }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="executor-footer" :id="'response-'+item.id">
                                <div class="p-4">
                                    <p class="captionText_l">Сообщение</p>
                                    <p class="message-text">{{ item.comment }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ModalNotification from "../../elements/Modal";
import StarRating from 'vue-star-rating';
import SbDirectStatus from "../SbDirectStatus";
import RatingMessages from "../../elements/RatingMessages";
import SbResponseModal from "../../elements/SbResponseModal";

export default {
    name: "SbDirectApplication",
    components: {SbResponseModal, RatingMessages, ModalNotification, StarRating, SbDirectStatus},
    props: {
        items: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            deleteDirectId: null,
        }
    },
    methods: {
        closeModalDelete() {
            $('#sb-notification-delete').modal('toggle');
        },
        archiveRentalRequest(responseId) {
            this.$store.dispatch('addToDirectArchive', {
                'id': responseId,
                'user_role': user.role,
            });
            this.$emit('updateData');
            this.closeModalDelete();
        },
        setIndexDelete(idx) {
            this.deleteDirectId = idx
        }
    }
}
</script>

<style scoped>

</style>
