<template>
    <div class="anotherObjects d-none d-lg-block borderblock bg-white shadow my-4 mb-5 p-4 pb-3 overflow-hidden">
        <p class="title fw-bold px-0 py-2">Похожие объекты</p>
        <swiper id="anotherObjectsSlider" :options="swiperOptionInObjects">
            <swiper-slide
                class="swiper-wrapper another-objects-slides another-objects-slides__item another-objects-slide"
                v-for="object in similarObjects" :key="object.id">
                <div class="swiper-slide objects-slide" style="width: 100%">
                    <div class="bg-white borderblock h-100 item shadow wrapper">
                        <div class="likeMark  anotherObject rounded bg-white p-2 m-4 ">
                            <svg class="overflow-visible" width="20" viewBox="0 0 428.26 387.2">
                                <g id="like">
                                    <path
                                        d="M221.45,37.8c76-71.77,221.37-12.24,197.11,117.79-.08.41-.17.82-.28,1.22C399.4,223.53,296.41,295.52,223.42,376.22a12.13,12.13,0,0,1-17.7.29C141.23,310.05,13.88,205.36,8.74,153-9.95,27,126.06-32.14,204.84,38.05A12.24,12.24,0,0,0,221.45,37.8Z"/>
                                </g>
                            </svg>
                        </div>
                        <img :src="'/storage/listings/objects/' + object.id + '/' + object.images[0]" alt="Image"
                             class="el__img w-100">
                        <div class="another-objects-slides__body h-50 d-grid" style="grid-template-rows: 0fr 0fr auto 0fr;">
                            <p class="el__title px-4 pt-4 fs-4 pb-3 fw-bold">{{ object.title }}</p>
                            <p class=" country__name d-inline-block px-4 pb-3 w-100"><span
                                class="text-lightblue">{{ object.country }} </span>
                                <span class="fs-5 fw-lighter">г.{{ object.city }}</span>
                            </p>
                            <p class="description opacity-7 px-4 pb-3">
                                {{ object.description.replace(/<\/?[^>]+(>|$)/g, "").replace(/\.([^\s])/g, '. $1') }}</p>
                            <p class="anotherObjects__price text-white fs-6 p-3 text-center mx-4 "> <span
                                class="fs-5 text-white">{{ object.accm_minPrice }} ₽</span> / с человека в сутки</p>

                        </div>
                        <a :href="'/object-catalog/' + object.id"
                           class="button button-fill text-white d-block m-auto w-50">Подробнее
                        </a>
                    </div>
                </div>
            </swiper-slide>
            <div class="swiper-pagination " slot="pagination"></div>
            <div class="swiper-button-prev" slot="button-prev"></div>
            <div class="swiper-button-next " slot="button-next"></div>
        </swiper>

        <div class="owl-carousel owl-theme anotherObjects__owl px-4">

        </div>
    </div>
</template>

<script>
import {Swiper, SwiperSlide} from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'

export default {
    props: {
        id: {}
    },
    data() {
        return {
            swiperOptionInObjects: {
                slidesPerView: 4,
                spaceBetween: 20,
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            }, similarObjects: []
        }
    },
    methods: {
        getSimilarObjects() {
            axios.put('/api/sport-objects/similar').then((result) => {
                this.similarObjects = result.data.data;
                this.similarObjects = this.similarObjects.filter(obj => obj.id !== this.$props.id);
            })
        },
        shortenedText(text) {
            return this.shortenText(text, 50);
        },
        shortenText(text, maxLength) {
            if (text.length <= maxLength) {
                return text;
            }
            return text.slice(0, maxLength).trim().split(' ').slice(0, -1).join(' ') + '...';
        },
    },
    mounted() {
        this.getSimilarObjects();
    },
    components: {
        Swiper,
        SwiperSlide,
    },
}
</script>

<style lang="scss" scoped>
@import '../../sass/base.scss';

.swiper-container .swiper-wrapper {
    height: auto !important;
}
</style>
<style>
.swiper-wrapper {
    height: auto !important;
}

.swiper-container {
    padding-bottom: 3rem !important;
}

.anotherObjects .el__img {
    max-height: 250px;
    height: 100%;
    object-fit: cover;
    border-top-left-radius: 9px;
    border-top-right-radius: 9px;
}

.swiper-slide {
    height: 100%;
}

.anotherObjects .description {
    max-height: 95px;
    overflow: hidden;
}
</style>
