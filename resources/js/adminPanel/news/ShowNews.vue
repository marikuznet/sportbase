<template>
    <div>
        <main class="sb-view-news container-fluid">
            <div class="">
                <nav aria-label="breadcrumb">
                    <ol class="sb-content__breadcrumb breadcrumb">
                        <li class="breadcrumb-item fs-lg-5"><a href="/admin/news">Новости</a></li>
                        <li class="breadcrumb-item active fs-lg-5" aria-current="page">{{ news.title }}</li>
                    </ol>
                </nav>
                <div class="sb-view-news__header text-center" v-if="news">
                    <h3 class="sb-header__title text-uppercase">{{ news.title }}</h3>
                    <div class="sb-header__date-and-view d-flex justify-content-center">
                        <h6 class="sb-date-and-view__date mr-4 m-1">{{ news.created }}</h6>
                        <h6 class="sb-date-and-view__view">{{ news.view_count }}</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 sb-view-news_padding-0" v-if="news">
                        <div class="sb-view-news__article p-5 mb-5" v-html="news.content">
                        </div>

                        <div class="sb-view-news__block-social ml-5 mb-5">
                            <div class="sb-view-news__social d-inline-flex">
                                <div class="sb-social d-flex shadow">
                                    <div class="sb-logo sb-vk__logo d-flex justify-content-center">
                                        <img src="/icons/vk.svg" alt="vk">
                                    </div>
                                    <div class="sb-action sb-vk__like mx-2">Нравится</div>
                                    <div class="sb-col sb-vk__col">{{ news.share_vk_count }}</div>
                                </div>
                                <div class="sb-social d-flex shadow">
                                    <div class="sb-logo sb-fb__logo d-flex justify-content-center">
                                        <img src="/icons/facebook-logo.svg" alt="facebook">
                                    </div>
                                    <div class="sb-action sb-fb__like mx-2">Share</div>
                                    <div class="sb-col sb-fb__col">{{ news.share_fb_count }}</div>
                                </div>
                                <div class="sb-social d-flex shadow">
                                    <div class="sb-logo sb-tw__logo d-flex justify-content-center">
                                        <img src="/icons/twitter.svg" alt="twitter">
                                    </div>
                                    <div class="sb-action sb-tw__like mx-2">Tweet</div>
                                    <div class="sb-col sb-tw__col">{{ news.share_tw_count }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    name: "ShowNews",
    props: ["item"],
    computed: {
        news() {
            return this.item;
        }
    },
}
</script>

<style scoped>

</style>
