<template>
    <div :class="['d-flex', 'align-content-start', 'flex-wrap', 'p-4', 'pe-0', 'pb-4', 'gap-3', objectListClass]">
        <div v-for="item in sportObjects" :key="item.id"
             :class="['content-objects-list__item', 'object-block', 'object-block-border', 'mb-5', { 'classPromotion': item.hasPromotion, 'border-rounded': item.hasPromotion }]">
            <div v-if="item.hasVIP" class="object-block__vip-label">VIP</div>
            <div v-if="item.hasHighlightion" class="object-block__fast-forward-label">
                <img src="/icons/sportObjects/fast-forward.svg" alt="fast-forward">
            </div>
            <div class="object-block-favorites-wrapp">
                <input type="checkbox" :value="item.id" :checked="isFavourite(item)" @click="toggleFavourite(item)"
                       :id="'favorites-heart-obj-' + item.id" :name="'favorites-heart-obj-' + item.id" class="object-block-favorites__checkbox">
                <label :for="'favorites-heart-obj-' + item.id" class="object-block-favorites__label">
                    <svg width="20" height="17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.019 1.519C13.832 0.483 11.911 2.068 10.698 3.475 10.2 4.054 9.229 3.99 8.774 3.376 7.629 1.835 5.627 0.117 3.163 1.519 -0.385 3.538 1.163 7.519 2.663 9.519 4.398 11.833 7.65 14.466 9.024 15.532 9.395 15.821 9.914 15.8 10.274 15.498 11.806 14.215 14.425 12.104 16.163 10.019 18.955 6.668 19.519 3.176 16.019 1.519Z" stroke="#B7C2CC" stroke-width="3"/>
                    </svg>
                </label>
            </div>
            <div class="img_sport-object w-100 position-relative">
                <img :src="`/storage/listings/objects/${item.id}/${item.image[0]}`" :alt="`object-${item.id}`" class="sb-image-content w-100" style="object-fit: cover;">
                <div v-if="item.hasVIP" class="object-block__vip-label">VIP</div>
                <div v-if="item.hasHighlightion" class="object-block__fast-forward-label">
                    <img src="/icons/sportObjects/fast-forward.svg" alt="fast-forward">
                </div>
            </div>
            <div class="object-block__content">
                <div class="object-block__name fw-bold text-uppercase">{{ item.title }}</div>
                <div class="object-block__location object-location">
                    <img src="/icons/russia-icon.svg" alt="russia-icon" class="object-location__flag">
                    <div class="object-location__country">{{ item.country }}</div>
                    <div class="object-location__city">{{ item.city }}</div>
                </div>
                <div class="object-block__descr">
                    {{ formatDescription(item.description) }}
                </div>
                <div class="object-block__cost text-center">
                    <span> от {{ item.accm_minPrice }} ₽</span>/ за человека в сутки
                </div>
            </div>
            <div class="wrapp-button d-flex justify-content-center w-100">
                <a :href="'/object-catalog/' + item.id" class="button button-fill text-white">подробнее</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ContentObjects",
    props: {
        objectListClass: {
            type: String,
            default: ''
        },
        sportObjects: {
            type: Array,
            required: true,
            default: () => []
        }
    },
    data() {
        return {
            favorites: [],
        }
    },
    mounted() {
        const storedFavorites = localStorage.getItem('favorites');
        if (storedFavorites) {
            try {
                this.favorites = JSON.parse(storedFavorites);
            } catch {
                localStorage.removeItem('favorites');
            }
        }
    },
    methods: {
        toggleFavourite(object) {
            const index = this.favorites.findIndex(item => item.id === object.id);
            if (index !== -1) {
                this.favorites.splice(index, 1);
            } else {
                this.favorites.push(object);
            }
            localStorage.setItem('favorites', JSON.stringify(this.favorites));
        },
        isFavourite(object) {
            return this.favorites.some(item => item.id === object.id);
        },
        formatDescription(description) {
            return description.replace(/<\/?[^>]+(>|$)/g, "").replace(/\.([^\s])/g, '. $1');
        }
    }
}
</script>

<style scoped>
.sb-image-content {
    border-top-right-radius: 5px;
    border-top-left-radius: 5px;
    height: 145px;
}
</style>
