<script>
import axios from 'axios';

export default {
    data(){
        return {
            dataSource : [],
            select : 'Nome' ,
            busca : '' ,
            inicio : 0 
        }
    }, 
    methods: {
        getBuscas() {
        // Cancela o temporizador anterior (se houver)
        if (this.debouncedInput) {
            clearTimeout(this.debouncedInput);
        }

        // Configura um novo temporizador para atrasar a execução em 500ms
        this.debouncedInput = setTimeout(() => {
                
                if(this.busca == ''){
                    axios.get('api/clientes/getClientes').then(response => (this.dataSource = response.data));      
                }else{
                    axios.get('api/clientes/getBuscaClientes?coluna='+this.select+'&busca='+this.busca).then(response => ( this.dataSource = response.data ));
                }
        }, 250);
        },
        paginaAnterior(){
            
            if(this.inicio > 0 ){
                this.inicio = this.inicio -50 ;
                if(this.inicio < 50 ){
                    this.inicio = 0 ;
                }
                axios.get('api/clientes/getClientesPaginacao?inicio='+this.inicio).then(response => (this.dataSource = response.data));
            }
        },
        paginaSeguinte(){
            this.inicio = this.inicio+50; 
            axios.get('api/clientes/getClientesPaginacao?inicio='+this.inicio).then(response => (this.dataSource = response.data));
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
            const requisicao = axios.delete('api/clientes/deleteClientes/'+id);
            
            for (let i = 0; i < this.dataSource.length; i++) {
                    if (this.dataSource[i].id === id) {
                    this.dataSource.splice(i, 1);
                    break;
                    }
                }
            }
        },
        modificar(id){

        }
        
  },
    mounted() {
        axios.get('api/clientes/getClientes').then(response => (this.dataSource = response.data));
        
        
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
              <option selected>Nome</option>
              <option>Id</option>
              <option>Email</option>
              <option>Cpf</option>
              <option>RG</option>
              <option>Telefone</option>
              <option>Telefone2</option>
              <option>Observações</option>
              <option>Data de nascimento</option>
              <option>Criado Em</option>
              <option>Ultima alteração</option>
              
          </select>
          <input type="text" class="form-control" aria-label="Text input with dropdown button"
          v-model="busca" @input="getBuscas">
          <button class="btn btn-link" @click="paginaSeguinte">&gt</button>
        </div>

<table class="table table-dark" >
    
    <thead >
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Nome</th>
        <th scope="col">Email</th>
        <th scope="col">Cpf</th>
        <th scope="col">RG</th>
        <th scope="col">Telefone</th>
        <th scope="col">Telefone 2</th>
        <th scope="col">Observações</th>
        <th scope="col">Data de nascimento</th>
        <th scope="col">Criado Em</th>
        <th scope="col">Ultima alteração</th>
      </tr>
    </thead >

    <tbody  v-for="row in dataSource" >
        <tr :id="'linha'+row.id" @click="editarLinha(row.id)" >
          <td scope="col">{{ row.id }}</td>
          <td scope="col">{{ row.nome }}</td>
          <td scope="col">{{ row.email }}</td>
          <td scope="col">{{ row.cpf }}</td>
          <td scope="col">{{ row.rg }}</td>
          <td scope="col">{{ row.telefone }}</td>
          <td scope="col">{{ row.telefone2 }}</td>
          <td scope="col">{{ row.observacao }}</td>
          <td scope="col">{{ row.datanascimento }} </td>
          <td scope="col">{{ row.created_at }}</td>
          <td scope="col">{{ row.updated_at }} </td>

    </tr>
        <tr :id="'editarLinha'+row.id" class="escondido" >
                <td><input class="form-control" type="text" :value="row.id"  > </td>
                <td><input class="form-control" type="text" :value="row.nome"  > </td>
                <td><input class="form-control" type="text" :value="row.email"  > </td>
                <td><input class="form-control" type="text" :value="row.cpf"  > </td>
                <td><input class="form-control" type="text" :value="row.rg"  > </td>
                <td><input class="form-control" type="text" :value="row.telefone"  > </td>
                <td><input class="form-control" type="text" :value="row.telefone2"  > </td>
                <td><input class="form-control" type="text" :value="row.observacao"  > </td>
                <td><input class="form-control" type="text" :value="row.datanascimento"   > </td>
                <td><button :id="'modificar'+ row.id " @click="modificar(row.id)" class="btn btn-warning">Modificar</button> </td>
                <td><button :id="'editar'+row.id" @click="deletar(row.id)" class="btn btn-danger">Deletar</button> </td>
        </tr>
 

    </tbody>

    </table> 
</template>

