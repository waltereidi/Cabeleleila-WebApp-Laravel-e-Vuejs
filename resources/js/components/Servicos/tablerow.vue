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
                    
                if(this.busca === ''){
                    axios.get('api/servicos/getServicos').then(response => (this.dataSource = response.data));      
                }else{
                    axios.get('api/servicos/getBuscaServicos?coluna='+this.select+'&busca='+this.busca).then(response => ( this.dataSource = response.data ));
                    console.log(this.dataSource);
                }
            }, 250);
        },
        paginaAnterior(){
            if(this.inicio > 0 ){
                this.inicio = this.inicio -50 ;
                if(this.inicio < 50 ){
                    this.inicio = 0 ;
                }
                axios.get('api/servicos/getServicosPaginacao?inicio='+this.inicio).then(response => (this.dataSource = response.data));
            }
        },
        paginaSeguinte(){
            this.inicio = this.inicio+50; 
            axios.get('api/servicos/getServicosPaginacao?inicio='+this.inicio).then(response => (this.dataSource = response.data));
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
                const requisicao = axios.delete('api/servicos/deleteServicos/'+id);
                console.log(requisicao);
                for (let i = 0; i < this.dataSource.length; i++) {
                    if (this.dataSource[i].id === id) {
                        this.dataSource.splice(i, 1);
                        break;
                    }
                    }
            }
        },
        modificar(id){
           const inputs = ['id'+id ,'nome'+id ,'descricao'+id ,'preco'+id ,'tempoestimado'+id  ];
           if(confirm("Deseja realmente alterar este valor?")){
               const data= {
                   id : id , 
                   nome : this.$refs[inputs[1]][0].value , 
                   descricao : this.$refs[inputs[2]][0].value , 
                   preco : this.$refs[inputs[3]][0].value , 
                   tempoestimado : this.$refs[inputs[4]][0].value 
               };
               
               const request = axios.post('api/servicos/modificarServicos' , data );
               
               axios.get('api/servicos/getServicos').then(response => (this.dataSource = response.data));
           }
        }
        
  },
    mounted() {
        axios.get('api/servicos/getServicos').then(response => (this.dataSource = response.data));
        

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
                <option value="Nome" selected>Nome</option>
                <option value="Id" >Id</option>
                <option value="Preco" >Preço</option>
                <option value="Descricao" >Descrição</option>
                <option value="Tempoestimado" >Tempo estimado</option>
                <option value="Ultima alteracao">Última alteração</option>
                <option value="Criado em" >Criado em</option>
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
            <th scope="col">Preco</th>
            <th scope="col">Descricao</th>
            <th scope="col">Tempo Estimado</th>
            <th scope="col">Ultima alteração</th>
            <th scope="col">Criado em</th>
        </tr>
    </thead >

    <tbody  v-for="row in dataSource" >
        <tr :id="'linha'+row.id" @click="editarLinha(row.id)" >
            <td scope="col">{{ row.id }}</td>
            <td scope="col">{{ row.nome }}</td>
            <td scope="col">{{ row.preco }}</td>
            <td scope="col">{{ row.descricao }}</td>
            <td scope="col">{{ row.tempoestimado }}</td>
            <td scope="col">{{ row.criadoem }}</td>
            <td scope="col">{{ row.ultimaalteracao }}</td>
        </tr>
        <tr :id="'editarLinha'+row.id" class="escondido" >
            <td :ref="'id' + row.id " > {{ row.id  }} </td>
            <td><input :ref="'nome' + row.id " class="form-control" type="text" maxlength="60" :value="row.nome"  > </td>
            <td><input :ref="'preco' + row.id " class="form-control"  type="number" step="0.01" :value="row.preco"  > </td>
            <td><input :ref="'descricao' + row.id " class="form-control" type="text" maxlength="255" :value="row.descricao"  > </td>
            <td><input :ref="'tempoestimado' + row.id " class="form-control" type="time" :value="row.tempoestimado"  > </td>
            <td><button :id="'modificar'+ row.id " @click="modificar(row.id)" class="btn btn-warning">Modificar</button> </td>
            <td><button :id="'editar'+row.id" @click="deletar(row.id)" class="btn btn-danger">Deletar</button> </td>
        </tr>
    </tbody>

    </table> 
</template>

