<script setup>
</script>

<template>
    <Head>
        <title>| {{$page.component}}</title>
        <meta head-key="description" name="description" content="Описание" />
    </Head>
    <div>
        <header class="bg-indigo-500 text-white">
            <nav class="flex items-center justify-between p-4 max-w-screen-lg mx-auto">
                <div class="space-x-6">
                    <Link :href="route('home')">Home</Link>
                    <Link :href="route('about')">About</Link>
                </div>
            </nav>
        </header>

        <main class="p-4">
            <slot /> <!-- Позволяет вставлять содержимое в основной компонент -->
        </main>
    </div>
</template>
