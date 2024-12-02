<template>
    <div>
        <navbar></navbar>
        <div class="content__compareObjects container-fluid p-0 overflow-hidden">
            <div class="wrapper container-fluid bg-white p-0">
                <div class="container favorites-objects__actions">
                    <div class="row top px-5 px-lg-0 justify-content-lg-end justify-content-center py-4 ">
                        <div class="col col-12 col-lg-auto pb-2 pb-lg-0 px-0 px-lg-2">
                            <form action="/favorites-objects">
                                <button
                                    class=" top__button backFavorites button button-blueBorder w-100  borderblock fs-6 text-start px-4">
                                    <p class="text-white position-relative"> Вернуться к избранным</p></button>
                            </form>
                        </div>
                        <div class="col col-12 col-lg-auto px-0 px-lg-2">
                            <button type="button" @click="removeAll" class="button button-border px-4 w-100">
                                <p>Удалить все объекты</p>
                                <span class="ms-2">{{ favoritesObject.length }}</span>
                                <svg class="ms-3" xmlns="http://www.w3.org/2000/svg" width="18.642" height="20"
                                     viewBox="0 0 18.642 20">
                                    <g id="delete_1_" data-name="delete (1)" transform="translate(-17.379)">
                                        <g id="Сгруппировать_7215" data-name="Сгруппировать 7215"
                                           transform="translate(17.379 3.003)">
                                            <g id="Сгруппировать_7214" data-name="Сгруппировать 7214">
                                                <g id="Сгруппировать_7213" data-name="Сгруппировать 7213">
                                                    <path id="Контур_44872" data-name="Контур 44872"
                                                          d="M306.712,175.113l-1.566-.057-.339,9.269,1.566.057Z"
                                                          transform="translate(-293.579 -171.22)" fill="#e45868"/>
                                                    <rect id="Прямоугольник_7961" data-name="Прямоугольник 7961"
                                                          width="1.567" height="9.269"
                                                          transform="translate(8.538 3.864)"
                                                          fill="#e45868"/>
                                                    <path id="Контур_44873" data-name="Контур 44873"
                                                          d="M160.324,184.318l-.339-9.269-1.566.057.339,9.269Z"
                                                          transform="translate(-152.91 -171.214)" fill="#e45868"/>
                                                    <path id="Контур_44874" data-name="Контур 44874"
                                                          d="M17.379,76.867v1.567h1.632L20.306,93.15a.783.783,0,0,0,.78.715h11.2a.783.783,0,0,0,.78-.715l1.3-14.716h1.659V76.867ZM31.57,92.3H21.8l-1.22-13.864H32.79Z"
                                                          transform="translate(-17.379 -76.867)" fill="#e45868"/>
                                                </g>
                                            </g>
                                        </g>
                                        <g id="Сгруппировать_7217" data-name="Сгруппировать 7217"
                                           transform="translate(22.836)">
                                            <g id="Сгруппировать_7216" data-name="Сгруппировать 7216">
                                                <path id="Контур_44875" data-name="Контур 44875"
                                                      d="M163.5,0h-5.117a1.307,1.307,0,0,0-1.305,1.305v2.48h1.567V1.567h4.6V3.786H164.8V1.305A1.307,1.307,0,0,0,163.5,0Z"
                                                      transform="translate(-157.076)" fill="#e45868"/>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="content__compareObjects container-fluid p-0 overflow-hidden ">
                    <div class="row content pb-5 px-4 px-lg-0 pt-4">
                        <div class="owl-carousel owl-theme compareObjects_owl pt-3 d-flex">
                            <div class="item pb-5 pt-4 pr-5" style="max-width: 550px; width: 550px; min-width: 550px"
                                 v-for="item in favoritesObject">
                                <div class=" wrapper  shadow bg-white borderblock mb-3 position-relative">
                                    <div @click="removeFavorite(item)"
                                         class="delete likeMark  anotherObject rounded bg-white p-2 m-4 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14.308" stroke="none"
                                             height="14.308" viewBox="0 0 14.308 14.308">
                                            <path id="cancel"
                                                  d="M9.212,7.382a.316.316,0,0,1,0-.457l4.9-4.9a.706.706,0,0,0,.2-.457.706.706,0,0,0-.2-.457L13.2.2A.706.706,0,0,0,12.74,0a.593.593,0,0,0-.457.2l-4.9,4.9a.316.316,0,0,1-.457,0L2.025.2A.706.706,0,0,0,1.568,0a.706.706,0,0,0-.457.2L.2,1.111a.706.706,0,0,0-.2.457.706.706,0,0,0,.2.457l4.9,4.9a.316.316,0,0,1,0,.457l-4.9,4.9a.632.632,0,0,0,0,.915l.915.915a.706.706,0,0,0,.457.2.706.706,0,0,0,.457-.2l4.9-4.9a.316.316,0,0,1,.457,0l4.9,4.9a.632.632,0,0,0,.915,0l.915-.915a.632.632,0,0,0,0-.915Z"
                                                  fill="#f56868"/>
                                        </svg>
                                    </div>
                                    <img :src="'/storage/listings/objects/'+ item.id + '/' + item.image[0]" alt="Image"
                                         class="el__img w-100 border-corn-top">
                                    <p class="el__title px-4 pt-4 fs-4 pb-3 text-Blue">{{ item.title }}</p>
                                    <p class=" country__name d-inline-block px-4 pb-3"> {{ item.city }}</p>
                                    <p class="description opacity-7 px-4 pb-5 mb-5 text-Blue"
                                       style="max-height: 600px; overflow: hidden" v-html="item.description"></p>
                                    <div class=" mx-lg-4"><p
                                        class="mx-auto m-lg-0 anotherObjects__price text-white fs-6 p-3 text-center button-blueBorder"> <span
                                        class="fs-5 text-white">{{ item.accm_minPrice }} ₽</span> /
                                        с человека в сутки</p>
                                    </div>

                                    <div class="informationBlocks__content__block__price pt-3" id="price">
                                        <div class="wrapper informationBlocks__content__block__price-blueBlock
                                            shadow rounded-top p-3 p-lg-2 informationBlocks__content__block border-0">

                                            <p class="title Mobile fw-bold pb-0 addInform text-white d-lg-none text-Blue">
                                                Цена на проживание
                                            </p>

                                            <div v-for="accommodation in item.accommodations"
                                                 class="informationBlocks__content__block__price__el py-2">
                                                <div class="wrapper  bg-white">
                                                    <div class="row px-4 pt-4 pb-3 m-0 borderBlockBottom">
                                                        <p class="title col col-auto col-lg-12 fw-bold p-0 pb-2 text-Blue">
                                                            с 1 января по 31 декабря
                                                        </p>
                                                        <p class="borderblock type col col-auto col-lg-2 my-auto p-lg-0
                                                            text-center text-Blue text-break">
                                                            {{ accommodation.type }}
                                                        </p>
                                                        <p class="col-12 col col-lg-10 comment px-0 px-lg-3 text-Blue"
                                                           v-html="accommodation.description">
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="row px-4 pb-4 pt-3  m-0 row-cols-1 row-cols-lg-2 justify-content-between">
                                                        <p class="col col-auto my-auto p-0 p-lg-0 pb-2 text-Blue"><span
                                                            class="fw-bold ">{{ getMinPrice(accommodation.price) }}
                                                    </span>руб. / в сутки с человека</p>
                                                        <button v-if="false" type="button "
                                                                class="col col-auto middle__button button  button-register my-auto rounded-0 text-start p-2">
                                                            <!--Забронировать--></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Класс disable - неактивный блок-->
                                            <div v-if="false"
                                                 class="informationBlocks__content__block__price__el py-2 disable">
                                                <div class="wrapper  bg-white">
                                                    <div class="row px-4 pt-4 pb-3 m-0 borderBlockBottom">
                                                        <p class="title col col-auto col-lg-12 fw-bold p-0 pb-2 text-Blue">
                                                            с 1 марта по 31 мая
                                                        </p>
                                                        <p
                                                            class="borderblock type col col-auto col-lg-2 my-auto p-lg-0 text-center text-Blue">
                                                            Отель</p>
                                                        <p class="col-12 col col-lg-10 comment px-0 px-lg-3 text-Blue">
                                                            Двух- или трёхместный
                                                            номер с собственной ванной комнатой</p>
                                                    </div>
                                                    <div
                                                        class="row px-4 pb-4 pt-3  m-0 row-cols-1 row-cols-lg-2 justify-content-between">
                                                        <p class="col col-auto my-auto p-0 p-lg-0 pb-2 text-Blue"><span
                                                            class="fw-bold ">1000
                                                    </span>руб. / в сутки с человека</p>
                                                        <button type="button "
                                                                class="col col-auto middle__button button  button-register my-auto rounded-0 text-start">
                                                            <!--Забронировать--></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="button button-fill rounded-0 border-0 m-auto d-block">Запросить
                                    расчет
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from './NavBar.vue'
import extendedinf from './ExtendedFooterInformation.vue'
import {Swiper, SwiperSlide} from "vue-awesome-swiper";
import 'swiper/css/swiper.css'
import {mapActions, mapGetters} from "vuex";
import carousel from 'vue-owl-carousel';
import SbResponseModal from "./elements/SbResponseModal";
import axios from "axios";

