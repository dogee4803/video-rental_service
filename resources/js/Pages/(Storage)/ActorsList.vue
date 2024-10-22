<script setup>
import Layout from "../../Layouts/Layout.vue";
import InputText from 'primevue/inputtext';
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import Message from 'primevue/message';
import ConfirmPopup from 'primevue/confirmpopup';
import { useConfirm } from "primevue/useconfirm"
import { useToast } from "primevue/usetoast";;

import Toast from 'primevue/toast';


import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

defineOptions({ layout: Layout });

const props = defineProps(["actors"]);

const editingRows = ref([]);

const errors = ref({});

const confirm = useConfirm();
const toast = useToast();

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

// TODO fix refresh
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
        console.log("Ответ:", response);
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

const deleteRow = (row) => {
    confirm.require({
        target: event.currentTarget,
        message: `Вы уверены, что хотите удалить актера ${row.firstname} ${row.lastname}?`,
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Отмена',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Да',
            severity: 'danger',
        },
        accept: () => {
            toast.add({ severity: 'success', summary: 'Принято', detail: 'Запись удалена', life: 3000 });
            Inertia.delete(`/actorslist/${row.id}`)
                .then(response => {
                    if (response.props && response.props.errors) {
                        errors.value = response.props.errors;
                    } else {
                        refreshData();
                        errors.value = {};
                    }
                })
                .catch(error => {
                    console.error("Ошибка при удалении:", error);
                });
        },
        reject: () => {
            toast.add({ severity: 'info', summary: 'Отмена', detail: 'Запись не удалена', life: 3000 });
            console.log("Удаление отменено");
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
            <Toast ref="toast" />
            <Column style="width: 10%; min-width: 8rem">
                <template #body="{ data }">
                    <Button icon="pi pi-trash" severity="secondary" text rounded @click="deleteRow(data)" />
                </template>
            </Column>
            <Column :rowEditor="true" style="width: 10%; min-width: 8rem"></Column>
        </DataTable>
        <ConfirmPopup />
    </div>
    
</template>

<style></style>
