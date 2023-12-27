<template>
    <section class="mb-6">
        <div class="col-span-4 lg:grid grid-cols-2 gap-x-4 gap-y-2 self-start mb-8">
            <h2 class="font-bold col-span-full mt-7">Seguridad y privacidad</h2>
        </div>
        <UpdatePasswordForm />
        <!-- <LogoutOtherBrowserSessionsForm :sessions="sessions" class="mt-10 sm:mt-0" /> -->
    </section>
</template>
<script>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Back from '@/Components/MyComponents/Back.vue';
import InputLabel from "@/Components/InputLabel.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import InputFilePreview from "@/Components/MyComponents/InputFilePreview.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link } from "@inertiajs/vue3";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
// import LogoutOtherBrowserSessionsForm from "@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue";

export default {
    data() {
        return {
        }
    },
    props: {
        sessions: Array
    },
    components: {
        InputError,
        InputLabel,
        PrimaryButton,
        Back,
        InputFilePreview,
        Link,
        ThirthButton,
        Dropdown,
        DropdownLink,
        UpdatePasswordForm,
        // LogoutOtherBrowserSessionsForm,
    },
    methods: {

    }
}
</script>