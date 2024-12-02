<template>
    <div class="mfs-3 mfe-3">
        <div class="sb-loading align-items-center d-flex justify-content-center loading position-fixed"
             v-if="sport_objects_loading">
            <div class="spinner-border text-info" role="status"/>
        </div>
        <div v-if="IsChecking">
            <div class="row mt-3">
                <div class="col-lg-6 col-12">
                    <h4 v-if="sports_objects_list" style="margin-top:10px;margin-bottom:10px;">Спортивные объекты (На
                        проверке - Списком)</h4>
                    <h4 v-else style="margin-top:10px;margin-bottom:10px;">Спортивные объекты (На проверке - На
                        карте)</h4>
                </div>
                <div class="col-lg-6 col-12 h-100 d-flex justify-content-end sb-btn-actions">
                    <a class="btn btn-info btn-left fw-bold text-white">На проверке
                        (<span>{{ statistic.checkinSportObjectsCount }}</span>)</a>
                    <a class="btn btn-outline-info btn-right" href="/admin/sport-objects/checked">Проверенные
                        <span>({{ statistic.checkedSportObjectsCount }})</span></a>
                </div>
            </div>
            <div class="row d-flex justify-content-between pt-4">
                <div class="col-12 col-lg-3">
                    <p><b>Список объектов на проверке</b></p>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="row">
                        <div class="col col-lg-8">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Поиск в каталоге">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-auto col-lg-4 d-flex justify-content-end">
                            <a href="#" @click="showFiltersBlock = !showFiltersBlock"
                               class="sb-btn-filter text-white btn btn-primary d-flex justify-content-center">
                                <i class="fa fa-filter"></i>
                                <span class="d-lg-block d-none">ФИЛЬТР</span>
                                <i class="d-lg-block d-none fa fa-caret-down fa-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="p-1rem">
            <div class="sport-objects__title d-flex justify-content-between row">
                <div class="justify-content-left">
                    <h4 v-if="sports_objects_list" style="margin-top:10px;margin-bottom:10px;">Спортивные объекты
                        (Проверенные - Списком)</h4>
                    <h4 v-else style="margin-top:10px;margin-bottom:10px;">Спортивные объекты (Проверенные - На
                        карте)</h4>
                </div>
                <div class="tabs justify-content-right text-right sb-btn-actions">
                    <a class="btn btn-left btn-outline-info" href="/admin/sport-objects/checking">На проверке
                        (<span>{{ statistic.checkinSportObjectsCount }}</span>)</a>
                    <a class="btn btn-right btn-info fw-bold text-white"
                       href="/admin/sport-objects/checked">Проверенные
                        <span>({{ statistic.checkedSportObjectsCount }})</span></a> <!--btn-active!-->
                </div>
            </div>
            <div class="tabs justify-content-right text-right">
                <div class="row d-flex justify-content-between pt-4">
                    <div class="">
                        <p><b>Список проверенных объектов</b></p>
                    </div>
                    <div class="d-flex">
                        <div v-if="sports_objects_list&&!IsChecking"
                             class="justify-content-left text-left m-t-b-10">
                            <a class="font-sm btn btn-info btn-left btn-active pr-3"
                               v-on:click="sports_objects_list=true">СПИСКОМ
                                <span>({{ statistic.checkedSportObjectsCount }})</span>
                            </a>
                            <a class=" font-sm btn btn-outline-info btn-right"
                               v-on:click="sports_objects_list=false">НА КАРТЕ
                                <span>({{ statistic.checkedSportObjectsCount }})</span>
                            </a>
                        </div>
                        <div v-if="!sports_objects_list&&!IsChecking"
                             class="justify-content-left text-left m-t-b-10">
                            <a class="font-sm btn btn-outline-info btn-left pr-3"
                               v-on:click="sports_objects_list=true">СПИСКОМ
                                <span>({{ statistic.checkinSportObjectsCount }})</span>
                            </a>
                            <a class="font-sm btn btn-info btn-right btn-active"
                               v-on:click="sports_objects_list=false">НА КАРТЕ
                                <span>({{ statistic.checkinSportObjectsCount }})</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Поиск в каталоге">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <a v-on:click="showFiltersBlock=!showFiltersBlock" class="text-white btn btn-primary"><i
                                    class="fa fa-filter">
                                </i> ФИЛЬТР <i class="fa fa-caret-down fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sb-filters-block mfs-3 w-100 mt-3">
            <div class="mfs-r-3" v-show="showFiltersBlock">
                <div class="card card-body">
                    <div class="container">
                        <div class="row w-100">
                            <div class="col"></div>
                            <div class="col">
                                <div class="form-group">
                                    <label htmlFor="ccmonth">Предоставляемое питание</label>
                                    <select class="w-100 form-control" id="ccmonth">
                                        <option>Любое</option>
                                        <option>9</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label htmlFor="ccmonth">Предоставляемые услуги</label>
                                    <select class="w-100 form-control" id="ccmonth">
                                        <option>Любые</option>
                                        <option>12</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        <div class="row mt-3 w-100">
                            <div class="col"></div>
                            <div class="col">
                                <label htmlFor="ccmonth">Инфраструктура</label>
                                <select class="w-100 form-control" id="ccmonth">
                                    <option>Любая</option>
                                    <option>12</option>
                                </select>
                            </div>
                            <div class="col">
                                <label htmlFor="ccmonth">Наличие акредитации <b><u>Минспорта</u></b></label>
                                <select class="w-100 form-control" id="ccmonth">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                </select>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!sports_objects_list&&!IsChecking" class="map-block__img" style="height: 500px">
            <div class="white__block"></div>
            <yandex-map style="height:100%" :coords="center" :zoom="4"
                        :cluster-options="clusterOptions" :settings="settings">
                <ymap-marker :key="index" v-for="(object, index) in sportObjectsForMap" :coords="object.coords"
                             :markerId="1"
                             cluster-name="1" :balloon-template="balloonTemplate(object)"/>
            </yandex-map>
        </div>
        <div v-else class="overflow-auto">
            <table-data-component :items="sportObjectsTable.tableItems" :columns="sportObjectsTable.tableColumns"
                                  :headers="sportObjectsTable.tableHeaders">
                <template #action="{ id }">
                    <a style="color:black !important" :href="'/admin/sport-objects/show/' + id">
                        <i class="fa fa-info-circle"></i>
                    </a>
                    <a style="color: lightblue !important;" :href="'/admin/sport-objects/show/' + id">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a @click="IsChecking ? verifyObject(id) : delSportObject(id)"
                       :style="IsChecking ? 'color: green !important;' : 'color: red !important;'" href="#"
                       :title="IsChecking ? 'Одобрить объект' : ''">
                        <i :class="IsChecking ? 'fas fa-check-square' : 'fas fa-minus-square'"></i>
                    </a>
                </template>
                <template #status="{ item }">
                    <input style="height: 22px !important;" type="checkbox" class="toggle" :checked="item.visible"
                           @click="visibleObject(item.id, !item.visible)">
                </template>
                <template #advertisement="{ item, index }">
                    <template v-if="item.advertisements.filter(advertisement => advertisement.paused).length > 0">
                        <a class="text-info">на паузе</a>
                        <i @mouseenter="handleClick(index, item, 'tooltipPaused')" :ref="'tooltipPaused_' + index"
                           class="fa fa-info-circle text-info"></i>
                    </template>
                    <template v-else-if="item.advertisements.length > 0">
                        <a class="text-info">рекламируется</a>
                        <i @mouseenter="handleClick(index, item, 'tooltipTarget')" :ref="'tooltipTarget_' + index"
                           class="fa fa-info-circle text-info"></i>
                    </template>
                    <template v-else>
                        <p>нет</p>
                    </template>
                </template>
            </table-data-component>
        </div>
    </div>
