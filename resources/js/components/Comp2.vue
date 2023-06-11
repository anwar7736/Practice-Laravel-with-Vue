<template>
    <button :class="btnClass" @click="click('Md Anwar Hossain')">{{ name }}</button>
    {{ clock }}
    <fieldset>
        <legend>
            Contact Info
        </legend>
        <input type="text" v-model="contact.name">{{ contact.name }}
        <input type="number" v-model="contact.age">{{ contact.age }}
        <input type="text" v-model="contact.gender">{{ contact.gender }}
    </fieldset>
    <div class="m-3">
        <button class="btn btn-sm btn-dark" @click="store.decrement">-</button>
        <strong class="mx-2">{{  double }}</strong>
        <button class="btn btn-sm btn-dark" @click="store.increment">+</button>
    </div>
</template>
<script setup>
    import { storeToRefs } from 'pinia';
import {inject, onBeforeUnmount, onMounted, reactive, ref} from 'vue';
    import {helpers} from '../composables';
    import { useCounterStore } from '../stores/counter';
    let btnClass = inject('btnClass');
    let handleClick = inject('handleClick');
    let clock = ref('Current Clock');
    const store = useCounterStore();
    const { count, double} = storeToRefs(store);
    const {name, click} = helpers();
    const contact = reactive({
        name: 'Md Anwar Hossain',
        age: 27,
        gender: 'Male'
    })
    let watch = setInterval(()=>{
        clock.value = new Date().toLocaleTimeString();
    }, 1000);

    onBeforeUnmount(()=>{
        clearInterval(watch);
    });
    onMounted(()=>{
        contact.name = 'AC';
        contact.age = 28;
        contact.gender = 'Other';
    });
</script>
<style>

</style>