<template>
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h4 class="title fw-bold pb-2 addInform">Редактирование профиля пользователя</h4>
            <div class="align-items-center d-flex">

            </div>
        </div>
        <ValidationObserver v-slot="props" tag="form" ref="observer" @submit.prevent="onSave">
            <div class="row">
                <div class="col-lg-6">
                    <h5 style="color: green">Основная информация</h5>
                    <div class="row about__company">
                        <div class="col-lg-4">
                            <label class="w-100 caption">Логотип компании
                                <div class="block__upload flex-wrap">
                                    <div class="block__upload-image d-flex justify-content-center"
                                         style="width: 180px;height: 110px; border: 1px solid lightgray; border-radius: 10px; cursor: pointer">
                                        <img :src="'/images/default/user.png'" style="border-radius: 10px" class=""
                                             alt="upload">
                                    </div>
                                    <input ref="logoExecutor" type="file" class="d-none"
                                           accept="image/jpeg, image/jpg, image/png">
                                    <p class="caption__logo">Высота и ширина должны
                                        быть не мнее 250х250 пикс.</p>
                                </div>
                            </label>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ValidationProvider rules="required" vid="title" v-slot="{ errors, failed }">
                                        <div class="name-wrapper w-100 my-2 me-3 mb-xl-2">
                                            <label class="w-100 caption">Название компании
                                                <span style="color: rgb(243, 122, 138)">*</span>
                                                <span class="float-right text-muted font-weight-normal">
                                                    <!--{{ infoCompanyDetail.title.length }} /100!-->
                                                        </span>
                                                <input v-model="infoCompanyDetail.mainInfo.title" type="text"
                                                       :class="{ 'is-invalid': failed }"
                                                       placeholder="ПромТехИнвест" class="input-profile-info w-100"
                                                       autocomplete="off">
                                            </label>
                                            <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="w-100 caption">Номер телефона
                                        <div class="row">
                                            <div class="row p-0 m-0"
                                                 v-for="(phone, index) in infoCompanyDetail.mainInfo.phones">
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
                                                           class="input-profile-info w-100">
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
                                    <ValidationProvider rules="required" v-slot="{errors}" vid="email">
                                        <label class="w-100 caption">Email адрес (компании)
                                            <span style="color: rgb(243, 122, 138)">*</span>
                                            <span v-show="hasError" class="error-valid">неверный формат записи</span>
                                            <input v-model="infoCompanyDetail.mainInfo.email" type="text"
                                                   :class="[isEmailValid()]" placeholder="mail@mail.com"
                                                   class="input-profile-info w-100">
                                        </label>
                                        <span class="error-valid" v-if="errors[0]">{{ errors[0] }}</span>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="w-100 caption">Адрес сайта
                                        <input v-model="infoCompanyDetail.mainInfo.site" type="text"
                                               placeholder="www.sitename.com"
                                               class="input-profile-info w-100">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row about__company">
                        <div class="col-lg-12 h-100">
                            <custom-vue-editor :max-length="maxDescriptionCompany" :props="props"
                                               @update:text="infoCompanyDetail.mainInfo.description = $event"
                                               :text="infoCompanyDetail.mainInfo.description"
                                               text-label="Описание компании"/>
                        </div>
                    </div>
                    <div class="row about__company">
                        <div class="col-lg-12">
                            <address-form :show-input="true" :title-block="'Адрес компании (для отображения на сайте)'"
                                          default-class="w-100"
                                          :map-height="500" :address-prop="infoCompanyDetail.address"
                                          :coords="[infoCompanyDetail.address.latitude, infoCompanyDetail.address.longtitude]"
                                          @update-address="infoCompanyDetail.address = $event">

                            </address-form>
                        </div>
                    </div>
                    <div class="row about__company mt-3">
                        <div class="col-lg-12">
                            <h5 style="color: green">Социальные сети и мессенжеры</h5>
                            <div class="row">
                                <div class="col-lg-4" v-for="(value, key) in infoCompanyDetail.social" :key="key">
                                    <label class="w-100 caption text-capitalize">{{ key }}
                                        <input v-model="infoCompanyDetail.social[key]" type="text"
                                               class="input-profile-info w-100">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row about__company mt-3">
                        <div class="col-lg-12">
                            <h5 style="color: green">Личные данные пользователя</h5>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="w-100 caption">Фамилия
                                        <input v-model="infoCompanyDetail.personalInfo.surname" type="text"
                                               class="input-profile-info w-100">
                                    </label>
                                </div>
                                <div class="col-lg-4">
                                    <label class="w-100 caption">Имя
                                        <input v-model="infoCompanyDetail.personalInfo.name" type="text"
                                               class="input-profile-info w-100">
                                    </label>
                                </div>
                                <div class="col-lg-4">
                                    <label class="w-100 caption">Отчество
                                        <input v-model="infoCompanyDetail.personalInfo.patronymic" type="text"
                                               class="input-profile-info w-100">
                                    </label>
                                </div>
                                <div class="align-items-end col-lg-4 d-flex">
                                    <div class="d-flex flex-column w-100">
                                        <label class="w-100 caption">Должность</label>
                                        <v-select v-model="infoCompanyDetail.personalInfo.position" labelTitle="Выбрать"
                                                  class="selectpicker select-wrapper"
                                                  :options="['Тренер', 'Директор', 'Менеджер', 'HR']"
                                                  textProp="title" valueProp="id"></v-select>
                                    </div>
                                </div>
                                <div class="align-items-end col-lg-4 d-flex">
                                    <label class="w-100 caption">Email адрес (рабочий или личный)
                                        <input v-model="infoCompanyDetail.personalInfo.email" type="text"
                                               class="input-profile-info w-100">
                                    </label>
                                </div>
                                <div class="align-items-end col-lg-4 d-flex">
                                    <label class="w-100 caption">Номер телефона
                                        <input v-model="infoCompanyDetail.personalInfo.phones" type="text"
                                               class="input-profile-info w-100">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row about__profile">
                        <div class="row w-100" v-if="infoCompanyDetail.payment">
                            <div class="col-12">
                                <h5 class="title fw-bold pb-2 addInform" style="color: green">Платежные реквизиты</h5>
                                <table class="p-2 table table-bordered w-100">
                                    <tr>
                                        <td><b>Юридическое наименование</b></td>
                                        <td class="d-flex">
                                            <v-select v-model="infoCompanyDetail.payment.legal_name" labelTitle="Выбрать"
                                                      class="selectpicker select-wrapper mr-3"
                                                      :options="['ООО', 'ОАО', 'ЗАО']"
                                                      textProp="title" valueProp="id"></v-select>
                                            <input v-model="infoCompanyDetail.payment.title" class="form-control"
                                                   type="text">
                                        </td>
                                    </tr>
                                    <tr v-for="(value, key) in infoCompanyDetail.payment" :key="key"
                                        v-if="paymentFields.hasOwnProperty(key)">
                                        <td width="30%"><b>{{ paymentFields[key] }}</b></td>
                                        <td>
                                            <input v-model="infoCompanyDetail.payment[key]" class="form-control"
                                                   type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Адрес компании</b></td>
                                        <td><i class="fa fa-map-marker"></i>
                                            {{ infoCompanyDetail.payment.address.city }}, {{
                                                infoCompanyDetail.payment.address.address
                                            }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row about__profile">
                        <div class="col-lg-12">
                            <address-form :show-input="true" :title-block="'Адрес (юридич.)'"
                                          default-class="w-100"
                                          :map-height="500" :address-prop="infoCompanyDetail.payment.address"
                                          :coords="[infoCompanyDetail.payment.address.latitude, infoCompanyDetail.payment.address.longtitude]"
                                          @update-address="infoCompanyDetail.payment.address = $event">

                            </address-form>
                        </div>
                    </div>
                    <div class="row about__profile mt-3">
                        <div class="col-lg-12">
                            <h5 class="title fw-bold pb-2 addInform" style="color: green">Платежные реквизиты</h5>
                            <div class="row">
                                <div class="col-lg-8">
                                    <table class="table table-bordered">
                                        <tr class="pb-4">
                                            <td width="30%"><b>E-mail адрес</b></td>
                                            <td>
                                                <input v-model="infoCompanyDetail.notification_email"
                                                       class="form-control" type="email">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>События</b></td>
                                            <td>
                                                <div v-for="(item,index) in allNotifications" :key="item.id">
                                                    <label class="align-items-center d-flex float-left">
                                                        <input class="checkEvent mr-2" type="checkbox" :value="item.id"
                                                               :checked="isNotificationSelected(item.id)">
                                                        {{ item.title }}
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </ValidationObserver>
        <div class="d-flex justify-content-center mb-3 mt-3">
            <button @click="prevStep" class="btn btn-primary">Сохранить</button>
        </div>
    </div>
</template>

<script>
import CustomVueEditor from "../../components/elements/CustomVueEditor";
import AddressForm from "../../components/AddressForm";
import {mapGetters} from "vuex";

export default {
    name: "AdminEditProfile",
    components: {AddressForm, CustomVueEditor},
    props: {
        userData: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            maxNameCompany: 100, maxDescriptionCompany: 2000, hasError: false,
            phonesSave: [],
            codePhone: [{id: 1, text: "+7"}, {id: 2, text: "+8"}],
            regEmail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            infoCompanyDetail: {
                mainInfo: {
                    title: null, phones: [], email: null, site: null, description: ""
                },
                address: {
                    country: null, region: null, city: null, postIndex: null, street: null, city_id: null,
                    latitude: null, longtitude: null
                },
                social: {
                    facebook: null, twitter: null, linkedIn: null, telegram: null, slack: null, instagram: null,
                },
                personalInfo: {
                    surname: null, name: null, patronymic: null, position: null, email: null, phones: [""]
                },
                payment: {
                    tin: null, numKpp: null, bic: null, requisites: null, kc: null, okpo: null, okato: null,
                    orgn: null, title: null, legal_name: null,
                    address: {
                        country: null, region: null, city: null, postIndex: null, street: null, city_id: null,
                        latitude: null, longtitude: null
                    }
                },
                notifications: [], notification_email: null
            },
            paymentFields: {
                tin: "ИНН",
                numKpp: "КПП",
                bic: "БИК",
                requisites: "Банковские реквизиты",
                kc: "К/С",
                okpo: "ОКПО",
                okato: "ОКАТО",
                orgn: "ОГРН",
            }
        }
    },
    computed: {
        ...mapGetters({
            allNotifications: 'AllEventNotifications',
        }),
    },
    methods: {
        addOncePhone() {
            this.infoCompanyDetail.mainInfo.phones.push({code: "+7", phone: ""});
        },
        isEmailValid: function () {
            const emailTrue = this.regEmail.test(this.infoCompanyDetail.mainInfo.email);
            this.hasError = !emailTrue;
            return emailTrue ? 'has-success' : 'has-error';
        },
        isNotificationSelected(eventId) {
            return Object.values(this.infoCompanyDetail.notifications).some(notification => notification.event_id === eventId);
        },
        prevStep() {
            this.$emit('prevStep');
        },

        onSave() {

        }
    },
    mounted() {
        this.$store.dispatch('fetchEventNotifications');
        console.log(this.userData)
        if (this.userData) {
            if (this.userData.info.address_id) {
                this.infoCompanyDetail.address = {
                    country: this.userData.info.country,
                    region: this.userData.info.region,
                    city: this.userData.info.city,
                    city_id: this.userData.info.city_id,
                    latitude: this.userData.info.latitude,
                    longtitude: this.userData.info.longtitude,
                    postIndex: this.userData.info.postIndex,
                    street: this.userData.info.address
                }
            }
            this.infoCompanyDetail.social = this.userData.info.social;

            this.infoCompanyDetail.personalInfo = {
                name: this.userData.info.name,
                surname: this.userData.info.surname,
                patronymic: this.userData.info.patronymic,
                position: this.userData.info.position.title,
                email: this.userData.info.email,
                phones: this.userData.info.phones,
            }

            if (this.userData.info.payment_details) {
                this.infoCompanyDetail.payment = this.userData.info.payment_details;
                this.infoCompanyDetail.payment.address.street = this.userData.info.payment_details.address.address;
            }
            if (this.userData.notifications) {
                this.infoCompanyDetail.notifications = this.userData.notifications;
                this.infoCompanyDetail.notification_email = this.userData.notifications.length > 0 ? this.userData.notifications[0].email : null;
            }
            this.infoCompanyDetail.mainInfo = {
                title: this.userData.info.name_user,
                email: this.userData.info.emailCompany,
                site: this.userData.info.site,
                description: this.userData.info.description
            }
            this.infoCompanyDetail.mainInfo.phones = (this.userData.info.phoneCompany || []).map((p) => ({
                code: p.substring(0, 2),
                phone: p.substring(2)
            }));
            this.infoCompanyDetail.mainInfo.phones.push({code: "+7", phone: ""});
        }
    },
    watch: {
        'infoCompanyDetail.mainInfo': {
            handler: function(newVal, oldVal) {
                console.log('mainInfo changed:', newVal, oldVal);
                // Ваша логика обработки изменений здесь
            },
            deep: true // Глубокое наблюдение за изменениями
        },
        'infoCompanyDetail.address': {
            handler: function(newVal, oldVal) {
                console.log('address changed:', newVal, oldVal);
                // Ваша логика обработки изменений здесь
            },
            deep: true // Глубокое наблюдение за изменениями
        },
        'infoCompanyDetail.social': {
            handler: function(newVal, oldVal) {
                console.log('social changed:', newVal, oldVal);
                // Ваша логика обработки изменений здесь
            },
            deep: true // Глубокое наблюдение за изменениями
        },
        'infoCompanyDetail.personalInfo': {
            handler: function(newVal, oldVal) {
                console.log('personalInfo changed:', newVal, oldVal);
                // Ваша логика обработки изменений здесь
            },
            deep: true // Глубокое наблюдение за изменениями
        },
        'infoCompanyDetail.payment': {
            handler: function(newVal, oldVal) {
                console.log('payment changed:', newVal, oldVal);
                // Ваша логика обработки изменений здесь
            },
            deep: true // Глубокое наблюдение за изменениями
        },
        'infoCompanyDetail.notification_email': {
            handler: function(newVal, oldVal) {
                console.log('notification_email changed:', newVal, oldVal);
                // Ваша логика обработки изменений здесь
            },
            deep: true // Глубокое наблюдение за изменениями
        },
    }
}
</script>

<style scoped>
.checkEvent {
    height: 20px;
    width: 20px !important;
    -webkit-appearance: auto;
}
</style>
<style>
.ql-editor {
    font-family: "Muller", sans-serif;
}
</style>
