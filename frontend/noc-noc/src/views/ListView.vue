<script>
import draggable from 'vuedraggable';
import { updateStatus } from '@/config/api';
export default {
  components: {
    draggable,
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

  },
};
  </script>

<template>
  <div class="flex gap-4">
    <div>
      <h3>Pending</h3>
      <ul>
        <draggable v-model="pendingTasks" :group="{ name: 'tasks', put: true }" @change="handleDrop('Pending', $event)" :itemKey="task => task.id">
          <template v-slot:item="{ element: task }">
            <li :key="task.id">{{ task.title }}</li>
          </template>
        </draggable>
      </ul>
    </div>
    <div>
      <h3>In Progress</h3>
      <ul>
        <draggable v-model="inProgressTasks" :group="{ name: 'tasks', put: true }" @change="handleDrop('In Progress', $event)" :itemKey="task => task.id">
          <template v-slot:item="{ element: task }">
            <li :key="task.id">{{ task.title }}</li>
          </template>
        </draggable>
      </ul>
    </div>
    <div>
      <h3>Blocked</h3>
      <ul>
        <draggable v-model="blockedTasks" :group="{ name: 'tasks', put: true }" @change="handleDrop('Blocked', $event)" :itemKey="task => task.id">
          <template v-slot:item="{ element: task }">
            <li :key="task.id">{{ task.title }}</li>
          </template>
        </draggable>
      </ul>
    </div>
    <div>
      <h3>Completed</h3>
      <ul>
        <draggable v-model="completedTasks" :group="{ name: 'tasks', put: true }" @change="handleDrop('Completed', $event)" :itemKey="task => task.id">
          <template v-slot:item="{ element: task }">
            <li :key="task.id">{{ task.title }}</li>
          </template>
        </draggable>
      </ul>
    </div>
  </div>
</template>
  