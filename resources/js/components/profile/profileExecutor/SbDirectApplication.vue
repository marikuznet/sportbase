<template>
    <div class="sb-direct-applications">
        <modal-notification id="sb-notification-delete" ref="sb-notification-delete" v-if="delete_direct"
                            modal_class="sb-notification-delete"
                            title="Отклонить заявку"
                            :content="`Вы действительно хотите отклонить заявку на аренду объекта
                            '${delete_direct.sportObject.title}' (id: ${delete_direct.sportObject.id})?`"
                            @left_action="cancelRequest(delete_direct.id)"
                            @right_action="closeModalDelete()"
                            left_button="Отклонить" right_button="ОТМЕНА">
        </modal-notification>

        <div class="container container-request executor-objects p-0 mb-4" v-for="direct in items" :key="direct.id">
            <request-summary :direct="direct" @showDeal="showDeal" @createDeal="createDeal"
                             @cancelResponse="handleCancelResponse"/>
            <hr width="100" class="d-lg-none d-flex">

            <div class="d-flex d-lg-none justify-content-between">
                <div class="d-flex">
                    <div class="rating align-items-end col-auto d-flex">
                        <div class="d-flex">
                            <star-rating :increment="0.5" :starSize="16" :activeColor="'#F5AE67'" :showRating="false"
                                         :rating="direct.sportObject.average_rating" :read-only="true"></star-rating>
                            <div>
                                <p>{{ direct.sportObject.average_rating | formatRating }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="align-items-end col-auto d-flex">
                        <div class="d-flex">
                            <img class="pr-1" src="/icons/direct/chat.svg" alt="chat">
                            <div class="d-flex align-items-center">
                                <p>{{ direct.sportObject.reviews_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-toggle="collapse" :data-target="'#response-' + direct.id"
                     class="pr-3 pl-3 arrow-button justify-content-center shadow align-items-center d-lg-flex d-none cursor-pointer">
                    <img width="30px" src="/icons/downArrowRed.svg" alt="">
                </div>
            </div>

            <hr width="100%" style="height: auto;">

            <div class="executor-title pt-0 pb-0 mb-3">
                <div class="title-info flex-wrap">
                    <sb-direct-status :is-send-messages="direct.archive === 0" :direct-id="direct.id"
                                      :deal-id="direct.deal_id" :status="direct.archive"
                                      @showDeal="showDeal(direct.deal_id)" :deal-data="direct.dealData || null"
                                      @createDeal="createDeal(direct.id)"
                                      @cancelResponse="delete_direct = direct" :customer_info="direct.customer_info"/>
                </div>
            </div>
            <div class="executor-body collapse border-top-solid" :id="'response-'+direct.id">
                <request-details :direct="direct"/>
            </div>
            <hr class="collapse" :id="'response-'+direct.id" width="100%" style="margin-bottom: 0; margin-top: 0">
            <div class="executor-footer collapse" :id="'response-'+direct.id">
                <div class="p-4">
                    <p class="captionText_l">Сообщение</p>
                    <p class="message-text">{{ direct.comment }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating';
import ModalNotification from "../../elements/Modal"
import SbDirectStatus from "../SbDirectStatus";
import RatingMessages from "../../elements/RatingMessages";
import RequestDetails from "../RequestDetails";
import RequestSummary from "../RequestSummary";

Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0");
});

export default {
    name: "SbDirectApplication",
    components: {RequestSummary, RequestDetails, RatingMessages, SbDirectStatus, StarRating, ModalNotification},
    props: {
        items: {
            type: Array,
            default: [],
        }
    },
    data() {
        return {
            delete_direct: null
        }
    },
    methods: {
        showDeal(id_deal) {
            window.location.href = "/transaction/deal/" + id_deal;
        },
        createDeal(direct_id) {
            this.$store.dispatch('storeDealDirect', {directApplication_id: direct_id}).then(result => {
                window.location.href = '/transaction/deal/' + result.deal_id;
            });
        },
        handleCancelResponse(direct) {
            this.delete_direct = direct;
        },
        cancelRequest(idDirect) {
            this.$store.dispatch('addToDirectArchive', {
                'id': idDirect,
                'user_role': user.role,
            });
            this.$emit('updateData');
            this.closeModalDelete();
        },
        closeModalDelete() {
            $('#sb-notification-delete').modal('toggle');
        },
    },
}
</script>

<style scoped>

</style>
