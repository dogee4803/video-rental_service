<script setup>
import Layout from "../../Layouts/Layout.vue";
import TextInput from "../../Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
defineOptions({ layout: Layout });

const form = useForm({
    email: null,
    password: null,
    remember: null,
});

const submit = () => {
    console.log(form);
    form.post("/login", {
        onError: () => form.reset("password"),
    });
};
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

        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <input type="checkbox" v-model="form.remember" id="remember" />
                <label for="remember">Запомнить меня</label>
            </div>

            <p class="text-slate-600 mb-2">
                Зарегистрировать нового пользователя? <a :href="route('register')" class="text-link">Зарегистрировать</a>
            </p>
        </div>
        <button class="primary-btn" :disabled="form.processing">
            Войти
        </button>
    </form>
</template>
