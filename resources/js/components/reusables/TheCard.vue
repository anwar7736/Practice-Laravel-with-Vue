<template>
  <div class="card" style="width: 18rem;">
        <img class="card-img-top" :src="image" alt="No Image Found">
        <div class="card-body">
            <h5 class="card-title" v-html="title"></h5>
            <p class="card-text" v-html="description"></p>
            <button href="#" class="btn btn-dark" @click="$emit('change')">Details</button>
        </div>
    </div>
</template>

<script setup>
    import {defineProps} from 'vue';

    defineProps({
        image: {
            type: String,
            default: 'https://images.pexels.com/photos/708777/pexels-photo-708777.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'
        },        
        title: {
            type: String,
            default: 'Card Title Will be Here...'
        },        
        description: {
            type: String,
            default: 'Card Description Will be Here...'
        },
        
    })
</script>

<style>

</style>