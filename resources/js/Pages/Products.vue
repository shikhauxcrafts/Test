<script setup>
import Welcome from '@/Components/Welcome.vue';
defineProps(['titles'])
</script>

<template>
    <Welcome :titles="titles"></Welcome>
</template>