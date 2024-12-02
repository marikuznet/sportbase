<template>
    <header class="navMenu px-5">

        <!-- меню для исполнителей  !-->
        <template v-if="user.role === 3">
            <nav class="navbar navbar-expand-xl navbar-light d-none d-lg-block">
                <div class="container">
                    <a class="navbar-brand mx-auto pr-lg-4" href="/">
                        <div class="navbar-brand__logo">СПОРТБАЗА<span>.РФ</span></div>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseDataMenu"
                            aria-controls="collapseDataMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="collapseDataMenu">
                        <ul class="navbar-nav nav gap-4">
                            <li class="nav-item mx-auto"><a class="nav-link text-white" href="/object-catalog">Каталог
                                объектов {{ sport_objects_statistic.activeSportObjectsCount }}</a></li>
                            <li class="nav-item mx-auto"><a class="nav-link text-white"
                                                            href="/tender-catalog">Тендеры</a>
                            </li>
                            <span class="nav-indicator"></span>
                        </ul>
                        <div class="navbar-buttons">
                            <a href="/favorites-objects" type="submit" class="button button-icon active">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21.412" height="19.897"
                                     viewBox="0 0 21.412 19.897">
                                    <path id="Контур_44609" data-name="Контур 44609"
                                          d="M19.661,18.767a5.851,5.851,0,0,0-8.575,0l-.378.4-.378-.4a5.855,5.855,0,0,0-8.274-.3q-.157.146-.3.3a6.567,6.567,0,0,0,0,8.929l8.4,8.859a.765.765,0,0,0,1.082.029l.029-.029,8.4-8.859A6.566,6.566,0,0,0,19.661,18.767Zm-1.107,7.874h0l-7.845,8.275L2.862,26.641a5.018,5.018,0,0,1,0-6.822,4.325,4.325,0,0,1,6.112-.246q.128.118.246.246l.933.984a.788.788,0,0,0,1.111,0l.933-.983a4.325,4.325,0,0,1,6.112-.246q.128.118.246.246A4.972,4.972,0,0,1,18.554,26.641Z"
                                          transform="translate(0 -16.896)" fill="#fff"/>
                                </svg>
                                <!--<div class="notification-block">
                                  2
                                </div>!-->
                            </a>
                            <a href="/messages" type="button" class="button button-icon active">
                                <svg id="email" xmlns="http://www.w3.org/2000/svg" width="20.76" height="15.206"
                                     viewBox="0 0 20.76 15.206">
                                    <path id="Контур_44478" data-name="Контур 44478"
                                          d="M18.136,24.61H2.624A2.627,2.627,0,0,0,0,27.234v9.959a2.627,2.627,0,0,0,2.624,2.624H18.136a2.627,2.627,0,0,0,2.624-2.624V27.234A2.627,2.627,0,0,0,18.136,24.61Zm-.41,1.692L10.38,31.977,3.033,26.3Zm.41,11.822H2.624a.932.932,0,0,1-.931-.931V27.4l8.17,6.311a.846.846,0,0,0,1.035,0l8.17-6.311v9.788A.932.932,0,0,1,18.136,38.124Z"
                                          transform="translate(0 -24.61)" fill="#fff"/>
                                </svg>
                                <div class="notification-block" v-if="unread_messages_count.count_messages > 0">
                                    {{ unread_messages_count.count_messages }}
                                </div>
                            </a>
                            <a @click="addObject" href="#" class="button" style="color: white !important;">
                                Добавить объект</a>
                            <div class="block-name-company">
                                <div class="block-name-company__photo">
                                    <img v-show="!logo" src="/images/default/user.png" alt="user">
                                    <img v-show="logo" :src="this.logoCompany" class="w-100 h-100" alt="user">
                                </div>

                                {{ titleCompany ? titleCompany : 'Название компании' }}
                            </div>
                            <button type="button" class="button button-toggle" @click="setActive">
                                <span></span>
                                <div class="button-toggle__data user-menu" v-if="buttonActive" @mouseleave="mouseLeave">
                                    <header class="user-menu__head head">
                                        <div class="wrapp-company">
                                            <div class="user-menu__user-photo">
                                                <img v-show="!logo" src="/images/default/user.png" alt="user">
                                                <img v-show="logo" :src="this.logoCompany" class="w-100 h-100"
                                                     alt="user">
                                            </div>
                                            {{ titleCompany ? titleCompany : 'Название компании' }}
                                        </div>
                                        <div class="user-menu__button-close"><span></span></div>
                                    </header>
                                    <main class="user-menu__content content">
                                        <div class="block-balance row">
                                            <div class="block-balance__label col" style="text-align: start">Баланс</div>
                                            <div class="block-balance__value col">{{ Number(sumPayment).toFixed(2) }}
                                                руб
                                            </div>
                                        </div>
                                        <a href="/sport-objects" class="content__item">Спортивные объекты
                                            <b>{{ sport_objects_statistic.mySportObjectsCount }}</b>
                                        </a>
                                        <a href="/rental-requests" class="content__item">Заявки на объекты</a>
                                        <a href="/tender-responses" class="content__item">Отклики на тендеры</a>
                                        <a href="/reviews" class="content__item">Отзывы о сотрудничестве</a>
                                        <a href="/orders-and-payments" class="content__item">Заказы и оплаты</a>
                                        <a href="/profile/settings" class="content__item">Профиль и настройки</a>
                                    </main>
                                    <footer class="user-menu__footer footer">
                                        <a href="/auth/logout" class="footer__item">Выйти из аккаунта</a>
                                    </footer>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>
        </template>

        <!-- меню для заказчиков !-->
        <nav class="navbar navbar-expand-xl navbar-light d-none d-lg-block" v-if="user.role === 2">
            <div class="container">
                <a class="navbar-brand mx-auto pr-4" href="/">
                    <div class="navbar-brand__logo">СПОРТБАЗА<span>.РФ</span></div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseDataMenu"
                        aria-controls="collapseDataMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="collapseDataMenu">
                    <ul class="navbar-nav nav">
                        <li class="nav-item mx-auto pr-4"><a class="nav-link text-white" href="/object-catalog">Каталог
                            объектов {{ sport_objects_statistic.activeSportObjectsCount || "" }} </a></li>
                        <li class="nav-item mx-auto"><a class="nav-link text-white" href="/tender-catalog">Тендеры</a>
                        </li>
                        <span class="nav-indicator"></span>
                    </ul>
                    <div class="navbar-buttons">
                        <a href="/favorites-objects" type="submit" class="button button-icon active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21.412" height="19.897"
                                 viewBox="0 0 21.412 19.897">
                                <path id="Контур_44609" data-name="Контур 44609"
                                      d="M19.661,18.767a5.851,5.851,0,0,0-8.575,0l-.378.4-.378-.4a5.855,5.855,0,0,0-8.274-.3q-.157.146-.3.3a6.567,6.567,0,0,0,0,8.929l8.4,8.859a.765.765,0,0,0,1.082.029l.029-.029,8.4-8.859A6.566,6.566,0,0,0,19.661,18.767Zm-1.107,7.874h0l-7.845,8.275L2.862,26.641a5.018,5.018,0,0,1,0-6.822,4.325,4.325,0,0,1,6.112-.246q.128.118.246.246l.933.984a.788.788,0,0,0,1.111,0l.933-.983a4.325,4.325,0,0,1,6.112-.246q.128.118.246.246A4.972,4.972,0,0,1,18.554,26.641Z"
                                      transform="translate(0 -16.896)" fill="#fff"/>
                            </svg>
                            <!--<div class="notification-block">
                              2
                            </div>!-->
                        </a>
                        <a href="/messages" type="button" class="button button-icon active">
                            <svg id="email" xmlns="http://www.w3.org/2000/svg" width="20.76" height="15.206"
                                 viewBox="0 0 20.76 15.206">
                                <path id="Контур_44478" data-name="Контур 44478"
                                      d="M18.136,24.61H2.624A2.627,2.627,0,0,0,0,27.234v9.959a2.627,2.627,0,0,0,2.624,2.624H18.136a2.627,2.627,0,0,0,2.624-2.624V27.234A2.627,2.627,0,0,0,18.136,24.61Zm-.41,1.692L10.38,31.977,3.033,26.3Zm.41,11.822H2.624a.932.932,0,0,1-.931-.931V27.4l8.17,6.311a.846.846,0,0,0,1.035,0l8.17-6.311v9.788A.932.932,0,0,1,18.136,38.124Z"
                                      transform="translate(0 -24.61)" fill="#fff"/>
                            </svg>
                            <div class="notification-block" v-if="unread_messages_count.count_messages > 0">
                                {{ unread_messages_count.count_messages }}
                            </div>
                        </a>
                        <a href="/create/tender" class="button button-borderWhite" style="color: white !important;">Заявка
                            на тендер</a>
                        <div class="block-name-company">
                            <div class="block-name-company__photo">
                                <img v-show="!logo" src="/images/default/user.png" alt="user">
                                <img v-show="logo" :src="this.logoCompany" class="w-100 h-100" alt="user">
                            </div>
                            {{ titleCompany ? titleCompany : 'Название компании' }}
                        </div>
                        <button type="button" class="button button-toggle" @click="setActive">
                            <span></span>
                            <div class="button-toggle__data user-menu" v-if="buttonActive" @mouseleave="mouseLeave">
                                <header class="user-menu__head head">
                                    <div class="wrapp-company">
                                        <div class="user-menu__user-photo">
                                            <img v-show="!logo" src="/images/default/user.png" alt="user">
                                            <img v-show="logo" :src="this.logoCompany" class="w-100 h-100" alt="user">
                                        </div>
                                        {{ titleCompany ? titleCompany : 'Название компании' }}
                                    </div>
                                    <div class="user-menu__button-close"><span></span></div>
                                </header>
                                <main class="user-menu__content content">
                                    <a href="/tenders/my-tenders" class="content__item">Мои тендеры</a>
                                    <a href="/my-rental-requests" class="content__item">Заявки на объекты</a>
                                    <a href="/reviews" class="content__item">Отзывы об объектах</a>
                                    <a href="/orders-and-payments" class="content__item">Заказы и оплаты</a>
                                    <a href="/profile/settings" class="content__item">Профиль и настройки</a>
                                </main>
                                <footer class="user-menu__footer footer">
                                    <a href="/auth/logout" class="footer__item">Выйти из аккаунта</a>
                                </footer>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <nav v-if="user.role === 2 || user.role === 3"
             class="navbar navbar-expand-xl navbar-light d-block d-lg-none mobileNav">
            <div class="align-items-center container">
                <a class="navbar-brand" href="/">
                    <div class="navbar-brand__logo">СПОРТБАЗА<span>.РФ</span></div>
                </a>
                <button @click="closeMenu" class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#collapseNavAuth"
                        aria-controls="collapseNavAuth" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div v-show="menuShow" class="collapse navbar-collapse justify-content-between w-100"
                     id="collapseNavAuth">
                    <div class="d-flex">
                        <form action="/auth" class="pb-3 flex-fill">
                            <button type="submit" class="button button-fill d-flex justify-content-center"
                                    style="height: 45px; border-radius: 0">
                                <div class="block-name-company__photo">
                                    <img v-show="!logo" src="/images/default/user.png" alt="user">
                                    <img v-show="logo" :src="this.logoCompany" class="w-100 h-100" alt="user">
                                </div>
                                {{ titleCompany ? titleCompany : 'Название компании' }}
                            </button>
                        </form>
                    </div>
                    <div class="d-flex mb-3">
                        <a href="/favorites-objects" type="submit" class="button button-icon active"
                           style="height: 45px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21.412" height="19.897"
                                 viewBox="0 0 21.412 19.897">
                                <path id="Контур_44609" data-name="Контур 44609"
                                      d="M19.661,18.767a5.851,5.851,0,0,0-8.575,0l-.378.4-.378-.4a5.855,5.855,0,0,0-8.274-.3q-.157.146-.3.3a6.567,6.567,0,0,0,0,8.929l8.4,8.859a.765.765,0,0,0,1.082.029l.029-.029,8.4-8.859A6.566,6.566,0,0,0,19.661,18.767Zm-1.107,7.874h0l-7.845,8.275L2.862,26.641a5.018,5.018,0,0,1,0-6.822,4.325,4.325,0,0,1,6.112-.246q.128.118.246.246l.933.984a.788.788,0,0,0,1.111,0l.933-.983a4.325,4.325,0,0,1,6.112-.246q.128.118.246.246A4.972,4.972,0,0,1,18.554,26.641Z"
                                      transform="translate(0 -16.896)" fill="#fff"/>
                            </svg>
                            <!--<div class="notification-block">
                              2
                            </div>!-->
                        </a>
                        <a href="/messages" type="button" class="button button-icon active" style="height: 45px">
                            <svg id="email" xmlns="http://www.w3.org/2000/svg" width="20.76" height="15.206"
                                 viewBox="0 0 20.76 15.206">
                                <path id="Контур_44478" data-name="Контур 44478"
                                      d="M18.136,24.61H2.624A2.627,2.627,0,0,0,0,27.234v9.959a2.627,2.627,0,0,0,2.624,2.624H18.136a2.627,2.627,0,0,0,2.624-2.624V27.234A2.627,2.627,0,0,0,18.136,24.61Zm-.41,1.692L10.38,31.977,3.033,26.3Zm.41,11.822H2.624a.932.932,0,0,1-.931-.931V27.4l8.17,6.311a.846.846,0,0,0,1.035,0l8.17-6.311v9.788A.932.932,0,0,1,18.136,38.124Z"
                                      transform="translate(0 -24.61)" fill="#fff"/>
                            </svg>
                            <div class="notification-block" v-if="unread_messages_count.count_messages > 0">
                                {{ unread_messages_count.count_messages }}
                            </div>
                        </a>
                    </div>

                    <ul class="navbar-nav nav">
                        <!--is-active!-->
                        <li v-if="user.role === 3" class="nav-item ">
                            <div class="align-items-center block-balance btn btn-light d-flex gap-2"
                                 style="height: 45px">
                                <div class="block-balance__label" style="text-align: start">Баланс</div>
                                <div class="block-balance__value">{{ Number(sumPayment).toFixed(2) }}
                                    руб
                                </div>
                            </div>
                        </li>
                        <li class="nav-item "><a class="nav-link text-white" href="/object-catalog">Каталог
                            объектов</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/tender-catalog">Тендеры</a></li>
                        <span class="nav-indicator"></span>
                    </ul>
                </div>
            </div>
        </nav>

        <nav class="navbar navbar-expand-xl navbar-light" v-if="user.role === 1">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <div class="navbar-brand__logo">СПОРТБАЗА<span>.РФ</span></div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseDataMenu"
                        aria-controls="collapseDataMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="collapseDataMenu">
                    <ul class="navbar-nav nav">
                        <!--is-active!-->
                        <li class="nav-item "><a class="nav-link text-white" href="/object-catalog">Каталог
                            объектов {{ sport_objects_statistic.activeSportObjectsCount || "" }}</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/tender-catalog">Тендеры</a></li>
                        <span class="nav-indicator"></span>
                    </ul>
                    <div class="navbar-buttons">
                        <div class="wrapp-buttons">
                            <form action="/favorites-objects">
                                <button type="submit" class="button button-icon">
                                    <svg data-name="Сгруппировать 7060" xmlns="http://www.w3.org/2000/svg"
                                         width="21.412" height="19.897" viewBox="0 0 21.412 19.897">
                                        <path id="Контур_44609" data-name="Контур 44609"
                                              d="M19.661,18.767a5.851,5.851,0,0,0-8.575,0l-.378.4-.378-.4a5.855,5.855,0,0,0-8.274-.3q-.157.146-.3.3a6.567,6.567,0,0,0,0,8.929l8.4,8.859a.765.765,0,0,0,1.082.029l.029-.029,8.4-8.859A6.566,6.566,0,0,0,19.661,18.767Zm-1.107,7.874h0l-7.845,8.275L2.862,26.641a5.018,5.018,0,0,1,0-6.822,4.325,4.325,0,0,1,6.112-.246q.128.118.246.246l.933.984a.788.788,0,0,0,1.111,0l.933-.983a4.325,4.325,0,0,1,6.112-.246q.128.118.246.246A4.972,4.972,0,0,1,18.554,26.641Z"
                                              transform="translate(0 -16.896)" fill="#fff"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <form style="margin-left: 10px" action="/auth/logout">
                            <button type="submit" class="button button-fill">Выйти</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <nav class="navbar navbar-expand-xl navbar-light d-lg-block d-none" v-if="show">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <div class="navbar-brand__logo">СПОРТБАЗА<span>.РФ</span></div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseDataMenu"
                        aria-controls="collapseDataMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="collapseDataMenu">
                    <ul class="navbar-nav nav">
                        <!--is-active!-->
                        <li class="nav-item "><a class="nav-link text-white" href="/object-catalog">Каталог
                            объектов {{ sport_objects_statistic.activeSportObjectsCount || "" }}</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/tender-catalog">Тендеры</a></li>
                        <span class="nav-indicator"></span>
                    </ul>
                    <div class="navbar-buttons">
                        <div class="wrapp-buttons">
                            <form action="/favorites-objects">
                                <button type="submit" class="button button-icon h-100">
                                    <svg data-name="Сгруппировать 7060" xmlns="http://www.w3.org/2000/svg"
                                         width="21.412"
                                         height="19.897"
                                         viewBox="0 0 21.412 19.897">
                                        <path id="Контур_44609" data-name="Контур 44609"
                                              d="M19.661,18.767a5.851,5.851,0,0,0-8.575,0l-.378.4-.378-.4a5.855,5.855,0,0,0-8.274-.3q-.157.146-.3.3a6.567,6.567,0,0,0,0,8.929l8.4,8.859a.765.765,0,0,0,1.082.029l.029-.029,8.4-8.859A6.566,6.566,0,0,0,19.661,18.767Zm-1.107,7.874h0l-7.845,8.275L2.862,26.641a5.018,5.018,0,0,1,0-6.822,4.325,4.325,0,0,1,6.112-.246q.128.118.246.246l.933.984a.788.788,0,0,0,1.111,0l.933-.983a4.325,4.325,0,0,1,6.112-.246q.128.118.246.246A4.972,4.972,0,0,1,18.554,26.641Z"
                                              transform="translate(0 -16.896)" fill="#fff"/>
                                    </svg>
                                </button>
                            </form>
                            <form class="middle" style="margin-left: 10px;" action="/create/tender">
                                <button type="submit" class="button button-borderWhite">Заявка на тендер</button>
                            </form>
                        </div>
                        <form style="margin-left: 10px" action="/auth">
                            <button type="submit" class="button button-fill">Войти</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <nav class="navbar navbar-expand-xl navbar-light d-block d-lg-none mobileNav" v-if="show">
            <div class="align-items-center container">
                <a class="navbar-brand" href="/">
                    <div class="navbar-brand__logo">СПОРТБАЗА<span>.РФ</span></div>
                </a>
                <button @click="closeMenu" class="" type="button" data-toggle="collapse"
                        data-target="#collapseNavAuth" aria-controls="collapseNavAuth" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div v-show="menuShow" class="collapse navbar-collapse justify-content-between" id="collapseNavAuth">
                    <form action="/auth" class="pb-3">
                        <button type="submit" class="button button-fill d-flex justify-content-center"
                                style="width: 170px; height: 45px; border-radius: 0">
                            Авторизация
                        </button>
                    </form>
                    <div class="select-wrapper">
                        <v-select class="selectpicker" labelTitle="Москва"></v-select>
                    </div>
                    <ul class="navbar-nav nav mt-4">
                        <!--is-active!-->
                        <li class="nav-item "><a class="nav-link text-white" href="#">Об организации</a></li>
                        <li class="nav-item "><a class="nav-link text-white" href="/object-catalog">Каталог
                            объектов</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/tender-catalog">Тендеры</a></li>
                        <li class="nav-item "><a class="nav-link text-white" href="#">Контакты</a></li>
                        <li class="nav-item "><a class="nav-link text-white" href="#">Правила платформы</a></li>
                        <li class="nav-item "><a class="nav-link text-white" href="#">Пользовательское соглашение</a>
                        </li>
                        <li class="nav-item "><a class="nav-link text-white" href="#">Политика конфиденциальности</a>
                        </li>
                        <span class="nav-indicator"></span>
                    </ul>
                </div>
            </div>
        </nav>

    </header>
