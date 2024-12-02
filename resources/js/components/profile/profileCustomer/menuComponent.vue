<template>
    <header>
        <nav class="navbar navbar-expand-xl navbar-light pt-1 pb-0 menuAuthCompany Mobile d-lg-none">
            <div class="container">
                <ul class="navbar-nav nav navbar-collapse menuForExecutor">
                    <li v-if="showObjects" v-on:click.prevent="showOrHideMenu"
                        v-bind:class="{ 'border__grey': showMenu }"
                        class="nav-item mx-auto d-lg-none d-flex" style="margin-left: 0 !important; cursor: pointer">
                        <a class="nav-link text-white">Заявки на объекты</a>
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
                    <li v-if="showTender" v-on:click.prevent="showOrHideMenu"
                        v-bind:class="{ 'border__grey': showMenu }"
                        class="nav-item mx-auto d-lg-none d-flex" style="margin-left: 0 !important; cursor: pointer">
                        <a class="nav-link text-white">Мои тендеры</a>
                        <img class="arrowDown" src="/icons/selectArowWhite.svg" alt="arrow">
                    </li>
                    <li v-if="showOrders" v-on:click.prevent="showOrHideMenu"
                        :class="{ 'border__grey': showMenu }"
                        class="nav-item mx-auto d-lg-none d-flex" style="margin-left: 0 !important; cursor: pointer">
                        <a class="nav-link text-white" href="/orders-and-payments">Заказы и оплаты</a>
                        <img class="arrowDown" src="/icons/selectArowWhite.svg" alt="arrow">
                    </li>
                    <li v-if="showReviews" v-on:click.prevent="showOrHideMenu"
                        :class="{ 'border__grey': showMenu }"
                        class="nav-item mx-auto d-lg-none d-flex" style="margin-left: 0 !important; cursor: pointer">
                        <a class="nav-link text-white" href="/reviews">Отзывы об объектах</a>
                        <img class="arrowDown" src="/icons/selectArowWhite.svg" alt="arrow">
                    </li>

                    <div class="menuAction" style="width: 100%;" v-if="showMenu">
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto" v-if="!showObjects"><a
                            class="nav-link text-white" href="/my-rental-requests">Заявки на объекты</a></li>
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto"><a
                            class="nav-link text-white" href="#">Сообщения</a></li>
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto" v-if="!showTender"><a
                            class="nav-link text-white" href="/tenders/my-tenders">
                            Мои тендеры</a></li>
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto" v-if="!showReviews"><a
                            class="nav-link text-white" href="/reviews">Отзывы об объектах</a></li>
                        <li :class="{ 'border__grey': showMenu }" class="nav-item mx-auto" v-if="!showOrders"><a
                            class="nav-link text-white" href="/orders-and-payments">Заказы и
                            оплаты</a></li>
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
                        <li class="nav-item mx-auto" :class="{ 'active-border': showObjects }"><a
                            class="nav-link text-white" href="/my-rental-requests">Заявки на объекты</a></li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/messages" :class="{ 'active-border': showMessages }">
                                Сообщения
                            </a>
                        </li>
                        <li class="nav-item mx-auto" :class="{ 'active-border': showTender }">
                            <a class="nav-link text-white" href="/tenders/my-tenders">
                                Мои тендеры
                            </a>
                        </li>
                        <li class="nav-item mx-auto" :class="{ 'active-border': showReviews }">
                            <a class="nav-link text-white" href="/reviews">
                                Отзывы об объектах
                            </a>
                        </li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/orders-and-payments"
                               :class="{ 'active-border': showOrders }">
                                Заказы и оплаты
                            </a>
                        </li>
                        <li v-bind:class="{ 'is-active': activeSettings, 'border__grey': showMenu, 'active-border': showSettings }"
                            class="nav-item mx-auto">
                            <a href="/profile/settings" class="nav-link text-white settingsIcon">
                                <img style="width: 20px" src="/icons/settings/settingsWhite.svg" alt="">
                            </a></li>
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
            showMessages: false,
            showTender: false,
            showOrders: false,
            showReviews: false,
            showSettings: false,
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
                this.showMessages = true;
            }
            if (this.active == 2) {
                this.showTender = true;
            }
            if (this.active == 5) {
                this.showOrders = true;
            }
            if (this.active == 3) {
                this.showReviews = true;
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
