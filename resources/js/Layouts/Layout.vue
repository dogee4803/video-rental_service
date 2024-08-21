<script setup>
</script>

<template>
    <Head>
        <title>| {{$page.component}}</title>
        <meta head-key="description" name="description" content="Описание" />
    </Head>
    <div>
        <header>
            <nav>
                <div class="space-x-6">
                    <Link :href="route('home')" class="nav-link">Home</Link>
                </div>

                <div class="space-x-6">
                    <Link :href="route('register')" class="nav-link">Register</Link>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot /> <!-- Позволяет вставлять содержимое в основной компонент -->
        </main>
    </div>
</template>
