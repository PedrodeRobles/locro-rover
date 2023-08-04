<template>
    <div class="fixed w-full">
        <header class=" flex items-center justify-between py-2 px-10 bg-red-800 text-white">
            <!-- Logo -->
            <div>
                <img src="../../img/rover-logo.png" alt="Logo" class="w-10">
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