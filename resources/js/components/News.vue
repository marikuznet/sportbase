<template>
    <div>
        <div class="align-items-center d-flex justify-content-center loading position-fixed"
             v-if="items_loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <main class="sb-news">
            <div class="sb-news__head-line position-relative">
                <div class="sb-head-line__banner position-relative">
                    <img class="sb-banner__background position-absolute"
                         src="/images/tenderCatalog/background.png"
                         alt="hockey">
                    <div class="banner__gradient"></div>
                    <div class="position-absolute sb-news__title w-100">
                        <div class="container">
                            <div class="d-flex flex-column sb-title__caption text-center">
                                <span class="sb-caption__title text-uppercase">Новости</span>
                                <span class="sb-caption__subtitle">Подписаться на рассылку новостей</span>
                            </div>
                            <div class="sb-head-line__subscribe d-lg-flex d-none justify-content-center">
                                <div class="sb-subscribe__input mr-2">
                                    <input type="text" class="sb-input sb-input-subscribe" placeholder="Ваш email">
                                </div>
                                <div class="sb-subscribe__input">
                                    <div class="sb-button-subscribe">Подписаться
                                        <span class="sb-input__email d-flex ml-4">
                                            <img src="/icons/email.svg" alt="email">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="sb-head-line__subscribe d-lg-none d-flex justify-content-center">
                                <div class="sb-subscribe__input position-relative">
                                    <input type="text" class="sb-input sb-input-subscribe" placeholder="Ваш email">
                                    <span class="sb-input__email position-absolute">
                                            <img src="/icons/email.svg" alt="email">
                                    </span>
                                </div>
                            </div>
                            <div class="sb-title__spam text-center">
                                мы не будет присылать спам или передавать ваши данные третьим лицам
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sb-news__all-content position-relative">
                <div class="container sb-content">
                    <nav aria-label="breadcrumb">
                        <ol class="sb-content__breadcrumb breadcrumb">
                            <li class="breadcrumb-item fs-lg-5"><a href="/">Главная</a></li>
                            <li class="breadcrumb-item active fs-lg-5" aria-current="page">Новости</li>
                        </ol>
                    </nav>
                    <div class="sb-news__caption d-lg-none d-block">
                        НОВОСТИ
                    </div>
                    <div class="d-flex">
                        <div class="sb-content-news row m-0" v-if="items">
                            <div class="col-xl-3 col-lg-4 mb-5 p-0 sb-news__content shadow" v-for="item in items">
                                <div class="sb-news__header">
                                    <div class="sb-header__image">
                                        <img :src="'/api/news/storage/image/' + item.image" alt="">
                                    </div>
                                </div>
                                <div class="sb-news__info">
                                    <div class="sb-info__title">
                                        {{ item.title }}
                                    </div>
                                    <div class="sb-info__description">
                                        {{ item.content_none_tags }}
                                    </div>
                                    <div class="sb-info__date">
                                        {{ item.created }}
                                    </div>
                                    <div class="sb-info__more position-relative">
                                        <a :href="'/news/' + item.slug" class="btn-close-white">Подробнее</a>
                                        <span class="sb-more__next"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container pb-5">
                    <paginator :pagination="pagination_data" @changePages="getNews"
                               @changeColPages="changeColPages"/>
                </div>
            </div>
        </main>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from "./NavBar";
import extendedinf from "./ExtendedFooterInformation";
import Paginator from "./Paginator";

export default {
    name: "News",
    components: {Paginator, navbar, extendedinf},
    data() {
        return {
            pageNumber: 1, colPages: null,
        }
    },
    computed: {
        pagination_data() {
            return this.$store.getters.news_pagination;
        },
        items_loading(){
          return this.$store.getters.news_loading;
        },
        items() {
            return this.$store.getters.all_news;
        }
    },
    methods: {
        async getNews(page = 1, total = 10) {
            await this.$store.dispatch('fetchNews', {
                page: page,
                total: this.colPages ?? total
            });
        },
        changeColPages(pages) {
            this.colPages = pages;
            this.getNews(1, this.colPages);
        },
    },
    created() {
        this.getNews();
    }
}
</script>

<style scoped>
* {
    color: #0B3158;
}

.sb-news__head-line {
    height: 280px;
}

.sb-banner__background {
    width: -webkit-fill-available;
    width: 100%;
    top: -110px;
}

.sb-head-line__banner .banner__gradient {
    height: 280px;
    position: relative;
}

.sb-news__title {
    top: 0;
}

