<script setup>
import Layout from "../../Layouts/Layout.vue";
import InputText from 'primevue/inputtext';
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import Message from 'primevue/message';

import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

defineOptions({ layout: Layout });

const props = defineProps(["actors"]);

const editingRows = ref([]);

const errors = ref({});


const validateActor = (actor) => {
    const validationErrors = {};
    
    if (!actor.firstname || /^\s*$/.test(actor.firstname)) {
        validationErrors.firstname = 'Имя обязательно и не должно начинаться с пробела.';
    } else if (!/^[a-zA-Zа-яА-ЯёЁ\s]+$/.test(actor.firstname)) {
        validationErrors.firstname = 'Имя может содержать только буквы.';
    }

    if (!actor.lastname || /^\s*$/.test(actor.lastname)) {
        validationErrors.lastname = 'Фамилия обязательна и не должна начинаться с пробела.';
    } else if (!/^[a-zA-Zа-яА-ЯёЁ\s]+$/.test(actor.lastname)) {
        validationErrors.lastname = 'Фамилия может содержать только буквы.';
    }

    return validationErrors;
};


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

const onRowEditSave = (event) => {
    let { newData, index } = event;
    
    const validationErrors = validateActor(newData);
    if (Object.keys(validationErrors).length > 0) {
        errors.value = validationErrors;
        return;
    }

    props.actors[index] = newData;
    console.log("Обновленные данные:", newData);

    Inertia.put(`/actorslist/${newData.id}`, {
        firstname: newData.firstname,
        lastname: newData.lastname,
    }).then(response => {
        if (response.props && response.props.errors) {
            errors.value = response.props.errors;
        } else {
            refreshData();
            errors.value = {};
        }
    console.log("Обновленные данные:", newData);
    });
};

const onRowEditCancel = (event) => {
    console.log("Редактирование отменено:", event.data);
};

const newActor = ref({ firstName: '', lastName: '' });

const addActor = () => {
    const actorData = {
        firstname: newActor.value.firstName,
        lastname: newActor.value.lastName,
    };

    const validationErrors = validateActor(actorData);
    if (Object.keys(validationErrors).length > 0) {
        errors.value = validationErrors;
        return;
    }

    Inertia.post('/actorslist', actorData, {
        onSuccess: (response) => {
            if (response.props && response.props.errors) {
                errors.value = response.props.errors;
            } else {
                newActor.value.firstname = '';
                newActor.value.lastname = '';
                refreshData();
                errors.value = {};
            }
        }
    });
};

const dt = ref();
const exportCSV = () => {
    dt.value.exportCSV();
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
        <div class="add-actor-form">
            <InputText v-model="newActor.firstName" placeholder="Имя актера" />
            <InputText v-model="newActor.lastName" placeholder="Фамилия актёра" />
            <Button label="Добавить актера" @click="addActor" />
        </div>
        
        <!-- Отображение ошибок -->
        <div v-if="Object.keys(errors).length > 0" class="alert alert-danger">
            <Message severity="error" icon="pi pi-exclamation-circle" v-for="(error, index) in errors" :key="index">
                {{ error }}
            </Message>
        </div>

        <DataTable
            ref="dt"
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
        <template #header>
            <div class="text-end pb-4">
                <Button icon="pi pi-external-link" label="Export" @click="exportCSV($event)" />
            </div>
        </template>
            <template #paginatorstart>
                <Button type="button" icon="pi pi-refresh" text @click="refreshData" />
            </template>
            <template #paginatorend>
                <Button type="button" icon="pi pi-download" text @click="downloadActors" />
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
