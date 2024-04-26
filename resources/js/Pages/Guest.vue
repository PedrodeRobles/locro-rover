<template>
    <div class="flex justify-end">
        <form @submit.prevent="logout" class="mt-4 mr-4">
            <button class="text-white bg-red-500 rounded-md p-2">
                Cerrar sesión
            </button>
        </form>
    </div>
    <div class="flex justify-center items-center mt-10 text-white">
        <div class="flex flex-col items-center">
            <img src="../../img/rover-logo.png" alt="" class="w-60">
            <div class="text-2xl">
                No sos un usuario activo. Si sos un Rover actual pedile al administrador que active tu cuenta
            </div>
            <a href="https://youtu.be/Br24qEZxKf4?si=-yVFwxvVf_tQoyA6" class="hover:text-blue-400">
                - La paciencia es una virtud 🦅-
            </a>
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