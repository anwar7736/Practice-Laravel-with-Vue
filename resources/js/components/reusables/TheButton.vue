<template>
  <button :class="button">
    <slot></slot>
  </button>
</template>

<script>
export default {
    props: ['button']
}
</script>

<style>

</style>