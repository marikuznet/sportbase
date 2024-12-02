<template>
    <div class="sb-main-page">
        <navbar></navbar>
        <div class="main-screen">
            <div class="block-gradient"/>
            <div class="container">
                <div class="row">
                    <div class="main-screen__title col-xl item align-self-center">
                        <h1 class="m-5 m-xl-0">В НАШЕЙ БАЗЕ БОЛЕЕ <span>2000</span> СПОРТИВНЫХ ОБЪЕКТОВ</h1>
                        <div class="line order-3"></div>
                        <a href="/object-catalog" class="button button-fill order-2 ml-4 mr-4 ml-lg-0 mr-lg-0">
                            <div class="button__wrapp-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35.583" height="35.723"
                                     viewBox="0 0 35.583 35.723">
                                    <path
                                        d="M31,8.818V6.279h4.535a1.047,1.047,0,0,0,.74-1.787L34.923,3.14l1.353-1.353A1.047,1.047,0,0,0,35.537,0H29.955a1.047,1.047,0,0,0-1.047,1.047V8.218a42.613,42.613,0,0,0-9.07-1.091V6.279h4.535a1.047,1.047,0,0,0,.74-1.787L23.76,3.14l1.353-1.353A1.047,1.047,0,0,0,24.373,0H18.792a1.047,1.047,0,0,0-1.047,1.047V7.128a42.613,42.613,0,0,0-9.07,1.091V6.279H13.21a1.047,1.047,0,0,0,.74-1.787L12.6,3.14,13.95,1.787A1.047,1.047,0,0,0,13.21,0H7.628A1.047,1.047,0,0,0,6.582,1.047V8.818C1.97,10.365,1,12.35,1,13.745v15.35c0,1.4.975,3.391,5.62,4.94a40.008,40.008,0,0,0,12.171,1.689,40.008,40.008,0,0,0,12.171-1.689c4.645-1.548,5.62-3.541,5.62-4.94V13.745C36.583,12.35,35.613,10.365,31,8.818Zm0-6.725H33.01L32.7,2.4a1.047,1.047,0,0,0,0,1.48l.307.307H31Zm-11.163,0h2.008L21.54,2.4a1.047,1.047,0,0,0,0,1.48l.307.307H19.838Zm-11.163,0h2.008l-.307.307a1.047,1.047,0,0,0,0,1.48l.306.307H8.675Zm-1.393,8.7A37.9,37.9,0,0,1,18.792,9.21,37.9,37.9,0,0,1,30.3,10.791c3.092,1.031,4.189,2.235,4.189,2.954,0,.463-.457,1.129-1.611,1.82a10.246,10.246,0,0,0-4.756-2.889A30.038,30.038,0,0,0,18.792,11.3,30.038,30.038,0,0,0,9.46,12.676,10.246,10.246,0,0,0,4.7,15.565c-1.153-.691-1.611-1.356-1.611-1.82C3.093,13.026,4.19,11.821,7.282,10.791ZM28.211,32.637a35.374,35.374,0,0,1-4.186.71V30.334a39.13,39.13,0,0,0,4.186-.671ZM9.372,29.663a39.149,39.149,0,0,0,4.186.671v3.013a35.359,35.359,0,0,1-4.186-.71Zm8.372,3.955q-1.062-.022-2.093-.088V29.443h2.093Zm2.093-4.175h2.093V33.53q-1.03.066-2.093.088ZM24.01,28.23a1.046,1.046,0,0,0-1.032-.88H14.605a1.046,1.046,0,0,0-1.032.88,35.935,35.935,0,0,1-4.2-.712V24.55a44.711,44.711,0,0,0,9.419.94,44.711,44.711,0,0,0,9.419-.94v2.968A35.935,35.935,0,0,1,24.01,28.23Zm-6.265-7.868v3.023A40.718,40.718,0,0,1,9.372,22.4V19.433A43.717,43.717,0,0,0,17.745,20.362ZM28.211,22.4a40.718,40.718,0,0,1-8.372.981V20.362a43.706,43.706,0,0,0,8.372-.929ZM30.3,16.7a37.9,37.9,0,0,1-11.51,1.581A37.9,37.9,0,0,1,7.282,16.7c-.205-.068-.4-.138-.589-.208,1.757-1.637,6.255-3.1,12.1-3.1s10.342,1.459,12.1,3.1C30.7,16.561,30.506,16.63,30.3,16.7Zm-27.208.324A13.9,13.9,0,0,0,6.62,18.685q.323.108.659.209v2.921c-3.09-1.03-4.186-2.235-4.186-2.953Zm0,5.117A13.9,13.9,0,0,0,6.62,23.8q.323.108.659.209V26.93c-.445-.148-.864-.305-1.253-.47-1.837-.779-2.933-1.707-2.933-2.482Zm0,6.955V27.251a11.7,11.7,0,0,0,2.116,1.137,20.135,20.135,0,0,0,2.07.737v2.923C4.19,31.017,3.093,29.813,3.093,29.094ZM30.3,32.047V29.124a20.119,20.119,0,0,0,2.07-.737A11.7,11.7,0,0,0,34.49,27.25v1.844C34.49,29.813,33.394,31.017,30.3,32.047Zm1.253-5.587c-.389.165-.808.322-1.253.47V24.01q.336-.1.659-.209a13.9,13.9,0,0,0,3.527-1.662v1.839c0,.775-1.1,1.7-2.933,2.482ZM30.3,21.814V18.893q.336-.1.659-.209a13.9,13.9,0,0,0,3.527-1.662v1.839c0,.718-1.1,1.923-4.186,2.953Z"
                                        transform="translate(-1 0)" fill="#fff"/>
                                </svg>
                                <p class="button__text">Посмотреть объекты</p>
                            </div>
                            <div class="arrow"></div>
                        </a>
                    </div>
                    <div class="main-screen__slider col-xl item mb-md-5">
                        <div id="slider-object">
                            <input type="radio" name="slider-object" id="object-1" checked="checked">
                            <input type="radio" name="slider-object" id="object-2">
                            <input type="radio" name="slider-object" id="object-3">
                            <label for="object-1" id="obj-1" class="slider-object__item slide">
                                <div class="slide__img">
                                    <img src="/images/objects-slider/1.webp" alt="1" srcset="">
                                </div>
                                <div class="slide__name">
                                    <div class="slide__logo">
                                        <img src="/icons/gazprom-logo.svg" alt="gazprom-logo">
                                    </div>
                                    <p>Газпром Арена <span>г. Санкт-Петербург</span></p>
                                </div>
                            </label>
                            <label for="object-2" id="obj-2" class="slider-object__item slide">
                                <div class="slide__img">
                                    <img src="/images/objects-slider/3.webp" alt="3" srcset="">
                                </div>
                                <div class="slide__name">
                                    <div class="slide__logo">
                                        <img src="/icons/gazprom-logo.svg" alt="gazprom-logo">
                                    </div>
                                    <p>Газпром Арена <span>г. Санкт-Петербург</span></p>
                                </div>
                            </label>
                            <label for="object-3" id="obj-3" class="slider-object__item slide">
                                <div class="slide__img">
                                    <img src="/images/objects-slider/2.webp" alt="2" srcset="">
                                </div>
                                <div class="slide__name">
                                    <div class="slide__logo">
                                        <img src="/icons/gazprom-logo.svg" alt="gazprom-logo">
                                    </div>
                                    <p>Газпром Арена <span>г. Санкт-Петербург</span></p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="background-blocks d-none d-xl-block">
            <div class="background-blocks__item"></div>
            <div class="background-blocks__item"></div>
            <div class="background-blocks__item"></div>
        </div>
        <main>
            <section class="work">
                <div class="container work">
                    <div class="section-title">
                        <h2 class="title">Как это работает?</h2>
                        <div class="line"></div>
                    </div>
                    <div class="work-list row gx-5">
                        <div class="work-list__item work-item col m-3">
                            <div class="work-item__number">
                                1
                            </div>
                            <div class="work-item__body">
                                <svg class="work-item__icon" xmlns="http://www.w3.org/2000/svg" width="50.375"
                                     height="59.981" viewBox="0 0 50.375 59.981">
                                    <g transform="translate(-41)">
                                        <path
                                            d="M278.709,93.97a7.615,7.615,0,1,0-10.816,0A12.315,12.315,0,0,0,261,105.016v5.858a1.757,1.757,0,0,0,1.757,1.757h21.087a1.757,1.757,0,0,0,1.757-1.757v-5.858A12.315,12.315,0,0,0,278.709,93.97ZM269.2,88.615a4.1,4.1,0,1,1,4.1,4.1A4.1,4.1,0,0,1,269.2,88.615Zm12.887,20.5H264.515v-4.1a8.786,8.786,0,0,1,17.573,0Z"
                                            transform="translate(-194.227 -71.511)" fill="#e45868"/>
                                        <path
                                            d="M58.573,364.946v-1.188A1.757,1.757,0,0,0,56.815,362H42.757A1.757,1.757,0,0,0,41,363.757v14.058a1.757,1.757,0,0,0,1.757,1.757H56.815a1.757,1.757,0,0,0,1.757-1.757v-7.908l2.4-2.4a1.756,1.756,0,0,0-2.4-2.565Zm-3.515,11.112H44.515V365.515H55.058v2.937L53.1,370.41l-2.071-2.071a1.757,1.757,0,1,0-2.485,2.485l3.314,3.314a1.757,1.757,0,0,0,2.485,0l.716-.716v2.636Z"
                                            transform="translate(0 -319.591)" fill="#e45868"/>
                                        <path
                                            d="M58.573,183.946v-1.188A1.757,1.757,0,0,0,56.815,181H42.757A1.757,1.757,0,0,0,41,182.757v14.058a1.757,1.757,0,0,0,1.757,1.757H56.815a1.757,1.757,0,0,0,1.757-1.757v-7.908l2.4-2.4a1.756,1.756,0,0,0-2.4-2.565Zm-3.515,11.112H44.515V184.515H55.058v2.937L53.1,189.41l-2.071-2.071a1.757,1.757,0,1,0-2.485,2.485l3.314,3.314a1.757,1.757,0,0,0,2.485,0l.716-.716v2.636Z"
                                            transform="translate(0 -159.796)" fill="#e45868"/>
                                        <path
                                            d="M58.573,2.946V1.757A1.757,1.757,0,0,0,56.815,0H42.757A1.757,1.757,0,0,0,41,1.757V15.815a1.757,1.757,0,0,0,1.757,1.757H56.815a1.757,1.757,0,0,0,1.757-1.757V7.907l2.4-2.4a1.756,1.756,0,0,0-2.4-2.565ZM55.058,14.058H44.515V3.515H55.058V6.452L53.1,8.41,51.029,6.339a1.757,1.757,0,1,0-2.485,2.485l3.314,3.314a1.757,1.757,0,0,0,2.485,0l.716-.716Z"
                                            transform="translate(0 0)" fill="#e45868"/>
                                    </g>
                                </svg>
                                <h4>Смета от выбранногo объекта</h4>
                            </div>
                            <div class="work-item__footer">
                                Получайте сметы от выбранных объектов для оперативного согласования
                            </div>
                        </div>
                        <div class="work-list__item work-item col m-3">
                            <div class="work-item__body">
                                <div class="work-item__number">
                                    2
                                </div>
                                <svg class="work-item__icon" xmlns="http://www.w3.org/2000/svg" width="56.009"
                                     height="56.009" viewBox="0 0 56.009 56.009">
                                    <path
                                        d="M27.052,0H9.184V3.3H0V56.009H36.237V3.3H27.052ZM12.466,3.282h11.3V6.591h-11.3Zm20.488,3.3v46.15H3.282V6.577h5.9v3.3H27.052v-3.3Z"
                                        transform="translate(0)" fill="#e45868"/>
                                    <path d="M75.25,180.75h3.3v3.282h-3.3Z" transform="translate(-67.018 -160.977)"
                                          fill="#e45868"/>
                                    <path d="M135.5,180.75h13.182v3.282H135.5Z" transform="translate(-120.677 -160.977)"
                                          fill="#e45868"/>
                                    <path d="M75.25,241h3.3v3.282h-3.3Z" transform="translate(-67.018 -214.636)"
                                          fill="#e45868"/>
                                    <path d="M135.5,241h13.182v3.282H135.5Z" transform="translate(-120.677 -214.636)"
                                          fill="#e45868"/>
                                    <path d="M75.25,301.25h3.3v3.282h-3.3Z" transform="translate(-67.018 -268.295)"
                                          fill="#e45868"/>
                                    <path d="M135.5,301.25h13.182v3.282H135.5Z" transform="translate(-120.677 -268.295)"
                                          fill="#e45868"/>
                                    <path d="M75.25,361.5h3.3v3.282h-3.3Z" transform="translate(-67.018 -321.954)"
                                          fill="#e45868"/>
                                    <path d="M135.5,361.5h13.182v3.282H135.5Z" transform="translate(-120.677 -321.954)"
                                          fill="#e45868"/>
                                    <path
                                        d="M371.373,6.591V3.3h-3.3V0H364.8V3.3h-3.3V48.338a4.944,4.944,0,0,0,3.3,4.655v3.016h3.282V52.993a4.944,4.944,0,0,0,3.3-4.655V9.873h3.309V21.414h3.282V6.591Zm-3.282-.014v6.6h-3.309v-6.6Zm0,9.886v3.309h-3.309V16.464Zm-1.655,33.529a1.656,1.656,0,0,1-1.655-1.655V23.055h3.309V48.338A1.656,1.656,0,0,1,366.436,49.993Z"
                                        transform="translate(-321.954)" fill="#e45868"/>
                                </svg>
                                <h4>Договор с гибкими условиями</h4>
                            </div>
                            <div class="work-item__footer">
                                Надежный договор с защитой интересов спортсменов
                            </div>
                        </div>
                        <div class="work-list__item work-item col m-3">
                            <div class="work-item__body">
                                <div class="work-item__number">
                                    3
                                </div>
                                <svg class="work-item__icon" xmlns="http://www.w3.org/2000/svg" width="54" height="54"
                                     viewBox="0 0 54 54">
                                    <path
                                        d="M54,11.508a1.582,1.582,0,0,0-1.582-1.582H42.152l-.007-8.345A1.582,1.582,0,0,0,40.563,0H9.694A1.582,1.582,0,0,0,8.112,1.582V20.928a2.567,2.567,0,0,1-.507.332,4.91,4.91,0,0,1-1.127.2,4.8,4.8,0,0,0-3.1,1.138,4.8,4.8,0,0,0-1.138,3.1,4.926,4.926,0,0,1-.2,1.127,4.7,4.7,0,0,1-.626.872A4.831,4.831,0,0,0,0,30.752a4.831,4.831,0,0,0,1.419,3.06,4.706,4.706,0,0,1,.626.872,4.912,4.912,0,0,1,.2,1.127,4.8,4.8,0,0,0,1.138,3.1c.039.039.079.075.119.111v13.4a1.582,1.582,0,0,0,2.243,1.437L11.958,51l6.217,2.86a1.582,1.582,0,0,0,2.243-1.437V45.886l26.29-.047c4.039-.12,7.292-3.81,7.292-8.331,0-.048,0-.095,0-.142,0-.026,0-.053,0-.08ZM3.164,30.752a3.5,3.5,0,0,1,.7-1.054,6.783,6.783,0,0,0,1.1-1.666,7.082,7.082,0,0,0,.419-2.008,4.009,4.009,0,0,1,.226-1.19A3.9,3.9,0,0,1,6.808,24.6a7.076,7.076,0,0,0,2.008-.419,6.784,6.784,0,0,0,1.666-1.1,3.5,3.5,0,0,1,1.054-.7,3.5,3.5,0,0,1,1.054.7,6.78,6.78,0,0,0,1.666,1.1,7.079,7.079,0,0,0,2.008.419,4.009,4.009,0,0,1,1.19.226,3.9,3.9,0,0,1,.231,1.195l.009.086v.012a6.771,6.771,0,0,0,.409,1.911,6.781,6.781,0,0,0,1.1,1.666,3.5,3.5,0,0,1,.7,1.054,3.5,3.5,0,0,1-.7,1.054,6.783,6.783,0,0,0-1.1,1.666,7.078,7.078,0,0,0-.419,2.008,4.006,4.006,0,0,1-.226,1.19,3.9,3.9,0,0,1-1.195.231,7.076,7.076,0,0,0-2.008.419,6.781,6.781,0,0,0-1.666,1.1,3.5,3.5,0,0,1-1.054.7,3.5,3.5,0,0,1-1.054-.7,6.783,6.783,0,0,0-1.666-1.1A7.079,7.079,0,0,0,6.808,36.9a4.006,4.006,0,0,1-1.19-.226,3.9,3.9,0,0,1-.231-1.195,7.075,7.075,0,0,0-.419-2.008,6.784,6.784,0,0,0-1.1-1.666,3.505,3.505,0,0,1-.7-1.054Zm3.5,9.316a4,4,0,0,1,.942.175,4.7,4.7,0,0,1,.872.626,6.646,6.646,0,0,0,1.9,1.211V48.24L6.662,49.949Zm10.592,9.882L13.54,48.24V41.659a10.414,10.414,0,0,0,1.057-.79,4.7,4.7,0,0,1,.871-.626,4.913,4.913,0,0,1,1.127-.2c.21-.022.432-.046.659-.078v9.979Zm3.164-12.143a7.147,7.147,0,0,0,.414-2,4.918,4.918,0,0,1,.2-1.127,4.7,4.7,0,0,1,.626-.872,11.023,11.023,0,0,0,.743-.982H33.375a1.582,1.582,0,0,0,0-3.164H22.89a6.464,6.464,0,0,0-1.236-1.974l-.128-.157H33.405a1.582,1.582,0,1,0,0-3.164H20.632a3.621,3.621,0,0,0-.938-1.777,3.177,3.177,0,0,0-.415-.348H33.407a1.582,1.582,0,0,0,0-3.164H16.854a1.578,1.578,0,0,0-1.482,2.13,6.261,6.261,0,0,1-.774-.578,4.831,4.831,0,0,0-3.06-1.42c-.088,0-.175,0-.26.011V3.164H38.982l.029,34.345h0a8.9,8.9,0,0,0,1.638,5.19l-20.23.022V37.806Zm30.418-.645a1.543,1.543,0,0,0,0,.171v.043c0,.044,0,.088,0,.133,0,2.853-1.943,5.173-4.331,5.173s-4.33-2.321-4.33-5.173h0l-.02-24.417h8.681Z"
                                        fill="#e45868"/>
                                    <path
                                        d="M163.3,80.576H146.91a1.582,1.582,0,0,0,0,3.164H163.3a1.582,1.582,0,1,0,0-3.164Z"
                                        transform="translate(-130 -72.078)" fill="#e45868"/>
                                    <path
                                        d="M163.3,130.751H146.91a1.582,1.582,0,0,0,0,3.164H163.3a1.582,1.582,0,1,0,0-3.164Z"
                                        transform="translate(-130 -116.961)" fill="#e45868"/>
                                    <path
                                        d="M260.982,331.45h-2.6a1.582,1.582,0,0,0,0,3.164h2.6a1.582,1.582,0,0,0,0-3.164Z"
                                        transform="translate(-229.717 -296.492)" fill="#e45868"/>
                                </svg>
                                <h4>Безопасная<br>cделка</h4>
                            </div>
                            <div class="work-item__footer">
                                Ваша 100% гарантия для проведения успешного мероприятия
                            </div>
                        </div>
                    </div>
                    <div class="section-title">
                        <h2 class="title">Организовать спортивные сборы или соревнования в несколько кликов</h2>
                        <h3 class="subtitle">Укажите основные требования и получайте самые актуальные предложения</h3>
                    </div>
                    <div class="video-section row">
                        <div class="col-1 col-xl-3"></div>
                        <div class="video-block col p-0">
                            <div class="video-block__img">
                                <img src="/images/webp/video-img.webp" alt="video-img">
                            </div>
                        </div>

                        <button type="button" class="button button-fill">
                            <p>Видео о платформе</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25.984" height="18.193"
                                 viewBox="0 0 25.984 18.193">
                                <path id="youtube"
                                      d="M25.449-3.235a3.255,3.255,0,0,0-2.29-2.29c-2.033-.556-10.167-.556-10.167-.556s-8.133,0-10.167.535A3.321,3.321,0,0,0,.536-3.235,34.3,34.3,0,0,0,0,3.015a34.175,34.175,0,0,0,.535,6.25,3.256,3.256,0,0,0,2.29,2.29c2.055.557,10.167.557,10.167.557s8.133,0,10.167-.535a3.255,3.255,0,0,0,2.29-2.29,34.312,34.312,0,0,0,.535-6.25,32.56,32.56,0,0,0-.535-6.271ZM10.4,6.91V-.881l6.763,3.9Zm0,0"
                                      transform="translate(-0.001 6.082)" fill="#fff"/>
                            </svg>
                        </button>
                        <div class="col-1 col-xl-3"></div>
                    </div>
                </div>
            </section>
            <section class="banner figure-skating d-none d-xl-block">
                <img class="banner__picture" src="/images/webp/figure-girl.webp" alt="figure-girl" srcset="">
                <div class="banner__gradient"></div>
                <div class="container">
                    <div class="banner__data">
                        <h2 class="banner__title">Игра только по твоим правилам</h2>
                        <p class="banner__subtitle">Скачай приложение</p>
                        <div class="banner__buttons buttons">
                            <button class="button button-fill buttons__item">
                                <svg id="apple" xmlns="http://www.w3.org/2000/svg" width="38.545" height="46.993"
                                     viewBox="0 0 38.545 46.993">
                                    <path id="Контур_44568" data-name="Контур 44568"
                                          d="M58.8,154.125c-6.994-.04-12.779-14.318-12.779-21.589,0-11.877,8.91-14.477,12.344-14.477a14.2,14.2,0,0,1,4.657,1.145,10.411,10.411,0,0,0,2.659.762,8.276,8.276,0,0,0,1.908-.618,15.291,15.291,0,0,1,5.75-1.39h.013c1.685,0,6.792.37,9.863,4.981l.719,1.081L82.9,124.8c-1.479,1.116-4.177,3.152-4.177,7.184a8.108,8.108,0,0,0,4.524,7.5c.648.39,1.319.792,1.319,1.671,0,.574-4.582,12.9-11.236,12.9a9.036,9.036,0,0,1-3.794-.921,7.694,7.694,0,0,0-3.377-.813,8.687,8.687,0,0,0-2.674.723,13.1,13.1,0,0,1-4.638,1.082Z"
                                          transform="translate(-46.022 -107.131)" fill="#fff"/>
                                    <path id="Контур_44569" data-name="Контур 44569"
                                          d="M263.983,0c.173,6.248-4.3,10.583-8.759,10.311C254.489,5.325,259.687,0,263.983,0Z"
                                          transform="translate(-235.959)" fill="#fff"/>
                                </svg>
                                <p>Загрузить в <br>AppStore</p>
                            </button>
                            <button class="button button-fill buttons__item">
                                <svg id="google-play" xmlns="http://www.w3.org/2000/svg" width="41.504" height="46.993"
                                     viewBox="0 0 41.504 46.993">
                                    <path id="Контур_44570" data-name="Контур 44570"
                                          d="M36.162.6A4.077,4.077,0,0,0,32.25.412l21.1,21.143,6.9-6.931Zm-5.85,1.77A4.3,4.3,0,0,0,29.9,4.2V42.88a4.135,4.135,0,0,0,.413,1.817l21.09-21.19Zm23.04,23.088L32.287,46.621a4.134,4.134,0,0,0,1.748.372,4.091,4.091,0,0,0,2.128-.574l24.09-14.047ZM69.42,19.966l-.026-.016-6.687-3.894L55.293,23.5l7.418,7.434,6.708-3.911a4.131,4.131,0,0,0,0-7.061Z"
                                          transform="translate(-29.902 0)" fill="#fff"/>
                                </svg>
                                <p>Загрузить в <br>Google Market</p>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="arena">
                <img class="arena__img" src="/images/webp/gazprom-arena.webp" alt="gazprom-arena">
                <div class="container">
                    <div class="arena-cols ">
                        <div class="arena__logo">
                            <img src="/icons/gazprom-logo.svg" alt="gazprom-logo">
                        </div>
                        <div class="arena__data">
                            <h2 class="arena__name">Газпром <br><span>арена</span></h2>
                            <button type="button" class="button button-fill button-blue">
                                Заявка на аренду
                            </button>
                        </div>
                    </div>
                </div>
                <img src="/icons/gazprom-arena-lines.svg" alt="gazprom-arena-lines" class="arena__lines">
            </section>
            <section class="map-objects">
                <div class="container">
                    <div class="section-title">
                        <h2 class="title title-white">Интерактивная карта спортивных объектов РФ</h2>
                        <h3 class="subtitle subtitle-white">Найди и получи ценовое предложение в пару кликов</h3>
                        <div class="line"></div>
                    </div>
                    <div class="map-section row">
                        <div class="col-2 col-sm-1 d-none d-sm-block"></div>
                        <div class="map-block col-8 col-sm-10 col-12 p-0" style="background-color: white">
                            <div class="buttons__map d-none d-lg-block">
                                <div class="user-type__list type-list p-3">
                                    <div class="d-flex">
                                        <div class="label-radio-wrapp type-list__item flex-fill">
                                            <input class="label-radio-wrapp__radio" type="radio" name="userType"
                                                   id="objects" value="objects" v-model="selectedUserType">
                                            <label class="align-items-center d-flex justify-content-center label-radio-wrapp__label" for="objects">
                                                Все объекты
                                            </label>
                                        </div>
                                        <div class="label-radio-wrapp type-list__item flex-fill">
                                            <input class="label-radio-wrapp__radio" type="radio" name="userType"
                                                   id="sportbase" value="sportbase" v-model="selectedUserType">
                                            <label class="align-items-center d-flex justify-content-center label-radio-wrapp__label" for="sportbase">
                                                Только Спортбазы
                                            </label>
                                        </div>
                                        <div class="label-radio-wrapp type-list__item flex-fill">
                                            <input class="label-radio-wrapp__radio" type="radio" name="userType"
                                                   id="stadium" value="stadium" v-model="selectedUserType">
                                            <label class="align-items-center d-flex justify-content-center label-radio-wrapp__label" for="stadium">
                                                Только стадионы
                                            </label>
                                        </div>
                                        <div class="label-radio-wrapp type-list__item flex-fill">
                                            <input class="label-radio-wrapp__radio" type="radio" name="userType"
                                                   id="ice_arena" value="ice_arena" v-model="selectedUserType">
                                            <label class="align-items-center d-flex justify-content-center label-radio-wrapp__label" for="ice_arena">
                                                Только ледовые арены
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="map-block__img" style="height: 500px">
                                <div class="white__block"></div>
                                <yandex-map style="height:100%" :coords="center" :zoom="4"
                                            :cluster-options="clusterOptions" :settings="settings">
                                    <ymap-marker :key="index" v-for="(object, index) in sportObjects"
                                                 :coords="object"
                                                 :markerId="1" cluster-name="1"/>
                                </yandex-map>
                            </div>
                            <a href="/object-catalog" class="button button-fill">
                                <div class="button__wrapp-text">
                                    <svg id="soccer-ball" xmlns="http://www.w3.org/2000/svg" width="32.546"
                                         height="32.546" viewBox="0 0 32.546 32.546">
                                        <g id="Сгруппировать_6919" data-name="Сгруппировать 6919">
                                            <path id="Контур_44545" data-name="Контур 44545"
                                                  d="M16.273,0a16.14,16.14,0,0,0-5.386.936.1.1,0,0,0-.026.01,16.314,16.314,0,0,0-7.6,5.594s-.006.008-.01.014A16.252,16.252,0,1,0,16.273,0ZM28.927,9.774A14.134,14.134,0,0,1,30.406,14.6l-2.042-2.229Zm-1.56-2.4-1,4.6-3.192,1.562-5.87-4.278V5.289l4.184-2.25A14.253,14.253,0,0,1,27.367,7.37Zm-5.506,7.724-2.238,6.265h-6.7L10.72,15.1l5.571-4.062ZM16.273,2.034a14.223,14.223,0,0,1,2.388.216L16.293,3.523,13.926,2.244A14.389,14.389,0,0,1,16.273,2.034Zm-5.183.991,4.184,2.258V9.257L9.406,13.535,6.2,11.969l-1-4.63A14.285,14.285,0,0,1,11.09,3.025ZM3.637,9.737,4.2,12.372,2.14,14.615A14.085,14.085,0,0,1,3.637,9.737Zm.9,14.579A14.145,14.145,0,0,1,2.1,17.656l3.444-3.741,3.141,1.536,2.366,6.719-2,2.4Zm1.8,2.138,2.408.132.7,2.177A14.382,14.382,0,0,1,6.336,26.454ZM19.9,30.026a13.977,13.977,0,0,1-7.978-.2l-1.279-3.985,2.038-2.449h7.189l2,2.374ZM22.615,29l1.155-2.5,2.937-.58A14.28,14.28,0,0,1,22.615,29Zm.846-4.508-1.967-2.329,2.4-6.715,3.126-1.532,3.423,3.737a14.09,14.09,0,0,1-1.918,5.84Z"
                                                  fill="#fff"/>
                                        </g>
                                    </svg>
                                    <a href="/object-catalog" class="button__text text-white">
                                        Перейти в каталог объектов
                                    </a>
                                </div>
                                <div class="arrow"></div>
                            </a>
                        </div>
                        <div class="col-2 col-sm-1 d-none d-sm-block"></div>
                    </div>
                </div>
                <div class="background-block d-none d-xl-block"></div>
            </section>
            <section class="banner football">
                <img class="banner__picture" src="/images/webp/football-players.webp" alt="football-players">
                <div class="banner__gradient"></div>
                <div class="container">
                    <div class="banner__data">
                        <h2 class="banner__title">Наша цель - помочь тренерам и спортсменам достигать новых высот</h2>
                        <p class="banner__subtitle">Об остальном позаботится Спортбаза.рф</p>
                    </div>
                </div>
                <div class="background-block d-none d-xl-block"></div>
            </section>
            <section class="popular-objects pb-0">
                <div class="container">
                    <div class="section-title">
                        <h2 class="title">Популярные объекты <span>топ-10</span></h2>
                        <h4 class="subtitle">Лента популярности</h4>
                        <div class="line"></div>
                    </div>
                    <div v-if="false" class="objects-categories-list gap-2">
                        <div v-for="(category, index) in object_categories" :key="index"
                             class="label-checkbox-wrapp objects-categories-list__item">
                            <input class="label-checkbox-wrapp__checkbox" type="checkbox" name="checkbox-category"
                                   :id="`${category.id}-cat`" v-model="sportTypes" :value="category.id">
                            <label class="label-checkbox-wrapp__label" :for="`${category.id}-cat`">
                                {{ category.title }}
                            </label>
                        </div>
                    </div>


                    <swiper class="swiper swiper-wrapper swiper-container popular-objects" id="objectsSlider"
                            :options="swiperOption">
                        <swiper-slide v-for="(object, index) in popularObjects" :key="object.id"
                                      class="align-items-center d-flex object-block popular-object position-relative swiper-slide swiper-slide-next">
                            <div class="object-block__img">
                                <img v-if="object.image"
                                     :src="'/storage/listings/objects/'+ object.id + '/' + object.image[0]"
                                     :alt="`logo-${index}`">
                            </div>
                            <div class="object-block__content">
                                <div class="object-block__name">{{ object.title }}</div>
                                <div class="object-block__location object-location">
                                    <img class="object-location__flag" :src="object.flagIco" alt="russia-icon">
                                    <div class="object-location__country">{{ object.country }}</div>
                                    <div class="object-location__city">{{ object.city }}</div>
                                </div>
                                <div class="object-block__descr">
                                    {{
                                        object.description.replace(/<\/?[^>]+(>|$)/g, "").replace(/\.([^\s])/g, '. $1')
                                    }}
                                </div>
                                <div class="object-block__cost text-center">
                                    <span>{{ object.accm_minPrice }} ₽</span> / с человека в сутки
                                </div>
                            </div>
                            <a :href="'/object-catalog/'+ object.id" type="button"
                               class="button button-fill text-white">
                                подробнее
                            </a>
                        </swiper-slide>
                        <div class="swiper-pagination" slot="pagination"></div>
                        <div class="swiper-button-prev" slot="button-prev">
                            <svg style="width:48px;height:48px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z"/>
                            </svg>
                        </div>
                        <div class="swiper-button-next" slot="button-next">
                            <svg style="width:48px;height:48px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z"/>
                            </svg>
                        </div>
                    </swiper>

                </div>
            </section>
            <section class="warranty pb-0">
                <div class="container">
                    <div class="section-title">
                        <h2 class="title">Надежности и гарантии</h2>
                        <h4 class="subtitle">Прозрачность условий для взаимной выгоды</h4>
                        <div class="line"></div>
                    </div>
                    <div class="warranty-blocks row p-5">
                        <div class="warranty-blocks__item warranty-block col item m-3">
                            <div class="warranty-block__icon">
                                <img src="/icons/inspection.svg" alt="inspection">
                            </div>
                            <div class="warranty-block__text">
                                <div class="warranty-block__name">Инспекция</div>
                                <div class="warranty-block__content">Только проверенные объекты</div>
                            </div>
                        </div>
                        <div class="warranty-blocks__item warranty-block col item m-3">
                            <div class="warranty-block__icon">
                                <img src="/icons/rate.svg" alt="rate">
                            </div>
                            <div class="warranty-block__text">
                                <div class="warranty-block__name">Отзывы</div>
                                <div class="warranty-block__content">Рейтинг качества</div>
                            </div>
                        </div>
                        <div class="warranty-blocks__item warranty-block col item m-3">
                            <div class="warranty-block__icon">
                                <img src="/icons/money.svg" alt="money">
                            </div>
                            <div class="warranty-block__text">
                                <div class="warranty-block__name">Выгода</div>
                                <div class="warranty-block__content">Накопительная скидка</div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <section v-if="false" class="banner hockey">
                <img class="banner__picture" src="/images/webp/hockey-player.webp" alt="hockey-player">
                <div class="banner__gradient"></div>
                <div class="container">
                    <div class="banner__data">
                        <h2 class="banner__title">Игра только по твоим правилам</h2>
                        <p class="banner__subtitle">Скачай приложение</p>
                        <div class="banner__buttons buttons">
                            <button class="button button-fill buttons__item">
                                <svg id="apple" xmlns="http://www.w3.org/2000/svg" width="38.545" height="46.993"
                                     viewBox="0 0 38.545 46.993">
                                    <path id="Контур_44568" data-name="Контур 44568"
                                          d="M58.8,154.125c-6.994-.04-12.779-14.318-12.779-21.589,0-11.877,8.91-14.477,12.344-14.477a14.2,14.2,0,0,1,4.657,1.145,10.411,10.411,0,0,0,2.659.762,8.276,8.276,0,0,0,1.908-.618,15.291,15.291,0,0,1,5.75-1.39h.013c1.685,0,6.792.37,9.863,4.981l.719,1.081L82.9,124.8c-1.479,1.116-4.177,3.152-4.177,7.184a8.108,8.108,0,0,0,4.524,7.5c.648.39,1.319.792,1.319,1.671,0,.574-4.582,12.9-11.236,12.9a9.036,9.036,0,0,1-3.794-.921,7.694,7.694,0,0,0-3.377-.813,8.687,8.687,0,0,0-2.674.723,13.1,13.1,0,0,1-4.638,1.082Z"
                                          transform="translate(-46.022 -107.131)" fill="#fff"/>
                                    <path id="Контур_44569" data-name="Контур 44569"
                                          d="M263.983,0c.173,6.248-4.3,10.583-8.759,10.311C254.489,5.325,259.687,0,263.983,0Z"
                                          transform="translate(-235.959)" fill="#fff"/>
                                </svg>
                                <p>Загрузить в <br>AppStore</p>
                            </button>
                            <button class="button button-fill buttons__item">
                                <svg id="google-play" xmlns="http://www.w3.org/2000/svg" width="41.504" height="46.993"
                                     viewBox="0 0 41.504 46.993">
                                    <path id="Контур_44570" data-name="Контур 44570"
                                          d="M36.162.6A4.077,4.077,0,0,0,32.25.412l21.1,21.143,6.9-6.931Zm-5.85,1.77A4.3,4.3,0,0,0,29.9,4.2V42.88a4.135,4.135,0,0,0,.413,1.817l21.09-21.19Zm23.04,23.088L32.287,46.621a4.134,4.134,0,0,0,1.748.372,4.091,4.091,0,0,0,2.128-.574l24.09-14.047ZM69.42,19.966l-.026-.016-6.687-3.894L55.293,23.5l7.418,7.434,6.708-3.911a4.131,4.131,0,0,0,0-7.061Z"
                                          transform="translate(-29.902 0)" fill="#fff"/>
                                </svg>
                                <p>Загрузить в <br>Google Market</p>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="chart">
                <div class="container">
                    <div class="section-title">
                        <h2 class="title">Мониторинг цен на спортивные объекты</h2>
                        <h4 class="subtitle">Мониторьте цены на различные виды спорта за 12 месяцев</h4>
                    </div>
                    <div class="dropdowns row col-lg">
                        <div class="col p-0 m-3 m-lg-3">
                            <div class="select-wrapper">
                                <span class="select-label">Вид спорта</span>
                                <v-select class="selectpicker" :options="kindOfSport" labelTitle="Выберите вид спорта">
                                </v-select>
                            </div>
                        </div>
                        <div class="col p-0 m-3 m-lg-3">
                            <div class="select-wrapper">
                                <span class="select-label">Регион</span>
                                <v-select class="selectpicker" :options="kindOfRegion"
                                          labelTitle="Выберите регион мероприятия">
                                </v-select>
                            </div>
                        </div>
                        <div class="col p-0 m-3 m-lg-3">
                            <div class="select-wrapper">
                                <span class="select-label">Категория</span>
                                <v-select class="selectpicker" :options="kindOfCategory"
                                          labelTitle="Выберите категорию">
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <div class="chart-block row">
                        <chart></chart>
                    </div>
                </div>
            </section>
            <partner></partner>
            <section class="opportunities position-relative">
                <img src="/images/figure-skating.jpg" alt="figure-skating" class="banner__picture h-100">
                <div class="container position-relative">
                    <div class="section-title">
                        <h2 class="title title-white">Для спортивных объектов</h2>
                        <h4 class="subtitle subtitle-white">Возможности сотрудничества</h4>
                        <div class="line"></div>
                    </div>
                    <div class="opportunities-blocks px-4 px-lg-5">
                        <div class="col-sm row">
                            <div class="opportunities-blocks__item opportunities-block row col-sm m-3 mx-lg-4">
                                <div class="opportunities-block__icon">
                                    <img src="/icons/document.svg" alt="document">
                                </div>
                                <div class="opportunities-block__text">Размещайте свои<br>объекты бесплатно</div>
                            </div>
                            <div class="opportunities-blocks__item opportunities-block row col-sm m-3 mx-lg-4">
                                <div class="opportunities-block__icon">
                                    <img src="/icons/candidates.svg" alt="candidates">
                                </div>
                                <div class="opportunities-block__text">Продавайте рекламные поверхности<br>обширной базе
                                    спонсоров
                                </div>
                            </div>
                        </div>
                        <div class="col-sm row">
                            <div class="opportunities-blocks__item opportunities-block row col-sm m-3 mx-lg-4">
                                <div class="opportunities-block__icon">
                                    <img src="/icons/achievement.svg" alt="achievement">
                                </div>
                                <div class="opportunities-block__text">Постоянный поток<br>спортсменов</div>
                            </div>
                            <div class="opportunities-blocks__item opportunities-block row col-sm m-3 mx-lg-4">
                                <div class="opportunities-block__icon">
                                    <img src="/icons/best-employee.svg" alt="best-employee">
                                </div>
                                <div class="opportunities-block__text">Повышайте престиж<br>и узнаваемость</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="survey">
                <div class="container">
                    <div class="section-title">
                        <h2 class="title">Примите участие в нашем опросе</h2>
                        <h4 class="subtitle">Возможности сотрудничества</h4>
                        <div class="line"></div>
                    </div>
                    <div class="survey-form p-3 p-lg-5 pb-lg-4">
                        <div class="input-form-block row m-0">
                            <div class="input-block col m-3 m-lg-3 p-0">
                                <label for="name">Имя</label>
                                <input type="text" name="name" id="name" placeholder="Андрей"
                                       v-model="cooperation.name">
                            </div>
                            <div class="input-block col m-3 m-lg-3 p-0">
                                <label for="name">E-mail компании</label>
                                <input type="email" name="name" id="email" placeholder="mail@mail.com"
                                       v-model="cooperation.email">
                            </div>
                            <div class="input-block col m-3 m-lg-3 p-0">
                                <label for="name">Телефон</label>
                                <input type="tel" name="name" id="phone" placeholder="8 (800) 000-00-00"
                                       v-model="cooperation.phone">
                            </div>
                        </div>

                        <div class="user-type mt-sm-3">
                            <h3 class="user-type__title">Кто вы? <span>выберите вариант</span></h3>
                            <div class="user-type__list type-list p-3">
                                <div class="label-radio-wrapp type-list__item m-sm-2">
                                    <input class="label-radio-wrapp__radio" type="radio" name="user-type" id="сoach"
                                           checked="true">
                                    <label @click="cooperation.position = 'Тренер'" class="label-radio-wrapp__label"
                                           for="сoach">Тренер</label>
                                </div>
                                <div class="label-radio-wrapp type-list__item m-sm-2">
                                    <input class="label-radio-wrapp__radio" type="radio" name="user-type"
                                           id="organizer">
                                    <label @click="cooperation.position = 'Организатор'"
                                           class="label-radio-wrapp__label" for="organizer">Организатор</label>
                                </div>
                                <div class="label-radio-wrapp type-list__item m-sm-2">
                                    <input class="label-radio-wrapp__radio" type="radio" name="user-type" id="sponsor">
                                    <label @click="cooperation.position = 'Спонсор'" class="label-radio-wrapp__label"
                                           for="sponsor">Спонсор</label>
                                </div>
                                <div class="label-radio-wrapp type-list__item m-sm-2">
                                    <input class="label-radio-wrapp__radio" type="radio" name="user-type"
                                           id="sportsman">
                                    <label @click="cooperation.position = 'Спортсмен'" class="label-radio-wrapp__label"
                                           for="sportsman">Спортсмен</label>
                                </div>
                                <div class="label-radio-wrapp type-list__item m-sm-2">
                                    <input class="label-radio-wrapp__radio" type="radio" name="user-type" id="guest">
                                    <label @click="cooperation.position = 'Случайный гость'"
                                           class="label-radio-wrapp__label" for="guest">Случайный гость</label>
                                </div>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="input-block col m-3 m-lg-3 p-0">
                                <label for="answer1">Нравится ли вам идея проекта?</label>
                                <textarea type="text" name="answer1" id="answer1" placeholder="Опишите ваш ответ"
                                          rows="4" v-model="cooperation.question1"></textarea>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="input-block col m-3 m-lg-3 p-0">
                                <label for="answer2">Будет ли Проект Вам полезен?</label>
                                <textarea type="text" name="answer2" id="answer2" placeholder="Опишите ваш ответ"
                                          rows="4" v-model="cooperation.question2"></textarea>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="input-block col m-3 m-lg-3 p-0">
                                <label for="answer3">Какие основные преимущества Вы видите в таком решении?</label>
                                <textarea class="large" type="text" name="answer3" id="answer3"
                                          placeholder="Опишите ваш ответ" rows="4"
                                          v-model="cooperation.question3"></textarea>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="input-block col m-3 m-lg-3 p-0">
                                <label for="answer4">Какие по Вашему мнению главные недостатки решения?</label>
                                <textarea class="large" type="text" name="answer4" id="answer4"
                                          placeholder="Опишите ваш ответ" rows="4"
                                          v-model="cooperation.question4"></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-4">
                            <button @click="sendCooperation" type="button"
                                    class="button button-fill col-10 col-md-8 col-lg-6 col-xl-5">
                                <p>Отправить свои ответы на опрос</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="25.636" height="18.779"
                                     viewBox="0 0 25.636 18.779">
                                    <path id="Контур_44478" data-name="Контур 44478"
                                          d="M22.4,24.61H3.24A3.244,3.244,0,0,0,0,27.85v12.3a3.244,3.244,0,0,0,3.24,3.24H22.4a3.244,3.244,0,0,0,3.24-3.24V27.85A3.244,3.244,0,0,0,22.4,24.61ZM21.89,26.7l-9.072,7.008L3.746,26.7ZM22.4,41.3H3.24a1.151,1.151,0,0,1-1.15-1.15V28.061l10.089,7.794a1.045,1.045,0,0,0,1.278,0l10.089-7.794V40.149A1.151,1.151,0,0,1,22.4,41.3Z"
                                          transform="translate(0 -24.61)" fill="#fff"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="background-block"></div>
            </section>
        </main>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import chart from './ChartOnMainPage.vue'