</template>
<script>
import modalAdvertisement from './ModalAdvertisement';
import modal from '../components/addObject/ModalLiving';
import {mapGetters, mapActions} from 'vuex';
import TableDataComponent from "./elements/TableDataComponent";
import {yandexMap, ymapMarker} from 'vue-yandex-maps';
import axios from "axios";
import StarRating from 'vue-star-rating'

export default {
    name: 'SportObjectsComponent',
    components: {modalAdvertisement, modal, TableDataComponent, yandexMap, ymapMarker, StarRating},
    props: ['isChecking'],
    data() {
        return {
            coords: [54, 39],
            checking: null,
            showFiltersBlock: false,
            sports_objects_list: true,
            isShowModal: false,
            list_sportObjects: '',
            center: [54, 39],
            settings: this.$apiSettings.yandexMap,
            clusterOptions: {
                '1': {
                    clusterIconColor: '#E45868',
                    clusterDisableClickZoom: true,
                    clusterOpenBalloonOnClick: true,
                }
            }, sportObjectsForMap: [], coordsObject: [],
            isModalOpen: false,
        }
    },
    methods: {
        ...mapActions(["adminFetchSportObjects", "adminSportObjectsStatistic", "visibleSportObject",
            "verifySportObject", "delForceSportObject"]),
        handleClick(index, item, nameTooltip) {
            const refName = `${nameTooltip}_${index}`;
            const element = this.$refs[refName];

            if (element) {
                $(this.$refs[refName]).tooltip({
                    template: '<div class="tooltip" role="tooltip"><div class="tooltip-inner"></div></div>',
                    title: this.generateTooltipTitle(item),
                    html: true,
                    placement: 'right',
                }).tooltip('show');
            }
        },
        generateTooltipTitle(item) {
            let tooltipTitle = '';
            tooltipTitle += `<p class="text-left font-weight-bold">Заметка</p>`;

            for (const advertisement of item.advertisements) {
                tooltipTitle += `<p>${advertisement.rate.title} (${advertisement.days} дней / ${advertisement.amount} руб.)  ${advertisement.paused ? '(пауза)' : ''}</p>`;
            }

            return tooltipTitle;
        },
        verifyObject(item_id) {
            this.verifySportObject({id: item_id}).then(() => this.adminFetchSportObjects());
        },
        visibleObject(item_id, visible) {
            this.visibleSportObject({id: item_id, visible: visible}).then(() => this.adminFetchSportObjects());
        },
        delSportObject(id) {
            this.delForceSportObject({id: id});
            this.getSportObjects();
        },
        async getCoords(address, object) {
            try {
                let long = null;
                let lat = null;
                if (object.latitude != null && object.longtitude != null) {
                    lat = parseFloat(object.latitude);
                    long = parseFloat(object.longtitude);
                } else {
                    let address = encodeURI(`${object.country}+${object.city}+${object.address}`);
                    let temp_address = address.replace(' ', '+');
                    try {
                        const resp = await axios.get('/api/v1/get/coords', {
                            params: {
                                address: temp_address
                            }
                        });
                        const coords = resp.data.response.GeoObjectCollection.featureMember[0]['GeoObject']['Point']['pos'].split(' ');
                        lat = parseFloat(coords[0]);
                        long = parseFloat(coords[1]);
                    } catch (error) {
                        console.log(error);
                    }
                }
                this.sportObjectsForMap.push(
                    {
                        coords: [lat, long],
                        id: object.id,
                        title: object.title,
                        country: object.country,
                        city: object.city,
                        image: object.image[0],
                        minPrice: object.accm_minPrice,
                        description: object.description
                    }
                );
            } catch (error) {
                console.log(error);
            }
        },
        balloonTemplate(object) {
            return `
        <div class="d-flex">
            <img width="200px" height="150px" class="mr-2" src="/storage/listings/objects/${object.id}/${object.image}">
            <div class="object-info">
                <a target="_blank" href="/admin/sport-objects/show/${object.id}"><h5 class="text-info">${object.title}</h5></a>
                <div class="">
                    <h6>от ${object.minPrice} руб.</h6>
                <h6>Рейтинг: ${object.rating}</h6>
                </div>
            </div>
        </div> `
        },
        openModal() {
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        getSportObjects() {
            this.adminFetchSportObjects();
            this.adminSportObjectsStatistic();
        },
        getObjectsForMap() {
            this.$store.dispatch("getAddressesBySportObjects").then(response => {
                for (const resp of response) {
                    let address = encodeURI(`${resp.country}+${resp.city}+${resp.address}`);
                    this.getCoords(address, resp);
                }
            });
        }
    },
    computed: {
        ...mapGetters({
            listChecking_sportObjects: 'AllSportObjectsChecking',
            listChecked_sportObjects: 'AllSportObjectsChecked',
            statistic: 'sport_objects_admin_statistic',
            countSportObjects: 'AllSportObjectsCount',
            sport_objects_loading: 'sport_objects_loading',
        }),
        IsChecking() {
            this.checking = this.isChecking;
            return this.checking;
        },
        sportObjectsTable() {
            let headers = [
                {label: "ID номер"}, {label: "Тип"}, {label: "Фото"}, {label: "Объект"}, {label: "Адрес"},
                {label: "Владелец"}, {label: "Реклама"}, {label: "Действие"}
            ];
            let columns = [
                {prop: "id", class: "text-center"},
                {prop: "objectType_title", class: "text-center", width: '10%'},
                {prop: "object_image", class: "text-center", html: true},
                {prop: "title", class: "text-center", width: '20%'},
                {prop: "object_address", class: "text-center", width: '20%'},
                {prop: "object_owner", class: "text-center underline", width: '20%', html: true},
                {prop: "advertisement", class: "text-center text-center", width: '20%'},
                {prop: "action", class: "text-center", width: '10%'}
            ];
            let items = this.listChecking_sportObjects.map(object => ({
                ...object,
                object_image: `<img class="img-responsive h-100 w-100" alt="object" src="/storage/listings/objects/${object.id}/${object.image[0]}"/>`,
                object_address: `${object.city}, ${object.address}`,
                object_owner: `<a href="/admin/users/profile/${object.owner_id}">${object.created.title} (ID: ${object.owner_id})</a>`,
                object_advertisement: 'нет'
            }));
            if (!this.isChecking) {
                headers.splice(7, 0, {label: "Акт."});
                columns.splice(7, 0, {prop: "object_active", class: ''});
                items = this.listChecked_sportObjects.map(object => ({
                    ...object,
                    object_image: `<img class="img-responsive h-100 w-100" alt="object" src="/storage/listings/objects/${object.id}/${object.image[0]}"/>`,
                    object_address: `${object.city}, ${object.address}`,
                    object_owner: `<a href="/admin/users/profile/${object.owner_id}">${object.created.title} (ID: ${object.owner_id})</a>`,
                    object_advertisement: 'нет',
                }));
            }
            return {
                tableHeaders: headers,
                tableColumns: columns,
                tableItems: items
            }
        },
    },
    mounted() {
    },
    created() {
        this.getSportObjects();
    }
};
</script>
<style>

.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    border: 1px solid gray;
}

