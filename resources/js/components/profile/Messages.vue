<template>
    <div>
        <navbar></navbar>
        <menu-component-customer v-if="user.role === 2" active="1"></menu-component-customer>
        <menu-component-executor v-if="user.role === 3" active="1"></menu-component-executor>
        <main style="background-color: #F9F9F9; min-height: 600px" class="position-relative">
            <div class="container mb-lg-5">
                <div class="row mt-4">
                    <div>
                        <p class="captionMessage">Сообщения
                            <span v-if="unread_messages_count.count_messages > 0" class="colMessage">
                                +{{ unread_messages_count.count_messages }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="history-chats shadow mt-4 mb-4 position-relative">
                            <div class="p-4">
                                <div class="search-wrapper w-100 mb-2">
                                    <input class="input-search searchField search-messages" type="search"
                                           name="search-object" id="search-object-mobile" placeholder="Поиск..."
                                           autocomplete="off" v-model="searchContact">
                                    <img class="icon" src="/icons/search-icon.svg" alt="search-icon">
                                </div>
                            </div>
                            <perfect-scrollbar>
                                <contacts-list :contacts="filtered_contacts" @selected="startConversationWithHandler"/>
                            </perfect-scrollbar>
                        </div>

                    </div>
                    <div class="col-lg-8 col-md-12 d-lg-block d-none h-100">
                        <div class="history-messages shadow mt-4 mb-4 position-relative">
                            <div class="history-messages__block w-100">
                                <div class="p-4 history-messages__chat-header shadow mb-4" v-if="selectedContact">
                                    <div class="justify-content-between">
                                        <div class="d-flex flex-lg-nowrap flex-wrap justify-content-center">
                                            <div class="d-flex w-100">
                                                <div class="history-messages__chat-header-logo position-relative mr-2">
                                                    <img :alt="selectedContact.info.image" class="w-100 h-100"
                                                         style="border-radius: inherit"
                                                         :src="selectedContact.info.image ? `/storage/listings/logos/${selectedContact.id}/${selectedContact.info.image}` : `/images/default/user.png`">
                                                    <div class="online"
                                                         :class="{'online-green': selectedContact.isOnline}"></div>
                                                </div>
                                                <div class="info d-flex">
                                                    <p class="textCompany">{{ selectedContact.info.name }}</p>
                                                    <span class="d-lg-block d-none m-auto"
                                                          v-if="selectedContact.isOnline">
                                                        онлайн
                                                    </span>
                                                </div>
                                            </div>
                                            <button type="button" style="width: 50px !important;"
                                                    @click="deleteMessagesByChatHandler"
                                                    class="history-messages__button-delete w-100 button button-icon
                                                    active btn-delete d-flex justify-content-center h-100">
                                                <img src="/icons/direct/trash.svg">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <perfect-scrollbar style="height: 70vh" ref="feed" id="feed">
                                    <conversation v-if="selectedContact" :contact="selectedContact"
                                                  :messages="messages_grouped"/>
                                    <div v-if="(selectedContact && messages_grouped.length === 0) || !selectedContact"
                                         class="align-items-center d-flex h-100 justify-content-center">
                                        <p class="text-Blue">
                                            {{
                                                selectedContact && messages_grouped.length === 0 ? 'Напишите первое сообщение' : null
                                            }}
                                            {{ !selectedContact ? 'Выберите чат' : null }}
                                        </p>
                                    </div>
                                </perfect-scrollbar>
                                <div v-if="selectedContact"
                                     class="history-messages__chat-input w-100 pl-3 pr-3 pb-3">
                                    <div class="d-flex">
                                        <div class="input-message position-relative w-100 mr-2">
                                            <input class="input-search searchField search-messages h-100 text-start"
                                                   type="text" placeholder="Сообщение..." v-model="newMessage"
                                                   @keydown.enter="addMessageHandler">
                                            <img @click="openUploadImage" src="/icons/messages/upload.svg"
                                                 alt="" v-if="responseImages.length < 1">
                                            <input type="file" ref="file" class="d-none" id="file-upload-input"
                                                   @change="uploadImage" accept="image/jpeg,image/jpg,image/png">
                                        </div>
                                        <button class="button button-blue"
                                                style="border-radius: 10px" @click="addMessageHandler">
                                            <span class="mr-2">Отправить</span>
                                            <img src="/icons/messages/letter.svg" alt=""></button>
                                    </div>
                                    <div class="mt-1">
                                        <span class="text-Blue mr-2 fs-6" v-for="item in imagesMessage">
                                            {{ item.name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <extendedinf></extendedinf>
    </div>
</template>

<script>
import navbar from '../NavBar'
import extendedinf from "../ExtendedFooterInformation";
import MenuComponentExecutor from "./menuComponent";
import MenuComponentCustomer from "./profileCustomer/menuComponent";
import {PerfectScrollbar} from 'vue2-perfect-scrollbar'
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'
import ContactsList from "./messages/ContactsList";
import Conversation from "./messages/Conversation";
import axios from "axios";


export default {
    name: "Messages",
    data() {
        return {
            selectedContact: null, messages: [], newMessage: '', imageSrc: null,
            imagesMessage: [], responseImages: [], searchContact: '', filtered_contacts: [],
            contacts: []
        }
    },
    computed: {
        user: function () {
            return window.user;
        },
        messages_grouped() {
            return this.$store.getters.AllMessagesChat.reduce((acc, n) => {
                (acc[n.date] = acc[n.date] || []).push(n);
                return acc;
            }, {});
        },
        unread_messages_count() {
            return this.$store.getters.messages_unread;
        }
    },
    methods: {
        async loadContacts() {
            try {
                await this.$store.dispatch('fetchContacts');
                this.contacts = this.$store.getters.AllContactsChat.sort((curr, prev) => {
                    if (curr.created_at === null) {
                        return 1;
                    }
                    if (prev.created_at === null) {
                        return -1;
                    }
                    if (curr.created_at === prev.created_at) {
                        return 0;
                    }
                    return curr.created_at > prev.created_at ? -1 : 1;
                });
                this.filtered_contacts = this.contacts;
            } catch (error) {
                console.error('Error loading contacts:', error);
            }
        },
        startConversationWithHandler(contact) {
            this.$store.dispatch('fetchMessagesChat', {id: contact.id}).then(() => {
                this.selectedContact = contact;
                this.$store.dispatch('getStatisticMessages');
                this.scrollToUnreadMessages();
                this.loadContacts();
            });
        },
        async addMessageHandler() {
            if (this.newMessage.replace(' ', '') == '') return;
            try {
                await this.$store.dispatch('sendMessage', {
                    to: this.selectedContact.id,
                    text: this.newMessage,
                    images: this.responseImages.length > 0 ? this.responseImages : null
                });

                this.newMessage = '';
                await this.loadContacts();
                await this.$store.dispatch('fetchMessagesChat', {id: this.selectedContact.id});

                this.responseImages = [];
                this.imagesMessage = [];
            } catch (error) {
                console.error('Error sending message:', error);
            } finally {
                await this.$nextTick();
                this.scrollToUnreadMessages();
            }
        },

        deleteMessagesByChatHandler() {
            this.$store.dispatch('deleteMessagesInChat', {id: this.selectedContact.id}).then(result => {
                this.$store.dispatch('fetchMessagesChat', {id: this.selectedContact.id});
                this.loadContacts();
            });
        },

        openUploadImage() {
            document.getElementById("file-upload-input").click();
        },

        uploadImage() {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const vm = this;
                reader.onload = function (e) {
                    vm.imageSrc = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
                this.inputImage = input.files[0];
                this.imagesMessage.push(this.inputImage);
            }

            let formData = new FormData();
            formData.append('image', this.inputImage);

            axios.post('/api/account/message/image-upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                this.responseImages.push(response.data);
            });
        },
        scrollToUnreadMessages() {
            const feed = this.$refs.feed;
            if (feed) {
                setTimeout(() => {
                    const feed = document.getElementById("feed");

                    if (feed) {
                        const unreadMessages = document.getElementsByClassName("unread-message");
                        if (unreadMessages.length > 0) {
                            setTimeout(() => {
                                const firstUnreadMessage = unreadMessages[0];
                                if (feed) {
                                    feed.scrollTop = firstUnreadMessage.offsetTop;
                                    axios.get(`/api/account/messages/read/${this.selectedContact.id}`).then((res) => {
                                    })
                                }
                            }, 100);
                        } else {
                            setTimeout(() => {
                                if (feed)
                                    feed.scrollTop = feed.scrollHeight;
                            }, 100);
                        }
                    }

                    /* const unreadMessagesHeader = document.createElement("div");
                     unreadMessagesHeader.className = "unread-messages-header";
                     unreadMessagesHeader.textContent = "Непрочитанные сообщения";
                     unreadMessagesHeader.style.position = "relative";
                     unreadMessagesHeader.style.top = "10px";
                     unreadMessagesHeader.style.bottom = "10px";
                     unreadMessagesHeader.style.textAlign = "center";
                     firstUnreadMessage.parentNode.insertBefore(unreadMessagesHeader, firstUnreadMessage);*/
                }, 100);
            }
        }
    },
    mounted() {
        window.addEventListener('load', this.scrollToUnreadMessages);
        this.loadContacts().then(() => {
            let uri = window.location.href.split('#');
            if (uri[1]) {
                setTimeout(() => {
                    const contact = this.contacts.find((item) => item.id == parseInt(uri[1]))
                    this.selectedContact = contact;
                    this.startConversationWithHandler(contact);
                    this.scrollToUnreadMessages();
                });
            } else {
                this.scrollToUnreadMessages();
            }
        });
        this.$store.dispatch("getStatisticMessages");

        Echo.private(`messages.${this.user.id}`).listen('.message-send-event', (e) => {
            if (!this.selectedContact) {
                this.loadContacts();
            }
            if (this.selectedContact) {
                this.$store.dispatch('fetchMessagesChat', {id: this.selectedContact.id}).then(() => {
                    this.loadContacts();
                }).finally(() => {
                    this.$nextTick(() => {
                        this.scrollToUnreadMessages();
                    });
                });
            }
        })
    },
    created() {

    },
    watch: {
        searchContact: {
            handler: function (value) {
                this.filtered_contacts = this.contacts.filter(contact =>
                    contact.info.name.toLowerCase().includes(value.toLowerCase())
                );
            },
            deep: true
        }
    },
    components: {
        Conversation, ContactsList,
        navbar, extendedinf, MenuComponentExecutor, MenuComponentCustomer, PerfectScrollbar,
    },
}
</script>

<style lang="scss">
.captionMessage {
    color: #0B3158;
    font-size: 28px;
    font-weight: bold;
}

.captionMessage .colMessage {
    color: #6283E5;
}

.history-chats {
    background-color: white;
    border-radius: 10px;
}

.history-messages__block {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 70vh;
    background-color: white;
    border-radius: 10px;

    .ps--active-y {
        flex: 1 !important;
        height: 100vh;
    }
}

.search-messages {
    height: 45px;
    border-radius: 5px;
    color: #0B3158;
}

.block-messages {
    max-height: 560px;

    & .block-messages__message {
        height: 108px;
        cursor: pointer;

        &:hover {
            background-color: #e6e6e6;
        }
    }
}

.history-messages__chat-header-logo {
    height: 58px;
    width: 58px;
    min-width: 58px;
    border-radius: 50%;
}

.block-messages__message .online,
.history-messages__chat-header .online {
    width: 19px;
    height: 19px;
    background-color: #DFDFDF;
    border: 3px solid #FFFFFF;
    border-radius: 50%;
    position: absolute;
    bottom: 0;
    right: 0;
}

.history-messages__chat-header .online {
    top: 0;
    right: 0;
}

.history-messages__chat-header .online-green {
    background-color: #79C592;
}


.block-messages__message {
    & .message, & .textCompany {
        // max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    & .time, & .message {
        color: #8598AB;
        font-size: 12px;
    }

    & .textCompany {
        color: #0B3158;
        font-size: 16px;
    }

    & .logo {
        height: 60px;
        width: 60px;
        border-radius: 100%;
    }

    & .online-green {
        background-color: #79C592;
    }
}

.history-messages__chat-header {
    border-radius: 10px 10px 0 0;

    & .info .textCompany {
        font-size: 18px;
        color: #0B3158;
        margin: auto 25px auto 0 !important;
    }

    & .info span {
        font-size: 14px;
        color: #8598AB;
    }
}

.chat__item {
    display: flex;
    align-items: flex-start;
}

.chat__person-avatar {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    min-width: 50px;
}

.chat__messages {
    margin-left: 15px;
}

.chat__message {
    display: flex;
    align-items: center;
    margin-right: 10px;
    color: #0B3158;
    font-size: 18px;
    margin-bottom: 17px;
}

.chat__message-content {
    border-radius: 5px;
    padding: 11px;
    background-color: #F8F8F8;
    display: inline-block;
    margin-left: 5px;
    margin-right: 15px;
}

.chat__message-time {
    color: #8598AB;
    font-size: 13px;
    margin-right: 15px;
}

.chat__message-status {
    height: 15px;
}

.chat__item--responder {
    flex-direction: row-reverse;

    & .chat__message {
        flex-direction: row-reverse;
    }

    & .chat__message-content {
        background-color: #D5EAFF;
        margin-left: 0;
        margin-right: 5px;
    }
}

.input-message img {
    width: fit-content;
    position: absolute;
    right: 5px;
    height: fit-content;
    top: 11px;
}

@media (max-width: 960px) {
    .captionMessage {
        font-size: 22px;
    }

    .history-chats {
        border-radius: 0;
    }

    .history-messages {
        border-radius: 0 !important;
    }

    .block-messages__message {
        height: 96px !important;

        & .textCompany {
            font-size: 15px;
        }

        & .message, & .item {
            font-size: 12px;
        }
    }

    .history-messages__button-delete {
        content: 'Заблокировать';
        color: #E45868;
        text-align: center;
        margin-right: 10px;
    }

    .chat__messages {
        margin-left: 0;
    }

    .chat__message-content {
        font-size: 14px;
        min-height: 35px;
    }

    .chat__message-time, .chat__message {
        margin-right: 0;
    }

    .chat__item--responder .chat__message-info {
        margin-right: 15px;
    }
}
</style>
