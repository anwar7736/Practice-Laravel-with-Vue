<template>
  <div class="container">
    <h2>Hello From Contact Component</h2>
        <The-Card  
          class="col-md-4 d-none"
          :title="cards[0].title" 
          :description="cards[0].description"
        />

        <The-Button button="btn btn-info btn-sm m-4">
          Add New Customer
        </The-Button>

        <The-Table
          :headings="['Name', 'Age', 'Gender', 'Action']"
          bgColor="table-dark"
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
  import {reactive, ref} from 'vue';
  name: 'About';
  const cards = ref([
      {title: 'Contact', description: '<u>description</u>'},
      {title: 'Contact2', description: '<strong>description2</strong>'},
      {title: 'Contact3', description: '<pre>description3 adsfffasd</pre>'},
  ]);
  const records = ref([
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Hossain', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
    {name: 'Anwar', age: 26, gender: 'Male'},
  ]);

</script>

<style>

</style>