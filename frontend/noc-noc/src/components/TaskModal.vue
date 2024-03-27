<script>
import { updateStatus, getComments, createComment, getUsers, updateUser, deleteTask, uploadFile, getFiles, deleteFile } from '@/config/api';
const user = localStorage.getItem('user');
export default {
    props: {
        task: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            comment: '',
            dropdownOpen: false,
            dropdownUserOpen: false,
            selectedStatus: this.task.status,
            selectedUser: this.task.assigned_user,
            states: ['Pending', 'In progress', 'Blocked', 'Completed'],
            comments: [],
            files: [],
            users: [],
            user: JSON.parse(user),
            file: null
        };
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        },
        toggleDropdownUser() {
            this.dropdownUserOpen = !this.dropdownUserOpen;
        },
        async submitComment() {
            const response = await createComment(this.task.id, this.comment);
            if (response.status === 'success') {
                this.comments.unshift(response.comment)
                this.comment = '';
            }
        },
        async selectStatus(status) {
            await updateStatus(this.task.id, status);
            this.selectedStatus = status;
            this.dropdownOpen = false;
            this.$emit('task-updated');
        },
        async selectUser(user) {
            await updateUser(this.task.id, user.id);
            this.selectedUser = user;
            this.dropdownUserOpen = false;
            this.$emit('task-updated');
        },
        async handleGetComments() {
            const response = await getComments(this.task.id);
            this.comments = response.comments
        },
        async handleGetFiles() {
            const response = await getFiles(this.task.id);
            this.files = response.files
        },
        async handleGetUsers() {
            const response = await getUsers();
            this.users = response.users.filter(user => user.id != this.task.assigned_to)
            this.users.push(this.user)
        },
        async handleDeleteTask() {
            await deleteTask(this.task.id);
            this.closeModal()
        },
        formatTimestamp(timestamp) {
            return new Date(timestamp).toLocaleString();
        },
        async handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        async uploadFile() {
            if (!this.file) {
                return;
            }
            let formData = new FormData();
            formData.append('file', this.file);
            const response = await uploadFile(formData, this.task.id);
            if (response.status === 'success') {
                this.files.unshift(response.file)
                this.file = null;
            }
        },
        async handleDeleteFile(id) {
            await deleteFile(id);
            this.files = this.files.filter(file => file.id !== id);
        }
    },
    mounted() {
        this.comments = this.handleGetComments();
        this.users = this.handleGetUsers();
        this.files = this.handleGetFiles();
    },
};
</script>

