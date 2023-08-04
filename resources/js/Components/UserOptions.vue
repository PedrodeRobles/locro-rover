<template>
    <div class="bg-red-700 border border-slate-600 rounded-md text-white fixed mt-1 right-1 animate__animated animate__fadeIn">
        <div class="p-2 w-28">
            <div>
                <!-- <Link :href="route('editProfile', userLoggedId)">
                    Editar perfil
                </Link> -->
                <Link :href="route('dashboard')">
                    Editar perfil
                </Link>
            </div>
            <form @submit.prevent="logout">
                <button class="text-red-400">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</template>

<script>
// import { Link } from '@inertiajs/inertia-vue3';
// import 'animate.css';

export default {
    // props: {
    //     userLoggedName: String,
    //     userLoggedId: Number,
    //     showOptions: Boolean
    // },
    // components: {
    //     Link
    // },
    methods: {
        logout() {
            this.$inertia.post(this.route('logout'), this.form);
        },
    },
}
</script>