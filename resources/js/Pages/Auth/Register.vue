<script setup>
import Layout from "../../Layouts/Layout.vue";
import TextInput from "../../Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import RadioButton from "../../Components/RadioButton.vue";
defineOptions({ layout: Layout });

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    role: null,
});

const submit = () => {
    console.log(form);
    form.post("/register", {
        onError: () => form.reset("password", "password_confirmation"),
    });
};

const roleOptions = [
  { value: 0, label: 'Работник склада' },
  { value: 1, label: 'Работник видео-проката' },
];
</script>

<template>
    <Head>
        <meta
            head-key="description"
            name="description"
            content="Register desc"
        />
    </Head>
    <h1 class="title">Регистрация нового аккаунта</h1>

    <form @submit.prevent="submit">
        <TextInput name="Имя" v-model="form.name" :message="form.errors.name" />

        <TextInput
            name="Почта"
            type="email"
            v-model="form.email"
            :message="form.errors.email"
        />

        <TextInput
            name="Пароль"
            type="password"
            v-model="form.password"
            :message="form.errors.password"
        />

        <TextInput
            name="Подтверждение пароля"
            type="password"
            v-model="form.password_confirmation"
        />

        <RadioButton
            name="Назначение"
            :options="roleOptions"
            v-model="form.role"
            message="Пожалуйста, выберите роль"
        />

        <div class="flex items-center justify-between mb-2">
            <p class="text-slate-600 mb-2">
                Есть аккаунт? <a :href="route('login')" class="text-link">Войти</a>
            </p>
        </div>

        <button class="primary-btn" :disabled="form.processing">
            Регистрация
        </button>
    </form>
</template>
