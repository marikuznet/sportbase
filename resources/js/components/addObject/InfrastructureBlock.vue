<template>
    <div class="col-12 col-sm-8 col-md-12 p-0">
        <sb-modal id="sb-infrastructure" ref="sb-infrastructure"
                  modal_dialog_class="modal-lg"
                  :title="infrastructureEditId != null ? 'Редактировать объект инфраструктуры' : 'Добавить объект инфраструктуры'"
                  modal_class="sb-infrastructure p-0 px-4" modal_title_class="text-xl-left">
            <template #body>
                <label class="w-100 caption mt-3" for="nameObject">Название объекта
                    <input type="text" name="search-object" autocomplete="off" v-model="titleInfrastructure"
                           id="nameObject" placeholder="Тренажерный зал" class="input-profile-info"/>
                </label>
                <div class="uploadImage">
                    <p class="caption">Фото объекта</p>
                    <div class="d-flex flex-lg-nowrap flex-wrap">
                        <div class="block__upload mb-2 mb-lg-0">
                            <div class="block__upload-image" style="width: 110px;height: 110px;">
                                <div style="overflow: hidden" class="block__rectangle d-flex justify-content-center">
                                    <img v-if="!imageSrc" class="img__upload" style="width: 30px;"
                                         src="/icons/settings/file-upload.svg" alt="file-upload"/>
                                    <img v-show="imageSrc" :src="imageSrc"
                                         alt="" class="img__upload Image-input__image"/>
                                </div>
                            </div>
                        </div>
                        <input type="file" accept="image/jpeg, image/jpg, image/png" class="d-none"
                               id="vue-file-upload-inp" @change="addImageInfrastructure"/>
                        <div class="text d-flex flex-wrap">
                            <div @click="openinputInfrastructure"
                                 class="text-upload d-flex align-items-center justify-content-center ml-lg-3 ml-0">
                                Загрузить новую фотографию
                                <img class="pl-4" src="/icons/stages/file-upload.svg" alt=""/>
                            </div>
                            <div class="subtitle pl-lg-3 pl-0 pt-1">
                                Формат фотографий - не менее 500px по широкой и узкой стороне / jpg или png без alpha
                                канала
                            </div>
                        </div>
                    </div>
                    <label class="caption w-100 mt-3 mb-0">Опции
                        <span class="text-muted float-right font-weight-normal">{{ countOptions }}/100</span>
                    </label>
                    <div class="closeOptions p-0 d-flex align-items-center"
                         v-for="(item, index) in objectOptionsInfrastructure">
                        <img v-if="item.title !== ''"
                             class="position-absolute"
                             @click.prevent="deleteOptionsInfrastruct(index)"
                             style="z-index: 1; right: 45px; cursor:pointer"
                             src="/icons/stages/exit.svg"
                             alt="exit"/>
                        <div class="col-sm-12 p-0 m-0">
                            <div class="h-100 mb-2">
                                <input type="text" autocomplete="off" :key="item.id" name="search-object"
                                       v-model="item.title" placeholder="Введите название опции"
                                       class="input-price-info h-100"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 p-0 m-0 buttonOption">
                        <button type="button" @click="addObjectOptionsInfra" class="button button-borderBlue">
                            Добавить опцию +
                        </button>
                    </div>
                </div>
                <div class="justify-content-center d-flex pt-3">
                    <button type="button" @click="saveInfrastructure"
                            class="button button-green justify-content-center">
                        Сохранить
                    </button>
                </div>
            </template>
        </sb-modal>
        <div class="col-12 p-0">
            <div class="col-sm-12">
                <ValidationProvider rules="infrastructuresCount" v-slot="{ errors, failed }">
                    <input type="text" v-model="infrastructuresCount" disabled class="d-none"/>
                    <p class="caption pb-lg-3">Инфраструктура
                        <span class="text-muted font-weight-normal">
              {{ infrastructuresCount }}/100
              <span class="error-valid">{{ errors[0] }}</span>
            </span>
                    </p>
                </ValidationProvider>
            </div>
        </div>
        <div
            class="buttonOption pb-4 col-12 col-sm-12 d-flex d-xl-flex justify-content-center justify-content-xl-start">
            <button data-toggle="modal" data-target="#sb-infrastructure" type="button"
                    @click="clearInfrastructureModal" class="button button-borderBlue">
                Добавить опцию +
            </button>
        </div>
        <div class="row row-cols-sm-1 row-cols-md-3 row-cols-12 px-3">
            <div v-if="item.title !== ''" class="blockInfrastructure col"
                 v-for="(item, index) in sportObject.pricing.infrastructures">
                <div class="infrastruct el wrapper shadow bg-white borderblock mb-3">
                    <div class="btnFunc d-flex">
                        <a
                            data-toggle="modal"
                            data-target="#sb-infrastructure"
                            @click.prevent="editInfrastructure(index)"
                            class="pr-2"
                            href="#"
                        >
              <span class="btnAction align-items-lg-center justify-content-center d-flex">
                <img src="/icons/stages/edit.svg" alt="edit"/>
              </span>
                        </a>
                        <a @click.prevent="deleteInfrastructure(index)">
              <span class="btnAction align-items-lg-center justify-content-center d-flex">
                <img src="/icons/stages/cancel.svg" alt="del"/>
              </span>
                        </a>
                    </div>
                    <div class="ul__list_objects">
                        <img
                            :src="item.image && item.image != '/storage/listings/infrastruct/null' ? item.image : '/images/no-photo.png'"
                            alt="Image"
                            style="border-radius: 8px 8px 0 0;object-fit: cover;"
                            class="el__img w-100"
                        />
                        <p class="el__title p-4">{{ item.title }}</p>
                        <ul class="list-overflow mx-2 pb-4" :class="{ 'h-auto': infrastructure_detail }">
                            <li v-for="option in item.options" v-if="option.title !== ''">
                                <p class="fs-6 opacity-7">{{ option.title }}</p>
                            </li>
                        </ul>
                    </div>
                    <div v-if="item.options.length > 4" class="justify-content-center align-items-lg-center d-flex">
                        <button
                            type="button"
                            @click="infrastructure_detail = !infrastructure_detail"
                            class="button button-borderBlue btnViewFull justify-content-between">
                            {{ infrastructure_detail ? 'Скрыть' : 'Показать полностью' }}
                            <img src="/icons/arrowDownBlue.svg" alt=""/>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SbModal from "../../adminPanel/addObject/SbModal";
