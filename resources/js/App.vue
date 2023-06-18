<template>
  <div class="container">
    <Header/>
    <Sidebar/>
    <RouterView/>
    <Footer/>
  </div>
</template>

<script>
  import Header from './components/partials/Header';
  import Sidebar from './components/partials/Sidebar';
  import Footer from './components/partials/Footer';
 export default{
  components: {
    Header,
    Sidebar,
    Footer
  }
 }
</script>

<style>


</style>