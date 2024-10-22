<script setup>
import Layout from '../../Layouts/Layout.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

// Определяем свойства для компоновки
defineOptions({ layout: Layout });


const props = defineProps(['countries']);

// Функция для сохранения стран
const saveCountries = () => {
    const formData = {
        countries: props.countries.map(country => ({
            id: country.id,
            name: country.country_name,
        })),
    };

    // Отправка данных на сервер
    Inertia.post('/countrieslist', formData);
};
</script>

<template>
    <Head>
        <meta head-key="description" name="description" content="Ведение списка стран">
    </Head>
    <h1 class="title">Ведение списка стран</h1>

    <InputText id="country" v-model="value" variant="filled" placeholder="Название страны" />

    <Button icon="pi pi-check" rounded aria-label="Filter" @click="saveCountries" />

    <ul>
        <li v-for="country in countries" :key="country.id">{{ country.country_name }}</li>
    </ul>
</template>

<style>

</style>
