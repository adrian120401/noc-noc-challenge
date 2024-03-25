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

    const token = localStorage.getItem('token');
    try {
      this.tasks = await getTasks(token);
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
        <ListView :tasks="tasks.user_tasks" />
    </div>
    <div class="">
      <h2>Otras tareas ></h2>
      <ListView :tasks="tasks.colleague_tasks" />
    </div>
  </main>
</template>
