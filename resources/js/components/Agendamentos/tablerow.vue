<script>
import axios from 'axios';

export default {
    props : ['email' , 'tipousuario'], 
    data(){
        return {
            dataSource : [],
            select : 'Nome' ,
            busca : '' ,
            inicio : 0 , 
            dataInicio : null , 
            dataFim : null , 
        }
    }, 
    methods: {
        getBuscas() {
            if (this.debouncedInput) {
                clearTimeout(this.debouncedInput);
            }

            this.debouncedInput = setTimeout(() => {
                    
                if(this.busca === ''){
                    axios.get('/api/agendamentos/getAgendamentos').then(response => (this.dataSource = response.data));      
                }else{
                    axios.get('/api/agendamentos/getBuscaAgendamentos?coluna='+this.select+'&busca='+this.busca).then(response => ( this.dataSource = response.data ));
                    //console.log(this.dataSource);
                }
            }, 250);
        },
        getBuscasIntervalo(){
            
            let dados ={
                inicio : this.dataInicio , 
                fim : this.dataFim 
            };
            console.log(dados);
            axios.post('/api/agendamentos/getBuscaIntervaloAgendamentos' , dados).then(response => (this.dataSource = response.data )); 


        },
        paginaAnterior(){
            if(this.inicio > 0 ){
                this.inicio = this.inicio -50 ;
                if(this.inicio < 50 ){
                    this.inicio = 0 ;
                }
                axios.get('/api/agendamentos/getAgendamentosPaginacao?inicio='+this.inicio).then(response => (this.dataSource = response.data));
            }
        },
        paginaSeguinte(){
            this.inicio = this.inicio+50; 
            axios.get('/api/agendamentos/getAgendamentosPaginacao?inicio='+this.inicio).then(response => (this.dataSource = response.data));
        },
        editarLinha(id){
            const editar = document.getElementById('editarLinha'+id);
            if(editar.className == 'escondido'){
                editar.className='editar';
            }else{
                editar.className='escondido';
            }
        }, 
        deletar(id){
            if(window.confirm('Deseja realmente deletar a linha de id '+id+' ?')){
                const requisicao = axios.delete('/api/agendamentos/deleteAgendamentos/'+id);
                //console.log(requisicao);
                for (let i = 0; i < this.dataSource.length; i++) {
                    if (this.dataSource[i].id === id) {
                        this.dataSource.splice(i, 1);
                        break;
                    }
                    }
            }
        },
        modificar(id){
            window.location.href = '/editarAgendamentos/'+id;
        }
  },
    mounted() {
        axios.get('/api/agendamentos/getAgendamentos').then(response => (this.dataSource = response.data));
        

    },

  }
</script>
<style scoped>
    .editar{
    }
    .escondido{
        display:none; 
    }
</style>

<template>
        <div class="input-group">
            <button class="btn btn-link" @click="paginaAnterior" >&lt</button>&nbsp<button type="button" class="btn btn-light">{{ inicio }} - {{ inicio+50 }}</button>&nbsp
            <select class="custom-select" v-model="select" >
                <option value="Descricao" selected>Descrição</option>
                <option value="Id" >Id</option>
                <option value="Preco" >Preço</option>
                <option value="dataagendamento" >Data do agendamento</option>
                <option value="SituacaoAgendamento" >Situação do agendamento</option>
                <option value="clientes_id" >Nome do cliente</option>
                <option value="Usuarios_id" >Usuário Responsável</option>
            </select>

            <input type="text" class="form-control" aria-label="Text input with dropdown button"
            v-model="busca" @input="getBuscas" v-show="select != 'dataagendamento'">
          
            <label v-show="select == 'dataagendamento'">Datainicio
            <input v-show="select == 'dataagendamento'" type="datetime-local" class="form-control form-control-sm" 
            v-on:change="getBuscasIntervalo" v-model="dataInicio"  ></label>
            
            <label v-show="select == 'dataagendamento'">Data fim
            <input v-show="select == 'dataagendamento'" type="datetime-local" class="form-control form-control-sm" 
            v-model="dataFim" v-on:change="getBuscasIntervalo" ></label>
                        
          <button class="btn btn-link" @click="paginaSeguinte">&gt</button>
        </div>

<table class="table table-dark table-hover" >
    
    <thead >
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Descricao</th>
            <th scope="col">Data agendamento</th>
            <th scope="col">Situação</th>
            <th scope="col">Usuário Responsável</th>
            <th scope="col">Nome do cliente</th>
            <th scope="col">Preço</th>
        </tr>
    </thead >

    <tbody  v-for="row in dataSource" >
        <tr :id="'linha'+row.id" @click="editarLinha(row.id)" >
            <td scope="col">{{ row.id }}</td>
            <td scope="col">{{ row.descricao }}</td>
            <td scope="col">{{ row.dataagendamento }}</td>
            <td scope="col">{{ row.situacao }}</td>
            <td scope="col">{{ row.usuariosnome }}</td>
            <td scope="col">{{ row.clientesnome }}</td>
            <td scope="col">{{ row.preco }}</td>
        </tr>
        <tr :id="'editarLinha'+row.id" class="escondido" >
            <td  class="p-3 mb-2 bg-warning text-dark" :ref="'id' + row.id " > {{ row.id  }} </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ></td>
            <td  class="p-3 mb-2 bg-warning text-dark" ></td>
            <td  class="p-3 mb-2 bg-warning text-dark" ></td>
            <td  class="p-3 mb-2 bg-warning text-dark" ></td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><button :id="'modificar'+ row.id " @click="modificar(row.id)" class="btn btn-secondary" >Modificar</button> </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><button :id="'editar'+row.id" @click="deletar(row.id)" class="btn btn-danger" :disabled="this.tipousuario != 1">Deletar</button> </td>
        </tr>
    </tbody>

    </table> 
</template>

