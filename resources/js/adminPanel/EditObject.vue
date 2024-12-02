<template>
    <div>
        <div class="main-stage-admin">
            <div class="">
                <nav aria-label="breadcrumb" class="pt-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Объекты (Списком)</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Название</li>
                        <a href="/admin/sport-objects/checking">< ВЕРНУТЬСЯ</a>
                    </ol>
                </nav>

                <div class="row m-0">
                    <div class="col-9">
                        <div>
                            <ValidationObserver v-slot="{invalid}" tag="form" @submit.prevent="nextStep" class="col-12">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <h1 class="caption__title">Название и тип объекта</h1>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-8">
                                                <label class="w-100 caption" for="nameOb">Полное название объекта
                                                    <span id="nameOb" class="float-right text-muted font-weight-normal">
                                                    {{ sportObject.title.length }}/300
                                                </span>
                                                    <ValidationProvider rules="required|max:300"
                                                                        v-slot="{ valid, errors, dirty, invalid }">
                                                        <input v-model="sportObject.title" :maxlength="maxNameObject"
                                                               :class="{ 'is-invalid': errors[0] }" type="text"
                                                               required class="form-control input-profile-info w-100"
                                                               placeholder="AquaLife Спортивно-гостиничный комплекс"
                                                               maxlength="300">
                                                    </ValidationProvider>
                                                </label>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <label class="w-100 caption select-wrapper mb-xl-2" for="category">Категория
                                                    объекта
                                                    <v-select id="category" labelTitle="Выбрать" textProp="title"
                                                              valueProp="id" :items="allObjectTypes"
                                                              v-model="sportObject.objectType_title"
                                                              class="selectpicker"
                                                              :options="allObjectTypes" name="category"
                                                              @input="getCategoryId">
                                                    </v-select>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-8 col-sm-8 col-md-2 text-nowrap pt-2 w-100">
                                                <label class="w-100 caption select-wrapper mb-xl-2" for="photo">Фото
                                                    объекта
                                                    <span id="photo"
                                                          class="spanRightMobile pl-4 text-muted font-weight-normal">
                                                        {{ countPhoto }}/10
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="blockUploadImages d-flex d-lg-flex justify-content-start">
                                            <div v-for="(data, index) in sportObject.images" :key="data.id"
                                                 class="blockImage d-flex align-items-center justify-content-center">
                                                <div class="image-preview h-100 position-relative">
                                                    <img @click="openinput" class="img-responsive h-100"
                                                         :src="data" alt="">
                                                    <div @click="removeFile(index)"
                                                         class="align-items-center d-flex justify-content-center position-absolute remove-image">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12.207"
                                                             height="12.206"
                                                             viewBox="0 0 12.207 12.206">
                                                            <rect id="Прямоугольник_6113" data-name="Прямоугольник 6113"
                                                                  width="3.342" height="13.92" rx="1.671"
                                                                  transform="translate(0.001 2.363) rotate(-45)"
                                                                  fill="#9dabb8"/>
                                                            <rect id="Прямоугольник_6114" data-name="Прямоугольник 6114"
                                                                  width="3.34" height="13.92" rx="1.67"
                                                                  transform="translate(9.843 0) rotate(45)"
                                                                  fill="#9dabb8"/>
                                                        </svg>

                                                    </div>
                                                </div>
                                            </div>

                                            <!--v-if="sportObject.files.length < option.maxFileCount"!-->
                                            <div class="image-input image-input-tbd d-flex"
                                                 v-if="false">
                                                <div
                                                    class="image-preview blockImage d-flex justify-content-center align-items-center position-relative"
                                                    @click="openinput">
                                                    <div class="imgUpload"/>
                                                </div>
                                                <input type="file" ref="file" class="d-none" id="vue-file-upload-input"
                                                       @change="addImage">
                                            </div>
                                        </div>

                                        <div class="captionUploadPhoto pl-1 pt-1">
                                            <p class="label">Формат фотографий - не менее 500px по широкой
                                                и узкой стороне / jpg или png без alpha канала</p>
                                        </div>

                                        <div class="row pt-2">
                                            <div
                                                class="col-12 col-sm-12 d-flex d-lg-flex justify-content-start
                                            justify-content-lg-start justify-content-xl-start">
                                                <div
                                                    class="text-left d-lg-flex justify-content-lg-center align-items-lg-center w-100">
                                                    <label class="caption w-100">Описание объекта<span
                                                        class="text-muted float-right font-weight-normal">
                                                    {{ sportObject.description.length }}/2000</span>
                                                        <vue-editor :maxlength="maxDescriptionObject" id="editor1"
                                                                    :editorToolbar="customToolbar"
                                                                    placeholder="Текст вашего сообщения"
                                                                    v-model="sportObject.description"
                                                                    name="description">
                                                            {{ sportObject.description }}
                                                        </vue-editor>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row pt-2">
                                    <div class="col-sm-12">
                                        <div class="row block__services col-lg-12">
                                            <div class="col-sm-12 pb-3 p-0">
                                                <label class="caption">Предоставляемые услуги</label>
                                            </div>

                                            <div class="col-sm-11 col-md-4 m-0 p-0"
                                                 v-for="item in allServices">
                                                <div class="row">
                                                    <div class="input-group mb-4 remember-me-link col-12">
                                                        <div class="input-group-prepend mr-2">
                                                            <input class="sb-checkbox form-check input-group-prepend"
                                                                   type="checkbox"
                                                                   name="services" :id="'service-'+item.id"/>
                                                        </div>
                                                        <label class="form-check-label" :for="'service-'+item.id">
                                                            {{ item.title }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-sm-12">
                                        <div class="row block__services col-lg-12">
                                            <div class="col-sm-12 pb-3 p-0">
                                                <label class="caption">Доступные виды спорта</label>
                                            </div>
                                            <div class="col-sm-11 col-md-4 p-0 m-0" v-for="(item, index) in sportTypes">
                                                <div class="row">
                                                    <div class="input-group mb-4 remember-me-link col-12">
                                                        <div class="input-group-prepend mr-2">
                                                            <input class="sb-checkbox form-check input-group-prepend"
                                                                   type="checkbox"
                                                                   name="sports" :id="'sports-'+item.id"/>
                                                        </div>
                                                        <label class="form-check-label" :for="'sports-'+item.id">
                                                            {{ item.title }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 1%;">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <hr class="hr1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10 col-md-10 pt-3 pl-0">
                                        <label class="caption">условия и цены</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-7">
                                        <div class="row col-12">
                                            <label class="caption w-100">Общее описание условий и правил
                                                проживания<span
                                                    class="text-muted float-right font-weight-normal">
                                            {{ sportObject.termsAndPrices.length }}/1000
                                        </span>
                                                <vue-editor :maxlength="maxDescriptionLive" id="editor"
                                                            :editorToolbar="customToolbar"
                                                            placeholder="Текст вашего сообщения"
                                                            v-model="sportObject.termsAndPrices"
                                                            name="descriptionLive">
                                                    {{ sportObject.termsAndPrices }}
                                                </vue-editor>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-5">
                                        <div class="row">
                                            <label class="caption w-100">Что включено в стоимость проживания<span
                                                class="text-muted float-right font-weight-normal">
                                           {{ sportObject.accomodationConditionAndPricing_included.length - 1 }}/100
                                        </span>
                                            </label>

                                            <div class="closePriceAllLive p-0 d-flex align-items-center col-12"
                                                 v-for="(item, index) in sportObject.accomodationConditionAndPricing_included">
                                                <div class="w-100 d-flex align-items-center">
                                                    <img v-if="item.title !== ''"
                                                         @click.prevent="deleteIncludedPricing(index)"
                                                         class="position-absolute"
                                                         style="z-index: 1; right: 15px"
                                                         src="/icons/stages/exit.svg" alt="exit">
                                                    <div class="col-sm-12 p-0 m-0">
                                                        <div class="h-100 p-1">
                                                            <input type="text" v-model="item.title"
                                                                   autocomplete="off" name="options"
                                                                   placeholder="Введите название опции"
                                                                   class="input-profile-info titleOption w-100 pr-5">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 p-0 m-0 buttonOption">
                                                <button type="button" @click="addIncludedPricing"
                                                        class="btn btn-info cursor-pointer">Добавить опцию +
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-12 col-sm-8 col-md-12">
                                        <type-living-modal :accommodations="sportObject.accommodations"/>
                                        <div v-if="false" class="row">
                                            <modal v-show="isShowModal" :show="isShowModal" :scrollable="true"
                                                   header-id="modalHeader"
                                                   body-id="modalBody" @close="toggleModal">
                                                <template #header>
                                                    <div class="headerIncludePrice__modal d-flex">
                                                        <p style="margin-right: auto !important;" class="caption">
                                                            Добавить стоимость и условия проживания</p>
                                                        <img style="cursor: pointer" @click="toggleModal"
                                                             src="/icons/stages/cancel.svg" alt="">
                                                    </div>
                                                </template>
                                                <template #body>
                                                    <label class="w-100 caption select-wrapper mb-xl-2"
                                                           for="typeObject">Тип объекта
                                                        <v-select id="typeObject" labelTitle="Выбрать"
                                                                  textProp="title" valueProp="id"
                                                                  class="selectpicker mt-1" :options="allAccmTypes"
                                                                  @input="getAccType_id" v-model="titleAccType">
                                                        </v-select>
                                                    </label>
                                                    <label class="caption w-100 mt-4">Описание объекта<span
                                                        class="text-muted float-right font-weight-normal">
                                                    {{ descriptionObjectLive.length }}/500</span>
                                                        <vue-editor :maxlength="maxDescriptionObjectLive" id="editor2"
                                                                    :editorToolbar="customToolbar"
                                                                    v-model="descriptionObjectLive"></vue-editor>
                                                    </label>
                                                    <p class="caption">Стоимость проживания в 2021 году
                                                        <span
                                                            class="additionalyPriceLive text-muted">   (руб за 1 чел. в сутки)</span>
                                                    </p>
                                                    <div class="priceList" v-for="(item, index) in month">
                                                        <div class="month d-flex pt-2 align-items-center">
                                                            <p class="nameMonth align-items-center d-flex m-0">
                                                                {{ item.text }}</p>
                                                            <span class="text mx-auto pl-1 pr-1">от</span>
                                                            <input type="text" name="search-object" maxlength="5"
                                                                   minlength="3"
                                                                   placeholder="100" v-model="minPriceAcc[index]"
                                                                   class="input__price-month" autocomplete="off">
                                                            <span class="text pl-1 pr-1">до</span>
                                                            <input type="text" name="search-object" maxlength="5"
                                                                   minlength="3"
                                                                   placeholder="10 000" v-model="maxPriceAcc[index]"
                                                                   class="input__price-month" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="justify-content-center d-flex pt-3">
                                                        <button type="button" @click="saveTypeLiving" class="btn btn-success
                                        justify-content-center">
                                                            Сохранить
                                                        </button>
                                                    </div>
                                                </template>
                                            </modal>

                                            <modalLivePricing v-if="false" v-show="isShowModalLivePricing"
                                                              :show="isShowModalLivePricing"
                                                              :scrollable="true"
                                                              @close="toggleModalLivePricing"
                                                              header-pricing-id="modalHeader"
                                                              body-pricing-id="modalBody">
                                                <template #header>
                                                    <div class="headerIncludePrice__modal d-flex">
                                                        <p style="margin-right: auto !important;" class="caption">
                                                            Стоимость проживания</p>
                                                        <img style="cursor: pointer"
                                                             @click="toggleModalLivePricing"
                                                             src="/icons/stages/cancel.svg" alt="">
                                                    </div>
                                                </template>
                                                <template #body>
                                                    <table class="table table-responsive">
                                                        <thead>
                                                        <th width="50%">Месяц пребывания 2021</th>
                                                        <th width="50%">Стоимость за 1 человека в сутки</th>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="(item, index) in month">
                                                            <td>{{ item.text }}</td>
                                                            <td>Цена руб.</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </template>
                                            </modalLivePricing>

                                            <div class="col-12 p-0">
                                                <div class="col-sm-12 pb-3 p-0">
                                                    <label class="caption">Типы проживания и стоимость
                                                        <span class="spanRightMobile text-muted font-weight-normal">
                                                    {{ sportObject.accommodations.length }}/100
                                                </span></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 buttonOption pb-4 p-0">
                                                <button type="button" @click="toggleModal" class="btn btn-info">
                                                    Добавить опцию +
                                                </button>
                                            </div>

                                            <div class="blockTypeLiveClose col-12 col-sm-12 col-md-6 pl-0 mb-3"
                                                 v-for="(item, index) in sportObject.accommodations">
                                                <div class="typeLive h-100">
                                                    <div class="block__title d-flex px-3 py-2">
                                                        <p class="caption mr-1">{{
                                                                item.pricing.accomodationType_title
                                                            }}</p>
                                                        <div class="btnFunc d-flex">
                                                            <a @click="editTypeLiving(index)" class="pr-2 mr-1"><span
                                                                class="btnAction align-items-lg-center justify-content-center d-flex"><img
                                                                src="/icons/stages/edit.svg" alt=""></span></a>
                                                            <a @click="deleteTypeLiving(index)"><span
                                                                class="btnAction align-items-lg-center justify-content-center d-flex"><img
                                                                src="/icons/stages/cancel.svg" alt=""></span></a>
                                                        </div>
                                                    </div>
                                                    <div class="block__text" style="min-height: 230px">
                                                        <p class="text p-4">{{ item.pricing.description }}</p>
                                                        <p class="priceForPer pl-4 pr-4 position-absolute"
                                                           style="bottom: 65px;">
                                                            Стоимость (за 1 человека)
                                                        </p>
                                                        <div
                                                            class="block__price d-flex pr-4 pl-4 pb-4 position-absolute"
                                                            style="bottom: 0">
                                                            <span class="text pt-2 pr-2">от</span>
                                                            <span class="priceMin button-blueBorder borderblock  px-3
                                                        d-inline-block py-2 fw-light"
                                                                  style="font-size: calc(1rem);">
                                                                {{ item.pricing.price[0].minPrice }} руб
                                                            </span>
                                                            <span class="text pt-2 pl-2 pr-2">до</span>
                                                            <span class="priceMax button-blueBorder borderblock  px-3
                                                d-inline-block py-2 fw-light mr-2"
                                                                  style="font-size: calc(1rem);">
                                                                {{ item.pricing.price[0].maxPrice }} руб</span>
                                                            <button @click="toggleModalLive(index)" type="button"
                                                                    class="btn btn-info align-items-lg-center
                                                                    justify-content-center d-flex mx-auto">
                                                                <img src="/icons/stages/information.svg" alt=""
                                                                     class="pr-3">
                                                                Подробнее
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row pt-3 pb-3">
                                    <div class="col-12 col-sm-8 col-md-12 p-0">
                                        <infrastructure :infrastructures="sportObject.infrastructures"/>
                                        <div class="row" v-if="false">
                                            <modalInfrastructure v-show="isShowModalInfrastructure"
                                                                 :show="isShowModalInfrastructure"
                                                                 :scrollable="true"
                                                                 header-id="modalHeader"
                                                                 body-id="modalBody"
                                                                 @close="toggleModalInfrastructure">
                                                <template #header>
                                                    <div class="headerIncludePrice__modal d-flex">
                                                        <p style="margin-right: auto !important;" class="caption">
                                                            Добавить
                                                            объект инфраструктуры</p>
                                                        <img style="cursor: pointer"
                                                             @click="toggleModalInfrastructure"
                                                             src="/icons/stages/cancel.svg" alt="">
                                                    </div>
                                                </template>
                                                <template #body>
                                                    <label class="w-100 caption" for="">Название объекта
                                                        <input type="text" name="search-object" autocomplete="off"
                                                               v-model="nameInfrastructure"
                                                               placeholder="Тренажерный зал"
                                                               class="input-profile-info form-control w-100">
                                                    </label>
                                                    <div class="uploadImage">
                                                        <p class="caption">Фотография объекта</p>
                                                        <div class="d-flex">
                                                            <div class="block__upload">
                                                                <div class="block__upload-image"
                                                                     style="width: 110px;height: 110px;">
                                                                    <div
                                                                        class="block__rectangle d-flex justify-content-center"
                                                                        style="overflow: hidden">
                                                                        <img class="img__upload" v-if="!imageSrc"
                                                                             style="width: 30px;"
                                                                             src="/icons/settings/file-upload.svg"
                                                                             alt="">
                                                                        <img alt="" v-show="imageSrc"
                                                                             class="img__upload Image-input__image"
                                                                             :src="imageSrc">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <input type="file" accept="image/jpeg, image/jpg, image/png"
                                                                   class="d-none" id="vue-file-upload-inp"
                                                                   @change="addImageInfrastructure">
                                                            <div class="text d-flex flex-wrap">
                                                                <div @click="openinputInfrastructure"
                                                                     style="cursor:pointer"
                                                                     class="text-upload d-flex align-items-center justify-content-center ml-3">
                                                                    Загрузить новую фотографию
                                                                    <img class="pl-4"
                                                                         src="/icons/stages/file-upload.svg"
                                                                         alt=""/>
                                                                </div>
                                                                <div class="subtitle pl-3 pt-1">Формат фотографий -
                                                                    не менее 500px по широкой и узкой стороне / jpg или
                                                                    png без alpha канала
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <label class="caption w-100">Опции<span
                                                            class="text-muted float-right font-weight-normal">
                                                            {{ countOptions }}/100</span>
                                                        </label>
                                                        <div class="closeOptions p-0 d-flex align-items-center"
                                                             v-for="(item, index) in objectOptionsInfrastruct">
                                                            <img v-if="item.title !== ''" class="position-absolute"
                                                                 @click.prevent="deleteOptionsInfrastruct(index)"
                                                                 style="z-index: 1; right: 45px; cursor:pointer"
                                                                 src="/icons/stages/exit.svg" alt="exit">
                                                            <input type="file" class="d-none"
                                                                   id="file-upload-infrastructure"
                                                                   @change="addImage">
                                                            <div class="col-sm-12 p-0 m-0">
                                                                <div class="h-100 p-1">
                                                                    <input type="text" autocomplete="off"
                                                                           :key="item" name="search-object"
                                                                           v-model="item.title"
                                                                           placeholder="Введите название опции"
                                                                           class="input-price-info form-control w-100">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 p-0 m-0 buttonOption">
                                                            <button type="button" @click="addObjectOptionsInfra"
                                                                    class="btn btn-info">Добавить опцию +
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="justify-content-center d-flex pt-3">
                                                        <button type="button" @click="saveInfrastructure" class="btn btn-success
                                        justify-content-center">Сохранить
                                                        </button>
                                                    </div>
                                                </template>
                                            </modalInfrastructure>

                                            <div class="col-12 p-0">
                                                <div class="col-sm-12 pb-3">
                                                    <p class="caption">Инфраструктура
                                                        <span class="text-muted font-weight-normal">
                                                    {{ sportObject.infrastructures.length }}/100
                                                </span></p>
                                                </div>
                                            </div>
                                            <div
                                                class="buttonOption pb-4 col-12 col-sm-12 d-flex d-xl-flex justify-content-center justify-content-xl-start">
                                                <button type="button" @click="toggleModalInfrastructure"
                                                        class="btn btn-info">
                                                    Добавить опцию +
                                                </button>

                                            </div>
                                            <div class="blockInfrastructure col-12 col-sm-12 col-md-4"
                                                 v-for="(item, index) in sportObject.infrastructures"
                                                 v-if="item.title !== ''">
                                                <div
                                                    class="infrastruct el wrapper shadow bg-white borderblock mb-3">
                                                    <div class="btnFunc d-flex justify-content-end p-2">
                                                        <a @click.prevent="editInfrastructure(index)" class="pr-2"
                                                           href=""><span
                                                            class="btnAction align-items-lg-center justify-content-center d-flex"><img
                                                            src="/icons/stages/edit.svg" alt="edit"></span></a>
                                                        <a @click.prevent="deleteInfrastructure(index)"><span
                                                            class="btnAction align-items-lg-center justify-content-center d-flex"><img
                                                            src="/icons/stages/cancel.svg" alt="del"></span></a>
                                                    </div>
                                                    <div class="ul__list_objects">
                                                        <img :src="item.image && item.image != '/storage/listings/infrastruct/null'
                                                    ? item.image : '/images/no-photo.png'" alt="Image"
                                                             style="border-radius: 8px 8px 0 0" class="el__img w-100">
                                                        <p class="el__title p-4">{{ item.title }}</p>
                                                        <ul class="list-overflow mx-2 pb-4">
                                                            <li v-for="(option, index) in item.options"
                                                                v-if="option.title !== ''">
                                                                <p class="fs-6 opacity-7">
                                                                    {{ option.title }}</p>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div
                                                        class="justify-content-center align-items-lg-center d-flex">
                                                        <button type="button"
                                                                class="btn btn-info btnViewFull justify-content-between mb-3">
                                                            Показать полностью
                                                            <img src="/icons/arrowDownBlue.svg" alt="">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="block__address-main_info p-0 pt-4 pb-2">
                                        <h5 class="caption__title">Адрес объекта</h5>
                                        <div class="addAddressButton d-flex pb-2">
                                            <button type="button" @click="switchManually"
                                                    :class="{ 'button-blue': showManually, 'button-border': showMap }"
                                                    class="button mr-2">Ввести вручную
                                            </button>
                                            <button type="button" class="button" @click="switchMap"
                                                    :class="{ 'button-blue': showMap, 'button-border': showManually }">
                                                <img class="pr-3" :src="image" alt=""> Указать на карте
                                            </button>
                                        </div>
                                        <div class="infoAboutAddress" v-if="showManually">
                                            <div class="row">
                                                <div class="col-lg-6 ">
                                                    <label class="w-100 caption select-wrapper mb-xl-2" for="">Страна
                                                        <v-select labelTitle="Выбрать" class="selectpicker"
                                                                  @input="getCountry_id"
                                                                  :options="allCountries" textProp="title"
                                                                  valueProp="id">
                                                        </v-select>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6 ">
                                                    <label class="w-100 caption select-wrapper mb-xl-2" for="">Область,
                                                        округ, провинция
                                                        <v-select labelTitle="Выбрать" class="selectpicker"

                                                                  @input="getRegions_id"
                                                                  :options="regionsWithCountry(country_id)"
                                                                  textProp="title" valueProp="id">
                                                        </v-select>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="w-100 caption select-wrapper mb-xl-2" for="">Город
                                                        (населенный пункт)
                                                        <v-select labelTitle="Выбрать"
                                                                  v-model="sportObject.address.city"
                                                                  class="selectpicker" @input="getCity_id"
                                                                  :options="citiesWithRegion(region_id)"
                                                                  textProp="title" valueProp="id">
                                                        </v-select>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="w-100 caption" for="">Почтовый индекс
                                                        <ValidationProvider rules="required|numeric|max:6|min:6"
                                                                            v-slot="{ valid, errors, dirty, invalid }">
                                                            <input type="text" v-model="sportObject.address.postIndex"
                                                                   :class="{ 'is-valid': dirty && valid, 'is-invalid': dirty && invalid }"
                                                                   placeholder="000 000" class="input-profile-info"
                                                                   autocomplete="off" pattern="^([0-9]+)$"
                                                                   maxlength="6" minlength="6" required>
                                                        </ValidationProvider>
                                                    </label>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label class="w-100 caption" for="">Улица, номер дома и офиса
                                                        <input type="text" v-model="sportObject.address.street"
                                                               placeholder="Введите имя улицы, номер дома и офиса"
                                                               class="input-profile-info"
                                                               autocomplete="off">
                                                    </label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="w-100 caption" for="">Географические координаты -
                                                        широта
                                                        <input type="text" v-model="sportObject.address.latitude"
                                                               placeholder="Широта" class="input-profile-info"
                                                               autocomplete="off">
                                                    </label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="w-100 caption" for="">Долгота
                                                        <input type="text" placeholder="Долгота"
                                                               class="input-profile-info" autocomplete="off"
                                                               v-model="sportObject.address.longtitude">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mapAddress pt-3" v-if="showMap" style="height: 300px">
                                            <yandex-map @click="showLocation" style="height:100%" :coords="center"
                                                        :zoom="17" :settings="settings">
                                                <ymap-marker v-model="marker" @input="getCity_id"
                                                             marker-type="placemark" :coords="coords" :markerId="1"
                                                             :icon="{color: 'green', glyph: 'bicycle'}"
                                                             :options="{draggable:true, iconShadow:true, iconShadowImageOffset:[2,-20],
                                                    iconShadowImageSize: [29, 7]}"/>
                                            </yandex-map>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="block_rul col-sm-12 mt-4">
                                        <div class="text-center">
                                            <p class="text__rules d-flex">
                                                <img class="pr-3" src="/icons/stages/information.svg">
                                                <span class="confidently">Нажимая на кнопку "Далее", вы соглашаетесь с
                                            <a href="#">Правилами платформы</a> и
                                            <a href="#">Политикой Конфиденицальности</a>
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12 d-flex pt-4 pb-4">
                                    <div class="text-center mx-auto">
                                        <button type="submit" class="btn btn-success justify-content-center">Далее
                                        </button>
                                    </div>
                                </div>
                            </ValidationObserver>
                        </div>

                    </div>
                    <div class="col-3">
                        <div class="borderBlockBottom p-2 blockInfoAdvertistime">
                            <div class="blockOwner">
                                <div class="d-flex">
                                    <img :src="'/storage/listings/logos/' + sportObject.created.user_id + '/'
                                        + sportObject.created.image" alt="" style="width: 20px; height: 20px">
                                    <a :href="'/admin/users/profile/' + sportObject.id">
                                        {{ sportObject.created.title }} (ID:{{ sportObject.created.user_id }})
                                    </a>
                                </div>
                            </div>
                            <div class="blockAdvertistime">
                                <p><b>Реклама и продвижение</b></p>
                                <p>Тариф: <span>Продвижение в каталоге</span></p>
                                <p>Сроки и стоимость: <span>12 дней, 456,78руб</span></p>
                            </div>
                            <div class="blockControl">
                                <p><b>Управление</b></p>
                                <div class="sb-actions d-flex flex-column">
                                    <button class="btn text-left"
                                            v-if="sportObject.verify === 0">
                                        <img src="/icons/settings/check-mark.svg" alt="">
                                        ОДОБРИТЬ ОБЪЕКТ
                                    </button>
                                    <button class="btn text-left">
                                        <img src="/icons/tenders/close-button.svg" alt="">
                                        УДАЛИТЬ ОБЪЕКТ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {yandexMap, ymapMarker} from 'vue-yandex-maps';
import VSelect from "@alfsnd/vue-bootstrap-select";
import modal from '../../js/components/addObject/ModalLiving.vue';
import modalInfrastructure from '../../js/components/addObject/ModalInfrastructure.vue';
import axios from "axios";
import {mapActions, mapGetters} from "vuex";
import TypeLivingModal from "./elements/TypeLivingModal";
import Infrastructure from "./elements/Infrastructure";

export default {
    props: {
        objectData: {
            type: String,
            default: null
        }
    },
    data: function () {
        return {
            sportObject: {
                title: '', objectType_id: null, objectType_name: '', sportType_id: 1, images: [], description: '',
                files: [], storageImages: [], formData: [],
                services: [], sports: [], pricing: {description: '', included: [], typeLiving: [], infrastructures: []},
                address: {
                    country: null, region: null, city: null, postIndex: null, street: null, latitude: null,
                    longtitude: null, city_id: null
                }, user_id: user.id, accomodationConditionAndPricing_id: null,
            }, resetCity: false, resetRegion: false,
            marker: [], coords: [53.235963, 34.353203],
            maxNameObject: 300, maxDescriptionObject: 2000, maxDescriptionLive: 1000, maxDescriptionObjectLive: 500,
            descriptionObjectLive: '',
            customToolbar: [
                [{'header': [1, 2, 3, 4, 5, 6, false]}],
                [{
                    'color': ['#0B3158', '#000000', '#e60000', '#ff9900', '#ffff00', '#008a00', '#0066cc', '#9933ff', '#ffffff'],
                    'background': []
                }],
                ['bold', 'italic'],
                [{'list': 'bullet'}, {'list': 'ordered'}, {'align': []}],
            ],
            image: '', showMap: false, showManually: true,
            settings: this.$apiSettings.yandexMap, center: [53.235963, 34.353203],
            countOptions: 0, countPhoto: 0,
            errored: false, loading: false, country_id: '', region_id: '', option: {maxFileCount: 10},
            nextIdIncludedPrice: 0, nextIdOptions: 0, objectOptions: [], isShowModal: false, modalOpen: false,
            isShowModalInfrastructure: false, isShowModalLivePricing: false, modalOpenInfrastructure: false,
            month: [{id: 0, text: 'Январь', title: 'january'}, {id: 1, text: 'Февраль', title: 'february'},
                {id: 2, text: 'Март', title: 'march'}, {id: 3, text: 'Апрель', title: 'april'},
                {id: 4, text: 'Май', title: 'may'}, {id: 5, text: 'Июнь', title: 'june'},
                {id: 6, text: 'Июль', title: 'jule'}, {id: 7, text: 'Август', title: 'august'},
                {id: 8, text: 'Сентябрь', title: 'september'}, {id: 9, text: 'Октябрь', title: 'october'},
                {id: 10, text: 'Ноябрь', title: 'november'}, {id: 11, text: 'Декабрь', title: 'december'}],
            formData: '',
            accType_id: null, livePricing: [], addAccTypeAndPrice: [], minPriceAcc: [], maxPriceAcc: [],
            ImageInfrastructure: '', nameInfrastructure: '', titleAccType: '', countObject: 0, infrastructureId: 0,
            objectOptionsInfrastruct: [], actionSaveTypeLive: false, imageSrc: '', imageInfrastructures: '',
            editInfrastructBool: false, id_editTypeLive: null, id_editInfrastructure: null, file: '', fileId: 1,
        }
    },
    components: {
        Infrastructure,
        TypeLivingModal,
        yandexMap, ymapMarker, VSelect, modal, modalInfrastructure,
    },
    watch: {
        objectEdit: {
            handler: function (object) {
                if (object) {
                    let services = [];
                    let sports = [];
                    let pricing = [];
                    let infrastructures = [];

                    this.sportObject.title = object.title;
                    this.sportObject.objectType_name = object.objectType_title;
                    this.sportObject.description = object.description;

                    for (let i = 0; i < object.services.length; i++)
                        services.push(object.services[i].service_id.id);
                    this.sportObject.services = services;

                    for (let i = 0; i < object.sports.length; i++)
                        sports.push(object.sports[i].sportType_id);
                    this.sportObject.sports = services;
                    this.sportObject.pricing.description = object.accomodationConditionAndPricing_description;
                    this.sportObject.pricing.included = object.accomodationConditionAndPricing_included;

                    for (let i = 0; i < object.accommodations.length; i++) {
                        pricing.push({
                            'id': this.countObject,
                            'idAccType': object.accommodations[i].pricing.idAccType,
                            'title': object.accommodations[i].pricing.accomodationType_title,
                            'description': object.accommodations[i].pricing.description,
                            'price': object.accommodations[i].pricing.price,
                        });
                        this.countObject++;
                    }
                    this.sportObject.pricing.typeLiving = pricing;

                    for (let i = 0; i < object.infrastructures.length; i++) {
                        infrastructures.push({
                            'id': this.infrastructureId,
                            'title': object.infrastructures[i].title,
                            'image': '/storage/listings/infrastruct/' + object.infrastructures[i].image,
                            'imageInfr': object.infrastructures[i].image,
                            'options': object.infrastructures[i].options,
                        });
                        this.infrastructureId++;
                    }
                    this.sportObject.pricing.infrastructures = infrastructures;

                    this.sportObject.address.city_id = object.city_id;
                    this.sportObject.address.country = object.country;
                    this.sportObject.address.region = object.region;
                    this.sportObject.address.city = object.city;

                    this.sportObject.address.postIndex = object.postIndex;
                    this.sportObject.address.street = object.address;
                    this.sportObject.address.longtitude = object.longtitude;
                    this.sportObject.address.latitude = object.latitude;

                }
            }, deep: true
        },
        sportObject: {
            handler: function (sportObject) {
                this.setStoreSportObject(sportObject);
            }, deep: true
        },
        descriptionObject: function () {
            const str = this.sportObject.description;
            //this.sportObject.description = str.replace(/<\/?[^>]+(>|$)/g, "");
        },
        descriptionObjectLive: function () {
            const str = this.descriptionObjectLive;
            //this.descriptionObjectLive = str.replace(/<\/?[^>]+(>|$)/g, "");
        },
    },
    computed: {
        ...mapGetters({
            sportTypes: 'AllSportTypes', allCities: 'AllCities', allCountries: 'AllCountries', allRegions: 'AllRegions',
            regionsWithCountry: 'RegionsWithCountryId', citiesWithRegion: 'CityWithRegionId',
            allObjectTypes: 'AllObjectTypes', allServices: 'AllServices', allAccmTypes: "AllAccomodationTypes",
            createObject: "CreateSportObject",
        }),
        country() {
            return this.allCountries.filter(item => item.title === this.sportObject.address.country)[0].title ?? this.sportObject.address.country
        },
        region() {
            return this.allRegions.filter(item => item.title === this.sportObject.address.region)[0].title ?? this.sportObject.address.region
        },
        city() {
            return this.allCities.filter(item => item.title === this.sportObject.address.city)[0].title ?? this.sportObject.address.city
        },
        city_id() {
            return this.allCities.filter(item => item.title === this.sportObject.address.city)[0]
        },
        user: function () {
            return window.user;
        },
        /* sportObject() {
             return this.$store.getters.SportObject(this.$props.id);
         }*/
    },
    methods: {
        ...mapActions(["fetchSportTypes", "fetchCities", "fetchCountries", "fetchRegions", "fetchObjectTypes",
            "fetchServices", "fetchAccomodationTypes", "setStoreSportObject"]),
        deleteTags(text) {
            return text.replace(/<\/?[^>]+(>|$)/g, "");
        },
        openinput: function () {
            document.getElementById("vue-file-upload-input").click();
        },
        addImage: function (e) {
            const tmpFiles = e.target.files;
            if (tmpFiles.length === 0) {
                return false;
            }
            const file = tmpFiles[0]
            let formData = new FormData();
            formData.append('file', file);

            axios.post('/uploadImages/' + this.fileId, formData, {
                'headers': {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                console.log(response);
                this.fileId++;
                this.sportObject.storageImages.push(response.data);
            })

            this.sportObject.files.push(file)
            const self = this
            const reader = new FileReader()
            reader.onload = function (e) {
                self.sportObject.images.push(e.target.result)
            }
            reader.readAsDataURL(file);
            this.countPhoto++;
        },
        removeFile: function (index) {
            this.sportObject.files.splice(index, 1)
            this.sportObject.images.splice(index, 1)
            this.sportObject.storageImages.splice(index, 1)
            document.getElementById("vue-file-upload-input").value = null
            /*axios.post('/removeImage', formData, {
                'headers': {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
            })*/

            /* if (this.countPhoto !== 0) this.countPhoto--;*/
        },
        addIncludedPricing() {
            if (this.sportObject.pricing.included.length - 1 < 101) {
                if (this.sportObject.pricing.included[this.nextIdIncludedPrice].title !== '') {
                    this.sportObject.pricing.included.push({
                        id: this.nextIdIncludedPrice,
                        title: this.sportObject.pricing.included[this.nextIdIncludedPrice].title
                    })
                    this.nextIdIncludedPrice++;
                    this.sportObject.pricing.included[this.nextIdIncludedPrice].title = '';
                }
            }
        },
        deleteIncludedPricing(index) {
            if (this.sportObject.pricing.included.length > 1) {
                this.$delete(this.sportObject.pricing.included, index);
                this.nextIdIncludedPrice--;
            }
        },
        getGeocode() {
            axios.get('/get/geocoder', {
                params: {
                    api: 'a5dcb900-70e8-4ce9-9128-481140e584c3',
                    lat: this.coords[0],
                    long: this.coords[1]
                }
            })
                .then(resp => {
                    this.sportObject.address.country = resp.data.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.Address.Component[0].name.replace(' ');
                    this.sportObject.address.region = resp.data.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.Address.Component[2].name;
                    this.sportObject.address.city = resp.data.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.Address.Component[4].name;
                    this.sportObject.address.city_id = this.city_id.id;
                    this.sportObject.address.street = resp.data.GeoObjectCollection.featureMember[0].GeoObject.name;
                    this.sportObject.address.postIndex = resp.data.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.Address.postal_code;
                    this.sportObject.address.longtitude = resp.data.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ')[1];
                    this.sportObject.address.latitude = resp.data.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ')[0];

                    this.validateCity();
                })
                .catch(error => {
                    console.log(error);
                    this.errored = true;
                });
        },
        showLocation: function (e) {
            this.coords = e.get('coords');
            this.getGeocode();
        },
        getCountry_id(allCountries) {
            this.country_id = allCountries.id;
            this.sportObject.address.country = this.country;
            this.regionsWithCountry(this.country_id);
            if (this.country_id) {
                this.resetRegion = true;
                this.resetCity = true;
            }
            if (this.resetRegion) this.sportObject.address.region = null;
            if (this.resetCity) this.sportObject.address.city = null;
        },
        getRegions_id(allRegions) {
            this.region_id = allRegions.id;
            this.sportObject.address.region = this.region

            this.citiesWithRegion(this.region_id);
            if (this.region_id) this.resetCity = true;
            if (this.resetCity) this.sportObject.address.city = null;
        },
        /*Действия "типы проживания и стоимость"*/
        toggleModal() {
            this.actionSaveTypeLive = false;
            this.isShowModal = !this.isShowModal;
            this.titleAccType = 'Выбрать';
            this.descriptionObjectLive = '';
            this.minPriceAcc = [];
            this.maxPriceAcc = [];

        },
        getPricing() {
            this.addAccTypeAndPrice = [];
            for (let i = 0; i < 12; i++) {
                this.addAccTypeAndPrice.push({
                    id: i,
                    title: this.month[i].title,
                    minPrice: this.minPriceAcc[i] === undefined ? 0 : this.minPriceAcc[i],
                    maxPrice: this.minPriceAcc[i] === undefined ? 0 : this.maxPriceAcc[i],
                });
            }
        },
        saveTypeLiving() {
            if (this.actionSaveTypeLive === false) {
                this.getPricing();
                this.descriptionObjectLive.replace(/<\/?[^>]+(>|$)/g, "");

                this.sportObject.pricing.typeLiving.push({
                    'id': this.countObject,
                    'idAccType': this.accType_id,
                    'title': this.titleAccType,
                    'description': this.descriptionObjectLive,
                    'price': this.addAccTypeAndPrice,
                });
                this.countObject++;
            } else {
                this.getPricing();
                this.sportObject.pricing.typeLiving[this.id_editTypeLive].title = this.titleAccType;
                this.sportObject.pricing.typeLiving[this.id_editTypeLive].idAccType = this.accType_id;
                this.sportObject.pricing.typeLiving[this.id_editTypeLive].description = this.descriptionObjectLive;
                this.sportObject.pricing.typeLiving[this.id_editTypeLive].price = this.addAccTypeAndPrice;
            }
            this.toggleModal();
        },
        editTypeLiving(index) {
            this.isShowModal = !this.isShowModal;
            this.actionSaveTypeLive = true;
            this.id_editTypeLive = index;

            this.titleAccType = this.sportObject.pricing.typeLiving[index].title;
            this.descriptionObjectLive = this.sportObject.pricing.typeLiving[index].description;
            for (let i = 0; i < 12; i++) {
                this.minPriceAcc[i] = this.sportObject.pricing.typeLiving[index].price[i].minPrice;
                this.maxPriceAcc[i] = this.sportObject.pricing.typeLiving[index].price[i].maxPrice;
            }
        },
        deleteTypeLiving(index) {
            this.$delete(this.sportObject.pricing.typeLiving, index);
        },

        /*Инфраструктура*/
        addObjectOptionsInfra() {
            if (this.countOptions < 101) {
                if (this.objectOptionsInfrastruct[this.nextIdOptions].title !== '') {
                    this.objectOptionsInfrastruct.push({
                        id: this.nextIdOptions,
                        title: this.objectOptionsInfrastruct[this.nextIdOptions].title
                    });

                    this.countOptions++;
                    this.nextIdOptions++;
                    this.objectOptionsInfrastruct[this.nextIdOptions].title = '';
                }
            }
        },

        uploadImageInfrastruct(image) {
            let formData = new FormData();
            formData.append('file', image);
            this.imageInfrastructures = image.name;

            axios.post('/uploadImages/infrastruct', formData, {
                'headers': {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                console.log(response.data);
            })
        },
        addImageInfrastructure: function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const vm = this;
                reader.onload = function (e) {
                    vm.imageSrc = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
                this.uploadImageInfrastruct(input.files[0]);
            }
        },
        saveInfrastructure() {
            if (this.editInfrastructBool) {
                this.sportObject.pricing.infrastructures[this.id_editInfrastructure].title = this.nameInfrastructure;
                this.sportObject.pricing.infrastructures[this.id_editInfrastructure].options = this.objectOptionsInfrastruct;
                this.toggleModalInfrastructure();

            } else if (!this.editInfrastructBool && this.nameInfrastructure !== '') {
                this.sportObject.pricing.infrastructures.push({
                    'id': this.infrastructureId++,
                    'title': this.nameInfrastructure,
                    'image': this.imageSrc,
                    'imageInfr': this.imageInfrastructures,
                    'options': this.objectOptionsInfrastruct,
                });
                this.toggleModalInfrastructure();
            }
        },
        editInfrastructure(index) {
            this.id_editInfrastructure = index;
            this.isShowModalInfrastructure = !this.isShowModalInfrastructure;
            this.nameInfrastructure = this.sportObject.pricing.infrastructures[index].title;
            this.imageSrc = this.sportObject.pricing.infrastructures[index].image;
            this.objectOptionsInfrastruct = this.sportObject.pricing.infrastructures[index].options;
            this.countOptions = this.sportObject.pricing.infrastructures[index].options.length - 1;
            this.nextIdOptions = this.sportObject.pricing.infrastructures[index].options.length - 1;
            this.editInfrastructBool = true;
        },
        deleteInfrastructure(index) {
            this.$delete(this.sportObject.pricing.infrastructures, index);
        },
        deleteOptionsInfrastruct(index) {
            if (this.countOptions > 0) {
                this.$delete(this.objectOptionsInfrastruct, index)
                this.countOptions--;
                this.nextIdOptions--;
            }
        },
        toggleModalInfrastructure() {
            this.isShowModalInfrastructure = !this.isShowModalInfrastructure;
            this.nameInfrastructure = '';
            this.imageSrc = '';
            this.objectOptionsInfrastruct = [];
            this.objectOptionsInfrastruct.push({
                id: 0,
                title: ''
            });
            this.countOptions = 0;
            this.nextIdOptions = 0;
        },
        toggleModalLivePricing() {
            this.isShowModalLivePricing = !this.isShowModalLivePricing;
        },
        toggleModalLive(index) {
            this.livePricing = this.sportObject.pricing.typeLiving[index];
            this.isShowModalLivePricing = !this.isShowModalLivePricing;
        },
        showModalInfrastructure() {
            this.modalOpenInfrastructure = true;
            this.$refs.modalInfrastructure.focus();
            this.$nextTick(() => {
                this.$refs.modalInfrastructure.focus();
            });
        },

        switchMap() {
            this.showManually = false;
            this.showMap = true
            this.image = 'icons/settings/maps-and-flagsWhite.svg';
        },
        switchManually() {
            this.showManually = true;
            this.showMap = false;
            this.image = 'icons/settings/maps-and-flags.svg';
        },
        openinputInfrastructure: function () {
            document.getElementById("vue-file-upload-inp").click();
        },
        showModal() {
            this.modalOpen = true;
            this.$refs.modal.focus();
            this.$nextTick(() => {
                this.$refs.modal.focus();
            });
        },
        getCategoryId(category) {
            this.sportObject.objectType_id = category.id;
        },
        getAccType_id(accType) {
            this.accType_id = accType.id;
            console.log(this.accType_id)
        },
        getCity_id(cities) {
            this.sportObject.address.city_id = cities.id;
        },
        closeModalInfrustruct() {
            this.$emit('close');
        },

        validateCity() {
            axios.post('/create/newCity', {
                titleCountry: this.sportObject.address.country,
                titleRegion: this.region_name,
                titleCity: this.sportObject.address.city
            }).then((response) => {
                console.log(response.data)
                this.fetchCities()
                this.fetchCountries()
                this.fetchRegions()
            }).catch((error) => {
                console.log(error)
            })
        },
        nextStep: function () {
            if (this.sportObject.description.length === 0) return;
            this.$emit('nextStep');
        },

    },
    mounted() {
        this.center = [53.235963, 34.353203];
        if (this.showMap === false) {
            this.image =
                '/icons/settings/maps-and-flags.svg';
        } else if (this.showMap === true) {
            this.image =
                '/icons/settings/maps-and-flagsWhite.svg';
        }

        /*this.sportObject.pricing.included.push({
            id: 0,
            title: ''
        })*/
    },
    created() {
        this.fetchObjectTypes();
        this.fetchSportTypes();
        this.fetchCities();
        this.fetchCountries();
        this.fetchRegions();
        this.fetchServices();
        this.fetchAccomodationTypes();

        console.log(JSON.parse(this.objectData));
        this.sportObject = JSON.parse(this.objectData);
    },
}
</script>

<style scoped>
body {
    font-size: 14px !important;
}

.aboutObject .label-checkbox-wrapp__label {
    cursor: context-menu;
}

.main-stage-admin .label-checkbox-wrapp__label {
    background-color: #f2f2f2;
    padding: 0.5rem;
    align-items: center;
    display: inline-flex;
}

.main-stage-admin .serviceOn,
.main-stage-admin .typeLive,
.main-stage-admin .block__title {
    background-color: #f2f2f2;
}

.ul__list_objects {
    background-color: #f2f2f2;
}

.blockInfoAdvertistime > p {
    font-size: 12px;
}

.blockInfoAdvertistime {
    border: 1px solid darkgrey;
}

button {
    color: white;
    border-radius: 5px;
    font-size: 16px;
}
</style>
