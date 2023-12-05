<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="text-center px-4 py-2 bg-primary border border-transparent rounded-full font-semibold text-xs text-white tracking-widest hover:bg-[#4dd292] active:bg-[#3ca572] active:scale-95 disabled:cursor-not-allowed disabled:opacity-50 disabled:active:scale-100 disabled:active:bg-primary disabled:hover:bg-primary focus:outline-none focus:ring-0 transition ease-in-out duration-100">
        <slot />
    </button>
</template>
