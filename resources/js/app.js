import './bootstrap';
import { createApp } from 'vue';
import PhoneNumbers from './components/PhoneNumbers.vue';

const app = createApp({});

app.component('phone-numbers', PhoneNumbers);

app.mount('#app');