table td {
    vertical-align: middle !important;
}

input[type=checkbox] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-tap-highlight-color: transparent;
    cursor: pointer;
}

input[type=checkbox]:focus {
    outline: 0;
}

.toggle {
    height: 22px;
    width: 44px;
    border-radius: 16px;
    display: inline-block;
    position: relative;
    margin: 0;
    border: 2px solid red;
    transition: all 0.2s ease;
}

.toggle:after {
    content: "";
    position: absolute;
    top: 2px;
    left: 2px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: white;
    box-shadow: 0 1px 2px rgba(44, 44, 44, 0.2);
    transition: all 0.2s cubic-bezier(0.5, 0.1, 0.75, 1.35);
}

.toggle:checked {
    border-color: green;
    background-color: green;
}

.toggle:checked:after {
    transform: translatex(20px);
}


.btn-active {
    background-color: lightgrey;
}

.tabs li {
    color: black !important;
    border: 1px solid black;
}

.btn {
    width: 150px;
}

.btn-left {
    border-radius: .5rem 0 0 .5rem;
}

.btn-right {
    border-radius: 0 .5rem .5rem 0;
}

.btn-active {
    color: white !important;
}

.mfs-r-3 {
    margin-right: 1.5rem !important;
}

.p-1rem {
    padding: 1rem !important;
}

.m-t-b-5 {
    margin-top: 5px;
    margin-bottom: 5px;
}

.m-t-b-10 {
    margin-top: 10px;
    margin-bottom: 10px;
}

.tooltip-inner {
    background: white;
    color: black;
}

.tooltip .tooltip-inner {
    max-width: 350px; /* Установите желаемую ширину */
}
</style>
