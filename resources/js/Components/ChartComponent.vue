<script setup>
import { ref, defineProps, onMounted } from "vue";
import Chart from 'primevue/chart';

// Определяем свойства компонента
const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
    options: {
        type: Object,
        default: () => ({}),
    },
    type: {
        type: String,
        default: 'pie',
    }
});

// Реактивные переменные для данных и опций графика
const chartData = ref({});
const chartOptions = ref({});

// Используем onMounted для инициализации данных графика
onMounted(() => {
    chartData.value = props.data; // Используем переданные данные
    chartOptions.value = { ...setChartOptions(), ...props.options }; // Объединяем переданные опции с настройками по умолчанию
});

// Функция для установки опций графика
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--p-text-color');

    return {
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    color: textColor
                }
            }
        }
    };
};
</script>

<template>
    <Chart :type="type" :data="chartData" :options="chartOptions" class="w-full md:w-[30rem]" />
</template>
