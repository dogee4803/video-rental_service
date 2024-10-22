<script setup>
import Layout from '../../Layouts/Layout.vue';

// Определяем свойства для компоновки
defineOptions({ layout: Layout });

const props = defineProps(['categories']);
</script>

<template>
    <Head>
        <meta head-key="description" name="description" content="Ведение списка жанров">
    </Head>
    <h1 class="title">Ведение списка жанров</h1>

    <ul>
        <li v-for="category in categories" :key="category.id">{{ category.category_name }}</li>
    </ul>

</template>

<style>

</style>
