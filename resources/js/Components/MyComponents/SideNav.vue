<template>
    <!-- sidebar -->
    <div class="h-screen hidden md:block shadow-lg relative">
        <div class="bg-[#313131] h-full overflow-auto">
        <!-- Logo -->
        <div class="shrink-0 flex items-center justify-center mt-4">
            <Link :href="route('dashboard')">
            <ApplicationMark class="block w-16" />
            </Link>
        </div>
            <nav class="px-2 pt-10 text-white">
                <template v-for="(menu, index) in menus" :key="index">
                    <div v-if="menu.show">
                        <Accordion v-if="menu.options.length" :icon="menu.icon" :active="menu.active" :title="menu.label"
                            :id="index">
                            <div v-for="(option, index2) in menu.options" :key="index2">
                                <button @click="goToRoute(option.route)" v-if="option.show" :active="option.active"
                                    :title="option.label"
                                    class="w-full text-start pl-6 pr-2 mb-1 flex justify-between text-xs rounded-md py-1"
                                    :class="option.active ? 'bg-primary text-white' : 'hover:text-primary'">
                                    <p class="w-full truncate"> {{ option.label }}</p>
                                </button>
                            </div>
                        </Accordion>
                        <button v-else @click="goToRoute(menu.route)" v-if="menu.show" :active="menu.active" :title="menu.label"
                            class="w-full text-start px-2 mb-1 flex justify-between text-xs rounded-md py-1"
                            :class="menu.active ? 'bg-primary text-white' : 'hover:text-primary'">
                            <p class="w-full truncate"><span v-html="menu.icon"></span> {{ menu.label }}</p>
                        </button>
                    </div>
                </template>
            </nav>
        </div>
    </div>
</template>

<script>
import Accordion from './Accordion.vue';
import { Link } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';

export default {
    data() {
        return {
            collapsedMenu: null,
            menus: [
                {
                    label: 'Inicio',
                    icon: '<i class="fa-solid fa-house text-xs"></i>',
                    route: route('dashboard'),
                    active: route().current('dashboard'),
                    notifications: false,
                    options: [],
                    dropdown: false,
                    show: true
                },
                {
                    label: 'Gestion de pagos',
                    icon: '<i class="fa-solid fa-dollar-sign"></i>',
                    active: route().current('dashboard*'),
                    options: [
                        {
                            label: 'Pagos',
                            route: route('payments.index'),
                            show: true,
                            active: route().current('payments.*'),
                        },
                        {
                            label: 'Estado de cuenta',
                            route: route('dashboard'),
                            show: true,
                            active: route().current('dashboard.*'),
                        },
                        {
                            label: 'Transacciones',
                            route: route('dashboard'),
                            show: true,
                            active: route().current('dashboard.*'),
                        },
                        {
                            label: 'Historial',
                            route: route('dashboard'),
                            show: true,
                            active: route().current('dashboard.*'),
                        },
                        // { tiene rol como ejemplo
                        //     label: 'Historial',
                        //     route: route('dashboard'),
                        //     show: this.$page.props.auth.user.permissions.includes('Ver clientes') || true, //quitar el true y poner un rol (de ser necesario).
                        //     active: route().current('dashboard.*'),
                        // },
                    ],
                    show: true
                },
            //     {
            //         label: 'Proyectos',
            //         icon: '<i class="fa-solid fa-check mr-1"></i>',
            //         route: route('pms.projects.index'),
            //         active: route().current('pms.*'),
            //         options: [
            //             {
            //                 label: 'Inicio',
            //                 route: route('pms.dashboard'),
            //                 active: route().current('pms.dashboard'),
            //                 show: true,
            //             },
            //             {
            //                 label: 'Proyectos',
            //                 route: route('pms.projects.index'),
            //                 active: route().current('pms.projects.*') || route().current('pms.tasks.*'),
            //                 show: this.$page.props.auth.user.permissions.includes('Ver proyectos'),
            //             },
            //         ],
            //         show: ['Ver proyectos'].some(permission => this.$page.props.auth.user.permissions.includes(permission)),
            //     },
            //     {
            //         label: 'Usuarios',
            //         icon: '<i class="fa-solid fa-user mr-1"></i>',
            //         route: route('users.index'),
            //         active: route().current('users.*'),
            //         options: [],
            //         show: this.$page.props.auth.user.permissions.includes('Ver usuarios')
            //     },
            //     {
            //         label: 'Configuración',
            //         icon: '<i class="fa-solid fa-gear mr-1"></i>',
            //         route: route('settings.index'),
            //         active: route().current('settings.*'),
            //         options: [
            //             {
            //                 label: 'Roles y permisos',
            //                 route: route('settings.role-permission.index'),
            //                 show: this.$page.props.auth.user.permissions.includes('Ver roles y permisos'),
            //                 active: route().current('settings.role-permission.index'),
            //             },
            //         ],
            //         show: ['Ver roles y permisos'].some(permission => this.$page.props.auth.user.permissions.includes(permission)),
            //     },
            ],
        }
    },
    components: {
        ApplicationMark,
        Accordion,
        Link
    },
    methods: {
        handleClickInMenu(index) {
            if (this.menus[index].options.length) {
                if (this.collapsedMenu === index) {
                    this.collapsedMenu = null;
                } else {
                    this.collapsedMenu = index;
                }
            } else {
                this.goToRoute(this.menus[index].route)
            }
        },
        goToRoute(route) {
            this.$inertia.get(route);
        }
    },
    mounted() {
    }
}
</script>