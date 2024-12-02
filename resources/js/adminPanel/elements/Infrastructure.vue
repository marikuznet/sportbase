<template>
    <div class="row">
        <modal id="sb-add-infrastructure" ref="sb-add-infrastructure" modal_dialog_class="modal-lg"
               :title="!isInfrastructureEdit ? 'Добавить объект инфраструктуры' : 'Редактировать объект инфраструктуры'">
            <template #body>
                <ValidationObserver tag="form" ref="observer">
                    <label class="w-100 caption" for="name_object">Название объекта
                        <input id="name_object" type="text" name="search-object" autocomplete="off"
                               v-model="infrastructure.name" placeholder="Тренажерный зал"
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
                                        <img class="img__upload" v-if="!infrastructure.image"
                                             style="width: 30px;"
                                             src="/icons/settings/file-upload.svg"
                                             alt="">
                                        <img alt="" v-show="infrastructure.image"
                                             class="img__upload Image-input__image"
                                             :src="infrastructure.image">
                                    </div>

                                </div>
                            </div>
                            <input type="file" accept="image/jpeg, image/jpg, image/png"
                                   class="d-none" id="vue-file-upload-inp"
                                   @change="addImageInfrastructureHandler">
                            <div class="text d-flex flex-wrap">
                                <div @click="openInputInfrastructure"
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
                             v-for="(item, index) in options">
                            <img v-if="item.title !== ''" class="position-absolute"
                                 @click.prevent="deleteOptionsInfrastructureHandler(index)"
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
                            <button type="button" @click="addOptionsInfrastructureHandler" class="btn btn-info text-white">
                                Добавить опцию +
                            </button>
                        </div>
                    </div>
                </ValidationObserver>
            </template>
            <template #footer>
                <div class="justify-content-center d-flex pt-3">
                    <button type="button" @click="saveInfrastructureHandler"
                            class="btn btn-success text-white justify-content-center">
                        Сохранить
                    </button>
                </div>
            </template>
        </modal>

        <div class="col-12 p-0">
            <div class="col-sm-12 pb-3">
                <label class="caption">Инфраструктура
                    <span class="text-muted font-weight-normal">
                        {{ infrastructures.length }}/100
                    </span>
                </label>
            </div>
        </div>
        <div class="buttonOption pb-4 col-12 col-sm-12 d-flex d-xl-flex justify-content-center
                    justify-content-xl-start">
            <button type="button" data-to class="btn btn-info text-white" :data-target="'#sb-add-infrastructure'"
                    data-toggle="modal">
                Добавить опцию +
            </button>

        </div>
        <div class="blockInfrastructure col-12 col-sm-12 col-md-4"
             v-for="(item, index) in infrastructures"
             v-if="item.title !== ''">
            <div
                class="infrastruct el wrapper shadow bg-white borderblock mb-3">
                <div class="btnFunc d-flex justify-content-end p-2">
                    <a :data-target="'#sb-add-infrastructure'" data-toggle="modal"
                       @click.prevent="editInfrastructureHandler(index)" class="pr-2"
                       href=""><span
                        class="btnAction align-items-lg-center justify-content-center d-flex"><img
                        src="/icons/stages/edit.svg" alt="edit"></span></a>
                    <a @click.prevent="deleteInfrastructureHandler(index)"><span
                        class="btnAction align-items-lg-center justify-content-center d-flex"><img
                        src="/icons/stages/cancel.svg" alt="del"></span></a>
                </div>
                <div class="ul__list_objects">
                    <img :src="item.image" alt="Image"
                         style="border-radius: 8px 8px 0 0"
                         class="el__img w-100">
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
                            class="btn btn-info text-white btnViewFull justify-content-between mb-3">
                        Показать полностью
                        <img src="/icons/arrowDownBlue.svg" alt="">
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Infrastructure",
    props: {
        infrastructures: {
            type: Array,
            default: null,
        }
    },
    data() {
        return {
            idInfrastructure: null, isInfrastructureEdit: false, idOption: 0, countOptions: 0,
            infrastructure: {id: 0, name: '', image: '', options: [],}
        }
    },
    computed: {},
    methods: {
        addOptionsInfrastructureHandler() {
            if (this.countOptions < 101) {
                if (this.infrastructure.options[this.idOption].title !== '') {
                    this.infrastructure.options.push({
                        id: this.idOption,
                        title: this.infrastructure.options[this.idOption].title
                    });

                    this.countOptions++;
                    this.idOption++;
                    this.infrastructure.options[this.idOption].title = '';
                }
            }
        },

        uploadImageInfrastructureHandler(image) {
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
        addImageInfrastructureHandler: function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const vm = this;
                reader.onload = function (e) {
                    vm.infrastructure.image = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
                this.uploadImageInfrastructureHandler(input.files[0]);
            }
        },
        saveInfrastructureHandler() {
            /*if (this.isInfrastructureEdit) {
                this.sportObject.pricing.infrastructures[this.idInfrastructure].title = this.infrastructure.name;
                this.sportObject.pricing.infrastructures[this.idInfrastructure].options = this.options;
                this.toggleModalInfrastructure();

            } else if (!this.isInfrastructureEdit && this.infrastructure.name !== '') {
                this.sportObject.pricing.infrastructures.push({
                    'id': this.infrastructure.id++,
                    'title': this.infrastructure.name,
                    'image': this.infrastructure.image,
                    'imageInfr': this.imageInfrastructures,
                    'options': this.options,
                });
                this.toggleModalInfrastructure();
            }*/
        },
        editInfrastructureHandler(index) {
            /*this.idInfrastructure = index;
            this.isShowModalInfrastructure = !this.isShowModalInfrastructure;
            this.nameInfrastructure = this.sportObject.pricing.infrastructures[index].title;
            this.infrastructure.image = this.sportObject.pricing.infrastructures[index].image;
            this.options = this.sportObject.pricing.infrastructures[index].options;
            this.countOptions = this.sportObject.pricing.infrastructures[index].options.length - 1;
            this.idOption = this.sportObject.pricing.infrastructures[index].options.length - 1;
            this.editInfrastructBool = true;*/
        },
        deleteInfrastructureHandler(index) {
            //this.$delete(this.sportObject.pricing.infrastructures, index);
        },
        deleteOptionsInfrastructureHandler(index) {
            if (this.countOptions > 0) {
                this.$delete(this.options, index)
                this.countOptions--;
                this.idOption--;
            }
        },

        openInputInfrastructure: function () {
            document.getElementById("vue-file-upload-inp").click();
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
                // this.sportObject.storageImages.push(response.data);
            })

            // this.sportObject.files.push(file)
            const self = this
            const reader = new FileReader()
            reader.onload = function (e) {
                //    self.sportObject.images.push(e.target.result)
            }
            reader.readAsDataURL(file);
            this.countPhoto++;
        },

    },
    created() {

    }
}
</script>

<style scoped>

</style>
