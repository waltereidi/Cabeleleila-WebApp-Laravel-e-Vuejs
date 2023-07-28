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
            if (this.debouncedInput) {
                clearTimeout(this.debouncedInput);
            }

            this.debouncedInput = setTimeout(() => {
                    
                if(this.busca == ''){
                    axios.get('/api/clientes/getClientes').then(response => (this.dataSource = response.data));      
                }else{
                    axios.get('/api/clientes/getBuscaClientes?coluna='+this.select+'&busca='+this.busca).then(response => ( this.dataSource = response.data ));
                }
            }, 250);
        },
        paginaAnterior(){
            if(this.inicio > 0 ){
                this.inicio = this.inicio -50 ;
                if(this.inicio < 50 ){
                    this.inicio = 0 ;
                }
                axios.get('/api/clientes/getClientesPaginacao?inicio='+this.inicio).then(response => (this.dataSource = response.data));
            }
        },
        paginaSeguinte(){
            this.inicio = this.inicio+50; 
            axios.get('/api/clientes/getClientesPaginacao?inicio='+this.inicio).then(response => (this.dataSource = response.data));
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
                const requisicao = axios.delete('/api/clientes/deleteClientes/'+id);
                
                for (let i = 0; i < this.dataSource.length; i++) {
                    if (this.dataSource[i].id === id) {
                        this.dataSource.splice(i, 1);
                        break;
                    }
                    }
            }
        },
        modificar(id){
           const inputs = ['id'+id ,'nome'+id ,'email'+id ,'cpf'+id ,'rg'+id ,'telefone'+id ,'telefone2'+id ,'observacao'+id ,'datanascimento'+id  ];
           if(confirm("Deseja realmente alterar este valor?")){
               const data= {
                   id : id , 
                   nome : this.$refs[inputs[1]][0].value , 
                   email : this.$refs[inputs[2]][0].value , 
                   cpf : this.$refs[inputs[3]][0].value , 
                   rg : this.$refs[inputs[4]][0].value , 
                   telefone : this.$refs[inputs[5]][0].value , 
                   telefone2 : this.$refs[inputs[6]][0].value , 
                   observacao : this.$refs[inputs[7]][0].value , 
                   datanascimento : this.$refs[inputs[8]][0].value 
               };
               const request = axios.post('/api/clientes/modificarClientes' , data );
               axios.get('/api/clientes/getClientes').then(response => (this.dataSource = response.data));
           }
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
                <option value="Nome"  selected>Nome</option>
                <option value="Id" >Id</option>
                <option value="Email" >Email</option>
                <option value="Cpf" >Cpf</option>
                <option value="Rg" >RG</option>
                <option value="Telefone" >Telefone</option>
                <option value="Telefone2" >Telefone2</option>
                <option value="Observacoes" >Observações</option>
            </select>
          <input type="text" class="form-control" aria-label="Text input with dropdown button"
          v-model="busca" @input="getBuscas">
          <button class="btn btn-link" @click="paginaSeguinte">&gt</button>
        </div>

<table class="table table-dark " >
    
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
            <td  class="p-3 mb-2 bg-warning text-dark"  :ref="'id'+row.id"  :value="row.id" >{{  row.id }} </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><input :ref="'nome' + row.id " class="form-control" type="text" :value="row.nome" maxlength="60" > </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><input :ref="'email' + row.id " class="form-control" type="email" :value="row.email" maxlength="60"  > </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><input :ref="'cpf' + row.id " class="form-control" type="text" :value="row.cpf" maxlength="15" > </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><input :ref="'rg' + row.id " class="form-control" type="text" :value="row.rg"  maxlength="15"> </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><input :ref="'telefone' + row.id " class="form-control" type="text" :value="row.telefone" maxlength="15"  > </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><input :ref="'telefone2' + row.id " class="form-control" type="text" :value="row.telefone2" maxlength="15" > </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><input :ref="'observacao' + row.id " class="form-control" type="text" :value="row.observacao" maxlength="255" > </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><input :ref="'datanascimento' + row.id " class="form-control" type="date" :value="row.datanascimento" > </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><button :id="'modificar'+ row.id " @click="modificar(row.id)" class="btn btn-secondary" >Modificar</button> </td>
            <td  class="p-3 mb-2 bg-warning text-dark" ><button :id="'editar'+row.id" @click="deletar(row.id)" class="btn btn-danger">Deletar</button> </td>
        </tr>
    </tbody>

    </table> 
</template>

