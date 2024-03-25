<script>
import List from '@/components/List.vue';
export default {
  components: {
    List
  },
  props: {
      tasks: {
      type: Array,
      required: true
      }
  }
};
  </script>

<template>
  <div class="flex gap-4">
    <div>
      <h3>Pending</h3>
      <ul>
        <!-- <li v-for="task in tasks" :key="task.id">{{ task.title }}</li> -->
        <List :tasks="tasks"/>
      </ul>
    </div>
    <div>
      <h3>In Progress</h3>
      <ul>
        <li v-for="task in tasks" :key="task.id">{{ task.title }}</li>
      </ul>
    </div>
    <div>
      <h3>Blocked</h3>
      <ul>
        <li v-for="task in tasks" :key="task.id">{{ task.title }}</li>
      </ul>
    </div>
    <div>
      <h3>Completed</h3>
      <ul>
        <li v-for="task in tasks" :key="task.id">{{ task.title }}</li>
      </ul>
    </div>
  </div>
</template>
  