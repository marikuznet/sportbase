<template>
    <div>
        <div class="d-flex add-referee mb-4">
            <div class="w-25 left">
                <p class="title-referee">Арбитр</p>
                <div class="d-flex referee mb-1">
                    <div class="img mr-3">
                        <img src="/icons/photo_arbitr.svg" alt="">
                    </div>
                    <div class="name">
                        <p class="caption">Андрей Иванов</p>
                        <p class="sub-caption">сотрудник службы поддержки</p>
                    </div>
                </div>
            </div>
            <div class="w-75 right">
                <div class="message-referee p-3">
                    <p>К вашему заказу был добавлен арбитр (сотрудник службы поддержки). Он ознакомится с
                        деталями заказа и переписки в течении 24 часов и задаст уточняющие вопрос (на этой
                        странице). Ожидайте ответа арбитра в ближайшее время.</p>
                </div>
            </div>
        </div>

        <div v-for="message in messagesUser">
            <div class="d-flex add-referee mb-4" v-if="message.user_role == 1">
                <div class="w-25 left">
                    <p class="title-referee">Арбитр</p>
                    <div class="d-flex referee mb-1">
                        <div class="img mr-3">
                            <img src="/icons/photo_arbitr.svg" alt="">
                        </div>
                        <div class="name">
                            <p class="caption">Андрей Иванов</p>
                            <p class="sub-caption">сотрудник службы поддержки</p>
                        </div>
                    </div>
                </div>
                <div class="w-75 right">
                    <div class="message-referee p-3">
                        <p>{{ message.message.replace(/<\/?[^>]+(>|$)/g, "") }}</p>
                    </div>
                </div>
            </div>
            <div class="d-flex add-referee mb-4" v-else-if="message.user_role == user.role">
                <div class="w-75 left">
                    <div class="message-referee p-3">
                        <p>{{ message.message.replace(/<\/?[^>]+(>|$)/g, "") }}</p>
                    </div>
                </div>
                <div class="text-right w-25">

                    <div class="d-inline-flex referee mb-1">
                        <div class="block__circle mr-3 w-100">
                            <img :src="'/storage/listings/logos/' + message.user_id + '/' + JSON.parse(message.user_logo)">
                        </div>
                        <div class="name">
                            <p class="title-referee">{{ message.user_role == 2 ? 'Заказчик' : 'Исполнитель' }}</p>
                            <p class="caption">{{ message.user_title }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex add-referee mb-4" v-else>
                <div class="w-25 left">
                    <div class="d-flex referee mb-1">
                        <div class="block__circle mr-3 w-100">
                            <img :src="'/storage/listings/logos/' + message.user_id + '/' + JSON.parse(message.user_logo)">
                        </div>
                        <div class="name">
                            <p class="title-referee">{{ message.user_role == 2 ? 'Заказчик' : 'Исполнитель' }}</p>
                            <p class="caption">{{ message.user_title }}</p>
                        </div>
                    </div>
                </div>
                <div class="w-75 right">
                    <div class="message-referee p-3">
                        <p>{{ message.message.replace(/<\/?[^>]+(>|$)/g, "") }}</p>
                    </div>
                </div>
            </div>
        </div>

        <p class="d-lg-block d-none mb-2 "
           style="font-size: calc(1.125rem); color: #0B3158; font-weight: bold">Ваше сообщение в заказе</p>
        <p class="d-lg-none d-block mb-2"
           style="font-size: calc(1rem); color: #0B3158; font-weight: bold">Ваше сообщение в заказе</p>
        <div class="chat">
            <vue-editor id="editorChat" :editorToolbar="customToolbar" placeholder="Текст вашего сообщения"
                        v-model="message.message">
            </vue-editor>
        </div>
        <div class="sendBtn d-flex justify-content-center mt-3">
            <button @click="addMessage" class="button button-green d-block text-center">Отправить</button>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Arbitration",
    props: {
        propsDealId: {type: Number},
    },
    data() {
        return {
            customToolbar: [
                [{'header': [1, 2, 3, 4, 5, 6, false]}],
                [{
                    'color': ['#0B3158', '#000000', '#e60000', '#ff9900', '#ffff00', '#008a00', '#0066cc', '#9933ff', '#ffffff'],
                    'background': []
                }],
                ['bold', 'italic'],
                [{'list': 'bullet'}, {'list': 'ordered'}, {'align': []}],
            ],
            message: {deal_id: null, user_id: null, message: '<p style="color: #0B3158"></p>',}
        }
    },
    computed: {
        ...mapGetters({
            messages: "AllMessagesArbitr",
            info: 'AllInfoCompanies'
        }),
        user() {
            return window.user;
        },
        dealId() {
            return this.$props.propsDealId;
        },
        messagesUser() {
            return this.$store.getters.AllMessagesArbitr.filter(f => f.deal_id == this.dealId)
        }
    },
    methods: {
        ...mapActions(["fetchMessagesArbitr"]),
        addMessage() {
            this.message.deal_id = this.dealId;
            this.message.user_id = this.user.id;
            this.$store.dispatch("storeMessagesArbitr", this.message).then(response => {
                this.$store.dispatch("fetchMessagesArbitr");
                this.message.message = '<p style="color: #0B3158"></p>';
            })
        }
    },
    created() {
        this.fetchMessagesArbitr();
    }
}
</script>

<style scoped>
.quillWrapper {
    background-color: white !important;
}

.ql-editor p {
    color: #0B3158 !important;
}
</style>
