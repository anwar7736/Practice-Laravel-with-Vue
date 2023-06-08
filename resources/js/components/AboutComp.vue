<template>
  <div class="container row">
    <h2>Hello From About Component</h2>
        <The-Card  
        class="col-md-4"
        v-for="card in cards" 
        :key="card"
        :title="card.title" 
        :description="card.description"
        @change="$router.push({query: {title: card.title}})"
    />
  </div>
</template>

<script setup>    
  import {reactive, ref} from 'vue';
  name: 'About';
  const cards = ref([
      {title: 'Title', description: '<i>description</i>'},
      {title: 'title2', description: '<strong>description2</strong>'},
      {title: 'title3', description: '<pre>description3 adsfffasd</pre>'},
  ]);

</script>

<style>

</style>