</template>

<script>
import VSelect from '@alfsnd/vue-bootstrap-select';
import {mapActions, mapGetters, mapState} from "vuex";
import eventBus from '../event-bus';

export default {
    data() {
        return {
            showDropdown: false, screenWidth: null, auth: null, buttonActive: false, show: false, menuShow: false,
            favorites: [], sumPayment: null
        }
    },
    components: {
        VSelect,
    },
    mounted() {
        if (user)
            this.$store.dispatch('fetchInfoCompanies')
    },
    computed: {
        ...mapState({info_companies: 'info_companies'}),
        ...mapGetters({
            infoCompanies: 'AllInfoCompanies', titleCompany: 'TitleCompany', logo: 'LogoCompany',
        }),
        user: function () {
            return window.user;
        },
        logoCompany() {
            return '/storage/listings/logos/' + this.user.id + '/' + this.logo;
        },
        sport_objects_statistic() {
            return this.$store.getters.sport_objects_statistic;
        },
        unread_messages_count() {
            return this.$store.getters.messages_unread;
        }
    },
    methods: {
        getWidthScreen() {
            this.screenWidth = window.innerWidth;
        },
        setActive() {
            this.buttonActive = !this.buttonActive;
        },
        mouseLeave() {
            this.buttonActive = !this.buttonActive;
        },
        closeMenu() {
            this.menuShow = !this.menuShow;
        },
        addObject() {
            eventBus.$emit('create-object')
            window.location.href = '/sport-objects/create';
        }
    },
    created() {
        window.addEventListener('resize', this.getWidthScreen);
        this.getWidthScreen();

        this.$store.dispatch('getSportObjectsStatistic');

        if (!this.user) {
            this.show = true;
        }

        if (this.user && this.user.role === 3) {
            this.$store.dispatch("getBalanceExecutor").then(result => {
                this.sumPayment = result;
            })
        }

        this.$store.dispatch('getStatisticMessages');

        Echo.private(`messages.${this.user.id}`).listen('.message-send-event', (e) => {
            this.$store.dispatch('getStatisticMessages');
        })
    },
}
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to

    /* .fade-leave-active до версии 2.1.8 */
{
    opacity: 0;
}

.mobileNav .selectpicker {
    width: 170px !important;
}

.mobileNav .v-select-toggle {
    background-color: transparent !important;
    color: white !important;
    border: 1px solid lightgray !important;
    width: 170px;
    border-radius: 0 !important;
}


</style>
