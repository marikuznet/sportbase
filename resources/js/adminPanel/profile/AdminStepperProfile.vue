<template>
    <main class="main-profile-settings">
        <div class="container-fluid">
            <breadcrumbs :items="breadcrumbs"/>
        </div>
        <profile v-if="step === 0" :user-data="userData" @nextStep="step++"/>

        <admin-edit-profile v-else-if="step === 1" :user-data="userData" @prevStep="step--"></admin-edit-profile>
    </main>
</template>

<script>
import Breadcrumbs from "../elements/Breadcrumbs";
import AdminEditProfile from "./AdminEditProfile";
import Profile from "../Profile";

export default {
    name: "AdminStepperProfile",
    components: {Profile, AdminEditProfile, Breadcrumbs},
    props: {
        id: {
            type: Number
        },
        userData: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            step: 0
        }
    },
    computed: {
        breadcrumbs() {
            return [
                {
                    text: `Пользователи (${this.userData.role_id === 2 ? 'Заказчики' : 'Исполнители'})`,
                    active: true,
                    href: `${this.userData.role_id === 2 ? '/admin/users/customers' : '/admin/users/executors'}`
                },
                {
                    text: `${this.userData.name_user || this.userData.name}` + ` (ID:${this.userData.id || this.userData.user_id})`,
                    active: true
                },
                {
                    text: "Профиль и настройки",
                    active: true,
                }]
        }
    },
    mounted() {

    },
    created() {
    }
}
</script>

<style scoped>

</style>
