<script>
/* import List from '@/components/List.vue'; */
import { getTasks } from '@/config/api';
import ListView from '@/views/ListView.vue';

export default {
  components: {
    ListView
  },

  data() {
    return {
      tasks: {
        "user_tasks": [],
        "colleague_tasks": [],
      }
    };
  },
  async created() {
    try {
      this.tasks = await getTasks();
    } catch (error) {
      console.error('Error al obtener las tareas:', error);
    }
  }
}
</script>

<template>
  <main>
    <header class="text-center">
      <h1>Task Managment</h1>
    </header>
    <div class="">
      <h2>Mis tareas ></h2>
      <template v-if="tasks.user_tasks.length > 0">
        <ListView :tasks="tasks.user_tasks" />
      </template>
      <template v-else>
        <p>You do not have any task assigned.</p>
      </template>
    </div>
    <div class="">
      <h2>Otras tareas ></h2>
      <ListView :tasks="tasks.colleague_tasks" />
    </div>
  </main>
</template>
