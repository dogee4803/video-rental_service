<script setup>
import Layout from '../Layouts/Layout.vue';

import Button from 'primevue/button';

defineOptions({layout: Layout})
</script>

<template>    
    <Head>
        <meta head-key="description" name="description" content="Home desc">
    </Head>
    <h1>Главная страница</h1>
    <Button label="Submit" />
</template>