<template>
    <div>
        <div v-for="message in messagesUser">
            <div class="row mb-3" v-if="message.user_role == 1">
                <div class="col-9">
                    <div class="block-grey pl-3 pr-3 pt-1 pb-2">
                        <p class="mb-0">{{ message.message.replace(/<\/?[^>]+(>|$)/g, "") }}</p>
                    </div>
                </div>
                <div class="col-3">
                    <h6>Арбитр</h6>
                    <div class="d-flex">
                        <div class="img mr-1" style="width: 40px; height: 40px">
                            <img class="w-100 h-100" src="" alt="">
                        </div>
                        <p><b>Алексей Н. (сотрудник службы поддержки)</b></p>
                    </div>
                </div>
            </div>
            <div class="row mb-3" v-else>
                <div class="col-3">
                    <h6>{{ message.user_role == 2 ? 'Заказчик' : 'Исполнитель' }}</h6>
                    <div class="d-flex">
                        <div class="img mr-1" style="width: 40px; height: 40px">
                            <img class="w-100 h-100" src="" alt="">
                        </div>
                        <p><b></b></p>
                    </div>
                </div>
                <div class="col-9">
                    <div class="block-grey pl-3 pr-3 pt-1 pb-2">
                        <p class="mb-0">{{ message.message.replace(/<\/?[^>]+(>|$)/g, "") }}</p>
                    </div>
                </div>
            </div>
        </div>


        <p class="d-lg-block d-none mb-2 "
           style="font-size: calc(1.125rem); color: #0B3158; font-weight: bold">Ваше сообщение в заказе</p>
        <p class="d-lg-none d-block mb-2"
           style="font-size: calc(1rem); color: #0B3158; font-weight: bold">Ваше сообщение в заказе</p>
        <div class="chat">
            <vue-editor style="background-color: white" id="editorChat" :editorToolbar="customToolbar"
                        placeholder="Текст вашего сообщения" v-model="message.message">
            </vue-editor>
        </div>
        <div class="row d-block text-center mt-3 mb-5">
            <button @click="addMessage" class="button-green">Отправить</button>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "AdminArbitration",
    props: {
        propsDealId: {type: Number},
    },
    data() {
        return {
            customToolbar: [
                [{'header': [1, 2, 3, 4, 5, 6, false]}], [{'color': []}, {'background': []}],
                ['bold', 'italic'], [{'list': 'bullet'}, {'list': 'ordered'}, {'align': []}],
                ['image', 'blockquote', 'link'],
            ],
            message: {deal_id: null, user_id: null, message: '<p style="color: #0B3158"></p>',}
        }
    },
    computed: {
        ...mapGetters({
            messages: "AllMessagesArbitr",
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
.button-green {
    background-color: rgb(111, 183, 127);
    padding: 0.5rem 2rem;
    color: white;
    font-size: 16px;
}

.block-grey {
    background-color: lightgrey;
    border-radius: 5px;
}
</style>
