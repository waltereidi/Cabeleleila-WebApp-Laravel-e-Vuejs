
import { createApp } from "vue/dist/vue.esm-bundler.js";
import Tablerow from "./components/Clientes/tablerow.vue";
import Clientes from "./components/Clientes/clientes.vue";


const appClientes =  createApp();
appClientes.component('vue-clientes' , Clientes ).component('vue-tablerow' , Tablerow );
appClientes.mount("#vueClientes");

