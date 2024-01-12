<script setup>
defineProps({
    title: {
        type: String,
    },
});
</script>

<template>
    <h1 class="mb-8 text-3xl font-bold">{{title}}</h1>
</template>
