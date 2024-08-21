<script setup>
import { reactive } from 'vue';
import Layout from '../../Layouts/Layout.vue';
defineOptions({layout: Layout})

const form = reactive({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})

const submit = () => {
    console.log(form);
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
        </div>

        <div class="mb-6">
            <label>Почта</label>
            <input type="text" v-model="form.email" />
        </div>

        <div class="mb-6">
            <label>Пароль</label>
            <input type="password" v-model="form.password" />
        </div>

        <div class="mb-6">
            <label>Подтверждение пароля</label>
            <input type="password" v-model="form.password_confirmation" />
        </div>

        <div>
            <p class="text-slate-600 mb-2">Есть аккаунт? <a href="#" class="text-link">Войти</a></p>
            <button class="primary-btn">Регистрация</button>
        </div>
    </form>
</template>