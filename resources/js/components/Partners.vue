<template>
<section class="partners">
    <div class="container">
        <div class="section-title">
            <h2 class="title">Наши генеральные партнеры</h2>
            <h4 class="subtitle subtitle-red">*на правах рекламы</h4>
            <div class="line"></div>
        </div>

        <swiper id="partnersSlider" :options="swiperOptionInPartners">
            <swiper-slide class="swiper-wrapper partners-slides partners-slides__item partners-slide" v-for="partner in partners" :key="partner.id">
                <div class="swiper-slide partners-slide" style="width: 100%">
                    <img class="partners-slide__img" :src="partner.partnerImage" alt="partner-gazprom">
                    <div class="partners-slide__blur">
                    </div>
                    <div class="partners-slide__content">
                        <div class="partners-slide__logo d-none d-sm-block">
                            <img :src="partner.partnerLogo" alt="gazprom-logo">
                        </div>
                        <div class="partners-slide__text">
                            <h2 class="partners-slide__name">Газпром <span>арена</span></h2>
                            <p class="partners-slide__descr">{{partner.description}}</p>
                        </div>
                    </div>
                    <img src="/icons/gazprom-arena-lines.svg" alt="gazprom-arena-lines" class="partners-slide__addit-img d-none d-md-block">
                </div>
            </swiper-slide>
            <div class="swiper-pagination " slot="pagination"></div>
            <div class="swiper-button-prev" slot="button-prev">
                <svg style="width:48px;height:48px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z" />
                </svg>
            </div>
            <div class="swiper-button-next " slot="button-next">
                <svg style="width:48px;height:48px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z" />
                </svg>
            </div>
        </swiper>

        <div class="partners-buttons d-flex justify-content-center">
            <button type="button" class="button button-fill button-blue mr-2">Стать партнером</button>
            <button type="button" class="button button-border h-100 sb-button-blue">Спонсорство</button>
        </div>
    </div>
</section>
</template>

<script>
import {
    Swiper,
    SwiperSlide
} from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'
export default {

    data() {
        return {
            partners: [{
                    id: 1,
                    partnerImage: "/images/webp/partner-gazprom.webp",
                    partnerLogo: "/icons/gazprom-logo.svg",
                    description: "лучшие предложения по аренде на сезон 2021",
                },
                {
                    id: 2,
                    partnerImage: "/images/webp/partner-gazprom.webp",
                    partnerLogo: "/icons/gazprom-logo.svg",
                    description: "лучшие предложения по аренде на сезон 2021",
                },
                {
                    id: 3,
                    partnerImage: "/images/webp/partner-gazprom.webp",
                    partnerLogo: "/icons/gazprom-logo.svg",
                    description: "лучшие предложения по аренде на сезон 2021",
                },
                {
                    id: 4,
                    partnerImage: "/images/webp/partner-gazprom.webp",
                    partnerLogo: "/icons/gazprom-logo.svg",
                    description: "лучшие предложения по аренде на сезон 2021",
                },
            ],
            swiperOptionInPartners: {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            }
        }
    },
    components: {
        Swiper,
        SwiperSlide,
    },
}
</script>

<style lang="scss" scoped>
//@import '../../sass/base.scss';
.partners-buttons button {
    font-size: 15px;
}
</style>
