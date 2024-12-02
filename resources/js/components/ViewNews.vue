<template>
    <div>
        <navbar></navbar>
        <main class="sb-view-news pb-5">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="sb-content__breadcrumb breadcrumb">
                        <li class="breadcrumb-item fs-lg-5"><a href="/">Главная</a></li>
                        <li class="breadcrumb-item fs-lg-5"><a href="/news">Новости</a></li>
                        <li class="breadcrumb-item active fs-lg-5" aria-current="page">{{ item.title }}</li>
                    </ol>
                </nav>
                <div class="sb-view-news__header text-center" v-if="item">
                    <div class="sb-header__title text-uppercase">{{ item.title }}</div>
                    <div class="sb-header__date-and-view d-flex justify-content-center">
                        <div class="sb-date-and-view__date mr-4">{{ item.created }}</div>
                        <div class="sb-date-and-view__view">{{ item.view_count }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 sb-view-news_padding-0">
                        <div class="sb-view-news__article p-5" v-html="item.content">
                        </div>

                        <div class="sb-view-news__article" v-if="false">
                            <div class="sb-article__image">
                                <img src="/imagesobjectCard/1.png" alt="img-news">
                            </div>
                            <div class="sb-article__signature">
                                <span>Фото Adam Smith / Pexels</span>
                            </div>

                            <div class="sb-article">
                                <div class="sb-article__subtitle">Подзаголовок статьи 1</div>
                                <div class="sb-article__text">
                                    <b>Спортивно-гостиничный комплекс AquaLife</b> находится в курортном поселке
                                    Кранево, в северо-восточной Болгарии, в 24 км от Варны. Поселок расположен на самом
                                    берегу Черного моря, между двумя известными болгарскими курортами: Золотые пески и
                                    Албена. Общая площадь территории — 40 000 кв.м.
                                    <br>
                                    <br>
                                    AquaLife — это комплекс для занятий спортом и активного отдыха международного
                                    уровня. С 2011 года AquaLife принял более 7 000 спортсменов из разных стран.
                                    Инфраструктура комплекса располагает всем необходимым для проведения сборов и
                                    соревнований. Спортивные объекты <b>имеют международные сертификаты</b> и
                                    рассчитаны на круглогодичную эксплуатацию.
                                </div>
                            </div>

                            <div class="sb-article__image">
                                <img src="/imagesobjectCard/1.png" alt="img-news">
                            </div>
                            <div class="sb-article__signature">
                                <span>Фото Adam Smith / Pexels</span>
                            </div>

                            <div class="sb-article">
                                <div class="sb-article__text">
                                    В 100 метрах от комплекса находится <b>собственный пляж AquaLife</b>. Уникальный
                                    климат, пологое морское дно без резких перепадов глубины. Пляжная полоса имеет
                                    протяженность около 6 км и ширину до 100 метров, мягкий и мелкий песок. Здесь есть
                                    две площадки для пляжного волейбола, спортивныесооружения. Здесь же расположен
                                    <a href="">бар Beach Bar AquaLife</a>.
                                    <br>
                                    <br>
                                    <b>На территории комплекса AquaLife работает команда профессиональных аниматоров</b>.
                                    Для детей проходят развлекательные, спортивные тематические мероприятия.
                                    <br>
                                    <br>
                                    Программа разработана с учетом режима всех тренировочных сборов и включает в себя:
                                    <ul class="sb-text__list-program">
                                        <li>конкурсы</li>
                                        <li>игры</li>
                                        <li>творческие вечера</li>
                                        <li>тематические встречи</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="sb-view-news__block-social">
                            <div class="sb-view-news__social d-inline-flex">
                                <div class="sb-social d-flex shadow">
                                    <div class="sb-logo sb-vk__logo d-flex justify-content-center">
                                        <img src="/icons/vk.svg" alt="vk">
                                    </div>
                                    <div class="sb-action sb-vk__like">Нравится</div>
                                    <div class="sb-col sb-vk__col">{{ item.share_vk_count }}</div>
                                </div>
                                <div v-if="false" class="sb-social d-flex shadow">
                                    <div class="sb-logo sb-fb__logo d-flex justify-content-center">
                                        <img src="/icons/facebook-logo.svg" alt="facebook">
                                    </div>
                                    <div class="sb-action sb-fb__like">Share</div>
                                    <div class="sb-col sb-fb__col">{{ item.share_fb_count }}</div>
                                </div>
                                <div v-if="false" class="sb-social d-flex shadow">
                                    <div class="sb-logo sb-tw__logo d-flex justify-content-center">
                                        <img src="/icons/twitter.svg" alt="twitter">
                                    </div>
                                    <div class="sb-action sb-tw__like">Tweet</div>
                                    <div class="sb-col sb-tw__col">{{ item.share_tw_count }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 sb-view-news__block-banner">
                        <div class="sb-view-news__banner position-relative">
                            <div class="banner__gradient" style="border-radius: 10px;"></div>
                            <div class="sb-banner__data position-absolute">
                                <div class="sb-data__title">Рекламный баннер</div>
                                <div class="sb-data__caption text-uppercase">Игра только по твоим правилам</div>
                                <div class="sb-data__title sb-data__download">Скачай приложение</div>
                                <div
                                    class="align-items-center d-flex justify-content-center sb-download-btn sb-download-btn__app-store">
                                    <span class="sb-app-store__title align-items-center d-flex">
                                        Загрузить в AppStore
                                    </span>
                                </div>
                                <div
                                    class="align-items-center d-flex justify-content-center sb-download-btn sb-download-btn__google-market">
                                    <span class="sb-google-market__title align-items-center d-flex">
                                        Загрузить в Google Market
                                    </span>
                                </div>
                            </div>
                            <img class="sb-banner__hockey-player" src="/images/webp/hockey-player.webp"
                                 alt="hockey-player">
                        </div>
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

export default {
    name: "ViewNews",
    components: {navbar, extendedinf},
    props: ['news'],
    computed: {
        item() {
            return JSON.parse(this.news);
        }
    },
    mounted() {
    },
    created() {
    }
}
</script>

<style scoped>
* {
    color: #0B3158;
}
</style>
