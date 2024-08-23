<script setup>
import Layout from '../Layouts/Layout.vue';
import Button from 'primevue/button';
import ChartComponent from '../Components/ChartComponent.vue';
import { ref } from 'vue';

// Определяем свойства для компоновки
defineOptions({ layout: Layout });

// Реактивные переменные для данных и опций графика
const chartData = ref({
    labels: ['A', 'B', 'C'],
    datasets: [
        {
            data: [540, 325, 702],
            backgroundColor: ['#42A5F5', '#66BB6A', '#FFA726'],
            hoverBackgroundColor: ['#2196F3', '#4CAF50', '#FFB300']
        }
    ]
});

const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
});
</script>

<template>    
    <Head>
        <meta head-key="description" name="description" content="Home desc">
    </Head>
    <h1 class="title">Главная страница</h1>
    <Button label="Submit" />
    <ChartComponent
        :data="chartData" 
        :options="chartOptions" 
        type="pie" 
    />
</template>
