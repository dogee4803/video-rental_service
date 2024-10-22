<script setup>
import Layout from '../../Layouts/Layout.vue';

// Определяем свойства для компоновки
defineOptions({ layout: Layout });

const props = defineProps(['studios']);

</script>

<template>
    <Head>
        <meta head-key="description" name="description" content="Ведение списка студий">
    </Head>
    <h1 class="title">Ведение списка студий</h1>

    <ul>
        <li v-for="studio in studios" :key="studio.id">{{ studio.studio_name }}</li>
    </ul>

</template>

<style>

</style>
