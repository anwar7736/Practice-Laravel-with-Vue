import { defineStore } from 'pinia';
import { computed, ref } from 'vue';

export const useCounter2Store = defineStore('counter2', ()=>{
    let count = ref(0);
    let double = computed(()=> count.value * 2);
    function increment()
    {
        count.value++;
    }    
    
    function decrement()
    {
        count.value--;
    }
    return { count, double, increment, decrement };

});