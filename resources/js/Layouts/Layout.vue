<script setup>
import Menubar from '../Components/Menubar.vue';

const props = defineProps(['auth']);

const ShopItems = [
    {
        label: 'Журнал',
        icon: 'pi pi-book',
        command: () => { window.location.href = route('rentjournal'); },
    },
    {
        label: 'Диски',
        icon: 'pi pi-circle-fill',
        command: () => { window.location.href = route('renteddiscs'); },
    },
    {
        label: 'Категории фильмов',
        icon: 'pi pi-sitemap',
        command: () => { window.location.href = route('filmscategory'); },
    },
    {
        label: 'Просроченные покупатели',
        icon: 'pi pi-calendar-times',
        command: () => { window.location.href = route('customersduedate'); },
    }
];

const StorageItems = [
    {
        label: 'Актёры',
        icon: 'pi pi-users',
        command: () => { window.location.href = route('actorslist'); },
    },
    {
        label: 'Жанры',
        icon: 'pi pi-sitemap',
        command: () => { window.location.href = route('categorieslist'); },
    },
    {
        label: 'Страны',
        icon: 'pi pi-globe',
        command: () => { window.location.href = route('countrieslist'); },
    },
    {
        label: 'Режиссёры',
        icon: 'pi pi-user',
        command: () => { window.location.href = route('directorslist'); },
    },
    {
        label: 'Диски',
        icon: 'pi pi-circle-fill',
        command: () => { window.location.href = route('discslist'); },
    },
    {
        label: 'Фильмы',
        icon: 'pi pi-ticket',
        command: () => { window.location.href = route('filmslist'); },
    },
    {
        label: 'Студии',
        icon: 'pi pi-camera',
        command: () => { window.location.href = route('studioslist'); },
    },
];

var MenuItems = []
const user = props.auth.user; // Access the user from props

if (user) {
    // Check the user's role and assign MenuItems accordingly
    if (user.role === true) {
        console.log('beep1');
        MenuItems = ShopItems;
    } else if (user.role === false) {
        console.log('beep2');
        MenuItems = StorageItems;
    }
}

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
        <div class="flex justify-between w-full" v-if="props.auth.user">
            <Menubar :model="MenuItems" :auth="$page.props.auth"/>
        </div>

        <div>
            {{ $page.props.auth.user }}
        </div>

        <main class="p-4">
            <slot />
            <!-- Позволяет вставлять содержимое в основной компонент -->
        </main>
    </div>
</template>