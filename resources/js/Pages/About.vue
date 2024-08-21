<script setup>

defineProps({
    smth: String
})
</script>

<template>
    <div>
        <Head>
            
            <meta head-key="description" name="description" content="about desc">
        </Head>
        <h1>
            Something {{smth}}
        </h1>
    </div>
</template>