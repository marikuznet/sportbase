<template>
    <div class="container" :class="sbClass">
        <div class="content-footer content-footer-page-mobile d-flex d-lg-none justify-content-center w-100 pt-5">
            <ul class="pagination m-0">
                <li class="page-item" :class="{ disabled: currentPage === 1}"
                    @click.prevent="previousPage(currentPage)">
                    <a class="page-link d-flex justify-content-center align-items-center" href="#">
                        <span class="page-link d-flex justify-content-center align-items-center"></span>
                    </a>
                </li>

                <li class="page-item" :class="{active: page === currentPage}" v-for="page in pagesNumber"
                    :key="page" @click.prevent="changePage(page)">
                    <a class="page-link d-flex justify-content-center align-items-center" href="">
                        {{ page }}
                    </a>
                </li>
                <li class="page-item" :class="{'disabled': currentPage == lastPage}" @click.prevent="nextPage">
                    <a class="page-link d-flex justify-content-center align-items-center" aria-label="Next" href='#'>
                    </a>
                </li>
            </ul>
        </div>
        <div class="content-footer d-none d-lg-flex justify-content-between w-100 pt-5">
            <ul class="pagination m-0">
                <li class="page-item" :class="{ 'disabled': currentPage == 1}" @click.prevent="previousPage">
                    <a class="page-link d-flex justify-content-center align-items-center" aria-label="Previous"
                       href="#">
                    </a>
                </li>
                <li class="page-item" :class="{'active': page === currentPage, 'dots': page == '...'}"
                    v-for="(page, key) in pagesNumber" :key="key" @click.prevent="changePage(page)">
                    <a class="page-link d-flex justify-content-center align-items-center"
                       href="#">{{ page }}</a>
                </li>
                <li class="page-item" :class="{'disabled': currentPage == lastPage}" @click.prevent="nextPage">
                    <a class="page-link d-flex justify-content-center align-items-center" aria-label="Next" href='#'>
                    </a>
                </li>
            </ul>
            <div class="count-pages d-lg-flex d-md-flex d-none align-self-center justify-content-end" v-if="false">
                <span class="count-pages__label d-flex align-self-center">Кол-во на странице</span>
            </div>
            <div class="col col-auto pages__count d-none d-lg-block">
                <div class="d-lg-inline-block filters__sortby dropdown borderblock colPage rounded-0 show p-0">
                    <p class="text-Blue  px-4 colPage" role="button" id="dropdownMenuLink"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ selectedPage  }}
                    </p>
                    <div class="dropdown-menu fs-5 w-100 border-0  pt-0" aria-labelledby="dropdownMenuLink">
                        <p v-for="page in items" class="dropdown-item text-Blue py-3 borderBlockBottom"
                           @click="changeColPages(page)">{{ page }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VSelect from '@alfsnd/vue-bootstrap-select';

export default {
    name: "Paginator",
    components: {VSelect,},
    data() {
        return {
            items: [10, 25, 50], selectedPage : 10,
        }
    },
    props: {
        pagination: {
            type: Object,
            required: true,
        },
        offset: {
            type: Number,
            default: 10
        },
        sbClass: {
            type: String,
            default: 'mb-5'
        }
    },
    mounted() {
    },
    computed: {
        currentPage() {
            return this.pagination.currentPage;
        },
        from() {
            return this.pagination.from;
        },
        lastPage() {
            return this.pagination.lastPage;
        },
        perPage() {
            return this.pagination.perPage;
        },
        to() {
            return this.pagination.to;
        },
        total() {
            return this.pagination.total;
        },
        pagesNumber() {
            if (!this.pagination.to) {
                return [];
            }
            let from = this.pagination.currentPage - this.offset;
            if (from < 1) {
                from = 1;
            }
            let to = from + (this.offset * 2);
            if (to >= this.pagination.lastPage) {
                to = this.pagination.lastPage;
            }
            let pagesArray = [];
            for (let page = from; page <= to; page++) {
                pagesArray.push(page);
            }
            return pagesArray;
        },
    },
    methods: {
        changePage(page) {
            if (page === '...') {
                return;
            } else if (page <= this.lastPage && page >= 1)
                this.$emit('changePages', page);
        },
        previousPage() {
            this.changePage((this.currentPage - 1));
        },
        nextPage() {
            this.changePage((this.currentPage + 1));
        },
        changeColPages(page) {
            this.selectedPage  = page;
            this.$emit('changeColPages', page);
        }
    },
}
</script>

<style scoped>
.colPage {
    width: auto;
    padding-left: 15px;
    color: #0b3158;
    font-size: 15px;
    text-align: center;
    vertical-align: middle;
    line-height: 45px;
    margin-right: 10px;
}

.content-footer .pagination .page-item.active .page-link {
    color: white !important;
    background-color: #6283e5 !important;
}
</style>
