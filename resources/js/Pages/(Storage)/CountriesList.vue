<script setup>
import Layout from "../../Layouts/Layout.vue";
import InputText from 'primevue/inputtext';
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import Message from 'primevue/message';
import ConfirmPopup from 'primevue/confirmpopup';
import { useConfirm } from "primevue/useconfirm"
import { useToast } from "primevue/usetoast";
import Dialog from 'primevue/dialog';
import Toast from 'primevue/toast';

import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

defineOptions({ layout: Layout });

const props = defineProps(['countries']);

const countries = ref(props.countries);

const editingRows = ref([]);

const errors = ref({});
const errorsAdd = ref({});

const confirm = useConfirm();
const toast = useToast();

const newCountry = ref({ name: '' });
const showDialog = ref(false);

const dt = ref();

const validateCountry = (country) => {
    const validationErrors = {};
    
    if (!country.name || /^\s*$/.test(country.name)) {
        validationErrors.name = 'Название страны обязательно и не должно начинаться с пробела.';
    } else if (!/^[a-zA-Zа-яА-ЯёЁ\s]+$/.test(country.name)) {
        validationErrors.name = 'Название страны может содержать только буквы.';
    }

    return validationErrors;
};

const refreshData = async () => {
    try {
        const response = await fetch('/api/countrieslist');
        
        if (!response.ok) {
            throw new Error(`HTTP error! статус: ${response.status}`);
        }

        const data = await response.json();

        countries.value = data;

    } catch (error) {
        console.error("Ошибка при обновлении данных:", error);
    }
};

const onRowEditSave = (event) => {
    let { newData, index } = event;

    const validationErrors = validateCountry(newData);
    if (Object.keys(validationErrors).length > 0) {
        errors.value = validationErrors;
        return;
    }

    Inertia.put(`/api/countrieslist/${newData.id}`, {
        name: newData.name,
    }).then(response => {
        console.log("response: ", response);
        
        if (response.props && response.props.errors) {
            errors.value = response.props.errors;
        } else {
            errors.value = {};
            refreshData();
        }
    }).catch(error => {
        console.error("Ошибка при обновлении данных:", error);
    });
};

const onRowEditCancel = (event) => {
    console.log("Редактирование отменено:", event.data);
};

const addCountry = () => {
    const countryData = {
        name: newCountry.value.name,
    };

    const validationErrors = validateCountry(countryData);
    if (Object.keys(validationErrors).length > 0) {
        errorsAdd.value = validationErrors;
        return;
    }

    Inertia.post('/api/countrieslist', countryData, {
        onSuccess: (response) => {
            if (response.props && response.props.errors) {
                errors.value = response.props.errors;
            } else {
                newCountry.value.name = '';
                errors.value = {};
                
                refreshData();
            }
        },
        onError: (error) => {
            console.error("Ошибка при добавлении страны:", error);
        }
    });
};

const exportCSV = () => {
    dt.value.exportCSV();
};

const deleteRow = (row) => {
    confirm.require({
        target: event.currentTarget,
        message: `Вы уверены, что хотите удалить страну - ${row.name}?`,
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
            Inertia.delete(`/api/countrieslist/${row.id}`)
                .then(response => {
                    if (response.props && response.props.errors) {
                        errors.value = response.props.errors;
                    } else {
                        errors.value = {};
                        refreshData();
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
        <meta head-key="description" name="description" content="Ведение списка стран">
    </Head>
    <h1 class="title">Ведение списка стран</h1>

    <div class="card">
        
        <!-- Errors printing -->
        <div v-if="Object.keys(errors).length > 0" class="alert alert-danger">
            <Message closable severity="error" icon="pi pi-exclamation-circle" v-for="(error, index) in errors" :key="index">
                {{ error }}
            </Message>
        </div>

        <DataTable
            ref="dt"
            :value="countries"
            paginator
            :rows="10"
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
            <div class="flex justify-between pb-4">
                <Button label="Добавить страну" icon="pi pi-plus" @click="showDialog = true" />
                <Button icon="pi pi-external-link" label="Export" @click="exportCSV($event)" />
            </div>
        </template>
            <template #paginatorstart>
                <Button type="button" icon="pi pi-refresh" text @click="refreshData" />
            </template>

            <Column field="id" header="ID" sortable style="width: 25%"></Column>
            <Column
                field="name"
                header="название страны"
                sortable
                style="width: 25%"
            >
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Toast ref="toast" />
            <Column :rowEditor="true" style="width: 10%; min-width: 8rem"></Column>
            <Column style="width: 10%; min-width: 8rem">
                <template #body="{ data }">
                    <Button icon="pi pi-trash" severity="danger" text rounded @click="deleteRow(data)" />
                </template>
            </Column>
        </DataTable>

        <Dialog header="Добавить страну" v-model:visible="showDialog" :modal="true" :closable='false'>
            <InputText 
                v-model="newCountry.name"
                placeholder="Название страны"
                class="block w-full p-2 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            
            <div class="flex justify-end">
                <Button label="Отмена" icon='pi pi-times' @click.prevent='() => { showDialog = false; errorsAdd = []; }' class='mr-2' />
                <Button label='Добавить' icon='pi pi-check' @click='addCountry' />
            </div>
            <div v-if="Object.keys(errorsAdd).length > 0" class="alert alert-danger">
                <Message closable severity="error" icon="pi pi-exclamation-circle" v-for="(error, index) in errorsAdd" :key="index">
                    {{ error }}
                </Message>
            </div>
        </Dialog>
        <ConfirmPopup />
    </div>
</template>

<style>

</style>
