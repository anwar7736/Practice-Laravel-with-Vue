<template>
  <div class="container">
    <h1>Hello From Home Component</h1>
    <The-Card class="d-none"/>
    <The-Button button="btn btn-success btn-sm m-3">
          Add New Student
    </The-Button>
    <The-Table
      :headings="['Name', 'Age', 'Gender', 'Action']"
      bgColor="table-success"
    >
    <template #t-body>
      <tr 
        v-for="(r,i) in records"
        :key="r"  
      >
        <th>{{ (i + 1) }}</th>
        <td>{{ r.name }}</td>
        <td>{{ r.age }}</td>
        <td>{{ r.gender }}</td>
        <td>
          <button class="btn btn-sm btn-success">Edit</button> | 
          <button class="btn btn-sm btn-danger">Delete</button>
        </td>
     </tr>
    </template>
    <template #t-foot v-if="records.length == 0">
       <tr>
         <td colspan="6">
          <h6 class="text-danger text-center">No records found!</h6>
         </td>
       </tr>
    </template>
    </The-Table>
    
  </div>
</template>

<script setup>
import { ref } from "vue";

  name: 'Home'
  const records = ref([
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
  ]);
</script>

<style>

</style>