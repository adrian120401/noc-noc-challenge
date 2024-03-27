<script>
import { getUsers, addTask } from '@/config/api'

const user = localStorage.getItem('user');

export default {
  data() {
    return {
      newTask: {
        title: '',
        description: '',
        assigned_to: '',
        status: '',
      },
      user: JSON.parse(user),
      users: [],
      states: ['Pending', 'In progress', 'Blocked', 'Completed']
    };
  },
  methods: {
    closeModal() {
      this.$emit('close');
    },
    async handleGetUsers() {
      const response = await getUsers();
      this.users = response.users
      this.users.push(this.user)
    },
    async addTask() {
      const response = await addTask(this.newTask);
      if (response.status === 'success') {
        this.$emit('task-added');
        this.$emit('close');
      }
    }
  },
  mounted() {
    this.users = this.handleGetUsers();
  },
};
</script>

<template>
  <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-8 rounded-md w-96">
      <h2 class="text-lg font-bold mb-4">Add Task</h2>
      <div class="mb-4">
        <label class="block mb-2" for="title">Title:</label>
        <input type="text" id="title" v-model="newTask.title"
          class="w-full border border-gray-400 rounded-md px-3 py-2">
      </div>
      <div class="mb-4">
        <label class="block mb-2" for="description">Description:</label>
        <textarea id="description" v-model="newTask.description"
          class="w-full border border-gray-400 rounded-md px-3 py-2"></textarea>
      </div>
      <div class="mb-4">
        <label class="block mb-2" for="assigned_to">Assigned To:</label>
        <select id="assigned_to" v-model="newTask.assigned_to"
          class="w-full border border-gray-400 rounded-md px-3 py-2">
          <option value="" disabled selected>Select a user</option>
          <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block mb-2" for="status">Status:</label>
        <select id="status" v-model="newTask.status" class="w-full border border-gray-400 rounded-md px-3 py-2">
          <option value="" disabled selected>Select a status</option>
          <option v-for="status in states" :key="status">{{ status }}</option>
        </select>
      </div>
      <div class="flex justify-end">
        <button @click="closeModal"
          class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">Cancel</button>
        <button @click="addTask" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add Task</button>
      </div>
    </div>
  </div>
</template>