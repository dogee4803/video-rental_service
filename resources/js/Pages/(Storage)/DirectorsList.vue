<script setup>
import Layout from '../../Layouts/Layout.vue';

// Определяем свойства для компоновки
defineOptions({ layout: Layout });

const props = defineProps(['directors']);

</script>

<template>
    <Head>
        <meta head-key="description" name="description" content="Ведение списка режиссёров">
    </Head>
    <h1 class="title">Ведение списка режиссёров</h1>

    <ul>
        <li v-for="director in directors" :key="director.id">{{ director.director_firstname }} {{ director.director_lastname }}</li>
    </ul>

</template>

<style>

</style>
