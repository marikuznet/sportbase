<template>
    <div class="block-messages">
        <div class="block-messages__message p-4" v-for="contact in contacts"
             :key="contact.id" @click="selectContact(contact)"
             :class="{'block-messages__message-active': contact.id === selected}">
            <div class="row">
                <div class="col-10">
                    <div class="d-flex">
                        <div class="logo position-relative mr-2">
                            <img :alt="contact.info.image" class="w-100 h-100"
                                 style="border-radius: inherit"
                                 :src="`/storage/listings/logos/${contact.id}/${contact.info.image}`">
                            <div class="online"
                                 :class="{'online-green': contact.isOnline}"/>
                        </div>
                        <div class="d-flex align-items-center info flex-fill w-75"
                             :class="{'none-message': !contact.last_message}">
                            <div class="">
                                <p class="textCompany">{{ contact.info.name }}</p>
                                <div class="d-flex" v-if="contact.last_message">
                                    <p class="message mr-2">{{ contact.last_message }}</p>
                                    <img :src="contact.last_message_read === true ? '/icons/messages/read.svg'
                                    : '/icons/messages/noun_read.svg'" alt="last_message_read">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <p class="time" style="white-space: nowrap" v-if="contact.time">
                        {{ contact.prevDay ? contact.time : contact.date }}
                    </p>
                    <p class="colMessage" v-if="contact.unread > 0">
                        {{ contact.unread }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ContactsList",
    props: {
        contacts: {
            type: Array,
            default: []
        },
    },
    data() {
        return {
            selected: null
        };
    },
    methods: {
        selectContact(contact) {
            this.selected = contact.id;
            this.$emit('selected', contact);
        },
    },
    created() {
    },
}
</script>

<style>
.info.none-message {
    display: flex;
    align-items: center;
}

.block-messages__message-active {
    background-color: #e6e6e6;
}

.block-messages__message .colMessage {
    color: #6283E5;
    font-weight: bold;
    background: lightgrey;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    line-height: 36px;
}
</style>
