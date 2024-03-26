<script>
import draggable from 'vuedraggable';
import { updateStatus } from '@/config/api';
import TaskModal from '@/components/TaskModal.vue';
export default {
  components: {
    draggable,
    TaskModal
  },
  props: {
      tasks: {
      type: Array,
      required: true
      }
  },
  data() {
    return {
      tasksCopy: [],
      pendingTasks: [],
      inProgressTasks: [],
      blockedTasks: [],
      completedTasks: [],
      modalOpen: false,
      selectedTask: null,
    };
  },
  watch: {
    tasks: {
      immediate: true,
      handler(newTasks) {
        this.tasksCopy = [...newTasks];
        this.pendingTasks = this.tasksCopy.filter(task => task.status === 'Pending');
        this.inProgressTasks = this.tasksCopy.filter(task => task.status === 'In progress');
        this.blockedTasks = this.tasksCopy.filter(task => task.status === 'Blocked');
        this.completedTasks = this.tasksCopy.filter(task => task.status === 'Completed');
      }
    }
  },
  methods: {
    async handleDrop(column, event) {
      if(event.added) {
        const taskId = event.added.element.id;
        await updateStatus(taskId, column);
        const taskIndex = this.tasksCopy.findIndex(task => task.id === taskId);
        this.tasksCopy[taskIndex].status = column;
        
      }
    },
    openModal(task) {
      this.selectedTask = task;
      this.modalOpen = true;
    },
    closeModal() {
      this.selectedTask = null;
      this.modalOpen = false;
    },
  },
};
  </script>

<template>
  <div class="flex gap-4 overflow-x-auto">
    <div class="w-full border border-gray-700 rounded p-4">
      <h3 class="text-lg font-bold mb-4">Pending</h3>
      <ul class="h-[80%] min-h-40">
        <draggable class="space-y-2 h-full" v-model="pendingTasks" :group="{ name: 'tasks', put: true }" @change="handleDrop('Pending', $event)" :itemKey="task => task.id">
          <template v-slot:item="{ element: task }">
            <li class="border border-gray-600 rounded p-2 cursor-pointer transition duration-300 hover:bg-gray-300" :key="task.id" @click="openModal(task)">{{ task.title }}</li>
          </template>
        </draggable>
      </ul>
    </div>
    <div class="w-full border border-gray-500 rounded p-4">
      <h3 class="text-lg font-bold mb-4">In Progress</h3>
      <ul class="h-[80%] min-h-40">
        <draggable class="space-y-2 h-full" v-model="inProgressTasks" :group="{ name: 'tasks', put: true }" @change="handleDrop('In progress', $event)" :itemKey="task => task.id">
          <template v-slot:item="{ element: task }">
            <li class="border border-gray-600 rounded p-2 cursor-pointer transition duration-300 hover:bg-gray-300" :key="task.id" @click="openModal(task)">{{ task.title }}</li>
          </template>
        </draggable>
      </ul>
    </div>
    <div class="w-full border border-gray-500 rounded p-4">
      <h3 class="text-lg font-bold mb-4">Blocked</h3>
      <ul class="h-[80%] min-h-40">
        <draggable class="space-y-2 h-full" v-model="blockedTasks" :group="{ name: 'tasks', put: true }" @change="handleDrop('Blocked', $event)" :itemKey="task => task.id">
          <template v-slot:item="{ element: task }">
            <li class="border border-gray-600 rounded p-2 cursor-pointer transition duration-300 hover:bg-gray-300" :key="task.id" @click="openModal(task)">{{ task.title }}</li>
          </template>
        </draggable>
      </ul>
    </div>
    <div class="w-full border border-gray-500 rounded p-4">
      <h3 class="text-lg font-bold mb-4">Completed</h3>
      <ul class="h-[80%] min-h-40">
        <draggable class="space-y-2 h-full" v-model="completedTasks" :group="{ name: 'tasks', put: true }" @change="handleDrop('Completed', $event)" :itemKey="task => task.id">
          <template v-slot:item="{ element: task }">
            <li class="border border-gray-600 rounded p-2 cursor-pointer transition duration-300 hover:bg-gray-300" :key="task.id" @click="openModal(task)">{{ task.title }}</li>
          </template>
        </draggable>
      </ul>
    </div>
  </div>

  <task-modal v-if="modalOpen" :task="selectedTask" @close="closeModal" />
</template>
  