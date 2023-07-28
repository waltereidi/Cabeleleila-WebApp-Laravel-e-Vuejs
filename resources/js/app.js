
import { createApp } from "vue/dist/vue.esm-bundler.js";
import Tablerow from "./components/Clientes/tablerow.vue";
import Clientes from "./components/Clientes/clientes.vue";

import TablerowServicos from "./components/Servicos/tablerow.vue"; 
import Servicos from "./components/Servicos/servicos.vue"; 

import TablerowAgendamentos from "./components/Agendamentos/tablerow.vue" ; 
import Agendamentos from "./components/Agendamentos/agendamentos.vue"; 

import EditarAgendamentos from "./components/Agendamentos/editarAgendamentos.vue";

import Gerenciamentos from "./components/Gerenciamento/gerenciamento.vue";

const appClientes =  createApp();
appClientes.component('vue-clientes' , Clientes ).component('vue-tablerow' , Tablerow );
appClientes.mount("#vueClientes");

const appServicos = createApp(); 
appServicos.component('vue-servicos' , Servicos).component('vue-tablerowservicos' , TablerowServicos);
appServicos.mount("#vueServicos");

const appAgendamentos = createApp() ; 

appAgendamentos.component('vue-agendamentos' , Agendamentos ).component('vue-tablerowagendamentos' , TablerowAgendamentos ); 
appAgendamentos.mount('#vueAgendamentos'); 

const appEditarAgendamentos = createApp(); 

appEditarAgendamentos.component('vue-editaragendamentos' , EditarAgendamentos ) ; 
appEditarAgendamentos.mount('#vueEditarAgendamentos');


const appGerenciamentos = createApp();

appGerenciamentos.component('vue-gerenciamentos' , Gerenciamentos); 
appGerenciamentos.mount('#vueGerenciamentos');