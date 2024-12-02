<template>
    <div>
        <navbar></navbar>
        <main class="sb-contacts">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-5">
                    <nav aria-label="breadcrumb">
                        <ol class="sb-content__breadcrumb breadcrumb">
                            <li class="breadcrumb-item fs-lg-5"><a href="/">Главная</a></li>
                            <li class="breadcrumb-item active fs-lg-5" aria-current="page">Контакты
                            </li>
                        </ol>
                    </nav>
                    <div class="sb-contacts__block">
                        <div class="sb-contacts__title">Контакты</div>
                        <div class="sb-contacts__phone">8 800 555 55 00</div>
                        <div class="sb-contacts__description">По всем вопросам наша команда сможет вас
                            проконсультировать,
                            если вы позвоните по номеру выше, или напишите на адрес
                        </div>
                        <div class="sb-contacts__mail">info@sportbase.ru</div>
                        <div class="sb-contacts-social d-flex align-items-center">
                            <img src="/icons/social/youtube.svg" alt="youtube">
                            <img src="/icons/social/instagram.svg" alt="instagram">
                            <img src="/icons/social/facebook.svg" alt="facebook">
                            <img src="/icons/social/twitter.svg" alt="twitter">
                        </div>
                        <div class="sb-contacts__btn position-relative mb-2 w-100">
                            <div class="sb-call__title align-items-center d-flex h-100">
                                Заказать звонок
                            </div>
                            <span class="sb-call__next position-absolute"></span>
                        </div>
                        <div class="sb-call__partner sb-contacts__btn position-relative w-100">
                            <div class="sb-call__title align-items-center d-flex h-100">
                                Стать партнером
                                <span class="sb-call__next position-absolute"></span>
                            </div>
                        </div>
                        <div class="sb-main-office__title">
                            Главный офис
                        </div>
                        <div class="sb-main-office">
                            Москва, Белоостровская 15/1, БЦ Авангард, офис 100
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="sb-contacts__map">
                        <yandex-map style="height:100%" :settings="settings"
                                    :coords="[55.7522, 37.6156]"
                                    :zoom="17">
                            <ymap-marker
                                marker-type="placemark"
                                :coords="[55.7522, 37.6156]"
                                :markerId="1"
                                :icon="markerIcon"
                            />
                        </yandex-map>
                    </div>
                </div>
            </div>
        </main>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from "./NavBar";
import extendedinf from "./ExtendedFooterInformation";
import {yandexMap, ymapMarker} from 'vue-yandex-maps';

export default {
    name: "Contacts",
    components: {navbar, extendedinf, yandexMap, ymapMarker},
    data() {
        return {
            markerIcon: {
                layout: 'default#imageWithContent', imageHref: 'icons/stages/mark.svg', imageSize: [48, 55],
                imageOffset: [0, 0], contentOffset: [0, 15],
                contentLayout: '<div style="background: red; width: 50px; color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
            },
            settings: this.$apiSettings.yandexMap,
        }
    }
}
</script>

<style scoped>
* {
    color: #0B3158;
}
</style>
