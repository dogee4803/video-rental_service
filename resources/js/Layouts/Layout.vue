<script setup>
import { ref } from 'vue';
import Menubar from '../Components/Menubar.vue';
//import Menubar from 'primevue/menubar';

const items = [
    {
        label: 'Home',
        icon: 'pi pi-home'
    },
    {
        label: 'Features',
        icon: 'pi pi-star'
    },
    {
        label: 'Contact',
        icon: 'pi pi-envelope'
    }
];

</script>

<template>
    <Head>
        <title>| {{ $page.component }}</title>
        <meta head-key="description" name="description" content="Описание" />
    </Head>
    <div>
        <header>
            <nav>
                <div class="space-x-6">
                    <Link :href="route('home')" class="nav-link">Home</Link>
                </div>
                <div v-if="$page.props.auth.user" class="space-x-6">
                    <Link :href="route('dashboard')" class="nav-link">Профиль</Link>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        type="button"
                        class="nav-link"
                    >Выйти</Link>
                </div>
                <div v-else class="space-x-6">
                    <Link :href="route('login')" class="nav-link">Войти</Link>
                </div>
            </nav>
        </header>
        <Menubar :model="items" />

        <main class="p-4">
            <slot />
            <!-- Позволяет вставлять содержимое в основной компонент -->
        </main>
    </div>
</template>
