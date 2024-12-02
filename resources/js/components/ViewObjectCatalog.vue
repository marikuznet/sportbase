<template>
    <div>
        <div class="align-items-center d-flex justify-content-center loading position-fixed" v-if="loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <div style="min-height: 600px; background-color: #e9ecef">
            <div class="container-fluid p-0" style="background-color: #e9ecef" v-if="infoObject">
                <modal-notification id="sb-not-payment" ref="sb-not-payment" modal_class="sb-not-payment"
                                    content="Для участия в сделке укажите платежные данные (реквизиты) компании в аккаунте на странице Платежные реквизиты"
                                    @left_action="closeModalPayment" @right_action="fillPayment" left_button="Отмена"
                                    right_button="Заполнить реквизиты"></modal-notification>
                <modal-notification id="sb-not-info" ref="sb-not-info" modal_class="sb-not-info"
                                    content="Для участия в сделке укажите данные компании в аккаунте на странице Профиль пользователя"
                                    @left_action="closeModalPayment" @right_action="fillInfo" left_button="Отмена"
                                    right_button="Заполнить профиль"/>

                <div class="content container p-0">
                    <div class="mobileMenu d-lg-none container-fluid p-0">
                        <div class="dropdown w-100 py-4 px-5">
                            <a class="dropdown-toggle text-light fs-5 d-flex p-0 w-100" href="#" role="button"
                               id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ blocks.find(it => it.isActive).title }}
                            </a>
                            <div class="dropdown-menu fs-5 w-100 border-0 pr-4 pl-4 pt-0"
                                 aria-labelledby="dropdownMenuLink">
                                <a v-for="(item, index) in blocks" :key="index"
                                   :class="{ 'active': title_menu === item.title }"
                                   @click="item.handler" class="dropdown-item text-light py-3" :href="item.href">
                                    <p>{{ item.title }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <nav class="px-5 px-lg-0 nav_breadcrumb" aria-label="breadcrumb ">
                        <ol class="breadcrumb px-lg-0 my-lg-2" style="border-bottom: none">
                            <li class="breadcrumb-item fs-lg-5"><a href="/">Главная</a></li>
                            <li class="breadcrumb-item fs-lg-5"><a href="/object-catalog">Каталог объектов</a></li>
                            <li class="breadcrumb-item active fs-lg-5" aria-current="page">{{ infoObject.title }}</li>
                        </ol>
                    </nav>
                    <div class="row row-cols-1 row-cols-lg-2 sb-content-object">
                        <div class="col d-lg-none carouselObjectCard Mobile p-0 position-relative">
                            <div class="object-block-favorites-wrapp d-lg-none position-absolute" style="right: 0">
                                <input class="object-block-favorites__checkbox" type="checkbox"
                                       :value="infoObject.id" @click="addFavourite(infoObject)"
                                       :checked="isFavourite(infoObject)"
                                       :name="'favorites-heart-obj-' + infoObject.id"
                                       :id="'favorites-heart-obj-' + infoObject.id">
                                <label :for="'favorites-heart-obj-' + infoObject.id"
                                       class="object-block-favorites__label me-3 d-flex align-items-center justify-content-center"
                                       style="width: 40px; height: 40px">
                                    <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.0193 1.51891C13.832 0.483103 11.9106 2.06844 10.698
                                                        3.47532C10.1996 4.05355 9.2293 3.98927 8.7741 3.37645C7.62889
                                                        1.83468 5.62652 0.11665 3.16253 1.51891C-0.384959 3.5378 1.16251
                                                        7.51891 2.66253 9.51892C4.39799 11.8328 7.65041 14.4661 9.02416
                                                        15.5325C9.3952 15.8205 9.91428 15.7996 10.2743 15.498C11.8057
                                                        14.2151 14.4246 12.1044 16.1625 10.0189C18.9546 6.6684 19.5193
                                                        3.1764 16.0193 1.51891Z"
                                              stroke="#B7C2CC" stroke-width="3"/>
                                    </svg>
                                </label>
                            </div>
                            <carousel class="carousel-view-object position-relative" :items="1" :nav="false"
                                      :dots="true" :responsive="{0:{items:1, margin:10, dots:true}}">
                                <div class="w-100" style="height: 274px" v-for="image in infoObject.images">
                                    <img class="h-100 w-100" alt="img"
                                         :src="'/storage/listings/objects/'+ infoObject.id +'/'+ image">
                                </div>
                                <template slot="prev">
                                    <span style="font-size: 50px"
                                          class="align-items-center d-flex justify-content-center owl-custom prev"
                                          aria-label=&quot;Previous&quot;>&#x2039;</span>
                                </template>
                                <template slot="next">
                                    <span style="font-size: 50px"
                                          class="align-items-center d-flex justify-content-center next owl-custom owl-custom-right"
                                          aria-label=&quot;Next&quot;>&#x203a;</span>
                                </template>
                            </carousel>
                        </div>
                        <div class="left order-1 order-lg-0">
                            <div class="image d-none d-lg-block">
                                <div class="carouselObjectCard__mainImage ">
                                    <img style="object-fit: cover" id="carouselMainImage" :src="selectedImage"
                                         alt="img"></div>
                                <div class="slider-wrapper">
                                    <div class="slider-navigation-wrapper position-relative">
                                        <div class="slider position-relative carousel-object"
                                             style="width: auto; z-index: 99;">
                                            <carousel :nav="false" :margin="20" :stagePadding="20"
                                                      :dots="false" ref="carousel" :items="5" :mouseDrag="false"
                                                      :responsive="{992:{items:3}, 1200:{items:4}, 1450:{items:5}}">
                                                <div class="item" v-for="(image, index) in infoObject.images"
                                                     :key="index" @click="showPreview(index)">
                                                    <img alt="slider image" style="object-fit: cover"
                                                         :src="'/storage/listings/objects/'+ infoObject.id +'/'+image">
                                                </div>
                                                <template slot="prev">
                                                    <span class="prev owl-custom"
                                                          aria-label=&quot;Previous&quot;>&#x2039;</span>
                                                </template>
                                                <template slot="next">
                                                    <span class="next owl-custom owl-custom-right"
                                                          aria-label=&quot;Next&quot;>&#x203a;</span>
                                                </template>
                                            </carousel>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="view-object__information">
                                <div class="row top d-none d-lg-flex informationBlocks__button py-4 m-0">
                                    <template v-for="block in blocks">
                                        <a :key="block.name" :href="block.href" @click="block.handler" class="col-3 p-1"
                                           data-toggle="collapse" role="button">
                                            <button :class="['bg-light', 'rounded', 'w-100', 'p-2',
                                            'button__' + block.name, 'borderblock', 'button-blueBorder', { 'active': block.isActive }]"
                                                    :id="'button__' + block.name" :name="block.name">{{ block.title }}
                                            </button>
                                        </a>
                                    </template>
                                </div>

                                <div class="p-0 position-relative informationBlocks__content">
                                    <div v-if="isActiveBlock('aboutObject')" id="aboutObject"
                                         class="informationBlocks__content__block informationBlocks__content__block__aboutObject shadow bg-white px-4">
                                        <div class="borderBlockBottom py-4 aboutObject__about px-4">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="title fw-bold addInform">Об объекте</p>
                                                <div class="object-arrow" data-toggle="collapse"
                                                     data-target="#objectDescription"
                                                     aria-expanded="true" style="cursor:pointer">
                                                    <img width="20px" src="/icons/downArrowRed.svg" alt="arrow">
                                                </div>
                                            </div>
                                            <p id="objectDescription" class="content p-0 pt-4"
                                               v-html="infoObject.description"></p>
                                        </div>
                                        <div class="borderBlockBottom py-4 aboutObject__comfort d-none d-lg-block px-4">
                                            <p class="title fw-bold pb-4 addInform">Удобства и услуги</p>
                                            <div class="content ">
                                                <div class="block__elements g-2 row m-0">
                                                    <div class="col-auto p-2 borderblock"
                                                         v-for="service in infoObject.services">
                                                        {{ service.title }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="isActiveBlock('infrastructure')" id="infrastructure" class="informationBlocks__content__block
                                    informationBlocks__content__block__infrastructure shadow bg-white p-3">
                                        <div class="Mobile carouselInfrastructure px-4 d-lg-none d-block"
                                             v-if="infoObject.infrastructures.length > 0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="title fw-bold count py-3">Спортивная инфраструктура
                                                    <span class="badge badge-primary p-2 ms-2">
                                                        {{ infoObject.infrastructures.length }}
                                                    </span>
                                                </p>
                                                <div class="object-arrow" data-toggle="collapse"
                                                     data-target="#objectInfrastructures"
                                                     aria-expanded="true" style="cursor:pointer">
                                                    <img width="20px" src="/icons/downArrowRed.svg" alt="arrow">
                                                </div>
                                            </div>

                                            <carousel id="objectInfrastructures" :items="1" :nav="false"
                                                      :dots="true" :responsive="{0:{items:1.2, margin:10, dots:true}}">
                                                <div v-for="(item, index) in infoObject.infrastructures" :key="index">
                                                    <div class="el wrapper bg-white borderblock mb-3">
                                                        <img
                                                            :src="item.image ? '/storage/listings/infrastruct/' + item.image : '/images/no-photo.png'"
                                                            alt="Image" class="el__img w-100">
                                                        <p class="el__title p-4">{{ item.title }}</p>
                                                        <ul class="el__list px-4 pb-4">
                                                            <li v-for="option in item.options">
                                                                <p class="fs-6 opacity-7">{{ option.title }}</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </carousel>
                                        </div>
                                        <div class="Desktop informationBlocks__content__block__infrastructure__elements
                                        d-none d-lg-flex row row-cols-2 m-0">
                                            <div class="col-6 p-2" v-for="item in infoObject.infrastructures"
                                                 v-if="item">
                                                <div
                                                    class="el wrapper shadow bg-white borderblock h-100 overflow-hidden">
                                                    <img alt="Image" class="el__img w-100"
                                                         :src="item.image && item.image != '/storage/listings/infrastruct/null' ? '/storage/listings/infrastruct/' + item.image : '/images/no-photo.png'">
                                                    <p class="el__title p-4">{{ item.title }}</p>
                                                    <ul class="el__list px-4 pb-4">
                                                        <li v-for="(option, index) in item.options">
                                                            <p class="fs-6 opacity-7">{{ option.title }}</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="isActiveBlock('price')" id="price"
                                         class="informationBlocks__content__block__price view-object__price">
                                        <div class="px-5 p-3 d-lg-none d-block">
                                            <p class="title fw-bold count py-2">Условия и цены</p>
                                        </div>

                                        <p class="mb-2 d-lg-block d-none" v-html="sportObject.pricing.description"></p>

                                        <div class="wrapper informationBlocks__content__block__price-blueBlock shadow
                                            px-5 p-lg-4 informationBlocks__content__block border-0 py-3">
                                            <p class="title fw-bold pb-3 addInform text-white d-lg-block d-none">
                                                Стоимость для спортивных групп
                                            </p>
                                            <p class="title Mobile fw-bold pb-0 addInform text-white d-lg-none d-block
                                                pt-2 pt-lg-0">
                                                Цена на проживание
                                            </p>
                                            <div class="informationBlocks__content__block__price__el py-2"
                                                 v-for="accommodation in infoObject.accommodations">
                                                <div class="wrapper bg-white">
                                                    <div class="row px-4 pt-4 pb-3 m-0 borderBlockBottom">
                                                        <p class="title view-object__price-el col col-auto col-lg-12
                                                            fw-bold p-0 pb-0 pb-lg-2">
                                                            с 1 января по 31 декабря
                                                        </p>
                                                        <p class="borderblock type col col-auto col-lg-3 my-auto
                                                        text-center view-object__type-el">
                                                            {{ accommodation.type }}</p>
                                                        <p class="col col-12 col-lg-9 comment mt-3 mt-lg-0 px-0 px-lg-3"
                                                           v-html="accommodation.description">
                                                        </p>
                                                    </div>
                                                    <div class="row px-4 pb-4 pt-3  m-0 row-cols-1 row-cols-lg-2
                                                        justify-content-between">
                                                        <p class="col col-auto my-auto p-0 p-lg-0 pb-2">
                                                            <span class="fw-bold">
                                                                {{ getMinPrice(accommodation.price) }}
                                                        </span>
                                                            руб. / в сутки с человека
                                                        </p>
                                                        <button type="button"
                                                                class="col col-auto middle__button button button-register my-auto rounded-0 text-start text-white">
                                                            <!--Забронировать--></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Класс disable - неактивный блок-->
                                        </div>
                                        <div class="informationBlocks__content__block__price-Included px-5 py-3">
                                            <p class="title fw-bold pb-2">Включено в стоимость</p>
                                            <ul class="p-0">
                                                <li v-for="(item, index) in infoObject.accomodationConditionAndPricing_included"
                                                    v-if="item.title !== '' ">
                                                    <p>{{ item.title }}</p>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="borderBlockBottom py-4 aboutObject__comfort d-block d-lg-none
                                            px-5 py-3 bg-white">
                                            <p class="title fw-bold pb-2 addInform">Удобства и услуги</p>
                                            <div class="block__elements g-2 row m-0">
                                                <div class="col-auto p-2 borderblock"
                                                     v-for="service in infoObject.services">
                                                    {{ service.title }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-white px-5 p-3 d-lg-none d-block">
                                            <p class="title fw-bold count py-2">Дополнительная информация</p>
                                        </div>
                                        <p class="bg-white d-block d-lg-none mb-4 pb-4 px-5"
                                           v-html="sportObject.pricing.description"></p>
                                    </div>
                                    <div v-if="isActiveBlock('reviews')" id="reviews"
                                         class="informationBlocks__content__block informationBlocks__content__block__reviews m-0 shadow bg-white ">
                                        <div class="align-items-center d-flex h-100 justify-content-center
                                        loading position-absolute" v-if="reviews.loading">
                                            <img src="/images/load.gif" alt="load" style="width: 40px">
                                        </div>
                                        <div class="">
                                            <div
                                                class="d-flex d-lg-none justify-content-between align-items-center px-5 borderBlockBottom">
                                                <p class="align-items-center count d-flex fw-bold py-4 title">Отзывы
                                                    <span class="badge badge-primary p-2 ms-2">
                                                        {{ infoObject.reviews.length }}
                                                    </span>
                                                </p>
                                                <div class="object-arrow" data-toggle="collapse"
                                                     data-target="#objectReviews"
                                                     aria-expanded="true" style="cursor:pointer">
                                                    <img width="20px" src="/icons/downArrowRed.svg" alt="arrow">
                                                </div>
                                            </div>
                                            <div id="objectReviews" class="py-lg-4">
                                                <div class="row top Mobile m-0 px-5 py-4 d-lg-none p-0">
                                                    <p class="title fw-bold px-0 pb-3">Сортировать</p>
                                                    <div class="ms-0 p-0 row row-cols-3 sort">
                                                        <div @click="reviews.sort = 'new'"
                                                             :class="{'active': reviews.sort == 'new'}"
                                                             class="col-auto new borderblock p-2">Новые
                                                        </div>
                                                        <div @click="reviews.sort = 'best'"
                                                             class="col-auto best borderblock p-2 mx-2">Лучшие оценки
                                                        </div>
                                                        <div @click="reviews.sort = 'bad'"
                                                             class="col-auto bed borderblock p-2">Худшие оценки
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row top Desktop m-0 px-4 pt-2 d-none d-lg-flex p-0">
                                                    <p class="col col-auto opacity-7 fs-5 my-auto">Сортировать</p>
                                                    <p class="col col-auto sort  my-auto">
                                                        <select class="select d-inline-block" v-model="reviews.sort">
                                                            <option class="new fs-6" value="new">
                                                                <span>Новые</span>
                                                            </option>
                                                            <option class="best fs-6" value="best">
                                                                <span>Лучшие оценки</span>
                                                            </option>
                                                            <option class="bed fs-6" value="bad">
                                                                <span>Худшие оценки</span>
                                                            </option>
                                                        </select>
                                                    </p>
                                                    <div class="col col-auto  wrapper ">
                                                        <input type="text" class="input_findReviews" id="findReviews"
                                                               name="findReviews" placeholder="Найти в отзывах"></div>
                                                </div>
                                                <div class="row middle m-0 px-4 py-2">
                                                    <div v-if="reviews.data.length > 0"
                                                         class="middle__el borderblock borderblock-blue row m-0 p-4 my-2 shadow"
                                                         v-for="review in reviews.data">
                                                        <div
                                                            class="col col-2 Desktop photo d-none d-lg-block rounded-circle">
                                                            <div class="logo__circle mr-2 ml-2"
                                                                 style="width: 75px; height: 75px">
                                                                <img class="h-100 w-100" style="border-radius: 100%"
                                                                     :src="'/storage/listings/logos/' + review.user_customer_info.user_id
                                                         + '/' + review.user_customer_info.logo">
                                                            </div>
                                                        </div>
                                                        <div class="col col-12 col-lg-10 p-0 px-lg-4">
                                                            <div class="row m-0 p-0 row-cols-2 top">
                                                                <div
                                                                    class="col col-2 Mobile photo d-lg-none rounded-circle my-auto p-0">
                                                                    <div class="logo__circle mr-2 ml-2"
                                                                         style="width: 40px; height: 40px">
                                                                        <img class="h-100 w-100"
                                                                             style="border-radius: 100%"
                                                                             :src="'/storage/listings/logos/' + review.user_customer_info.user_id
                                                         + '/' + review.user_customer_info.logo">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col col-6 p-2 p-lg-0 ml-3 ml-lg-0 name title">
                                                                    {{ review.user_customer_info.title }}
                                                                </div>
                                                            </div>
                                                            <div class="align-items-center borderblockbottom d-lg-none m-0
                                                            middle order-1 order-lg-2 p-0 row row-cols-2">
                                                                <div class="date col col-auto p-0">
                                                                    {{ review.created_at }}
                                                                </div>
                                                                <div
                                                                    class="align-items-center col col-auto d-flex top__comment__rating">
                                                                    <div class="col-auto stars d-inline-block px-2">
                                                                        <img class="d-lg-none d-block"
                                                                             src="/icons/star.svg"
                                                                             alt="star">
                                                                        <star-rating class="d-none d-lg-block"
                                                                                     :increment="0.5" :starSize="16"
                                                                                     :activeColor="'#F5AE67'"
                                                                                     :showRating="false"
                                                                                     :rating="review.average"
                                                                                     :read-only="true"/>
                                                                    </div>
                                                                    <div class="comment d-inline-block fs-5">
                                                                        {{ review.average }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row m-0 p-0 order-2 order-lg-1 py-3 bottom">
                                                                {{ review.text.replace(/<\/?[^>]+(>|$)/g, "") }}
                                                            </div>
                                                        </div>
                                                        <div class="col ms-auto col-10 d-none d-lg-block px-4">
                                                            <div
                                                                class="row m-0 p-0 row-cols-2 order-1 order-lg-2 middle">
                                                                <div class="date col col-auto p-0">{{
                                                                        review.created_at
                                                                    }}
                                                                </div>
                                                                <div class="col col-auto top__comment__rating ">
                                                                    <div class="col-auto stars d-inline-block px-2">
                                                                        <star-rating :increment="0.5" :starSize="16"
                                                                                     :activeColor="'#F5AE67'"
                                                                                     :showRating="false"
                                                                                     :rating="review.average"
                                                                                     :read-only="true"/>
                                                                    </div>
                                                                    <div class="comment d-inline-block">
                                                                        {{ review.average }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <paginator v-if="reviews && reviews.pagination"
                                                           :sb-class="'mb-0 d-lg-block d-none'"
                                                           :pagination="reviews.pagination"
                                                           :offset="reviews.perPage"
                                                           @changePages="changePages"
                                                           @changeColPages="changeColPages"/>
                                                <div class="row bottom Mobile  m-0 px-4  d-lg-none pt-3 pb-4">
                                                    <button class="button m-auto my-auto px-4 rounded-0 text-center
                                                    text-white">
                                                        Показать все отзывы
                                                        (<span class="reviews_count">{{ reviews.data.length }}</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col sb-object__info">
                            <div class="bg-white mb-3 order-1 order-lg-2 py-4 shadow shortInformation">
                                <div class="borderBlockBottom px-5 px-lg-4">
                                    <div class="row top__title p-0">
                                        <div class="col-lg-11 shortInformation__objectName ">
                                            <p class="overflow-hidden fs-3 fs-lg-1 fw-bold text-uppercase">
                                                {{ infoObject.title }}
                                            </p>
                                        </div>
                                        <div v-if="user.role != 3" class=" col-1">
                                            <div class="object-block-favorites-wrapp d-none d-lg-block">
                                                <input class="object-block-favorites__checkbox h-100" type="checkbox"
                                                       :value="infoObject.id" @click="addFavourite(infoObject)"
                                                       :checked="isFavourite(infoObject)"
                                                       :name="'favorites-heart-obj-' + infoObject.id"
                                                       :id="'favorites-heart-obj-' + infoObject.id">
                                                <label class="object-block-favorites__label"
                                                       :for="'favorites-heart-obj-' + infoObject.id">
                                                    <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M16.0193 1.51891C13.832 0.483103 11.9106 2.06844 10.698
                                                        3.47532C10.1996 4.05355 9.2293 3.98927 8.7741 3.37645C7.62889
                                                        1.83468 5.62652 0.11665 3.16253 1.51891C-0.384959 3.5378 1.16251
                                                        7.51891 2.66253 9.51892C4.39799 11.8328 7.65041 14.4661 9.02416
                                                        15.5325C9.3952 15.8205 9.91428 15.7996 10.2743 15.498C11.8057
                                                        14.2151 14.4246 12.1044 16.1625 10.0189C18.9546 6.6684 19.5193
                                                        3.1764 16.0193 1.51891Z"
                                                            stroke="#B7C2CC" stroke-width="3"/>
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row top__comment row-cols-3 py-3 px-0">
                                        <div class="col-auto top__comment__country">
                                            <p class="top__comment__country__name country__name d-inline-block fs-5 d-flex">
                                                <span class="d-lg-block d-none me-1">{{ infoObject.country }}, </span>
                                                {{ infoObject.city }}
                                            </p>
                                        </div>

                                        <div class="align-items-center col-auto d-flex top__comment__rating">
                                            <div class="stars px-2 d-inline-block">
                                                <img class="d-lg-none d-block" src="/icons/star.svg" alt="star">
                                                <star-rating class="d-lg-inline-block d-none" :increment="0.5"
                                                             :starSize="16" :activeColor="'#F5AE67'"
                                                             :showRating="false" :rating="sportObjectAverage"
                                                             :read-only="true"/>
                                            </div>
                                            <div class="comment d-inline-block">
                                                {{ sportObjectAverage }}
                                            </div>
                                        </div>
                                        <div class="col-auto top__comment__comments px-4">
                                            <p class="top__comment__comments__text comment">
                                                {{ this.reviews.data.length }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="price borderBlockBottom px-lg-4 px-5 py-3">
                                    <div class="col-12 col-xl-6 price__text px-0">
                                        <p class="price__text__top fs-5 fw-bold">Цены от</p>
                                        <p class="comment fs-5">
                                        <span class="fs-1 fw-bold">{{ infoObject.accm_minPrice }}
                                        </span>в сутки с человека
                                        </p>
                                    </div>

                                    <modal v-if="user.role != 2" id="sb-auth-users" ref="sb-auth-users"
                                           modal_class="sb-auth-users" title="Уведомление"
                                           content="Отправлять Заявки и отклики могут только зарегистрированные и
                                                    авторизованные ЗАКАЗЧИКИ"
                                           @left_action="authUser" @right_action="authRegister"
                                           left_button="Авторизоваться"
                                           right_button="ЗАРЕГИСТРИРОВАТЬСЯ"></modal>

                                    <modal-notification id="sb-active-request" ref="sb-active-request"
                                                        modal_class="sb-active-request"
                                                        content="У вас уже есть активная заявка. Отправка новой заявки доступно только после завершения предыдущей">
                                        <template #footer>
                                            <p></p>
                                        </template>
                                    </modal-notification>

                                    <template v-if="user.role === 2 && hasActiveRequest">
                                        <div
                                            class="col-12 col-xl-6 align-self-lg-center price__Button px-0 pt-3 pt-lg-0">
                                            <button :data-target="'#sb-active-request'" data-toggle="modal"
                                                    type="button"
                                                    class="button price__button rounded-0 button-fill shadow w-100">
                                                <p class="price__button__text w-100 text-start position-relative">
                                                    Запросить расчет
                                                </p>
                                            </button>
                                        </div>
                                    </template>

                                    <template v-if="user.role !== 3 && !hasActiveRequest">
                                        <div
                                            class="col-12 col-xl-6 align-self-lg-center price__Button px-0 pt-3 pt-lg-0">
                                            <button :data-target="user.role === 2 ? (!hasUserInfo ? '#sb-not-info'
                                            : (!hasUserPayment ? '#sb-not-payment' : '#sb-response-modal')) : '#sb-auth-users'"
                                                    data-toggle="modal" type="button"
                                                    class="button price__button rounded-0 button-fill shadow w-100">
                                                <p class="price__button__text w-100 text-start position-relative">
                                                    Запросить расчет
                                                </p>
                                            </button>
                                        </div>
                                    </template>

                                    <sb-response-modal :id-sport-object="Number(sportObject.id)"/>
                                </div>
                                <div class="sportInfrastructure borderBlockBottom px-lg-4 px-5 py-3">
                                    <div class="sportInfrastructure__title px-0 pb-3">
                                        <p class="fs-5 fw-bold">Спортивная инфраструктура</p>
                                    </div>
                                    <div class="sportInfrastructure__elements row row-cols-1 row-cols-lg-2 px-0 g-2">
                                        <div v-for="(item, index) in infoObject.infrastructures" :key="index"
                                             class="col el pb-0">
                                            <div class="borderblock h-100 px-2 justify-content-between d-flex fs-5 lh-1
                                                pb-2 pt-2">
                                                <div class="col d-inline-block title m-auto opacity-7">
                                                    {{ item.title }}
                                                </div>
                                                <div class="col-auto d-inline-block count m-auto">1</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sportTypes borderBlockBottom px-lg-4 px-5 py-3">
                                    <div class="sportTypes__title px-0 d-none d-lg-block pb-3">
                                        <p class="fs-5 fw-bold">Доступные виды спорта</p>
                                    </div>
                                    <div class="sportTypes__title mobile d-lg-none px-0 pb-3">
                                        <p class="fs-5 fw-bold">Виды спорта</p>
                                    </div>
                                    <div class="block__elements px-3 row g-2 sportTypes__elements">
                                        <div class="col-auto p-2 borderblock"
                                             v-for="(sport, index) in infoObject.sports">
                                            {{ sport.title }}
                                        </div>
                                    </div>
                                </div>
                                <div class="map pt-4">
                                    <div
                                        class=" px-lg-4 px-5 map__title px-0 d-flex d-lg-block pb-lg-4  justify-content-between">
                                        <p class=" map__title__text fs-5 fw-bold d-inline-block">Адрес и маршрут</p>
                                        <button
                                            class=" map__title__button bg-white px-2 py-1 px-lg-3 rounded borderblock">
                                            <svg width="11.438" height="11.438" viewBox="0 0 11.438 11.438">
                                                <g>
                                                    <path
                                                        d="M11.214.043a.408.408,0,0,0-.366,0h0L.227,5.354a.408.408,0,0,0,.109.767l4.215.767L5.318,11.1a.408.408,0,0,0,.344.331.4.4,0,0,0,.058,0,.409.409,0,0,0,.366-.226L11.4.591A.408.408,0,0,0,11.214.043Z"/>
                                                </g>
                                            </svg>
                                            К карте
                                        </button>
                                    </div>
                                    <div class=" px-lg-4 px-5 p-0 d-lg-none map__comment__country pb-4">
                                        <p class="op__comment__country__name country__name d-inline-block">
                                            {{ infoObject.country }} {{ infoObject.city }}</p>
                                    </div>
                                    <div class="map__map h-100 position-relative ">
                                        <yandex-map style="height:400px" :settings="settings"
                                                    :coords="[infoObject.latitude, infoObject.longtitude]"
                                                    :zoom="7" :dragable="false">
                                            <ymap-marker marker-type="placemark"
                                                         :coords="[infoObject.latitude, infoObject.longtitude]"
                                                         :markerId="1" :icon="customIcon"
                                                         :options="{draggable:false, iconShadow:true, iconShadowImageOffset:[2,-20],
                                                    iconShadowImageSize: [29, 7]}"/>
                                        </yandex-map>
                                    </div>
                                    <!--<div class="map__inform px-lg-4 px-5 pt-4">
                                        <p class="fs-5 stantion_distance pb-2 pb-lg-1">Дзержинск — 3 км</p>
                                        <p class="fs-5 vokzal_distance pb-2 pb-lg-1">Сочи — 40 км</p>
                                        <p class="fs-5 distance pb-2 pb-lg-1">Международного аэропорта Сочи — 68 км</p>
                                    </div>!-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <similiar-components :id="infoObject.id"></similiar-components>
                </div>
            </div>
        </div>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from './NavBar.vue';
import extendedinf from './ExtendedFooterInformation.vue';
import SimiliarComponents from "./SimiliarComponents";
import {mapActions} from 'vuex';
import carousel from 'vue-owl-carousel';
import 'owl.carousel/dist/assets/owl.carousel.css';
import {yandexMap, ymapMarker} from 'vue-yandex-maps';
import VueCompositionAPI from '@vue/composition-api';
import StarRating from 'vue-star-rating';
import Paginator from "./Paginator";
import Modal from "./elements/Modal";
import SbResponseModal from "./elements/SbResponseModal";
import axios from "axios";

Vue.use(VueCompositionAPI);

export default {
    props: {
        sportObject: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            isServiceVisible: false,
            isReviewsVisible: false,
            isInfrastructureVisible: false,
            isAboutVisible: true,
            favorites: [],
            loading: false,
            settings: this.$apiSettings.yandexMap,
            reviews: {
                data: [],
                currentPage: 1,
                perPage: 10,
                sort: 'new',
                loading: true,
                pagination: {}
            },
            selectedImage: '',
            hasUserPayment: false,
            hasUserInfo: false,
            customIcon: {
                layout: 'default#image',
                imageHref: '/icons/mapLabel.svg',
                imageSize: [94, 94],
                imageOffset: [-22, -55]
            },
            title_menu: 'Об объекте',
            blocks: [
                {
                    name: 'aboutObject',
                    title: 'Об объекте',
                    href: '#aboutObject',
                    handler: this.showAbout,
                    isActive: true
                },
                {
                    name: 'infrastructure',
                    title: 'Инфраструктура',
                    href: '#infrastructure',
                    handler: this.showInfrastructure,
                    isActive: false
                },
                {name: 'price', title: 'Условия и цены', href: '#price', handler: this.showService, isActive: false},
                {
                    name: 'reviews',
                    title: 'Отзывы и оценки',
                    href: '#reviews',
                    handler: this.showReviews,
                    isActive: false
                }
            ]
        };
    },
    components: {
        SbResponseModal,
        SimiliarComponents,
        navbar,
        extendedinf,
        carousel,
        yandexMap,
        ymapMarker,
        StarRating,
        Paginator,
        Modal
    },
    methods: {
        ...mapActions(["fetchDealsReviews"]),

        updateTitle(title) {
            this.title_menu = title;
        },

        isActiveBlock(blockName) {
            return this.blocks.some(block => block.name === blockName && block.isActive);
        },

        setActiveBlock(blockName) {
            this.blocks.forEach(block => {
                block.isActive = block.name === blockName;
            });
        },

        showAbout() {
            this.setActiveBlock('aboutObject');
        },
        showInfrastructure() {
            this.setActiveBlock('infrastructure');
        },
        showService() {
            this.setActiveBlock('price');
        },
        showReviews() {
            this.setActiveBlock('reviews');
            this.loadReviews();
        },

        authUser() {
            window.location.href = '/auth';
        },
        authRegister() {
            window.location.href = '/auth/registration';
        },

        addFavourite(object) {
            const index = this.favorites.findIndex(item => item.id === object.id);
            if (index !== -1) {
                this.favorites.splice(index, 1);
            } else {
                this.favorites.push(object);
            }
            localStorage.setItem('favorites', JSON.stringify(this.favorites));
        },
        isFavourite(object) {
            return this.favorites.some(item => item.id == object.id);
        },

        showPreview(index) {
            this.selectedImage = `/storage/listings/objects/${this.sportObject.id}/${this.sportObject.images[index]}`;
        },
        prevSlide() {
            this.$refs.carousel.prev();
        },
        nextSlide() {
            this.$refs.carousel.next();
        },

        getMinPrice(price) {
            return price.reduce((min, current) => current.minPrice < min.minPrice ? current : min).minPrice;
        },

        async loadReviews() {
            this.reviews.loading = true;
            const tempReviews = await this.$store.dispatch('fetchReviews', {
                sportObjectId: this.sportObject.id,
                sort: this.reviews.sort,
                limit: this.reviews.perPage,
                page: this.reviews.currentPage
            });
            this.reviews.data = tempReviews.data ?? [];
            this.reviews.pagination = tempReviews.pagination;
            this.reviews.loading = false;
        },
        async changePages(page) {
            this.reviews.currentPage = page;
            await this.loadReviews();
        },
        async changeColPages(limit) {
            this.reviews.perPage = limit;
            await this.loadReviews();
        },

        closeModalPayment() {
            $('#sb-not-payment').modal('hide');
        },
        fillPayment() {
            window.location.href = '/profile/payment';
        },
        fillInfo() {
            window.location.href = '/profile/settings';
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
        }
    },
    async mounted() {
        this.loading = true;
        await Promise.all([
            this.getHasUserPayment(),
            this.getHasUserInfo(),
        ]);
        const favorites = localStorage.getItem('favorites');
        if (favorites) {
            try {
                this.favorites = JSON.parse(favorites);
            } catch (e) {
                localStorage.removeItem('favorites');
            }
        }
        this.selectedImage = `/storage/listings/objects/${this.sportObject.id}/${this.sportObject.images[0]}`;
        this.loading = false;
    },
    computed: {
        user() {
            return window.user;
        },
        hasActiveRequest() {
            return this.sportObject.has_active_request;
        },
        sportObjectAverage() {
            if (Array.isArray(this.reviews.data) && this.reviews.data.length > 0) {
                const total = this.reviews.data.reduce((sum, review) => sum + review.average, 0);
                return Number((total / this.reviews.data.length).toFixed(2));
            }
            return 0;
        },
        infoObject() {
            if (this.sportObject.latitude && this.sportObject.longtitude) {
                return this.sportObject;
            }
            try {
                const address = `${this.sportObject.country} ${this.sportObject.city} ${this.sportObject.address}`;
                axios.get('/api/v1/get/coords', {params: {address: address.replace(/\s/g, '+')}})
                    .then(resp => {
                        const pos = resp.data.response.GeoObjectCollection.featureMember[0]['GeoObject']['Point']['pos'].split(' ');
                        this.sportObject.longtitude = parseFloat(pos[0]);
                        this.sportObject.latitude = parseFloat(pos[1]);
                    });
                return this.sportObject;
            } catch (error) {
                console.error('Error fetching coordinates:', error);
                return this.sportObject;
            }
        }
    },
    watch: {
        favorites: {
            handler(newValue) {
                localStorage.setItem('favorites', JSON.stringify(newValue));
            },
            deep: true
        },
        'reviews.sort': 'loadReviews'
    }
}
</script>


<style scoped lang="scss">
.nav_breadcrumb .breadcrumb {
    padding: 20px 0 !important;
    margin-bottom: 0;
}

.label-radio-wrapp__label {
    height: 55px;
    font-size: calc(1.2em);
}

.is-invalid {
    color: rgb(243, 122, 138) !important;
    border: 1px solid rgb(243, 122, 138) !important;
}

.wrapper .el__img {
    max-height: 145px;
    border-radius: 10px 10px 0 0;
}

.ymaps-2-1-79-map {
    height: 400px;
}

.ymaps-2-1-79-map.ymaps-2-1-79-i-ua_js_yes.ymaps-2-1-79-map-bg.ymaps-2-1-79-islets_map-lang-ru {
    height: 400px;
}

.view-object {
    &__information button.active {
        background-color: #6283e5 !important;
    }

    @media (max-width: 991.98px) {
        &__price-el {
            font-size: 15px;
        }
        &__type-el {
            font-size: 13px;
        }
    }
}

@media (max-width: 991.98px) {
    .middle__el {
        border-radius: 0;
    }
}

#overlay {
    z-index: 999;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.2);
}

.btn-no {
    color: #E45868;
    margin-left: 0.5rem;
}

.caption {
    color: #32325D;
    font-weight: bold;
    font-size: calc(1.25rem);
}

.item {
    margin-right: 15px;
}

.owl-carousel .owl-item img {
    height: 145px;
    object-fit: cover;
}

.slider-navigation {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.slider-navigation__prev,
.slider-navigation__next {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
}

.slider-navigation__prev i,
.slider-navigation__next i {
    margin: 0 8px;
}
</style>

<style lang="scss">
.borderblock-blue {
    border: 1px solid #6283E5;
}

.carousel-object .item {
    margin-right: 0 !important;
}

.carousel-object .owl-carousel .owl-nav {
    // z-index: -1 !important;
}

.carousel-object {
    .owl-carousel {
        position: relative;
    }

    .owl-custom {
        color: #FFF;
        font-size: 14px;
        padding: 4px 7px;
        background: #D6D6D6;
        display: inline-block;
        cursor: pointer;
        border-radius: 3px;
        position: absolute;
        top: 40%;
        z-index: 99;
    }

    .owl-custom-right {
        right: 0;
    }
}

.carousel-view-object {
    .owl-carousel {
        position: relative;
    }

    .owl-custom {
        color: #FFF;
        display: inline-block;
        cursor: pointer;
        position: absolute;
        top: 40%;
        z-index: 99;
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.6);
    }

    .owl-custom-right {
        right: 0;
    }
}

.aboutObject__about .content > p {
    font-size: 18px !important;
}

.carousel-view-object .owl-theme .owl-nav.disabled + .owl-dots {
    margin-top: 15px;
    margin-bottom: 15px;
}

.object-arrow[aria-expanded="true"] {
    transform: rotate(180deg);
}


.informationBlocks__content__block__price__el span {
    font-size: 18px !important;
}

@media (max-width: 991.98px) {
    .sb-content-object {
        margin: 0;

        .left {
            padding: 0;
        }
    }

    .sb-object__info {
        padding: 0;
    }
}
</style>
