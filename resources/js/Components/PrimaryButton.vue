<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="text-center px-4 py-2 bg-primary border border-transparent rounded-full font-semibold text-xs text-white tracking-widest hover:bg-[#4dd292] active:bg-[#3ca572] active:scale-95 focus:outline-none focus:ring-0 transition ease-in-out duration-300">
        <slot />
    </button>
</template>
