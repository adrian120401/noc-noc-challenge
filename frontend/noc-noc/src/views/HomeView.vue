<script>
/* import List from '@/components/List.vue'; */
import { getTasks } from '@/config/api';
import ListView from '@/views/ListView.vue';
import AddTaskModal from '@/components/AddTaskModal.vue';
import ReportModal from '@/components/ReportModal.vue';

/* const user = localStorage.getItem('user'); */
export default {
  components: {
    ListView,
    AddTaskModal,
    ReportModal
  },

  data() {
    return {
      tasks: {
        "user_tasks": [],
        "colleague_tasks": [],
      },
      myTasksOpen: true,
      otherTasksOpen: false,
      modalOpen: false,
      modalOpenReport: false,
      user: null
    };
  },
  watch: {
    '$route'() {
      this.getUserData();
    }
  },
  async created() {
    this.getUserData();
    this.tasks = await getTasks();
  },
  methods: {
    getUserData() {
      const user = localStorage.getItem('user');
      if (!user) {
        this.$router.push('/login');
      }
      else {
        this.user = JSON.parse(user);
      }
    },
    toggleMyTasks() {
      this.myTasksOpen = !this.myTasksOpen;
    },
    toggleOtherTasks() {
      this.otherTasksOpen = !this.otherTasksOpen;
    },
    openModal() {
      this.modalOpen = true;
    },
    closeModal() {
      this.modalOpen = false;
    },
    openModalReport() {
      this.modalOpenReport = true;
    },
    closeModalReport() {
      this.modalOpenReport = false;
    },
    async taskUpdated() {
      this.tasks = await getTasks();
    },
    async taskAdded() {
      this.tasks = await getTasks();
    }
  }
}
</script>

<template>
  <main>
    <header class="text-center">
      <h1 class="text-3xl font-bold text-gray-800 mb-4">Task Managment</h1>
    </header>
    <template v-if="user?.role === 'superadmin'">
      <div class="flex justify-between mb-4">
        <div>
          <button @click="openModal()"
            class="flex items-center justify-between cursor-pointer py-2 px-4 border border-gray-500 bg-gray-300 hover:bg-gray-400">Add
            task +</button>
        </div>
        <div>
          <button @click="openModalReport()"
            class="flex items-center justify-between cursor-pointer py-2 px-4 border border-gray-500 bg-gray-300 hover:bg-gray-400">Generate
            report</button>
        </div>
      </div>
    </template>
    <div>
      <h2 @click="toggleMyTasks"
        class="flex items-center justify-between cursor-pointer py-2 px-4 bg-gray-300 hover:bg-gray-400 mb-4">My tasks
        <template v-if="myTasksOpen">
          <font-awesome-icon icon="chevron-down" class="ml-2" />
        </template>
        <template v-else>
          <font-awesome-icon icon="chevron-right" class="ml-2" />
        </template>
      </h2>
      <template v-if="myTasksOpen">
        <template v-if="tasks.user_tasks.length > 0">
          <ListView :tasks="tasks.user_tasks" @task-updated="taskUpdated" />
        </template>
        <template v-else>
          <p class="text-center text-gray-600 text-lg">You do not have any task assigned.</p>
        </template>
      </template>
    </div>
    <div class="mt-6">
      <h2 @click="toggleOtherTasks"
        class="flex items-center justify-between cursor-pointer py-2 px-4 bg-gray-300 hover:bg-gray-400 mb-4">Other
        tasks
        <template v-if="otherTasksOpen">
          <font-awesome-icon icon="chevron-down" class="ml-2" />
        </template>
        <template v-else>
          <font-awesome-icon icon="chevron-right" class="ml-2" />
        </template>
      </h2>
      <template v-if="otherTasksOpen">
        <ListView :tasks="tasks.colleague_tasks" @task-updated="taskUpdated" />
      </template>
    </div>
  </main>

  <AddTaskModal v-if="modalOpen" @close="closeModal" @task-added="taskAdded" />
  <ReportModal v-if="modalOpenReport" @close="closeModalReport" />
</template>
