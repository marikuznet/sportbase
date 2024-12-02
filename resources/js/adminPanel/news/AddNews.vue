<template>
    <div class="sb-add-news mfs-3 mfe-3">
        <nav aria-label="breadcrumb">
            <ol class="sb-content__breadcrumb breadcrumb">
                <li class="breadcrumb-item fs-lg-5"><a href="/admin/news">Новости</a></li>
                <li class="breadcrumb-item active fs-lg-5" aria-current="page">
                    {{ !edit_mode ? 'Добавить' : 'Редактировать' }} новость
                </li>
            </ol>
        </nav>

        <div class="row justify-content-between px-3 p-1rem">
            <div class="justify-content-left">
                <h4 style="margin-top:10px;margin-bottom:10px;">{{ !edit_mode ? 'Добавить' : 'Редактировать' }}
                    новость</h4>
            </div>
        </div>

        <ValidationObserver v-slot="props" tag="form" ref="observer" @submit.prevent="addNews">
            <div class="sb-ad-news__content">
                <div class="row mb-3">
                    <div class="col-lg-4 col-12">
                        <ValidationProvider rules="required|max:300" v-slot="{ errors }">
                            <label for="caption_field" class="form-label font-weight-bold">
                                Заголовок <span class="error-valid text-danger" v-if="errors[0]">(* {{
                                    errors[0]
                                }})</span>
                            </label>
                            <input :class="{ 'is-invalid': errors[0] }" type="text" class="form-control"
                                   id="caption_field" v-model="news.title" autocomplete="off"
                                   placeholder="Новость 1" maxlength="300" required>
                        </ValidationProvider>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-2 col-12">
                        <ValidationProvider rules="image" v-slot="{ errors }">
                            <input type="text" v-model="countImage" disabled class="d-none">
                            <label for="image_field" class="form-label font-weight-bold">
                                Изображение <span class="error-valid text-danger" v-if="errors[0]">(* {{
                                    errors[0]
                                }})</span>
                            </label>
                            <input :class="{ 'is-invalid': errors[0] }" type="file" class="form-control"
                                   id="image_field" accept="image/jpeg,image/jpg,image/png"
                                   @change="addImage">
                        </ValidationProvider>
                    </div>
                    <div class="col-lg-4 col-12" v-if="image_data">
                        <div class="sb-prev-image w-100">
                            <img class="w-50" :src="image_data" alt="prev-image">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <ValidationProvider v-slot="{errors, failed}" rules="required">
                            <label for="news_field" class="form-label font-weight-bold">
                                Содержание <span class="error-valid text-danger" v-if="errors[0]">(* {{
                                    errors[0]
                                }})</span>
                            </label>
                            <vue-editor :class="{'is-invalid': failed && props.validated}" id="news_field"
                                        placeholder="Новость 1" v-model="news.content"></vue-editor>
                        </ValidationProvider>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3 col-md-3 col-12">
                        <button :disabled="!props.valid" style="width: 100% !important;" type="submit"
                                class="btn btn-primary">Сохранить
                        </button>
                    </div> <!--!-->
                </div>
            </div>
        </ValidationObserver>
    </div>
</template>

<script>
import {extend} from 'vee-validate';
import axios from "axios";

extend('image', {
    validate: (value => {
        return value > 0;
    }),
    message: 'Изображение не выбрано'
});

export default {
    name: "AddNews",
    props: {
        item: {
            type: Object,
            default: null,
        }
    },
    data() {
        return {
            news: {id: null, title: "", image: "", content: ""}, countImage: 0, image_data: null,
            input_image: null, edit_mode: false, tempImage: null
        }
    },
    methods: {
        async addNews() {
            await this.$refs.observer.validate().then(success => {
                if (!success) {
                    setTimeout(() => {
                        const errors = Object.entries(this.$refs.observer.errors)
                            .map(([key, value]) => ({key, value}))
                            .filter(error => error["value"].length);
                        this.$refs.observer.refs[errors[0]["key"]].$el.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });
                    }, 100);
                } else {
                    if (!this.edit_mode) {
                        let formData = new FormData();
                        formData.append('image', this.input_image);
                        axios.post('/admin/api/news/uploadImage', formData, {
                            'headers': {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then((response) => {
                            this.news.image = response.data;
                            this.$store.dispatch('storeNews', this.news).then(result => {
                                window.location.href = "/admin/news";
                            })
                        });
                    } else {
                        if (this.input_image != null) {
                            let formData = new FormData();
                            formData.append('image', this.input_image);
                            axios.post('/admin/api/news/uploadImage', formData, {
                                'headers': {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }).then((response) => {
                                console.log(response.data.image)
                                this.news.image = response.data.image
                                this.$store.dispatch("updateNews", this.news).then(() => {
                                     window.location.href = "/admin/news";
                                })
                            });
                        }

                    }
                }
            });
        },
        addImage() {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const vm = this;
                reader.onload = function (e) {
                    vm.image_data = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
                this.countImage++;
                this.input_image = input.files[0];
            }
        },
    },
    created() {
        if (!this.item) return;
        this.image_data = '/api/news/storage/image/' + this.item.image;
        this.news.id = this.item.id;
        this.news.title = this.item.title;
        this.news.image = this.item.image;
        this.countImage = 1;
        this.news.content = this.item.content;
        this.edit_mode = true;
    }
}
</script>

<style scoped>

</style>
