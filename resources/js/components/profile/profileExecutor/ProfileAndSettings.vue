<template xmlns="http://www.w3.org/1999/html">
    <div class="sb-profile-and-settings">
        <div class="align-items-center d-flex justify-content-center loading position-fixed" v-if="loading">
            <img src="/images/load.gif" alt="load" style="width: 40px">
        </div>
        <navbar></navbar>
        <menu-component-customer v-if="user.role===2" active="6"></menu-component-customer>
        <menu-component-executor v-if="user.role===3" active="6"></menu-component-executor>

        <nav class="navbar navbar-expand-xl navbar-light pt-1 pb-0 menuAuthCompany Mobile d-lg-none">
            <div class="profile_user_background">
                <div class="container">
                    <ul class="navbar-nav nav navbar-collapse d-lg-none profile__user">
                        <li @click.prevent="showOrHideMenu"
                            class="nav-item mx-auto d-flex" style="margin-left: 0 !important; cursor: pointer">
                            <a class="nav-link text-white userIcon">
                                <img style="width: 20px" src="/icons/settings/userWhite.svg" alt="">
                            </a>
                            <img class="arrowDown" src="/icons/selectArowWhite.svg" alt="arrow">
                        </li>
                    </ul>
                    <div class="profileAction navbar-collapse nav navbar-nav" style="width: 100%;" v-if="showProfile">
                        <li :class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/profile/payment">
                                <img class="img__icon-settings" src="/icons/settings/real-estateWhite.svg"
                                     alt="">
                                Платежные реквизиты</a>
                        <li :class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/profile/notification">
                                <img class="img__icon-settings" src="/icons/settings/notificationWhite.svg"
                                     alt="">
                                Оповещания</a>
                        </li>
                        <li v-bind:class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/profile/security">
                                <img class="img__icon-settings" src="/icons/settings/securityWhite.svg" alt="">
                                Безопасность</a>
                        </li>
                        <li v-bind:class="{ 'border__grey': showProfile }" class="nav-item mx-auto">
                            <a class="nav-link text-white" href="/auth/logout">
                                <img class="img__icon-settings" src="/icons/settings/logout.svg" alt="">
                                Выйти из профиля</a>
                        </li>
                    </div>
                </div>
            </div>
        </nav>
        <div class="main-profile " style="min-height: 600px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <left-menu :active="0"></left-menu>
                    </div>
                    <div class="col-lg-8">
                        <ValidationObserver v-slot="props" tag="form" ref="observer"
                                            @submit.prevent="saveInfoCompanies">
                            <div class="block__profile-settings shadow mb-lg-0 mt-lg-0 mt-5 mb-5">
                                <div class="title__block-profile p-4 d-flex flex-wrap
                                    justify-content-between">
                                    <h3 class="caption__profile  d-none d-lg-block">Профиль пользователя</h3>
                                    <template v-if="user.role === 3">
                                        <h6 v-if="statusVerify === 10 || statusVerify === 13" style="color: red">
                                            {{ statusVerify === 10 ? 'Не верифицирован' : '' }}
                                            {{ statusVerify === 13 ? 'На проверке' : '' }}
                                        </h6>
                                        <h6 v-else-if="statusVerify === 11" style="color: green">Подтвержден</h6>
                                    </template>
                                    <template v-if="user.role === 2">
                                        <p class="text-Blue mb-4 mt-4">
                                            Вы можете выбрать, кем быть на сайте - физическим или юридическим лицом.
                                            Данная настройка влияет на: поля в профиле пользователя, отображении на
                                            сайте (для Исполнителей), возможности оплаты, закрывающие Файлы. Вы можете
                                            переключиться в любой момент времени.
                                        </p>
                                        <div class="row align-items-center">
                                            <div class="col-lg-2 col-4">
                                                <p class="text-Blue">Тип аккаунта</p>
                                            </div>
                                            <div class="col-lg-4 col-4">
                                                <div class="d-flex">
                                                    <input id="legalPerson" type="radio" name="person" value="0"
                                                           v-model="checkProfile" class="me-2">
                                                    <label for="legalPerson">Юридическое лицо</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-4">
                                                <div class="d-flex">
                                                    <input id="individual" type="radio" name="person" value="1"
                                                           v-model="checkProfile" class="me-2">
                                                    <label for="individual">Физическое лицо</label>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <div class="block__profile-main_info p-lg-4 pt-4">
                                    <h5 class="caption">Основная информация</h5>
                                    <div class="row about__company" v-if="user.role == 3">
                                        <div class="col-lg-8">
                                            <ValidationProvider rules="required" vid="title"
                                                                v-slot="{ errors, failed }">
                                                <div class="name-wrapper w-100 my-2 me-3 mb-xl-2">
                                                    <label class="w-100 caption">Название компании
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <span class="float-right text-muted font-weight-normal">
                                                    <!--{{ infoCompanyDetail.title.length }} /100!-->
                                                        </span>
                                                        <input :maxlength="maxNameCompany" type="text"
                                                               :class="{ 'is-invalid': failed }"
                                                               v-model="infoCompanyDetail.title"
                                                               placeholder="ПромТехИнвест" class="input-profile-info"
                                                               autocomplete="off">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="col-employees-wrapper select-wrapper w-100 my-2 me-3 mb-xl-2">
                                                <label class="w-100 caption select-wrapper mb-xl-2">
                                                    Количество сотрудников
                                                    <v-select labelTitle="Выбрать" class="selectpicker"
                                                              v-model="infoCompanyDetail.quantityEmployees"
                                                              :options="colEmployees" valueProp="id" titleProp="text">
                                                    </v-select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="w-100 caption">Логотип компании
                                                <div class="block__upload">
                                                    <div class="block__upload-image d-flex justify-content-center"
                                                         style="width: 180px;height: 110px; border: 1px solid lightgray; border-radius: 10px; cursor: pointer">
                                                        <img v-if="!imageSrc" style="width:30px"
                                                             src="/icons/stages/file-upload.svg"
                                                             alt="upload"/>
                                                        <img class="w-100 h-100" v-show="imageSrc"
                                                             style="border-radius: 10px; object-fit: cover;" :src="imageSrc"
                                                             alt="upload"/>
                                                    </div>
                                                    <input ref="logoExecutor" type="file" class="d-none"
                                                           accept="image/jpeg, image/jpg, image/png, image/gif"
                                                           @change="addImage">
                                                    <p class="caption__logo pl-4">
                                                        Высота и ширина должны быть не мнее 250х250 пикс.
                                                    </p>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="w-100 caption">Номер телефона
                                                <div class="row">
                                                    <div class="row p-0 m-0" v-for="phone in phonesSave">
                                                        <div class="col-4 col-employees-wrapper select-wrapper mb-xl-2">
                                                            <label class="w-100 caption select-wrapper mb-xl-2"
                                                                   for="phoneComp">
                                                                <v-select id="phoneComp" labelTitle="+7"
                                                                          v-model="phone.code"
                                                                          class="selectpicker" :options="codePhone">
                                                                </v-select>
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-8 col-8">
                                                            <input type="text" name="phoneCompany"
                                                                   v-model="phone.phone" maxlength="10"
                                                                   placeholder="900 000 00 00" autocomplete="off"
                                                                   class="input-profile-info">
                                                        </div>
                                                    </div>

                                                    <div class="col-4 d-none d-lg-block"></div>
                                                    <div class="col-lg-8 col-8 d-none d-lg-block">
                                                        <a class="pl-4" href="#" @click.prevent="addOncePhone"
                                                           style="color: #6283E5; font-weight: normal; font-size: calc(1.125rem)">
                                                            Добавить еще +
                                                        </a>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="w-100 caption">Email адрес (компании)
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <span style="color: #F37A8A;float: right;font-size: calc(0.875rem);"
                                                      v-show="hasError">неверный формат записи
                                            </span>
                                                <input type="text" v-model="infoCompanyDetail.emailCompany"
                                                       :class="[isEmailValid()]"
                                                       placeholder="mail@mail.com" class="input-profile-info">
                                            </label>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="w-100 caption">Адрес сайта
                                                <input type="text" v-model="infoCompanyDetail.site"
                                                       placeholder="www.sitename.com" class="input-profile-info">
                                            </label>
                                        </div>
                                        <div class="col-lg-12">
                                            <custom-vue-editor :max-length="maxDescriptionCompany" :props="props"
                                                               @update:text="infoCompanyDetail.descriptionCompany = $event"
                                                               :text="infoCompanyDetail.descriptionCompany"
                                                               text-label="Описание компании"/>
                                        </div>
                                    </div>
                                    <div class="row about__company" v-if="user.role == 2 && checkProfile == 0">
                                        <div class="col-lg-6">
                                            <ValidationProvider rules="required" vid="title"
                                                                v-slot="{errors, failed}">
                                                <div class="name-wrapper w-100 me-3 mb-xl-2">
                                                    <label class="w-100 caption">Название компании
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <span class="float-right text-muted font-weight-normal"></span>
                                                        <input :maxlength="maxNameCompany" type="text" id="title"
                                                               name="title" :class="{ 'is-invalid': failed }"
                                                               v-model="infoCompanyDetail.title"
                                                               placeholder="ПромТехИнвест" class="input-profile-info"
                                                               autocomplete="off">
                                                    </label>
                                                    <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-lg-6">
                                            <ValidationProvider rules="required" v-slot="{errors}" vid="email">
                                                <label class="w-100 caption">Email адрес (компании)
                                                    <span style="color: rgb(243, 122, 138)">*</span>
                                                    <span class="error-valid" v-show="hasError">неверный формат записи
                                                    </span>
                                                    <input type="text" v-model="infoCompanyDetail.emailCompany"
                                                           :class="[isEmailValid()]" placeholder="mail@mail.com"
                                                           class="input-profile-info">
                                                </label>
                                                <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-lg-6">
                                            <ValidationProvider v-slot="{errors}" vid="logo">
                                                <label class="w-100 caption">Логотип компании
                                                    <div class="block__upload">
                                                        <div class="block__upload-image d-flex justify-content-center"
                                                             style="width: 180px;height: 110px; border: 1px solid lightgray;
                                                     border-radius: 10px; cursor: pointer">
                                                            <img v-if="!imageSrc" style="width:30px"
                                                                 src="/icons/stages/file-upload.svg"
                                                                 alt="upload"/>
                                                            <img class="w-100 h-100" v-show="imageSrc"
                                                                 style="border-radius: 10px; object-fit: cover;" :src="imageSrc"
                                                                 alt="upload"/>
                                                        </div>
                                                        <input ref="logoCustomer" type="file"
                                                               accept="image/jpeg, image/jpg, image/png, image/gif"
                                                               class="d-none" @change="addImage">
                                                        <p class="caption__logo pl-4">Высота и ширина должны
                                                            быть не мнее 250х250 пикс.</p>
                                                    </div>
                                                </label>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="w-100 caption">Номер телефона</label>
                                            <div class="row">
                                                <div class="row p-0 m-0" v-for="phone in phonesSave">
                                                    <div class="col-4 col-employees-wrapper select-wrapper mb-xl-2">
                                                        <label class="w-100 caption select-wrapper mb-xl-2"
                                                               for="phoneCompany">
                                                            <v-select id="phoneCompany" labelTitle="+7"
                                                                      v-model="phone.code" class="selectpicker"
                                                                      :options="codePhone" valueProp="text">
                                                            </v-select>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-8">
                                                        <input type="text" maxlength="10" minlength="10"
                                                               @input="phone.phone = phone.phone.replace(/[^0-9]/g, '')"
                                                               name="phoneCompany" v-model="phone.phone"
                                                               placeholder="900 000 00 00" autocomplete="off"
                                                               class="input-profile-info">
                                                    </div>
                                                </div>

                                                <div class="col-4 d-none d-lg-block"></div>
                                                <div class="col-lg-8 col-8 d-none d-lg-block">
                                                    <a class="pl-4"
                                                       style="color: #6283E5; font-weight: normal; font-size: calc(1.125rem)"
                                                       href="#" @click.prevent="addOncePhone">Добавить еще +
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="w-100 caption">Адрес сайта
                                                <input type="text" v-model="infoCompanyDetail.site"
                                                       placeholder="www.sitename.com" class="input-profile-info">
                                            </label>
                                        </div>
                                        <div class="col-lg-12">
                                            <custom-vue-editor :max-length="maxDescriptionCompany" :props="props"
                                                               @update:text="infoCompanyDetail.descriptionCompany = $event"
                                                               :text="infoCompanyDetail.descriptionCompany"
                                                               text-label="Описание компании"/>
                                        </div>
                                    </div>
                                    <div class="row about__company" v-if="user.role == 2 && checkProfile == 1">
                                        <div class="col-lg-3">
                                            <ValidationProvider v-slot="{errors}">
                                                <label class="w-100 caption">Фото / аватар
                                                    <div class="block__upload d-block">
                                                        <div
                                                            class="block__upload-image d-flex justify-content-center"
                                                            style="width: 180px;height: 110px; border: 1px solid lightgray;
                                                     border-radius: 10px; cursor: pointer">
                                                            <img v-if="!imageSrc" style="width:30px"
                                                                 src="/icons/stages/file-upload.svg"
                                                                 alt="upload"/>
                                                            <img class="w-100 h-100" v-show="imageSrc"
                                                                 style="border-radius: 10px" :src="imageSrc"
                                                                 alt="upload"/>
                                                        </div>
                                                        <input ref="logoCustomer" type="file"
                                                               accept="image/jpeg, image/jpg, image/png, image/gif"
                                                               class="d-none" @change="addImage">
                                                        <p class="caption__logo">Высота и ширина должны
                                                            быть не мнее 250х250 пикс.</p>
                                                    </div>
                                                </label>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-4">
                                                    <ValidationProvider rules="required|alpha|max:50"
                                                                        v-slot="{ errors, failed }">
                                                        <label class="w-100 caption">Фамилия
                                                            <span style="color: rgb(243, 122, 138)">*</span>
                                                            <input type="text" v-model="infoCompanyDetail.surname"
                                                                   placeholder="Петров" class="input-profile-info"
                                                                   maxlength="50"
                                                                   :class="{ 'is-invalid': failed }">
                                                        </label>
                                                        <span class="error-valid"
                                                              v-if="errors[0]">{{ errors[0] }}</span>
                                                    </ValidationProvider>
                                                </div>
                                                <div class="col-lg-6 col-md-4">
                                                    <ValidationProvider rules="required|alpha|max:50"
                                                                        v-slot="{ errors, failed }">
                                                        <label class="w-100 caption">Имя
                                                            <span style="color: rgb(243, 122, 138)">*</span>
                                                            <input type="text" v-model="infoCompanyDetail.name"
                                                                   placeholder="Иван" class="input-profile-info"
                                                                   maxlength="50"
                                                                   :class="{ 'is-invalid': failed }">
                                                        </label>
                                                        <span class="error-valid"
                                                              v-if="errors[0]">{{ errors[0] }}</span>
                                                    </ValidationProvider>
                                                </div>
                                                <div class="col-lg-6 col-md-4">
                                                    <ValidationProvider rules="required|alpha|max:50"
                                                                        v-slot="{ errors, failed }">
                                                        <label class="w-100 caption">Отчество
                                                            <span style="color: rgb(243, 122, 138)">*</span>
                                                            <input type="text"
                                                                   v-model="infoCompanyDetail.patronymic"
                                                                   placeholder="Иванович" class="input-profile-info"
                                                                   maxlength="50" :class="{ 'is-invalid': failed }">
                                                        </label>
                                                        <span class="error-valid"
                                                              v-if="errors[0]">{{ errors[0] }}</span>
                                                    </ValidationProvider>
                                                </div>
                                                <div class="col-lg-6 col-md-4">
                                                    <label class="w-100 caption select-wrapper mb-xl-2">
                                                        Должность
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <v-select labelTitle="Выбрать" textProp="title"
                                                                  v-model="infoCompanyDetail.position"
                                                                  @input="getPosition_id"
                                                                  valueProp="id" class="selectpicker"
                                                                  :options="allPositions">
                                                        </v-select>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <custom-vue-editor :max-length="maxDescriptionCompany" :props="props"
                                                               @update:text="infoCompanyDetail.descriptionCompany = $event"
                                                               :text="infoCompanyDetail.descriptionCompany"
                                                               text-label="Описание вашей деятельности"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="block__address-main p-lg-4 pt-4">
                                    <h5 class="caption">Адрес компании <span
                                        class="additionally">(для отображения на сайте)</span></h5>
                                    <div class="addAddressButton d-flex pb-2">
                                        <button type="button"
                                                v-bind:class="{ 'button-blue': showManually, 'button-border': showMap }"
                                                v-on:click="switchManually" class="button mr-2">
                                            Ввести вручную
                                        </button>
                                        <button type="button"
                                                v-bind:class="{ 'button-blue': showMap, 'button-border': showManually }"
                                                class="button" v-on:click="switchMap">
                                            <img class="pr-3" alt=""> Указать на
                                            карте
                                        </button>
                                    </div>
                                    <template>
                                        <div class="infoAboutAddress" v-if="showManually">
                                            <div class="row">
                                                <div class="col-lg-6 ">
                                                    <label class="w-100 caption select-wrapper mb-xl-2">Страна
                                                        <span style="color: rgb(243, 122, 138)">*</span>
                                                        <v-select labelTitle="Выбрать" class="selectpicker"
                                                                  v-model="infoCompanyDetail.country"
                                                                  :options="allCountries"
                                                                  textProp="title" valueProp="id">
                                                        </v-select>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6 ">
                                                    <ValidationProvider v-slot="{errors, failed}"
                                                                        :rules="infoCompanyDetail.country != null ? 'required': ''">
                                                        <label class="w-100 caption select-wrapper mb-xl-2">Область,
                                                            округ, провинция
                                                            <span style="color: rgb(243, 122, 138)">*</span>
                                                            <v-select id="region" valueProp="id" class="selectpicker"
                                                                      :class="{'is-invalid': failed}" textProp="title"
                                                                      v-model="infoCompanyDetail.region"
                                                                      labelTitle="Выбрать"
                                                                      :options="regionsWithCountry">
                                                            </v-select>
                                                        </label>
                                                        <span class="error-valid" v-if="errors[0]">{{
                                                                errors[0]
                                                            }}</span>
                                                    </ValidationProvider>
                                                </div>
                                                <div class="col-lg-6">
                                                    <ValidationProvider v-slot="{errors, failed}"
                                                                        :rules="infoCompanyDetail.country != null ? 'required': ''">
                                                        <label class="w-100 caption select-wrapper mb-xl-2">Город
                                                            (населенный пункт)
                                                            <span style="color: rgb(243, 122, 138)">*</span>
                                                            <v-select id="city" textProp="title" valueProp="id"
                                                                      :class="{'is-invalid': failed}"
                                                                      labelTitle="Выбрать"
                                                                      v-model="infoCompanyDetail.city"
                                                                      class="selectpicker" @input="getCity_id"
                                                                      :options="citiesWithRegion(region_id)">
                                                            </v-select>
                                                        </label>
                                                        <span class="error-valid" v-if="errors[0]">{{
                                                                errors[0]
                                                            }}</span>
                                                    </ValidationProvider>
                                                </div>
                                                <div class="col-lg-6">
                                                    <ValidationProvider v-slot="{ failed, errors }"
                                                                        :rules="infoCompanyDetail.country != null ? 'required|numeric|max:6|min:6|': ''">
                                                        <label class="w-100 caption mt-lg-3">Почтовый индекс
                                                            <span style="color: rgb(243, 122, 138)">*</span>
                                                            <input type="text" v-model="infoCompanyDetail.postIndex"
                                                                   :class="{ 'is-invalid': failed }"
                                                                   placeholder="000 000" class="input-profile-info"
                                                                   autocomplete="off" pattern="^([0-9]+)$"
                                                                   maxlength="6" minlength="6">
                                                        </label>
                                                        <span class="error-valid" v-if="errors[0]">{{
                                                                errors[0]
                                                            }}</span>
                                                    </ValidationProvider>
                                                </div>
                                                <div class="col-lg-12">
                                                    <ValidationProvider v-slot="{ failed, errors }"
                                                                        :rules="infoCompanyDetail.country != null ? 'max:200|required': ''">
                                                        <label class="w-100 caption">Улица, номер дома и офиса
                                                            <span style="color: rgb(243, 122, 138)">*</span>
                                                            <input :class="{ 'is-invalid': failed }" type="text"
                                                                   v-model="infoCompanyDetail.address"
                                                                   placeholder="Введите имя улицы, номер дома и офиса"
                                                                   class="input-profile-info" autocomplete="off"
                                                                   :disabled="infoCompanyDetail.country == null">
                                                        </label>
                                                        <span class="error-valid" v-if="errors[0]">{{
                                                                errors[0]
                                                            }}</span>
                                                    </ValidationProvider>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mapAddress pt-3" v-if="showMap" style="height: 300px">
                                            <yandex-map @click="showLocation" style="height:100%" :coords="center"
                                                        :zoom="17" :settings="settings">
                                                <ymap-marker v-model="marker" marker-type="placemark"
                                                             :coords="coords" :markerId="1" :icon="{color: 'green'}"
                                                             :options="{draggable:true, iconShadow:true, iconShadowImageOffset:[2,-20],
                                                    iconShadowImageSize: [29, 7]}" @input="getCity_id"/>
                                            </yandex-map>
                                        </div>
                                    </template>
                                </div>

                                <div class="block__social-main_info p-lg-4 pt-4">
                                    <h5 class="caption">Социальные сети и мессенджеры</h5>
                                    <div class="row social-data">
                                        <div class="col-lg-4">
                                            <label class="w-100 caption">Facebook
                                                <input type="text" v-model="infoCompanyDetail.facebook"
                                                       placeholder="Введите адрес" class="input-profile-info">
                                            </label></div>
                                        <div class="col-lg-4">
                                            <label class="w-100 caption">Twitter
                                                <input type="text" v-model="infoCompanyDetail.twitter"
                                                       placeholder="Введите адрес" class="input-profile-info">
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="w-100 caption">LinkedIn
                                                <input type="text" v-model="infoCompanyDetail.linkedIn"
                                                       placeholder="Введите адрес" class="input-profile-info">
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="w-100 caption">Telegram
                                                <input type="text" v-model="infoCompanyDetail.telegram"
                                                       placeholder="Введите адрес" class="input-profile-info">
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="w-100 caption">Slack
                                                <input type="text" v-model="infoCompanyDetail.slack"
                                                       placeholder="Введите адрес" class="input-profile-info">
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="w-100 caption">Github
                                                <input type="text" v-model="infoCompanyDetail.instagram"
                                                       placeholder="Введите адрес" class="input-profile-info">
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="user.role==2 && checkProfile == 1 "
                                     class="block__data-main_info p-lg-4 pt-4">
                                    <h5 class="caption">Контактные данные</h5>
                                    <div class="row personal-data">
                                        <div class="col-lg-4"><label class="w-100 caption"><span>Email</span>
                                            (рабочий или личный)
                                            <span style="color: rgb(243, 122, 138)">*</span>
                                            <span style="color: #F37A8A;float: right;font-size: calc(0.875rem);"
                                                  v-show="phisHasEmailError">
                                                неверный формат записи
                                            </span>
                                            <input type="text" :class="[isEmailPersonPhisValid()]"
                                                   v-model="infoCompanyDetail.email"
                                                   placeholder="mail@mail.com" class="input-profile-info">
                                        </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="caption w-100">Номер телефона
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <div class="row">
                                                    <div
                                                        class="col-4 col-employees-wrapper select-wrapper mb-xl-2 pr-0">
                                                        <v-select v-model="mePhone_code" labelTitle="+7"
                                                                  class="selectpicker" :options="codePhone">
                                                        </v-select>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" v-model="mePhone_phone"
                                                               @input="mePhone_phone = mePhone_phone.replace(/[^0-9]/g, '')"
                                                               placeholder="900 000 00 00" maxlength="10"
                                                               class="input-profile-info" minlength="10"
                                                               pattern="^([0-9]+)$" autocomplete="off">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="w-100 caption">Адрес сайта
                                                <input type="text" v-model="infoCompanyDetail.site"
                                                       placeholder="www.sitename.com" class="input-profile-info">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="block__data-main_info p-lg-4 pt-4">
                                    <h5 class="caption">Личные данные пользователя</h5>
                                    <div class="row personal-data">
                                        <div class="col-lg-4">
                                            <ValidationProvider rules="required|alpha|max:50"
                                                                v-slot="{ errors, failed }">
                                                <label class="w-100 caption">Имя
                                                    <span style="color: rgb(243, 122, 138)">*</span>
                                                    <input type="text" v-model="infoCompanyDetail.name"
                                                           placeholder="Иван" class="input-profile-info" maxlength="50"
                                                           :class="{ 'is-invalid': failed }">
                                                </label>
                                                <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-lg-4">
                                            <ValidationProvider rules="required|alpha|max:50"
                                                                v-slot="{ errors, failed }">
                                                <label class="w-100 caption">Фамилия
                                                    <span style="color: rgb(243, 122, 138)">*</span>
                                                    <input type="text" v-model="infoCompanyDetail.surname"
                                                           placeholder="Петров" class="input-profile-info"
                                                           maxlength="50"
                                                           :class="{ 'is-invalid': failed }">
                                                </label>
                                                <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="w-100 caption select-wrapper mb-xl-2">
                                                Должность
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <v-select labelTitle="Выбрать" textProp="title"
                                                          v-model="infoCompanyDetail.position" @input="getPosition_id"
                                                          valueProp="id" class="selectpicker"
                                                          :options="allPositions">
                                                </v-select>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="w-100 caption"><span>Email</span>
                                                (рабочий или личный)
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <span style="color: #F37A8A;float: right;font-size: calc(0.875rem);"
                                                      v-show="hasEmailError">
                                                неверный формат записи
                                            </span>
                                                <input type="text" v-model="infoCompanyDetail.email"
                                                       :class="[isEmailPersonValid()]"
                                                       placeholder="mail@mail.com" class="input-profile-info">
                                            </label>
                                        </div>
                                        <div class="col-lg-8">
                                            <label class="caption w-100">Номер телефона
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <div class="row">
                                                    <div
                                                        class="col-4 col-employees-wrapper select-wrapper mb-xl-2">
                                                        <label class="w-100 caption select-wrapper mb-xl-2"
                                                               for="mePhone">
                                                            <v-select id="mePhone" labelTitle="+7"
                                                                      v-model="mePhone_code" class="selectpicker"
                                                                      :options="codePhone">
                                                            </v-select>
                                                        </label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" v-model="mePhone_phone"
                                                               placeholder="900 000 00 00" maxlength="10"
                                                               class="input-profile-info" minlength="10"
                                                               pattern="^([0-9]+)$" autocomplete="off"
                                                               @input="mePhone_phone = mePhone_phone.replace(/[^0-9]/g, '')">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="button-center button button-green mb-4 d-block">
                                    Сохранить
                                </button>
                            </div>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </div>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from '../../NavBar'
