<script setup>
import Layout from '../../Layouts/Layout.vue';
import ChartComponent from '../../Components/ChartComponent.vue';
import { ref, onMounted } from 'vue';

// Определяем свойства для компоновки
defineOptions({ layout: Layout });

// Реактивные переменные для данных
const movies = ref([]);
const chartData = ref({
    labels: [],
    datasets: [
        {  
            data: [],
            backgroundColor: [],
            hoverBackgroundColor: []
        }
    ]
});

// Функция для получения данных о фильмах и жанрах
const fetchMoviesAndGenres = async () => {
    try {
        
        movies.value = response.data.movies;

        // Обработка данных для графика
        const genreCounts = {};
        response.data.movies.forEach(movie => {
            movie.genres.forEach(genre => {
                genreCounts[genre] = (genreCounts[genre] || 0) + 1;
            });
        });

        // Подготовка данных для графика
        chartData.value.labels = Object.keys(genreCounts);
        chartData.value.datasets[0].data = Object.values(genreCounts);
        chartData.value.datasets[0].backgroundColor = chartData.value.labels.map((_, index) => {
            // Генерация цвета для каждого жанра
            return `hsl(${(index * 360) / chartData.value.labels.length}, 70%, 50%)`;
        });
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

// Получаем данные при монтировании компонента
onMounted(fetchMoviesAndGenres);

// Опции графика
const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
});
</script>

<template>
    <Head>
        <meta head-key="description" name="description" content="Отчёт: 'Список фильмов по жанрам'">
    </Head>
    <h1 class="title">Список фильмов по жанрам</h1>
    
    <!-- Таблица с фильмами -->
    <p-table :value="movies" class="mb-4">
        <template #header>
            <tr>
                <th>Название фильма</th>
                <th>Жанры</th>
            </tr>
        </template>
        <template #body="{ item }">
            <tr>
                <td>{{ item.title }}</td>
                <td>{{ item.genres.join(', ') }}</td>
            </tr>
        </template>
    </p-table>

    <!-- График с распределением жанров -->
    <ChartComponent 
        :data="chartData" 
        :options="chartOptions" 
        type="pie" 
    />
</template>

<style>
/* Добавьте стили по необходимости */
</style>
