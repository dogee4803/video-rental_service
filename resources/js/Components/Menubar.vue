<script setup>
import { defineProps } from 'vue';
import Menubar from 'primevue/menubar';

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
});
</script>

<template>
    <Menubar :model="items" />
</template>