import extendedinf from "../../ExtendedFooterInformation";
import MenuComponentExecutor from "../menuComponent";
import MenuComponentCustomer from "../profileCustomer/menuComponent";
import leftMenu from "../leftMenu";
import VSelect from "@alfsnd/vue-bootstrap-select";
import {yandexMap, ymapMarker} from 'vue-yandex-maps';
import {VueEditor} from 'vue2-editor';
import {mapActions, mapGetters} from 'vuex';
import axios from "axios";
import CustomVueEditor from "../../elements/CustomVueEditor";
import AddressForm from "../../AddressForm";

/*const getInitialFormData = () => ({
    infoCompanyDetail: {
        title: null, emailCompany: null, descriptionCompany: '<p style="color: #0B3158"></p>',
        imageUpload: null, quantityEmployees: null, site: null, country: null,
        postIndex: null, address: null, region: '', address_id: null, latitude: null, longtitude: null,
        facebook: null, twitter: null, linkedIn: null, telegram: null, slack: null, instagram: null,
        github: null, surname: null, name: null, phone: null, position: null, email: this.userInfo,
        phones: [], city: null, city_id: '', patronymic: null, typePerson: null, position_id: '',
    },
});*/

export default {
    data: function () {
        return {
            regionsWithCountry: [],
            marker: [53.235963, 34.353203],
            coords: [53.235963, 34.353203],
            settings: this.$apiSettings.yandexMap,
            delivery_path: [[54, 39], [55, 39], [56, 40], [57, 41],],
            center: [54, 39], showMap: false, showManually: true, icon_map: '', selected: 'Выбрать' || 'defaultValue',
            colEmployees: [{id: 1, text: "до 5"}, {id: 2, text: "от 6 до 10"},
                {id: 3, text: "от 11 до 20"}, {id: 4, text: "от 21 до 30"},
                {id: 5, text: "от 31 до 50"}, {id: 6, text: "от 51 до 100"},
                {id: 7, text: "от 101 до 200"}, {id: 6, text: "200 и более"}
            ],
            codePhone: [{id: 1, text: "+7"}, {id: 2, text: "+8"}],
            showProfile: false, maxNameCompany: 100, maxDescriptionCompany: 2000,
            infoCompanyDetail: {
                title: null, emailCompany: null, descriptionCompany: '<p style="color: #0B3158"></p>',
                imageUpload: null, quantityEmployees: null, site: null, country: null,
                postIndex: null, address: null, region: '', address_id: null, latitude: null, longtitude: null,
                facebook: null, twitter: null, linkedIn: null, telegram: null, slack: null, instagram: null,
                github: null, surname: null, name: null, phone: null, position: null, email: this.userInfo,
                phones: [], city: null, city_id: '', patronymic: null, typePerson: null, position_id: '',
            },
            defaultEmail: null, defaultEmailCompany: null,
            imageSrc: null, loading: false, form: [], logo: '',
            phonesSave: [], mePhone_code: '', mePhone_phone: '',
            statusVerify: '', checkProfile: 0,
            resetRegion: false, resetCity: false, hasEmailError: false, phisHasEmailError: false,
            country_id: null, region_id: null, hasError: false,
            regEmail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            errors: null, userInfo: null, temp: {description: null,},
            imageFile: null,
        }
    },
    computed: {
        ...mapGetters({
            allCities: 'AllCities', allCountries: 'AllCountries', allPositions: 'AllPositions',
            infoCompany: 'AllInfoCompanies', regions: 'RegionsWithCountryId',
            citiesWithRegion: 'CityWithRegionId'
        }),
        positions: function () {
            return this.$store.getters.AllPositions;
        },
        user: function () {
            return window.user;
        },
        logoCompany() {
            if (this.infoCompany.image) {
                return '/storage/listings/logos/' + this.user.id + "/" + this.infoCompany.image;
            }
        },
    },
    async mounted() {
        this.loading = true;
        const [positions, currentUser, countries, regions, cities] = await Promise.all([
            this.fetchPositions(),
            this.$store.dispatch("getCurrentUser"),
            this.fetchCountries(),
            this.fetchRegions(),
            this.fetchCities(),
        ]);
        this.center = [53.235963, 34.353203];
        if (this.showMap === false) {
            this.icon_map = 'icons/settings/maps-and-flags.svg';
        } else if (this.showMap === true) {
            this.icon_map = 'icons/settings/maps-and-flagsWhite.svg';
        }
        this.infoCompanyDetail.position = positions[0];
        if (user.role == 3) {
            await this.getStatusVerify();
        }
        this.userInfo = currentUser;
        this.defaultEmail = this.userInfo.email;
        this.defaultEmailCompany = this.userInfo.email;
        await this.fillProfile(this.infoCompany)
        this.loading = false;
        if (this.infoCompanyDetail.country != null) {
            this.country_id = countries?.find(f => f.title == this.infoCompanyDetail.country).id;
        }
        if (this.country_id != null) {
            this.regionsWithCountry = this.regions(this.country_id);
        }
        if (this.infoCompanyDetail.region != null) {
            this.region_id = regions?.find(f => f.title == this.infoCompanyDetail.region)?.id;
        }
        if (this.region_id != null) {
            this.citiesWithRegion(this.region_id);
        }
    },
    components: {
        AddressForm,
        CustomVueEditor,
        MenuComponentCustomer, MenuComponentExecutor, leftMenu, navbar,
        VSelect, extendedinf, yandexMap, ymapMarker, VueEditor
    },
    methods: {
        ...mapActions(["fetchCities", "fetchCountries", "fetchRegions", "fetchPositions", "setInfoCompanies"]),
        getGeocode() {
            axios.get('/get/geocoder', {
                params: {
                    lat: this.coords[0],
                    long: this.coords[1]
                }
            }).then(resp => {
                const {GeoObjectCollection} = resp.data;
                const {GeoObject} = GeoObjectCollection.featureMember[0];

                this.infoCompanyDetail.country = GeoObject?.metaDataProperty?.GeocoderMetaData?.Address?.Component?.[0]?.name?.replace(' ');
                this.infoCompanyDetail.region = GeoObject?.metaDataProperty?.GeocoderMetaData?.Address?.Component?.[2]?.name;
                this.infoCompanyDetail.city = GeoObject?.metaDataProperty?.GeocoderMetaData?.Address?.Component?.[4]?.name;
                this.infoCompanyDetail.address = GeoObject?.name;
                this.infoCompanyDetail.postIndex = GeoObject?.metaDataProperty?.GeocoderMetaData?.Address?.postal_code;
                this.infoCompanyDetail.longtitude = GeoObject?.Point?.pos?.split(' ')?.[1];
                this.infoCompanyDetail.latitude = GeoObject?.Point?.pos?.split(' ')?.[0];

                this.validateCity();
            }).catch(error => {
                console.log(error);
                this.errored = true;
            });
        },
        showLocation: function (e) {
            this.coords = e.get('coords');
            this.center = this.coords;
            this.getGeocode();
        },
        validateCity() {
            axios.post('/create/newCity', {
                titleCountry: this.infoCompanyDetail.country,
                titleRegion: this.infoCompanyDetail.region,
                titleCity: this.infoCompanyDetail.city
            }).then((response) => {
                this.fetchCities()
                this.fetchCountries()
                this.fetchRegions()
            }).catch((error) => {
                console.log(error)
            })
        },
        switchMap() {
            this.showManually = false;
            this.showMap = true
            this.icon_map = 'icons/settings/maps-and-flagsWhite.svg';
        },
        switchManually() {
            this.showManually = true;
            this.showMap = false;
            this.icon_map = 'icons/settings/maps-and-flags.svg';
        },
        showOrHideMenu() {
            this.showProfile = !this.showProfile;
        },
        async saveInfoCompanies() {
            const validationSuccess = await this.$refs.observer.validate();
            if (!validationSuccess) {
                setTimeout(() => {
                    const errors = Object.entries(this.$refs.observer.errors)
                        .map(([key, value]) => ({key, value}))
                        .filter(error => error["value"].length);
                    this.$refs.observer.refs[errors[0]["key"]].$el.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });
                }, 100);
                return;
            }

            this.getErrors();
            if (this.errors['email'] || this.errors['emailPhis'] || this.errors['emailCompany']) {
                return;
            }

            if (this.imageFile) {
                try {
                    await this.uploadImage(this.imageFile);
                } catch (error) {
                    console.error("Ошибка загрузки изображения:", error);
                    alert("Произошла ошибка при загрузке изображения. Пожалуйста, попробуйте снова.");
                    return;
                }
            }

            for (let i = 0; i < this.phonesSave.length; i++) {
                const phone = this.phonesSave[i].phone;
                const code = this.phonesSave[i].code.text || "+7";
                this.infoCompanyDetail.phones.push(`${code}${phone}`);
            }
            if (this.mePhone_phone !== "") {
                const phone = this.mePhone_phone;
                const code = this.mePhone_code?.text || "+7";
                this.infoCompanyDetail.phone = `${code}${phone}`;
            }
            if (this.infoCompanyDetail.city) {
                this.infoCompanyDetail.city_id = this.infoCompanyDetail.city.id ||
                    this.allCities.filter(f => f.title === this.infoCompanyDetail.city)[0]?.id;
            }
            const position = this.allPositions.find(f => f.title === this.infoCompanyDetail.position);
            this.infoCompanyDetail.position_id = position?.id || this.position_id;
            this.infoCompanyDetail.typePerson = this.checkProfile;
            this.infoCompanyDetail.quantityEmployees = this.infoCompanyDetail.quantityEmployees?.text || this.infoCompanyDetail.quantityEmployees;
            this.infoCompanyDetail.title = this.infoCompanyDetail.title ?? null;

            this.infoCompanyDetail.phones = this.infoCompanyDetail.phones.filter(function (value) {
                return value !== "+7" && value !== "+8" && value !== undefined;
            });

            this.loading = true;
            await this.setInfoCompanies(this.infoCompanyDetail);
            await this.$store.dispatch("setNonVerifyUser", {id: this.user.id});
            this.loading = false;
            window.location.reload();
        },
        getErrors() {
            this.errors = {};
            if (this.hasError && this.checkProfile === 0) {
                this.errors['email'] = "Неверный формат ввода email";
            }
            if (this.phisHasEmailError && this.checkProfile === 1) {
                this.errors['emailPhis'] = "Неверный формат ввода email";
            }
            if (this.hasEmailError && this.checkProfile === 0) {
                this.errors['emailCompany'] = "Неверный формат ввода email";
            }
        },
        async getStatusVerify() {
            try {
                const response = await axios.get('/company/verify/' + user.id);
                this.statusVerify = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        uploadImage(image) {
            let formData = new FormData();
            formData.append('file', image);
            this.infoCompanyDetail.imageUpload = "logo." + image.name.split('.')[1];
            axios.post('/uploadLogo/' + user.id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).catch(error => {
                console.log(error);
            });
        },
        async addImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const supportedFormats = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                const file = input.files[0];

                if (!supportedFormats.includes(file.type)) {
                    alert("Неподдерживаемый формат изображения. Пожалуйста, выберите изображение в формате jpg, jpeg, png или gif.");
                    return;
                }

                const reader = new FileReader();
                const vm = this;

                reader.onload = function (e) {
                    const img = new Image();
                    img.src = e.target.result;

                    img.onload = function () {
                        if (img.width < 250 || img.height < 250) {
                            alert("Изображение должно быть не менее 250x250 пикселей");
                            return;
                        }
                        vm.imageFile = file;
                        vm.imageSrc = e.target.result;
                    };

                    img.onerror = function () {
                        alert("Не удалось загрузить изображение. Пожалуйста, попробуйте другой файл.");
                    };
                };

                reader.onerror = function () {
                    alert("Произошла ошибка при чтении файла. Пожалуйста, попробуйте снова.");
                };

                reader.readAsDataURL(file);
            }
        },
        addOncePhone() {
            this.phonesSave.push({code: '+7', phone: ''});
        },
        getCity_id(allCities) {
            this.city_id = allCities.id;
        },
        getPosition_id(allPositions) {
            this.position_id = allPositions.id;
        },
        isEmailValid: function () {
            const emailTrue = this.regEmail.test(this.infoCompanyDetail.emailCompany);
            this.hasError = !emailTrue;
            return emailTrue ? 'has-success' : 'has-error';
        },
        isEmailPersonValid: function () {
            const emailTrue = this.regEmail.test(this.infoCompanyDetail.email);
            this.hasEmailError = !emailTrue;
            return emailTrue ? 'has-success' : 'has-error';
        },
        isEmailPersonPhisValid: function () {
            const emailTrue = this.regEmail.test(this.infoCompanyDetail.email);
            this.phisHasEmailError = !emailTrue;
            return emailTrue ? 'has-success' : 'has-error';
        },
        async fillProfile(newValue) {
            const {
                typePerson, quantityEmployees, patronymic, title, description, phoneCompany, phone, image,
                emailCompany, email, site, postIndex, address, address_id, country, region, city, latitude,
                longtitude, social, surname, name,
                position_id
            } = newValue || {};

            this.checkProfile = typePerson == 1 ? 1 : 0;
            if (this.user.role === 3) {
                this.infoCompanyDetail.quantityEmployees = quantityEmployees;
            }
            if (this.checkProfile === 1) {
                this.infoCompanyDetail.patronymic = patronymic;
            }
            this.infoCompanyDetail.title = title || '';
            this.infoCompanyDetail.descriptionCompany = description || '<p style="color: #0B3158"></p>';
            this.phonesSave = (phoneCompany || []).map((p) => ({code: p.substring(0, 2), phone: p.substring(2)}));
            this.phonesSave.push({code: "+7", phone: ""});
            this.mePhone_code = phone?.substring(0, 2);
            this.mePhone_phone = phone?.substring(2);
            this.infoCompanyDetail.imageUpload = image;
            this.infoCompanyDetail.emailCompany = emailCompany || this.defaultEmail;
            this.infoCompanyDetail.email = email || this.defaultEmail;
            this.infoCompanyDetail.site = site;
            this.infoCompanyDetail.postIndex = postIndex;
            this.infoCompanyDetail.address = address;
            this.infoCompanyDetail.address_id = address_id || null;
            this.infoCompanyDetail.country = country;
            this.infoCompanyDetail.region = region;
            this.infoCompanyDetail.city = city;
            this.infoCompanyDetail.latitude = latitude;
            this.infoCompanyDetail.longtitude = longtitude;
            this.infoCompanyDetail.facebook = social?.facebook;
            this.infoCompanyDetail.twitter = social?.twitter;
            this.infoCompanyDetail.linkedIn = social?.linkedIn;
            this.infoCompanyDetail.telegram = social?.telegram;
            this.infoCompanyDetail.slack = social?.slack;
            this.infoCompanyDetail.instagram = social?.instagram;
            this.infoCompanyDetail.github = social?.github;
            this.infoCompanyDetail.surname = surname;
            this.infoCompanyDetail.name = name;
            this.infoCompanyDetail.position = this.allPositions.find((f) => f.id === position_id) || {};
            this.position_id = position_id;
        },
    },
    watch: {
        async infoCompany(newValue) {
            this.loading = true;
            this.imageSrc = this.logoCompany;
            await this.fillProfile(newValue).then(result => {
                this.loading = false;
            });
        },
        positions(positions_list) {
            this.infoCompanyDetail.position = positions_list.find(item => item.id === this.position_id);
        },
        'infoCompanyDetail.country'(newValue) {
            const {id} = newValue ?? {};
            this.country_id = id;
            if (id) {
                this.regionsWithCountry = this.regions(id);
                this.resetRegion = true;
                this.resetCity = true;
            }
            if (this.resetRegion) this.infoCompanyDetail.region = null;
            if (this.resetCity) this.infoCompanyDetail.city = null;
        },
        'infoCompanyDetail.region'(newValue) {
            const {id} = newValue ?? {};
            this.region_id = id;
            this.citiesWithRegion(id);
            if (id) this.resetCity = true;
            if (this.resetCity) this.infoCompanyDetail.city = null;
        },
    },
}
</script>

<style>
#region.is-invalid,
#city.is-invalid {
    border: none !important;
}

#region.is-invalid .v-select-toggle,
#city.is-invalid .v-select-toggle {
    border: 1px solid #e45868 !important;
}
</style>

<style scoped>
.infoAboutAddress .select-wrapper {
    padding-top: 1rem !important;
}

.is-invalid {
    color: rgb(243, 122, 138) !important;
    border: 1px solid rgb(243, 122, 138) !important;
}

.ql-editor > * {
    color: #0B3158;
}

.viewUser p {
    font-size: 14px;
    color: #2d297d !important;
}

.has-error {
    color: #F37A8A;
    border-color: #F37A8A;
}
</style>
