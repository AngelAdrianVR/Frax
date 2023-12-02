<script setup>
defineProps({
    message: String,
});
</script>

<template>
    <div v-show="message">
        <p class="text-xs text-red-600 ml-2">
            {{ message }}*
        </p>
    </div>
</template>