export default {
    data() {
        return {
            favorites: [], favoritesObject: [],
            hasUserPayment: false,
            hasUserInfo: false,
        }
    },
    computed: {
        ...mapGetters({
            allSportObject: 'AllSportObjects',
        }),
        user() {
            return window.user;
        },
    },
    methods: {
        ...mapActions(["fetchSportObjects"]),
        deleteInfrastruct(e) {
            const box = e.target.closest('.item');
            box.remove();
        },
        removeFavorite(object) {
            const index = this.favorites.findIndex(item => item.id === object.id);

            if (index !== -1) {
                this.favorites.splice(index, 1);
                this.favoritesObject = [...this.favorites];
                const parsed = JSON.stringify(this.favorites);
                localStorage.setItem('favorites', parsed);
            }
        },
        removeAll() {
            this.favorites = [];
            this.favoritesObject = [];
            localStorage.setItem('favorites', JSON.stringify(this.favorites));
        },
        getMinPrice(price) {
            return price.reduce((min, current) => current.minPrice < min.minPrice ? current : min).minPrice;
        },
        async getHasUserPayment() {
            try {
                const {data} = await axios.get('/api/user/payment-details');
                this.hasUserPayment = data === 1;
            } catch (error) {
                console.error('Error fetching user payment details:', error);
            }
        },
        async getHasUserInfo() {
            try {
                const {data} = await axios.get('/api/user/info-company');
                this.hasUserInfo = data === 1;
            } catch (error) {
                console.error('Error fetching user info:', error);
            }
        },
        authUser() {
            window.location.href = '/auth';
        },
        authRegister() {
            window.location.href = '/auth/registration';
        },
    },
    watch: {},
    async mounted() {
        await Promise.all([
            this.getHasUserPayment(),
            this.getHasUserInfo(),
        ]);
        if (localStorage.getItem('favorites')) {
            try {
                this.favorites = JSON.parse(localStorage.getItem('favorites'));
                this.favoritesObject = this.favorites;
            } catch (e) {
                localStorage.removeItem('favorites');
            }
        }
    },
    components: {
        SbResponseModal,
        navbar,
        extendedinf,
        Swiper,
        SwiperSlide,
        carousel
    },
}
</script>

<style scoped>
.border-corn-top {
    border-top-right-radius: inherit;
    border-top-left-radius: inherit;
    height: 200px;
    object-fit: cover;
}
</style>
