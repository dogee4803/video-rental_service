<script setup>
import { reactive } from "vue";
import Layout from "../../Layouts/Layout.vue";
import TextInput from "../../Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
defineOptions({ layout: Layout });

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});

const submit = () => {
    console.log(form);
    form.post("/register", {
        onError: () => form.reset("password", "password_confirmation"),
    });
};
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
        <div>
            <p class="text-slate-600 mb-2">
                Есть аккаунт? <a href="#" class="text-link">Войти</a>
            </p>
            <button class="primary-btn" :disabled="form.processing">
                Регистрация
            </button>
        </div>
    </form>
</template>
