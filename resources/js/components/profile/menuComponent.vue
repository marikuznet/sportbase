<template>
    <header>
        <nav class="navbar navbar-expand-xl navbar-light pt-1 pb-0 menuAuthCompany Mobile d-lg-none">
            <div class="container">
                <ul class="navbar-nav nav navbar-collapse menuForExecutor">
                    <li v-if="showObjects" @click.prevent="showOrHideMenu"
                        v-bind:class="{ 'border__grey': showMenu }"
                        class="nav-item mx-auto d-lg-none d-flex" style="margin-left: 0 !important; cursor: pointer">
                        <a class="nav-link text-white">Спортивные объекты</a>
                        <img class="arrowDown" src="/icons/selectArowWhite.svg" alt="arrow">
                    </li>
                    <li v-if="showApplicationObjects" v-on:click.prevent="showOrHideMenu"
                        v-bind:class="{ 'border__grey': showMenu }"
                        class="nav-item mx-auto d-lg-none d-flex" style="margin-left: 0 !important; cursor: pointer">
                        <a class="nav-link text-white">Заявки на объекты</a>
                        <img class="arrowDown" src="/icons/selectArowWhite.svg" alt="arrow">
                    </li>
                    <li v-if="showResponsesTenders" v-on:click.prevent="showOrHideMenu"
                        v-bind:class="{ 'border__grey': showMenu }"
                        class="nav-item mx-auto d-lg-none d-flex" style="margin-left: 0 !important; cursor: pointer">
                        <a class="nav-link text-white">Отклики на тендеры</a>
                        <img class="arrowDown" src="/icons/selectArowWhite.svg" alt="arrow">
                    </li>
                    <li v-if="showOrders" v-on:click.prevent="showOrHideMenu"
                        v-bind:class="{ 'border__grey': showMenu }"
                        class="nav-item mx-auto d-lg-none d-flex" style="margin-left: 0 !important; cursor: pointer">
                        <a class="nav-link text-white">Заказы и оплаты</a>
                        <img class="arrowDown" src="/icons/selectArowWhite.svg" alt="arrow">
                    </li>
                    <li v-if="showSettings" v-on:click.prevent="showOrHideMenu"
                        v-bind:class="{ 'border__grey': showMenu }"
                        class="nav-item mx-auto d-lg-none d-flex" style="margin-left: 0 !important; cursor: pointer">
                        <a class="nav-link text-white settingsIcon" href="/profile/settings">
                            <img style="width: 20px" src="/icons/settings/settingsWhite.svg" alt="">
                            <img src="/icons/selectArowWhite.svg" alt="arrow" class="arrowDown">
                        </a>
                    </li>


                    <div class="menuAction" style="width: 100%;" v-if="showMenu">
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto" v-if="!showObjects"><a
                            class="nav-link text-white" href="/sport-objects">Спортивные объекты</a></li>
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/messages">Сообщения</a>
                        </li>
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto"
                            v-if="!showApplicationObjects">
                            <a class="nav-link text-white" href="/rental-requests">Заявки на объекты</a>
                        </li>
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto"
                            v-if="!showResponsesTenders"><a
                            class="nav-link text-white" href="/tender-responses">Отклики на тендеры</a></li>
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto"><a
                            class="nav-link text-white" v-if="!showReviews" href="/reviews">Отзывы о сотрудничестве</a>
                        </li>
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto" v-if="!showOrders"><a
                            class="nav-link text-white" href="/orders-and-payments">Заказы и оплаты</a></li>
                        <li :class="{ 'is-active': activeSettings, 'border__grey': showMenu }"
                            class="nav-item mx-auto">
                            <a class="nav-link text-white settingsIcon" href="/profile/settings">
                                <img style="width: 20px" src="/icons/settings/settingsWhite.svg" alt="">
                            </a>
                        </li>
                        <li class="nav-item mr-0 mx-auto ">
                            <a class="nav-link text-white exitIcon" href="/auth/logout">
                                <img style="width: 20px" src="/icons/settings/exitWhite.svg" alt="">
                            </a>
                        </li>
                    </div>
                    <span class="nav-indicator"></span>
                </ul>
            </div>
        </nav>

        <!--ВЕРСИЯ ДЛЯ ПК*!-->
        <nav class="navbar navbar-expand-xl navbar-light pt-1 pb-0 menuAuthCompany PC d-none d-lg-block">
            <div class="container">
                <ul class="navbar-nav nav navbar-collapse menuForExecutor">
                    <div class="menuAction pt-2 pb-2" style="width: 100%;">
                        <li class="nav-item mx-auto" :class="{ 'active-border': showObjects }">
                            <a class="nav-link text-white" href="/sport-objects">Спортивные объекты</a>
                        </li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-white" :class="{ 'active-border': showMessage }" href="/messages">Сообщения</a>
                        </li>
                        <li class="nav-item mx-auto" :class="{ 'active-border': showApplicationObjects }"><a
                            class="nav-link text-white" href="/rental-requests">Заявки на объекты</a></li>
                        <li class="nav-item mx-auto"><a
                            class="nav-link text-white" :class="{ 'active-border': showResponsesTenders }"
                            href="/tender-responses">Отклики на тендеры</a></li>
                        <li class="nav-item mx-auto"><a class="nav-link text-white"
                                                        :class="{ 'active-border': showReviews }" href="/reviews">
                            Отзывы о сотрудничестве</a>
                        </li>
                        <li class="nav-item mx-auto"><a
                            class="nav-link text-white" :class="{ 'active-border': showOrders }"
                            href="/orders-and-payments">Заказы и оплаты</a></li>
                        <li v-bind:class="{ 'is-active': activeSettings, 'border__grey': showMenu, 'active-border': showSettings }"
                            class="nav-item mx-auto">
                            <a href="/profile/settings" class="nav-link text-white settingsIcon">
                                <img style="width: 20px" src="/icons/settings/settingsWhite.svg" alt=""></a>
                        </li>
                        <li class="nav-item mr-0 mx-auto "><a class="nav-link text-white exitIcon" href="/auth/logout">
                            <img style="width: 20px" src="/icons/settings/exitWhite.svg" alt="">
                        </a></li>
                    </div>
                    <span class="nav-indicator"></span>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    props: ['active'],
    data: function () {
        return {
            activeSettings: false,
            showMenu: false,
            showObjects: false,
            showApplicationObjects: false,
            showResponsesTenders: false,
            showOrders: false,
            showTender: false,
            showSettings: false,
            showMessage: false,
            showReviews: false,
        }
    },
    methods: {
        showOrHideMenu() {
            this.showMenu = !this.showMenu;
        },
        isActive() {
            if (this.active == 0) {
                this.showObjects = true;
            }
            if (this.active == 1) {
                this.showMessage = true;
            }
            if (this.active == 2) {
                this.showApplicationObjects = true;
            }
            if (this.active == 3) {
                this.showResponsesTenders = true;
            }
            if (this.active == 4) {
                this.showReviews = true;
            }
            if (this.active == 5) {
                this.showOrders = true;
            }
            if (this.active == 6) {
                this.showSettings = true;
            }
        }
    },
    mounted() {
        this.isActive();
    }
}
</script>

<style>
</style>
