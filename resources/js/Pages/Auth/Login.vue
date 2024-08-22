<script setup>
import { reactive, ref } from "vue";
import Layout from "../../Layouts/Layout.vue";
import TextInput from "../../Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import RadioButton from "../../Components/RadioButton.vue";
defineOptions({ layout: Layout });

const form = useForm({
    email: null,
    password: null,
    role: null,
});

const submit = () => {
    console.log(form);
    form.post("/login", {
        onError: () => form.reset("password"),
    });
};

const roleOptions = [
  { value: 'storage', label: 'Работник склада' },
  { value: 'shop', label: 'Работник видео-проката' },
];
</script>

<template>
    <Head>
        <meta
            head-key="description"
            name="description"
            content="Login desc"
        />
    </Head>
    <h1 class="title">Авторизация</h1>

    <form @submit.prevent="submit">
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

        <RadioButton
            name="Назначение"
            :options="roleOptions"
            v-model="form.role"
            message="Пожалуйста, выберите роль"
        />

        <div>
            <p class="text-slate-600 mb-2">
                Зарегистрировать нового пользователя? <a href="/register" class="text-link">Войти</a>
            </p>
            <button class="primary-btn" :disabled="form.processing">
                Регистрация
            </button>
        </div>
    </form>
</template>
