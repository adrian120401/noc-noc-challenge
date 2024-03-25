<script>
import draggable from 'vuedraggable'
import { toRef } from 'vue'

export default {
    components: {
        draggable,
    },
    props: {
        tasks: {
        type: Array,
        required: true,
        },
    },
    setup(props) {
        const tasksRef = toRef(props, 'tasks');

        return {
        tasksRef,
        };
    },
};
</script>

<template>
    <draggable v-model="tasksRef" tag="ol">
        <template #item="{element: task}">
            <li>{{ task.title }}</li>
        </template>
    </draggable>
</template>

<style scoped>
</style>