<template>
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-gray-200 p-8 rounded-md flex">
            <div class="w-1/2 pr-4">
                <h3 class="text-xl font-bold mb-4">{{ task.title }}</h3>
                <div class="border border-gray-400 rounded-md p-3">
                    <p>{{ task.description }}</p>
                </div>
                <div>
                    <input type="text" v-model="comment" class="mt-4 border border-gray-300 rounded-md px-3 py-2 w-full"
                        placeholder="Write a comment...">
                    <button @click="submitComment"
                        class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Send comment</button>
                </div>
                <template v-if="comments.length > 0">
                    <h3 class="text-lg font-semibold mb-1 mt-2">Comments</h3>
                    <div class="overflow-y-auto max-h-52">
                        <ul>
                            <li v-for="comment in comments" :key="comment.id" class="mb-4">
                                <div class="flex items-center mb-2">
                                    <span>{{ comment.user.name }}</span>
                                    <span class="text-gray-500 text-sm ml-2">{{ formatTimestamp(comment.updated_at)
                                        }}</span>
                                </div>
                                <p class="bg-gray-100 p-2 rounded">{{ comment.comment }}</p>
                            </li>
                        </ul>
                    </div>
                </template>
            </div>

            <div class="w-1/2 pl-4">
                <div class="flex mb-4">
                    <span class="mr-2">Status:</span>
                    <template v-if="user.role === 'superadmin' || user.id === task.assigned_to">
                        <div class="relative">
                            <div @click="toggleDropdown"
                                class="cursor-pointer bg-white border border-gray-300 rounded-md px-3">{{ selectedStatus
                                }}
                                <template v-if="dropdownOpen">
                                    <font-awesome-icon icon="chevron-down" class="ml-2" />
                                </template>
                                <template v-else>
                                    <font-awesome-icon icon="chevron-right" class="ml-2" />
                                </template>
                            </div>
                            <transition name="fade">
                                <ul v-if="dropdownOpen"
                                    class="absolute bg-white border border-gray-300 rounded-md mt-1 py-1 w-32 shadow-md z-10">
                                    <li v-for="status in states" :key="status"
                                        class="cursor-pointer px-4 py-2 hover:bg-gray-100"
                                        @click="selectStatus(status)">{{ status }}</li>
                                </ul>
                            </transition>
                        </div>
                    </template>
                    <template v-else>
                        <span class="cursor-pointer bg-white border border-gray-300 rounded-md px-3">{{ selectedStatus
                            }}</span>
                    </template>
                </div>
                <div class="flex mb-4">
                    <span class="mr-2">Assigned to:</span>
                    <template v-if="user.role === 'superadmin'">
                        <div class="relative">
                            <div @click="toggleDropdownUser"
                                class="cursor-pointer bg-white border border-gray-300 rounded-md px-3">{{
                    selectedUser.name }}
                                <template v-if="dropdownUserOpen">
                                    <font-awesome-icon icon="chevron-down" class="ml-2" />
                                </template>
                                <template v-else>
                                    <font-awesome-icon icon="chevron-right" class="ml-2" />
                                </template>
                            </div>
                            <transition name="fade">
                                <ul v-if="dropdownUserOpen"
                                    class="absolute bg-white border border-gray-300 rounded-md mt-1 py-1 w-32 shadow-md z-10">
                                    <li v-for="user in users" :key="user.id"
                                        class="cursor-pointer px-4 py-2 hover:bg-gray-100" @click="selectUser(user)">{{
                    user.name }}</li>
                                </ul>
                            </transition>
                        </div>
                    </template>
                    <template v-else>
                        <span class="cursor-pointer bg-white border border-gray-300 rounded-md px-3">{{
                    selectedUser.name }}></span>
                    </template>
                </div>
                <div>
                    <h3>Upload a file</h3>
                    <input type="file" @change="handleFileUpload">
                    <button @click="uploadFile"
                        class="mt-3 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Upload</button>
                </div>
                <template v-if="files.length > 0">
                    <h3 class="text-lg font-semibold mb-1 mt-2">Files</h3>
                    <div class="overflow-y-auto overflow-x-hidden max-h-52">
                        <ul>
                            <li v-for="file in files" :key="file.id" class="mb-4">
                                <div class="flex items-center mb-3">
                                    <span>{{ file.user.name }}</span>
                                    <span class="text-gray-500 text-sm ml-2">{{ formatTimestamp(file.updated_at)
                                        }}</span>
                                    <template
                                        v-if="user.role === 'superadmin' || user.id === file.user_id || user.id === task.assigned_to">
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-1 rounded-md ml-2"
                                            @click="handleDeleteFile(file.id)"><font-awesome-icon
                                                icon="trash" /></button>
                                    </template>
                                </div>
                                <a :href="file.filepath" target="_blank" :title="file.filename"
                                    class="bg-gray-100 hover:bg-gray-200 p-2 rounded border border-gray-700 truncate">{{
                                    file.filename }}</a>
                            </li>
                        </ul>
                    </div>
                </template>
                <template v-if="user.role === 'superadmin'">
                    <div>
                        <button @click="handleDeleteTask"
                            class="mt-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md"><font-awesome-icon
                                icon="trash" /> Delete task</button>
                    </div>
                </template>
            </div>
            <div>
                <button @click="closeModal" class="text-gray-600 hover:text-gray-800">
                    <font-awesome-icon icon="times" />
                </button>
            </div>
        </div>
    </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.truncate {
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow-x: hidden;
}
</style>