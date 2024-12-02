<template>
    <div>
        <navbar></navbar>
        <div class="sb-error position-relative h-100">
            <div class="sb-error__image h-100"></div>
            <div class="sb-error__banner-gradient"></div>
            <div class="sb-error__block position-absolute d-flex justify-content-center align-items-center w-100 h-100">
                <div class="sb-error__data position-absolute text-center w-100">
                    <div class="sb-data__number d-inline-flex align-items-center">
                        <div class="sb-number">4</div>
                        <div class="align-items-center d-flex p sb-number__image">
                            <img src="/icons/ball.png" alt="ball">
                        </div>
                        <div class="sb-number">4</div>
                    </div>
                    <div class="sb-data__description">
                        Увы, данной страницы не существует, но вы всегда можете посмотреть на нашу огромную
                        базу спортивных объектов!
                    </div>
                    <div class="d-flex justify-content-center sb-data__view-objects-btn">
                        <a href="/object-catalog"
                           class="sb-view-objects-btn button button-fill d-flex justify-content-between">
                            <div class="button__wrapp-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32.546" height="32.546"
                                     viewBox="0 0 32.546 32.546">
                                    <path id="Контур_44545" data-name="Контур 44545"
                                          d="M16.273,0a16.14,16.14,0,0,0-5.386.936.1.1,0,0,0-.026.01,16.314,16.314,0,0,0-7.6,5.594s-.006.008-.01.014A16.252,16.252,0,1,0,16.273,0ZM28.927,9.774A14.134,14.134,0,0,1,30.406,14.6l-2.042-2.229Zm-1.56-2.4-1,4.6-3.192,1.562-5.87-4.278V5.289l4.184-2.25A14.253,14.253,0,0,1,27.367,7.37Zm-5.506,7.724-2.238,6.265h-6.7L10.72,15.1l5.571-4.062ZM16.273,2.034a14.223,14.223,0,0,1,2.388.216L16.293,3.523,13.926,2.244A14.389,14.389,0,0,1,16.273,2.034Zm-5.183.991,4.184,2.258V9.257L9.406,13.535,6.2,11.969l-1-4.63A14.285,14.285,0,0,1,11.09,3.025ZM3.637,9.737,4.2,12.372,2.14,14.615A14.085,14.085,0,0,1,3.637,9.737Zm.9,14.579A14.145,14.145,0,0,1,2.1,17.656l3.444-3.741,3.141,1.536,2.366,6.719-2,2.4Zm1.8,2.138,2.408.132.7,2.177A14.382,14.382,0,0,1,6.336,26.454ZM19.9,30.026a13.977,13.977,0,0,1-7.978-.2l-1.279-3.985,2.038-2.449h7.189l2,2.374ZM22.615,29l1.155-2.5,2.937-.58A14.28,14.28,0,0,1,22.615,29Zm.846-4.508-1.967-2.329,2.4-6.715,3.126-1.532,3.423,3.737a14.09,14.09,0,0,1-1.918,5.84Z"
                                          fill="#fff"/>
                                </svg>
                                <p class="button__text">Посмотреть объекты</p></div>
                            <div class="arrow"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="container h-100">
                <div class="sb-error__footer align-items-center d-flex h-100 justify-content-between">
                    <div class="sb-footer__first">"Искусство быть первыми"</div>
                    <div class="sb-footer__sportbase">Спортбаза.РФ / {{ new Date().getFullYear() }}</div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import navbar from '../components/NavBar';
export default {
    name: "NotFound",
    components: {navbar}
}
</script>

<style scoped>
footer {
    height: 100px;
}

.sb-error__footer {
    color: white;
    font-size: 16px;
}

.sb-error__block {
    top: 0;
}

.sb-error .sb-error__image {
    height: 600px;
    background-image: url("/images/basketball.png");
    background-size: cover;
    background-repeat: no-repeat;
    background-position-x: center;
}

.sb-error__banner-gradient {
    background: -webkit-gradient(
        linear,
        left bottom,
        left top,
        from(rgba(45, 41, 125, 0.8)),
        to(#2d297d)
    );
    background: linear-gradient(0deg, rgba(45, 41, 125, 0.8), #2d297d);
    width: 100%;
    height: 100%;
    position: absolute;
    bottom: 0;
}

.sb-error__data {
    max-width: 500px;
}

.sb-error__data .sb-number {
    color: white;
    font-size: 142px;
    font-weight: bold;
}

.sb-error__data .sb-number__image {
    margin-top: -20px;
}

.sb-error__data .sb-data__description {
    font-size: 20px;
    color: white;
    margin-bottom: 30px;
}

.sb-error__data .sb-view-objects-btn {
    width: 414px;
}

@media (max-width: 991px) {
    .sb-error__data {
        padding-left: 3rem !important;
        padding-right: 3rem !important;
    }

    .sb-error__data .sb-number {
        font-size: 113px;
    }

    .sb-error__data .sb-data__description {
        font-size: 14px;
    }

    .sb-error__data .sb-number__image img {
        width: 87px;
    }

    footer .container {
        display: flex;
        justify-content: center;
    }

    .sb-error__footer .sb-footer__first {
        display: none;
    }
}
</style>
