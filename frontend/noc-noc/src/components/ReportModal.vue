<script>
import { getReport } from '@/config/api';
import { generatePDF } from '@/config/pdf';

export default {
    data() {
        return {
            startDate: '',
            endDate: ''
        };
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        async generateReport() {

            const formattedStartDate = this.startDate;
            const formattedEndDate = this.endDate;
            const reponse = await getReport(formattedStartDate, formattedEndDate);
            generatePDF(reponse.tasks)
            this.$emit('close');
        }
    }
}
</script>

<template>
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-8 rounded-md w-96">
            <h2 class="text-lg font-bold mb-4">Generate report</h2>
            <div class="mb-4">
                <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="startDate" v-model="startDate"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" id="endDate" v-model="endDate"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="flex justify-end">
                <button @click="closeModal"
                    class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">Cancel</button>
                <button @click="generateReport"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Generate</button>
            </div>
        </div>
    </div>
</template>