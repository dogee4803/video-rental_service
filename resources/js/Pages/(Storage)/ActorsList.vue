<script setup>
import Layout from '../../Layouts/Layout.vue';

// Определяем свойства для компоновки
defineOptions({ layout: Layout });

const props = defineProps(['actors']);
</script>

<template>
    <Head>
        <meta head-key="description" name="description" content="Ведение списка актёров">
    </Head>
    <h1 class="title">Ведение списка актёров</h1>

    <ul>
        <li v-for="actor in actors" :key="actor.id">{{ actor.actor_firstname }} {{ actor.actor_lastname }}</li>
    </ul>

</template>

<style>

</style>
