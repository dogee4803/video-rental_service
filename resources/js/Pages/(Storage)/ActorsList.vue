<script setup>
import Layout from "../../Layouts/Layout.vue";
import InputText from 'primevue/inputtext';
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";

import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'; // Импортируйте Inertia

// Определяем свойства для компоновки
defineOptions({ layout: Layout });

const props = defineProps(["actors"]);

const editingRows = ref([]); // Массив для хранения редактируемых строк

// Обработчик сохранения изменений
const onRowEditSave = (event) => {
    let { newData, index } = event;
    props.actors[index] = newData;
    console.log("Обновленные данные:", newData); // Выводим обновленные данные для проверки

    Inertia.put(`/actorslist/${newData.id}`, {
        actor_firstname: newData.actor_firstname,
        actor_lastname: newData.actor_lastname,
    });
    console.log("Обновленные данные:", newData); // Выводим обновленные данные для проверки
};

// Обработчик отмены редактирования
const onRowEditCancel = (event) => {
    console.log("Редактирование отменено:", event.data);
};
</script>

<template>
    <Head>
        <meta
            head-key="description"
            name="description"
            content="Ведение списка актёров"
        />
    </Head>
    <h1 class="title">Ведение списка актёров</h1>

    <div class="card">
        <DataTable
            :value="actors"
            paginator
            :rows="5"
            :rowsPerPageOptions="[5, 10, 20, 50]"
            tableStyle="min-width: 50rem"
            paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
            currentPageReportTemplate="{first} to {last} of {totalRecords}"
            removableSort
            v-model:editingRows="editingRows" 
            editMode="row"
            @row-edit-save="onRowEditSave"
            @row-edit-cancel="onRowEditCancel"
        >
            <template #paginatorstart>
                <Button type="button" icon="pi pi-refresh" text />
            </template>
            <template #paginatorend>
                <Button type="button" icon="pi pi-download" text />
            </template>

            <Column field="id" header="ID" sortable style="width: 25%"></Column>
            <Column
                field="actor_firstname"
                header="Имя актера"
                sortable
                style="width: 25%"
            >
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column
                field="actor_lastname"
                header="Фамилия актёра"
                sortable
                style="width: 25%"
            >
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column :rowEditor="true" style="width: 10%; min-width: 8rem"></Column>
        </DataTable>
    </div>
</template>

<style></style>
