<template>
    <div>
        <navbar></navbar>
        <main class="favorites-objects">
            <div class="favorites-objects__header p-0 py-md-4">
                <div
                    class="container p-4 p-md-0 d-flex flex-column justify-content-between flex-xl-row flex-column-reverse">
                    <div
                        class="favorites-objects__sorting w-100 d-flex flex-column flex-md-row align-items-center justify-content-between mt-3 mt-xl-0">
                        <div class="content-header__sorting sorting d-flex align-items-center">
                            <div class="sorting__label w-100 d-none d-xl-block me-lg-4">Сортировать по</div>
                            <div class="sorting__select select-wrapper sorting w-100 ms-0">
                                <select class="selectpicker">
                                    <option>Сортировка - 1</option>
                                    <option>Сортировка - 2</option>
                                    <option>Сортировка - 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="search-wrapper ms-0 ms-md-3 mt-3 mt-md-0 me-xl-3">
                            <input class="input-search" type="search" name="search-object" id="search-object"
                                   placeholder="Найти в избранных" v-model="filter.search" autocomplete="off">
                            <img class="icon" src="/icons/search-icon.svg" alt="search-icon">
                        </div>
                    </div>
                    <div
                        class="favorites-objects__actions d-flex flex-column flex-md-row w-auto align-items-center justify-content-between pb-3 pb-xl-0">
                        <a href="/compare-objects" class="button button-blue mb-3 mb-md-0 pe-4 me-0 me-md-3 w-100">
                            <p>Сравнить избранные</p>
                            <svg class="ms-3" xmlns="http://www.w3.org/2000/svg" width="19.68" height="20.5"
                                 viewBox="0 0 19.68 20.5">
                                <g id="Сгруппировать_7062" data-name="Сгруппировать 7062"
                                   transform="translate(-1073.445 -463)">
                                    <g id="right-arrow" transform="translate(1073.445 463)">
                                        <g id="Сгруппировать_7061" data-name="Сгруппировать 7061"
                                           transform="translate(0 0)">
                                            <path id="Контур_44610" data-name="Контур 44610"
                                                  d="M25.852,136.4h0l-4.19-4.17a.8.8,0,0,0-1.131,1.137l2.813,2.8h-9.1a.8.8,0,1,0,0,1.6h9.1l-2.813,2.8a.8.8,0,0,0,1.131,1.137l4.19-4.17h0A.8.8,0,0,0,25.852,136.4Z"
                                                  transform="translate(-13.445 -132)" fill="#fff"/>
                                        </g>
                                    </g>
                                    <g id="right-arrow-2" data-name="right-arrow"
                                       transform="translate(1093.125 483.5) rotate(180)">
                                        <g id="Сгруппировать_7061-2" data-name="Сгруппировать 7061"
                                           transform="translate(0 0)">
                                            <path id="Контур_44610-2" data-name="Контур 44610"
                                                  d="M12.407,4.4h0L8.216.233A.8.8,0,0,0,7.085,1.37L9.9,4.17H.8a.8.8,0,0,0,0,1.6H9.9l-2.813,2.8A.8.8,0,0,0,8.216,9.71l4.19-4.17h0A.8.8,0,0,0,12.407,4.4Z"
                                                  fill="#fff"/>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                        <button type="button" @click="removeAll" class="button button-border px-4 w-100">
                            <p>Удалить все объекты</p>
                            <span class="ms-2">{{ favoritesObject.length }}</span>
                            <svg class="ms-3" xmlns="http://www.w3.org/2000/svg" width="18.642" height="20"
                                 viewBox="0 0 18.642 20">
                                <g id="delete_1_" data-name="delete (1)" transform="translate(-17.379)">
                                    <g id="Сгруппировать_7215" data-name="Сгруппировать 7215"
                                       transform="translate(17.379 3.003)">
                                        <g id="Сгруппировать_7214" data-name="Сгруппировать 7214">
                                            <g id="Сгруппировать_7213" data-name="Сгруппировать 7213">
                                                <path id="Контур_44872" data-name="Контур 44872"
                                                      d="M306.712,175.113l-1.566-.057-.339,9.269,1.566.057Z"
                                                      transform="translate(-293.579 -171.22)" fill="#e45868"/>
                                                <rect id="Прямоугольник_7961" data-name="Прямоугольник 7961"
                                                      width="1.567" height="9.269" transform="translate(8.538 3.864)"
                                                      fill="#e45868"/>
                                                <path id="Контур_44873" data-name="Контур 44873"
                                                      d="M160.324,184.318l-.339-9.269-1.566.057.339,9.269Z"
                                                      transform="translate(-152.91 -171.214)" fill="#e45868"/>
                                                <path id="Контур_44874" data-name="Контур 44874"
                                                      d="M17.379,76.867v1.567h1.632L20.306,93.15a.783.783,0,0,0,.78.715h11.2a.783.783,0,0,0,.78-.715l1.3-14.716h1.659V76.867ZM31.57,92.3H21.8l-1.22-13.864H32.79Z"
                                                      transform="translate(-17.379 -76.867)" fill="#e45868"/>
                                            </g>
                                        </g>
                                    </g>
                                    <g id="Сгруппировать_7217" data-name="Сгруппировать 7217"
                                       transform="translate(22.836)">
                                        <g id="Сгруппировать_7216" data-name="Сгруппировать 7216">
                                            <path id="Контур_44875" data-name="Контур 44875"
                                                  d="M163.5,0h-5.117a1.307,1.307,0,0,0-1.305,1.305v2.48h1.567V1.567h4.6V3.786H164.8V1.305A1.307,1.307,0,0,0,163.5,0Z"
                                                  transform="translate(-157.076)" fill="#e45868"/>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="favorites-objects__list pt-4" style="min-height: 600px">
                <div class="container d-flex flex-wrap list-favorites-objects pt-2 py-5">
                    <p v-if="favoritesObject.length === 0" class="font-weight-bold text-Blue">Вы еще не сохранили ни
                        один объект</p>
                    <p v-else-if="filteredfavorites.length === 0" class="font-weight-bold text-Blue">По вашему запросу
                        ничего не найдено</p>


                    <div v-else class="object-block object-block-border mx-3 mb-5" v-for="object in filteredfavorites">
                        <div @click.prevent="removeFavorite(object)" class="object-block__button-delete"></div>
                        <div class="object-block__img">
                            <img :src="'/storage/listings/objects/' + object.id + '/' + object.image[0]" alt="1">
                        </div>
                        <div class="object-block__content">
                            <div class="object-block__name">{{ object.title }}</div>
                            <div class="object-block__location object-location">
                                <img class="object-location__flag" src="/icons/russia-icon.svg"
                                     alt="russia-icon">
                                <div class="object-location__country">{{ object.country }}</div>
                                <div class="object-location__city">г. {{ object.city }}</div>
                            </div>
                            <div class="object-block__descr">
                                {{ object.description.replace(/<\/?[^>]+(>|$)/g, "") }}
                            </div>
                            <div class="object-block__cost">
                                <span>{{ object.accm_minPrice }} ₽</span>
                                / с человека в сутки
                            </div>
                        </div>
                        <div class="wrapp-button d-flex justify-content-center w-100"
                             style="width: -moz-available;">
                            <a :href="'/object-catalog/' + object.id" type="submit"
                               class="button button-fill  text-white">подробнее
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <extendedinf></extendedinf>
    </div>