import axios from "axios";

export default {
    name: "InfrastructureBlock",
    components: {SbModal},
    props: {
        sportObject: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            infrastructureEditId: null,
            infrastructureId: null,
            titleInfrastructure: '',
            imageSrc: '',
            imageInfrastructures: '',
            objectOptionsInfrastructure: [{id: 0, title: ''}],
            countOptions: 0,
            nextIdOptions: 0,
            infrastructure_detail: false
        };
    },
    computed: {
        infrastructuresCount() {
            return this.sportObject.pricing.infrastructures.length;
        },
    },
    methods: {
        addObjectOptionsInfra() {
            if (this.countOptions < 101) {
                if (this.objectOptionsInfrastructure[this.nextIdOptions].title !== '') {
                    this.objectOptionsInfrastructure.push({
                        id: this.nextIdOptions,
                        title: this.objectOptionsInfrastructure[this.nextIdOptions].title
                    });
                    this.countOptions++;
                    this.nextIdOptions++;
                    this.objectOptionsInfrastructure[this.nextIdOptions].title = '';
                }
            }
        },
        uploadImageInfrastruct(image) {
            let formData = new FormData();
            formData.append('file', image);
            axios.post('/uploadImages/infrastruct', formData, {
                'headers': {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                this.imageInfrastructures = response.data;
            });
        },
        addImageInfrastructure(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imageSrc = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
                this.uploadImageInfrastruct(input.files[0]);
            }
        },
        saveInfrastructure() {
            const {
                infrastructureEditId,
                titleInfrastructure,
                imageSrc,
                imageInfrastructures,
                objectOptionsInfrastructure
            } = this;

            const {pricing} = this.sportObject;

            if (infrastructureEditId !== null) {
                const infrastructure = {
                    id: this.infrastructureId,
                    title: titleInfrastructure,
                    image: imageSrc,
                    imageInfr: imageInfrastructures,
                    options: objectOptionsInfrastructure
                };

                const newInfrastructures = [...pricing.infrastructures];
                newInfrastructures[infrastructureEditId] = infrastructure;

                this.$set(this.sportObject.pricing, 'infrastructures', newInfrastructures);
            } else if (titleInfrastructure !== '') {
                const infrastructure = {
                    id: null,
                    title: titleInfrastructure,
                    image: imageSrc,
                    imageInfr: imageInfrastructures,
                    options: objectOptionsInfrastructure
                };

                this.sportObject.pricing.infrastructures = [...pricing.infrastructures, infrastructure];
            }
            this.clearInfrastructureModal();
            $('#sb-infrastructure').modal('hide');
        },
        editInfrastructure(index) {
            const {pricing} = this.sportObject;
            const infrastructure = pricing.infrastructures[index];
            this.infrastructureEditId = index;
            this.infrastructureId = infrastructure.id;
            this.titleInfrastructure = infrastructure.title;
            this.imageSrc = infrastructure.image;
            this.objectOptionsInfrastructure = infrastructure.options;
            this.setEditingInfrastructureState();
        },
        setEditingInfrastructureState() {
            if (this.objectOptionsInfrastructure.length === 0) {
                this.objectOptionsInfrastructure.push({id: 0, title: ''});

                this.countOptions = 0;
                this.nextIdOptions = 1;
                this.isEditInfrastructure = true;
                return;
            }
            if (this.objectOptionsInfrastructure[this.objectOptionsInfrastructure.length - 1].title !== '') {
                this.objectOptionsInfrastructure.push({id: 0, title: ''});
            }
            this.countOptions = this.objectOptionsInfrastructure.length - 1;
            this.nextIdOptions = this.objectOptionsInfrastructure.length - 1;
            this.isEditInfrastructure = true;
        },
        deleteInfrastructure(index) {
            this.$delete(this.sportObject.pricing.infrastructures, index);
        },
        deleteOptionsInfrastruct(index) {
            if (this.countOptions > 0) {
                this.$delete(this.objectOptionsInfrastructure, index);
                this.countOptions--;
                this.nextIdOptions--;
            }
        },
        clearInfrastructureModal() {
            this.titleInfrastructure = '';
            this.imageSrc = '';
            this.objectOptionsInfrastructure = [{id: 0, title: ''}];
            this.countOptions = 0;
            this.nextIdOptions = 0;
            this.infrastructureEditId = null;
        },
        openinputInfrastructure() {
            document.getElementById("vue-file-upload-inp").click();
        }
    }
};
</script>

<style scoped>
/* Your existing styles */
</style>
