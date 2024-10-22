<script setup>
import Layout from '../../Layouts/Layout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';

// Определяем свойства для компоновки
defineOptions({ layout: Layout });

const props = defineProps(['actors']);
</script>

<template>
    <Head>
        <meta head-key="description" name="description" content="Ведение списка актёров">
    </Head>
    <h1 class="title">Ведение списка актёров</h1>

    <div class="card">
        <DataTable :value="actors" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem"
                paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                currentPageReportTemplate="{first} to {last} of {totalRecords}" removableSort>
            <template #paginatorstart>
                <Button type="button" icon="pi pi-refresh" text />
            </template>
            <template #paginatorend>
                <Button type="button" icon="pi pi-download" text />
            </template>

            <Column field="id" header="ID" sortable style="width: 25%"></Column>
            <Column field="actor_firstname" header="Имя актера" sortable style="width: 25%"></Column>
            <Column field="actor_lastname" header="Фамилия актёра" sortable style="width: 25%"></Column>
        </DataTable>
    </div>

</template>

<style>

</style>
