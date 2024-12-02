<template>
    <div>
        <navbar></navbar>
        <div class="container-fluid" style="min-height: 650px; background-color: white">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="">
                        <div style="font-size: 22px" class="pt-5">Подтвердите Вашу Email почту</div>
                        <p style="color: black" class="pt-2">Прежде чем продолжить, пожалуйста, проверьте свою
                            электронную почту на
                            наличие ссылки для подтверждения. Если вы не получили письмо,</p>
                        <form class="d-inline" method="POST" action="">
                            <button type="submit"
                                    class="btn btn-link p-0 m-0 align-baseline">
                                <p style="color: black;">нажмите здесь, чтобы запросить другое</p>
                            </button>
                            .
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <extendedinf></extendedinf>
    </div>

</template>

<script>
import navbar from './NavBar.vue'
import extendedinf from './ExtendedFooterInformation.vue'

export default {
    data() {

    },
    components: {
        navbar,
        extendedinf
    }
}
</script>

<style scoped>

</style>
