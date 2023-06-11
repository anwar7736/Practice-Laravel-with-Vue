<template>
    <slot name="head"></slot>
    <slot></slot>
    <slot name="foot"></slot>
    <Comp/>
    {{ name }}
</template>
<script setup>
import Comp from '../components/Comp2.vue';
import { inject, defineProps, defineEmits } from 'vue';
let name = inject('name');

</script>
<style>

</style>