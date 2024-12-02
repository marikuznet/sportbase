<template>
    <div class="m-auto mfs-3 mfs-r-3">
        <div class="sb-loading align-items-center d-flex justify-content-center loading position-fixed"
             v-if="news_loading">
            <div class="spinner-border text-info" role="status"/>
        </div>
        <div class="row justify-content-between px-3 p-1rem">
            <div class="justify-content-left">
                <h4 style="margin-top:10px;margin-bottom:10px;">Новости</h4>
            </div>
            <div class="justify-content-right">
                <a style="margin-top:10px;margin-bottom:10px;" class="btn btn-success" href="/admin/news/add">Добавить
                    статью</a>
            </div>
        </div>
        <div class="">
            <div class="overflow-auto">
                <table class="table" v-if="items">
                    <thead>
                    <th class="text-nowrap">ID номер<i class="fa fa-caret-down sort mx-2"></i></th>
                    <th class="text-nowrap">Изображение</th>
                    <th class="text-nowrap">Название<i
                        class="fa fa-caret-down sort mx-2"></i></th>
                    <th class="text-nowrap">Дата созд.<i class="fa fa-caret-down sort mx-2"></i></th>
                    <th class="text-nowrap">Статья<i class="fa fa-caret-down sort mx-2"></i></th>
                    <th class="text-nowrap">Кол-во просмотров<i class="fa fa-caret-down sort mx-2"></i>
                    </th>
                    <th class="text-center text-nowrap">Действие</th>
                    </thead>
                    <tbody>
                    <tr v-for="item in items">
                        <modal id="sb-notification-delete" ref="sb-notification-delete" v-if="false"
                               modal_class="sb-notification-delete" :key="item.id"
                               title="Уведомление" @left_action="deleteCancel" @right_action="deleteConfirm(item)"
                               left_button="ОТМЕНА" right_button="Удалить">
                        </modal>

                        <td>{{ item.id }}</td>
                        <td><img style="width: 100px;" :src="'/api/news/storage/image/' + item.image" alt=""></td>
                        <td>{{ item.title }}</td>
                        <td>{{ item.created }}</td>
                        <td>content</td>
                        <td>{{ item.view_count }}</td>
                        <td width="10%" class="text-center">
                            <a :href="'/admin/api/news/' + item.slug" style="color:black !important">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            <a :href="'/admin/api/news/' + item.slug + '/edit'" style="color: lightblue !important;">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a @click="deleteConfirm(item)" href="#"
                               style="color: red !important;">
                                <i class="fas fa-minus-square"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center jumbotron" v-else>
                    <p class="fa-2x">Записи отсутствуют...</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import modal from "./elements/modal"

export default {
    name: "NewsComponent",
    data() {
        return {
        }
    },
    components: {modal},
    methods: {
        deleteCancel() {
            $('#sb-notification-delete').modal('hide');
        },
        deleteConfirm(item) {
            this.$store.dispatch('removeNews', item).then(response => {
                this.$store.dispatch('adminFetchNews');
            });
        }
    },
    computed: {
        ...mapGetters({
            news_loading: "news_loading",
            items: "all_news"
        })
    },
    created() {
        this.$store.dispatch('adminFetchNews');
    },
}
</script>

<style scoped>

</style>