.sb-news__head-line .sb-caption__title {
    margin-top: 23px;
    font-size: 40px;
    color: #FFFFFF;
}

.sb-news__title .sb-title__caption {
    margin-bottom: 20px;
}

.sb-news__head-line .sb-caption__subtitle {
    font-size: 22px;
    color: #FFFFFF;
}

.sb-input-subscribe {
    height: 55px;
    color: #0B3158;
    font-size: 20px;
    min-width: 450px;
}

.sb-button-subscribe {
    background-color: #E45868;
    color: white;
    cursor: pointer;
    border-radius: 10px;
    padding: 0 27px 0 27px;
    height: 100%;
    display: flex;
    align-items: center;
    font-size: 18px;
}

.sb-button-subscribe:hover {
    background-color: #c54352;
}

.sb-head-line__subscribe {
    margin-bottom: 20px;
}

.sb-news__head-line .sb-title__spam {
    font-size: 18px;
    color: #FFFFFF;
    opacity: 75%;
}

.sb-news__all-content {
    min-height: 400px;
    background-color: #F9F9F9;
}

.sb-content__breadcrumb {
    background-color: transparent;
    border-bottom: none;
    padding-top: 25px;
    padding-bottom: 25px;
}

.sb-news__content {
    /*width: 318px;*/
    border-radius: 10px;
    background-color: #FFFFFF;
    border: 1px solid #BAC4DF;
    margin-right: 10px;
}

.sb-news__content .sb-header__image {
    height: 145px;
    border-radius: 10px 10px 0 0;
    margin-bottom: 15px;
    position: relative;
    overflow: hidden;
}

.sb-news__content .sb-header__image img {
    border-radius: 10px 10px 0 0;
    height: auto;
    width: 100%;
}

.sb-news__info {
    margin-left: 22px;
    margin-right: 42px;
}

.sb-news__content .sb-info__title {
    font-size: 20px;
    margin-bottom: 5px;
}

.sb-news__content .sb-info__description {
    color: #7088A1;
    font-size: 17px;
    margin-bottom: 8px;
    max-height: 130px;
    text-overflow: ellipsis;
    overflow: hidden;
}

.sb-news__content .sb-info__date {
    font-size: 17px;
    margin-bottom: 14px;
}

.sb-news__content .sb-info__more {
    cursor: pointer;
    background-color: #6283E5;
    color: white;
    font-size: 19px;
    width: 225px;
    padding: 5px 20px 0 20px;
    height: 48px;
    display: flex;
    align-items: center;
    margin-bottom: 22px;
}

.sb-news__content .sb-info__more:hover {
    background-color: #465fa7;
}

.sb-news__content .sb-info__more .sb-more__next {
    position: absolute;
    right: 10px;
    width: 30px;
    height: 30px;
    background-color: #FFFFFF;
    opacity: 20%;
    top: 9px;
}

.sb-news__content .sb-info__more .sb-more__next:after {
    content: '';
    display: inline-flex;
    width: 15px;
    height: 15px;
    border-top: 2px solid gray;
    border-right: 2px solid gray;
    transform: rotate(45deg);
    margin-top: 8px;
    margin-left: 4px;
}

@media (min-width: 320px) and (max-width: 768px) {
    .sb-banner__background {
        height: 100%;
        top: 0;
    }

    .sb-news__head-line {
        height: 250px;
    }

    .sb-news__head-line .sb-caption__title {
        font-size: 24px;
    }

    .sb-news__head-line .sb-caption__subtitle, .sb-news__head-line .sb-title__spam {
        font-size: 14px;
    }

    .sb-news__head-line .sb-title__spam {
        opacity: 100%;
    }

    .sb-news__head-line .sb-input__email {
        background-color: #E45868;
        border-radius: 10px;
        padding: 10px;
        right: 5px;
        top: 5px;
    }

    .sb-input-subscribe {
        min-width: 300px;
        height: 50px;
        font-size: 14px;
    }

    .sb-news__all-content .sb-news__caption {
        font-weight: bold;
        font-size: 22px;
        margin-bottom: 20px;
    }

    .sb-content-news {
        justify-content: center;
    }

    .sb-news__content {
        margin-right: 0;
    }

    .sb-news__content .sb-info__title {
        font-size: 18px
    }

    .sb-news__content .sb-info__description {
        font-size: 15px;
    }

    .sb-news__content .sb-info__date {
        font-size: 16px;
    }
}

@media (min-width: 768px) and (max-width: 1024px) {

}

</style>
