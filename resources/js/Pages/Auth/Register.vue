<script setup>
import { reactive } from 'vue';
import Layout from '../../Layouts/Layout.vue';
import { useForm } from '@inertiajs/vue3';
defineOptions({layout: Layout})

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})

const submit = () => {
    console.log(form);
    form.post("/register", {
        onError: () => form.reset("password", "password_confirmation"),
    });
    };
</script>

<template>
    <Head>
        <meta head-key="description" name="description" content="Register desc">
    </Head>
    <h1 class="title">Регистрация нового аккаунта</h1>

    <form @submit.prevent="submit">
        <div class="mb-6">
            <label>Имя</label>
            <input type="text" v-model="form.name" />
            <small>{{ form.errors.name }}</small>
        </div>

        <div class="mb-6">
            <label>Почта</label>
            <input type="text" v-model="form.email" />
            <small>{{ form.errors.email }}</small>
        </div>

        <div class="mb-6">
            <label>Пароль</label>
            <input type="password" v-model="form.password" />
            <small>{{ form.errors.password }}</small>
        </div>

        <div class="mb-6">
            <label>Подтверждение пароля</label>
            <input type="password" v-model="form.password_confirmation" />
            <small>{{ form.errors.password_confirmation }}</small>
        </div>

        <div>
            <p class="text-slate-600 mb-2">Есть аккаунт? <a href="#" class="text-link">Войти</a></p>
            <button class="primary-btn" :disabled="form.processing">Регистрация</button>
        </div>
    </form>
</template>