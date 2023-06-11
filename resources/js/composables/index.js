import { ref } from "vue";
export let helpers = ()=>{
    let name = ref('Say Hello!');
    function click(text)
    {
        name.value = text;
    }

    return {name, click};
}