import bottom from './Bottom.vue'
import navbar from './NavBar.vue'
import partner from './Partners.vue'
import extendedinf from './ExtendedFooterInformation.vue'
import VSelect from '@alfsnd/vue-bootstrap-select'
import {yandexMap, ymapMarker} from 'vue-yandex-maps';
import {Swiper, SwiperSlide} from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'
import axios from "axios";

export default {
    name: 'swiper-example-navigation',
    title: 'Navigation',
    props: ['user'],
    data: function () {
        return {
            selectedUserType: 'objects',
            center: [54, 39],
            settings: this.$apiSettings.yandexMap,
            width: null, object_categories: [],
            kindOfSport: [{id: 1, text: "Вид спорта - 1"}, {id: 2, text: "Вид спорта - 2"},
                {id: 3, text: "Вид спорта - 3"}
            ],
            kindOfRegion: [{id: 1, text: "Регион мероприятия - 1"}, {id: 2, text: "Регион мероприятия - 2"},
                {id: 3, text: "Регион мероприятия - 3"}
            ],
            kindOfCategory: [{id: 1, text: "Категория - 1"}, {id: 2, text: "Категория - 2"},
                {id: 3, text: "Категория - 3"}
            ],
            popularObjects: [],
            swiperOption: {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: false,
                pagination: {el: '.swiper-pagination', clickable: true},
                navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev'},
                breakpoints: {
                    375: {slidesPerView: 1, spaceBetween: 10,},
                    576: {slidesPerView: 2, spaceBetween: 20,},
                    768: {slidesPerView: 3, spaceBetween: 20,},
                    992: {slidesPerView: 4, spaceBetween: 30,}
                },
            },
            showSlide1: false, showSlide2: false, showSlide3: true, sportObjects: [],
            clusterOptions: {
                '1': {
                    clusterIconColor: '#E45868',
                    clusterDisableClickZoom: true,
                    // clusterOpenBalloonOnClick: true,
                }
            }, sportTypes: [],
            cooperation: {
                name: '', email: '', phone: '', position: 'Тренер',
                question1: '', question2: '', question3: '', question4: '',
            },
            regEmail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
        }
    },
    watch: {
        sportTypes: {
            handler: function () {
                this.getSportObjectsPopular();
            }, deep: true
        }
    },
    mounted() {
        this.center = [55.767592, 37.619971];
        if (this.showMap === false) {
            this.image =
                '/icons/settings/maps-and-flags.svg';
        } else if (this.showMap === true) {
            this.image =
                '/icons/settings/maps-and-flagsWhite.svg';
        }

        this.$store.dispatch("fetchSportObjectsWithoutPage").then(
            response => {
                 for (let i = 0; i < response.length; i++) {
                     if (response[i].visible == 1 && response[i].verify == 1) {
                         if (response[i].latitude != null && response[i].longtitude != null) {
                             this.sportObjects.push([response[i].latitude, response[i].longtitude]);
                         } else {
                             let address = encodeURI(`${response[i].country}+${response[i].city}+${response[i].address}`);
                             this.getCoords(address);
                         }
                     }
                 }
            }
        )

        this.getSportObjectsPopular();
        this.getSportTypes();
    },
    methods: {
        getSportObjectsPopular() {
            this.$store.dispatch('getPopularSportObjects', {data: this.sportTypes}).then((result) => {
                this.popularObjects = result.map(obj => {
                    return {
                        ...obj,
                        flagIco: "/icons/russia-icon.svg"
                    };
                });
            })
        },
        getSportTypes() {
            this.$store.dispatch('fetchSportTypes').then((result) => {
                this.object_categories = result;
            })
        },
        getCoords(address) {
            let temp_address = address.replace(' ', '+');
            let long = null;
            let lat = null;
            axios.get('/api/v1/get/coords', {
                params: {
                    address: temp_address
                }
            }).then(resp => {
                const coords = resp.data.response.GeoObjectCollection.featureMember[0]['GeoObject']['Point']['pos'].split(' ');
                long = parseFloat(coords[1]);
                lat = parseFloat(coords[0]);
                this.sportObjects.push([lat, long]);
            }).catch(error => {
                console.log(error);
            });
        },
        sendCooperation() {
            for (const key in this.cooperation) {
                if (this.cooperation.hasOwnProperty(key) && this.cooperation[key] === '') {
                    return alert('Заполните пустые поля');
                }
            }

            axios.post('/send-cooperation', this.cooperation).then(() => {
                this.cooperation = {
                    name: '', email: '', phone: '', position: 'Тренер',
                        question1: '', question2: '', question3: '', question4: '',
                }
                alert('Ответы на вопросы отправлены');
            })
        }
    },
    created() {
        // window.addEventListener('resize', this.checkWidth);
        // this.checkWidth();
        // window.addEventListener('resize', this.initSwiperOption);
        // this.initSwiperOption();
    },
    components: {
        bottom, navbar, Swiper, SwiperSlide, partner, extendedinf, chart, VSelect, yandexMap, ymapMarker,
    }
}
</script>

<style>

@media (max-width: 440px) {
    .swiper-wrapper button.button {
        width: -moz-available;
        margin-right: 100px;
        margin-left: 100px;
    }

    .map-section a.button {
        margin-bottom: 60%;
        height: 63px;
        margin-left: 30px;
        margin-right: 20px;
        left: 0;
        bottom: 0 !important;
    }
}
</style>

<!--

<style lang="scss" scoped>
// @import '../../sass/base.scss';
//
</style>-->
