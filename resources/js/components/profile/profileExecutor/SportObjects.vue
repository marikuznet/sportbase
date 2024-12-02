<template>
    <div>
        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="sport_objects_loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <modal-notification :id="'sb-notification-delete-' + sportObject.id" modal_class="sb-notification-delete"
                            left_button="Удалить" right_button="ОТМЕНА" title="Удаление объекта"
                            :content="`Вы действительно хотите удалить объект '${sportObject.title}' (id: ${sportObject.id})?`"
                            @left_action="delSoftSportObject(sportObject.id)"
                            @right_action="closeModalDelete(sportObject.id)"/>
        <navbar></navbar>
        <menu-component active="0"></menu-component>
        <div class="main-sport-objects">
            <div class="container pb-4" style="min-height: 600px">
                <div class="row searchLine">
                    <div class="col-lg-4 p-0 d-flex align-items-center">
                        <p class="caption">Спортивные объекты <span
                            class="blueText ml-2">{{ statistic.mySportObjectsCount }}</span></p>
                    </div>
                    <div class="sb-search-add-object col-lg-8 p-0 d-flex align-items-baseline d-flex">
                        <div class="search-wrapper w-100 my-2 me-3 mb-xl-2">
                            <input class="input-search searchField" type="search" name="search-object"
                                   id="search-object" v-model="filter.search"
                                   placeholder="Поиск в каталоге объектов" autocomplete="off">
                            <img class="icon" src="/icons/search-icon.svg" alt="search-icon">
                        </div>

                        <a href="/sport-objects/create" class="mb-lg-3 button-blue button borderblock searchButton">
                            <span class="text-white">Добавить объект +</span>
                        </a>
                    </div>
                </div>
                <p v-if="statistic.mySportObjectsCount === 0" class="font-weight-bold text-Blue">
                    У вас еще нет ни одного спортивного объекта...
                </p>
                <div class="row sport-object shadow mb-4" v-for="(item, index) in sport_objects">
                    <modal :id="'sb-advertisement-order-'+item.id" :ref="'sb-advertisement-order-'+item.id"
                           modal_class="sb-advertisement-order"
                           title="Рекламируется" @right_action="" right_button="ЗАКРЫТЬ">
                        <template #body>
                            <div class="sb-statistic-object text-Blue">
                                <template v-for="(advertisement, index) in item.advertisements">
                                    <h5>{{ advertisement.rate.title }} <span
                                        class="text-muted">{{
                                            `(${advertisement.days} дн. / ${advertisement.amount} руб.)`
                                        }}</span>
                                    </h5>
                                    <p>Дата начала: {{ advertisement.dateStart }}</p>
                                    <p v-if="advertisement.paused">Приостановлена:
                                        {{
                                            advertisement.paused && item.verify == 1 ? `до (${advertisement.pause_until})` : ``
                                        }}
                                        {{
                                            advertisement.paused && item.verify == 0 ? `(объект на модерации)` : ``
                                        }}
                                    </p>
                                    <p v-if="!advertisement.paused">Дата завершения: {{
                                            advertisement.dateEnd
                                        }}</p>

                                    <label v-if="!advertisement.paused" class="caption w-100">Приостановить на
                                        (от 1 до 10 дней)
                                        <div class="d-flex">
                                            <input type="number" min="1" max="10" v-model="daysStop[index]"
                                                   class="input-profile-info mr-4"
                                                   :class="{'is-invalid': errors[index]}" value="1"
                                                   @input="validateDaysStop(index)">
                                            <button
                                                @click="stopAdvertisement(advertisement.id, index, daysStop[index])"
                                                class="btn btn-blue">Приостановить
                                            </button>
                                        </div>
                                    </label>
                                    <template v-if="false">
                                        <button @click="resumeAdvertisement(advertisement.id)"
                                                class="btn btn-blue">
                                            Продолжить продвижение
                                        </button>
                                    </template>
                                    <hr style="height: 1px">
                                </template>
                                <template v-if="false">
                                    <h2>Статистика рекламной кампании</h2>
                                    <p>Количество просмотров: $campaignStats->views</p>
                                    <p>Количество кликов: $campaignStats->clicks</p>
                                    <p>Количество конверсий: $campaignStats->conversions</p>
                                </template>
                            </div>
                        </template>
                        <template #footer>
                            <span></span>
                        </template>
                    </modal>
                    <modal-advertisement :id="`sb-advertisement-${item.id}`" :ref="`sb-advertisement-${item.id}`"
                                         modal_dialog_class="modal-lg"
                                         title="Запустить рекламу объекта" modal_class="sb-advertisement">
                        <template #body>
                            <h5>{{ item.title }} (id: {{ item.id }})</h5>
                            <div class="block-advertis d-flex mb-3 p-3"
                                 v-for="(advertisement, index) in advertisements"
                                 style="border: 1px solid black;">
                                <div class="block-img mr-md-3 mr-lg-3 position-relative"
                                     style="width: 150px; height: 150px">
                                    <div class="object-block__fast-forward-label position-absolute"
                                         v-if="index===0">
                                        <img src="/icons/sportObjects/fast-forward.svg" alt="fast">
                                    </div>
                                    <div class="object-block__vip-label position-absolute" v-if="index === 2">vip
                                    </div>
                                    <img :class="{'highlighting': index === 1}"
                                         :src="'/storage/listings/objects/' + item.id + '/' + item.image[0]"
                                         alt="" width="150px" height="150px">
                                </div>
                                <div class="sb-info-advertisement">
                                    <h5><b>{{ advertisement.title }}</b></h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <span>продолжительность</span>
                                            <div class="d-flex">
                                                <v-select class="selectpicker" :options="advertisement.price"
                                                          v-model="selectedAdvertisements[index].advertisement"
                                                          textProp="title" valueProp="id"
                                                          @input="inputAdvertisements($event, advertisement.id, index)"
                                                          labelTitle="Выберите продолжительность">
                                                </v-select>
                                                <button type="button" data-modal="sb-advertisement-2"
                                                        class="close ml-4" @click="resetSelectAdvertisement(index)">
                                                    <span aria-hidden="true">
                                                        <img src="/icons/cancel.svg" alt="close">
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template #footer>
                            <div class="d-flex justify-content-center">
                                <button class="w-100 btn btn-yes text-white" @click="payPromotion(item.id)">
                                    Оплатить продвижение
                                </button>
                            </div>
                        </template>
                    </modal-advertisement>
                    <modal-advertisement :id="`sb-history-advertisement-${item.id}`"
                                         :ref="`sb-history-advertisement-${item.id}`"
                                         modal_dialog_class="modal-lg"
                                         title="История завершенных рекламных компаний"
                                         modal_class="sb-history-advertisement">
                        <template #body>
                            <div class="overflow-auto">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Название</th>
                                        <th>Дата старта</th>
                                        <th>Дата конца</th>
                                        <th>Дней</th>
                                        <th>Сумма</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in item.finished_advertisements">
                                        <td>{{ item.rate.title }}</td>
                                        <td>{{ item.dateStart }}</td>
                                        <td>{{ item.dateEnd }}</td>
                                        <td>{{ item.days }}</td>
                                        <td>{{ item.amount }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                    </modal-advertisement>

                    <div class="col-lg-3 pl-0 pr-0">
                        <div class="img_sport-object w-100 position-relative"
                             :class="{'classPromotion': item.hasPromotion}">
                            <img class="sb-image-content w-100" :alt="`object-${index + 1}`" style="object-fit: cover;"
                                 :src="'/storage/listings/objects/' + item.id + '/' + item.image[0]">
                            <div class="object-block__vip-label" v-if="item.hasVIP">vip</div>
                            <div class="object-block__fast-forward-label" v-if="item.hasHighlightion">
                                <img src="/icons/sportObjects/fast-forward.svg" alt="fast">
                            </div>
                        </div>
                        <div class="buttons d-lg-none d-flex">
                            <span v-if="item.verify === 1"
                                  @click="item.visible === 1 ? changeVisibleSportObject(item.id, 0)
                                  : changeVisibleSportObject(item.id, 1)"
                                  class="btnAction d-flex align-items-center justify-content-center"
                                  style="border: 1px solid #EBECF1; cursor:pointer;">
                                <img :src="item.visible === 0 ? '/icons/sportObjects/viewHidden.svg'
                                : '/icons/sportObjects/viewShow.svg'" alt="">
                            </span>
                            <span class="btnAction d-flex align-items-center justify-content-center cursor-pointer"
                                  style="border: 1px solid #6283E5;"
                                  @click="sportObject.id = item.id; sportObject.title = item.title"
                                  :data-target="'#sb-notification-delete-'+item.id" data-toggle="modal">
                                <img src="/icons/sportObjects/trash.svg" alt="">
                            </span>
                            <span @click="showPageEditSportObject(item.id)"
                                  class="btnAction d-flex align-items-center justify-content-center"
                                  style="border: 1px solid #E45868; cursor:pointer;">
                                <img src="/icons/sportObjects/edit.svg" alt="">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-9 p-0 pb-3">
                        <div class="block-text position-relative">
                            <div class="block_title d-flex p-4 justify-content-between">
                                <div>
                                    <p class="captionHidden">{{ item.title }}<span class="id pl-4">id  {{
                                            item.id
                                        }}</span>
                                    </p>
                                    <p v-if="item.verify === 0" class="text-muted" style="font-size: 12px"><i>Объект
                                        находится на модерации. Вам доступно редактирование
                                        информации об объекте и удаление объекта при необходимости</i></p>
                                </div>
                            </div>
                            <div class="buttons d-none d-lg-flex">
                                <span v-if="item.verify === 1"
                                      :title="item.visible === 1 ? 'Скрыть объект' : 'Отобразить объект'"
                                      @click="item.visible === 1 ? changeVisibleSportObject(item.id, 0)
                                      : changeVisibleSportObject(item.id, 1)"
                                      class="btnAction d-flex align-items-center justify-content-center"
                                      style="border: 1px solid #EBECF1; cursor:pointer;">
                                    <img :src="item.visible === 1 ? '/icons/sportObjects/viewHidden.svg'
                                    : '/icons/sportObjects/viewShow.svg'" alt="">
                                </span>
                                <span class="btnAction d-flex align-items-center justify-content-center cursor-pointer"
                                      style="border: 1px solid #6283E5;"
                                      @click="sportObject.id = item.id; sportObject.title = item.title"
                                      :data-target="'#sb-notification-delete-'+item.id" data-toggle="modal">
                                    <img src="/icons/sportObjects/trash.svg" alt="">
                                </span>
                                <span @click="showPageEditSportObject(item.id)"
                                      class="btnAction d-flex align-items-center justify-content-center"
                                      style="border: 1px solid #E45868; cursor:pointer;">
                                <img src="/icons/sportObjects/edit.svg" alt="">
                            </span>
                            </div>
                        </div>
                        <div class="description_sport-object d-lg-none d-block">
                            <div class="row p-4 pt-3 d-flex justify-content-between">
                                <div class="col-12 mb-4">
                                    <div class="row">
                                        <div class="object-rating d-flex pr-5 col-6">
                                            <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                         :showRating="false"
                                                         :rating="item.average_rating"
                                                         :read-only="true"/>
                                            <p class="text-color_blue">{{ item.average_rating | formatRating }}</p>
                                        </div>
                                        <div class="object-message d-flex col-6">
                                            <img src="/icons/sportObjects/chat.svg" alt="">
                                            <p class="text-color_blue">{{ item.reviews_count }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex align-items-start object-block__location object-location">
                                    <img src="/icons/russia-icon.svg" alt="russia-icon"
                                         class="object-location__flag pr-3">
                                    <div class="object-location__country pr-3">{{ item.country }},{{ item.city }}, {{
                                            item.address
                                        }}
                                    </div>
                                </div>
                            </div>
                            <div class="block_descr p-4 pt-0">
                                <p class="text__descr" v-html="item.description"></p>
                            </div>
                        </div>
                        <div class="description_sport-object d-lg-block d-none">
                            <div class="p-4 pt-3 d-flex justify-content-between">
                                <div class="object-block__location object-location d-flex">
                                    <img src="/icons/russia-icon.svg" alt="russia-icon"
                                         class="object-location__flag pr-3">
                                    <div class="object-location__country pr-3">{{ item.country }},</div>
                                    <div class="object-location__city">{{ item.city }}, {{ item.address }}
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="object-rating d-flex pr-5">
                                        <star-rating :increment="0.5" :starSize="18" :activeColor="'#F5AE67'"
                                                     :showRating="false"
                                                     :rating="item.average_rating"
                                                     :read-only="true"/>
                                        <p class="text-color_blue">{{ item.average_rating | formatRating }}</p>
                                    </div>
                                    <div class="object-message d-flex">
                                        <img src="/icons/sportObjects/chat.svg" alt="">
                                        <p class="text-color_blue">{{ item.reviews_count }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="block_descr p-4 pt-0">
                                <p class="text__descr" v-html="formattedText(item.description)"></p>
                            </div>
                        </div>

                        <div class="d-flex d-lg-none row price_sport-object p-4 pt-0 pb-0 justify-content-between">
                            <div class="price">
                                <div class="price-for-per">
                                    <p class="align-items-center d-flex justify-content-center price_text text-center">
                                        <span class="price">{{ item.accm_minPrice }}<span
                                            class="valute pl-2">руб. / </span></span>
                                        <span style="font-weight: bolder">с человека в сутки</span>
                                    </p>
                                </div>
                            </div>

                            <div class="d-lg-none d-flex gap-2">
                                <template v-if="shouldShowAdvertisement(item)">
                                    <div v-if="isAdvertising(item)"
                                         class="sb-advertisement-reminders d-flex align-items-center justify-content-between">
                                        <div :data-target="'#sb-advertisement-order-'+item.id" data-toggle="modal"
                                             :style="advertisementStyle">
                                            <p class="sb-color-main-blue mr-2">осталось </p>
                                            <p class="sb-color-green">{{ remainingDays(item) }}</p>
                                        </div>
                                    </div>
                                    <div v-else-if="isPaused(item)"
                                         class="sb-advertisement-reminders align-items-center">
                                        <p class="sb-color-green mr-2 underline"
                                           :data-target="getAdvertisementTarget(item)" data-toggle="modal">
                                            Реклама на паузе
                                        </p>
                                    </div>
                                    <div v-else-if="item.verify === 1" class="btnAdvertising w-100">
                                        <button type="button" data-toggle="modal"
                                                :data-target="`#sb-advertisement-${item.id}`"
                                                :style="advertisementStyle"
                                                class="button btn-on_advertising justify-content-center p-4 fs-6 mb-0">
                                            Запустить рекламу
                                            <img class="pl-4" src="/icons/sportObjects/growing.svg" alt="growing">
                                        </button>
                                    </div>
                                </template>

                                <button v-if="item.verify === 1"
                                        class="align-items-center btn-blue btnAction cursor-pointer d-flex justify-content-center me-0"
                                        :style="actionButtonStyle" @click="handleClick(item.id, item)">
                                    <i :ref="'tooltipTarget_' + item.id" class="fa fs-2 fa-info-circle text-info"></i>
                                </button>
                            </div>
                        </div>

                        <div class="price_sport-object p-4 pb-0 justify-content-between d-lg-flex d-none">
                            <div class="price">
                                <p class="price-caption">Цены от</p>
                                <div class="price-for-per">
                                    <p class="price_text">
                                        <span class="price">{{ item.accm_minPrice }}<span
                                            class="valute pl-2">руб.</span></span>
                                        <span>в сутки с человека</span>
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <template v-if="showAdvertisement(item)">
                                    <div class="sb-advertisement-reminders align-items-center d-flex">
                                        <p class="sb-color-green mr-2 underline"
                                           :data-target="'#sb-advertisement-order-'+item.id" data-toggle="modal">
                                            {{ getAdvertisementText(item) }}
                                        </p>
                                        <div v-if="isAdvertising(item)" class="sb-advertisement-reminders__days d-flex">
                                            <p class="sb-color-main-blue mr-2">осталось</p>
                                            <p class="sb-color-green">{{ remainingDays(item) }}</p>
                                        </div>
                                    </div>
                                </template>

                                <template v-else>
                                    <button v-if="item.verify === 1"
                                            class="button btn-on_advertising justify-content-center" type="button"
                                            data-toggle="modal" :data-target="`#sb-advertisement-${item.id}`">
                                        Запустить рекламу
                                        <img class="pl-4" src="/icons/sportObjects/growing.svg" alt="growing">
                                    </button>
                                    <div v-else class="sb-advertisement-reminders align-items-center">
                                        <p class="sb-color-green mr-2 underline"
                                           :data-target="item.verify === 1 ? '#sb-advertisement-order-'+item.id : ''"
                                           data-toggle="modal">
                                            {{ getAdvertisementText(item) }}
                                        </p>
                                    </div>
                                </template>

                                <button
                                    class="align-items-center btn-blue btnAction cursor-pointer d-flex justify-content-center me-0"
                                    style="height: 60px; width: 60px" @click="handleClick(item.id, item)">
                                    <i :ref="'tooltipTarget_' + item.id" class="fa fs-2 fa-info-circle text-info"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <paginator :pagination="sport_objects_pagination" @changePages="getSportObjects"
                           @handleUpdate="getSportObjects" @changeColPages="changeColPages"/>
            </div>
        </div>
        <extendedinf></extendedinf>
    </div>
</template>
<script>

import navbar from '../../NavBar'
import extendedinf from "../../ExtendedFooterInformation";
import MenuComponent from "../menuComponent";
import {mapActions, mapGetters} from 'vuex';
import VSelect from "@alfsnd/vue-bootstrap-select";
import StarRating from 'vue-star-rating'
import axios from "axios";
import Paginator from "../../Paginator";
import ModalAdvertisement from "../../elements/SbModal";
import ModalNotification from "../../elements/Modal";
import Modal from "../../elements/Modal";
import eventBus from '../../../event-bus';


export default {
    data: function () {
        return {
            filter: {search: ''},
            sportObject: {id: null, title: null},
            selectedAdvertisementIds: [],
            selectedAdvertisements: [{advertisement: null}, {advertisement: null}, {advertisement: null}],
            objectsData: {limit: 10, page: 1}, daysStop: [], errors: [],
            payPromotions: []
        }
    },

    computed: {
        ...mapGetters({
            sport_objects: 'AllSportObjects',
            sport_objects_pagination: 'sport_objects_pagination',
            sport_objects_loading: 'sport_objects_loading',
            statistic: 'sport_objects_statistic'

        }),
        user: function () {
            return window.user;
        },
        advertisements() {
            return this.$store.getters.advertising_tariffs.map(advertisement => ({
                ...advertisement,
                price: advertisement.price.map(price => ({
                    ...price,
                    title: `${price.days} дней (${price.allPrice} руб.)`
                }))
            }));
        },
        advertisementStyle() {
            return {
                height: "45px"
            };
        },
        actionButtonStyle() {
            return {
                height: "45px",
                width: "45px",
                minWidth: "45px"
            };
        },
    },
    components: {
        Paginator, ModalAdvertisement, ModalNotification, MenuComponent, navbar, extendedinf, VSelect, StarRating, Modal
    },
    methods: {
        ...mapActions(["fetchSportObjectsByUser"]),
        isAdvertising(item) {
            return item.advertisements.filter(advertisement => !advertisement.paused).length > 0;
        },
        isPaused(item) {
            return item.advertisements.filter(advertisement => advertisement.paused).length > 0;
        },
        remainingDays(item) {
            return this.declOfDays(item.advertisements.reduce((max, advertisement) => {
                return Math.max(max, advertisement.daysOfEnd.remaining_days);
            }, 0));
        },
        handleClick(index, item) {
            $(`#sb-history-advertisement-${item.id}`).modal('show');
        },
        async delSoftSportObject(id) {
            try {
                await axios.put(`/sport-objects/${id}/soft-delete`).then(() => {
                    this.getSportObjects();
                });
                this.closeModalDelete(id);
            } catch (error) {
                console.error(error.response);
            }
        },
        async changeVisibleSportObject(id, visible) {
            try {
                await this.$store.dispatch("visibleSportObject", {id: id, visible: visible});
                this.getSportObjects();
            } catch (error) {
                console.log(error);
            }
        },
        showPageEditSportObject(id) {
          //  eventBus.$emit('edit-object');
            window.location.href = '/sport-objects/edit/' + id
        },
        async getSportObjects(page = this.objectsData.page, limit = this.objectsData.limit, filter = this.filter) {
            await this.$store.dispatch('fetchSportObjectsByUser', {
                limit: limit, page: page, filter: filter
            });
            window.scrollTo(0, 0);
        },
        changeColPages(pages) {
            this.objectsData.limit = pages;
            this.getSportObjects();
        },
        closeModalDelete(id) {
            $('#sb-notification-delete-' + id).modal('toggle');
            this.sportObject = {id: null, title: null}
        },
        async payPromotion(objectId) {
            if (this.selectedAdvertisements.filter(item => item.advertisement != null).length < 1) {
                alert("Не выбран ни один вид рекламы");
                return;
            }
            this.payPromotions = this.selectedAdvertisements.map(advertisement => {
                if (advertisement.advertisement != null) {
                    const adver = advertisement.advertisement;
                    return {
                        id: adver.id,
                        price: {
                            allPrice: adver.allPrice,
                            days: adver.days,
                            oneDay: adver.oneDay
                        }
                    };
                }
                return null;
            });

            const advertisementsPay = this.payPromotions.filter(item => {
                if (item != null) return item;
            });
            const amount = advertisementsPay.reduce((acc, item) => acc + item.price.allPrice, 0);
            try {
                const response = await axios.post('/payments/create', {
                    sportObject_id: objectId,
                    amount: amount,
                    advertisements: advertisementsPay,
                    description: 'Оплата за рекламное продвижение'
                });
                if (response.status === 200) {
                    window.open(response.data);
                } else {
                    console.log('Ошибка при создании платежа');
                }
            } catch (error) {
                console.log('Ошибка при выполнении запроса', error);
            }
        },
        closeModalAdvertisement(id) {
            $(`#sb-advertisement-${id}`).modal('toggle');
            this.getSportObjects();
        },
        declOfDays(days) {
            const titles = ['день', 'дня', 'дней'];
            const cases = [2, 0, 1, 1, 1, 2];
            const lastTwoDigits = days % 100;
            const lastDigit = days % 10;
            let index;

            if (lastTwoDigits >= 5 && lastTwoDigits <= 20) {
                index = 2;
            } else {
                index = cases[lastDigit === 1 && lastTwoDigits !== 11 ? 0 : lastDigit >= 2 && lastDigit <= 4 ? 1 : 2];
            }

            return days + ' ' + titles[index];
        },

        inputAdvertisements(event, id, index) {
            this.selectedAdvertisements[index].advertisement.id = id;
        },
        resetSelectAdvertisement(index) {
            this.selectedAdvertisements[index].advertisement = null;
        },
        stopAdvertisement(advertisement_id, index, daysStop) {
            if (this.daysStop[index] === undefined || this.daysStop[index] === '') {
                return;
            }
            this.$store.dispatch('pauseAdvertisement', {id: advertisement_id, data: {days: daysStop}}).then(() => {
                this.getSportObjects();
            })
        },
        resumeAdvertisement(advertisement_id) {
            this.$store.dispatch('continueAdvertisement', {id: advertisement_id}).then(() => {
                this.getSportObjects();
            })
        },
        validateDaysStop(index) {
            if (this.daysStop[index] < 1) {
                this.daysStop[index] = 1;
            } else if (this.daysStop[index] > 10) {
                this.daysStop[index] = 10;
            }
        },
        showAdvertisement(item) {
            return this.isAdvertising(item) || this.isPaused(item);
        },
        getAdvertisementText(item) {
            if (this.isAdvertising(item)) {
                return "Рекламируется";
            } else if (this.isPaused(item)) {
                return "Реклама на паузе";
            }
        },
        shouldShowAdvertisement(item) {
            return this.isAdvertising(item) || this.isPaused(item) || item.verify === 1;
        },
        getAdvertisementTarget(item) {
            return item.verify === 1 ? `#sb-advertisement-order-${item.id}` : '';
        },
        removeHtmlTags(text) {
            return text.replace(/<[^>]+>/g, '');
        },
        addSpacesAfterPeriods(text) {
            return text.replace(/\.(\s*)/g, '. ');
        },
        formattedText(text) {
            let textWithoutTags = this.removeHtmlTags(text);
            return this.addSpacesAfterPeriods(textWithoutTags);
        }
    },
    created() {
        this.getSportObjects();
        this.$store.dispatch('getAdvertisingTariffs');
    },
    watch: {
        filter: {
            handler: function (value, oldValue) {
                this.getSportObjects();
            }, deep: true
        },
    }
}
</script>

<style lang="scss">
.sb-info-advertisement button {
    height: 30px !important;
}

.sb-statistic-object > * {
    color: #0b3158;
}

.sb-statistic-object {
    p {
        font-size: 14px;
    }

    label.caption {
        font-size: 14px;
    }

    input {
        height: 40px;
    }
}
</style>