</template>
<script>
import navbar from './NavBar.vue'
import extendedinf from './ExtendedFooterInformation.vue'
import {mapGetters, mapActions} from 'vuex'

export default {
    data() {
        return {
            favorites: [],
            favoritesObject: [],
            filter: {
                search: ''
            }
        }
    },
    computed: {
        filteredfavorites() {
            return this.favoritesObject.filter(object => {
                return this.filter.search == '' || object.title.toLowerCase().indexOf(this.filter.search.toLowerCase()) !== -1
                    || object.description.toLowerCase().indexOf(this.filter.search.toLowerCase()) !== -1
            })
        }
    },
    methods: {
        removeFavorite(object) {
            const index = this.favorites.findIndex(item => item.id === object.id);

            if (index !== -1) {
                this.favorites.splice(index, 1);
                this.favoritesObject = [...this.favorites];
                const parsed = JSON.stringify(this.favorites);
                localStorage.setItem('favorites', parsed);
            }
        },
        removeAll() {
            this.favorites = [];
            this.favoritesObject = [];
            localStorage.setItem('favorites', JSON.stringify(this.favorites));
        }
    },
    mounted() {
        if (localStorage.getItem('favorites')) {
            try {
                this.favorites = JSON.parse(localStorage.getItem('favorites'));
                this.favoritesObject = [...this.favorites];
            } catch (e) {
                localStorage.removeItem('favorites');
            }
        }
    }
    ,
    components: {
        navbar,
        extendedinf
    }
}
</script>

<style scoped>
</style>
