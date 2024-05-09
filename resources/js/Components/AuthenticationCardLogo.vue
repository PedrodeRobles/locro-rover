<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <img v-if="$page.props.pastelitosEvent" src="../../img/logo-unidad.png" alt="" class="w-36">
    <img v-else src="../../img/rover-logo.png" alt="" class="w-20">
</template>
