<template>
  <div class="container">
    <ul>
      <li>
        <RouterLink :to="{name: 'Home'}">Home</RouterLink>
      </li>
      <li>
        <RouterLink :to="{name: 'About'}">About</RouterLink>
      </li>
      <li>
        <RouterLink :to="{name: 'Contact'}">Contact</RouterLink>
      </li>
    </ul>
    <button class="btn btn-info" @click="gotoHome">Go to Home</button>
    <RouterView/>
  </div>
</template>

<script setup>
import {useRouter, useRoute} from 'vue-router';
const router = useRouter();
const route = useRoute();
      function gotoHome(){
       router.push({
        name: 'Home',
        query: {
          name: 'Anwar',
          age: 26
        }
       });
      
    }
  
</script>

<style>

</style>