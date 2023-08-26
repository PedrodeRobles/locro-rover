<template>
    <div class="fixed w-full">
        <header class="flex items-center justify-between py-2 px-4 md:px-10 bg-red-800 text-white">
            <div class="flex items-center space-x-4 md:space-x-12">
                <img src="../../img/rover-logo.png" alt="Logo" class="w-10">

                <Link :href="route('list')" class="flex items-center bg-gray-800 p-4 md:p-2 rounded-lg cursor-pointer hover:bg-gray-700 space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table" viewBox="0 0 16 16">
                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"/>
                    </svg>
                    <p class="hidden md:block">Lista general</p>
                </Link>

                <Link :href="route('my-list')" class="flex items-center bg-gray-800 p-4 md:p-2 rounded-lg cursor-pointer hover:bg-gray-700 space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z"/>
                    </svg>
                    <p class="hidden md:block">Mi lista</p>
                </Link>

                <Link :href="route('my-list')" class="flex items-center bg-indigo-600 p-4 md:p-2 rounded-lg cursor-pointer hover:bg-indigo-500 space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
                        <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434L7.752.066ZM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567L4.25 7.504ZM7.5 9.933l-2.75 1.571v3.134l2.75-1.571V9.933Zm1 3.134 2.75 1.571v-3.134L8.5 9.933v3.134Zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567-2.742 1.567Zm2.242-2.433V3.504L8.5 5.076V8.21l2.75-1.572ZM7.5 8.21V5.076L4.75 3.504v3.134L7.5 8.21ZM5.258 2.643 8 4.21l2.742-1.567L8 1.076 5.258 2.643ZM15 9.933l-2.75 1.571v3.134L15 13.067V9.933ZM3.75 14.638v-3.134L1 9.933v3.134l2.75 1.571Z"/>
                    </svg>
                    <p class="hidden md:block">Panel de control</p>
                </Link>

            </div>


            <!-- Enlaces para login y registro -->
            <div class="flex items-center space-x-4">
                <div v-if="$page.props.checkAuth">
                    <img src="../../img/boy-scout.png" 
                        alt="Perfil" 
                        class="w-10 cursor-pointer"
                        @click="showOptions = !showOptions"
                    >
                    <UserOptions
                        v-show="showOptions"
                    ></UserOptions>
                </div>
                <div v-else class="space-x-2">
                    <Link :href="route('login')" class="text-white">Log in</Link>
                    <Link :href="route('register')" class="text-white">Register</Link>
                </div>
            </div>
            
        </header>
    </div>
</template>


<script setup>
import UserOptions from './UserOptions.vue';
import { ref } from 'vue';

const showOptions = ref(false);
</script>