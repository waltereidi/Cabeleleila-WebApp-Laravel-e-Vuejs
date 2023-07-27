
import { createApp } from "vue/dist/vue.esm-bundler.js";
import Tablerow from "./components/Clientes/tablerow.vue";
import Clientes from "./components/Clientes/clientes.vue";

import TablerowServicos from "./components/Servicos/tablerow.vue"; 
import Servicos from "./components/Servicos/servicos.vue"; 

const appClientes =  createApp();
appClientes.component('vue-clientes' , Clientes ).component('vue-tablerow' , Tablerow );
appClientes.mount("#vueClientes");

const appServicos = createApp(); 
appServicos.component('vue-servicos' , Servicos).component('vue-tablerowservicos' , TablerowServicos);
appServicos.mount("#vueServicos");

