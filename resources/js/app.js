require('./bootstrap');
import {createApp} from 'vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import App from './App.vue';
import router from '../js/router/index.js';
import TheCard from './components/reusables/TheCard.vue';
import TheTable from './components/reusables/TheTable.vue';
import TheButton from './components/reusables/TheButton.vue';

const app = createApp(App);
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);
app.component('TheCard', TheCard);
app.component('TheTable', TheTable);
app.component('TheButton', TheButton);
app.use(router);
app.use(pinia);
app.mount('#root');