<script setup>
import Layout from '../../Layouts/Layout.vue';

// Определяем свойства для компоновки
defineOptions({ layout: Layout });


const props = defineProps(['countries']);
console.log(props.countries);

</script>

<template>
    <Head>
        <meta head-key="description" name="description" content="Ведение списка стран">
    </Head>
    <h1 class="title">Ведение списка стран</h1>
    <ul>
        <li v-for="country in countries" :key="country.id">{{ country.country_name }}</li> <!-- Отображаем название каждой страны -->
    </ul>
</template>

<style>

</style>
