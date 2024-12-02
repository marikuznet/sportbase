<template>
    <div class="container mb-5 content-footer">
        <div class="content-footer content-footer-page-mobile d-flex d-lg-none justify-content-center w-100 pt-5">
            <ul class="pagination m-0">
                <li class="page-item" :class="{ disabled: pageNumber === 1}"
                    @click.prevent="pagePrev(pageNumber)">
                    <a class="page-link d-flex justify-content-center align-items-center"
                       href="#"><span
                        class="page-link d-flex justify-content-center align-items-center"></span>
                    </a>
                </li>

                <li class="page-item" :class="{active: page === pageNumber}" v-for="page in pages"
                    :key="page" @click.prevent="pageClick(page)">
                    <a class="page-link d-flex justify-content-center align-items-center"
                       href="">{{ page }}</a>
                </li>

                <li class="page-item" :class="{ disabled: pageNumber == this.pages }">
                    <a class="page-link d-flex justify-content-center align-items-center"
                       href=''></a>
                </li>
            </ul>
        </div>

        <div class="content-footer d-none d-lg-flex justify-content-between w-100 pt-5">
            <ul class="pagination m-0">
                <li class="page-item" :class="{ 'disabled': pageNumber == 1}" @click.prevent="pagePrev(pageNumber)">
                    <a class="page-link d-flex justify-content-center align-items-center" aria-label="Previous"
                       href="#">
                    </a>
                </li>

                <li class="page-item" :class="{'active': page === pageNumber, 'dots': page == '...'}"
                    v-for="(page, key) in pages" :key="key" @click.prevent="pageClick(page)">
                    <a class="page-link d-flex justify-content-center align-items-center"
                       href="#">{{ page }}</a>
                </li>

                <li class="page-item" :class="{ disabled: pageNumber == this.pages }"
                    @click.prevent="pageNext(pageNumber)">
                    <a class="page-link d-flex justify-content-center align-items-center"
                       href='#'></a>
                </li>
            </ul>
            <div class="d-none d-lg-block p-0">
                <p class="text-Blue d-lg-inline-block ">Кол-во на странице</p>
                <div class="d-lg-inline-block filters__sortby inputInf dropdown ml-4"
                     style="border: 1px solid #BED0E2;">
                    <p class="dropdown-page-toggle text-Blue comboBox mr-4 p-2" ref="#" role="button"
                       id="dropdownSort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">10
                    </p>
                    <div class="dropdown-menu fs-5 w-100 border-0  pt-0" aria-labelledby="dropdownSort"
                         style="inset: 0 !important;">
                        <p v-for="page in pageSort" class="dropdown-item text-Blue py-3 borderBlockBottom">
                            {{ page.title }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Pagination",
    props: ['pages_initial'],
    data() {
        return {
            pageSort: [
                {id: 0, title: 10},
                {id: 1, title: 20},
                {id: 2, title: 30}
            ], selPage: '' || {id: 0, title: 10}, pageNumber: 1,
        }
    },
    computed: {
        pages() {
            return this.$props.pages_initial;
        }
    },
    methods: {
        pageClick(page) {
            this.pageNumber = page;
            this.$emit('setCurrentPage', this.pageNumber);
            window.scroll(0, 400);
        },
        pagePrev(page) {
            if (this.pageNumber > 1)
                this.pageNumber = page - 1;
            this.$emit('setCurrentPage', this.pageNumber);
            window.scroll(0, 400);
        },
        pageNext(page) {
            if (this.pageNumber < this.pages)
                this.pageNumber = page + 1;
            this.$emit('setCurrentPage', this.pageNumber);
            window.scroll(0, 400);
        },
    },
    mounted() {
        this.$emit('setPages', this.selPage.title);
    }
}
</script>

<style scoped>
.dropdown-page-toggle::after {
    display: inline-block;
    margin-left: .255em;
    vertical-align: .255em;
    content: "";
    border-top: .3em solid #FF8B5F;
    border-right: .3em solid transparent;
    border-bottom: 0;
    border-left: .3em solid transparent;
}
</style>
