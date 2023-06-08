require('./bootstrap');
import {createApp} from 'vue';
import App from './App.vue';
import router from '../js/router/index.js';
import TheCard from './components/reusables/TheCard.vue';
import TheTable from './components/reusables/TheTable.vue';
import TheButton from './components/reusables/TheButton.vue';

const app = createApp(App);
app.component('TheCard', TheCard);
app.component('TheTable', TheTable);
app.component('TheButton', TheButton);
app.use(router);
app.mount('#root');