<script setup>
import Layout from "../../Layouts/Layout.vue";
import InputText from 'primevue/inputtext';
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";

import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

defineOptions({ layout: Layout });

const props = defineProps(["actors"]);

const editingRows = ref([]);

/// Метод для обновления данных таблицы
const refreshData = async () => {
    try {
        const response = await Inertia.get('/actorslist', {
            preserveState: false,
            preserveScroll: true,
        });
        if (response.props && response.props.actors) {
            console.log("КВА");
            props.actors = response.props.actors;
        };
        console.log("Оответ:", response);
    } catch (error) {
        console.error("Ошибка при обновлении данных:", error, "ответ:", response);
    }
};

// Обработчик сохранения изменений
const onRowEditSave = (event) => {
    let { newData, index } = event;
    props.actors[index] = newData;
    console.log("Обновленные данные:", newData);

    Inertia.put(`/actorslist/${newData.id}`, {
        firstname: newData.firstname,
        lastname: newData.lastname,
    });
    console.log("Обновленные данные:", newData);
};

// Обработчик отмены редактирования
const onRowEditCancel = (event) => {
    console.log("Редактирование отменено:", event.data);
};

const newActor = ref({ firstName: '', lastName: '' });

const addActor = () => {
    const actorData = {
        firstname: newActor.value.firstName,
        lastname: newActor.value.lastName,
    };

    Inertia.put('/actorslist', actorData, {
        onSuccess: () => {
            
            newActor.value.firstName = '';
            newActor.value.lastName = '';
            refreshData(); 
        }
    });
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
        <!-- Форма для добавления актера -->
        <div class="add-actor-form">
            <InputText v-model="newActor.firstName" placeholder="Имя актера" />
            <InputText v-model="newActor.lastName" placeholder="Фамилия актёра" />
            <Button label="Добавить актера" @click="addActor" />
        </div>
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
                <Button type="button" icon="pi pi-refresh" text @click="refreshData" />
            </template>
            <template #paginatorend>
                <Button type="button" icon="pi pi-download" text />
            </template>

            <Column field="id" header="ID" sortable style="width: 25%"></Column>
            <Column
                field="firstname"
                header="Имя актера"
                sortable
                style="width: 25%"
            >
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column
                field="lastname"
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
