<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-[#D9D9D9] rounded-full font-semibold text-xs text-[#373737] tracking-widest focus:bg-gray-100 active:bg-gray-100 focus:outline-none focus:ring-2 transition ease-in-out duration-200 disabled:opacity-25 disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
