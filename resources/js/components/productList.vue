<template>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
            <strong>Filter By Category</strong><br>
            <label v-for="(cat) in categories" :key="cat.id" class="filter-section">
              <input type="checkbox" v-model="selected.categories" :value="cat.id"> {{ cat.name }} 
              <sup class="text-danger">
                ({{ cat.products_count }})
            </sup>
            </label>
        </div>      
        <div class="col-md-4">
            <strong>Filter By Size</strong><br>
            <label v-for="size in sizes" :key="size.id" class="filter-section">
              <input type="checkbox" v-model="selected.sizes" :value="size.id"> {{ size.name }} 
              <sup class="text-danger">
                ({{ size.products_count }})
            </sup>
            </label>
        </div>      
        <div class="col-md-4">
            <strong>Filter By Color</strong><br>
            <label v-for="color in colors" :key="color.id" class="filter-section">
              <input type="checkbox" v-model="selected.colors" :value="color.id"> {{ color.name }} 
              <sup class="text-danger">
                ({{ color.products_count }})
            </sup>
            </label>
        </div>
       </div><br>
       {{ selected.categories }}
       {{ selected.sizes }}
       {{ selected.colors }}
       <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Image</th>
              <th>SKU</th>
              <th>Name</th>
              <th>Categories</th>
              <th>Sizes</th>
              <th>Colors</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(product,index) in products" :key="product.id">
              <td>{{ index + 1 }}</td>
              <td><img :src="product.image_url" height="50" width="50"></td>
              <td>{{ product.sku }}</td>
              <td>{{ product.name }}</td>
              <td>
                <span v-for="(cat,index) in product.categories" :key="cat.id">
                  <span v-if="index">,</span>
                  {{ cat.name }}
                </span>
              </td>
              <td>
                <span v-for="(size,index) in product.sizes" :key="size.id">
                  <span v-if="index">,</span>
                  {{ size.name }}
                </span>
              </td>
              <td>
                <span v-for="(color,index) in product.colors" :key="color.id">
                  <span v-if="index">,</span>
                  {{ color.name }}
                </span>
              </td>
              <td>{{ product.price }}</td>
            </tr>
          </tbody>
       </table>
    </div>
  </template>
  
  <script setup>
  import { onMounted, reactive, ref, watch } from 'vue';
  import axios from 'axios';
  const products = ref([]);
  const categories = ref([]);
  const sizes = ref([]);
  const colors = ref([]);
  const selected = reactive({
    categories: [],
    sizes: [],
    colors: [],
  })
  function getProducts()
  {
  
    axios.get('http://127.0.0.1:8000/api/v1/product',{ params: selected})
    .then(res=> products.value = res.data[0])
    .catch(err => console.log(err));
  }
  
  onMounted(()=>{
    getProducts();
    fetch('http://127.0.0.1:8000/api/v1/get_category_size_color_list')
    .then(res=> res.json())
    .then(data => {
      categories.value = data.categories;
      sizes.value = data.sizes;
      colors.value = data.colors;
    });
  });
  
  
  watch(selected, (newVal,oldVal) =>{
    getProducts();
  });
  
  </script>
  
  <style scoped>
    .filter-section{
     margin-left:10px;
    }
  </style>