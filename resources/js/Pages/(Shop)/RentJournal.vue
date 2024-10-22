<script setup>
import Layout from '../../Layouts/Layout.vue';

// Определяем свойства для компоновки
defineOptions({ layout: Layout });

const props = defineProps(['rentjournal']);

</script>

<template>
    <Head>
        <meta head-key="description" name="description" content="Ведение журнала регистрации">
    </Head>
    <h1 class="title">Журнал аренды</h1>

    <ul>
        <li v-for="country in countries" :key="country.id">{{ country.country_name }}</li>
    </ul>

</template>

<style>

</style>
