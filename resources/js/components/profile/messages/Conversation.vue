<template>
    <div id="history-messages" class="history-messages__chat-content m-4">
        <div v-for="(items, date) in messages">
            <div class="chat__date text-muted text-center mb-4">
                {{ date }} ({{ getNowDay(date) }})
            </div>
            <div class="chat__item" v-for="item in items"
                 :class="{'chat__item--responder': item.from.id === user.id, 'unread-message': !item.read}">
                <img alt="photo" class="chat__person-avatar d-lg-block d-none"
                     :src="`/storage/listings/logos/${item.from.id}/${item.from.info.image}`">
                <div class="chat__messages">
                    <div class="align-items-end chat__message d-flex">
                        <div class="chat__message-content">
                            {{ item.text }}
                            <div class="chat__message-image" v-if="item.images">
                                <img class="w-100" :src="`/storage/listings/message-image/${item.images[0]}`" alt="">
                            </div>
                        </div>
                        <div class="d-block"
                             :class="{'chat__message-info': item.from.id !== user.id}">
                            <div class="chat__message-status">
                                <img :src="item.read ? '/icons/messages/read.svg'
                                    : '/icons/messages/noun_read.svg'" alt="">
                            </div>
                            <div class="chat__message-time">{{ item.time }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "Conversation",
    props: {
        contact: {
            type: Object,
            default: null
        },
        messages: {
            type: Object,
            default: []
        }
    },
    computed: {
        user: function () {
            return window.user;
        },
    },
    methods: {
        getNowDay(date) {
            return moment(date, 'DD-MM-YYYY').format('dddd');
        },
    }
}
</script>

<style scoped>

.chat__message-image {
    width: 95px;
    height: 95px;
}

</style>
