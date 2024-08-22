<script setup></script>

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
                    <Link :href="route('dashboard')" class="nav-link">
                        Профиль
                    </Link>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        type="button"
                        class="nav-link"
                        >Выйти</Link
                    >
                </div>
                <div v-else class="space-x-6">
                    <Link :href="route('login')" class="nav-link">Войти</Link>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot />
            <!-- Позволяет вставлять содержимое в основной компонент -->
        </main>
    </div>
</template>
