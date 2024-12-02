<template>
    <div>

        <div id="cookie_notification" class="w-100">
            <div class="container position-relative ">
                <div class="cookie-notification__info-cookie d-flex align-items-center p-3">
                    <span class="d-flex cookie-notification__logo"><img src="/icons/cookie.svg" alt=""></span>
                    <p>Продолжая работу с сайтом, Вы разрешаете использование cookie-файлов. Вы всегда можете отключить
                        файлы cookie в настройках Вашего браузера.</p>
                    <button class="button cookie-notification__accept">Принять</button>
                    <span class="cookie-notification__close d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22.005" height="22.005"
                             viewBox="0 0 22.005 22.005">
                            <path id="cancel" d="M14.168,11.354a.486.486,0,0,1,0-.7L21.7,3.115a1.085,1.085,0,0,0,
                            .3-.7,1.085,1.085,0,0,0-.3-.7L20.3.3a1.085,1.085,0,0,0-.7-.3.912.912,0,0,0-.7.3L11.354,
                            7.837a.486.486,0,0,1-.7,0L3.115.3a1.085,1.085,0,0,0-.7-.3,1.085,1.085,0,0,0-.7.3L.3,
                            1.708a1.085,1.085,0,0,0-.3.7,1.085,1.085,0,0,0,.3.7l7.536,7.536a.486.486,0,0,1,0,.7L.3,
                            18.89A.971.971,0,0,0,.3,20.3L1.708,21.7a1.085,1.085,0,0,0,.7.3,1.085,1.085,0,0,0,
                            .7-.3l7.536-7.536a.486.486,0,0,1,.7,0L18.89,21.7a.971.971,0,0,0,1.407,
                            0L21.7,20.3a.971.971,0,0,0,0-1.407Z" fill="#7a4f08"/>
                        </svg>
                    </span>
                </div>

            </div>
        </div>

        <footer class="footer navbar p-0 flex-column">
            <div id="ww_cf927c74dfdee" v='1.3' loc='id' style="background: none;" class=""
                 a='{"t":"horizontal","lang":"ru","ids":[],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"image","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#81D4FA","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722"}'>
                Больше прогнозов: <a href="https://oneweather.org/tr/istanbul/15_days/" id="ww_cf927c74dfdee_u"
                                     target="_blank">15 gunluk hava durumu</a></div>

            <div class="footer-top container-fluid  py-4 py-lg-5 px-0 ">
                <a href="#" class=" d-lg-none m-auto">
                    <p>Спортбаза.РФ © 2024</p>
                </a>
                <div class="row container row-cols-4  mx-auto  d-none d-lg-flex text-start px-0">

                    <div class="col px-0">
                        <p class=" fs-3 fw-normal">СПОРТБАЗА<span class="span">.РФ</span></p>
                        <p class="opacity-5 fs-4 fw-bold">Единый реестр спортивной <br>
                            инфраструктуры</p>
                        <p class=" fs-3 fw-bold span pt-4"> 8 800 100-20-30</p>
                        <p>sportbasa@sport.ru</p>
                    </div>
                    <div class="col px-0">
                        <a class="nav-link px-0" href="/object-catalog">
                            <p>Каталог объектов {{ sport_objects_statistic.activeSportObjectsCount || "" }}</p>
                        </a>
                        <a class="nav-link px-0" href="/tender-catalog">
                            <p>Тендеры</p>
                        </a>
                        <a class="nav-link px-0" href="#">
                            <p>О проекте</p>
                        </a>
                        <a class="nav-link px-0" href="#">
                            <p>Клиенты и отзывы</p>
                        </a>
                    </div>
                    <div class="col ">
                        <a class="nav-link px-0" href="/news">
                            <p>Новости</p>
                        </a>
                        <a class="nav-link px-0" href="/contacts">
                            <p>Контакты</p>
                        </a>
                    </div>
                    <div class="col ">
                        <a class="nav-link px-0" href="#">
                            <p>Мы в соц.сетях</p>
                        </a>
                        <div class="socialButton row row-cols-auto pt-2">
                            <a href="#" class="col">
                                <div class="socialButton__facebook rounded d-inline-block text-center"><img
                                    src="/icons/facebookWhite.png" alt="F" class="w-auto h-auto align-text-top ">
                                </div>
                            </a>
                            <a href="#" class="col"><img src="/icons/odnoklassniki.svg" alt="O"
                                                         class="socialButton__odnoklassniki"></a>
                            <a href="#" class="col"><img src="/icons/instagram.png" alt="G"
                                                         class="socialButton__gmail"></a>
                            <a href="#" class="col"><img src="/icons/vk.svg" alt="VK"
                                                         class="socialButton__vk"></a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom container-fluid  py-4 py-lg-5 px-0">
                <div class="row container row-cols-1 row-cols-lg-4  mx-auto p-0">
                    <a href="#" class="col d-lg-flex d-none px-0 ">
                        <p> Спортбаза.РФ © 2022</p>
                    </a>
                    <a href="/terms" class="col d-lg-flex d-none px-0">
                        <p class="opacity-7">Правила пользования</p>
                    </a>
                    <a href="/terms" class="col d-lg-flex d-none px-0">
                        <p class="opacity-7">Правила платформы</p>
                    </a>
                    <a href="#" class="col d-lg-flex d-none px-0">
                        <p class="opacity-7">Политика конфиденциальности</p>
                    </a>
                    <p class="footer__comment  d-lg-none col px-0 ">"Искусство быть первыми"</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>

export default {
    data() {
        return {}
    },
    computed: {
        sport_objects_statistic() {
            return this.$store.getters.sport_objects_statistic;
        },
    },
    methods: {
        checkCookies() {
            let cookieDate = localStorage.getItem('cookieDate');
            let cookieNotification = document.getElementById('cookie_notification');
            let cookieBtn = cookieNotification.querySelector('.cookie-notification__accept');
            let cookieCloseBtn = cookieNotification.querySelector('.cookie-notification__close');

            if (!cookieDate || (+cookieDate + 31536000000) < Date.now()) {
                cookieNotification.classList.add('show');
            }
            cookieBtn.addEventListener('click', function () {
                localStorage.setItem('cookieDate', Date.now());
                cookieNotification.classList.remove('show');
            })
            cookieCloseBtn.addEventListener('click', function () {
                cookieNotification.classList.remove('show');
            })
        }
    },
    mounted() {
        this.checkCookies();
        this.$store.dispatch('getSportObjectsStatistic');
    }
}

</script>

<style scoped>
.cookie-notification__info-cookie {
    background-color: #FFCC75;
    border-radius: 5px;
}

.cookie-notification__info-cookie p {
    color: #7A4F08;
    font-size: 18px;
}

#cookie_notification {
    display: none;
    z-index: 100;
    position: fixed;
    bottom: 15px;
}

#cookie_notification.show {
    display: block;
}

.cookie-notification__logo {
    margin-right: 23px;
}

.cookie-notification__close {
    margin-left: 31px;
    cursor: pointer;
}

.cookie-notification__accept {
    height: 45px;
    margin-left: 20px;
    background-color: #FFFFFF;
    color: #D88800;
}

@media (max-width: 960px) {
    .cookie-notification__info-cookie p {
        font-size: 16px;
        margin-bottom: 15px;
    }

    .cookie-notification__info-cookie {
        flex-wrap: wrap;
        padding: 28px 23px 28px 23px !important;
    }

    .cookie-notification__logo {
        margin-bottom: 14px;
    }

    .cookie-notification__accept {
        margin-left: 0;
    }
}
</style>
