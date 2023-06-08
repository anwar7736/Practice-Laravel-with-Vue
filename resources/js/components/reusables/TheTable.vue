<template>
  <div class="container">
    <table :class="['table table-hover', bgColor]">
        <thead>
            <tr>
            <th>#</th>
            <th scope="col" 
                v-for="h in headings"
                :key="h"
             >
                {{ h }}
            </th>
            </tr>
        </thead>
        <tbody>
            <slot  name="t-body"/>
        </tbody>
        <tfoot>
            <slot name="t-foot"/>
        </tfoot>
        </table>
  </div>
</template>

<script setup>
    import { defineProps } from 'vue';
    defineProps({
        bgColor: {
            type: String,
            default: 'table-secondary'
        },
        headings: {
            type: Object,
            rquired: true,
        },     
        records: {
            type: Object,
            retuired: true,
        }
    })
</script>

<style>

</style>