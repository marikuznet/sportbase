<template>
    <main class="sb-admin-create-object">
        <div v-if="loading" class="loading-overlay">
            <img src="/images/load.gif" alt="Загрузка..." class="loading-image">
        </div>
        <div class="main-stage">
            <div class="container">
                <breadcrumbs
                    :items="[
                        { text: 'Главная', href: '/admin/sport-objects/checking' },
                        { text: 'Редактировать объект', active: true }
                    ]"
                />
                <div class="caption-stage row justify-content-center">
                    <div class="col-md-12 text-center">
                        <h1 class="title__stage text-uppercase">
                            <strong>Редактировать объект</strong>
                        </h1>
                    </div>
                    <hr class="caption-stage__hr mt-3">
                </div>
            </div>

            <admin-create-object-first
                v-if="addStep === 0"
                @nextStep="addStep++"
                :get-object="sportObject"
                @loading="getStatusLoad"
            />
        </div>
    </main>
</template>

<script>
import Breadcrumbs from "../elements/Breadcrumbs";
import eventBus from "../../event-bus";

export default {
    name: "CreateObject",
    components: { Breadcrumbs },
    props: {
        id: {
            type: [String, Number],
            default: null,
        },
    },
    data() {
        return {
            addStep: 0,
            loading: false,
            idObject: null,
        };
    },
    computed: {
        sportObject() {
            return this.$store.getters.getAdminSportObject;
        },
    },
    methods: {
        getStatusLoad(status) {
            this.loading = status;
        },
    },
    async mounted() {
        try {
            this.loading = true;
            const object = await this.$store.dispatch("getSportObjectById", { id: this.id });
            eventBus.$emit('admin-send-object', object);
        } catch (error) {
            console.error("Ошибка при загрузке объекта:", error);
        } finally {
            this.loading = false;
        }
    },
};
</script>

<style scoped>
.create-object-stepper img {
    height: 75px;
    width: 75px;
}
</style>
